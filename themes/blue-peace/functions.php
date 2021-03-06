<?php



function bluepeace_scripts() {
	wp_enqueue_style( 'Cuprum', '//fonts.googleapis.com/css?family=Cuprum:400,400italic,700,700itali');
	wp_enqueue_style( 'style', get_stylesheet_uri() );
    wp_enqueue_style( 'respinsive', get_template_directory_uri() . '/media-queries.css' );
	wp_enqueue_script( 'customcode', get_template_directory_uri() . '/js/mohsen.js', array( 'jquery' ), '20120206', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

}
add_action( 'wp_enqueue_scripts', 'bluepeace_scripts' );





function bluepeace_setup() {

	// This theme supports a variety of post formats.
add_theme_support( 'post-formats', array( 'aside', 'image', 'link', 'quote', 'status' ) );

    
    // Allows users to set a custom background
    add_theme_support( 'custom-background', array(
        'default-image' => get_template_directory_uri() . '/img/bg.jpg',
    ) );

global $wp_version;
$args = array(
    'width'         => 980,
    'default-image' => get_template_directory_uri() . '/img/head.jpg',
    'uploads'       => true,
);

add_theme_support( 'custom-header' );

	
add_theme_support( 'automatic-feed-links' );

if ( ! isset( $content_width ) )
	$content_width = 700;
	
	
	
register_nav_menus( array(
		'primary' => __( 'Primary Navigation', 'bluepeace' ),
	) );
	
add_theme_support( 'title-tag' );

	
}	
	
add_action( 'after_setup_theme', 'bluepeace_setup' );

function bluepeace_fallbackmenu(){ ?>
			<div id="submenu">
				<ul><li> Go to Adminpanel > Appearance > Menus to create your menu. You should have WP 3.0+ version for custom menus to work.</li></ul>
			</div>
<?php }	

function bluepeace_widgets () {


		register_sidebar( array(
		'name' =>'Main Sidebar',
		'id' => 'sidebar-1',
		'description' => 'Appears on posts and pages except the optional Front Page template, which has its own widgets',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	
	
}


 add_action( 'widgets_init', 'bluepeace_widgets' );












?>
