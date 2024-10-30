<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
?>
<input type="hidden" name="bo_customer_review_watson_active_settings_tab" value="test"/>
<?php

$showApiAlert = " hidden ";
$showConnectAlert = " hidden ";
$showConnectOK = " hidden ";
$showTestTextOK = " hidden ";
$defaultText = __('Text in english. Please update it if you language is different','bo-customer-review-watson').". Team I know that times are tough. Product sales have been disappointing for the past three quarters. We have a competitive product, but we need to do a better job of selling it.";
$resultConnections = false;
$language = $options['bo_wc_customer_reviews_watson_language'];
if ($language !== "fr" && $language !== "en") {
    $language = "en";
}
$languagearray = array(
    "fr" => "Français",
    "en" => "English",
);
$languagestr = $languagearray[$language];
$results = false;
if (isset($_GET)) {
    if (isset($_GET['test_on'])) {
        $endpoint = $options['bo_wc_customer_reviews_watson_server_endpoint'];
        $api_key = $options['bo_wc_customer_reviews_watson_api_key'];
        if (sanitize_text_field($_GET['test_on']) == "valid") {
            if ($endpoint == "" or $endpoint == "-") {
                $showApiAlert = "";
            } else if ($api_key == "") {
                $showApiAlert = "";
            } else {
                $getToneApi = new BO_WC_Customer_Reviews_Watson_Api($api_key, $endpoint, $language);
                $resultConnections = $getToneApi->getTone($defaultText);
                if (is_array($resultConnections)) {
                    if ($resultConnections["code"] == "401") {
                        $showConnectAlert = " ";
                        $resultConnections = false;
                    } else {
                        $showConnectOK = false;
                    }
                } else {
                    $showConnectAlert = " ";
                    $resultConnections = false;
                }
            }

        }
        if (sanitize_text_field($_GET['test_on']) == "text") {
            if (isset($_POST)) {
                if (isset($_POST["text_content"]) and sanitize_textarea_field($_POST["text_content"]) !== "") {
                    if ($endpoint == "" or $endpoint == "-") {
                        $showApiAlert = "";
                    } else if ($api_key == "") {
                        $showApiAlert = "";
                    } else {
                        $defaultText = stripslashes(sanitize_textarea_field($_POST["text_content"]));
                        $getToneApi = new BO_WC_Customer_Reviews_Watson_Api($api_key, $endpoint, $language);
                        $results = $getToneApi->getTone($defaultText);
                        $showTestTextOK = "";
                        if (is_array($results)) {
                            if ($results["code"] == "401") {
                                $showConnectAlert = " ";
                                $results = false;
                            } else {
                            }
                        } else {
                            $showConnectAlert = " ";
                            $results = false;
                        }
                    }
                }
            }
        }
    }
}
?>
<div class="notice notice-success notice-alt  is-dismissible  <?php echo $showConnectOK; ?>">

    <p><?php _e('STEP','bo-customer-review-watson');?> B- <?php _e('Testing the API Service','bo-customer-review-watson');?>
        <br><strong><?php _e('CONNECTION & AUTHENTIFICATION SUCCESSFULL ! Please now make a test with a real text','bo-customer-review-watson');?>.</strong></p>
    <button type="button" class="notice-dismiss"><span class="screen-reader-text"><?php _e('Dismiss this notice','bo-customer-review-watson');?>.</span>
</div>
<div class="notice notice-success notice-alt  is-dismissible  <?php echo $showTestTextOK; ?>">

    <p><?php _e('STEP','bo-customer-review-watson');?> B- <?php _e('Testing the API Service','bo-customer-review-watson');?>
        <br><strong><?php _e('Success! Please now go to Tab "STEP C- Set Tones" to define your tones alert notifications settings','bo-customer-review-watson');?>.</strong>
        <br><?php _e('Depending on your Tones settings for each tone type selected (when analyzing a customer review), if the fiability of a tone is above the minimum % you have defined, a notification alert email will be sent to the defined users','bo-customer-review-watson');?>.
    </p>
    <button type="button" class="notice-dismiss"><span class="screen-reader-text"><?php _e('Dismiss this notice','bo-customer-review-watson');?>.</span>
