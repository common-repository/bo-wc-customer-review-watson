<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across the admin area side of the site.
 *
 * @link       https://blue-origami-digital.com/
 * @since      1.0.0
 *
 * @package    BO_WC_Customer_Reviews_Watson
 * @subpackage BO_WC_Customer_Reviews_Watson/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    BO_WC_Customer_Reviews_Watson
 * @subpackage BO_WC_Customer_Reviews_Watson/includes
 * @author     Blue Origami Digital - Renaud Hamelin <renaud@b-o-d.fr>
 */
class BO_WC_Customer_Reviews_Watson
{

    /**
     * The loader that's responsible for maintaining and registering all hooks that power
     * the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      BO_WC_Customer_Reviews_Watson_Loader $loader Maintains and registers all hooks for the plugin.
     */
    protected $loader;

    /**
     * The unique identifier of this plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string $plugin_name The string used to uniquely identify this plugin.
     */
    protected $plugin_name;

    /**
     * The current version of the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string $version The current version of the plugin.
     */
    protected $version;

    /**
     * @var string
     */
    protected $environment = 'development';

    protected $is_configured;





    /**
     * Define the core functionality of the plugin.
     *
     * Set the plugin name and the plugin version that can be used throughout the plugin.
     * Load the dependencies, define the locale, and set the hooks for the admin area and
     * the public-facing side of the site.
     *
     * @param string $environment
     * @param string $version
     *
     * @since    1.0.0
     */
    public function __construct($environment = 'development', $version = '1.0.0')
    {

        $this->plugin_name = 'bo-customer-review-watson';
        $this->version = $version;
        $this->environment = $environment;

        $this->load_dependencies();
        $this->set_locale();
        $this->define_admin_hooks();

        $this->activateBO_WC_Customer_Reviews_WatsonService();
    }



    /**
     * @param $key
     * @param string $value
     * @return bool
     */
    private function queryStringEquals($key, $value = '1')
    {
        return isset($_GET[$key]) && $_GET[$key] === $value;
    }

    /**
     * Load the required dependencies for this plugin.
     *
     * Include the following files that make up the plugin:
     *
     * - BO_WC_Customer_Reviews_Watson_Loader. Orchestrates the hooks of the plugin.
     * - BO_WC_Customer_Reviews_Watson_i18n. Defines internationalization functionality.
     * - BO_WC_Customer_Reviews_Watson_Admin. Defines all hooks for the admin area.
     * - BO_WC_Customer_Reviews_Watson_Public. Defines all hooks for the public side of the site.
     *
     * Create an instance of the loader which will be used to register the hooks
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function load_dependencies()
    {


        // fire up the loader
        $this->loader = new BO_WC_Customer_Reviews_Watson_Loader();


    }

    /**
     * Define the locale for this plugin for internationalization.
     *
     * Uses the BO_WC_Customer_Reviews_Watson_i18n class in order to set the domain and to register the hook
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function set_locale()
    {
        $plugin_i18n = new BO_WC_Customer_Reviews_Watson_i18n();
        $this->loader->add_action('init', $plugin_i18n, 'load_plugin_textdomain');

    }



	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new BO_WC_Customer_Reviews_Watson_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_styles');
		$this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts');

		// Add menu item
		$this->loader->add_action('admin_menu', $plugin_admin, 'add_plugin_admin_menu');

		// Add Settings link to the plugin
		$plugin_basename = plugin_basename( plugin_dir_path( __DIR__ ) . $this->plugin_name . '.php');
		$this->loader->add_filter('plugin_action_links_' . $plugin_basename, $plugin_admin, 'add_action_links');

		// make sure we're listening for the admin init
		$this->loader->add_action('admin_init', $plugin_admin, 'options_update');


	}



	/**
	 * Handle all the service hooks here.
	 */
	private function activateBO_WC_Customer_Reviews_WatsonService()
	{
		$service = new BO_WC_Customer_Reviews_Watson_Service();

		if ($service->isConfigured()) {

			$service->setEnvironment($this->environment);
			$service->setVersion($this->version);

			// core hook setup
			$this->loader->add_action('admin_init', $service, 'adminReady');
			$this->loader->add_action('woocommerce_init', $service, 'wooIsRunning');
            $this->loader->add_action('wp_insert_comment', $service, 'commentPosted');

		}
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    BO_WC_Customer_Reviews_Watson_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}
}
