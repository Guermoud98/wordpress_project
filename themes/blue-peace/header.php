<!DOCTYPE html>

<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />








	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	<?php wp_head(); ?>
</head>


<body <?php body_class(); ?>>

	<div id="page" class="clear">

		<div id="header" >


			<img class="headerimg" src="<?php header_image(); ?>" height="<?php echo get_custom_header()->height; ?>" width="<?php echo get_custom_header()->width; ?>" alt="" />

			<div class="headertitle" <?php if (!header_image() ) echo "style='position:static; margin-left: 20px;'"?>>
				<h1>
					<a href="<?php echo esc_url(home_url( '/' )); ?>"><?php bloginfo('name'); ?></a>
				</h1>  
				<span class="desc tra"><?php bloginfo('description'); ?></span> 
			</div>

			<div id="nav-head" <?php if (!header_image() ) echo "style='position:static; top:0px'"?>>  
				<a class="nav-toggle" href="#nav-head"><?php _e( 'Show Menu', 'bluepeace' ); ?></a>
				<a class="nav-toggleof" href="#header"><?php _e( 'Hide Menu', 'bluepeace' ); ?></a>

			         <?php wp_nav_menu(array('theme_location' => 'primary', 'menu_class' => 'menu clear', 'menu_id' => 'navigation', 'container' => false,  'show_home' => '1','fallback_cb'=> 'bluepeace_fallbackmenu')); ?>  

				<a class="nav-toggleof" href="#header">	<?php _e( 'Hide Menu', 'bluepeace' ); ?></a>
			</div>


		</div>