<?php
/**
 * Plugin Name: Fbs Elementor Add On
 * Plugin URI: https://chitabd.com
 * Description: Some elementor widgets
 * Author: Fazle Bari
 * Author URI: https://chitabd.com/fazlebari
 * Tags: woocommerce product,woocommerce product table, product table, elementor
 * 
 * Version: 1.0.0
 * Requires at least:    4.0.0
 * Tested up to:         5.5.1
 * WC requires at least: 3.0.0
 * WC tested up to: 	 4.5.2
 * 
 * Text Domain: fbsele
 * Domain Path: /languages/
 */

 if( ! defined( 'ABSPATH' ) ) exit();

 /**
 * Elementor Extension main CLass
 * @since 1.0.0
 */
final class FbseleWidget {

    // Plugin version
    const VERSION = '1.0.0';

    // Minimum Elementor Version
    const MINIMUM_ELEMENTOR_VERSION = '2.0.0';

    // Minimum PHP Version
    const MINIMUM_PHP_VERSION = '7.0';

    // Instance
    private static $_instance = null;

    /**
    * SIngletone Instance Method
    * @since 1.0.0
    */
    public static function instance() {
        if( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
    * Construct Method
    * @since 1.0.0
    */
    public function __construct() {
        // Call Constants Method
        $this->FbseleWidget();
        add_action( 'wp_enqueue_scripts', [ $this, 'fbslele_style_script' ] );
        add_action( 'init', [ $this, 'i18n' ] );
        add_action( 'plugins_loaded', [ $this, 'init' ] );
    }

    /**
    * Define Plugin Constants
    * @since 1.0.0
    */
    public function FbseleWidget() {
        define( 'FBSELE_PLUGIN_URL', trailingslashit( plugins_url( '/', __FILE__ ) ) );
        define( 'FBSELE_PLUGIN_PATH', trailingslashit( plugin_dir_path( __FILE__ ) ) );
    }

    /**
    * Load Scripts & Styles
    * @since 1.0.0
    */
    public function fbslele_style_script() {
        wp_register_style( 'fbsele-style', FBSELE_PLUGIN_URL . 'assets/css/public.css', [], rand(), 'all' );
        wp_register_script( 'fbsele-script', FBSELE_PLUGIN_URL . 'assets/js/public.js', [ 'jquery' ], rand(), true );

        wp_enqueue_style( 'fbsele-style' );
        wp_enqueue_script( 'fbsele-script' );
    }

    /**
    * Load Text Domain
    * @since 1.0.0
    */
    public function i18n() {
       load_plugin_textdomain( 'fbsele', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
    }

    /**
    * Initialize the plugin
    * @since 1.0.0
    */
    public function init() {

        // Check if the ELementor installed and activated
        if( ! did_action( 'elementor/loaded' ) ) {
            add_action( 'admin_notices', [ $this, 'AdminNoticeMissingMainPlugin' ] );
            return;
        }

        add_action( 'elementor/init', [ $this, 'initCategory' ] );
        add_action( 'elementor/widgets/widgets_registered', [ $this, 'initWidgets' ] );
    }

    /**
    * Init Widgets
    * @since 1.0.0
    */
    public function initWidgets() {
        require_once FBSELE_PLUGIN_PATH . '/widgets/example.php';
    }

    /**
    * Init Category Section
    * @since 1.0.0
    */
    public function initCategory() {
        Elementor\Plugin::instance()->elements_manager->add_category(
            'fbsele-for-elementor',
            [
                'title' => 'Fbs Elementor Widgets'
            ],
            1
        );
    }

    /**
    * Admin Notice
    * Warning when the site doesn't have Elementor installed or activated
    * @since 1.0.0
    */
    public function AdminNoticeMissingMainPlugin() {
        if( isset( $_GET[ 'activate' ] ) ) unset( $_GET[ 'activate' ] );
        $message = sprintf(
            esc_html__( '"%1$s" requires "%2$s" to be installed and activated', 'my-elementor-widget' ),
            '<strong>'.esc_html__( 'Fbs Elementor Add On', 'my-elementor-widget' ).'</strong>',
            '<strong>'.esc_html__( 'Elementor', 'my-elementor-widget' ).'</strong>'
        );

        printf( '<div class="notice notice-warning is-dimissible"><p>%1$s</p></div>', $message );
    }


}

FbseleWidget::instance();