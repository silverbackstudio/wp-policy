<?php
/**
* Plugin Name: Silverback Privacy Policies
* Plugin URI: https://github.com/silverbackstudio/wp-privacy-policy
* Description: Send Wordpress emails through Email Services API with templates
* Author: Silverback Studio
* Version: 1.0.0
* Author URI: http://www.silverbackstudio.it/
* Text Domain: svbk-privacy
* @package Silverback Privacy Policies Plugin
* @version 1.1
*/

use Svbk\WP\Privacy as WP_Privacy; 

defined( 'ABSPATH' ) || exit;

define( 'SVBK_POLICY_BLOCKS_DIR', plugin_dir_path( __FILE__ ) . 'src/blocks/' );

/**
 * If used as standalone plugin trigger autoloading
 */
if ( file_exists( __DIR__ . '/vendor/autoload.php' ) ) {
	require_once __DIR__ . '/vendor/autoload.php';
} 

require __DIR__ . '/src/providers/ProviderInterface.php';
require __DIR__ . '/src/providers/File.php';

/**
 * Load all translations for our plugin from the MO file.
*/
add_action( 'init', 'svbk_policy_load_textdomain' );

function svbk_policy_load_textdomain() {
	load_plugin_textdomain( 'svbk-wp-policy', false, basename( __DIR__ ) . '/languages' );
}

/**
 * Registers all blocks
 */
function svbk_policy_register_block() {
	register_block_type( 'svbk/privacy-policy', include( SVBK_POLICY_BLOCKS_DIR . 'privacy-policy/index.php') );
	register_block_type( 'svbk/cookie-policy', include( SVBK_POLICY_BLOCKS_DIR . 'cookie-policy/index.php') );
}

add_action( 'init', 'svbk_policy_register_block');

/**
 * Registers all block assets so that they can be enqueued through Gutenberg in
 * the corresponding context.
 *
 * Passes translations to JavaScript.
 */
function svbk_policy_blocks_editor_assets() {

	// automatically load dependencies and version
	$asset_file = include( plugin_dir_path( __FILE__ ) . 'build/index.asset.php');

	wp_register_script(
		'svbk-policy-blocks',
		plugins_url( 'build/index.js', __FILE__ ),
		array_merge($asset_file['dependencies'], array( 'wp-blocks', 'wp-components', 'wp-editor') ),
		$asset_file['version']
	);

	wp_enqueue_style(
		'svbk-policy-blocks-editor',
		plugins_url( 'build/editor.css', __FILE__ ),
		$asset_file['version']
	);

	if ( function_exists( 'wp_set_script_translations' ) ) {
		/**
		 * May be extended to wp_set_script_translations( 'my-handle', 'my-domain',
		 * plugin_dir_path( MY_PLUGIN ) . 'languages' ) ). For details see
		 * https://make.wordpress.org/core/2018/11/09/new-javascript-i18n-support-in-wordpress/
		 */
		wp_set_script_translations( 'svbk-policy-blocks', 'svbk-wp-policy', plugin_dir_path( __FILE__ ) . 'languages' );
	}

}

add_action( 'enqueue_block_editor_assets', 'svbk_policy_blocks_editor_assets' );

/**
 * Registers frontend scripts and assets 
 */
function svbk_policy_scripts() {

	wp_enqueue_style(
		'svbk-policy-blocks',
		plugins_url( 'build/style.css', __FILE__ )
	);

}

add_action( 'wp_enqueue_scripts', 'svbk_policy_scripts' );



/**
 * Set default Privacy Policy page content
 *
 * @param string $privacy_content 	The WP generated policy content
 * @return string
 */
function svbk_policy_default_privacy_content($privacy_content){
	
	$provider = svbk_policy_get_provider();

	if ( $provider ) {
		return 
		'<!-- wp:heading -->' .
		'<h2> ' . __('Privacy Policy', 'svbk-wp-policy') . ' </h2>' .
		'<!-- /wp:heading -->' .

		'<!-- wp:svbk/privacy-policy /-->';
	}

    return $provider_content;
}
add_filter( 'wp_get_default_privacy_policy_content', 'svbk_policy_default_privacy_content' );


/**
 * Retrieves the policy content
 *
 * @param string 	$name		The policy name (identifier)
 * @param array		$attributes	The attributes used to configure the policy
 * @return void
 */
function svbk_policy_content($name, $attributes){
	
	$provider = svbk_policy_get_provider();	

	if ( empty( $attributes['language'] ) ) {
		$attributes['language'] = get_locale();
	}

	$attributes = apply_filters( 'svbk_policy_attributes', $attributes, $name );

	$provider_content = $provider->getPolicyContent($name, $attributes);

	$search = array_map( 'svbk_policy_attribute_placeholder', array_keys($attributes));
	$replace = array_values($attributes);

	$content = str_replace( $search, $replace, $provider_content );
	
    return apply_filters( 'svbk_policy_content', $content, $name, $attributes);
}

/**
 * Wraps attribute in it's placeholder
 *
 * @param string $name 	Attribute name
 * @return void
 */
function svbk_policy_attribute_placeholder($name){
	return '{{' . $name . '}}';
}

/**
 * Return the currently configured provider
 *
 * @return void
 */
function svbk_policy_get_provider(){
	$provider = new \Svbk\WP\Privacy\Providers\File;
	return apply_filters('svbk_policy_provider', $provider );
}

/**
 * Shortcode
 *
 * @param array	 $atts 	Shortcode attributes
 * @return string	
 */
function svbk_policy_shortcode( $atts ) {
	
	$a = shortcode_atts( array(
		'name' => 'privacy-policy',
		'email' => '',
		'address' => '',
		'company' => '',
		'phone' => '',
	), $atts );

	return svbk_policy_content($a['name'], $a);
}

add_shortcode( 'svbk-policy', 'svbk_policy_shortcode' );

/**
 * Block Editor category filter
 *
 * @param array $categories
 * @param int	$post
 * @return array
 */
function svbk_policy_block_category( $categories, $post ) {
	return array_merge(
		$categories,
		array(
			array(
				'slug' => 'policy',
				'title' => __( 'Policy', 'svbk-wp-policy' ),
			),
		)
	);
}
add_filter( 'block_categories', 'svbk_policy_block_category', 10, 2);