<?php
/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    BO_WC_Customer_Reviews_Watson
 * @subpackage BO_WC_Customer_Reviews_Watson/includes
 * @author     Blue Origami Digital - Renaud Hamelin <renaud@b-o-d.fr>
 */
class BO_WC_Customer_Reviews_Watson_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {



		// update the settings so we have them for use.
        $saved_options = get_option('bo_customer_review_watson', false);

        // if we haven't saved options previously, we will need to create the site id and update base options
        if (empty($saved_options)) {
            update_option('bo_customer_review_watson', array());
            // only do this if the option has never been set before.
            if (!is_multisite()) {
                add_option('bo_customer_review_watson_plugin_do_activation_redirect', true);
            }
        }

        // if we haven't saved the store id yet.
        $saved_store_id = get_option('bo_customer_review_watson-store_id', false);
        if (empty($saved_store_id)) {
            // add a store id flag which will be a random hash
            update_option('bo_customer_review_watson-store_id', uniqid(), 'yes');
        }


	}


}
