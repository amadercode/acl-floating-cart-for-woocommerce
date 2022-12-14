<?php

if (!defined('ABSPATH')) exit;

class ACL_FoCaWo_Plugin
{

    /**
     * The single instance of ACL_FoCaWo_Plugin.
     * @var    object
     * @access  private
     * @since    1.0.0
     */
    private static $_instance = null;

    /**
     * Settings class object
     * @var     object
     * @access  public
     * @since   1.0.0
     */
    public $settings = null;

    /**
     * The version number.
     * @var     string
     * @access  public
     * @since   1.0.0
     */
    public $_version;

    /**
     * The token.
     * @var     string
     * @access  public
     * @since   1.0.0
     */
    public $_token;

    /**
     * The main plugin file.
     * @var     string
     * @access  public
     * @since   1.0.0
     */
    public $file;

    /**
     * The main plugin directory.
     * @var     string
     * @access  public
     * @since   1.0.0
     */
    public $dir;

    /**
     * The plugin assets directory.
     * @var     string
     * @access  public
     * @since   1.0.0
     */
    public $assets_dir;

    /**
     * The plugin assets URL.
     * @var     string
     * @access  public
     * @since   1.0.0
     */
    public $assets_url;

    /**
     * Suffix for Javascripts.
     * @var     string
     * @access  public
     * @since   1.0.0
     */
    public $image_path;

    /**
     * Suffix for Javascripts.
     * @var     string
     * @access  public
     * @since   1.0.0
     */
    public $script_suffix;

    /**
     * Constructor function.
     * @access  public
     * @return  void
     * @since   1.0.0
     */
    public function __construct($file = '', $version = '1.0.0')
    {
        $this->_version = $version;
        $this->_token = 'acl_focawo';
        //Includes all files
        $this->includes();
        //installtion
        // Load plugin environment variables
        $this->file = $file;
        $this->dir = dirname($this->file);
        $this->assets_dir = trailingslashit($this->dir) . 'assets';
        $this->assets_url = esc_url(trailingslashit(plugins_url('/assets/', $this->file)));
        $this->image_path = esc_url(trailingslashit(plugins_url('/assets/images/', $this->file)));

        $this->script_suffix = '';
        //$this->script_suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
        // Load frontend JS & CSS
        add_action('wp_enqueue_scripts', array($this, 'enqueue_styles'), 10);
        add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'), 10);

        // Load admin JS & CSS
        if (isset($_GET['page']) && ($_GET['page'] == "acl-floating-cart")) {
            add_action('admin_enqueue_scripts', array($this, 'admin_enqueue_scripts'), 10, 1);
            add_action('admin_enqueue_scripts', array($this, 'admin_enqueue_styles'), 10, 1);
        }


        // Load API for generic admin functions
        if (is_admin()) {
            $this->admin = new ACL_FoCaWo_Admin_API();
        }

        // Handle localisation
        $this->load_plugin_textdomain();
        add_action('init', array($this, 'load_localisation'), 0);
    } // End __construct ()

    /**
     * Include required core files used in admin and on the frontend.
     */
    public function includes()
    {
        /**
         * admin.
         */
        // include_once ACL_FOCAWO_ABSPATH . 'includes/class-focawo-install.php';
        include_once ACL_FOCAWO_ABSPATH . 'includes/admin/focawo-settings.php';
        include_once ACL_FOCAWO_ABSPATH . 'includes/admin/focawo-admin-api.php';
        /**
         * operations.
         */
        include_once ACL_FOCAWO_ABSPATH . 'includes/class-focawo-operation.php';


    }

    /**
     * Load frontend CSS.
     * @access  public
     * @return void
     * @since   1.0.0
     */
    public function enqueue_styles()
    {
        //wp_register_style( $this->_token . '-bootstrap-grid', esc_url( $this->assets_url ) . 'css/bootstrap-grid.css', array(), $this->_version );
        //wp_enqueue_style( $this->_token . '-bootstrap-grid');
         $template=get_option('acl_focawo_templates')!=""?get_option('acl_focawo_templates'):'01';
         wp_register_style($this->_token . '-frontend', esc_url($this->assets_url) . 'css/template-'.$template.'.css', array(), $this->_version);
         wp_enqueue_style($this->_token . '-frontend');

    } // End enqueue_styles ()

