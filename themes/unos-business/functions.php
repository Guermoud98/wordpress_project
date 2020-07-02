<?php
/**
 *                  _   _             _   
 *  __      ___ __ | | | | ___   ___ | |_ 
 *  \ \ /\ / / '_ \| |_| |/ _ \ / _ \| __|
 *   \ V  V /| |_) |  _  | (_) | (_) | |_ 
 *    \_/\_/ | .__/|_| |_|\___/ \___/ \__|
 *           |_|                          
 *
 * :: Theme's main functions file ::::::::::::
 * :: Initialize and setup the theme :::::::::
 *
 * Hooks, Actions and Filters are used throughout this theme. You should be able to do most of your
 * customizations without touching the main code. For more information on hooks, actions, and filters
 * @see http://codex.wordpress.org/Plugin_API
 *
 * @package    Unos Business
 */


/* === Theme Setup === */


/**
 * Theme Setup
 *
 * @since 1.0
 * @access public
 * @return void
 */
function unosbiz_theme_setup(){

	// Load theme's Hootkit functions if plugin is active
	if ( class_exists( 'HootKit' ) && file_exists( hoot_data()->child_dir . 'hootkit/functions.php' ) )
		include_once( hoot_data()->child_dir . 'hootkit/functions.php' );

	// Load the about page.
	if ( apply_filters( 'unosbiz_load_about', file_exists( hoot_data()->child_dir . 'admin/about.php' ) ) )
		require_once( hoot_data()->child_dir . 'admin/about.php' );

}
add_action( 'after_setup_theme', 'unosbiz_theme_setup', 10 );

/**
 * Set dynamic css handle to child stylesheet
 * if HK active : earlier set to hootkit@parent @priority 5; set to hootkit@child @priority 9
 * This is preferred in case of pre-built child themes where we want child stylesheet to come before
 * dynamic css (not after like in the case of user blank child themes purely used for customizations)
 *
 * @since 1.0
 * @access public
 * @return string
 */
if ( !function_exists( 'unosbiz_dynamic_css_child_handle' ) ) :
function unosbiz_dynamic_css_child_handle( $handle ) {
	return 'hoot-child-style';
}
endif;
add_filter( 'hoot_style_builder_inline_style_handle', 'unosbiz_dynamic_css_child_handle', 7 );

/**
 * Unload Template's About Page
 *
 * @since 1.0
 * @access public
 * @return bool
 */
function unosbiz_unload_template_about( $load ) {
	return false;
}
add_filter( 'unos_load_about', 'unosbiz_unload_template_about', 5 );

/**
 * Add child theme's hook for unloading About page
 *
 * @since 1.0
 * @access public
 * @return array
 */
function unosbiz_unload_about( $hooks ) {
	if ( is_array( $hooks ) )
		$hooks[] = 'unosbiz_load_about';
	return $hooks;
}
add_filter( 'unos_unload_upsell', 'unosbiz_unload_about', 5 );

/**
 * Modify custom-header
 * Priority@5 to come before 10 used by unos for adding support
 *    @ref wp-includes/theme.php #2440
 *    // Merge in data from previous add_theme_support() calls.
 *    // The first value registered wins. (A child theme is set up first.)
 * For remove_theme_support, use priority@15
 *
 * @since 1.0
 * @access public
 * @return void
 */
function unosbiz_custom_header() {
	add_theme_support( 'custom-header', array(
		'width' => 1440,
		'height' => 500,
		'flex-height' => true,
		'flex-width' => true,
		'default-image' => '',
		'header-text' => false
	) );
}
add_filter( 'after_setup_theme', 'unosbiz_custom_header', 5 );


/* === Attr === */


/**
 * Topbar meta attributes.
 * Priority@10: 7-> base lite ; 9-> base prim
 *
 * @since 1.0
 * @param array $attr
 * @param string $context
 * @return array
 */
function unosbiz_attr_topbar( $attr, $context ) {
	if ( !empty( $attr['classes'] ) )
		$attr['classes'] = str_replace( 'social-icons-invert', '', $attr['classes'] );
	return $attr;
}
add_filter( 'hoot_attr_topbar', 'unosbiz_attr_topbar', 10, 2 );

/**
 * Loop meta attributes.
 * Priority@10: 7-> base lite ; 9-> base prim
 *
 * @since 1.0
 * @param array $attr
 * @param string $context
 * @return array
 */
