<?php

// If this file is called directly, abort.
if (!defined( 'WPINC')) {
    die;
}

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$bo_customer_review_watson_analyzer_wc_spl_autoloader = true;

spl_autoload_register(function($class) {
    $classes = array(
        // includes root
        'BO_WC_Customer_Reviews_Watson_Options' => 'includes/class-bo-customer-review-watson-options.php',
        'BO_WC_Customer_Reviews_Watson_Loader' => 'includes/class-bo-customer-review-watson-loader.php',
        'BO_WC_Customer_Reviews_Watson_Service' => 'includes/class-bo-customer-review-watson-service.php',
        'BO_WC_Customer_Reviews_Watson_Deactivator' => 'includes/class-bo-customer-review-watson-deactivator.php',
        'BO_WC_Customer_Reviews_Watson_Activator' => 'includes/class-bo-customer-review-watson-activator.php',
        'BO_WC_Customer_Reviews_Watson_i18n' => 'includes/class-bo-customer-review-watson-i18n.php',
        'BO_WC_Customer_Reviews_Watson_Api' => 'includes/class-bo-customer-review-watson-api.php',
        'BO_WC_Customer_Reviews_Watson' => 'includes/class-bo-customer-review-watson.php',
        'BO_WC_Customer_Reviews_Watson_Admin' => 'admin/class-bo-customer-review-watson-admin.php',

    );

    // if the file exists, require it
    $path = plugin_dir_path( __FILE__ );
    if (array_key_exists($class, $classes) && file_exists($path.$classes[$class])) {
        require $path.$classes[$class];
    }
});

function bo_get_tones_list(){
    return   array(
        "anger"=>array(
            "tone_id" => "anger",
            "tone_name" => __('Anger','bo-customer-review-watson'),//"Anger",
            "color" => "#fc6565",
            "default" => true,
            "default_treshold" => "60",
        ),
        "fear"=> array(
            "tone_id" => "fear",
            "tone_name" => __('Fear','bo-customer-review-watson'),//"Fear",
            "color" => "orange",
            "default" => true,
            "default_treshold" => "60",
        ),
        "sadness"=> array(
            "tone_id" => "sadness",
            "tone_name" => __('Sadness','bo-customer-review-watson'),//"Sadness",
            "color" => "yellow",
            "default" => true,
            "default_treshold" => "70",
        ),
        "joy"=>array(
            "tone_id" => "joy",
            "tone_name" => __('Joy','bo-customer-review-watson'),//"Joy",
            "color" => "#24c324",
            "default" => false,
        ),
        "analytical"=> array(
            "tone_id" => "analytical",
            "tone_name" => __('Analytical','bo-customer-review-watson'),//"Analytical",
            "color" => "#00b9ff",
            "default" => false,
        ),
        "confident"=>array(
            "tone_id" => "confident",
            "tone_name" => __('Confident','bo-customer-review-watson'),//"Confident",
            "color" => "#AAAAAA",
            "default" => false,
        ),
        "tentative"=> array(
            "tone_id" => "tentative",
            "tone_name" => __('Tentative','bo-customer-review-watson'),//"Tentative",
            "color" => "white",
            "default" => false,
        ),
    );
}
/**
 * @param $key
 * @param null $default
 * @return mixed
 */
function bo_customer_review_watson_analyzer_get_data($key, $default = null) {
    return get_option('bo-customer-review-watson-'.$key, $default);
}

/**
 * @param $key
 * @param $value
 * @param string $autoload
 * @return bool
 */
function bo_customer_review_watson_analyzer_set_data($key, $value, $autoload = 'yes') {
    return update_option('bo-customer-review-watson-'.$key, $value, $autoload);
}

/**
 * @return string
 */
function bo_customer_review_watson_analyzer_get_store_id() {
    $store_id = bo_customer_review_watson_analyzer_get_data('store_id', false);
    if (empty($store_id)) {
        bo_customer_review_watson_analyzer_set_data('store_id', $store_id = uniqid(), 'yes');
    }
    return $store_id;
}
/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-bo-customer-review-watson-activator.php
 */
function activate_bo_customer_review_watson_analyzer_wc() {
    // if we don't have woocommerce we need to display a horrible error message before the plugin is installed.
    if (!bo_customer_reviews_watson_check_woocommerce_plugin_status()) {
        // Deactivate the plugin
        deactivate_plugins(__FILE__);
        $error_message = __('The plugin ', 'bo-customer-review-watson').BODAI_PLUGINNAME. __(' requires the <a href="http://wordpress.org/extend/plugins/woocommerce/">WooCommerce</a> plugin to be active!', 'bo-customer-review-watson');
        wp_die($error_message);
    }
    BO_WC_Customer_Reviews_Watson_Activator::activate();
}


/**
 * @return bool
 */
function bo_customer_reviews_watson_check_woocommerce_plugin_status()
{
    // if you are using a custom folder name other than woocommerce just define the constant to TRUE
    if (defined("RUNNING_CUSTOM_WOOCOMMERCE") && RUNNING_CUSTOM_WOOCOMMERCE === true) {
        return true;
    }
    // it the plugin is active, we're good.
    if (in_array('woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option('active_plugins')))) {
        return true;
    }
    if (!is_multisite()) return false;
    $plugins = get_site_option( 'active_sitewide_plugins');
    return isset($plugins['woocommerce/woocommerce.php']);
}
/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-bo-customer-review-watson-deactivator.php
 */
function deactivate_bo_customer_review_watson_analyzer_wc() {
    BO_WC_Customer_Reviews_Watson_Deactivator::deactivate();
}


function bo_customer_review_watson_analyzer_wc_on_all_plugins_loaded() {
    if (bo_customer_reviews_watson_check_woocommerce_plugin_status()) {
        run_bo_customer_review_watson();
    }
}


function run_bo_customer_review_watson() {
    $env = bo_customer_review_watson_environment_variables();
    $plugin = new BO_WC_Customer_Reviews_Watson($env->environment, $env->version);
    $plugin->run();
}
/**
 * @return object
 */
function bo_customer_review_watson_environment_variables() {
    global $wp_version;

    $o = get_option('bo_customer_review_watson', false);

    return (object) array(
        'repo' => 'master',
        'environment' => 'production',
        'version' => '1.0.0',
        'php_version' => phpversion(),
        'wp_version' => (empty($wp_version) ? 'Unknown' : $wp_version),
        'wc_version' => class_exists('WC') ? WC()->version : null,
    );
}

