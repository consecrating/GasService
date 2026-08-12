<?php
if( !isset($data) ){
	$data = yobazar_get_theme_options();
}

update_option('ts_load_dynamic_style', 0);

$default_options = array(
				'ts_enable_rtl'					=> 0
				,'ts_layout_fullwidth'			=> 0
				,'ts_enable_search'				=> 1
				,'ts_search_style' 				=> 'search-default'
				,'ts_logo_width'				=> "154"
				,'ts_device_logo_width'			=> "126"
				,'ts_product_rating_style'		=> 'border'
				,'ts_custom_font_ttf'			=> array( 'url' => '' )
		);
		
foreach( $default_options as $option_name => $value ){
	if( isset($data[$option_name]) ){
		$default_options[$option_name] = $data[$option_name];
	}
}

extract($default_options);
		
$default_colors = array(
				'ts_primary_color'											=> '#D9121F'
				,'ts_text_color_in_bg_primary'								=> '#ffffff'
				,'ts_main_content_background_color'							=> '#ffffff'
				,'ts_text_color'											=> '#191919'
				,'ts_text_bold_color'										=> '#191919'
				,'ts_text_gray_color'										=> '#808080'
				,'ts_heading_color'											=> '#191919'
				,'ts_link_color'											=> '#D9121F'
				,'ts_link_color_hover'										=> '#D9121F'
				,'ts_border_color'											=> '#e6e6e6'
				,'ts_input_text_color'										=> '#191919'
				,'ts_input_background_color'								=> '#ffffff'
				,'ts_input_border_color'									=> '#cccccc'
				,'ts_input_search_background_color'							=> '#f2f2f2'
				,'ts_input_search_border_color'								=> '#f2f2f2'
				,'ts_button_text_color'										=> '#ffffff'
				,'ts_button_background_color'								=> '#191919'
				,'ts_button_border_color'									=> '#191919'
				,'ts_button_text_hover'										=> '#191919'
				,'ts_button_background_hover'								=> 'transparent'
				,'ts_button_border_hover'									=> '#191919'
				,'ts_breadcrumb_background_color'							=> '#ffffff'
				,'ts_breadcrumb_text_color'									=> '#191919'
				,'ts_breadcrumb_link_color'									=> '#808080'
				,'ts_notice_text_color'										=> '#191919'
				,'ts_notice_background_color'								=> '#FFEEEF'
				,'ts_header_text_color'										=> '#191919'
				,'ts_header_background_color'								=> '#ffffff'
				,'ts_header_border_color'									=> '#E6E6E6'
				,'ts_header_top_text_color'									=> '#ffffff'
				,'ts_header_top_background_color'							=> '#191919'
				,'ts_header_top_border_color'								=> '#242424'
				,'ts_header_icon_color'										=> '#191919'
				,'ts_menu_text_color'										=> '#191919'
				,'ts_menu_text_hover'										=> '#D9121F'
				,'ts_sub_menu_heading_color'								=> '#808080'
				,'ts_sub_menu_background_color'								=> '#ffffff'
				,'ts_footer_background_color'								=> '#ffffff'
				,'ts_footer_text_color'										=> '#191919'
				,'ts_product_name_text_color'								=> '#191919'
				,'ts_product_name_text_hover'								=> '#D9121F'
				,'ts_product_price_color'									=> '#191919'
				,'ts_product_del_price_color'								=> '#999999'
				,'ts_product_sale_price_color'								=> '#D9121F'
				,'ts_rating_color'											=> '#E6E6E6'
				,'ts_rating_fill_color'										=> '#191919'
				,'ts_counter_background_color'								=> '#ffffff'
				,'ts_counter_text_color'									=> '#191919'
				,'ts_product_detail_images_summary_background'				=> '#f3f3f3'
				,'ts_product_category_background'							=> '#f3f3f3'
				,'ts_product_button_thumbnail_text_color'					=> '#191919'
				,'ts_product_button_thumbnail_background_color'				=> '#ffffff'
				,'ts_product_button_thumbnail_text_hover'					=> '#ffffff'
				,'ts_product_button_thumbnail_background_hover'				=> '#191919'
				,'ts_product_button_thumbnail_tooltip_background_color'		=> '#ffffff'
				,'ts_product_button_thumbnail_tooltip_text_color'			=> '#191919'
				,'ts_product_sale_label_text_color'							=> '#ffffff'
				,'ts_product_sale_label_background_color'					=> '#d9121f'
				,'ts_product_new_label_text_color'							=> '#191919'
				,'ts_product_new_label_background_color'					=> '#ffffff'
				,'ts_product_feature_label_text_color'						=> '#ffffff'
				,'ts_product_feature_label_background_color'				=> '#191919'
				,'ts_product_outstock_label_text_color'						=> '#ffffff'
				,'ts_product_outstock_label_background_color'				=> '#cccccc'
				,'ts_product_button_mobile_text_color'						=> '#191919'
				,'ts_product_button_mobile_background_color'				=> '#f3f3f3'
				,'ts_product_group_button_fixed_icon_color'					=> '#191919'
				,'ts_product_group_button_fixed_background_color'			=> '#ffffff'
				,'ts_product_group_button_fixed_border_color'				=> '#e6e6e6'
				,'ts_menu_mobile_background_color'							=> '#ffffff'
				,'ts_menu_mobile_text_color'								=> '#191919'				
);

$data = apply_filters('yobazar_custom_style_data', $data);

foreach( $default_colors as $option_name => $default_color ){
	if( isset($data[$option_name]['rgba']) ){
		$default_colors[$option_name] = $data[$option_name]['rgba'];
	}
	else if( isset($data[$option_name]['color']) ){
		$default_colors[$option_name] = $data[$option_name]['color'];
	}
}

extract( $default_colors );

/* Parse font option. Ex: if option name is ts_body_font, we will have variables below:
* ts_body_font (font-family)
* ts_body_font_weight
* ts_body_font_style
* ts_body_font_size
* ts_body_font_line_height
* ts_body_font_letter_spacing
*/
$font_option_names = array(
							'ts_body_font',
							'ts_body_font_medium',
							'ts_body_font_bold',
							'ts_heading_font',
							'ts_menu_font',
							'ts_product_font',
							);
$font_size_option_names = array( 
							'ts_h1_font', 
							'ts_h2_font', 
							'ts_h3_font', 
							'ts_h4_font', 
							'ts_h5_font', 
							'ts_h6_font',
							'ts_button_font',
							'ts_input_font',
							'ts_h1_ipad_font', 
							'ts_h2_ipad_font', 
							'ts_h3_ipad_font', 
							'ts_h4_ipad_font',
							'ts_h5_ipad_font',
							'ts_button_ipad_font',
							'ts_input_ipad_font',
							'ts_h1_mobile_font', 
							'ts_h2_mobile_font', 
							'ts_h3_mobile_font', 
							'ts_h4_mobile_font',
							'ts_h5_mobile_font',
							);