function unosbiz_attr_premium_loop_meta_wrap( $attr, $context ) {
	$attr['class'] = ( empty( $attr['class'] ) ) ? '' : $attr['class'];

	/* Overwrite all and apply background class for both */
	$attr['class'] = str_replace( array( 'loop-meta-wrap pageheader-bg-default', 'loop-meta-wrap pageheader-bg-stretch', 'loop-meta-wrap pageheader-bg-incontent', 'loop-meta-wrap pageheader-bg-both', 'loop-meta-wrap pageheader-bg-none', ), '', $attr['class'] );
	$attr['class'] .= ' loop-meta-wrap pageheader-bg-both';

	return $attr;
}
add_filter( 'hoot_attr_loop-meta-wrap', 'unosbiz_attr_premium_loop_meta_wrap', 10, 2 );


/* === Dynamic CSS === */


/**
 * Custom CSS built from user theme options
 * For proper sanitization, always use functions from library/sanitization.php
 * Priority@6: 5-> base lite ; 7-> base prim prepare (rules removed) ;
 *             9-> base prim ; 10-> base hootkit lite/prim
 *
 * @since 1.0
 * @access public
 */
function unosbiz_dynamic_cssrules() {

	global $hoot_style_builder;

	// Get user based style values
	$styles = unos_user_style(); // echo '<!-- '; print_r($styles); echo ' -->';
	extract( $styles );

	hoot_add_css_rule( array(
						'selector'  => '#topbar',
						'property'  => array(
							'background' => array( 'none' ),    // $accent_color
							'color'      => array( 'inherit' ), // $accent_font
							),
					) );

	hoot_add_css_rule( array(
						'selector'  => '#topbar.js-search .searchform.expand .searchtext',
						'property'  => 'background',
						'value'     => $content_bg_color, // $accent_color
					) );
	hoot_add_css_rule( array(
						'selector'  => '#topbar.js-search .searchform.expand .searchtext' . ',' . '#topbar .js-search-placeholder',
						'property'  => 'color',
						'value'     => 'inherit', // $accent_font
					) );

	$hoot_style_builder->remove( array(
		'#main.main' . ',' . '.below-header',
	) );

	hoot_add_css_rule( array(
						'selector'  => '#main.main',
						'property'  => 'background',
						'value'     => $content_bg_color,
					) );

	$hoot_style_builder->remove( array(
		'.menu-items li.current-menu-item, .menu-items li.current-menu-ancestor, .menu-items li:hover',
		'.menu-items li.current-menu-item > a, .menu-items li.current-menu-ancestor > a, .menu-items li:hover > a',
	) );
	hoot_add_css_rule( array(
						'selector'  => '#header .menu-items li.current-menu-item, #header .menu-items li.current-menu-ancestor, #header .menu-items li:hover', // Replaces '.menu-items li.current-menu-item, .menu-items li.current-menu-ancestor, .menu-items li:hover' . ',' . '#header-supplementary .menu-items li.current-menu-item, #header-supplementary .menu-items li.current-menu-ancestor, #header-supplementary .menu-items li:hover',
						'property'  => 'background',
						'value'     => $accent_color,
						'idtag'     => 'accent_color'
					) );
	hoot_add_css_rule( array(
						'selector'  => '#header .menu-items li.current-menu-item > a, #header .menu-items li.current-menu-ancestor > a, #header .menu-items li:hover > a', // Replaces  '.menu-items li.current-menu-item > a, .menu-items li.current-menu-ancestor > a, .menu-items li:hover > a' . ',' . '#header-supplementary .menu-items li.current-menu-item > a, #header-supplementary .menu-items li.current-menu-ancestor > a, #header-supplementary .menu-items li:hover > a',
						'property'  => 'color',
						'value'     => $accent_font,
						'idtag'     => 'accent_font'
					) );

	$halfwidgetmargin = false;
	if ( intval( $widgetmargin ) )
		$halfwidgetmargin = ( intval( $widgetmargin ) / 2 > 25 ) ? ( intval( $widgetmargin ) / 2 ) . 'px' : '25px';
	if ( $halfwidgetmargin )
		hoot_add_css_rule( array(
						'selector'  => '.main > .main-content-grid:first-child' . ',' . '.content-frontpage > .frontpage-area-boxed:first-child',
						'property'  => 'margin-top',
						'value'     => $halfwidgetmargin,
					) );

	hoot_add_css_rule( array(
						'selector'  => '.widget_newsletterwidget, .widget_newsletterwidgetminimal',
						'property'  => array(
							// property  => array( value, idtag, important, typography_reset ),
							'background' => array( $accent_color, 'accent_color' ),
							'color'      => array( $accent_font, 'accent_font' ),
							),
					) );

}
add_action( 'hoot_dynamic_cssrules', 'unosbiz_dynamic_cssrules', 6 );


