<input type="hidden" name="bo_customer_review_watson_active_settings_tab" value="api_key"/>
<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if (($options['connection_submitted'] == true && $options['connection_info_empty'] == true) or $options['connection_server_empty'] == true) { ?>

    <div data-dismissible="bo-wc-notice-api-error" class="error notice notice-error is-dismissible">
        <p><?php _e('STEP','bo-customer-review-watson');?> A- <?php _e('IBM Watson - Tone Analyser settings','bo-customer-review-watson');?> - <?php _e('Account & Service Connection Information:','bo-customer-review-watson');?>
            <br><?php _e('You need to input an Api Key, or a Username + a Password, and select a server','bo-customer-review-watson');?>.</p>
        <button type="button" class="notice-dismiss"><span class="screen-reader-text"><?php _e('Dismiss this notice','bo-customer-review-watson');?>.</span>
        </button>
    </div>
    <?php
}
?>

<h2 style="padding-top: 1em;"><?php _e('STEP','bo-customer-review-watson');?> A- <?php _e('IBM Watson - Tone Analyser settings','bo-customer-review-watson');?>s - <?php _e('Account & Service Connection Information:','bo-customer-review-watson');?></h2>
<h4><?php _e('STEP','bo-customer-review-watson');?> 1/ <?php _e('CREATE AN ACCOUNT & A SERVICE','bo-customer-review-watson');?></h4>
<p><strong><?php _e('Don\'t worry, this is not so hard. And you can create an IBM Watson Account for FREE!','bo-customer-review-watson');?></strong></p>
<?php _e('To know how to create an IBM Waston Account + a Tone Analyzer Service, and to get your Connections informations, see the tab "Help"','bo-customer-review-watson');?>
<h4><?php _e('STEP','bo-customer-review-watson');?> 2/ <?php _e('SELECT YOUR CONNECTION TYPE','bo-customer-review-watson');?></h4>
<p><strong>2-1/</strong> <?php _e('Depending on your account type, you will have a different Connection information type, with','bo-customer-review-watson');?></p>
A- <?php _e('An Api Key','bo-customer-review-watson');?>
<br>B- <?php _e('Or a Username & Password','bo-customer-review-watson');?></p>
<p><?php _e('If you are not sure of your account type, please referer again to the tab "Help"','bo-customer-review-watson');?></p>
<p><strong>2-2/</strong> <?php _e('Please select the type of connection:','bo-customer-review-watson');?></p>
<p>
    <?php
    isset($options['bo_wc_customer_reviews_watson_connection_type']) ? $connection_type = $options['bo_wc_customer_reviews_watson_connection_type'] : $connection_type = 'api_key';
    ?>
    <input type="radio" class="connection_type_selector" name="<?php echo $this->plugin_name; ?>[bo_wc_customer_reviews_watson_connection_type]" value="api_key" <?php echo $connection_type == "api_key" ? "checked" : ""; ?>>A- <?php _e('With an Api Key','bo-customer-review-watson');?><br>
    <input type="radio" class="connection_type_selector" name="<?php echo $this->plugin_name; ?>[bo_wc_customer_reviews_watson_connection_type]" value="username_password" <?php echo $connection_type == "username_password" ? "checked" : ""; ?>>B- <?php _e('With a Username & Password','bo-customer-review-watson');?>
</p>