</div>
<div data-dismissible="bo-wc-notice-api-error" class="error notice notice-error is-dismissible <?php echo $showApiAlert; ?>">
    <p><?php _e('STEP','bo-customer-review-watson');?> B- <?php _e('Testing the API Service','bo-customer-review-watson');?>
        <br><?php _e('You need to input an Api Key, or a Username + a Password, and select a server','bo-customer-review-watson');?>.</p>
    <button type="button" class="notice-dismiss"><span class="screen-reader-text"><?php _e('Dismiss this notice','bo-customer-review-watson');?>.</span>
    </button>
</div>
<div data-dismissible="bo-wc-notice-api-error" class="error notice notice-error is-dismissible <?php echo $showConnectAlert; ?>">
    <p><?php _e('STEP','bo-customer-review-watson');?> B- <?php _e('Testing the API Service','bo-customer-review-watson');?>
        <br><?php _e('Your Api Key or Username/password is wrong, result: Unauthorized. Please check your connection information','bo-customer-review-watson');?>.
        <br><?php _e('Maybe you tried to use an ApiKey when you account needs a username /password, or reverse. Refer to the Help tab','bo-customer-review-watson');?>.
    </p>
    <button type="button" class="notice-dismiss"><span class="screen-reader-text"><?php _e('Dismiss this notice','bo-customer-review-watson');?>.</span>
    </button>
</div>

