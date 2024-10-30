<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://blue-origami-digital.com/
 * @since      1.0.0
 *
 * @package    BO_WC_Customer_Reviews_Watson
 * @subpackage BO_WC_Customer_Reviews_Watson/includes
 */

/**
 *
 * @since      1.0.0
 * @package    BO_WC_Customer_Reviews_Watson
 * @subpackage BO_WC_Customer_Reviews_Watson/includes
 * @author     Blue Origami Digital - Renaud Hamelin <renaud@b-o-d.fr>
 */
class BO_WC_Customer_Reviews_Watson_Admin extends BO_WC_Customer_Reviews_Watson_Options
{

    /**
     * @return BO_WC_Customer_Reviews_Watson_Admin
     */
    public static function connect()
    {
        $env = bo_customer_review_watson_environment_variables();

        return new self('bo-customer-review-watson', $env->version);
    }

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string $plugin_name The name of this plugin.
     * @param      string $version The version of this plugin.
     */
    public function __construct($plugin_name, $version)
    {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_styles()
    {
        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/bo-customer-review-watson-admin.css', array(), $this->version, 'all');
    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts()
    {
        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/bo-customer-review-watson-admin.js', array('jquery'), $this->version, false);
    }

    /**
     * Register the administration menu for this plugin into the WordPress Dashboard menu.
     *
     * @since    1.0.0
     */
    public function add_plugin_admin_menu()
    {
        add_menu_page(
            BODAI_PLUGINNAME,//,
            BODAI_PLUGINSHORTNAME,
            'manage_options',
            $this->plugin_name,
            array($this, 'display_plugin_setup_page'),
            'dashicons-testimonial'
        );
    }


    /**
     * Add settings action link to the plugins page.
     *
     * @since    1.0.0
     */
    public function add_action_links($links)
    {
        $settings_link = array(
            '<a href="' . admin_url('options-general.php?page=' . $this->plugin_name) . '">' . __('Settings', $this->plugin_name) . '</a>',
        );
        return array_merge($settings_link, $links);
    }

    /**
     * Render the settings page for this plugin.
     *
     * @since    1.0.0
     */
    public function display_plugin_setup_page()
    {
        include_once('partials/bo-customer-review-watson-admin-tabs.php');
    }

    /**
     *
     */
    public function options_update()
    {

        //$this->handle_abandoned_cart_table(); //@TODO:remove

        register_setting($this->plugin_name, $this->plugin_name, array($this, 'validate'));
    }


    /**
     * @param $input
     * @return array
     */
    public function validate($input)
    {


        if (isset($input['bo_customer_review_watson_nonce']) && wp_verify_nonce($input['bo_customer_review_watson_nonce'], 'boai_security_post')) {
            //Have request and request is valid, let go further
        } else {
            //Invalid  nonce
            wp_die("Oops, apparenlty you tried to cheat.. Invalid Security key Nonce.");
        }

        $active_tab = isset($input['bo_customer_review_watson_active_tab']) ? $input['bo_customer_review_watson_active_tab'] : null;


        if (!current_user_can('administrator')) {
            wp_die("Sorry, accessible only for Admin.");
        }

        $active_tab = isset($input['bo_customer_review_watson_active_tab']) ? $input['bo_customer_review_watson_active_tab'] : null;

        if (empty($active_tab)) {
            return $this->getOptions();
        }

        switch ($active_tab) {

            case 'api_key':
                $data = $this->validatePostApiKey($input);
                break;
            case 'emails':
                $data = $this->validatePostEmails($input);
                break;
            case 'tones':
                $data = $this->validatePosTones($input);
                break;
            case 'activate':
                $data = $this->validatePosActivate($input);
                break;


        }

        return (isset($data) && is_array($data)) ? array_merge($this->getOptions(), $data) : $this->getOptions();
    }

    /**
     * STEP E.
     *
     * Handle the 'emails' tab post.
     *
     * @param $input
     * @return array
     */
    protected function validatePosActivate($input)
    {
        $data = array(
            'bo_wc_customer_reviews_watson_active' => isset($input['bo_wc_customer_reviews_watson_active']) ? sanitize_text_field(trim($input['bo_wc_customer_reviews_watson_active'])) : false,

        );

        return $data;
    }

    /**
     * STEP D.
     *
     * Handle the 'emails' tab post.
     *
     * @param $input
     * @return array
     */
    protected function validatePostEmails($input)
    {
        $data = array(
            'bo_wc_customer_reviews_watson_email_subject' => isset($input['bo_wc_customer_reviews_watson_email_subject']) ? sanitize_text_field(trim($input['bo_wc_customer_reviews_watson_email_subject'])) : '',
            'bo_wc_customer_reviews_watson_email_fromname' => isset($input['bo_wc_customer_reviews_watson_email_fromname']) ? sanitize_text_field(trim($input['bo_wc_customer_reviews_watson_email_fromname'])) : '',
            'bo_wc_customer_reviews_watson_email_fromemail' => isset($input['bo_wc_customer_reviews_watson_email_fromemail']) ? sanitize_email(trim($input['bo_wc_customer_reviews_watson_email_fromemail'])) : '',

        );
        $data['email_subject_submitted'] = false;
        if (!$data['bo_wc_customer_reviews_watson_email_subject'] == "") {
            $data['email_subject_submitted'] = true;
        }


        return $data;
    }

    /**
     * STEP C.
     *
     * Handle the 'tones' tab post.
     *
     * @param $input
     * @return array
     */
    protected function validatePosTones($input)
    {
        $tones = array(
            array(
                "tone_id" => "anger",
            ),
            array(
                "tone_id" => "fear",
            ),
            array(
                "tone_id" => "sadness",
            ),
            array(
                "tone_id" => "joy",
            ),
            array(
                "tone_id" => "analytical",
            ),
            array(
                "tone_id" => "confident",
            ),
            array(
                "tone_id" => "tentative",
            ),
        );
        $data = array();
        $tones_options = array();
        foreach ($tones as $tone) {
            $data['bo_wc_customer_reviews_watson_tone_check_' . $tone['tone_id']] = isset($input['bo_wc_customer_reviews_watson_tone_check_' . $tone['tone_id']]) && $input['bo_wc_customer_reviews_watson_tone_check_' . $tone['tone_id']] == "on" ? true : false;
            $data['bo_wc_customer_reviews_watson_tone_treshold_' . $tone['tone_id']] = isset($input['bo_wc_customer_reviews_watson_tone_treshold_' . $tone['tone_id']]) ? intval($input['bo_wc_customer_reviews_watson_tone_treshold_' . $tone['tone_id']]) : 0;
            if ($data['bo_wc_customer_reviews_watson_tone_check_' . $tone['tone_id']]) {
                $tones_options[$tone['tone_id']] = $data['bo_wc_customer_reviews_watson_tone_treshold_' . $tone['tone_id']];
            }

        }
        $data['tones_options'] = $tones_options;
        $data['test_valid_tones'] = true;


        return $data;
    }

    /**
     * STEP A.
     *
     * Handle the 'api_key' tab post.
     *
     * @param $input
     * @return array
     */
    protected function validatePostApiKey($input)
    {
        $data = array(
            //  'bo_wc_customer_reviews_watson_email_subject' => isset($input['bo_wc_customer_reviews_watson_email_subject']) ? trim($input['bo_wc_customer_reviews_watson_email_subject']) : false,
            'bo_wc_customer_reviews_watson_api_key' => isset($input['bo_wc_customer_reviews_watson_api_key']) ? sanitize_text_field(trim($input['bo_wc_customer_reviews_watson_api_key'])) : false,
            'bo_wc_customer_reviews_watson_username' => isset($input['bo_wc_customer_reviews_watson_username']) ? sanitize_text_field(trim($input['bo_wc_customer_reviews_watson_username'])) : false,
            'bo_wc_customer_reviews_watson_password' => isset($input['bo_wc_customer_reviews_watson_password']) ? sanitize_text_field(trim($input['bo_wc_customer_reviews_watson_password'])) : false,
            'bo_wc_customer_reviews_watson_connection_type' => isset($input['bo_wc_customer_reviews_watson_connection_type']) ? sanitize_text_field(trim($input['bo_wc_customer_reviews_watson_connection_type'])) : false,
            'bo_wc_customer_reviews_watson_server_endpoint' => isset($input['bo_wc_customer_reviews_watson_server_endpoint']) ? sanitize_text_field(trim($input['bo_wc_customer_reviews_watson_server_endpoint'])) : false,
            'bo_wc_customer_reviews_watson_language' => isset($input['bo_wc_customer_reviews_watson_language']) ? sanitize_text_field(trim($input['bo_wc_customer_reviews_watson_language'])) : false,

        );
        $data['connection_submitted'] = true;
        $data['connection_info_empty'] = false;
        $data['connection_server_empty'] = false;
        $api_key_empty = true;
        $userpassw_empty = true;
        if (!$data['bo_wc_customer_reviews_watson_api_key'] == "") {
            $api_key_empty = false;
        }
        if (!$data['bo_wc_customer_reviews_watson_username'] == "" && !$data['bo_wc_customer_reviews_watson_password'] == "") {
            $userpassw_empty = false;
        }
        if ($api_key_empty && $userpassw_empty) {
            $data['connection_info_empty'] = true;
        }
        if ($data['bo_wc_customer_reviews_watson_server_endpoint'] == "" or $data['bo_wc_customer_reviews_watson_server_endpoint'] == "-") {
            $data['connection_server_empty'] = true;
        }

        return $data;
    }


    /**
     * @param null $data
     * @param bool $throw_if_not_valid
     * @return array|bool|mixed|null|object
     * @throws Exception
     */
    public function hasValidApiKey($data = null, $throw_if_not_valid = false)
    {
        $bool = false;
        if ($this->validateOptions(array('bo_wc_customer_reviews_watson_api_key'), $data)) {
            $bool = true;
        }
        if ($this->validateOptions(array('bo_wc_customer_reviews_watson_username'), $data) && $this->validateOptions(array('bo_wc_customer_reviews_watson_password'), $data)) {
            $bool = true;
        }

        return $bool;
    }


    /**
     * @param array $required
     * @param null $options
     * @return bool
     */
    private function validateOptions(array $required, $options = null)
    {

        $options = is_array($options) ? $options : $this->getOptions();
        foreach ($required as $requirement) {
            if (!isset($options[$requirement]) || empty($options[$requirement])) {
                return false;
            }
        }

        return true;
    }


}
