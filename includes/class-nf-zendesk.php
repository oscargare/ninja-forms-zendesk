<?php
/**
 * Plugin main class.
 *
 * @package NF_Zendesk
 */

defined( 'ABSPATH' ) || exit;

/**
 * Main Ninja Forms Zendesk Class
 */
class NF_Zendesk {

	/**
	 * Plugin version.
	 *
	 * @var string
	 */
	public static $version = '3.1.0';

	/**
	 * Admin notices.
	 *
	 * @var array
	 */
	private static $admin_notices = array();

	/**
	 * Init plugin
	 *
	 * @since 1.0
	 */
	public static function init() {
		add_action( 'plugins_loaded', array( __CLASS__, 'init_plugin' ), 0 );
	}

	/**
	 * Init plugin
	 */
	public static function init_plugin() {
		if ( ! self::check_environment() ) {
			return;
		}
		// Include files.
		include_once dirname( __FILE__ ) . '/api/class-nf-zendesk-api.php';

		// Add hooks.
		add_filter( 'ninja_forms_register_actions', array( __CLASS__, 'register_actions' ) );
		add_action( 'ninja_forms_builder_templates', array( __CLASS__, 'builder_templates' ) );
	}

	/**
	 * Checks the environment for compatibility problems.
	 *
	 * @return boolean
	 */
	private static function check_environment() {

		self::$admin_notices = array();

		if ( ! class_exists( 'Ninja_Forms' ) ) {
			// translators: HTML Tags.
			self::$admin_notices[] = sprintf( __( '%1$sNinja Forms Zendesk extension%2$s requires the Ninja Form plugin to be activated to work.', 'nf-zendesk' ), '<strong>', '</strong>' );
			return false;
		}

		if ( version_compare( Ninja_Forms::VERSION, '3.0', '<' ) ) {
			// translators: HTML Tags.
			self::$admin_notices[] = sprintf( __( 'Ninja Forms Zendesk extension - The minimum Ninja Form version required for this plugin is %1$s. You are running %2$s.', 'nf-zendesk' ), '3.0', Ninja_Forms::VERSION );
			return false;
		}

		return true;
	}

	/**
	 * Config
	 *
	 * @param string $file_name File name.
	 * @return array
	 */
	public static function config( $file_name ) {
		$config = array();
		$path   = dirname( __FILE__ ) . '/config/nf-' . str_replace( '_', '-', $file_name ) . '.php';
		if ( file_exists( $path ) ) {
			$config = include_once $path;
			$config = is_array( $config ) ? $config : array();
		}
		return $config;
	}

	/**
	 * Register the action.
	 *
	 * @param array $actions Array of actions.
	 */
	public static function register_actions( $actions ) {
		$actions = is_array( $actions ) ? $actions : array();

		include_once dirname( __FILE__ ) . '/actions/class-nf-zendesk-action.php';
		$actions['zendesk'] = new NF_Zendesk_Action();
		return $actions;
	}

	/**
	 * Output builder templates.
	 */
	public static function builder_templates() {
		include_once dirname( __FILE__ ) . '/templates/nf-zendesk-custom-fields.html.php';
	}
}
