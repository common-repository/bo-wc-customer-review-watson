<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://wc-reviews-watson-tone-analyzer.blue-origami-digital.com
 * @since             1.0.0
 * @package           BO_Woocommerce_Customer_Reviews_Watson
 *
 * @wordpress-plugin
 * Plugin Name:       Customer Reviews A.I. Tone Analyzer Notifications with IBM Watson + Woocommerce
 * Plugin URI:        https://wc-reviews-watson-tone-analyzer.blue-origami-digital.com
 * Description:       Plugin for WooCommerce, to analyze via A.I, all the customer reviews texts, through IBM Watson Tone Analyzer service, to detect specific tones in the text, like Angry or Sadness, and trigger email alerts to warn the moderator / admin.
 * Version:           1.0.0
 * Author:            Blue Origami Digital - Renaud Hamelin <renaud@b-o-d.fr>
 * Author URI:        https://blue-origami-digital.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       bo-customer-review-watson
 * Domain Path:       /languages
 * Requires at least: 4.8
 * Tested up to: 5.1
 */
if ( !defined( 'ABSPATH' ) ) {
    exit;
}
// If this file is called directly, abort.
if ( !defined( 'WPINC' ) ) {
    die;
}
/*
 * USING FREEMIUS API, https://freemius.com/, to help follow up, grab comments and feedbacks, and propose later a Premium version.
 */

if ( function_exists( 'bo_cr_watson_fs' ) ) {
    bo_cr_watson_fs()->set_basename( false, __FILE__ );
    return;
}


if ( !function_exists( 'bo_cr_watson_fs' ) ) {
    // Create a helper function for easy SDK access.
    function bo_cr_watson_fs()
    {
        global  $bo_cr_watson_fs ;
        
        if ( !isset( $bo_cr_watson_fs ) ) {
            // Include Freemius SDK.
            require_once dirname( __FILE__ ) . '/freemius/start.php';
            $bo_cr_watson_fs = fs_dynamic_init( array(
                'id'             => '3356',
                'slug'           => 'bo-customer-review-watson',
                'type'           => 'plugin',
                'public_key'     => 'pk_4b6e3d1a050122de0714a542b8ae4',
                'is_premium'     => false,
                'has_addons'     => false,
                'has_paid_plans' => true,
                'trial'          => array(
                'days'               => 7,
                'is_require_payment' => true,
            ),
                'menu'           => array(
                'slug'       => 'bo-customer-review-watson',
                'first-path' => 'admin.php?page=bo-customer-review-watson',
                'support'    => false,
            ),
                'is_live'        => true,
            ) );
        }
        
        return $bo_cr_watson_fs;
    }
    
    // Init Freemius.
    bo_cr_watson_fs();
    // Signal that SDK was initiated.
    do_action( 'bo_cr_watson_fs_loaded' );
}

if ( !isset( $bo_customer_review_watson_analyzer_wc_spl_autoloader ) || $bo_customer_review_watson_analyzer_wc_spl_autoloader === false ) {
    include_once "bootstrap.php";
}
register_activation_hook( __FILE__, 'activate_bo_customer_review_watson_analyzer_wc' );
register_uninstall_hook( __FILE__, 'deactivate_bo_customer_review_watson_analyzer_wc' );
add_action( 'plugins_loaded', 'bo_customer_review_watson_analyzer_wc_on_all_plugins_loaded', 12 );
define( 'BODAI_URL', plugins_url( '', __FILE__ ) );
define( 'BODAI_PATH', plugin_dir_path( __FILE__ ) );