<?php
if (!defined('ABSPATH')) exit; // Exit if accessed directly


$active_tab = isset($_GET['tab']) ? sanitize_text_field($_GET['tab']) : 'description';


$handler = BO_WC_Customer_Reviews_Watson_Admin::connect();

//Grab all options for this particular tab we're viewing.
$options = get_option($this->plugin_name, array());

if (!isset($_GET['tab']) && isset($options['active_tab'])) {
    $active_tab = $options['active_tab'];
}

$show_sync_tab = isset($_GET['resync']) ? sanitize_text_field($_GET['resync']) === '1' : false;;
$has_valid_api_key = false;
$allow_new_list = true;
$connection_info_empty = isset($options['connection_info_empty']) && !empty($options['connection_info_empty']) ? $options['connection_info_empty'] : null;

if (isset($options['bo_wc_customer_reviews_watson_api_key'])) {

    try {
        if ($handler->hasValidApiKey(null, true)) {
            $has_valid_api_key = true;
            // if we don't have a valid api key we need to redirect back to the 'api_key' tab.
        }
    } catch (\Exception $e) {
        $has_api_error = $e->getMessage() . ' on ' . $e->getLine() . ' in ' . $e->getFile();
    }
}
?>


<?php if (!defined('PHP_VERSION_ID') || (PHP_VERSION_ID < 70000)): ?>
    <div data-dismissible="notice-php-version" class="error notice notice-error is-dismissible">
        <p><?php _e('Blue Origami WC Customer Reviews AI Analyzer says: Please upgrade your PHP version to a minimum of 7.0', 'bo-customer-review-watson'); ?></p>
    </div>
<?php endif; ?>

<?php if (!empty($has_api_error)): ?>
    <div data-dismissible="notice-api-error" class="error notice notice-error is-dismissible">
        <p><?php _e("Blue Origami WC Customer Reviews AI Analyzer says: API Request Error - " . $has_api_error, 'bo-customer-review-watson'); ?></p>
    </div>
<?php endif; ?>

<!-- Create a header in the default WordPress 'wrap' container -->
<div class="wrap boai_wrap">
    <div id="icon-themes" class="icon32"></div>
    <h2>
        <img style="vertical-align: text-top; margin-right: 15px;" src="<?php echo BODAI_URL; ?>/admin/images/logovisu32.jpg"/><?php echo BODAI_PLUGINNAME ?> - <?php _e('Settings', 'bo-customer-review-watson'); ?>
    </h2>

    <h2 class="nav-tab-wrapper">
        <a style="margin-right: 25px;" href="?page=bo-customer-review-watson&tab=description" class="nav-tab <?php echo $active_tab == 'description' ? 'nav-tab-active' : ''; ?>"><?php _e('Description', 'bo-customer-review-watson'); ?></a>
        <a href="?page=bo-customer-review-watson&tab=api_key" class="nav-tab <?php echo $active_tab == 'api_key' ? 'nav-tab-active' : ''; ?>">A- <?php _e('Connect IBM Watson Tone analyzer', 'bo-customer-review-watson'); ?></a>
        <?php if ($has_valid_api_key): ?>
            <a href="?page=bo-customer-review-watson&tab=test" class="nav-tab <?php echo $active_tab == 'test' ? 'nav-tab-active' : ''; ?>">B- <?php _e('Test Api', 'bo-customer-review-watson'); ?></a>
        <?php endif; ?>
        <?php if ($has_valid_api_key): ?>
            <a href="?page=bo-customer-review-watson&tab=tones" class="nav-tab <?php echo $active_tab == 'tones' ? 'nav-tab-active' : ''; ?>">C- <?php _e('Set Tones', 'bo-customer-review-watson'); ?></a>
            <a href="?page=bo-customer-review-watson&tab=emails" class="nav-tab <?php echo $active_tab == 'emails' ? 'nav-tab-active' : ''; ?>">D- <?php _e('Set notifications', 'bo-customer-review-watson'); ?></a>
            <a href="?page=bo-customer-review-watson&tab=activate" class="nav-tab <?php echo $active_tab == 'activate' ? 'nav-tab-active' : ''; ?>">E- <?php _e('Launch', 'bo-customer-review-watson'); ?></a>
        <?php endif; ?>
        <a style="margin-left: 25px;" href="?page=bo-customer-review-watson&tab=pro" class="nav-tab <?php echo $active_tab == 'pro' ? 'nav-tab-active' : ''; ?>"><?php _e('Pro', 'bo-customer-review-watson'); ?></a>
        <a href="?page=bo-customer-review-watson&tab=help" class="nav-tab <?php echo $active_tab == 'help' ? 'nav-tab-active' : ''; ?>"><?php _e('Help', 'bo-customer-review-watson'); ?></a>
    </h2>

    <form method="post" name="cleanup_options" action="options.php">


        <?php
        if (!$clicked_sync_button) {
            settings_fields($this->plugin_name);
            do_settings_sections($this->plugin_name);
        }
        ?>

        <input type="hidden" name="<?php echo $this->plugin_name; ?>[bo_customer_review_watson_active_tab]" value="<?php echo esc_attr($active_tab); ?>"/>
        <input type="hidden" name="<?php echo $this->plugin_name; ?>[bo_customer_review_watson_nonce]" value="<?php echo wp_create_nonce('boai_security_post'); ?>">

        <?php if ($active_tab == 'api_key'): ?>
            <?php include_once 'tabs/api_key.php'; ?>
        <?php endif; ?>

        <?php if ($active_tab == 'tones' && $has_valid_api_key): ?>
            <?php include_once 'tabs/tones.php'; ?>
        <?php endif; ?>
        <?php if ($active_tab == 'test' && $has_valid_api_key): ?>
            <?php include_once 'tabs/test.php'; ?>
        <?php endif; ?>
        <?php if ($active_tab == 'description' && $has_valid_api_key): ?>
            <?php include_once 'tabs/description.php'; ?>
        <?php endif; ?>

        <?php if ($active_tab == 'emails' && $has_valid_api_key): ?>
            <?php include_once 'tabs/emails.php'; ?>
        <?php endif; ?>
        <?php if ($active_tab == 'activate' && $has_valid_api_key): ?>
            <?php include_once 'tabs/activate.php'; ?>
        <?php endif; ?>
        <?php if ($active_tab == 'pro'): ?>
            <?php include_once 'tabs/pro.php'; ?>
        <?php endif; ?>
        <?php if ($active_tab == 'help' && $has_valid_api_key): ?>
            <?php include_once 'tabs/help.php'; ?>
        <?php endif; ?>


        <?php if ($active_tab !== 'sync' && $active_tab !== 'logs' && $active_tab !== 'description' && $active_tab !== 'help' && $active_tab !== 'test' && $active_tab !== 'pro') submit_button(__('Save all changes', 'bo-customer-review-watson'), 'primary', 'submit', TRUE); ?>

    </form>


</div><!-- /.wrap -->
