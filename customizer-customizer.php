<?php
/**
 * Plugin Name: Hide WP Customizer options
 * Description: A plugin to customize the WP Customizer
 * Version: 1.0.0
 * Author: PootlePress
 * Author URI: http://pootlepress.com/
 * Requires at least: 4.0.0
 * Tested up to: 4.0.0
 *
 * Text Domain: pp-customizer-customizer
 * Domain Path: /languages/
 *
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Returns the main instance of PP_Customizer_Customizer to prevent the need to use globals.
 *
 * @since  1.0.0
 * @return object PP_Customizer_Customizer
 */
function PP_Customizer_Customizer() {
	return PP_Customizer_Customizer::instance();
} // End PP_Customizer_Customizer()

PP_Customizer_Customizer();

/**
 * Main PP_Customizer_Customizer Class
 *
 * @class PP_Customizer_Customizer
 * @version	1.0.0
 * @since 1.0.0
 * @package	PP_Customizer_Customizer
 * @author Matty
 */
final class PP_Customizer_Customizer {
	/**
	 * PP_Customizer_Customizer The single instance of PP_Customizer_Customizer.
	 * @var 	object
	 * @access  private
	 * @since 	1.0.0
	 */
	private static $_instance = null;

	/**
	 * The token.
	 * @var     string
	 * @access  public
	 * @since   1.0.0
	 */
	public $token;

	/**
	 * The version number.
	 * @var     string
	 * @access  public
	 * @since   1.0.0
	 */
	public $version;

	/**
	 * The plugin directory URL.
	 * @var     string
	 * @access  public
	 * @since   1.0.0
	 */
	public $plugin_url;

	/**
	 * The plugin directory path.
	 * @var     string
	 * @access  public
	 * @since   1.0.0
	 */
	public $plugin_path;

	// Admin - Start
	/**
	 * The admin object.
	 * @var     object
	 * @access  public
	 * @since   1.0.0
	 */
	public $admin;

	/**
	 * The settings object.
	 * @var     object
	 * @access  public
	 * @since   1.0.0
	 */
	public $settings;
	// Admin - End

	// Post Types - Start
	/**
	 * The post types we're registering.
	 * @var     array
	 * @access  public
	 * @since   1.0.0
	 */
	public $post_types = array();
	// Post Types - End
	/**
	 * Constructor function.
	 * @access  public
	 * @since   1.0.0
	 * @return  void
	 */
	public function __construct () {
		$this->token 			= 'pp-customizer-customizer';
		$this->plugin_url 		= plugin_dir_url( __FILE__ );
		$this->plugin_path 		= plugin_dir_path( __FILE__ );
		$this->version 			= '1.0.0';

		// Admin - Start
		require_once( 'classes/class-pp-customizer-customizer-settings.php' );
			$this->settings = PP_Customizer_Customizer_Settings::instance();

		if ( is_admin() ) {
			require_once( 'classes/class-pp-customizer-customizer-admin.php' );
			$this->admin = PP_Customizer_Customizer_Admin::instance();
		}


		// Post Types - End
		register_activation_hook( __FILE__, array( $this, 'install' ) );

		add_action( 'init', array( $this, 'load_plugin_textdomain' ) );
	} // End __construct()

	/**
	 * Main PP_Customizer_Customizer Instance
	 *
	 * Ensures only one instance of PP_Customizer_Customizer is loaded or can be loaded.
	 *
	 * @since 1.0.0
	 * @static
	 * @see PP_Customizer_Customizer()
	 * @return Main PP_Customizer_Customizer instance
	 */
	public static function instance () {
		if ( is_null( self::$_instance ) )
			self::$_instance = new self();
		return self::$_instance;
	} // End instance()

	/**
	 * Load the localisation file.
	 * @access  public
	 * @since   1.0.0
	 * @return  void
	 */
	public function load_plugin_textdomain() {
		load_plugin_textdomain( 'pp-customizer-customizer', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
	} // End load_plugin_textdomain()

	/**
	 * Cloning is forbidden.
	 *
	 * @since 1.0.0
	 */
	public function __clone () {
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?' ), '1.0.0' );
	} // End __clone()

	/**
	 * Unserializing instances of this class is forbidden.
	 *
	 * @since 1.0.0
	 */
	public function __wakeup () {
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?' ), '1.0.0' );
	} // End __wakeup()

	/**
	 * Installation. Runs on activation.
	 * @access  public
	 * @since   1.0.0
	 * @return  void
	 */
	public function install () {
		$this->_log_version_number();
	} // End install()

	/**
	 * Log the plugin version number.
	 * @access  private
	 * @since   1.0.0
	 * @return  void
	 */
	private function _log_version_number () {
		// Log the version number.
		update_option( $this->token . '-version', $this->version );
	} // End _log_version_number()
} // End Class
?>
