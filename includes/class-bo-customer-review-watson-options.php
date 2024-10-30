<?php

/**
 * Created by Blue Origami Digital.
 *
 * @since      1.0.0
 * @package    BO_WC_Customer_Reviews_Watson
 * @subpackage BO_WC_Customer_Reviews_Watson/includes
 * @author     Blue Origami Digital - Renaud Hamelin <renaud@b-o-d.fr>
 */
abstract class BO_WC_Customer_Reviews_Watson_Options
{
    /**
     *
     */
    protected $api;
    protected $plugin_name = 'bo-customer-review-watson';
    protected $environment = 'development';
    protected $version = '1.0.0';
    protected $plugin_options = null;
    protected $is_admin = false;

    /**
     * hook calls this so that we know the admin is here.
     */
    public function adminReady()
    {
        $this->is_admin = current_user_can('administrator');
        if (get_option('bo_customer_review_watson_plugin_do_activation_redirect', false)) {
            delete_option('bo_customer_review_watson_plugin_do_activation_redirect');

            // don't do the redirect while activating the plugin through the rest API.
            if ((defined( 'REST_REQUEST' ) && REST_REQUEST)) {
                return;
            }

            if (!isset($_GET['activate-multi'])) {
                wp_redirect("options-general.php?page=bo-customer-review-watson");
            }
        }
    }

    /**
     * @return bool
     */
    public function isAdmin()
    {
        return $this->is_admin;
    }

    /**
     * @param $version
     */
    public function setVersion($version)
    {
        $this->version = $version;
    }

    /**
     * @return string
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * @return string
     */
    public function getUniqueStoreID()
    {
        return bo_customer_review_watson_analyzer_get_store_id();
    }

    /**
     * @param $env
     * @return $this
     */
    public function setEnvironment($env)
    {
        $this->environment = $env;
        return $this;
    }

    /**
     * @return string
     */
    public function getEnvironment()
    {
        return $this->environment;
    }

    /**
     * @param $key
     * @param null $default
     * @return null
     */
    public function getOption($key, $default = null)
    {
        $options = $this->getOptions();
        if (isset($options[$key])) {
            return $options[$key];
        }
        return $default;
    }

    /**
     * @param $key
     * @param bool $default
     * @return bool
     */
    public function hasOption($key, $default = false)
    {
        return (bool) $this->getOption($key, $default);
    }

    /**
     * @return array
     */
    public function resetOptions()
    {
        return $this->plugin_options = get_option($this->plugin_name);
    }

    /**
     * @return array
     */
    public function getOptions()
    {

        if (empty($this->plugin_options)) {
            $this->plugin_options = get_option($this->plugin_name);
        }
        return is_array($this->plugin_options) ? $this->plugin_options : array();
    }

    /**
     * @param $key
     * @param $value
     * @return $this
     */
    public function setData($key, $value)
    {
        update_option($this->plugin_name.'-'.$key, $value, 'yes');
        return $this;
    }

    /**
     * @param $key
     * @param null $default
     * @return mixed|void
     */
    public function getData($key, $default = null)
    {
        return get_option($this->plugin_name.'-'.$key, $default);
    }


    /**
     * @param $key
     * @return bool
     */
    public function removeData($key)
    {
        return delete_option($this->plugin_name.'-'.$key);
    }

    /**
     * @param $key
     * @param null $default
     * @return null|mixed
     */
    public function getCached($key, $default = null)
    {
        $cached = $this->getData("cached-$key", false);
        if (empty($cached) || !($cached = unserialize($cached))) {
            return $default;
        }

        if (empty($cached['till']) || (time() > $cached['till'])) {
            $this->removeData("cached-$key");
            return $default;
        }

        return $cached['value'];
    }

    /**
     * @param $key
     * @param $value
     * @param $seconds
     * @return $this
     */
    public function setCached($key, $value, $seconds = 60)
    {
        $time = time();
        $data = array('at' => $time, 'till' => $time + $seconds, 'value' => $value);
        $this->setData("cached-$key", serialize($data));

        return $this;
    }

    /**
     * @param $key
     * @param $callable
     * @param int $seconds
     * @return mixed|null
     */
    public function getCachedWithSetDefault($key, $callable, $seconds = 60)
    {
        if (!($value = $this->getCached($key, false))) {
            $value = call_user_func($callable);
            $this->setCached($key, $value, $seconds);
        }
        return $value;
    }

    /**
     * @return bool
     */
    public function isConfigured()
    {
        return true;
        //return $this->getOption('public_key', false) && $this->getOption('secret_key', false);
    }

    /**
     * @return bool
     */
    protected function doingAjax()
    {
        return defined('DOING_AJAX') && DOING_AJAX;
    }



    /**
     * @param array $data
     * @param $key
     * @param null $default
     * @return null|mixed
     */
    public function array_get(array $data, $key, $default = null)
    {
        if (isset($data[$key])) {
            return $data[$key];
        }

        return $default;
    }


}