<?php if ($active_tab == 'test' && $has_valid_api_key): ?>
    <style>

    </style>
    <div class="test_area">
        <h2><?php _e('STEP','bo-customer-review-watson');?> B- <?php _e('Testing the API Service','bo-customer-review-watson');?></h2>
        <form method="post" action="admin.php?page=bo-customer-review-watson&tab=test"></form>
        <form method="post" action="admin.php?page=bo-customer-review-watson&tab=test&test_on=valid">
            <h4>1/ <?php _e('Testing the API Key','bo-customer-review-watson');?></h4>
            <input type="submit" name="test_on_api_valid" class="button button-primary" value="Test if the Api Key is valid"/>
            <p><?php _e('We will try to connect to your account at IBM Watson Cloud, It could take some time, please be patient (be sure you created one yet, see help if needed)','bo-customer-review-watson');?>...</p>
        </form>

        <form method="post" action="admin.php?page=bo-customer-review-watson&tab=test&test_on=text">
            <h4>2/ <?php _e('Testing a text with the IBM Watson Tone Analyzer API','bo-customer-review-watson');?></h4>
            <p><?php _e('Please test first your API Key / Username + password, and account, and if ok, then you can proceed here','bo-customer-review-watson');?>.</p>
            <div class="test_text_zone">
                <div>
                    <h5><?php _e('INPUT A TEXT','bo-customer-review-watson');?>:</h5>
                    <p><strong><?php _e('Language defined in setting tab','bo-customer-review-watson');?>: <?php echo $languagestr ?></strong></p>
                    <p><label><?php _e("Please input a text, to test and see the Tone Analyzer's results",'bo-customer-review-watson');?></label></p>
                    <p><?php _e('NOTE: a default text is in the text input, please put the one you want','bo-customer-review-watson');?>.</p>

                    <textarea name="text_content" style="height: 200px"><?php echo $defaultText; ?></textarea>

                    <p><input type="submit" name="test_on_text" class="button button-primary" value="<?php _e('Test your text','bo-customer-review-watson');?>"/>
                    </p>
                    <p><?php _e('We will connect to the Tone Analyzer Service at IBM Watson Cloud, It could take some time, please be patient','bo-customer-review-watson');?>...</p>

                </div>
                <div>
                    <h4><?php _e('RESULTS:','bo-customer-review-watson');?></h4>
                    <p><?php _e('NOTE: Depending if your text has one sentence or more, then the results are differents:','bo-customer-review-watson');?>
                        <br><?php _e('In case of 1 sentence, see "DOCUMENT TONES",','bo-customer-review-watson');?>.
                        <br><?php _e('In case of multiple sentences, see "TONES BY SENTENCES".','bo-customer-review-watson');?>.
                    </p>
                    <?php
                    if ($results !== false) {

                        $tones_list = bo_get_tones_list();
                        ?> <h4><?php _e('TONES BY SENTENCES:','bo-customer-review-watson');?></h4>
                        <ul class="boai_analyzis_results">
                            <?php
                            if (isset($results["sentences_tone"]) && count($results["sentences_tone"]) > 0) {
                                foreach ($results["sentences_tone"] as $sentences_tone) {
                                    ?>
                                    <li><p>
                                            <strong>Text: </strong><?php echo stripslashes($sentences_tone["text"]) ?>
                                        </p>
                                        <ul style="">
                                            <?php
                                            if (count($sentences_tone["tones"]) > 0) {
                                                foreach ($sentences_tone["tones"] as $tone) {
                                                    $color = $tones_list[$tone["tone_id"]]['color'];
                                                    ?>
                                                    <li>
                                                        <span style="background: <?php echo $color; ?>; padding: 5px; display: inline-block"><strong><?php _e('Tone:','bo-customer-review-watson');?></strong> <?php echo $tone["tone_name"] ?></span> -
                                                        <strong><?php _e('Fiability:','bo-customer-review-watson');?></strong> <?php echo($tone["score"] * 100) ?>%
                                                    </li>
                                                    <?php
                                                }
                                            } else { ?>
                                                <li>
                                                    <strong><?php _e('No specific tone detected > 50% of fiability','bo-customer-review-watson');?>.</strong>
                                                </li>
                                                <?php
                                            } ?>
                                        </ul>
                                    </li>
                                    <?php
                                }
                            } else {
                                ?>
                                <p><strong><?php _e('NO MULTIPLE SENTENCES ! -> The analyzis will be done on Document level, see lower','bo-customer-review-watson');?>.</strong></p>
                                <?php
                            }
                            ?>
                        </ul>



                        <h4><?php _e('DOCUMENT TONES:','bo-customer-review-watson');?></h4>
                        <h5><?php _e('All Tones:','bo-customer-review-watson');?></h5>
                        <ul>
                            <?php
                            $mostfiable = array("score" => 0, "tone_id" => "", "tone_name" => "");
                            if (count($results["document_tone"]["tones"]) > 0) {
                                foreach ($results["document_tone"]["tones"] as $tone) {
                                    $color = $tones_list[$tone["tone_id"]]['color'];
                                    if ($tone["score"] > $mostfiable["score"]) {
                                        $mostfiable = $tone;
                                    }
                                    ?>
                                    <li><span style="background: <?php echo $color; ?>; padding: 5px; display: inline-block"><strong><?php _e('Tone:','bo-customer-review-watson');?></strong> <?php echo $tone["tone_name"] ?> </span> -
                                        <strong><?php _e('Fiability:','bo-customer-review-watson');?></strong> <?php echo($tone["score"] * 100) ?>%</li>
                                    <?php
                                }
                            } else { ?>
                                <li><strong><?php _e('No specific tone detected > 50% of fiability','bo-customer-review-watson');?></strong></li>
                                <?php
                            }
                            ?>
                        </ul>
                        <h4><?php _e('Success! Please now go to Tab "STEP C- Set Tones" to define your tones alert notifications settings','bo-customer-review-watson');?>.</h4>
                        <p><?php _e('On analyzing a customer review, depending on your Tones settings, for each tone type selected, if the fiability of a tone is above the minimum % you will define, a notification alert email could be sent to the defined users','bo-customer-review-watson');?>.</p>
                        <?php
                    }
                    ?>
                </div>
                <br clear="all"/>

            </div>
        </form>
    </div>
<?php endif; ?>
