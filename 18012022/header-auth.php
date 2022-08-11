<?php
/**
 * The header for authenication
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Vodokanal
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Oswald:400,300" type="text/css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto+Condensed:400,300" type="text/css">
  
  
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site">
	<div id="wrapper">
		<div class="auth-top">

			<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'vodokanal' ); ?></a>

				<header id="masthead" class="site-header">
					<div class="site-branding">
						
          <?php				
            the_custom_logo();
            if ( is_front_page() && is_home() ) : ?>
          
            <h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
            <?php else : ?>
            <p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
            <?php
            endif;				

            $description = get_bloginfo( 'description', 'display' );
            if ( $description || is_customize_preview() ) : ?>
              <p class="site-description"><?php echo $description; /* WPCS: xss ok. */ ?></p>
              <?php
            endif; ?>
   
            <div class="auth-top-l">
              <div class="auth-page-name">
                <a href="/login">ОСОБИСТИЙ КАБІНЕТ</a>
              </div>
              <div class="auth-logo-2">
              	
                <img src="<?php echo esc_url( get_template_directory_uri( '/' ) ); ?>/images/logo2.png" width="140" height="25">
              </div>
            </div>
              
						<div class="auth-top-r">
              
              <div class="auth-support-info">
               <a href="tel:0 800 503 283"><img src="<?php echo esc_url( get_template_directory_uri( '/' ) ); ?>/images/support_w1.png" alt="CallCenter" width="30" height="20"><span style="vertical-align: 5px;font: normal 14px sans-serif;">Контакт центр:+38(050)811-18-86, 42-22-33</span></a>

              </div><!-- .auth-support-info -->              
						</div><!-- .auth-top-r -->
              
						<nav class="auth-top-menu">
							<button class="menu-toggle" aria-controls="secondary-menu" aria-expanded="false"><?php esc_html_e( 'Secondary Menu', 'vodokanal' ); ?></button>
							<?php
								wp_nav_menu( array(
								'theme_location' => 'auth-menu-top',
								'menu_id'        => 'secondary-menu',
								) );
							?>
						</nav><!-- #site-navigation -->
					 </div>


  







					
        </header><!-- #masthead -->
    </div><!-- .auth-top -->

    
  	<div id="content" class="site-content"> 
