<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
?>
<input type="hidden" name="bo_customer_review_watson_active_settings_tab" value="description"/>

<h2 style="padding-top: 1em;"><?php _e('Description', 'bo-customer-review-watson'); ?></h2>
<h3><?php _e('Your WooCommerce Customers Reviews, analyzed by the power of IBM Watson Tone Analyzer', 'bo-customer-review-watson'); ?></h3>
<h4><?php _e('Apply the power of Artificial Intelligence to detect emotions/tones in your customers reviews', 'bo-customer-review-watson'); ?>. <?php _e('Following your settings, you will receive email notifications if a customer is Angry, Sad, Afraid', 'bo-customer-review-watson'); ?>...</h4>
<p class="boai_topintro"><img width="130" src="<?php echo BODAI_URL ?>/admin/images/woocommerce.png"> <span>+</span>
    <img width="130" src="<?php echo BODAI_URL ?>/admin/images/watson_purple.png"><span>IBM Watson </span>
    <img width="300" src="<?php echo BODAI_URL ?>/admin/images/ToneAnalyzer.jpg"></p>

<p><?php _e('The best way to get warned when a reviews really needs an urgent reply and moderation', 'bo-customer-review-watson'); ?>. <?php _e('You will be able to react much quickly and manage the reactions of your clients before they could impact your business', 'bo-customer-review-watson'); ?>.</p>
<p><?php _e('This plugin will add a call to Watson Ton Analyzer, each time a review is poosted on a product, to analyze it\'s content', 'bo-customer-review-watson'); ?>.</p>
<p><?php _e('This plugin is relying on a 3rd party as a service, the plugin send your content to your own version of Watson Tone Analyzer web service', 'bo-customer-review-watson'); ?>. <?php _e('Only the review text will be sent to the cloud service, no personal data or any other information are sent to the web service', 'bo-customer-review-watson'); ?>. <?php _e('This plugin DO require you to create a (quick and easily created) FREE account on IBM Watson Cloud', 'bo-customer-review-watson'); ?>.
</p>



<div style="padding: 4px 10px; background: #ebdbbe; width: 48%;  float:left; ">

<h4>1/ <?php _e('VERSIONS OLDER THAN 1.0:', 'bo-customer-review-watson'); ?> <?php _e('TEMPORARY ISSUE WARNING > OCCASIONNAL ISSUE FOR UPDATING YOUR  PLUGIN FREE VERSION TO A NEW VERSION', 'bo-customer-review-watson'); ?></h4>
<h4><strong><?php
    $env = bo_customer_review_watson_environment_variables();
    _e('You are currently in Version', 'bo-customer-review-watson'); echo " ".$env->version;
    ?> <?php _e('and should not be concerned.', 'bo-customer-review-watson'); ?></strong></h4>
<p><?php _e('It could happend, in some cases, with the Free version licence, that the free license could be not well activated or blocked, you could be blocked to get an access to the plugin update. In this case:<br>1. It should be possible to go to wp-admin/admin.php?page=bo-customer-review-watson-account and do "sync" licence,.<br>2. If not working, you can redownload again the last version and upload it again. Don\'t worry no data will be lost.<br> 3. If not possible in your case, the best to do is to contact us and we will generated a new licence remotely and it should be possible to sync the licence,  or try "Activate licence" with the one we will send to you.', 'bo-customer-review-watson'); ?></p>
<p><?php _e('Note that we are working on it, to see how to simplify the Update process for free versions. Contact us for any issues.', 'bo-customer-review-watson'); ?></p>
</div>


<div style="padding: 4px 10px; background: #d8ebbb;  width: 48%; margin-left:1%; float:left;">
<h2 style="padding-top: 1em;"><?php _e('NEW PLAN ADDED, Free features + Advanced Support', 'bo-customer-review-watson'); ?></h2>
<p><?php _e('With this plan, you will have the same features than the free, but a much better support.<br>Adding support by email and better reactivity and support time in 48hr (as long as I\'m not sick...)', 'bo-customer-review-watson'); ?>
    <a href="admin.php?page=bo-customer-review-watson-pricing">UPGRADE</a></p>
</div>

<br clear="all"/>
<h4><?php _e('What is IBM Watson, what is Tone Analyzer?', 'bo-customer-review-watson'); ?></h4>
<p>
    <a target="_blank" href="https://www.ibm.com/watson">IBM Watson</a> <?php _e('is the Artificial Intelligence Branch of IBM, proposing a lot of A.I. different services for different needs', 'bo-customer-review-watson'); ?>
