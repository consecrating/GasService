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
			
			<div class="header-sticky">
				<div class="header-middle logo-center">
					<div class="container">
					
						<div class="header-left">
							<?php if( $yobazar_theme_options['ts_enable_search'] ): ?>
								<div class="ts-search-by-category"><?php get_search_form(); ?></div>
							<?php endif; ?>
						</div>
					
						<div class="logo-wrapper"><?php yobazar_theme_logo(); ?></div>
						
						<div class="header-right">
						
							<?php if( $yobazar_theme_options['ts_header_currency'] || $yobazar_theme_options['ts_header_language'] ): ?>
							<div class="language-currency hidden-phone">
								
								<?php if( $yobazar_theme_options['ts_header_language'] ): ?>
								<div class="header-language"><?php yobazar_wpml_language_selector(); ?></div>
								<?php endif; ?>
								
								<?php if( $yobazar_theme_options['ts_header_currency'] ): ?>
								<div class="header-currency"><?php yobazar_woocommerce_multilingual_currency_switcher(); ?></div>
								<?php endif; ?>
								
							</div>
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
							
							<!-- Menu Icon -->
							<div class="icon-menu-sticky-header hidden-phone">
								<span class="icon">
									<svg width="22" height="18" viewBox="0 0 22 18" fill="none" xmlns="http://www.w3.org/2000/svg">
									<line y1="2.39999" x2="22" y2="2.39999" stroke="black" stroke-width="1.5"/>
									<line y1="9.39999" x2="22" y2="9.39999" stroke="black" stroke-width="1.5"/>
									<line y1="16.4" x2="22" y2="16.4" stroke="black" stroke-width="1.5"/>
									</svg>
								</span>
							</div>
							
						</div>
						
					</div>
				</div>
				
				<div class="header-bottom menu-center hidden-phone">
					<div class="container">						
						<div class="menu-wrapper">
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
					</div>
				</div>
			</div>			
		</div>	
	</div>
</header>