<fieldset>
    <h4><?php _e('STEP','bo-customer-review-watson');?> 3/ <?php _e('INPUT YOUR CONNECTION INFORMATIONS','bo-customer-review-watson');?></h4>
    <?php
    $api_key_div = "";
    $username_password_div = "";
    if ($connection_type == "api_key"):
        $username_password_div = "hidden";
    endif;
    if ($connection_type == "username_password"):
        $api_key_div = "hidden";
    endif; ?>

    <div class="<?php echo $api_key_div; ?> connection_type_div connection_type_api_key">
        <strong><?php _e('Case','bo-customer-review-watson');?> A- <?php _e('Connection with an Api Key','bo-customer-review-watson');?></strong>
        <br><?php _e('Enter your IBM Watson - Tone Analyser Service','bo-customer-review-watson');?> - <?php _e('API key','bo-customer-review-watson');?>.
        <input style="width: 30%;" type="password" id="<?php echo $this->plugin_name; ?>-bo-wc-cr-watson-api-key" name="<?php echo $this->plugin_name; ?>[bo_wc_customer_reviews_watson_api_key]" value="<?php echo isset($options['bo_wc_customer_reviews_watson_api_key']) ? $options['bo_wc_customer_reviews_watson_api_key'] : '' ?>"/>
    </div>

    <div class="<?php echo $username_password_div; ?> connection_type_div connection_type_username_password">
        <strong><?php _e('Case','bo-customer-review-watson');?> B- <?php _e('Connection with a Username & Password','bo-customer-review-watson');?></strong>
        <br><?php _e('Enter your IBM Watson - Tone Analyser Service','bo-customer-review-watson');?> - <?php _e('Connection Informations','bo-customer-review-watson');?>.
        <p><label><?php _e('Username:','bo-customer-review-watson');?></label>
            <input style="width: 30%;" type="text" id="<?php echo $this->plugin_name; ?>-bo-wc-cr-watson-username" name="<?php echo $this->plugin_name; ?>[bo_wc_customer_reviews_watson_username]" value="<?php echo isset($options['bo_wc_customer_reviews_watson_username']) ? $options['bo_wc_customer_reviews_watson_username'] : '' ?>"/>
        </p>
        <p><label><?php _e('Password:','bo-customer-review-watson');?></label>
            <input style="width: 30%;" type="password" id="<?php echo $this->plugin_name; ?>-bo-wc-cr-watson-password" name="<?php echo $this->plugin_name; ?>[bo_wc_customer_reviews_watson_password]" value="<?php echo isset($options['bo_wc_customer_reviews_watson_password']) ? $options['bo_wc_customer_reviews_watson_password'] : '' ?>"/>
        </p>
    </div>

    <div>

        <h4><?php _e('STEP','bo-customer-review-watson');?> 4/ <?php _e('SELECT THE IBM WATSON ENDPOINT SERVER','bo-customer-review-watson');?></h4>
        <?php
        isset($options['bo_wc_customer_reviews_watson_server_endpoint']) ? $server_endpoint = $options['bo_wc_customer_reviews_watson_server_endpoint'] : $server_endpoint = '-'; ?>
        <select name="<?php echo $this->plugin_name; ?>[bo_wc_customer_reviews_watson_server_endpoint]">
            <option value="-" <?php echo $server_endpoint =="-" ?  "selected" : ""?> ><?php _e('Please select','bo-customer-review-watson');?></option>
            <option value="gateway" <?php echo $server_endpoint =="gateway" ?  "selected" : ""?> >Dallas</option>
            <option value="gateway-wdc" <?php echo $server_endpoint =="gateway-wdc" ?  "selected" : ""?> >Washington DC</option>
            <option value="gateway-fra" <?php echo $server_endpoint =="gateway-fra" ?  "selected" : ""?> >Frankfurt</option>
            <option value="gateway-syd" <?php echo $server_endpoint =="gateway-syd" ?  "selected" : ""?> >Sydney</option>
            <option value="gateway-tok" <?php echo $server_endpoint =="gateway-tok" ?  "selected" : ""?> >Tokyo</option>
            <option value="gateway-lon" <?php echo $server_endpoint =="gateway-lon" ?  "selected" : ""?> >London</option>
        </select>
        <br>
        <br>
    </div><div>

        <h4><?php _e('STEP','bo-customer-review-watson');?> 5/ <?php _e('SELECT THE LANGUAGE','bo-customer-review-watson');?></h4>
        <p><?php _e('English or French only for this Ibm Watson service, sorry for other languages','bo-customer-review-watson');?>.</p>
        <?php
        isset($options['bo_wc_customer_reviews_watson_language']) ? $language = $options['bo_wc_customer_reviews_watson_language'] : $language = '-'; ?>
        <select name="<?php echo $this->plugin_name; ?>[bo_wc_customer_reviews_watson_language]">
            <option value="en" <?php echo $language =="en" ?  "selected" : ""?> >English</option>
            <option value="fr" <?php echo $language =="fr" ?  "selected" : ""?> >Français</option>
        </select>
        <br>
        <br>
    </div>

</fieldset>