</p>
<p>
    <a target="_blank" href="https://www.ibm.com/watson/services/tone-analyzer/">IBM Watson Tone Analyzer</a> <?php _e('is the Watson service, that understand emotions and communication style in text', 'bo-customer-review-watson'); ?>.
    <br><?php _e('Base on this it can return a list of emotions/tones detected eventually in your text, with a % of fiability', 'bo-customer-review-watson'); ?>.</p>
<p>
    <a target="_blank" href="https://tone-analyzer-demo.ng.bluemix.net/"><?php _e('See a simple demo of the IBM Watson Ton Analyzer', 'bo-customer-review-watson'); ?></a>
</p>

<p><?php _e('EXAMPLE of a text passed through the analyze:', 'bo-customer-review-watson'); ?> </p>
<img class="boai_imgborder" src="<?php echo BODAI_URL ?>/admin/images/testTexts.JPG">
<p><?php _e('EXISTING TONES: the following tones are detected by Watson', 'bo-customer-review-watson'); ?></p>
<img class="boai_imgborder" src="<?php echo BODAI_URL ?>/admin/images/TonesEx.JPG">

<h4><?php _e('How can I apply Watson to the WooCommerce Customer reviews?', 'bo-customer-review-watson'); ?></h4>
<p><?php _e('You will need to have a free account at Watson, and create a "Tone Analyzer" service. This is free up to 2500 calls to the API / month', 'bo-customer-review-watson'); ?></p>
<p><?php _e('Then you will receive connexion informations, and you just need to insert your information in this plugin', 'bo-customer-review-watson'); ?>.
    <strong><?php _e('NO complex settings, NO NEED to be a geek or very tech savyy, very EASY to SET UP', 'bo-customer-review-watson'); ?></strong></p>
<p>> <?php _e('Create your free acount at Watson:', 'bo-customer-review-watson'); ?>
    <a target="_blank" href="https://cloud.ibm.com/registration?target=%2Fcatalog%2Fservices%2Ftone-analyzer%3FhideTours%3Dtrue%26?cm_sp=WatsonPlatform-WatsonPlatform-_-OnPageNavCTA-IBMWatson_ToneAnalyzer-_-Watson_Developer_Website"><?php _e('Create my Account', 'bo-customer-review-watson'); ?></a>
</p>
<p>> <?php _e('Once your account is created, create your tone analyser service:', 'bo-customer-review-watson'); ?>
    <a target="_blank" href="https://cloud.ibm.com/registration?target=%2Fcatalog%2Fservices%2Ftone-analyzer%3FhideTours%3Dtrue%26?cm_sp=WatsonPlatform-WatsonPlatform-_-OnPageNavCTA-IBMWatson_ToneAnalyzer-_-Watson_Developer_Website"><?php _e('Create my Service', 'bo-customer-review-watson'); ?></a>
</p>
<p> <?php _e('WARNING: note that here you need to select the SERVER LOCATION, please save this information, you will need to define the server target', 'bo-customer-review-watson'); ?></p>
<img class="boai_imgborder" src="<?php echo BODAI_URL ?>/admin/images/createServiceWatson.JPG">
<p>> <?php _e('After creation of your service, you will be redirected to the service dashboard', 'bo-customer-review-watson'); ?>.</p>
<img class="boai_imgborder" src="<?php echo BODAI_URL ?>/admin/images/dashboardServiceWatson.JPG">
<p>> <?php _e('Then find the <strong>MANAGE page</strong>', 'bo-customer-review-watson'); ?></p>
<p> <?php _e('You will find here the IDENTIFICATION INFORMATION for your service, API connection values', 'bo-customer-review-watson'); ?>.
<br> <?php _e('DEPENDING on your ACCOUNT TYPE, there is TWO TYPEs of values, an API KEY, or a USERNAME + PASSWORD', 'bo-customer-review-watson'); ?>
</p>
<p> <?php _e('Find here the <strong>API KEY or USERNAME + PASSWORD</strong>, note it,', 'bo-customer-review-watson'); ?>
    <br><?php _e('and an URL. This URL will be automatically generated by the plugin, you just need to know what is the SERVER LOCATION city you selected on previous step (example here:', 'bo-customer-review-watson'); ?> gateway-lon = london)
</p>
<img class="boai_imgborder" src="<?php echo BODAI_URL ?>/admin/images/WatsonGetIndentification.JPG">
<p><?php _e('THAT\'s ALL! Nothing more complex. Refer to the STEP A to start setting up your plugin', 'bo-customer-review-watson'); ?>.</p>

<br>
<p><?php _e('This plugin is built by', 'bo-customer-review-watson'); ?> <a href="https://blue-origami-digital.com/">Blue Origami Digital, France</a> </p>
