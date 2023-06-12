<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package CS_Academy
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<link href="https://fonts.googleapis.com/css?family=Montserrat:400,700|Open+Sans:400,700" rel="stylesheet">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'csacademy' ); ?></a>
	<div class="title-bar" data-responsive-toggle="cs-main-menu" data-hide-for="medium">
		<a class="cs-main-menu__mobile-toggle" href="#" data-toggle="cs-main-menu">
			<span class="menu-icon"></span>
			<div class="title-bar-title"><?php esc_html_e( 'Menu', 'csacademy' ); ?></div>
		</a>
	</div>
	<nav id="cs-main-menu" class="top-bar cs-main-menu" data-topbar role="navigation">
		<div class="grid-container">
			<div class="grid-x align-middle">
				<div class="top-bar-left">
					<div class="site-branding">
						<?php if ( function_exists( 'the_custom_logo' ) ) the_custom_logo(); ?>
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
					</div><!-- .site-branding -->
				</div>
				<div class="top-bar-right">
					<?php
					wp_nav_menu( array(
						'theme_location' => 'main-menu',
						'menu_id'        => 'cs-main-menu',
						'menu_class'		 => 'vertical medium-horizontal menu accordion-menu',
						'container'			 => '',
						'items_wrap'     => '<ul class="%2$s" data-responsive-menu="accordion medium-dropdown">%3$s</ul>'
					) );
					?>
				</div>
			</div>
		</div>
	</nav>