/* === Customizer Options === */


/**
 * Update theme defaults
 * Prim @priority 5
 * Prim child @priority 9
 *
 * @since 1.0
 * @access public
 * @return array
 */
if ( !function_exists( 'unosbiz_default_style' ) ) :
function unosbiz_default_style( $defaults ){
	$defaults = array_merge( $defaults, array(
		'accent_color'         => '#248ed0',
		'accent_font'          => '#ffffff',
		'widgetmargin'         => 35,
		'logo_fontface'        => 'fontos',
		'headings_fontface'    => 'fontos',
	) );
	return $defaults;
}
endif;
add_filter( 'unos_default_style', 'unosbiz_default_style', 7 );

/**
 * Add Options (settings, sections and panels) to Hoot_Customize class options object
 *
 * Parent Lite/Prim add options using 'init' hook both at priority 0. Currently there is no way
 * to hook in between them. Hence we hook in later at 5 to be able to remove options if needed.
 * The only drawback is that options involving widget areas cannot be modified/created/removed as
 * those have already been used during widgets_init hooked into init at priority 1. For adding options
 * involving widget areas, we can alterntely hook into 'after_setup_theme' before lite/prim options
 * are built. Modifying/removing such options from lite/prim still needs testing.
 *
 * @since 1.0
 * @access public
 */
if ( !function_exists( 'unosbiz_add_customizer_options' ) ) :
function unosbiz_add_customizer_options() {

	$hoot_customize = Hoot_Customize::get_instance();

	// Modify Options
	$hoot_customize->remove_settings( array( 'logo_tagline_size', 'logo_tagline_style' ) );
	$hoot_customize->remove_settings( 'pageheader_background_location' );

}
endif;
add_action( 'init', 'unosbiz_add_customizer_options', 5 );

/**
 * Modify Lite customizer options
 * Prim hooks in later at priority 9
 *
 * @since 1.0
 * @access public
 */
function unosbiz_modify_customizer_options( $options ){
	if ( isset( $options['settings']['widgetmargin'] ) )
		$options['settings']['widgetmargin']['input_attrs']['placeholder'] = esc_html__( 'default: 35', 'unos-business' );
	if ( isset( $options['settings']['menu_location'] ) )
		$options['settings']['menu_location']['default'] = 'bottom';
	if ( isset( $options['settings']['logo_side'] ) )
		$options['settings']['logo_side']['default'] = 'widget-area';
	if ( isset( $options['settings']['fullwidth_menu_align'] ) )
		$options['settings']['fullwidth_menu_align']['default'] = 'left';
	if ( isset( $options['settings']['logo_custom'] ) )
		$options['settings']['logo_custom']['default'] = array(
			'line1'  => array( 'text' => wp_kses_post( __( '<b>HOOT</b> <em>UNOS</em>', 'unos-business' ) ), 'size' => '25px' ),
			'line2'  => array( 'text' => wp_kses_post( __( '<b><em>BUSINESS</em></b>', 'unos-business' ) ), 'size' => '45px' ),
			// 'line3'  => array( 'sortitem_hide' => 1, 'font' => 'standard' ),
			'line4'  => array( 'sortitem_hide' => 1, ),
		);
	if ( !empty( $options['settings']['logo_custom']['description'] ) )
		$options['settings']['logo_custom']['description'] = sprintf( esc_html__( 'Use &lt;b&gt; and &lt;em&gt; tags in "Line Text" fields below to emphasize different words. Example:%1$s%2$s&lt;b&gt;Unos&lt;/b&gt; &lt;em&gt;Business&lt;/em&gt;%3$s', 'unos-business' ), '<br />', '<code>', '</code>' );

	if ( isset( $options['settings']['logo_fontface_style'] ) )
		$options['settings']['logo_fontface_style']['default'] = 'standard';
	return $options;
}
add_filter( 'unos_customizer_options', 'unosbiz_modify_customizer_options', 7 );

/**
 * Modify Customizer Link Section
 *
 * @since 1.0
 * @access public
 */
