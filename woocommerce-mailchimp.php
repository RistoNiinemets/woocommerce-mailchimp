<?php
/**
 * Plugin Name: WooCommerce MailChimp
 * Plugin URI: http://anderly.com/woocommerce-mailchimp
 * Description: WooCommerce MailChimp provides simple MailChimp integration for WooCommerce.
 * Author: Adam Anderly
 * Author URI: http://anderly.com
 * Version: 1.4
 * Text Domain: ss_wc_mailchimp
 * Domain Path: languages
 *
 * Copyright: � 2015 Adam Anderly
 * License: GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 *
 * MailChimp Docs: http://apidocs.mailchimp.com/
 */


function woocommerce_mailchimp_init() {

	if ( ! class_exists( 'WC_Integration' ) )
		return;

	load_plugin_textdomain( 'ss_wc_mailchimp', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );

	if ( ! defined( 'WOOCOMMERCE_MAILCHIMP_SETTINGS_URL' ) ) {
		define( 'WOOCOMMERCE_MAILCHIMP_SETTINGS_URL', admin_url( 'admin.php?page=wc-settings&tab=integration&section=mailchimp' ) );
	}

	include_once( 'classes/class-ss-wc-integration-mailchimp.php' );

	/**
	 * Add the Integration to WooCommerce
	 */
	function add_mailchimp_integration($methods) {
		$methods[] = 'SS_WC_Integration_MailChimp';

		return $methods;
	}

	add_filter( 'woocommerce_integrations', 'add_mailchimp_integration' );

	/**
	 * Add Settings link to plugins list
	 *
	 * @param  array $links Plugin links
	 * @return array        Modified plugin links
	 */
	function action_links( $links ) {
		$plugin_links = array(
			'<a href="' . WOOCOMMERCE_MAILCHIMP_SETTINGS_URL . '">' . __( 'Settings', 'ss_wc_mailchimp' ) . '</a>',
		);

		return array_merge( $plugin_links, $links );
	}

	// Add the "Settings" links on the Plugins administration screen
	add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'action_links' );
}
add_action( 'plugins_loaded', 'woocommerce_mailchimp_init', 0 );
