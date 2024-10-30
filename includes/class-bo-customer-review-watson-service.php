<?php

/**
 * Created by Blue Origami Digital.
 *
 * @since      1.0.0
 * @package    BO_WC_Customer_Reviews_Watson
 * @subpackage BO_WC_Customer_Reviews_Watson/includes
 * @author     Blue Origami Digital - Renaud Hamelin <renaud@b-o-d.fr>
 */
class BO_WC_Customer_Reviews_Watson_Service extends BO_WC_Customer_Reviews_Watson_Options
{
    protected $user_email = null;
    protected $previous_email = null;
    protected $force_cart_post = false;
    protected $cart_was_submitted = false;
    protected $cart = array();


    /**
     * hook fired when a comment is posted. We must check if its a customer product review
     */
    public function commentPosted($comment_id)//$comment_id, $comment_object
    {

        $comment = get_comment($comment_id);
        $post = get_post($comment->comment_post_ID);
        if ($post->post_type == "product") {
            $options = $this->getOptions();
            $tones_options = $options['tones_options'];
            $endpoint = $options['bo_wc_customer_reviews_watson_server_endpoint'];
            $api_key = $options['bo_wc_customer_reviews_watson_api_key'];
            $language = $options['bo_wc_customer_reviews_watson_language'];

            $getToneApi = new BO_WC_Customer_Reviews_Watson_Api($api_key, $endpoint, $language);
            $defaultText = stripslashes($comment->comment_content);
            $results = $getToneApi->getTone($defaultText);
            if (is_array($results)) {
                update_comment_meta($comment_id, "wc_boai_tone_analyze", $results);
                if ($options['bo_wc_customer_reviews_watson_active'] == "on") {
                    $this->processReviewTones($comment_id, $results, $tones_options, $post, $options);
                }
            } else {
            }

        }
    }

    /**
     * send email alerts notificaotin, in case there was element in Tone Analyzer, that where triggered above the tones threshold criterias
     *
     */
    public function sendEmailAlert($comment_id, $tones_needs_alert, $doctones_needs_alert, $product, $options)//$comment_id, $comment_object
    {

        $tones_list = bo_get_tones_list();
        ob_start();
        include(BODAI_PATH . '/emails/generic_email_notification_alert_tpl.php');
        $email_tpl = ob_get_contents();
        ob_end_clean();
        $email_tpl = str_replace("*|PRODUCTNAME|*", $product->post_title, $email_tpl);

        if (count($tones_needs_alert) > 0) {
            $sentences = "<ul>";
            foreach ($tones_needs_alert as $sentence) {
                $color = $tones_list[$sentence["tone_id"]]['color'];
                $sentences .= "<li><strong>Sentence:</strong> '" . $sentence["sentence"] . "'
<br><span style='background-color:" . $color . "; padding: 5px; display: inline-block;'><strong>".__('Tone:','bo-customer-review-watson')."</strong> " . $sentence["tone_name"] . "</span> - <strong>".__('Tone score fiability result:','bo-customer-review-watson')."</strong>  " . $sentence["score"] . "%</li>";
            }
            $sentences .= "</ul>";
        } else {
            $sentences = "<p><strong>".__('NO MULTIPLE SENTENCES ! -> The analyzis will be done on Document level, see lower','bo-customer-review-watson').".</strong></p>";
        }
        if (count($doctones_needs_alert) > 0) {
            $docsalerts = "<ul>";
            $mostfiable = array("score" => 0, "tone_id" => "", "tone_name" => "");
            foreach ($doctones_needs_alert as $tone) {
                $color = $tones_list[$tone["tone_id"]]['color'];
                if ($tone["score"] > $mostfiable["score"]) {
                    $mostfiable = $tone;
                }

                $docsalerts .= "<li><span style='background-color:" . $color . "; padding: 5px; display: inline-block;'><strong>".__('Tone:','bo-customer-review-watson')."</strong> " . $tone["tone_name"] . "</span> - <strong>".__('Tone score fiability result:','bo-customer-review-watson')."</strong>  " . $tone["score"] . "%</li>";

            }
            $docsalerts .= "</ul>";
        } else {
            $docsalerts = "<p><strong>".__('NOTHING DETECTED ON DOCUMENT LEVEL','bo-customer-review-watson').".</strong></p>";
        }
        $comment = get_comment($comment_id);
        $defaultText = stripslashes($comment->comment_content);

        $email_tpl = str_replace("*|SENTENCES|*", $sentences, $email_tpl);
        $email_tpl = str_replace("*|COMMENTTXT|*", $defaultText, $email_tpl);
        $email_tpl = str_replace("*|DOCSALERTS|*", $docsalerts, $email_tpl);
        $email_tpl = str_replace("*|LINKEDITCOMMENT|*", site_url() . "/wp-admin/post.php?post=" . $product->ID . "&action=edit", $email_tpl);
        $email_tpl = str_replace("*|LINKPRODUCTFORM|*", site_url() . "/wp-admin/comment.php?action=editcomment&c=" . $comment_id, $email_tpl);
        $email_tpl = str_replace("*|SITENAME|*", get_bloginfo('name'), $email_tpl);
        $linkproduct = get_permalink($product);
        $email_tpl = str_replace("*|LINKPRODUCT|*", $linkproduct, $email_tpl);
        $email_tpl = str_replace("*|BODAI_PLUGINNAME|*", BODAI_PLUGINNAME, $email_tpl);

        $administrator_emails = $this->get_administrator_email();
        $subject = $options['bo_wc_customer_reviews_watson_email_subject'];
        $headers = array('Content-Type: text/html; charset=UTF-8');
        $headers[] = 'From: ' . $options['bo_wc_customer_reviews_watson_email_fromname'] . ' <' . $options['bo_wc_customer_reviews_watson_email_fromemail'] . '>';

        function bodai_set_html_mail_content_type()
        {
            return 'text/html';
        }

        add_filter('wp_mail_content_type', 'bodai_set_html_mail_content_type');
       $resmail= wp_mail($administrator_emails, $subject, $email_tpl, $headers);
        remove_filter('wp_mail_content_type', 'bodai_set_html_mail_content_type');


    }