$font_option_names = array_merge($font_option_names, $font_size_option_names);
foreach( $font_option_names as $option_name ){
	$default = array(
		$option_name 						=> 'inherit'
		,$option_name . '_weight' 			=> 'normal'
		,$option_name . '_style' 			=> 'normal'
		,$option_name . '_size' 			=> 'inherit'
		,$option_name . '_line_height' 		=> 'inherit'
		,$option_name . '_letter_spacing' 	=> 'inherit'
	);
	if( is_array($data[$option_name]) ){
		if( !empty($data[$option_name]['font-family']) ){
			$default[$option_name] = $data[$option_name]['font-family'];
		}
		if( !empty($data[$option_name]['font-weight']) ){
			$default[$option_name . '_weight'] = $data[$option_name]['font-weight'];
		}
		if( !empty($data[$option_name]['font-style']) ){
			$default[$option_name . '_style'] = $data[$option_name]['font-style'];
		}
		if( !empty($data[$option_name]['font-size']) ){
			$default[$option_name . '_size'] = $data[$option_name]['font-size'];
		}
		if( !empty($data[$option_name]['line-height']) ){
			$default[$option_name . '_line_height'] = $data[$option_name]['line-height'];
		}
		if( !empty($data[$option_name]['letter-spacing']) ){
			$default[$option_name . '_letter_spacing'] = $data[$option_name]['letter-spacing'];
		}
	}
	extract( $default );
}
?>	
	
	/*
		I. CUSTOM FONT FAMILY
		II. CUSTOM FONT SIZE
		III. CUSTOM COLOR
	*/
	header .logo img,
	header .logo-header img{
		width: <?php echo absint($ts_logo_width); ?>px;
	}
	@media only screen and (max-width: 1279px){
		header .logo img,
		header .logo-header img{
			width: <?php echo absint($ts_device_logo_width); ?>px;
		}
	}
	@media only screen and (max-width: 767px){
		header .logo img,
		header .logo-header img{
			width: <?php echo absint($ts_device_logo_width); ?>px;
		}
	}
	
	<?php if( isset($data['ts_product_rating_style']) && $data['ts_product_rating_style'] != 'fill' ): ?>
		.star-rating span:before,
		.star-rating:before,
		.woocommerce .star-rating span:before,
		.woocommerce .star-rating:before,
		.rs-layer .rs-starring .star-rating:before,
		.rs-layer .rs-starring-page .star-rating:before,
		.rs-layer .rs-starring .star-rating span:before,
		.rs-layer .rs-starring-page .star-rating span:before,
		.woocommerce p.stars a::before,
		.ts-testimonial-wrapper .rating:before,
		.ts-testimonial-wrapper .rating span:before,
		blockquote .rating:before,
		blockquote .rating span:before{
			text-transform: none;
		}
	<?php endif; ?>
	
	/*--------------------------------------------------------
		I. CUSTOM FONT FAMILY
	---------------------------------------------------------*/
	html,
	body,
	label,
	input,
	textarea,
	keygen,
	select,
	button,
	body .font-body,
	.ts-header nav.main-menu > ul.menu > li.font-body > a, 
	.ts-header nav.main-menu > ul > li.font-body > a,
	.product-name,
	h3.product-name,
	.product-name h3,
	.mobile-menu-wrapper .mobile-menu .product,
	.ts-header .menu-wrapper .ts-menu .product,
	.portfolio-inner h4,
	.single-portfolio .meta-content .portfolio-info > span:first-child,
	body a.button-text,
	.ts-banner .box-content header h6,
	.woocommerce-cart table.cart td.actions .button,
	body table.compare-list,
	.ts-blogs article .entry-title,
	.columns-2 .list-posts article .entry-title,
	.columns-0 .list-posts article:not(:nth-child(5n+1)) .entry-title,
	.columns-3 .list-posts article .entry-title{
		font-family: <?php echo esc_html($ts_body_font); ?>;
		font-style: <?php echo esc_html($ts_body_font_style); ?>;
		font-weight: <?php echo esc_html($ts_body_font_weight); ?>;
	}
	h1,h2,h3,
	h4,h5,h6,
	.h1,.h2,.h3,
	.h4,.h5,.h6,
	.ts-blogs.columns-1 article .entry-title,
	.list-posts article .entry-title{
		font-family: <?php echo esc_html($ts_heading_font); ?>;
		font-style: <?php echo esc_html($ts_heading_font_style); ?>;
		font-weight: <?php echo esc_html($ts_heading_font_weight); ?>;
	}
	strong,
	table thead th,
	table th,
	.woocommerce table.shop_table th,
	.woocommerce table.shop_table tbody th,
	.woocommerce table.shop_table tfoot th,
	body .wp-block-calendar table th,
	.ts-store-notice a,
	.hightlight,
	.woocommerce .product-label > span.onsale,
	.woocommerce .product-label > span,
	.entry-author .author a,
	.single-portfolio .meta-content,
	ul.blog-filter-bar li.current,
	.ts-portfolio-wrapper .filter-bar li.current,
	.cart-collaterals .cart_totals > h2,
	.cart_list .subtotal,
	.ts-tiny-cart-wrapper .total, 
	.widget_shopping_cart .total-title, 
	.yith-wfbt-section .total_price_label,
	.yith-wfbt-section .total_price,
	.woocommerce .widget_shopping_cart .total, 
	.woocommerce.widget_shopping_cart .total, 
	.elementor-widget-wp-widget-woocommerce_widget_cart .total,
	body .wishlist_table.images_grid li .item-details table.item-details-table td.label, 
	body .wishlist_table.mobile li .item-details table.item-details-table td.label, 
	body .wishlist_table.mobile li table.additional-info td.label, 
	body .wishlist_table.modern_grid li .item-details table.item-details-table td.label,
	.woocommerce #reviews #comments ol.commentlist li .comment-text p.meta strong,
	.ts-product-categories-widget-wrapper ul.product-categories > li > a,
	.ts-product-categories-widget-wrapper ul li.current > a,
	.ts-shop-result-count,
	#main-content .woocommerce.columns-1 > .products .product .product-name,
	#main-content .woocommerce.columns-1 > .products .product .meta-wrapper-2 .price,
	.woocommerce div.product p.price,
	.woocommerce div.product span.price,
	.woocommerce div.product form.cart .variations label,
	.ts-product-attribute > div.option:not(.color) > a,
	.meta-wrapper-2 .quantity .screen-reader-text,
	.woocommerce div.product form.cart div.quantity .screen-reader-text,
	.woocommerce #reviews .comment-reply-title,
	div.product .single-navigation > a > span,
	.woocommerce-orders-table__cell-order-number,
	html body > h1,
	.more-less-buttons a,
	.button,
	a.button,
	button,
	.ts-button,
	input[type^="submit"],
	.shopping-cart p.buttons a,
	a.wp-block-button__link,
	.woocommerce a.button,
	.woocommerce button.button,
	.woocommerce input.button,
	.woocommerce-page a.button,
	.woocommerce-page button.button,
	.woocommerce-page input.button,
	.woocommerce a.button.alt,
	.woocommerce button.button.alt,
	.woocommerce input.button.alt,
	.woocommerce-page a.button.alt,
	.woocommerce-page button.button.alt,
	.woocommerce-page input.button.alt,
	.woocommerce #respond input#submit, 
	.yith-woocompare-widget a.clear-all,
	.yith-woocompare-widget a.compare,
	.elementor-button-wrapper .elementor-button,
	.elementor-widget-wp-widget-yith-woocompare-widget a.clear-all,
	.elementor-widget-wp-widget-yith-woocompare-widget a.compare,
	.woocommerce.yith-wfbt-section .yith-wfbt-form .yith-wfbt-items li span.checkboxbutton.checked ~ *,
	.woocommerce div.product .woocommerce-tabs ul.tabs li.active,
	div.button a,
	input[type="submit"].dokan-btn, 
	a.dokan-btn, 
	.dokan-btn,
	.button-text,
	.wishlist_table .product-add-to-cart a,
	body .woocommerce table.compare-list .add-to-cart td a,
	.woocommerce .woocommerce-error .button,
	.woocommerce .woocommerce-info .button,
	.woocommerce .woocommerce-message .button,
	.woocommerce-page .woocommerce-error .button,
	.woocommerce-page .woocommerce-info .button,
	.woocommerce-page .woocommerce-message .button,
	.woocommerce .product .category-name .count,
	.ts-product-brand-wrapper .item .count,
	.woocommerce .woocommerce-ordering .orderby-current,
	.woocommerce-cart table.cart td.actions .button,
	.woocommerce .cart-collaterals .amount,
	.woocommerce-shipping-fields h3#ship-to-different-address,
	.comment-meta .author,
	.portfolio-info > span:first-child,
	.woocommerce > form > fieldset legend,
	#ts-search-result-container .view-all-wrapper,
	.column-tabs ul.tabs li.current,
	.ts-list-of-product-categories-wrapper,
	.woocommerce form table.shop_table tbody th,
	.woocommerce form table.shop_table tfoot td,
	.woocommerce form table.shop_table tfoot th,
	.woocommerce table.shop_table ul#shipping_method .amount,
	.ts-availability-bar,
	.ts-sold-in-24h,
	.ts-product-video-button,
	.ts-product-360-button,
	.counter-wrapper,
	.view-all-wrapper a,
	.ts-shortcode a.view-more{
		font-family: <?php echo esc_html($ts_body_font_medium); ?>;
		font-style: <?php echo esc_html($ts_body_font_medium_style); ?>;
		font-weight: <?php echo esc_html($ts_body_font_medium_weight); ?>;
	}
	body .font-body-bold,
	.product-on-sale-form.checked > label,
	.filter-widget-area-button > a,
	.commentlist li strong,
	body.error404 .image-404 .text-clipping,
	.dropdown-container .theme-title span,
	.my-wishlist-wrapper .tini-wishlist .count-number, 
	.shopping-cart-wrapper .cart-control .cart-number,
	.breadcrumb-title-wrapper .page-title .count,
	.dokan-dashboard-content .pagination li a,
	.dokan-pagination-container .dokan-pagination li a,
	.woocommerce nav.woocommerce-pagination ul li a,
	.woocommerce nav.woocommerce-pagination ul li span,
	.ts-pagination ul li a,
	.ts-pagination ul li span{
		font-family: <?php echo esc_html($ts_body_font_bold); ?>;
		font-style: <?php echo esc_html($ts_body_font_bold_style); ?>;
		font-weight: <?php echo esc_html($ts_body_font_bold_weight); ?>;
	}
	.mobile-menu-wrapper .mobile-menu,
	.ts-header .menu-wrapper .ts-menu{
		font-family: <?php echo esc_html($ts_menu_font); ?>;
		font-style: <?php echo esc_html($ts_menu_font_style); ?>;
		font-weight: <?php echo esc_html($ts_menu_font_weight); ?>;
	}
	.mobile-menu-wrapper .mobile-menu li[class*="ti-"],
	.ts-header nav.main-menu li[class*="ti-"],
	.mobile-menu-wrapper .mobile-menu li[class*="fa-"],
	.ts-header nav.main-menu li[class*="fa-"]{
		font-family: <?php echo esc_html($ts_menu_font); ?> !important;
		font-style: <?php echo esc_html($ts_menu_font_style); ?> !important;
		font-weight: <?php echo esc_html($ts_menu_font_weight); ?> !important;
	}
	
	<?php 
	/* Custom Font */
	if( isset($ts_custom_font_ttf) && $ts_custom_font_ttf['url'] ):
	?>
	@font-face {
		font-family: 'CustomFont';
		src:url('<?php echo esc_url($ts_custom_font_ttf['url']); ?>') format('truetype');
		font-weight: normal;
		font-style: normal;
	}
	<?php endif; ?>

	/*--------------------------------------------------------
		II. CUSTOM FONT SIZE
	---------------------------------------------------------*/
	html,
	body,
	html body > h1,
	body table.compare-list,
	.woocommerce-shipping-fields h3#ship-to-different-address{
		font-size: <?php echo esc_html($ts_body_font_size); ?>;
		line-height: <?php echo esc_html($ts_body_font_line_height); ?>;
	}
	.tagcloud a,
	.wp-block-tag-cloud a{
		font-size: <?php echo esc_html($ts_body_font_size); ?> !important;
		line-height: <?php echo esc_html($ts_body_font_line_height); ?> !important;
	}
	.mobile-menu-wrapper .mobile-menu > ul > li.font-body > a,
	.ts-header nav.main-menu > ul.menu > li.font-body > a, 
	.ts-header nav.main-menu > ul > li.font-body > a{
		font-size: <?php echo esc_html($ts_body_font_size); ?>;
	}
	body table.compare-list tr.description,
	body table.compare-list tr.description ~ tr,
	.header-language, 
	.header-currency,
	.ts-language-switcher,
	.ts-currency-switcher,
	.breadcrumb-title-wrapper .breadcrumbs,
	.header-top,
	.comment-meta,
	.entry-meta-middle,
	.product-group-button .button-tooltip,
	.ts-product-attribute .button-tooltip,
	#comment-wrapper .heading-title small,
	.woocommerce #reviews #comments ol.commentlist li .comment-text p.meta,
	.woocommerce .cart-collaterals table.shop_table .shipping td,
	.widget_recent_entries .post-date,
	.single-portfolio .date-time,
	.portfolio-meta .date-time,
	.single-portfolio .meta-content,
	.elementor-widget-wp-widget-recent-posts .post-date,
	.woocommerce .widget_rating_filter ul li a,
	.woocommerce .woocommerce-widget-layered-nav-list .woocommerce-widget-layered-nav-list__item .count,
	.product-filter-by-brand li label .count,
	.ts-product-categories-widget-wrapper ul li .count,
	ul.product-categories li .count,
	.dokan-store-wrap .commentlist li p strong[itemprop="author"],
	.dokan-store-wrap .commentlist li p em.verified,
	.dokan-store-wrap .commentlist li p time,
	div.product .summary .meta-content,
	div.product .summary .detail-meta-top,
	.woocommerce div.product .summary .woocommerce-product-rating,
	.woocommerce div.product .summary .product-brands,
	.woocommerce div.product .summary .woocommerce-product-details__short-description,
	.widget_categories li,
	.elementor-widget-wp-widget-categories li,
	.widget_archive li,
	.wp-block-archives-list li,
	.ts-sold-in-24h,
	.ts-product-video-button,
	.ts-product-360-button,
	#group-icon-header .group-button-header,
	.product-filter-by-color ul li .count,
	.woocommerce ul.order_details li,
	.woocommerce-privacy-policy-text,
	.woocommerce .product .category-name .count,
	.ts-product-brand-wrapper .item .count,
	.products .product .meta-wrapper > .count-rating,
	.woocommerce div.product form.cart .variations,
	.woocommerce div.product form.cart .reset_variations,
	.woocommerce div.product form.cart .single_variation_wrap,
	.woocommerce div.product .single-product-buttons-sharing .single-product-buttons,
	.woocommerce div.product .single-product-buttons-sharing .ts-social-sharing,
	.woocommerce div.product .single-product-buttons-sharing .single-product-buttons a:before,
	.woocommerce div.product .single-product-buttons-sharing .single-product-buttons a.added,
	.woocommerce div.product .single-product-buttons-sharing .single-product-buttons .added a:after,
	.woocommerce div.product .single-product-buttons-sharing .single-product-buttons .ts-tooltip:before{
		font-size: <?php echo esc_html( absint($ts_body_font_size) - 2 ) . 'px'; ?>;
	}
	.woocommerce.main-products.columns-1 > .products .product-group-button-meta > div.button-in a:before,
	.woocommerce.main-products.columns-1 > .products .product-group-button-meta > div.compare a.added,
	.woocommerce.main-products.columns-1 > .products .product-group-button-meta > div.wishlist .added a:after,
	.woocommerce.main-products.columns-1 > .products .product-group-button-meta > .button-in .ts-tooltip:before{
		font-size: <?php echo esc_html( absint($ts_body_font_size) - 2 ) . 'px'; ?> !important;
	}
	small,
	table th,
	.ts-store-notice,
	.ts-sidebar .widget-container,
	.ts-sidebar .ts-blogs-widget-wrapper .post-title,
	.widget_categories li > a,
	.elementor-widget-wp-widget-categories  li > a,
	.widget_archive  li > a,
	.wp-block-archives-list  li > a,
	.woocommerce .cart-collaterals,
	.woocommerce .before-loop-wrapper,
	.woocommerce div.product form.cart .variations label,
	body .wishlist_table.images_grid li .item-details table.item-details-table td.label, 
	body .wishlist_table.mobile li .item-details table.item-details-table td.label, 
	body .wishlist_table.mobile li table.additional-info td.label, 
	body .wishlist_table.modern_grid li .item-details table.item-details-table td.label,
	.footer-container .elementor-widget-container > h5,
	.ts-megamenu-container .elementor-widget-container > h5,
	.footer-container .ts-list-of-product-categories-wrapper h3.heading-title,
	.ts-megamenu-container .ts-list-of-product-categories-wrapper h3.heading-title,
	.woocommerce div.product form.cart div.quantity .screen-reader-text,
	.woocommerce-account .addresses .title h3,
	.woocommerce-account .addresses h2,
	.woocommerce-customer-details .addresses h2,
	.woocommerce-Address address,
	.yith-wfbt-section .total_price_label,
	div.product .single-navigation > a > span,
	.wp-block-archives-list li > a,
	.widget_archive li > a{
		font-size: <?php echo esc_html( absint($ts_body_font_size) - 1 ) . 'px'; ?>;
	}
	.ts-availability-bar,
	.ts-product-category-wrapper.style-icon .product .category-name h3{
		font-size: <?php echo esc_html( absint($ts_body_font_size) + 1 ) . 'px'; ?>;
	}
	.header-top .header-language,
	.header-top .header-currency{
		font-size: <?php echo esc_html( absint($ts_body_font_size) - 3 ) . 'px'; ?>;
	}

	/*** Menu ***/
	.mobile-menu-wrapper .mobile-menu,
	.ts-list-of-product-categories-wrapper,
	.ts-header .menu-wrapper .ts-menu{
		font-size: <?php echo esc_html($ts_menu_font_size); ?>;
		line-height: <?php echo esc_html($ts_menu_font_line_height); ?>;
	}
	.mobile-menu-wrapper .mobile-menu li,
	.ts-header nav.main-menu li{
		line-height: <?php echo esc_html($ts_menu_font_line_height); ?> !important;
	}

	/*** Product ***/
	.product-name,
	h3.product-name,
	.product-name h3,
	.products .meta-wrapper > *:not(.star-rating),
	.woocommerce div.product p.price del,
	.woocommerce div.product span.price del,
	#main-content .woocommerce.columns-1 > .products .product .meta-wrapper-2 .price del{
		font-size: <?php echo esc_html($ts_product_font_size); ?>;
		line-height: <?php echo esc_html($ts_product_font_line_height); ?>;
	}

	/*** Button/input ***/
	input,
	textarea,
	keygen,
	select,
	select option,
	body .select2-container,
	.woocommerce form .form-row input.input-text,
	.woocommerce form .form-row textarea,
	.dokan-form-control,
	.more-less-buttons a,
	#add_payment_method table.cart td.actions .coupon .input-text,
	.woocommerce-cart table.cart td.actions .coupon .input-text,
	.woocommerce-checkout table.cart td.actions .coupon .input-text,
	.woocommerce-columns > h3,
	.hidden-title-form input[type="text"]{
		font-size: <?php echo esc_html($ts_input_font_size); ?>;
		line-height: <?php echo esc_html($ts_input_font_line_height); ?>;
	}
	body a.button-text,
	.woocommerce-cart table.cart td.actions .button,
	.woocommerce .button.button-small,
	.button.button-small,
	.woocommerce .button.button-small.button-border,
	.button.button-small.button-border,
	.woocommerce-cart .cart-collaterals .shipping-calculator-form .button,
	.elementor-button-wrapper .elementor-button.elementor-size-xs{
		font-size: <?php echo esc_html( absint($ts_body_font_size) + 1 ) . 'px'; ?>;
	}
	.button,
	a.button,
	button,
	input[type^="submit"],
	.shopping-cart p.buttons a,
	a.wp-block-button__link,
	.woocommerce a.button,
	.woocommerce button.button,
	.woocommerce input.button,
	.woocommerce-page a.button,
	.woocommerce-page button.button,
	.woocommerce-page input.button,
	.woocommerce a.button.alt,
	.woocommerce button.button.alt,
	.woocommerce input.button.alt,
	.woocommerce-page a.button.alt,
	.woocommerce-page button.button.alt,
	.woocommerce-page input.button.alt,
	#content button.button,
	.woocommerce #respond input#submit, 
	div.button a,
	input[type="submit"].dokan-btn, 
	a.dokan-btn, 
	.dokan-btn,
	.wishlist_table .product-add-to-cart a,
	body .woocommerce table.compare-list .add-to-cart td a,
	.elementor-button-wrapper .elementor-button,
	.elementor-widget-wp-widget-yith-woocompare-widget a.clear-all,
	.elementor-widget-wp-widget-yith-woocompare-widget a.compare,
	.woocommerce .widget_price_filter .price_slider_amount .button,
	.woocommerce-page .widget_price_filter .price_slider_amount .button{
		font-size: <?php echo esc_html($ts_button_font_size); ?>;
		line-height: <?php echo esc_html($ts_button_font_line_height); ?>;
	}
	.yith-woocompare-widget a.clear-all,
	.yith-woocompare-widget a.compare{
		line-height: <?php echo esc_html($ts_button_font_line_height); ?>;
	}
	.product-hover-vertical-style-2 .products .product div.loop-add-to-cart a.button{
		font-size: <?php echo esc_html( absint($ts_button_font_size) - 2 ) . 'px'; ?> !important;
		line-height: <?php echo esc_html($ts_button_font_line_height); ?> !important;
	}
	#main-content .main-products.columns-1 .products .product div.loop-add-to-cart a.button{
		font-size: <?php echo esc_html($ts_button_font_size); ?> !important;
	}

	/*** Heading ***/
	h1, .h1,
	.h1 .elementor-heading-title,
	article.single-portfolio .entry-content > .entry-title,
	article.single .entry-header .entry-title{
		font-size: <?php echo esc_html($ts_h1_font_size); ?>;
		line-height: <?php echo esc_html($ts_h1_font_line_height); ?>;
	}
	h2, .h2,
	.h2 .elementor-heading-title,
	.breadcrumb-title-wrapper .page-title,
	.ts-blogs.columns-1 article .entry-title,
	.columns-0 .list-posts article:nth-child(5n+1) .entry-title{
		font-size: <?php echo esc_html($ts_h2_font_size); ?>;
		line-height: <?php echo esc_html($ts_h2_font_line_height); ?>;
	}
	h3, .h3,
	.h3 .elementor-heading-title,
	.list-posts article .entry-title,
	.columns-0 #main-content:not(.ts-col-24) .list-posts article:nth-child(5n+1) .entry-title,
	.woocommerce div.product .summary p.price,
	.woocommerce div.product .summary span.price,
	.yith-wfbt-section .total_price,
	.dokan-dashboard header.dokan-dashboard-header h1,
	#main-content .woocommerce.columns-1 > .products .product .meta-wrapper-2 .price{
		font-size: <?php echo esc_html($ts_h3_font_size); ?>;
		line-height: <?php echo esc_html($ts_h3_font_line_height); ?>;
	}
	h4, .h4,
	.h4 .elementor-heading-title,
	.woocommerce div.product .summary .entry-title,
	.ts-blogs.columns-2 article .entry-title,
	.columns-2 .list-posts article .entry-title,
	.theme-title .heading-title, 
	.comments-title .heading-title, 
	.woocommerce .cart-collaterals .cart_totals > h2,
	.woocommerce-billing-fields > h3,
	.woocommerce > form.checkout #order_review_heading,
	.woocommerce-MyAccount-content form > h3,
	#customer_login h2,
	.woocommerce-order-details > h2,
	.woocommerce div.product .woocommerce-tabs ul.tabs li,
	.ts-product-category-wrapper.style-grid .product .category-name h3,
	.woocommerce .cross-sells > h2,
	.woocommerce .up-sells > h2, 
	.woocommerce .related > h2, 
	.woocommerce.related > h2, 
	.yith-wfbt-section > h3,
	.woocommerce div.product > #reviews .woocommerce-Reviews-title,
	.woocommerce div.product.show-tabs-content-default:not(.tabs-in-summary) #reviews .woocommerce-Reviews-title,
	.widget-container .widget-title-wrapper,
	.column-tabs ul.tabs li,
	.related-portfolios .shortcode-title,
	.ts-shortcode .shortcode-heading-wrapper .shortcode-title{
		font-size: <?php echo esc_html($ts_h4_font_size); ?>;
		line-height: <?php echo esc_html($ts_h4_font_line_height); ?>;
	}
	h5, .h5,
	.h5 .elementor-heading-title,
	.ts-search-by-category > h2,
	.dropdown-container .theme-title,
	.ts-blogs article .entry-title,
	.columns-3 .list-posts article .entry-title,
	.columns-0 #main-content:not(.ts-col-24) .list-posts article:not(:nth-child(5n+1)) .entry-title,
	#comment-wrapper .heading-title,
	#reviews .woocommerce-Reviews-title,
	.woocommerce #reviews #comments h2,
	.portfolio-inner h4,
	.ts-list-of-product-categories-wrapper h3.heading-title,
	#main-content .woocommerce.columns-1 > .products .product .product-name{
		font-size: <?php echo esc_html($ts_h5_font_size); ?>;
		line-height: <?php echo esc_html($ts_h5_font_line_height); ?>;
	}
	h6, .h6,
	.h6 .elementor-heading-title,
	.ts-team-members h3,
	ul.blog-filter-bar li,
	.ts-portfolio-wrapper .filter-bar li,
	.widget-container .widget-title,
	body .dokan-category-menu h3.widget-title, 
	body .dokan-widget-area .widget .widget-title,
	body .wc-empty-cart-message .wc-block-components-notice-banner.is-info,
	body .cart-empty.woocommerce-info,
	.commentlist li #comment-wrapper .heading-title,
	.woocommerce .product .category-name h3,
	.ts-product-brand-wrapper .item .meta-wrapper h3,
	.woocommerce .widget_price_filter .price_slider_amount .button, 
	.woocommerce .woocommerce-widget-layered-nav-dropdown .woocommerce-widget-layered-nav-dropdown__submit,
	.woocommerce .tabs-in-summary #reviews #comments .woocommerce-Reviews-title,
	.elementor-widget-image-box .elementor-image-box-description{
		font-size: <?php echo esc_html($ts_h6_font_size); ?>;
		line-height: <?php echo esc_html($ts_h6_font_line_height); ?>;
	}
	.ts-product-categories-widget-wrapper ul li,
	.commentlist li strong{
		font-size: <?php echo esc_html($ts_h6_font_size); ?>;
	}
	.woocommerce #reviews .comment-reply-title,
	.woocommerce div.product.show-tabs-content-default:not(.tabs-in-summary) #reviews > .woocommerce-product-rating,
	.woocommerce div.product > #reviews > .woocommerce-product-rating{
		font-size: <?php echo esc_html( absint($ts_h6_font_size) + 2 ) . 'px'; ?>;
	}
	.woocommerce.archive #primary > .woocommerce-info,
	.woocommerce div.product.tabs-in-summary .woocommerce-tabs ul.tabs li,
	.elementor-widget-image-box .elementor-image-box-title{
		font-size: <?php echo esc_html( absint($ts_h6_font_size) + 3 ) . 'px'; ?>;
	}
	/*** Responsive font size ***/
	@media only screen and (max-width: 1279px){
		h1, .h1,
		.h1 .elementor-heading-title,
		article.single-portfolio .entry-content > .entry-title,
		article.single .entry-header .entry-title{
			font-size: <?php echo esc_html($ts_h1_ipad_font_size); ?>;
			line-height: <?php echo esc_html($ts_h1_ipad_font_line_height); ?>;
		}
		h2, .h2,
		.h2 .elementor-heading-title,
		.breadcrumb-title-wrapper .page-title{
			font-size: <?php echo esc_html($ts_h2_ipad_font_size); ?>;
			line-height: <?php echo esc_html($ts_h2_ipad_font_line_height); ?>;
		}
		h3, .h3,
		.h3 .elementor-heading-title,
		.ts-blogs.columns-1 article .entry-title,
		.columns-0 .list-posts article:nth-child(5n+1) .entry-title,
		.woocommerce div.product .summary p.price,
		.woocommerce div.product .summary span.price,
		.yith-wfbt-section .total_price,
		.dokan-dashboard header.dokan-dashboard-header h1,
		#main-content .woocommerce.columns-1 > .products .product .meta-wrapper-2 .price{
			font-size: <?php echo esc_html($ts_h3_ipad_font_size); ?>;
			line-height: <?php echo esc_html($ts_h3_ipad_font_line_height); ?>;
		}
		h4, .h4,
		.h4 .elementor-heading-title,
		.woocommerce div.product .summary .entry-title,
		.ts-blogs.columns-2 article .entry-title,
		.columns-2 .list-posts article .entry-title,
		.list-posts article .entry-title,
		.columns-0 #main-content:not(.ts-col-24) .list-posts article:nth-child(5n+1) .entry-title,
		.theme-title .heading-title, 
		.comments-title .heading-title, 
		.woocommerce .cart-collaterals .cart_totals > h2,
		.woocommerce-billing-fields > h3,
		.woocommerce > form.checkout #order_review_heading,
		.woocommerce-MyAccount-content form > h3,
		#customer_login h2,
		.woocommerce-order-details > h2,
		.woocommerce div.product .woocommerce-tabs ul.tabs li,
		.ts-product-category-wrapper.style-grid .product .category-name h3,
		.woocommerce .cross-sells > h2,
		.woocommerce .up-sells > h2, 
		.woocommerce .related > h2, 
		.woocommerce.related > h2, 
		.yith-wfbt-section > h3,
		.woocommerce div.product > #reviews .woocommerce-Reviews-title,
		.woocommerce div.product.show-tabs-content-default:not(.tabs-in-summary) #reviews .woocommerce-Reviews-title,
		.widget-container .widget-title-wrapper,
		.column-tabs ul.tabs li,
		.related-portfolios .shortcode-title,
		.ts-shortcode .shortcode-heading-wrapper .shortcode-title{
			font-size: <?php echo esc_html($ts_h4_ipad_font_size); ?>;
			line-height: <?php echo esc_html($ts_h4_ipad_font_line_height); ?>;
		}
		h5, .h5,
		.h5 .elementor-heading-title,
		.ts-search-by-category > h2,
		.dropdown-container .theme-title,
		.ts-blogs article .entry-title,
		.columns-3 .list-posts article .entry-title,
		.columns-0 #main-content:not(.ts-col-24) .list-posts article:not(:nth-child(5n+1)) .entry-title,
		#comment-wrapper .heading-title,
		#reviews .woocommerce-Reviews-title,
		.woocommerce #reviews #comments h2,
		.portfolio-inner h4,
		.ts-list-of-product-categories-wrapper h3.heading-title,
		#main-content .woocommerce.columns-1 > .products .product .product-name{
			font-size: <?php echo esc_html($ts_h5_ipad_font_size); ?>;
			line-height: <?php echo esc_html($ts_h5_ipad_font_line_height); ?>;
		}
		.woocommerce #reviews .comment-reply-title,
		.woocommerce div.product.show-tabs-content-default:not(.tabs-in-summary) #reviews > .woocommerce-product-rating,
		.woocommerce div.product > #reviews > .woocommerce-product-rating,
		.woocommerce.archive #primary > .woocommerce-info,
		.woocommerce div.product.tabs-in-summary .woocommerce-tabs ul.tabs li,
		.elementor-widget-image-box .elementor-image-box-title{
			font-size: <?php echo esc_html($ts_h6_font_size); ?>;
		}
		
		/*button/input*/
		input,
		textarea,
		keygen,
		select,
		select option,
		.woocommerce form .form-row input.input-text,
		.woocommerce form .form-row textarea,
		.dokan-form-control,
		#add_payment_method table.cart td.actions .coupon .input-text,
		.woocommerce-cart table.cart td.actions .coupon .input-text,
		.woocommerce-checkout table.cart td.actions .coupon .input-text,
		.woocommerce-columns > h3,
		.hidden-title-form input[type="text"]{
			font-size: <?php echo esc_html($ts_input_ipad_font_size); ?>;
		}
		.button,
		a.button,
		button,
		input[type^="submit"],
		.shopping-cart p.buttons a,
		a.wp-block-button__link,
		.woocommerce a.button,
		.woocommerce button.button,
		.woocommerce input.button,
		.woocommerce-page a.button,
		.woocommerce-page button.button,
		.woocommerce-page input.button,
		.woocommerce a.button.alt,
		.woocommerce button.button.alt,
		.woocommerce input.button.alt,
		.woocommerce-page a.button.alt,
		.woocommerce-page button.button.alt,
		.woocommerce-page input.button.alt,
		#content button.button,
		.woocommerce #respond input#submit, 
		div.button a,
		input[type="submit"].dokan-btn, 
		a.dokan-btn, 
		.dokan-btn,
		.wishlist_table .product-add-to-cart a,
		body .woocommerce table.compare-list .add-to-cart td a,
		.elementor-button-wrapper .elementor-button,
		.elementor-widget-wp-widget-yith-woocompare-widget a.clear-all,
		.elementor-widget-wp-widget-yith-woocompare-widget a.compare,
		.woocommerce .widget_price_filter .price_slider_amount .button,
		.woocommerce-page .widget_price_filter .price_slider_amount .button,
		.product-hover-vertical-style-2 .products .product div.loop-add-to-cart a.button{
			font-size: <?php echo esc_html($ts_button_ipad_font_size); ?>;
		}
		#main-content .main-products.columns-1 .products .product div.loop-add-to-cart a.button{
			font-size: <?php echo esc_html($ts_button_ipad_font_size); ?> !important;
		}
	}

	@media only screen and (max-width: 767px){
		h1, .h1,
		.h1 .elementor-heading-title,
		article.single-portfolio .entry-content > .entry-title,
		article.single .entry-header .entry-title{
			font-size: <?php echo esc_html($ts_h1_mobile_font_size); ?>;
			line-height: <?php echo esc_html($ts_h1_mobile_font_line_height); ?>;
		}
		h2, .h2,
		.h2 .elementor-heading-title,
		.breadcrumb-title-wrapper .page-title,
		.yith-wfbt-section .total_price{
			font-size: <?php echo esc_html($ts_h2_mobile_font_size); ?>;
			line-height: <?php echo esc_html($ts_h2_mobile_font_line_height); ?>;
		}
		h3, .h3,
		.h3 .elementor-heading-title,
		.woocommerce div.product .summary p.price,
		.woocommerce div.product .summary span.price,
		#main-content .woocommerce.columns-1 > .products .product .meta-wrapper-2 .price{
			font-size: <?php echo esc_html($ts_h3_mobile_font_size); ?>;
			line-height: <?php echo esc_html($ts_h3_mobile_font_line_height); ?>;
		}
		h4, .h4,
		.h4 .elementor-heading-title,
		.woocommerce div.product .summary .entry-title,
		.theme-title .heading-title, 
		.comments-title .heading-title, 
		.woocommerce .cart-collaterals .cart_totals > h2,
		.woocommerce-billing-fields > h3,
		.woocommerce > form.checkout #order_review_heading,
		.woocommerce-MyAccount-content form > h3,
		#customer_login h2,
		.woocommerce-order-details > h2,
		.woocommerce div.product .woocommerce-tabs ul.tabs li,
		.ts-product-category-wrapper.style-grid .product .category-name h3,
		.woocommerce .cross-sells > h2,
		.woocommerce .up-sells > h2, 
		.woocommerce .related > h2, 
		.woocommerce.related > h2, 
		.yith-wfbt-section > h3,
		.woocommerce div.product > #reviews .woocommerce-Reviews-title,
		.woocommerce div.product.show-tabs-content-default:not(.tabs-in-summary) #reviews .woocommerce-Reviews-title,
		#comment-wrapper .heading-title,
		#reviews .woocommerce-Reviews-title,
		.woocommerce #reviews #comments h2,
		.widget-container .widget-title-wrapper,
		.column-tabs ul.tabs li,
		.related-portfolios .shortcode-title,
		.ts-blogs article .entry-title,
		.ts-blogs.columns-2 article .entry-title,
		.ts-blogs.columns-1 article .entry-title,
		.list-posts article .entry-title,
		.columns-2 .list-posts article .entry-title,
		.columns-0 .list-posts article:nth-child(5n+1) .entry-title,
		.columns-1 .list-posts article .entry-title,
		.columns-0 #main-content:not(.ts-col-24) .list-posts article:nth-child(5n+1) .entry-title,
		.portfolio-inner h4,
		.ts-shortcode .shortcode-heading-wrapper .shortcode-title{
			font-size: <?php echo esc_html($ts_h4_mobile_font_size); ?>;
			line-height: <?php echo esc_html($ts_h4_mobile_font_line_height); ?>;
		}
		h5, .h5,
		.h5 .elementor-heading-title,
		.ts-search-by-category > h2,
		.dropdown-container .theme-title,
		.ts-list-of-product-categories-wrapper h3.heading-title,
		#main-content .woocommerce.columns-1 > .products .product .product-name{
			font-size: <?php echo esc_html($ts_h5_mobile_font_size); ?>;
			line-height: <?php echo esc_html($ts_h5_mobile_font_line_height); ?>;
		}
		.woocommerce #reviews .comment-reply-title,
		.woocommerce div.product.show-tabs-content-default:not(.tabs-in-summary) #reviews > .woocommerce-product-rating,
		.woocommerce div.product > #reviews > .woocommerce-product-rating{
			font-size: <?php echo esc_html($ts_body_font_size); ?>;
		}
	}
	@media only screen and (max-width: 480px){
		.columns-0 .list-posts article:not(:nth-child(5n+1)) .entry-title{
			font-weight: <?php echo esc_html($ts_body_font_medium_weight); ?>;
		}
	}

	/*--------------------------------------------------------
		III. CUSTOM COLOR
	---------------------------------------------------------*/
	/*** Background Content Color ***/
	body #main,
	body.dokan-store #main:before,
	#cboxLoadedContent,	
	.shopping-cart-wrapper .dropdown-container:before, 
	.my-account-wrapper .dropdown-container:before, 
	form.checkout div.create-account,
	.ts-popup-modal .popup-container,
	body #ts-search-result-container:before,
	body .select2-container--default .select2-selection--single .select2-selection__rendered,
	#yith-wcwl-popup-message,
	.dataTables_wrapper,
	body > .compare-list,
	.single-navigation > div .product-info:before,
	.single-navigation .product-info:before,
	.archive.ajax-pagination .woocommerce > .products:after,
	.dropdown-container ul.cart_list li.loading:before,
	.thumbnail-wrapper .button-in.wishlist > a.loading:before,
	.meta-wrapper .button-in.wishlist > a.loading:before,
	.woocommerce a.button.loading:before,
	.woocommerce button.button.loading:before,
	.woocommerce input.button.loading:before,
	div.blockUI.blockOverlay:before,
	.woocommerce .blockUI.blockOverlay:before,
	div.product .single-navigation a .product-info,
	.ts-floating-sidebar .ts-sidebar-content,
	#ts-mobile-button-bottom,
	.woocommerce .widget_price_filter .ui-slider .ui-slider-handle,
	.filter-widget-area-button a,
	.woocommerce .woocommerce-ordering, 
	.woocommerce-page .woocommerce-ordering,
	.woocommerce .woocommerce-ordering .orderby ul:before,
	.product-per-page-form ul.perpage ul:before,
	.product-per-page-form,
	.woocommerce div.product.images-summary-background div.summary,
	.woocommerce div.product.images-summary-background > *:not(.product-images-summary):before,
	.woocommerce div.product.images-summary-background .single-product-buttons-sharing:before,
	#comments .wcpr-filter-container ul.wcpr-filter-button-ul,
	body > #ts-search-result-container,
	.woocommerce-account .woocommerce-MyAccount-navigation li a,
	.archive.woocommerce .woocommerce .product-wrapper,
	.shopping-cart-wrapper .dropdown-container:before,
	.my-account-wrapper .dropdown-container:before,
	.wcml_currency_switcher > ul:before, 
	.wpml-ls-legacy-dropdown ul.wpml-ls-sub-menu:before,
	.wpml-ls-item-legacy-dropdown-click ul.wpml-ls-sub-menu:before{
		background-color: <?php echo esc_html($ts_main_content_background_color); ?>;
	}
	.cross-sells .product .product-group-button-meta > div:not(:last-child),
	.up-sells .product .product-group-button-meta > div:not(:last-child),
	.related .product .product-group-button-meta > div:not(:last-child),
	#tab-more_seller_product .product .product-group-button-meta > div:not(:last-child),
	.dokan-single-store .seller-items .product .product-group-button-meta > div:not(:last-child),
	.ts-product .product .product-group-button-meta > div:not(:last-child),
	.woocommerce.main-products:not(.columns-1) .product .product-group-button-meta > div:not(:last-child),
	.color-swatch > div:before,
	.product-filter-by-color ul li a:before,
	.ts-product-attribute div.option.color a:before{
		border-color: <?php echo esc_html($ts_main_content_background_color); ?>;
	}
	.ts-tiny-cart-wrapper li div.blockUI.blockOverlay,
	.widget_shopping_cart li div.blockUI.blockOverlay, 
	.elementor-widget-wp-widget-woocommerce_widget_cart li div.blockUI.blockOverlay{
		background-color: <?php echo esc_html($ts_main_content_background_color); ?> !important;
	}
	<?php if( strpos($ts_main_content_background_color, 'rgba') !== false ): ?>
	.more-less-buttons > a.more-button:after {
		background-image: -webkit-gradient(linear,left top,left bottom,color-stop(0,<?php echo esc_html(str_replace('1)', '0)', esc_html($ts_main_content_background_color))); ?>),to(<?php echo esc_html($ts_main_content_background_color); ?>));
		background-image: -o-linear-gradient(linear,left top,left bottom,color-stop(0,<?php echo esc_html(str_replace('1)', '0)', esc_html($ts_main_content_background_color))); ?>),to(<?php echo esc_html($ts_main_content_background_color); ?>));
		background-image: linear-gradient(to bottom,<?php echo esc_html(str_replace('1)', '0)', esc_html($ts_main_content_background_color))); ?> 0,<?php echo esc_html($ts_main_content_background_color); ?> 100%);
	}
	.ts-team-members .team-info{
		background-color: <?php echo esc_html(str_replace('1)', '0.9)', esc_html($ts_main_content_background_color))); ?>;
	}
	<?php endif; ?>

	/*** Body Text Color ***/
	body,
	body table.compare-list,
	.comment-author-link a,
	.widget-container li > a,
	.widget_categories li > a,
	.widget_archive li > a,
	.wp-block-archives-list li > a,
	.elementor-widget:not(.elementor-widget-ts-list-of-product-categories) .elementor-widget-container li > a,
	.header-top .header-currency ul,
	.header-top .wpml-ls-legacy-dropdown .wpml-ls-sub-menu, 
	.header-top .wpml-ls-legacy-dropdown-click .wpml-ls-sub-menu,
	.woocommerce #reviews #comments ol.commentlist li .comment-text p.meta,
	.ul-style.primary-color li{
		color: <?php echo esc_html($ts_text_color); ?>;
	}

	/*** Text bold color ***/
	.owl-nav > div:before,
	.ts-social-sharing li a,
	.woocommerce-info,
	.woocommerce .woocommerce-info,
	.alert.alert-success,
	div.wpcf7-mail-sent-ok,
	#yith-wcwl-popup-message,
	.woocommerce div.product .woocommerce-tabs ul.tabs li a,
	.woocommerce.yith-wfbt-section .yith-wfbt-images td > a,
	#ts-product-360-modal.ts-popup-modal .close,
	.more-less-buttons > a,
	.ts-availability-bar,
	.woocommerce-product-rating a,
	.woocommerce-product-rating a:hover,
	#reviews > .woocommerce-product-rating .review-count,
	.woocommerce-privacy-policy-text,
	.woocommerce > form.checkout a,
	body .hidden-title-form a,
	.ts-product-video-button,
	.ts-product-360-button,
	a[href^='tel:'],
	a[href^='mailto:'],
	.dokan-store-wrap .commentlist li p time,
	.ts-product-category-wrapper.style-grid .product .category-name h3 > a:after,
	.woocommerce div.product .single-product-buttons-sharing .single-product-buttons a,
	.widget_price_filter .price_slider_amount .price_label > span:first-child:after,
	dt,
	label ,
	p > label,
	fieldset div > label,
	blockquote,
	table thead th,
	.wpcf7 p,
	.woocommerce > form > fieldset legend,
	.woocommerce table.shop_table th,
	html input:focus:invalid:focus, 
	html select:focus:invalid:focus,
	#yith-wcwl-popup-message,
	table#wp-calendar thead th,
	.woocommerce table.shop_attributes th,
	body a.button-text,
	.woocommerce-cart table.cart td.actions .button,
	body .button-text a,
	.column-tabs ul.tabs li,
	.ts-banner.text-under-image .box-content .description,
	.ts-banner.text-under-image .box-content h2,
	.ts-banner.text-under-image .box-content h6,
	.ts-banner.text-under-image.style-arrow .ts-banner-button a,
	body table.compare-list th,
	body table.compare-list tr.title th,
	body table.compare-list tr.image th,
	body table.compare-list tr.price th{
		color: <?php echo esc_html($ts_text_bold_color); ?>;
	}
	#to-top a,
	.owl-dot.active,
	.social-icons .list-icons .ts-tooltip,
	.ts-product-category-wrapper.style-grid .product .category-name h3 > a:before,
	.woocommerce .widget_price_filter .ui-slider .ui-slider-handle{
		background: <?php echo esc_html($ts_text_bold_color); ?>;
	}
	.product-on-sale-form.checked label:before,
	.woocommerce.yith-wfbt-section .yith-wfbt-form .yith-wfbt-items li span.checkboxbutton.checked,
	.widget-container.product-filter-by-brand ul > li.selected label:before,
	.product-filter-by-availability ul li input[checked="checked"] + label:before,
	.product-filter-by-price ul li.chosen label:before,
	.woocommerce .woocommerce-widget-layered-nav-list .woocommerce-widget-layered-nav-list__item--chosen a:before,
	.woocommerce .widget_rating_filter ul li.chosen a::before,
	.woocommerce .widget_price_filter .ui-slider-horizontal .ui-slider-range:before{
		background: <?php echo esc_html($ts_text_bold_color); ?>;
		border-color: <?php echo esc_html($ts_text_bold_color); ?>;
	}
	#to-top a,
	.product-group-button .button-tooltip,
	.thumbnail-wrapper .product-group-button > div:hover,
	.product-on-sale-form.checked label:after,
	.woocommerce.yith-wfbt-section .yith-wfbt-form .yith-wfbt-items li span.checkboxbutton.checked:after,
	.widget-container.product-filter-by-brand ul > li.selected label:after,
	.product-filter-by-availability ul li input[checked="checked"] + label:after,
	.product-filter-by-price ul li.chosen label:after,
	.woocommerce .woocommerce-widget-layered-nav-list .woocommerce-widget-layered-nav-list__item--chosen a:after,
	.woocommerce .widget_rating_filter ul li.chosen a::after,
	.woocommerce .widget_price_filter .ui-slider-horizontal .ui-slider-range:after{
		color: <?php echo esc_html($ts_text_color_in_bg_primary); ?>;
	}
	.social-icons .list-icons .ts-tooltip:before{
		border-top-color: <?php echo esc_html($ts_text_bold_color); ?>;
	}
	html body > h1,
	.dropdown-container .theme-title span,
	.my-wishlist-wrapper .tini-wishlist .count-number,
	.shopping-cart-wrapper .cart-control .cart-number,
	.breadcrumb-title-wrapper .page-title .count,
	.threesixty .nav_bar a,
	body #ts-ajax-add-to-cart-message,
	.add-to-cart-popup-content .heading .theme-title,
	.cats-portfolio a,
	.portfolio-info .cat-links a,
	.portfolio-inner a.like,
	.portfolio-info .portfolio-like,
	.tags-link a,
	.wp-block-tag-cloud a,
	.tagcloud a{
		background: <?php echo esc_html($ts_text_bold_color); ?>;
		border-color: <?php echo esc_html($ts_text_bold_color); ?>;
		color: <?php echo esc_html($ts_text_color_in_bg_primary); ?>;
	}
	.tags-link a:hover,
	.cats-portfolio a:hover,
	.portfolio-info .cat-links a:hover,
	.portfolio-inner a.like:hover,
	.portfolio-info .portfolio-like:hover,
	.threesixty .nav_bar a:hover,
	.wp-block-tag-cloud a:hover,
	.tagcloud a:hover{
		background: transparent;
		color: <?php echo esc_html($ts_text_bold_color); ?>;
	}
	.product-group-button > div a:after,
	.product-group-button-meta > div.button-in a:before,
	.cross-sells .product .product-group-button-meta > div.loop-add-to-cart > a.button:before,
	.up-sells .product .product-group-button-meta > div.loop-add-to-cart > a.button:before,
	.related .product .product-group-button-meta > div.loop-add-to-cart > a.button:before,
	#tab-more_seller_product .product .product-group-button-meta > div.loop-add-to-cart > a.button:before,
	.dokan-single-store .seller-items .product .product-group-button-meta > div.loop-add-to-cart > a.button:before,
	.woocommerce.main-products:not(.columns-1) .product .product-group-button-meta > div.loop-add-to-cart > a.button:before,
	.ts-product .product-group-button-meta > div.loop-add-to-cart > a.button:before{
		color: <?php echo esc_html($ts_text_bold_color); ?>;
	}
	.product-group-button > div:hover a:after{
		color: <?php echo esc_html($ts_text_color_in_bg_primary); ?>;
	}
	
	.woocommerce div.product div.images .woocommerce-product-gallery__trigger,
	.thumbnail-wrapper .product-group-button > div,
	.portfolio-thumbnail > figure ~ .cats-portfolio a,
	.portfolio-thumbnail > figure ~ a.like{
		background: <?php echo esc_html($ts_text_color_in_bg_primary); ?>;
		border-color: <?php echo esc_html($ts_text_color_in_bg_primary); ?>;
		color: <?php echo esc_html($ts_text_bold_color); ?>;
	}
	.list-posts article .tags-link a,
	.ts-blogs article .tags-link a{
		background: <?php echo esc_html($ts_text_color_in_bg_primary); ?>;
		border-color: <?php echo esc_html($ts_border_color); ?>;
		color: <?php echo esc_html($ts_text_bold_color); ?>;
	}
	.list-posts article .tags-link a:hover{
		background: transparent;
	}
	.list-posts article.has-post-thumbnail .tags-link a:hover,
	.ts-blogs article .tags-link a:hover,
	.blog-template:not(.index-template) .list-posts article.format-video .tags-link a:hover,
	.portfolio-thumbnail > figure ~ .cats-portfolio a:hover,
	.portfolio-thumbnail > figure ~ a.like:hover{
		background: transparent;
		color: <?php echo esc_html($ts_text_color_in_bg_primary); ?>;
	}
	.ts-pagination ul li a:focus,
	.ts-pagination ul li a:hover,
	.ts-pagination ul li span.current,
	.pagination-wrap ul.pagination > li > a:hover,
	.pagination-wrap ul.pagination > li > span.current,
	.dokan-pagination-container .dokan-pagination li:hover a,
	.dokan-pagination-container .dokan-pagination li.active a,
	.woocommerce nav.woocommerce-pagination ul li a:focus, 
	.woocommerce nav.woocommerce-pagination ul li a:hover, 
	.woocommerce nav.woocommerce-pagination ul li span.current{
		background: <?php echo esc_html($ts_text_bold_color); ?> !important;
		color: <?php echo esc_html($ts_text_color_in_bg_primary); ?> !important;
	}
	.woocommerce a.remove,
	.ts-floating-sidebar .close, 
	.cart_list li a.remove,
	ul.products-list a.remove,
	table.shop_table .product-remove a,
	table.compare-list tr.remove td > a .remove,
	.woocommerce .widget_price_filter .price_slider_amount .button, 
	.woocommerce .woocommerce-widget-layered-nav-dropdown .woocommerce-widget-layered-nav-dropdown__submit{
		color: <?php echo esc_html($ts_text_bold_color); ?> !important;
	}
	.flex-control-nav.flex-control-paging li a.flex-active,
	.thumbnail-wrapper .product-group-button > div:hover,
	.product-group-button .button-tooltip:before{
		background: <?php echo esc_html($ts_text_bold_color); ?>;
	}	
	.ts-banner.text-under-image.style-arrow .ts-banner-button svg path{
		fill: <?php echo esc_html($ts_text_bold_color); ?>;
	}
	.column-tabs ul.tabs li:after{
		border-color: <?php echo esc_html($ts_text_bold_color); ?>;
	}

	/*** Heading Text Color ***/
	h1,h2,h3,h4,h5,h6,
	.h1,.h2,.h3,.h4,.h5,.h6{
		color: <?php echo esc_html($ts_heading_color); ?>;
	}
	
	/*** Primary color ***/
	.primary-color,
	.hightlight,
	.ts-sold-in-24h,
	.ul-style.primary-color li:before,
	.woocommerce-tabs .ul-style li:before,
	.short-description .ul-style li:before,
	.woocommerce-product-details__short-description .ul-style li:before,
	blockquote:before,
	.out-of-stock .availability-text,
	.woocommerce div.product form.cart .woocommerce-variation-availability p.stock.out-of-stock,
	.yith-wfbt-section .total_price,
	.elementor-lightbox .dialog-lightbox-close-button:hover,
	.ts-store-notice .close:hover,
	body #cboxClose:hover:after,
	html body > h1 a.close:hover,
	body table.compare-list tr.remove td > a:hover,
	.elementor-lightbox .elementor-swiper-button:hover,
	.woocommerce-account .addresses .title .edit:hover:before,
	body .hidden-title-form a:hover,
	body.woocommerce .hidden-title-form a.hide-title-form:hover, 
	body.woocommerce .hidden-title-form a.save-title-form:hover,
	.ts-header a:hover,
	.my-account-wrapper .dropdown-container a:hover,
	body .wpml-ls-legacy-dropdown a:hover, 
	body .wpml-ls-legacy-dropdown a:focus,
	body .wpml-ls-legacy-dropdown .wpml-ls-current-language:hover>a,
	body .wpml-ls-legacy-dropdown-click a:hover, 
	body .wpml-ls-legacy-dropdown-click a:focus, 
	body .wpml-ls-legacy-dropdown-click .wpml-ls-current-language:hover>a,
	.ts-search-result-container .view-all-wrapper a:hover,
	.woocommerce .ts-search-result-container ul.product_list_widget ul.ul-style li:before,
	.woocommerce.ts-search-result-container ul.product_list_widget ul.ul-style li:before,
	.woocommerce div.product .single-product-buttons-sharing .single-product-buttons a:hover,
	.woocommerce div.product .woocommerce-tabs ul.tabs li:not(.active) a:hover{
		color: <?php echo esc_html($ts_primary_color); ?>;
	}
	.ts-language-switcher a:hover, 
	.ts-currency-switcher a:hover,
	#ts-product-video-modal .close:hover,
	ul.products-list a.remove:hover,
	table.shop_table .product-remove a:hover,
	table.compare-list tr.remove td > a .remove:hover,
	.cart_list li a.remove:hover{
		color: <?php echo esc_html($ts_primary_color); ?> !important;
	}
	#to-top a:hover,
	.ts-availability-bar .progress-bar > span{
		background: <?php echo esc_html($ts_primary_color); ?>;
	}	
	.ts-sold-in-24h svg path,
	.shopping-cart-wrapper:hover .cart-icon svg path, 
	.my-wishlist-wrapper:hover svg path, 
	.search-button:hover svg path, 
	.my-account-wrapper:hover svg path,
	.header-transparent.header-text-light .header-template > div:not(.is-sticky) .shopping-cart-wrapper:hover .cart-icon svg path, 
	.header-transparent.header-text-light .header-template > div:not(.is-sticky) .my-wishlist-wrapper:hover svg path, 
	.header-transparent.header-text-light .header-template > div:not(.is-sticky) .search-button:hover svg path, 
	.header-transparent.header-text-light .header-template > div:not(.is-sticky) .my-account-wrapper:hover svg path{
		stroke: <?php echo esc_html($ts_primary_color); ?>;
	}

	/*** Menu ***/
	.ts-header .ts-menu{
		color: <?php echo esc_html($ts_menu_text_color); ?>;
	}
	.ts-menu ul li > a:hover, 
	.ts-menu ul li.current-menu-item > a, 
	.ts-menu ul li.current-menu-parent > a, 
	.ts-menu ul li.current-menu-ancestor > a, 
	.ts-menu ul li.current-product_cat-ancestor > a,
	.ts-menu ul li.current-menu-item > .ts-menu-drop-icon, 
	.ts-menu ul li.current-menu-parent > .ts-menu-drop-icon, 
	.ts-menu ul li.current-menu-ancestor > .ts-menu-drop-icon, 
	.ts-menu ul .sub-menu li.current-menu-item > a, 
	.ts-menu ul .sub-menu li.current-menu-parent > a, 
	.ts-menu ul .sub-menu li.current-menu-ancestor > a, 
	.ts-menu ul .sub-menu li.current-product_cat-ancestor > a,
	.ts-menu ul .sub-menu li.current-menu-item > .ts-menu-drop-icon, 
	.ts-menu ul .sub-menu li.current-menu-parent > .ts-menu-drop-icon, 
	.ts-menu ul .sub-menu li.current-menu-ancestor > .ts-menu-drop-icon,
	.header-transparent.header-text-light .header-template > div:not(.is-sticky) .header-middle .menu-wrapper nav > ul.menu > li > a .menu-label:before,
	.header-transparent.header-text-light .header-template > div:not(.is-sticky) .header-middle .menu-wrapper nav > ul.menu > li.current-menu-item > a, 
	.header-transparent.header-text-light .header-template > div:not(.is-sticky) .header-middle .menu-wrapper nav > ul.menu > li.current_page_parent > a, 
	.header-transparent.header-text-light .header-template > div:not(.is-sticky) .header-middle .menu-wrapper nav > ul.menu > li.current-menu-parent > a, 
	.header-transparent.header-text-light .header-template > div:not(.is-sticky) .header-middle .menu-wrapper nav > ul.menu > li.current_page_item > a, 
	.header-transparent.header-text-light .header-template > div:not(.is-sticky) .header-middle .menu-wrapper nav > ul.menu > li.current-menu-ancestor > a, 
	.header-transparent.header-text-light .header-template > div:not(.is-sticky) .header-middle .menu-wrapper nav > ul.menu > li.current-page-ancestor > a, 
	.header-transparent.header-text-light .header-template > div:not(.is-sticky) .header-middle .menu-wrapper nav > ul.menu > li.current-product_cat-ancestor > a{
		color: <?php echo esc_html($ts_menu_text_hover); ?> !important;
	}
	.ts-header nav > ul.menu li ul.sub-menu:before,
	.ts-header nav > ul.menu li ul.sub-menu:after{
		background-color: <?php echo esc_html($ts_sub_menu_background_color); ?>;
	}
	.footer-container .elementor-widget-container > h5,
	.ts-megamenu-container .elementor-widget-container > h5,
	.footer-container .ts-list-of-product-categories-wrapper h3.heading-title,
	.ts-megamenu-container .ts-list-of-product-categories-wrapper h3.heading-title{
		color: <?php echo esc_html($ts_sub_menu_heading_color); ?>;
	}
	
	/*** Link Color ***/
	a{
		color: <?php echo esc_html($ts_link_color); ?>;
	}
	a:hover,
	.product-brands a:hover,
	.product-categories a:hover,
	.woocommerce div.product .summary .product-brands a:hover,
	.woocommerce div.product .summary .cat-links a:hover,
	.woocommerce div.product .summary .tag-links a:hover,
	.ts-product-category-wrapper .product .category-name a:hover,
	.comments-area .add-comment > a:hover,
	.commentlist li.comment .comment-actions a:hover{
		color: <?php echo esc_html($ts_link_color_hover); ?>;
	}

	/*** Button/Input Color ***/
	.button,
	a.button,
	button,
	input[type^="submit"],
	.shopping-cart p.buttons a,
	a.wp-block-button__link,
	.is-style-outline>.wp-block-button__link:not(.has-background):hover,
	.wp-block-button__link.is-style-outline:not(.has-background):hover,
	.woocommerce a.button,
	.woocommerce button.button,
	.woocommerce input.button,
	.woocommerce-page a.button,
	.woocommerce-page button.button,
	.woocommerce-page input.button,
	.woocommerce a.button.alt,
	.woocommerce button.button.alt,
	.woocommerce input.button.alt,
	.woocommerce-page a.button.alt,
	.woocommerce-page button.button.alt,
	.woocommerce-page input.button.alt,
	#content button.button,
	.woocommerce #respond input#submit, 
	div.button a,
	input[type="submit"].dokan-btn, 
	a.dokan-btn, 
	.dokan-btn,
	.wishlist_table .product-add-to-cart a,
	body .woocommerce table.compare-list .add-to-cart td a,
	.yith-woocompare-widget a.clear-all,
	.elementor-widget-wp-widget-yith-woocompare-widget a.clear-all,
	.woocommerce .widget_price_filter .price_slider_amount .button,
	.woocommerce-page .widget_price_filter .price_slider_amount .button,
	.product-hover-vertical-style-2 .thumbnail-wrapper .product-group-button > div.loop-add-to-cart,
	div.wpcf7 input[type^="submit"]:hover,
	.woocommerce a.button.disabled,
	.woocommerce a.button.disabled:hover,
	.woocommerce a.button:disabled,
	.woocommerce a.button:disabled[disabled], 
	.woocommerce a.button:disabled[disabled]:hover, 
	.woocommerce button.button.disabled, 
	.woocommerce button.button:disabled,
	.woocommerce button.button:disabled[disabled], 
	.woocommerce input.button.disabled, 
	.woocommerce input.button:disabled, 
	.woocommerce input.button:disabled[disabled],
	.woocommerce #respond input#submit.alt.disabled,
	.woocommerce #respond input#submit.alt.disabled:hover,
	.woocommerce #respond input#submit.alt:disabled,
	.woocommerce #respond input#submit.alt:disabled:hover,
	.woocommerce #respond input#submit.alt:disabled[disabled],
	.woocommerce #respond input#submit.alt:disabled[disabled]:hover,
	.woocommerce a.button.alt.disabled, 
	.woocommerce a.button.alt.disabled:hover,
	.woocommerce a.button.alt:disabled, 
	.woocommerce a.button.alt:disabled:hover,
	.woocommerce a.button.alt:disabled[disabled], 
	.woocommerce a.button.alt:disabled[disabled]:hover, 
	.woocommerce button.button.alt.disabled, 
	.woocommerce button.button.alt.disabled:hover, 
	.woocommerce button.button.alt:disabled, 
	.woocommerce button.button.alt:disabled:hover, 
	.woocommerce button.button.alt:disabled[disabled], 
	.woocommerce button.button.alt:disabled[disabled]:hover, 
	.woocommerce input.button.alt.disabled, 
	.woocommerce input.button.alt.disabled:hover, 
	.woocommerce input.button.alt:disabled, 
	.woocommerce input.button.alt:disabled:hover, 
	.woocommerce input.button.alt:disabled[disabled], 
	.woocommerce input.button.alt:disabled[disabled]:hover,
	.woocommerce div.product .summary a.button.ts-buy-now-button:hover{
		background: <?php echo esc_html($ts_button_background_color); ?>;
		border-color: <?php echo esc_html($ts_button_border_color); ?>;
		color: <?php echo esc_html($ts_button_text_color); ?>;
	}
	div.wpcf7 input[type^="submit"],
	.button:hover,
	a.button:hover,
	button:hover,
	input[type^="submit"]:hover,
	.shopping-cart p.buttons a:hover,
	.woocommerce a.button:hover,
	.woocommerce button.button:hover,
	.woocommerce input.button:hover,
	.woocommerce-page a.button:hover,
	.woocommerce-page button.button:hover,
	.woocommerce-page input.button:hover,
	.woocommerce a.button.alt:hover,
	.woocommerce button.button.alt:hover,
	.woocommerce input.button.alt:hover,
	.woocommerce-page a.button.alt:hover,
	.woocommerce-page button.button.alt:hover,
	.woocommerce-page input.button.alt:hover,
	#content button.button:hover,
	.woocommerce #respond input#submit:hover, 
	div.button a:hover,
	input[type="submit"].dokan-btn:hover,
	input[type='submit'].dokan-btn-success:hover, 
	a.dokan-btn-success:hover, .dokan-btn-success:hover, 
	input[type='submit'].dokan-btn-success:focus, 
	a.dokan-btn-success:focus, .dokan-btn-success:focus, 
	input[type='submit'].dokan-btn-success:active, 
	a.dokan-btn-success:active, 
	.dokan-btn-success:active, input[type='submit'].dokan-btn-success.active,
	a.dokan-btn-success.active, 
	.dokan-btn-success.active, 
	.open .dropdown-toggleinput[type='submit'].dokan-btn-success, 
	.open .dropdown-togglea.dokan-btn-success, 
	.open .dropdown-toggle.dokan-btn-success,
	a.dokan-btn:hover, 
	.dokan-btn:hover,
	.wishlist_table .product-add-to-cart a:hover,
	a.wp-block-button__link:hover,
	.is-style-outline>.wp-block-button__link:not(.has-background),
	.wp-block-button__link.is-style-outline:not(.has-background),
	body .woocommerce table.compare-list .add-to-cart td a:hover,
	.yith-woocompare-widget a.clear-all:hover,
	.woocommerce div.product .summary a.button.ts-buy-now-button,
	.elementor-widget-wp-widget-yith-woocompare-widget a.clear-all:hover,
	.woocommerce .widget_price_filter .price_slider_amount .button:hover,
	.woocommerce-page .widget_price_filter .price_slider_amount .button:hover{
		color: <?php echo esc_html($ts_button_text_hover); ?>;
		background: <?php echo esc_html($ts_button_background_hover); ?>;
		border-color: <?php echo esc_html($ts_button_border_hover); ?>;
	}
	.product-hover-vertical-style-2 .thumbnail-wrapper .product-group-button > div.loop-add-to-cart:hover{
		background: <?php echo esc_html($ts_primary_color); ?>;
	}
	.button-primary,
	.button.button-primary,
	.shop-more a.button,
	body.error404 article a.button,
	.woocommerce-page button.button.button-primary,
	.load-more-wrapper .button,
	.ts-shop-load-more .button,
	.woocommerce .ts-shop-load-more .button,
	.woocommerce-cart .return-to-shop a.button,
	.widget_shopping_cart .buttons a.checkout,
	.yith-woocompare-widget a.compare,
	.elementor-button-wrapper .elementor-button,
	.elementor-widget-wp-widget-yith-woocompare-widget a.compare,
	.elementor-widget-wp-widget-woocommerce_widget_cart .buttons a.checkout,
	.dropdown-footer > a.button.checkout-button{
		background: <?php echo esc_html($ts_primary_color); ?>;
		border-color: <?php echo esc_html($ts_primary_color); ?>;
		color: <?php echo esc_html($ts_text_color_in_bg_primary); ?>;
	}
	.button-primary:hover,
	.button.button-primary:hover,
	.shop-more a.button:hover,
	body.error404 article a.button:hover,
	.woocommerce-page button.button.button-primary:hover,
	.load-more-wrapper .button:hover,
	.ts-shop-load-more .button:hover,
	.woocommerce .ts-shop-load-more .button:hover,
	.woocommerce-cart .return-to-shop a.button:hover,
	.widget_shopping_cart .buttons a.checkout:hover,
	.yith-woocompare-widget a.compare:hover,
	.elementor-button-wrapper .elementor-button:hover,
	.elementor-widget-wp-widget-yith-woocompare-widget a.compare:hover,
	.elementor-widget-wp-widget-woocommerce_widget_cart .buttons a.checkout:hover,
	.dropdown-footer > a.button.checkout-button:hover{
		background: <?php echo esc_html($ts_text_color_in_bg_primary); ?>;
		color: <?php echo esc_html($ts_primary_color); ?>;
		border-color: <?php echo esc_html($ts_primary_color); ?>;
	}
	select,
	textarea,
	html input[type="search"],
	html input[type="text"],
	html input[type="email"],
	html input[type="password"],
	html input[type="date"],
	html input[type="number"],
	html input[type="tel"],
	textarea.dokan-form-control,
	select.dokan-form-control,
	.woocommerce form .form-row .input-text, 
	.woocommerce form .form-row select,
	body .select2-container--default .select2-search--dropdown .select2-search__field,
	body .select2-container--default .select2-selection--single,
	body .select2-dropdown,
	body .select2-container .select2-dropdown, 
	body .select2-container .select2-selection,
	body .select2-container--open .select2-dropdown--below,
	body .select2-container--default .select2-selection--single,
	body .select2-container--default .select2-search--dropdown .select2-search__field,
	.woocommerce form .form-row.woocommerce-validated .select2-container,
	.woocommerce form .form-row.woocommerce-validated input.input-text,
	.woocommerce form .form-row.woocommerce-validated select,
	body .select2-container--default .select2-selection--multiple{
		color: <?php echo esc_html($ts_input_text_color); ?>;
		background-color: <?php echo esc_html($ts_input_background_color); ?>;
		border-color: <?php echo esc_html($ts_input_border_color); ?>;
	}
	#add_payment_method table.cart td.actions .coupon .input-text, 
	.woocommerce-cart table.cart td.actions .coupon .input-text, 
	.woocommerce-checkout table.cart td.actions .coupon .input-text{
		border-color: <?php echo esc_html($ts_input_border_color); ?>;
	}
	.ts-search-by-category > form .search-content input[type="text"]{
		background-color: <?php echo esc_html($ts_input_search_background_color); ?>;
		border-color: <?php echo esc_html($ts_input_search_border_color); ?>;
	}
	.woocommerce .wishlist-title a.show-title-form, 
	.woocommerce .hidden-title-form a.hide-title-form, 
	.wishlist_manage_table tfoot a.create-new-wishlist {
		background-color: <?php echo esc_html($ts_border_color); ?>;
		color: <?php echo esc_html($ts_input_text_color); ?>;
	}
	.woocommerce .wishlist-title a.show-title-form:hover, 
	.woocommerce .hidden-title-form a.hide-title-form:hover, 
	.wishlist_manage_table tfoot a.create-new-wishlist:hover {
		background-color: <?php echo esc_html($ts_primary_color); ?>;
		color: <?php echo esc_html($ts_text_color_in_bg_primary); ?>;
	}

	/*** Border Color ***/
	*,
	.entry-meta-bottom,
	.commentlist li.comment,
	.woocommerce #reviews #comments ol.commentlist li,
	.ts-tiny-cart-wrapper .total, 
	.widget_shopping_cart .total,
	.elementor-widget-wp-widget-woocommerce_widget_cart .total,
	#main-content .woocommerce.columns-1 > .products .product:after,
	.twitter-wrapper .avatar-name img,
	body.single-post article .entry-format.no-featured-image,
	.product-on-sale-form > label:before,
	.woocommerce table.shop_table tbody th,
	.woocommerce table.shop_table tfoot td,
	.woocommerce table.shop_table tfoot th,
	#group-icon-header .menu-title span:before,
	#group-icon-header .group-button-header:before,
	.woocommerce div.product form.cart table.group_table td,
	.woocommerce form.checkout_coupon, 
	.woocommerce .checkout-login-coupon-wrapper form.login,
	.ts-product-brand-wrapper .item img,
	body #yith-woocompare table.compare-list tbody th, 
	body #yith-woocompare table.compare-list tbody td,
	.list-categories:after,
	.color-swatch > div img,
	.product-filter-by-color ul li a img,
	.ts-product-attribute a img,
	.product-filter-by-brand ul li label:before,
	.product-filter-by-price ul li label:before,
	.product-filter-by-availability ul li label:before,
	.woocommerce .widget_rating_filter ul li.chosen a::before,
	.woocommerce .widget_rating_filter ul li a:before,
	.woocommerce .woocommerce-widget-layered-nav-list .woocommerce-widget-layered-nav-list__item a:before,
	.woocommerce .widget_price_filter .price_slider_wrapper .ui-widget-content:after,
	.woocommerce .widget_price_filter .price_slider_wrapper .ui-widget-content:before,
	.dokan-dashboard .dokan-dashboard-content .edit-account fieldset,
	.columns-1 .list-posts article:after, .columns-1.ts-blogs article:after,
	.woocommerce table.shop_table.wishlist_table tr th, 
	.woocommerce table.shop_table.wishlist_table tr td,	
	.columns-0 .list-posts article:nth-child(5n+1):before, 
	.columns-0 .list-posts article:nth-child(5n+1):after{
		border-color: <?php echo esc_html($ts_border_color); ?>;
	}
	.list-posts article:after{
		border-color: <?php echo esc_html($ts_border_color); ?> !important;
	}
	.ts-availability-bar .progress-bar,
	.woocommerce .widget_price_filter .price_slider_wrapper .ui-widget-content{
		background: <?php echo esc_html($ts_border_color); ?>;
	}	
	.tagcloud .tag-link-count{
		color: <?php echo esc_html($ts_border_color); ?>;
	}
	.widget_categories > ul li.cat-parent > span.icon-toggle,
	.elementor-widget-wp-widget-categories > ul li.cat-parent > span.icon-toggle,
	.ts-product-categories-widget-wrapper > ul li.cat-parent > span.icon-toggle{
		border-color: <?php echo esc_html($ts_border_color); ?>;
		color: <?php echo esc_html($ts_text_bold_color); ?>;
	}
	.woocommerce div.product .woocommerce-tabs ul.tabs li a:after,
	.ts-product-attribute > div.option:not(.color).selected > a,
	.woocommerce div.product.color-variation-thumbnail .ts-product-attribute div.option.color a:hover img,
	.woocommerce div.product.color-variation-thumbnail .ts-product-attribute div.option.color.selected a img,
	.ts-product-attribute > div.option:not(.color):hover > a{
		border-color: <?php echo esc_html($ts_text_bold_color); ?>;
	}
	.woocommerce div.product.color-variation-thumbnail .ts-product-attribute div.option.color a:after{
		background: <?php echo esc_html($ts_text_bold_color); ?>;
	}
	blockquote,
	.entry-author,
	#add_payment_method #payment div.payment_box,
	.woocommerce-cart #payment div.payment_box,
	.woocommerce-checkout #payment div.payment_box{
		background: <?php echo esc_html($ts_border_color); ?>;
	}
	#add_payment_method #payment div.payment_box::before,
	.woocommerce-cart #payment div.payment_box::before,
	.woocommerce-checkout #payment div.payment_box::before{
		border-bottom-color: <?php echo esc_html($ts_border_color); ?>;
	}

	/*** Header Color ***/
	.ts-store-notice,
	.woocommerce-account .woocommerce-MyAccount-navigation{
		background: <?php echo esc_html($ts_notice_background_color); ?>;
		color: <?php echo esc_html($ts_notice_text_color); ?>;
	}
	.header-top{
		background: <?php echo esc_html($ts_header_top_background_color); ?>;
		color: <?php echo esc_html($ts_header_top_text_color); ?>;
		border-color: <?php echo esc_html($ts_header_top_border_color); ?>;
	}
	.header-top .header-left > *:not(:last-child),
	.header-top div.header-right > *:not(:first-child){
		border-color: <?php echo esc_html($ts_header_top_border_color); ?>;
	}
	.header-middle,
	.header-bottom{
		background: <?php echo esc_html($ts_header_background_color); ?>;
		color: <?php echo esc_html($ts_header_text_color); ?>;
		border-color: <?php echo esc_html($ts_header_border_color); ?>;
	}
	.ts-header nav > ul.menu li ul.sub-menu:before,
	.ts-header .header-middle .menu-wrapper:before,
	.header-v2 .ts-header nav > ul.menu li ul.sub-menu:before{
		border-color: <?php echo esc_html($ts_header_border_color); ?>;
	}
	.header-language, 
	.header-currency,
	.ts-language-switcher,
	.ts-currency-switcher,
	#group-icon-header .group-button-header,	
	.ts-search-result-container .description,
	.woocommerce-privacy-policy-text,
	.woocommerce-MyAccount-content > form .form-row > span > em,
	.yith-wcwl-share .yith-wcwl-after-share-section,
	.menu-desc,
	.mobile-menu-wrapper .mobile-menu > ul > li.font-body > a,
	.ts-header nav.main-menu > ul.menu > li.font-body > a, 
	.ts-header nav.main-menu > ul > li.font-body > a{
		color: <?php echo esc_html($ts_text_gray_color); ?>;
	}
	.widget_archive li,
	.wp-block-archives-list li,
	.widget_categories li,
	.elementor-widget-wp-widget-categories li,
	.product-filter-by-color ul li .count,
	ul.product_list_widget li .reviewer,
	.woocommerce-product-rating .review-count,
	.elementor-widget-wp-widget-recent-posts .post-date,
	#cancel-comment-reply-link,
	.products .product .count-rating,
	.woocommerce .product .category-name .count,
	.ts-product-brand-wrapper .item .count,
	.woocommerce .widget_rating_filter ul li a,
	.woocommerce .woocommerce-widget-layered-nav-list .woocommerce-widget-layered-nav-list__item .count,
	.product-filter-by-brand li label .count,
	.comments-area .navigation .nav-previous + .nav-next:before,
	.commentlist li.comment .comment-actions a{
		color: <?php echo esc_html($ts_text_gray_color); ?>;
	}
	.shopping-cart-wrapper .cart-icon svg path, 
	.icon-menu-sticky-header svg line,
	.my-wishlist-wrapper svg path, 
	.search-button svg path, 
	.my-account-wrapper svg path{
		stroke: <?php echo esc_html($ts_header_icon_color); ?>;
	}	
	
	/*** Breadcrumbs ***/
	.breadcrumb-title-wrapper{
		background-color: <?php echo esc_html($ts_breadcrumb_background_color); ?>;
	}
	.breadcrumb-title-wrapper .breadcrumbs,
	.breadcrumb-title-wrapper .page-title{
		color: <?php echo esc_html($ts_breadcrumb_text_color); ?>;
	}
	.breadcrumb-title-wrapper .breadcrumbs a,
	.breadcrumb-title-wrapper .brn_arrow:before{
		color: <?php echo esc_html($ts_breadcrumb_link_color); ?>;
	}
	
	/*** Footer ***/
	footer#colophon{
		background-color: <?php echo esc_html($ts_footer_background_color); ?>;
	}
	footer#colophon{ 
		color: <?php echo esc_html($ts_footer_text_color); ?>;
	}
	
	/*** Product ***/
	.product-name,
	h3.product-name,
	.product-name h3,
	.product_list_widget .title,
	ul.product_list_widget li a, 
	.woocommerce ul.cart_list li a, 
	.woocommerce ul.product_list_widget li a{
		color: <?php echo esc_html($ts_product_name_text_color); ?>;
	}
	.product-name:hover,
	h3.product-name:hover,
	.product-name h3:hover,
	.product_list_widget .title:hover,
	ul.product_list_widget li a:hover, 
	.woocommerce ul.cart_list li a:hover, 
	.woocommerce ul.product_list_widget li a:hover{
		color: <?php echo esc_html($ts_product_name_text_hover); ?>;
	}
	.price,
	.product-price,
	.woocommerce div.product p.price,
	.woocommerce div.product span.price{
		color: <?php echo esc_html($ts_product_price_color); ?>;
	}
	.product-brands,
	.product-sku,
	.product-categories,
	ul.product_list_widget .product-categories,
	.price del,
	table.group_table del,
	.product-price del,
	body .wishlist_table.mobile table.item-details-table td del,
	.dokan-product-listing .dokan-product-listing-area del .amount,
	.entry-author .role{
		color: <?php echo esc_html($ts_product_del_price_color); ?>;
	}
	.price ins,
	table.group_table ins,
	body .wishlist_table.mobile table.item-details-table td ins,
	.dokan-product-listing .dokan-product-listing-area ins .amount,
	.product-price ins{
		color: <?php echo esc_html($ts_product_sale_price_color); ?>;
	}
	.star-rating::before,
	.woocommerce .star-rating::before,
	.woocommerce p.stars a,
	.woocommerce p.stars a:hover ~ a,
	.woocommerce p.stars.selected a.active ~ a,
	.ts-testimonial-wrapper .rating:before,
	blockquote .rating:before{
		color: <?php echo esc_html($ts_rating_color); ?>;
	}
	.star-rating span, 
	.woocommerce .star-rating span, 
	.product_list_widget .star-rating span,
	.woocommerce p.stars:hover a, 
	.woocommerce p.stars.selected a, 
	.woocommerce .star-rating span:before, 
	.ts-testimonial-wrapper .rating span:before, 
	blockquote .rating span:before{
		color: <?php echo esc_html($ts_rating_fill_color); ?>;
	}
	.counter-wrapper{
		background: <?php echo esc_html($ts_counter_background_color); ?>;
		color: <?php echo esc_html($ts_counter_text_color); ?>;
	}
	div.product.images-summary-background:before{
		background: <?php echo esc_html($ts_product_detail_images_summary_background); ?>;
	}
	.products .product-category > .product-wrapper > a,
	.woocommerce .products .product-category > .product-wrapper > a{
		background: <?php echo esc_html($ts_product_category_background); ?>;
	}
	.woocommerce div.product.color-variation-thumbnail .ts-product-attribute div.option.color a img{
		border-color: <?php echo esc_html($ts_product_button_mobile_background_color); ?>;
	}

	/*** Product Label ***/
	.woocommerce .product .product-label .onsale{
		color: <?php echo esc_html($ts_product_sale_label_text_color); ?>;
		background: <?php echo esc_html($ts_product_sale_label_background_color); ?>;
	}
	.woocommerce .product .product-label .new{
		color: <?php echo esc_html($ts_product_new_label_text_color); ?>;
		background: <?php echo esc_html($ts_product_new_label_background_color); ?>;
	}
	.woocommerce .product .product-label .featured{
		color: <?php echo esc_html($ts_product_feature_label_text_color); ?>;
		background: <?php echo esc_html($ts_product_feature_label_background_color); ?>;
	}
	.woocommerce .product .product-label .out-of-stock{
		color: <?php echo esc_html($ts_product_outstock_label_text_color); ?>;
		background: <?php echo esc_html($ts_product_outstock_label_background_color); ?>;
	}

	/*** Mobile Buttons Bottom ***/
	#ts-mobile-button-bottom{
		background: <?php echo esc_html($ts_product_group_button_fixed_background_color); ?>;
		border-color: <?php echo esc_html($ts_product_group_button_fixed_border_color); ?>;
	}
	#ts-mobile-button-bottom svg path,
	#ts-mobile-button-bottom .ts-mobile-icon-toggle svg line,
	#ts-mobile-button-bottom .shopping-cart-wrapper .cart-icon svg path,
	#ts-mobile-button-bottom .my-wishlist-wrapper svg path, 
	#ts-mobile-button-bottom .search-button svg path, 
	#ts-mobile-button-bottom .my-account-wrapper svg path{
		stroke: <?php echo esc_html($ts_product_group_button_fixed_icon_color); ?>;
	}
	#group-icon-header .ts-sidebar-content,
	#group-icon-header h6,
	.mobile-menu-wrapper ul.sub-menu,
	.mobile-menu-wrapper .mobile-menu{
		background-color: <?php echo esc_html($ts_menu_mobile_background_color); ?>;
		color: <?php echo esc_html($ts_menu_mobile_text_color); ?>;
	}
	.mobile-menu-wrapper li.active .ts-menu-drop-icon.active,
	.mobile-menu-wrapper li.current-menu-parent.active .ts-menu-drop-icon.active,
	.mobile-menu-wrapper li.current-menu-ancestor.active .ts-menu-drop-icon.active,
	.mobile-menu-wrapper li.current-product_cat-ancestor.active .ts-menu-drop-icon.active,
	.mobile-menu-wrapper li.current-menu-item.active .ts-menu-drop-icon.active,
	.mobile-menu-wrapper .sub-menu li.current-menu-parent.active .ts-menu-drop-icon.active,
	.mobile-menu-wrapper .sub-menu li.current-menu-ancestor.active .ts-menu-drop-icon.active,
	.mobile-menu-wrapper .sub-menu li.current-product_cat-ancestor.active .ts-menu-drop-icon.active,
	.mobile-menu-wrapper .sub-menu li.current-menu-item.active .ts-menu-drop-icon.active{
		background-color: <?php echo esc_html($ts_menu_mobile_background_color); ?>;
		color: <?php echo esc_html($ts_menu_mobile_text_color); ?> !important;
	}
	
	/*** Loading ***/
	<?php if( strpos($ts_button_text_color, 'rgba') !== false ): ?>
	.portfolio-inner a.like.loading:before,
	.portfolio-like .ic-like.loading:before,
	.portfolio-thumbnail > figure ~ a.like.loading:hover:before,
	.woocommerce div.product form.cart .button.loading:before,
	.wishlist_table .product-add-to-cart a.add_to_cart.loading:before,
	rs-layer .products .product div.loop-add-to-cart .button.loading:before,
	.product-hover-vertical-style-2 rs-layer .products .product div.loop-add-to-cart .button.loading:before,
	.product-hover-vertical-style-2 .products .product div.loop-add-to-cart .button.loading:before,
	.woocommerce.main-products.columns-1 .product-group-button-meta > div a.button.loading:before,
	.product-group-button > div:hover a.loading:after,
	.product-hover-vertical-style-2 .products .product .thumbnail-wrapper div.loop-add-to-cart .button.loading:before,
	.woocommerce.main-products.columns-1 .product .product-group-button-meta div.loop-add-to-cart .button.loading:before,
	body .woocommerce table.compare-list .add-to-cart td a.loading:before,
	.woocommerce .product-group-button > div .button.loading:hover:after,
	.woocommerce div.product form.cart .button.loading:before{
		border-color: <?php echo esc_html(str_replace('1)', '0.5)', esc_html($ts_button_text_color))); ?>;
	}
	<?php endif; ?>
	.portfolio-inner a.like.loading:before,
	.portfolio-like .ic-like.loading:before,
	.portfolio-thumbnail > figure ~ a.like.loading:hover:before,
	.woocommerce div.product form.cart .button.loading:before,
	.wishlist_table .product-add-to-cart a.add_to_cart.loading:before,
	rs-layer .products .product div.loop-add-to-cart .button.loading:before,
	.product-hover-vertical-style-2 rs-layer .products .product div.loop-add-to-cart .button.loading:before,
	.product-hover-vertical-style-2 .products .product div.loop-add-to-cart .button.loading:before,
	.woocommerce.main-products.columns-1 .product-group-button-meta > div a.button.loading:before,
	.product-group-button > div:hover a.loading:after,
	.product-hover-vertical-style-2 .products .product .thumbnail-wrapper div.loop-add-to-cart .button.loading:before,
	.woocommerce.main-products.columns-1 .product .product-group-button-meta div.loop-add-to-cart .button.loading:before,
	body .woocommerce table.compare-list .add-to-cart td a.loading:before,
	.woocommerce .product-group-button > div .button.loading:hover:after,
	.woocommerce div.product form.cart .button.loading:before{
		border-top-color: <?php echo esc_html($ts_button_text_color); ?>;
	}
	<?php if( strpos($ts_button_background_color, 'rgba') !== false ): ?>
	.search-table .search-button:after,
	.cross-sells .product .product-group-button-meta > div a.loading:after,
	.up-sells .product .product-group-button-meta > div a.loading:after,
	.related .product .product-group-button-meta > div a.loading:after,
	#tab-more_seller_product .product .product-group-button-meta > div a.loading:after,
	.dokan-single-store .seller-items .product .product-group-button-meta > div a.loading:after,
	.woocommerce.main-products:not(.columns-1) .product .product-group-button-meta > div a.loading:after,
	.ts-product .product-group-button-meta > div a.loading:after,
	.portfolio-inner a.like.loading:hover:before,
	.portfolio-like .ic-like.loading:hover:before,
	.portfolio-thumbnail > figure ~ a.like.loading:before,
	.woocommerce div.product form.cart .button.loading:hover:before,
	rs-layer .products .product div.loop-add-to-cart .button.loading:hover:before,
	.product-hover-vertical-style-2 rs-layer .products .product div.loop-add-to-cart .button.loading:hover:before,
	.woocommerce.main-products.columns-1 .product-group-button-meta > div a.button.loading:hover:before,
	.search-table .search-button:after,
	.product-group-button-meta > div a.loading:before,
	.woocommerce .product-group-button-meta > div a.button.loading:before,
	.woocommerce div.product form.cart .button.loading:hover:before,
	.wishlist_table .product-add-to-cart a.add_to_cart.loading:hover:before,
	.woocommerce .product-group-button > div .button.loading:after,
	body .woocommerce table.compare-list .add-to-cart td a.loading:hover:before,
	.woocommerce.main-products.columns-1 .product .product-group-button-meta div.loop-add-to-cart .button.loading:hover:before,	
	.product-group-button > div a.loading:after{
		border-color: <?php echo esc_html(str_replace('1)', '0.5)', esc_html($ts_button_background_color))); ?>;
	}
	<?php endif; ?>
	.search-table .search-button:after,
	.cross-sells .product .product-group-button-meta > div a.loading:after,
	.up-sells .product .product-group-button-meta > div a.loading:after,
	.related .product .product-group-button-meta > div a.loading:after,
	#tab-more_seller_product .product .product-group-button-meta > div a.loading:after,
	.dokan-single-store .seller-items .product .product-group-button-meta > div a.loading:after,
	.woocommerce.main-products:not(.columns-1) .product .product-group-button-meta > div a.loading:after,
	.ts-product .product-group-button-meta > div a.loading:after,
	.portfolio-inner a.like.loading:hover:before,
	.portfolio-like .ic-like.loading:hover:before,
	.portfolio-thumbnail > figure ~ a.like.loading:before,
	.woocommerce div.product form.cart .button.loading:hover:before,
	rs-layer .products .product div.loop-add-to-cart .button.loading:hover:before,
	.product-hover-vertical-style-2 rs-layer .products .product div.loop-add-to-cart .button.loading:hover:before,
	.woocommerce.main-products.columns-1 .product-group-button-meta > div a.button.loading:hover:before,
	.search-table .search-button:after,
	.product-group-button-meta > div a.loading:before,
	.woocommerce .product-group-button-meta > div a.button.loading:before,
	.woocommerce div.product form.cart .button.loading:hover:before,
	.wishlist_table .product-add-to-cart a.add_to_cart.loading:hover:before,
	.woocommerce .product-group-button > div .button.loading:after,
	body .woocommerce table.compare-list .add-to-cart td a.loading:hover:before,
	.woocommerce.main-products.columns-1 .product .product-group-button-meta div.loop-add-to-cart .button.loading:hover:before,
	.product-group-button > div a.loading:after{
		border-top-color: <?php echo esc_html($ts_button_background_color); ?>;
	}
	.load-more-wrapper .button.loading,
	.ts-shop-load-more .button.loading,
	.woocommerce .ts-shop-load-more .button.loading{
		border-color: <?php echo esc_html($ts_input_border_color); ?>;
		border-top-color: <?php echo esc_html($ts_primary_color); ?>;
	}
	.images.loading:after,
	.ts-product .content-wrapper.loading:after,
	.ts-logo-slider-wrapper.loading .content-wrapper:after,
	.related-posts.loading .content-wrapper:after,
	.search-table .search-button:after,
	.woocommerce .product figure.loading:after,
	.ts-products-widget-wrapper.loading:after,
	.ts-blogs-widget-wrapper.loading:after,
	.ts-recent-comments-widget-wrapper.loading:after,
	.blogs article a.gallery.loading:after,
	.ts-blogs-wrapper.loading .content-wrapper:after,
	.ts-testimonial-wrapper .items.loading:after,
	.ts-twitter-slider .items.loading:after,
	article .thumbnail.loading:after,
	.ts-portfolio-wrapper.loading:after,
	.thumbnails.loading:after,
	.ts-product-category-wrapper .content-wrapper.loading:after,
	.thumbnails-container.loading:after,
	.column-products.loading:after,
	.ts-team-members .loading:after,
	.ts-products-widget-wrapper.loading:after,
	.ts-blogs-widget-wrapper.loading:after,
	.ts-recent-comments-widget-wrapper.loading:after,
	.ts-tiny-cart-wrapper li div.blockUI.blockOverlay:after,
	.widget_shopping_cart li div.blockUI.blockOverlay:after,
	.elementor-widget-wp-widget-woocommerce_widget_cart div.blockUI.blockOverlay:after,
	.dropdown-container ul.cart_list li.loading:after,
	.woocommerce a.button.loading:after,
	.woocommerce button.button.loading:after,
	.woocommerce input.button.loading:after,
	.woocommerce div.product .single-product-buttons-sharing .single-product-buttons a.loading:after,
	.archive.ajax-pagination .woocommerce > .products:before,
	div.blockUI.blockOverlay:after,
	.woocommerce div.blockUI.blockOverlay:after,
	div.wpcf7 .ajax-loader:after{
		border-color: <?php echo esc_html($ts_input_border_color); ?>;
	}
	.images.loading:after,
	.search-table .search-button:after,
	.ts-product .content-wrapper.loading:after,
	.ts-logo-slider-wrapper.loading .content-wrapper:after,
	.related-posts.loading .content-wrapper:after,
	.woocommerce .product figure.loading:after,
	.ts-products-widget-wrapper.loading:after,
	.ts-blogs-widget-wrapper.loading:after,
	.ts-recent-comments-widget-wrapper.loading:after,
	.blogs article a.gallery.loading:after,
	.ts-blogs-wrapper.loading .content-wrapper:after,
	.ts-testimonial-wrapper .items.loading:after,
	.ts-twitter-slider .items.loading:after,
	article .thumbnail.loading:after,
	.ts-portfolio-wrapper.loading:after,
	.thumbnails.loading:after,
	.ts-product-category-wrapper .content-wrapper.loading:after,
	.thumbnails-container.loading:after,
	.column-products.loading:after,
	.ts-team-members .loading:after,
	.ts-products-widget-wrapper.loading:after,
	.ts-blogs-widget-wrapper.loading:after,
	.ts-recent-comments-widget-wrapper.loading:after,
	.ts-tiny-cart-wrapper li div.blockUI.blockOverlay:after,
	.widget_shopping_cart li div.blockUI.blockOverlay:after,
	.elementor-widget-wp-widget-woocommerce_widget_cart div.blockUI.blockOverlay:after,
	.dropdown-container ul.cart_list li.loading:after,
	.woocommerce a.button.loading:after,
	.woocommerce button.button.loading:after,
	.woocommerce input.button.loading:after,
	.woocommerce div.product .single-product-buttons-sharing .single-product-buttons a.loading:after,
	.archive.ajax-pagination .woocommerce > .products:before,
	div.blockUI.blockOverlay:after,
	.woocommerce div.blockUI.blockOverlay:after,
	div.wpcf7 .ajax-loader:after{
		border-top-color: <?php echo esc_html($ts_button_background_color); ?>;
	}
	@media only screen and (max-width: 1279px){
		<?php if( strpos($ts_button_text_color, 'rgba') !== false ): ?>
		.product-group-button-meta > div a.loading:before,
		.product-group-button-meta > div .button.loading:before,
		.product-group-button-meta > div a.loading:hover:before,
		.product-group-button-meta > div .button.loading:hover:before,
		.woocommerce.main-products.columns-1 .product .product-group-button-meta div.loop-add-to-cart .button.loading:hover:before{
			border-color: <?php echo esc_html(str_replace('1)', '0.5)', esc_html($ts_button_background_color))); ?> !important;
		}
		<?php endif; ?>
		.product-group-button-meta > div a.loading:before,
		.product-group-button-meta > div .button.loading:before,
		.product-group-button-meta > div a.loading:hover:before,
		.product-group-button-meta > div .button.loading:hover:before,
		.woocommerce.main-products.columns-1 .product .product-group-button-meta div.loop-add-to-cart .button.loading:hover:before{
			border-top-color: <?php echo esc_html($ts_button_background_color); ?> !important;
		}
		.cross-sells .product .product-group-button-meta,
		.up-sells .product .product-group-button-meta,
		.related .product .product-group-button-meta,
		#tab-more_seller_product .product .product-group-button-meta,
		.dokan-single-store .seller-items .product .product-group-button-meta,
		.ts-product .product .product-group-button-meta,
		.woocommerce.main-products:not(.columns-1) .product .product-group-button-meta{
			background: <?php echo esc_html($ts_product_button_mobile_background_color); ?>;
		}
		.product-group-button > div a:after, .product-group-button-meta > div.button-in a:before,
		.cross-sells .product .product-group-button-meta > div.loop-add-to-cart > a.button:before,
		.up-sells .product .product-group-button-meta > div.loop-add-to-cart > a.button:before,
		.related .product .product-group-button-meta > div.loop-add-to-cart > a.button:before,
		#tab-more_seller_product .product .product-group-button-meta > div.loop-add-to-cart > a.button:before,
		.dokan-single-store .seller-items .product .product-group-button-meta > div.loop-add-to-cart > a.button:before,
		.woocommerce.main-products:not(.columns-1) .product .product-group-button-meta > div.loop-add-to-cart > a.button:before,
		.ts-product .product-group-button-meta > div.loop-add-to-cart > a.button:before{
			color: <?php echo esc_html($ts_product_button_mobile_text_color); ?>;
		}
		<?php if( strpos($ts_button_text_color, 'rgba') !== false ): ?>
		.woocommerce.main-products.columns-1 .product .product-group-button-meta div.loop-add-to-cart .button.loading:before{
			border-color: <?php echo esc_html(str_replace('1)', '0.5)', esc_html($ts_button_text_color))); ?> !important;
		}
		<?php endif; ?>
		.woocommerce.main-products.columns-1 .product .product-group-button-meta div.loop-add-to-cart .button.loading:before{
			border-top-color: <?php echo esc_html($ts_button_text_color); ?> !important;
		}
		<?php if( strpos($ts_button_background_color, 'rgba') !== false ): ?>
		.woocommerce.main-products.columns-1 .product .product-group-button-meta div.loop-add-to-cart .button:hover.loading:before{
			border-color: <?php echo esc_html(str_replace('1)', '0.5)', esc_html($ts_button_background_color))); ?> !important;
		}
		<?php endif; ?>
		.woocommerce.main-products.columns-1 .product .product-group-button-meta div.loop-add-to-cart .button:hover.loading:before{
			border-top-color: <?php echo esc_html($ts_button_background_color); ?> !important;
		}
	}
	
<?php update_option('ts_load_dynamic_style', 1); // uncomment after finished this file ?>	