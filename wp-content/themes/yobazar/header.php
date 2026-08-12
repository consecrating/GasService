<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<?php 
	$yobazar_theme_options = yobazar_get_theme_options();
	?>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />

	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1" />

	<link rel="profile" href="//gmpg.org/xfn/11" />
	<?php 
	yobazar_theme_favicon();
	wp_head(); 
	?>
</head>
<body <?php body_class(); ?>>
<?php
if( function_exists('wp_body_open') ){
	wp_body_open();
}
?>

<!-- Group Header Button -->
<div id="group-icon-header" class="ts-floating-sidebar">
	<div class="overlay"></div>
	<div class="ts-sidebar-content">
		<div class="sidebar-content">
			
			<ul class="tab-mobile-menu hidden">
				<li class="active"><span><?php esc_html_e('Menu', 'yobazar'); ?></span></li>
			</ul>
			
			<h6 class="menu-title"><span><?php esc_html_e('Menu', 'yobazar'); ?></span></h6>
			
			<div class="mobile-menu-wrapper ts-menu visible-phone">
				<div class="menu-main-mobile">
					<?php 
					if( has_nav_menu( 'mobile' ) ){
						wp_nav_menu( array( 'container' => 'nav', 'container_class' => 'mobile-menu', 'theme_location' => 'mobile', 'walker' => new Yobazar_Walker_Nav_Menu() ) );
					}else if( has_nav_menu( 'primary' ) ){
						wp_nav_menu( array( 'container' => 'nav', 'container_class' => 'mobile-menu', 'theme_location' => 'primary', 'walker' => new Yobazar_Walker_Nav_Menu() ) );
					}
					else{
						wp_nav_menu( array( 'container' => 'nav', 'container_class' => 'mobile-menu' ) );
					}
					?>
				</div>
			</div>
			
			<div class="group-button-header">
				
				<?php if( $yobazar_theme_options['ts_header_currency'] || $yobazar_theme_options['ts_header_language'] ): ?>
				<div class="language-currency">
					
					<?php if( $yobazar_theme_options['ts_header_language'] ): ?>
					<div class="header-language"><?php yobazar_wpml_language_selector(); ?></div>
					<?php endif; ?>
					
					<?php if( $yobazar_theme_options['ts_header_currency'] ): ?>
					<div class="header-currency"><?php yobazar_woocommerce_multilingual_currency_switcher(); ?></div>
					<?php endif; ?>
					
				</div>
				<?php endif; ?>
				
				<?php 
				if( in_array( $yobazar_theme_options['ts_header_layout'], array('v3','v4') ) && function_exists('ts_header_social_icons') ):
					ts_header_social_icons();
				endif;
				?>
				
				<?php if( in_array( $yobazar_theme_options['ts_header_layout'], array('v3','v4') ) && $yobazar_theme_options['ts_header_info'] ): ?>
				<div class="info"><?php echo do_shortcode(stripslashes($yobazar_theme_options['ts_header_info'])); ?></div>
				<?php endif; ?>
				
			</div>
			
		</div>	
	</div>
</div>

<!-- Mobile Group Button -->
<div id="ts-mobile-button-bottom">
	<!-- Menu Icon -->
	<div class="ts-mobile-icon-toggle">
		<span class="icon">
			<svg width="22" height="18" viewBox="0 0 22 18" fill="none" xmlns="http://www.w3.org/2000/svg">
			<line y1="2.39999" x2="22" y2="2.39999" stroke="black" stroke-width="1.5"/>
			<line y1="9.39999" x2="22" y2="9.39999" stroke="black" stroke-width="1.5"/>
			<line y1="16.4" x2="22" y2="16.4" stroke="black" stroke-width="1.5"/>
			</svg>
		</span>
	</div>
	
	<!-- Home Icon -->
	<div class="mobile-button-home">
		<a href="<?php echo esc_url( home_url('/') ) ?>">
			<svg width="21" height="20" viewBox="0 0 21 20" fill="none" xmlns="http://www.w3.org/2000/svg">
			<path d="M17.4661 7.08325V18.7499H4.13281V7.08325" stroke="black" stroke-width="1.5" stroke-miterlimit="10"/>
			<path d="M19.9661 8.75L10.7995 1.25L1.63281 8.75" stroke="black" stroke-width="1.5" stroke-miterlimit="10"/>
			</svg>
		</a>
	</div>
	
	<!-- Myaccount Icon -->
	<?php if( $yobazar_theme_options['ts_enable_tiny_account'] ): ?>
	<div class="my-account-wrapper">
		<?php echo yobazar_tiny_account(false); ?>
	</div>
	<?php endif; ?>
	
	<!-- Wishlist Icon -->
	<?php if( class_exists('YITH_WCWL') && $yobazar_theme_options['ts_enable_tiny_wishlist'] ): ?>
		<div class="my-wishlist-wrapper"><?php echo yobazar_tini_wishlist(); ?></div>
	<?php endif; ?>
	
	<!-- Cart Icon -->
	<?php if( $yobazar_theme_options['ts_enable_tiny_shopping_cart'] ): ?>
	<div class="shopping-cart-wrapper mobile-cart">
		<?php echo yobazar_tiny_cart(true, false); ?>
	</div>
	<?php endif; ?>
</div>

<!-- Search Sidebar -->
<?php if( $yobazar_theme_options['ts_enable_search'] ): ?>
	
	<div id="ts-search-sidebar" class="ts-floating-sidebar">
		<div class="overlay"></div>
		<div class="ts-sidebar-content">
			<span class="close"></span>
			
			<div class="ts-search-by-category woocommerce">
				<h2 class="title"><?php esc_html_e('Search ', 'yobazar'); ?></h2>
				<?php get_search_form(); ?>
				<div class="ts-search-result-container"></div>
			</div>
		</div>
	</div>

<?php endif; ?>

<!-- Shopping Cart Floating Sidebar -->
<?php if( class_exists('WooCommerce') && $yobazar_theme_options['ts_enable_tiny_shopping_cart'] && $yobazar_theme_options['ts_shopping_cart_sidebar'] && !is_cart() && !is_checkout() ): ?>
<div id="ts-shopping-cart-sidebar" class="ts-floating-sidebar">
	<div class="overlay"></div>
	<div class="ts-sidebar-content">
		<span class="close"></span>
		<div class="ts-tiny-cart-wrapper"></div>
	</div>
</div>
<?php endif; ?>

<div id="page" class="hfeed site">

	<?php if( !is_page_template('page-templates/blank-page-template.php') ): ?>
	
		<?php yobazar_header_store_notice(); ?>
		
		<!-- Page Slider -->
		<?php if( is_page() ): ?>
			<?php if( yobazar_get_page_options('ts_page_slider') && yobazar_get_page_options('ts_page_slider_position') == 'before_header' ): ?>
			<div class="top-slideshow">
				<div class="top-slideshow-wrapper">
					<?php yobazar_show_page_slider(); ?>
				</div>
			</div>
			<?php endif; ?>
		<?php endif; ?>
		
		<?php yobazar_get_header_template(); ?>
		
	<?php endif; ?>
	
	<?php do_action('yobazar_before_main_content'); ?>

	<div id="main" class="wrapper">