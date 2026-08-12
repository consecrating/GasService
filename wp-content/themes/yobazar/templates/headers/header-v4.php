<?php
$yobazar_theme_options = yobazar_get_theme_options();

$header_classes = array();
if( $yobazar_theme_options['ts_enable_sticky_header'] ){
	$header_classes[] = 'has-sticky';
}

if( !$yobazar_theme_options['ts_enable_tiny_shopping_cart'] ){
	$header_classes[] = 'hidden-cart';
}

if( !$yobazar_theme_options['ts_enable_tiny_wishlist'] || !class_exists('WooCommerce') || !class_exists('YITH_WCWL') ){
	$header_classes[] = 'hidden-wishlist';
}

if( !$yobazar_theme_options['ts_header_currency'] ){
	$header_classes[] = 'hidden-currency';
}

if( !$yobazar_theme_options['ts_header_language'] ){
	$header_classes[] = 'hidden-language';
}

if( !$yobazar_theme_options['ts_enable_search'] ){
	$header_classes[] = 'hidden-search';
}
?>

<header class="ts-header <?php echo esc_attr(implode(' ', $header_classes)); ?>">
	<div class="header-container">
		<div class="header-template">
		
			<div class="header-top hidden-phone">
				<div class="container">
				
					<div class="header-left">
						<?php 
						if( function_exists('ts_header_social_icons') ):
							ts_header_social_icons();
						endif;
						?>
					</div>
					
					<div class="header-right">
					
						<?php if( $yobazar_theme_options['ts_header_info'] ): ?>
						<div class="info"><?php echo do_shortcode(stripslashes($yobazar_theme_options['ts_header_info'])); ?></div>
						<?php endif; ?>
					
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
						
					</div>
					
				</div>
			</div>
			
			<div class="header-sticky">
				<div class="header-middle">
					<div class="container">
					
						<div class="logo-wrapper"><?php yobazar_theme_logo(); ?></div>
						
						<div class="menu-wrapper hidden-phone">
							<div class="ts-menu">
								<?php 
									if ( has_nav_menu( 'primary' ) ) {
										wp_nav_menu( array( 'container' => 'nav', 'container_class' => 'main-menu pc-menu ts-mega-menu-wrapper','theme_location' => 'primary','walker' => new Yobazar_Walker_Nav_Menu() ) );
									}
									else{
										wp_nav_menu( array( 'container' => 'nav', 'container_class' => 'main-menu pc-menu ts-mega-menu-wrapper' ) );
									}
								?>
							</div>
						</div>
						
						<div class="header-right">
						
							<?php if( $yobazar_theme_options['ts_enable_search'] ): ?>
								<div class="ts-search-by-category"><?php get_search_form(); ?></div>
							<?php endif; ?>
							
							<?php if( $yobazar_theme_options['ts_enable_tiny_account'] ): ?>
							<div class="my-account-wrapper hidden-phone">							
								<?php echo yobazar_tiny_account(); ?>
							</div>
							<?php endif; ?>
							
							<?php if( class_exists('YITH_WCWL') && $yobazar_theme_options['ts_enable_tiny_wishlist'] ): ?>
								<div class="my-wishlist-wrapper hidden-phone"><?php echo yobazar_tini_wishlist(); ?></div>
							<?php endif; ?>
							
							<?php if( $yobazar_theme_options['ts_enable_tiny_shopping_cart'] ): ?>
							<div class="shopping-cart-wrapper hidden-phone">
								<?php echo yobazar_tiny_cart(); ?>
							</div>
							<?php endif; ?>
							
						</div>
					</div>
				</div>
			</div>			
		</div>	
	</div>
</header>