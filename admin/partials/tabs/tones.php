<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
?>
<input type="hidden" name="bo_customer_review_watson_active_settings_tab" value="tones"/>

<h2 style="padding-top: 1em;"><?php _e('Set Tones to detect','bo-customer-review-watson');?></h2>
<h3><?php _e('Tone','bo-customer-review-watson');?>List of all the Tones that IBM Watson Tone Analyzer can detect in your customer reviews:</h3>
<p><?php _e('For each one, please define if you want to detect it, and what is the minimum % treshold to reach, in order to trigger sending an alert notification email','bo-customer-review-watson');?>.</p>
<p><?php _e('For example: if you check "Anger" and set a minimum % treshold of 60%, then for any customer review with any sentence returning a level of anger > 60%, the notification email will be sent','bo-customer-review-watson');?>.
<br><?php _e('If you select multiple tones, only one email notification will be sent for one customer reviews, in case the criterias is matched by any of the tones selected','bo-customer-review-watson');?>.</p>
<!-- remove some meta and generators from the <head> -->
<br>
<small><?php _e('Note: some tones and treshold are preset by default, you can update them','bo-customer-review-watson');?>.</small>
<h4><?php _e('Minimum threshold % required by tone: 50% (below, Watson will not consider them)','bo-customer-review-watson');?></h4>

<fieldset>
    <ul class="boai_tones_list_form">
        <?php
        $tones = bo_get_tones_list();
        foreach ($tones as $tone) {
            $treshold=$tone['default_treshold'];
            if( isset( $options["bo_wc_customer_reviews_watson_tone_treshold_".$tone['tone_id']] ) ){
                $treshold=$options["bo_wc_customer_reviews_watson_tone_treshold_".$tone['tone_id']];
            }
            $checked=$tone['default'];
            if( isset( $options["bo_wc_customer_reviews_watson_tone_check_".$tone['tone_id']] ) ){
                $checked=$options["bo_wc_customer_reviews_watson_tone_check_".$tone['tone_id']];
            }
            ?>
            <li>
                <input name="<?php echo $this->plugin_name; ?>[bo_wc_customer_reviews_watson_tone_check_<?php echo $tone['tone_id'] ?>]"  type="checkbox" <?php echo $checked == true ? "checked" : "" ?> >
                <label style="font-weight: bold; background-color:<?php echo $tone['color'] ?>; padding: 4px;"><?php echo $tone['tone_name'] ?></label> - <?php _e('Detection of minimum','bo-customer-review-watson');?> >=
                <input name="<?php echo $this->plugin_name; ?>[bo_wc_customer_reviews_watson_tone_treshold_<?php echo $tone['tone_id'] ?>]" value="<?php echo $treshold ?>" type="text">% <?php _e('to trigger a notification','bo-customer-review-watson');?>
            </li>
            <?php
        }
        ?>
    </ul>
</fieldset>
