<?php

/**
 * The file that defines the core plugin class.
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://woocommerce.db-dzine.com
 * @since      1.0.0
 */

class Wordpress_Doodle
{
    /**
     * The loader that's responsible for maintaining and registering all hooks that power
     * the plugin.
     *
     * @since    1.0.0
     *
     * @var Wordpress_Doodle_Loader Maintains and registers all hooks for the plugin.
     */
    protected $loader;

    /**
     * The unique identifier of this plugin.
     *
     * @since    1.0.0
     *
     * @var string The string used to uniquely identify this plugin.
     */
    protected $plugin_name;

    /**
     * The current version of the plugin.
     *
     * @since    1.0.0
     *
     * @var string The current version of the plugin.
     */
    protected $version;

    /**
     * Define the core functionality of the plugin.
     *
     * Set the plugin name and the plugin version that can be used throughout the plugin.
     * Load the dependencies, define the locale, and set the hooks for the admin area and
     * the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function __construct()
    {
        $this->plugin_name = 'wordpress-doodle';
        $this->version = '1.0.0';

        $this->load_dependencies();
        $this->set_locale();
        $this->define_admin_hooks();
        $this->define_public_hooks();
    }

    /**
     * Load the required dependencies for this plugin.
     *
     * Include the following files that make up the plugin:
     *
     * - Wordpress_Doodle_Loader. Orchestrates the hooks of the plugin.
     * - Wordpress_Doodle_i18n. Defines internationalization functionality.
     * - Wordpress_Doodle_Admin. Defines all hooks for the admin area.
     * - Wordpress_Doodle_Public. Defines all hooks for the public side of the site.
     *
     * Create an instance of the loader which will be used to register the hooks
     * with WordPress.
     *
     * @since    1.0.0
     */
    private function load_dependencies()
    {
        /**
         * The class responsible for orchestrating the actions and filters of the
         * core plugin.
         */
        require_once plugin_dir_path(dirname(__FILE__)).'includes/class-wordpress-doodle-loader.php';

        /**
         * The class responsible for defining internationalization functionality
         * of the plugin.
         */
        require_once plugin_dir_path(dirname(__FILE__)).'includes/class-wordpress-doodle-i18n.php';

        /**
         * The class responsible for defining all actions that occur in the admin area.
         */
        
        require_once( plugin_dir_path(dirname(__FILE__)) . 'vendor/autoload.php' );

        // Include WP's list table class
        require_once( ABSPATH . 'wp-admin/includes/class-wp-screen.php' );//added
        require_once( ABSPATH . 'wp-admin/includes/screen.php' );//added
        require_once( ABSPATH . 'wp-admin/includes/template.php' );
        

        require_once plugin_dir_path(dirname(__FILE__)).'admin/class-wordpress-doodle-admin.php';
        require_once plugin_dir_path(dirname(__FILE__)).'admin/class-wordpress-doodle-overview.php';

        /**
         * The class responsible for defining all actions that occur in the public-facing
         * side of the site.
         */
        require_once plugin_dir_path(dirname(__FILE__)).'public/class-wordpress-doodle-public.php';

        $this->loader = new Wordpress_Doodle_Loader();
    }

    /**
     * Define the locale for this plugin for internationalization.
     *
     * Uses the Wordpress_Doodle_i18n class in order to set the domain and to register the hook
     * with WordPress.
     *
     * @since    1.0.0
     */
    private function set_locale()
    {
        $plugin_i18n = new Wordpress_Doodle_i18n();

        $this->loader->add_action('plugins_loaded', $plugin_i18n, 'load_plugin_textdomain');
    }

    /**
     * Register all of the hooks related to the admin area functionality
     * of the plugin.
     *
     * @since    1.0.0
     */
    private function define_admin_hooks()
    {
        $plugin_admin = new Wordpress_Doodle_Admin($this->get_plugin_name(), $this->get_version());

        $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_styles', 999);
        $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts', 999);

        $this->loader->add_action('plugins_loaded', $plugin_admin, 'load_extensions');
        $this->loader->add_action('init', $plugin_admin, 'init');
        $this->loader->add_action('admin_menu', $plugin_admin, 'plugin_menu', 20);
        $this->loader->add_action('admin_action_create_text_poll', $plugin_admin, 'create_text_poll' );
        $this->loader->add_action('admin_action_create_dates_poll', $plugin_admin, 'create_dates_poll' );
        $this->loader->add_action('admin_action_delete_poll', $plugin_admin, 'delete_poll' );

    }

    /**
     * Register all of the hooks related to the public-facing functionality
     * of the plugin.
     *
     * @since    1.0.0
     */
    private function define_public_hooks()
    {
        $plugin_public = new Wordpress_Doodle_Public($this->get_plugin_name(), $this->get_version());

        $this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_styles');
        $this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_scripts');

        $this->loader->add_action('init', $plugin_public, 'init');
        $this->loader->add_action('init', $plugin_public, 'add_shortcode_doodle');
    }

    /**
     * Run the loader to execute all of the hooks with WordPress.
     *
     * @since    1.0.0
     */
    public function run()
    {
        $this->loader->run();
    }

    /**
     * The name of the plugin used to uniquely identify it within the context of
     * WordPress and to define internationalization functionality.
     *
     * @since     1.0.0
     *
     * @return string The name of the plugin.
     */
    public function get_plugin_name()
    {
        return $this->plugin_name;
    }

    /**
     * The reference to the class that orchestrates the hooks with the plugin.
     *
     * @since     1.0.0
     *
     * @return Wordpress_Doodle_Loader Orchestrates the hooks of the plugin.
     */
    public function get_loader()
    {
        return $this->loader;
    }

    /**
     * Retrieve the version number of the plugin.
     *
     * @since     1.0.0
     *
     * @return string The version number of the plugin.
     */
    public function get_version()
    {
        return $this->version;
    }
}