<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package blackpirates
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site">
    <nav aria-label="Skiplinks">
	<ul class="skip-links">		
	    <li><a id="skip-link-nav" class="screen-reader-text" href="#site-navigation"><?php esc_html_e( 'Skip to site navigation.', 'blackpirates' ); ?></a></li>
	    <li><a id="skip-link-content"  class="screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content.', 'blackpirates' ); ?></a></li>
	</ul>
    </nav>
	<header id="masthead" class="site-header" role="banner">
		<div class="site-branding" itemprop="publisher" itemscope itemtype="http://schema.org/Organization">
                    <h1 class="site-title"><?php 
                        $header_image = get_header_image();

                        if ( ! is_front_page() ) { 
                            echo '<a itemprop="url" rel="home" href="'.blackpirates_esc_url(home_url( '/' ) ).'">';	
			} 
                        if ( ! empty( $header_image ) ) {	
                            echo '<img src="'.blackpirates_esc_url( $header_image ).'" width="'.get_custom_header()->width.'" height="'.get_custom_header()->height.'" alt="'.get_bloginfo( 'title' ).'">';	   
			} else {				 
                            echo get_bloginfo( 'title' );   
			} 
			if ( ! is_front_page() ) {  
                            echo "</a>"; 			    
			}
                        ?></h1>
			
                        <?php 
			$description = get_bloginfo( 'description', 'display' );
			if ( $description || is_customize_preview() ) : ?>
				<p class="site-description"><?php echo $description; /* WPCS: xss ok. */ ?></p>
			<?php endif; ?>
		</div><!-- .site-branding -->

		<nav aria-label="<?php _e( 'Navigation', 'blackpirates' ); ?>"  id="site-navigation" class="main-navigation" role="navigation">
			<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( 'Primary Menu', 'blackpirates' ); ?></button>
			<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'primary-menu' ) ); ?>
		</nav><!-- #site-navigation -->
                
            	<div class="section breadcrumbs"><?php 
                    blackpirates_breadcrumb(); 
                ?></div>    
                
                
	</header><!-- #masthead -->

	<div id="content" class="site-content">
