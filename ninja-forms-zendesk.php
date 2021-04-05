<?php
/**
 * Plugin Name: Ninja Forms - Zendesk
 * Plugin URI: https://woocommerce.com/products/buy-one-get-one-free/
 * Description: Create tickets on Zendesk with Ninja Forms.
 * Version: 3.1.1
 * Author: Oscar Gare
 * Author URI: https://www.linkedin.com/in/oscargare
 * Developer: Oscar Gare
 * Developer URI: https://www.linkedin.com/in/oscargare
 * Text Domain: nf-zendesk
 * Domain Path: /languages/
 *
 * Requires at least: 4.4
 * Tested up to: 5.6
 *
 * @package NF_Zendesk
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Define NF_ZENDESK_FILE.
if ( ! defined( 'NF_ZENDESK_FILE' ) ) {
	define( 'NF_ZENDESK_FILE', __FILE__ );
}

if ( ! class_exists( 'NF_Zendesk' ) ) {
	include_once dirname( __FILE__ ) . '/includes/class-nf-zendesk.php';
	NF_Zendesk::init();
}
