<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://blue-origami-digital.com/
 * @since      1.0.0
 *
 * @package    BO_WC_Customer_Reviews_Watson
 * @subpackage BO_WC_Customer_Reviews_Watson/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    BO_WC_Customer_Reviews_Watson
 * @subpackage BO_WC_Customer_Reviews_Watson/includes
 * @author     Blue Origami Digital - Renaud Hamelin <renaud@b-o-d.fr>
 */
class BO_WC_Customer_Reviews_Watson_i18n
{


    /**
     * Load the plugin text domain for translation.
     *
     * @since    1.0.0
     */
    public function load_plugin_textdomain()
    {

        load_plugin_textdomain(
            'bo-customer-review-watson',
            false,
            dirname(dirname(plugin_basename(__FILE__))) . '/languages/'
        );

        define('BODAI_PLUGINNAME', __('IBM Watson + Woocommerce, Customer Reviews A.I. Tone Analyzer Notifications','bo-customer-review-watson'));
        define('BODAI_PLUGINSHORTNAME', __('WC Reviews - Watson A.I. Analyzer','bo-customer-review-watson'));


    }


}
