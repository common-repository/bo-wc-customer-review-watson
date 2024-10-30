<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
?>
<input type="hidden" name="bo_customer_review_watson_active_settings_tab" value="activate"/>

<h2 style="padding-top: 1em;"><?php _e('STEP','bo-customer-review-watson');?> E - <?php _e('ACTIVATE & LAUNCH THE ANALYZIS','bo-customer-review-watson');?></h2>

<h4><?php _e('WARNING: After activation, each customer review will start to be analyzed','bo-customer-review-watson');?>.</h4>
<p><?php _e('Remember that you can have (with a default basic IBM Watson plan) a free connection to the Tone Analyzer API, up to 2500 calls / month','bo-customer-review-watson');?>.
<br><?php _e('Above, you will need to pay (see Help tab > link to prices, for the cost)','bo-customer-review-watson');?></p>

<fieldset>
    <p><label><input name="<?php echo $this->plugin_name; ?>[bo_wc_customer_reviews_watson_active]" type="checkbox" <?php echo  isset($options['bo_wc_customer_reviews_watson_active'])  && $options['bo_wc_customer_reviews_watson_active'] == true ? "checked" : ""?>/> <?php _e('ACTIVATE THE SERVICE AND START TO ANALYZE EACH CUSTOMER REVIEW','bo-customer-review-watson');?></label></p>
</fieldset>