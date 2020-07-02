<?php
/**
 * This file contains functions and hooks for styling Hootkit plugin
 *   Hootkit is a free plugin released under GPL license and hosted on wordpress.org.
 *   It is recommended to the user via wp-admin using TGMPA class
 *
 * This file is loaded at 'after_setup_theme' action @priority 10 ONLY IF hootkit plugin is active
 *
 * @package    Unos Business
 * @subpackage HootKit
 */

// Add theme's hootkit styles.
// Changing priority to >11 has added benefit of loading child theme's stylesheet before hootkit style.
// This is preferred in case of pre-built child themes where we want child stylesheet to come before
// dynamic css (not after like in the case of user blank child themes purely used for customizations)
add_action( 'wp_enqueue_scripts', 'unosbiz_enqueue_hootkit', 15 );

// Set dynamic css handle to child theme's hootkit
// if HK active : earlier set to hootkit@parent @priority 5; set to child stylesheet @priority 7
// Dynamic is hooked to child stylesheet in main functions file. We modify it here for when HootKit is
// active to load dynamic after hootkit stylesheet (which is loaded after child stylesheet - see above)
add_filter( 'hoot_style_builder_inline_style_handle', 'unosbiz_dynamic_css_hootkit_handle', 9 );

// Add dynamic CSS for hootkit
// Priority@12: 10-> base hootkit lite/prim
add_action( 'hoot_dynamic_cssrules', 'unosbiz_hootkit_dynamic_cssrules', 12 );

/**
 * Enqueue Scripts and Styles
 *
 * @since 1.0
 * @access public
 * @return void
 */
if ( !function_exists( 'unosbiz_enqueue_hootkit' ) ) :
function unosbiz_enqueue_hootkit() {

	/* 'unos-hootkit' is loaded using 'hoot_locate_style' which loads child theme location. Hence deregister it and load files again */
	wp_deregister_style( 'unos-hootkit' );
	/* Load Hootkit Style - Add dependency so that hotkit is loaded after */
	if ( file_exists( hoot_data()->template_dir . 'hootkit/hootkit.css' ) )
	wp_enqueue_style( 'unos-hootkit', hoot_data()->template_uri . 'hootkit/hootkit.css', array( 'hoot-style' ), hoot_data()->template_version );
	if ( file_exists( hoot_data()->child_dir . 'hootkit/hootkit.css' ) )
	wp_enqueue_style( 'unosbiz-hootkit', hoot_data()->child_uri . 'hootkit/hootkit.css', array( 'hoot-style', 'unos-hootkit' ), hoot_data()->childtheme_version );

}
endif;

/**
 * Set dynamic css handle to hootkit
 *
 * @since 1.0
 * @access public
 * @return void
 */
if ( !function_exists( 'unosbiz_dynamic_css_hootkit_handle' ) ) :
function unosbiz_dynamic_css_hootkit_handle( $handle ) {
	return 'unosbiz-hootkit';
}
endif;

/**
 * Custom CSS built from user theme options for hootkit features
 *
 * @since 1.0
 * @access public
 */
if ( !function_exists( 'unosbiz_hootkit_dynamic_cssrules' ) ) :
function unosbiz_hootkit_dynamic_cssrules() {

	global $hoot_style_builder;

	// Get user based style values
	$styles = unos_user_style(); // echo '<!-- '; print_r($styles); echo ' -->';
	extract( $styles );

	$hoot_style_builder->remove( array(
		'.social-icons-icon',
		'#topbar .social-icons-icon, #page-wrapper .social-icons-icon',
	) );

	/*** Add Dynamic CSS ***/

}
endif;

/**
 * Modify Posts List default style
 *
 * @since 1.0
 * @param array $settings
 * @return string
 */
function unosbiz_posts_list_widget_settings( $settings ) {
	if ( isset( $settings['form_options']['firstpost']['fields']['size']['std'] ) )
		$settings['form_options']['firstpost']['fields']['size']['std'] = 'small';
	return $settings;
}
add_filter( 'hootkit_posts_list_widget_settings', 'unosbiz_posts_list_widget_settings', 5 );

/**
 * Modify Post Grid default style
 *
 * @since 1.0
 * @param array $settings
 * @return string
 */
function unosbiz_post_grid_widget_settings( $settings ) {
	if ( isset( $settings['form_options']['columns']['std'] ) )
		$settings['form_options']['columns']['std'] = '4';
	return $settings;
}
add_filter( 'hootkit_post_grid_widget_settings', 'unosbiz_post_grid_widget_settings', 5 );

/**
 * Modify Ticker and Ticker Posts default style
 *
 * @since 1.0
 * @param array $settings
 * @return string
 */
function unosbiz_ticker_posts_widget_settings( $settings ) {
	if ( isset( $settings['form_options']['background'] ) )
		$settings['form_options']['background']['std'] = '#f1f1f1';
	if ( isset( $settings['form_options']['fontcolor'] ) )
		$settings['form_options']['fontcolor']['std'] = '#248ed0';
	return $settings;
}
add_filter( 'hootkit_ticker_widget_settings', 'unosbiz_ticker_posts_widget_settings', 5 );
add_filter( 'hootkit_ticker_posts_widget_settings', 'unosbiz_ticker_posts_widget_settings', 5 );

/**
 * Filter Ticker and Ticker Posts display Title markup
 *
 * @since 1.0
 * @param array $settings
 * @return string
 */
function unosbiz_hootkit_widget_title( $display, $title, $context, $icon = '' ) {
	if ( $context == 'ticker-posts' || $context == 'ticker' )
		$display = '<div class="ticker-title accent-typo">' . $icon . $title . '</div>';
	return $display;
}
add_filter( 'hootkit_widget_ticker_title', 'unosbiz_hootkit_widget_title', 5, 4 );