    /**
     * Load frontend Javascript.
     * @access  public
     * @return  void
     * @since   1.0.0
     */
    public function enqueue_scripts()
    {

        wp_register_script($this->_token . '-frontend', esc_url($this->assets_url) . 'js/frontend' . $this->script_suffix . '.js', array('jquery'), $this->_version);

        wp_enqueue_script($this->_token . '-frontend');

        wp_localize_script($this->_token . '-frontend', 'focawo_ajax_object',
            array(
                'ajax_url' => admin_url('admin-ajax.php'),
                'prouct_per_page' => get_option('acl_focawo_product_per_page'),
                'image_path' => $this->image_path,
            )
        );

    } // End enqueue_scripts ()

    /**
     * Load admin CSS.
     * @access  public
     * @return  void
     * @since   1.0.0
     */
    public function admin_enqueue_styles($hook = '')
    {
        wp_register_style($this->_token . '-admin', esc_url($this->assets_url) . 'css/admin.css', array(), $this->_version);
        wp_enqueue_style($this->_token . '-admin');
    } // End admin_enqueue_styles ()

    /**
     * Load admin Javascript.
     * @access  public
     * @return  void
     * @since   1.0.0
     */
    public function admin_enqueue_scripts($hook = '')
    {
        wp_register_script($this->_token . '-admin', esc_url($this->assets_url) . 'js/admin' . $this->script_suffix . '.js', array('jquery'), $this->_version);
        wp_enqueue_script($this->_token . '-admin');
        wp_localize_script($this->_token . '-admin', 'focawo_admin_object',
            array(
                'ajax_url' => admin_url('admin-ajax.php'),
                'prouct_per_page' => get_option('acl_focawo_product_per_page'),
                'image_path' => $this->image_path,
            )
        );
        // WordPress  Media library
        wp_enqueue_media();
    } // End admin_enqueue_scripts ()

    /**
     * Load plugin localisation
     * @access  public
     * @return  void
     * @since   1.0.0
     */
    public function load_localisation()
    {
        load_plugin_textdomain('acl-floating-cart', false, dirname(plugin_basename($this->file)) . '/lang/');
    } // End load_localisation ()

    /**
     * Load plugin textdomain
     * @access  public
     * @return  void
     * @since   1.0.0
     */
    public function load_plugin_textdomain()
    {
        $domain = 'acl-floating-cart';

        $locale = apply_filters('plugin_locale', get_locale(), $domain);

        load_textdomain($domain, WP_LANG_DIR . '/' . $domain . '/' . $domain . '-' . $locale . '.mo');
        load_plugin_textdomain($domain, false, dirname(plugin_basename($this->file)) . '/lang/');
    } // End load_plugin_textdomain ()

    /**
     * Main FOCAWO_Plugin Instance
     *
     * Ensures only one instance of FOCAWO_Plugin is loaded or can be loaded.
     *
     * @return Main FOCAWO_Plugin instance
     * @see FOCAWO_Plugin()
     * @since 1.0.0
     * @static
     */
    public static function instance($file = '', $version = '1.0.0')
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new self($file, $version);
        }
        return self::$_instance;
    } // End instance ()

    /**
     * Cloning is forbidden.
     *
     * @since 1.0.0
     */
    public function __clone()
    {
        _doing_it_wrong(__FUNCTION__, __('Cheatin&#8217; huh?'), $this->_version);
    } // End __clone ()

    /**
     * Unserializing instances of this class is forbidden.
     *
     * @since 1.0.0
     */
    public function __wakeup()
    {
        _doing_it_wrong(__FUNCTION__, __('Cheatin&#8217; huh?'), $this->_version);
    } // End __wakeup ()

    /**
     * Installation. Runs on activation.
     * @access  public
     * @return  void
     * @since   1.0.0
     */
    public function install()
    {
        $this->_log_version_number();
    } // End install ()

    /**
     * Log the plugin version number.
     * @access  public
     * @return  void
     * @since   1.0.0
     */
    private function _log_version_number()
    {
        update_option($this->_token . '_version', $this->_version);
    } // End _log_version_number ()

}