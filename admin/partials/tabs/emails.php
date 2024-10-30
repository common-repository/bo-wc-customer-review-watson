<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
?>
<input type="hidden" name="bo_customer_review_watson_active_settings_tab" value="emails"/>

<h2 style="padding-top: 1em;"><?php _e('Set notifications Email alerts','bo-customer-review-watson');?></h2>
<p><strong><?php _e('On this FREE version','bo-customer-review-watson');?></strong>,
    <?php _e('the email subject and content is unique for all tones. You can only define the email subject. Content is defined by default in a file','bo-customer-review-watson');?>.
    <br>(<?php _e('NOTE: if you are a developper you can edit the file','bo-customer-review-watson');?> /mails/generic_email_notification_alert_tpl.php).</p>

<fieldset>
    <p><label class="boai_emails_labels "><?php _e('Email notification alert','bo-customer-review-watson');?> - <?php _e('Subject:','bo-customer-review-watson');?> </label><input style="width: 50%;" name="<?php echo $this->plugin_name; ?>[bo_wc_customer_reviews_watson_email_subject]" value="<?php echo isset($options['bo_wc_customer_reviews_watson_email_subject']) && $options['bo_wc_customer_reviews_watson_email_subject']!=="" ? $options['bo_wc_customer_reviews_watson_email_subject'] : 'Your site name - Customer Review Analyzis Alert' ?>"/></p>


    <p><label class="boai_emails_labels "><?php _e('Email notification alert','bo-customer-review-watson');?> - <?php _e('"From" name:','bo-customer-review-watson');?> </label><input style="width: 50%;" name="<?php echo $this->plugin_name; ?>[bo_wc_customer_reviews_watson_email_fromname]" value="<?php echo isset($options['bo_wc_customer_reviews_watson_email_fromname']) && $options['bo_wc_customer_reviews_watson_email_fromname']!=="" ? $options['bo_wc_customer_reviews_watson_email_fromname'] : 'Your sender name' ?>"/></p>


    <p><label class="boai_emails_labels "><?php _e('Email notification alert','bo-customer-review-watson');?> - <?php _e('"From" email:','bo-customer-review-watson');?> </label><input style="width: 50%;" name="<?php echo $this->plugin_name; ?>[bo_wc_customer_reviews_watson_email_fromemail]" value="<?php echo isset($options['bo_wc_customer_reviews_watson_email_fromemail']) && $options['bo_wc_customer_reviews_watson_email_fromemail']!=="" ? $options['bo_wc_customer_reviews_watson_email_fromemail'] : 'Your sender from email address' ?>"/></p>


</fieldset>
<p><strong><?php _e('PRO feature only','bo-customer-review-watson');?>:</strong> <?php _e('Set specific emails by Tone, and set specific email content for each tone','bo-customer-review-watson');?>.</p>
<p><?php _e('In the Pro (but cheap) version , under development','bo-customer-review-watson');?>, <?php _e('you will have the possibility to edit your Email notifications, and to define a different subject and content for each Tone selected','bo-customer-review-watson');?>.</p>
<h2 style="padding-top: 1em;"><?php _e('Set Users targets','bo-customer-review-watson');?></h2>
<p><?php _e('On the free version, the emails notifications alerts are sent to all the administrator users','bo-customer-review-watson');?>...</p>
<p><strong><?php _e('PRO feature only','bo-customer-review-watson');?>.</strong> <?php _e('In the Pro (but cheap) version , under development','bo-customer-review-watson');?>, <?php _e('you will have the possibility to select a list of users, or a list of roles','bo-customer-review-watson');?>. </p>