    public function get_administrator_email()
    {
        $emails = array();
        $blogusers = get_users('role=Administrator');
        foreach ($blogusers as $user) {
            $emails[] = $user->user_email;
        }
        return $emails;
    }

    /**
     * process the tones analyzis results coming from the Api Watson Tone Analyzer
     */
    public function processReviewTones($comment_id, $results, $tones_options, $product, $options)//$comment_id, $comment_object
    {

        $tones_needs_alert = array();
        $doctones_needs_alert = array();
        foreach ($tones_options as $ktone_id => $tones_option) {
            if (isset($results["sentences_tone"]) && count($results["sentences_tone"]) > 0) {
                foreach ($results["sentences_tone"] as $sentences_tone) {
                    if (count($sentences_tone["tones"]) > 0) {
                        foreach ($sentences_tone["tones"] as $tone) {
                            if ($tone["tone_id"] == $ktone_id) {
                                if (intval($tone["score"] * 100) >= $tones_option) {
                                    $tones_needs_alert[] = array(
                                        "tone_id" => $tone["tone_id"],
                                        "tone_name" => $tone["tone_name"],
                                        "threshold" => $tones_option,
                                        "score" => $tone["score"] * 100,
                                        "sentence" => $sentences_tone["text"],
                                    );
                                }
                            }
                        }
                    }
                }
            }

            if (isset($results["document_tone"])) {
                if (isset($results["document_tone"]["tones"]) && count($results["document_tone"]["tones"]) > 0) {
                    foreach ($results["document_tone"]["tones"] as $tone) {
                        if ($tone["tone_id"] == $ktone_id) {
                            if (intval($tone["score"] * 100) >= $tones_option) {
                                $doctones_needs_alert[] = array(
                                    "tone_id" => $tone["tone_id"],
                                    "tone_name" => $tone["tone_name"],
                                    "threshold" => $tones_option,
                                    "score" => $tone["score"] * 100,
                                    "sentence" => "",
                                );
                            }
                        }
                    }
                }
            }
        }

        if (count($tones_needs_alert) > 0 or count($doctones_needs_alert) > 0) {
            $this->sendEmailAlert($comment_id, $tones_needs_alert, $doctones_needs_alert, $product, $options);
        } else {
        }

    }


    /**
     * hook fired when we know everything is booted
     */
    public
    function wooIsRunning()
    {
        $this->is_admin = current_user_can('administrator');
    }


    /**
     * @param $key
     * @param $default
     * @return mixed
     */
    protected
    function cookie($key, $default = null)
    {
        if ($this->is_admin) {
            return $default;
        }

        return isset($_COOKIE[$key]) ? $_COOKIE[$key] : $default;
    }


    /**
     *
     */
    public
    function get_user_by_hash()
    {
        if ($this->doingAjax() && isset($_GET['hash'])) {
            if (($cart = $this->getCart(sanitize_text_field($_GET['hash'])))) {
                $this->respondJSON(array('success' => true, 'email' => $cart->email));
            }
        }
        $this->respondJSON(array('success' => false, 'email' => false));
    }


    /**
     * @param string $time
     * @return int
     */
    protected
    function getCookieDuration($time = 'thirty_days')
    {
        $durations = array(
            'one_day' => 86400, 'seven_days' => 604800, 'fourteen_days' => 1209600, 'thirty_days' => 2419200,
        );

        if (!array_key_exists($time, $durations)) {
            $time = 'thirty_days';
        }

        return time() + $durations[$time];
    }


    /**
     * @param $data
     */
    protected
    function respondJSON($data)
    {
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

}
