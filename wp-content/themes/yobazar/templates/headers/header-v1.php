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
				<div class="header-middle menu-center">
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
							
							<?php if( $yobazar_theme_options['ts_enable_search'] ): ?>
							<div class="search-button search-icon">
								<span class="icon">
									<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M7.61667 13.9833C11.1329 13.9833 13.9833 11.1329 13.9833 7.61667C13.9833 4.10045 11.1329 1.25 7.61667 1.25C4.10045 1.25 1.25 4.10045 1.25 7.61667C1.25 11.1329 4.10045 13.9833 7.61667 13.9833Z" stroke="#191919" stroke-width="1.5" stroke-miterlimit="10"/>
									<path d="M18.75 18.75L11.9917 11.9917" stroke="#191919" stroke-width="1.5" stroke-miterlimit="10"/>
									</svg>
								</span>
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
							
						</div>
						
					</div>
					
				</div>
			</div>			
		</div>	
	</div>
</header>