function unosbiz_customizer_option_linksection( $lcontent ){
	if ( is_array( $lcontent ) ) {
		if ( !empty( $lcontent['demo'] ) )
			$lcontent['demo'] = str_replace( 'demo.wphoot.com/unos', 'demo.wphoot.com/unos-business', $lcontent['demo'] );
		if ( !empty( $lcontent['install'] ) )
			$lcontent['install'] = str_replace( 'wphoot.com/support/unos', 'wphoot.com/support/unos-business', $lcontent['install'] );
		if ( !empty( $lcontent['rateus'] ) )
			$lcontent['rateus'] = str_replace( 'wordpress.org/support/theme/unos/reviews/?filter=5#new-post', 'wordpress.org/support/theme/unos-business/reviews/#new-post', $lcontent['rateus'] );
	}
	return $lcontent;
}
add_filter( 'unos_customizer_option_linksection', 'unosbiz_customizer_option_linksection' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 *
 * @since 1.0
 * @return void
 */
function unosbiz_customize_preview_js() {
	if ( file_exists( hoot_data()->child_dir . 'admin/customize-preview.js' ) )
		wp_enqueue_script( 'unosbiz-customize-preview', hoot_data()->child_uri . 'admin/customize-preview.js', array( 'hoot-customize-preview', 'customize-preview' ), hoot_data()->childtheme_version, true );
}
add_action( 'customize_preview_init', 'unosbiz_customize_preview_js', 12 );

/**
 * Add style tag to support dynamic css via postMessage script in customizer preview
 *
 * @since 2.7
 * @access public
 */

function unosbiz_customize_dynamic_selectors( $settings ) {
	if ( !is_array( $settings ) ) return $settings;
	$hootpload = ( function_exists( 'hoot_lib_premium_core' ) ) ? 1 : '';

	$modify = array(
		'box_background_color' => array(
			'background'	=> array( 'add' => array(), ),
		),
		'accent_color' => array(
			'background' => array(
				'add' => array(
					'#header .menu-items li.current-menu-item, #header .menu-items li.current-menu-ancestor, #header .menu-items li:hover',
					'.widget_newsletterwidget, .widget_newsletterwidgetminimal',
				),
				'remove' => array(
					'.menu-items li.current-menu-item, .menu-items li.current-menu-ancestor, .menu-items li:hover',
					'.social-icons-icon',
				),
			),
		),
		'accent_font' => array(
			'color' => array(
				'add' => array(
					'.widget_newsletterwidget, .widget_newsletterwidgetminimal',
					'#header .menu-items li.current-menu-item > a, #header .menu-items li.current-menu-ancestor > a, #header .menu-items li:hover > a',
				),
				'remove' => array(
					'.menu-items li.current-menu-item > a, .menu-items li.current-menu-ancestor > a, .menu-items li:hover > a',
					'#topbar .social-icons-icon, #page-wrapper .social-icons-icon',
				),
			),
		),
	);

	if ( !$hootpload ) {
		array_push( $modify['accent_color']['background']['remove'], '#topbar', '#topbar.js-search .searchform.expand .searchtext' );
		array_push( $modify['accent_font']['color']['remove'], '#topbar', '#topbar.js-search .searchform.expand .searchtext', '#topbar .js-search-placeholder' );
		array_push( $modify['box_background_color']['background']['add'], '#topbar.js-search .searchform.expand .searchtext' );
	}

	foreach ( $modify as $id => $props ) {
		foreach ( $props as $prop => $ops ) {
			foreach ( $ops as $op => $values ) {
				if ( $op == 'remove' ) {
					foreach ( $values as $val ) {
						$akey = array_search( $val, $settings[$id][$prop] );
						if ( $akey !== false ) unset( $settings[$id][$prop][$akey] );
					}
				} elseif ( $op == 'add' ) {
					foreach ( $values as $val ) {
						$settings[$id][$prop][] = $val;
					}
				}
			}
		}
	}

	return $settings;
}
add_filter( 'hoot_customize_dynamic_selectors', 'unosbiz_customize_dynamic_selectors', 5 );


/* === Misc === */


/**
 * Modify the image thumbnail size for mosaic 3/4 archive styles
 *
 * @since 1.0
 * @access public
 * @return string
 */
function unosbiz_archive_imgsize( $size, $context='' ){
	if ( $context == 'mosaic3' || $context == 'mosaic4' ) $size = 'hoot-preview-thumb';
	return $size;
}
// @NU
if ( function_exists( 'hoot_lib_premium_core' ) ){
	// Update Image Sizes
	add_filter( 'unos_archive_imgsize', 'unosbiz_archive_imgsize', 7, 2 );
	// Remove the filter (to append google fonts) and let those fonts occur in their natural order as in hoot_googlefonts_list()
	remove_filter( 'hoot_fonts_list', 'unosbiz_fonts_list', 15 );
}