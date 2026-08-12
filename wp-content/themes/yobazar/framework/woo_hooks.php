<?php
/*************************************************
* WooCommerce Custom Hook                        *
**************************************************/

/*** Shop - Category ***/

/* Remove hook */
function yobazar_woocommerce_remove_shop_loop_default_hooks(){
	remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
	remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0);
	remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);

	remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );
	remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);

	remove_action('woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10);

	remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10);
	remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5);

	remove_action('woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10);
	remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);
	remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5);

	remove_action('woocommerce_before_subcategory', 'woocommerce_template_loop_category_link_open', 10);
	remove_action('woocommerce_after_subcategory', 'woocommerce_template_loop_category_link_close', 10);
}
yobazar_woocommerce_remove_shop_loop_default_hooks();

add_action('load-post.php', 'yobazar_woocommerce_remove_shop_loop_default_hooks', 20); /* Fix: Elementor editor - WooCommerce 8.4.0 */
/* Add new hook */

add_action('woocommerce_before_shop_loop_item_title', 'yobazar_template_loop_product_thumbnail', 10);
add_action('woocommerce_after_shop_loop_item_title', 'yobazar_template_loop_product_label', 1);

add_action('woocommerce_after_shop_loop_item', 'yobazar_template_loop_brands', 5);
add_action('woocommerce_after_shop_loop_item', 'yobazar_template_loop_product_title', 30);
add_action('woocommerce_after_shop_loop_item', 'yobazar_template_loop_product_sku', 10);
add_action('woocommerce_after_shop_loop_item', 'yobazar_template_loop_categories', 20);
add_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_rating', 50);
add_action('woocommerce_after_shop_loop_item', 'yobazar_template_loop_short_description', 60);
add_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_price', 40);
add_action('woocommerce_after_shop_loop_item_2', 'yobazar_template_loop_add_to_cart', 40);

add_action('woocommerce_before_shop_loop', 'yobazar_add_filter_button', 15);
add_action('woocommerce_before_shop_loop', 'yobazar_product_columns_selector', 20);
add_action('woocommerce_before_shop_loop', 'yobazar_product_on_sale_form', 50);
add_action('woocommerce_before_shop_loop', 'yobazar_product_per_page_form', 60);

add_action('woocommerce_after_main_content', 'yobazar_shop_bottom_content', 10);

add_filter('loop_shop_per_page', 'yobazar_change_products_per_page_shop' ); 

add_filter('loop_shop_post_in', 'yobazar_show_only_products_on_sales');

add_action('woocommerce_after_shop_loop', 'yobazar_shop_load_more_html', 20);

add_filter('woocommerce_catalog_orderby', 'yobazar_woocommerce_catalog_orderby');

add_filter('woocommerce_get_stock_html', 'yobazar_empty_woocommerce_stock_html', 10, 2);

add_filter('woocommerce_before_output_product_categories', 'yobazar_before_output_product_categories');
add_filter('woocommerce_after_output_product_categories', 'yobazar_after_output_product_categories');

add_filter('woocommerce_pagination_args', 'yobazar_woocommerce_pagination_args');
function yobazar_woocommerce_pagination_args( $args ){
	$args['prev_text'] = esc_html__('Prev', 'yobazar');
	$args['next_text'] = esc_html__('Next', 'yobazar');
	return $args;
}

add_action('init', 'yobazar_check_product_lazy_load');
function yobazar_check_product_lazy_load(){
	if( wp_doing_ajax() || ( isset($_GET['action']) && $_GET['action'] == 'elementor' ) ){
		yobazar_change_theme_options('ts_prod_lazy_load', 0);
	}
}

function yobazar_template_loop_product_label(){
	global $product;
	$theme_options = yobazar_get_theme_options();
	?>
	<div class="product-label">
	<?php 
	if( $product->is_in_stock() ){
		/* New label */
		if( $theme_options['ts_product_show_new_label'] ){
			$now = current_time( 'timestamp', true );
			$post_date = get_post_time('U', true);
			$num_day = (int)( ( $now - $post_date ) / ( 3600*24 ) );
			$num_day_setting = absint( $theme_options['ts_product_show_new_label_time'] );
			if( $num_day <= $num_day_setting ){
				echo '<span class="new"><span>'.esc_html($theme_options['ts_product_new_label_text']).'</span></span>';
			}
		}
		
		/* Sale label */
		if( $product->is_on_sale() ){
			if( $theme_options['ts_show_sale_label_as'] != 'text' ){
				if( $product->get_type() == 'variable' ){
					$regular_price = $product->get_variation_regular_price('max');
					$sale_price = $product->get_variation_sale_price('min');
				}
				else{
					$regular_price = $product->get_regular_price();
					$sale_price = $product->get_price();
				}
				if( $regular_price ){
					if( $theme_options['ts_show_sale_label_as'] == 'number' ){
						$_off_price = round($regular_price - $sale_price, wc_get_price_decimals());
						$price_display = '-' . sprintf(get_woocommerce_price_format(), get_woocommerce_currency_symbol(), $_off_price);
						echo '<span class="onsale amount" data-original="'.$price_display.'"><span>'.$price_display.'</span></span>';
					}
					if( $theme_options['ts_show_sale_label_as'] == 'percent' ){
						echo '<span class="onsale percent"><span>-'.yobazar_calc_discount_percent($regular_price, $sale_price).'%</span></span>';
					}
				}
			}
			else{
				echo '<span class="onsale"><span>'.esc_html($theme_options['ts_product_sale_label_text']).'</span></span>';
			}
		}
		
		/* Hot label */
		if( $product->is_featured() ){
			echo '<span class="featured"><span>'.esc_html($theme_options['ts_product_feature_label_text']).'</span></span>';
		}
	}
	else{ /* Out of stock */
		echo '<span class="out-of-stock"><span>'.esc_html($theme_options['ts_product_out_of_stock_label_text']).'</span></span>';
	}
	?>
	</div>
	<?php
}

function yobazar_template_loop_product_thumbnail(){
	global $product;
	$lazy_load = yobazar_get_theme_options('ts_prod_lazy_load');
	$placeholder_img_src = yobazar_get_theme_options('ts_prod_placeholder_img')['url'];
	
	$prod_galleries = $product->get_gallery_image_ids();
	
	$image_size = apply_filters('yobazar_loop_product_thumbnail', 'woocommerce_thumbnail');
	
	$dimensions = wc_get_image_size( $image_size );
	
	$has_back_image = yobazar_get_theme_options('ts_effect_product');
	
	if( !is_array($prod_galleries) || ( is_array($prod_galleries) && count($prod_galleries) == 0 ) ){
		$has_back_image = false;
	}
	 
	if( wp_is_mobile() ){
		$has_back_image = false;
	}
	
	echo '<figure class="' . ($has_back_image?'has-back-image':'no-back-image') . '">';
		if( !$lazy_load ){
			echo woocommerce_get_product_thumbnail( $image_size );
			
			if( $has_back_image ){
				echo wp_get_attachment_image( $prod_galleries[0], $image_size, 0, array('class' => 'product-image-back') );
			}
		}
		else{
			$front_img_src = '';
			$alt = '';
			if( has_post_thumbnail( $product->get_id() ) ){
				$post_thumbnail_id = get_post_thumbnail_id($product->get_id());
				$image_obj = wp_get_attachment_image_src($post_thumbnail_id, $image_size, 0);
				if( isset($image_obj[0]) ){
					$front_img_src = $image_obj[0];
				}
				$alt = trim(strip_tags( get_post_meta($post_thumbnail_id, '_wp_attachment_image_alt', true) ));
			}
			else{
				$front_img_src = wc_placeholder_img_src();
			}
			
			echo '<img src="'.esc_url($placeholder_img_src).'" data-src="'.esc_url($front_img_src).'" class="attachment-shop_catalog wp-post-image ts-lazy-load" alt="'.esc_attr($alt).'" width="'.$dimensions['width'].'" height="'.$dimensions['height'].'" />';
		
			if( $has_back_image ){
				$back_img_src = '';
				$alt = '';
				$image_obj = wp_get_attachment_image_src($prod_galleries[0], $image_size, 0);
				if( isset($image_obj[0]) ){
					$back_img_src = $image_obj[0];
					$alt = trim(strip_tags( get_post_meta($prod_galleries[0], '_wp_attachment_image_alt', true) ));
				}
				else{
					$back_img_src = wc_placeholder_img_src();
				}
				
				echo '<img src="'.esc_url($placeholder_img_src).'" data-src="'.esc_url($back_img_src).'" class="product-image-back ts-lazy-load" alt="'.esc_attr($alt).'" width="'.$dimensions['width'].'" height="'.$dimensions['height'].'" />';
			}
		}
	echo '</figure>';
}

function yobazar_template_loop_product_variable_color(){
	global $product;
	if( $product->get_type() == 'variable' ){
		$attribute_color = wc_attribute_taxonomy_name( 'color' ); // pa_color
		$attribute_color_name = wc_variation_attribute_name( $attribute_color ); // attribute_pa_color
		
		$color_terms = wc_get_product_terms( $product->get_id(), $attribute_color, array( 'fields' => 'all' ) );
		if( empty($color_terms) || is_wp_error($color_terms) ){
			return;
		}
		$color_term_ids = wp_list_pluck( $color_terms, 'term_id' );
		$color_term_slugs = wp_list_pluck( $color_terms, 'slug' );
		
		$color_html = array();
		$price_html = array();
		
		$added_colors = array();
		$count = 0;
		$number = apply_filters('yobazar_loop_product_variable_color_number', 3);
		
		$children = $product->get_children();
		if( is_array($children) && count($children) > 0 ){
			foreach( $children as $children_id ){
				$variation_attributes = wc_get_product_variation_attributes( $children_id );
				foreach( $variation_attributes as $attribute_name => $attribute_value ){
					if( $attribute_name == $attribute_color_name ){
						if( in_array($attribute_value, $added_colors) ){
							break;
						}
						
						$term_id = 0;
						$found_slug = array_search($attribute_value, $color_term_slugs);
						if( $found_slug !== false ){
							$term_id = $color_term_ids[ $found_slug ];
						}
						
						if( $term_id !== false && absint( $term_id ) > 0 ){
							$thumbnail_id = get_post_meta( $children_id, '_thumbnail_id', true );
							if( $thumbnail_id ){
								$image_src = wp_get_attachment_image_src($thumbnail_id, 'woocommerce_thumbnail');
								if( $image_src ){
									$thumbnail = $image_src[0];
								}
								else{
									$thumbnail = wc_placeholder_img_src();
								}
							}
							else{
								$thumbnail = wc_placeholder_img_src();
							}
							
							$color_datas = get_term_meta( $term_id, 'ts_product_color_config', true );
							if( $color_datas ){
								$color_datas = unserialize( $color_datas );	
							}else{
								$color_datas = array('ts_color_color' => '#ffffff', 'ts_color_image' => 0);
							}
							$color_datas['ts_color_image'] = absint($color_datas['ts_color_image']);
							if( $color_datas['ts_color_image'] ){
								$color_html[] = '<div class="color-image" data-thumb="'.$thumbnail.'" data-term_id="'.$term_id.'"><span>'.wp_get_attachment_image( $color_datas['ts_color_image'], 'ts_prod_color_thumb', true, array('alt' => $attribute_value) ).'</span></div>';
							}
							else{
								$color_html[] = '<div class="color" data-thumb="'.$thumbnail.'" data-term_id="'.$term_id.'"><span style="background-color: '.$color_datas['ts_color_color'].'"></span></div>';
							}
							$variation = wc_get_product( $children_id );
							$price_html[] = '<span data-term_id="'.$term_id.'">' . $variation->get_price_html() . '</span>';
							$count++;
						}
						
						$added_colors[] = $attribute_value;
						break;
					}
				}
				
				if( $count == $number ){
					break;
				}
			}
		}
		
		if( $color_html ){
			echo '<div class="color-swatch">'. implode('', $color_html) . '</div>';
			echo '<span class="variable-prices hidden">' . implode('', $price_html) . '</span>';
		}
	}
}

function yobazar_template_loop_product_title(){
	global $product;
	echo '<h3 class="heading-title product-name">';
	echo '<a href="' . esc_url($product->get_permalink()) . '">' . esc_html($product->get_title()) . '</a>';
	echo '</h3>';
}

function yobazar_template_loop_add_to_cart(){
	if( yobazar_get_theme_options('ts_enable_catalog_mode') ){
		return;
	}
	
	echo '<div class="loop-add-to-cart">';
	woocommerce_template_loop_add_to_cart();
	echo '</div>';
}

function yobazar_template_loop_product_sku(){
	global $product;
	echo '<div class="product-sku">' . esc_html($product->get_sku()) . '</div>';
}

function yobazar_template_loop_short_description(){
	global $product;
	if( !$product->get_short_description() ){
		return;
	}
	
	$allowed_html = array(
		'ul' => array(
			'class' => array()
		)
		,'ol' => array(
			'class' => array()
		)
		,'li'=> array(
			'class' => array()
		)
	);
	
	$limit_words = (int) yobazar_get_theme_options('ts_prod_cat_desc_words');
	?>
		<div class="short-description">
			<?php yobazar_the_excerpt_max_words($limit_words, '', $allowed_html, '', true); ?>
		</div>
	<?php
	
}

function yobazar_template_loop_brands(){
	global $product;
	if( taxonomy_exists('ts_product_brand') ){
		echo get_the_term_list($product->get_id(), 'ts_product_brand', '<div class="product-brands">', ', ', '</div>');
	}
}

function yobazar_template_loop_categories(){
	global $product;
	$categories_label = esc_html__('Categories: ', 'yobazar');
	echo wc_get_product_category_list($product->get_id(), ', ', '<div class="product-categories"><span>'.$categories_label.'</span>', '</div>');
}

function yobazar_change_products_per_page_shop(){
    if( is_tax( get_object_taxonomies( 'product' ) ) || is_post_type_archive('product') ){
		if( isset($_GET['per_page']) && absint($_GET['per_page']) > 0 ){
			return absint($_GET['per_page']);
		}
		$per_page = absint( yobazar_get_theme_options('ts_prod_cat_per_page') );
        if( $per_page ){
            return $per_page;
        }
    }
}

function yobazar_product_per_page_form(){
	if( !yobazar_get_theme_options('ts_prod_cat_per_page_dropdown') ){
		return;
	}
	if( function_exists('woocommerce_products_will_display') && !woocommerce_products_will_display() ){
		return;
	}
	
	$per_page = absint( yobazar_get_theme_options('ts_prod_cat_per_page') );
	if( !$per_page ){
		return;
	}
	
	$options = array();
	for( $i = 1; $i <= 4; $i++ ){
		$options[] = $per_page * $i;
	}
	$selected = isset($_GET['per_page'])?absint($_GET['per_page']):$per_page;
	
	$action = '';
	$cat 	= get_queried_object();
	if( isset( $cat->term_id ) && isset( $cat->taxonomy ) ){
		$action = get_term_link( $cat->term_id, $cat->taxonomy );
	}
	else{
		$action = wc_get_page_permalink('shop');
	}
?>
	<form method="get" action="<?php echo esc_url($action) ?>" class="product-per-page-form">
		<span><?php esc_html_e('Show', 'yobazar'); ?></span>
		<select name="per_page" class="perpage">
			<?php foreach( $options as $option ): ?>
			<option value="<?php echo esc_attr($option) ?>" <?php selected($selected, $option) ?>><?php echo esc_html($option) ?></option>
			<?php endforeach; ?>
		</select>
		<ul class="perpage">
			<li>
				<span class="perpage-current">
					<span><?php esc_html_e('Show', 'yobazar'); ?></span>
					<strong><?php echo esc_html($selected) ?></strong>
				</span>
				<ul class="dropdown">
					<?php foreach( $options as $option ): ?>
					<li>
						<a href="#" data-perpage="<?php echo esc_attr($option) ?>" class="<?php echo esc_attr($option == $selected?'current':''); ?>">
							<span><?php esc_html_e('Show', 'yobazar'); ?></span>
							<strong><?php echo esc_html($option) ?></strong>
						</a>
					</li>
					<?php endforeach; ?>
				</ul>
			</li>
		</ul>
		<?php wc_query_string_form_fields( null, array( 'per_page', 'submit', 'paged', 'product-page' ) ); ?>
	</form>
<?php
}

function yobazar_product_columns_selector(){
	if( !yobazar_get_theme_options('ts_prod_cat_columns_selector') ){
		return;
	}
	if( function_exists('woocommerce_products_will_display') && !woocommerce_products_will_display() ){
		return;
	}
	
	$default_column = (int) yobazar_get_theme_options('ts_prod_cat_columns');
	
	$columns = array(1, 2, 3, 4);
	?>
	<div class="ts-product-columns-selector">
		<?php foreach( $columns as $column ){ ?>
		<span class="column-<?php echo esc_attr($column); ?> <?php echo esc_attr($default_column == $column?'selected':''); ?>" data-col="<?php echo esc_attr($column); ?>"></span>
		<?php } ?>
	</div>
	<?php
}

function yobazar_show_only_products_on_sales( $array ){
	if( is_tax( get_object_taxonomies( 'product' ) ) || is_post_type_archive('product') ){
		if( isset($_GET['onsale']) && 'yes' == $_GET['onsale'] ){
			return array_merge($array, wc_get_product_ids_on_sale());
		}
	}
	return $array;
}

function yobazar_product_on_sale_form(){
	if( !yobazar_get_theme_options('ts_prod_cat_onsale_checkbox') ){
		return;
	}
	if( function_exists('woocommerce_products_will_display') && !woocommerce_products_will_display() ){
		return;
	}
	
	$checked = isset($_GET['onsale']) && 'yes' == $_GET['onsale'] ? true : false;
	
	$action = '';
	$cat 	= get_queried_object();
	if( isset( $cat->term_id ) && isset( $cat->taxonomy ) ){
		$action = get_term_link( $cat->term_id, $cat->taxonomy );
	}
	else{
		$action = wc_get_page_permalink('shop');
	}
	?>
	<form method="get" action="<?php echo esc_url($action); ?>" class="product-on-sale-form <?php echo esc_attr( $checked?'checked':'' ); ?>">
		<label>
			<input type="checkbox" name="onsale" value="yes" <?php echo esc_attr( $checked?'checked':'' ); ?> />
			<?php esc_html_e('Show only products on sale', 'yobazar'); ?>
		</label>
		<?php wc_query_string_form_fields( null, array( 'onsale', 'submit', 'paged', 'product-page' ) ); ?>
	</form>
	<?php
}

function yobazar_woocommerce_catalog_orderby( $orderby ){
	if( isset($orderby['menu_order']) ){
		$orderby['menu_order'] = __('Default', 'yobazar');
	}
	if( isset($orderby['popularity']) ){
		$orderby['popularity'] = __('Popularity', 'yobazar');
	}
	if( isset($orderby['rating']) ){
		$orderby['rating'] = __('Average rating', 'yobazar');
	}
	if( isset($orderby['date']) ){
		$orderby['date'] = __('Latest', 'yobazar');
	}
	if( isset($orderby['price']) ){
		$orderby['price'] = __('Price: low to high', 'yobazar');
	}
	if( isset($orderby['price-desc']) ){
		$orderby['price-desc'] = __('Price: high to low', 'yobazar');
	}
	return $orderby;
}

function yobazar_is_active_filter_area(){
	return is_active_sidebar('filter-widget-area') && yobazar_get_theme_options('ts_filter_widget_area') && woocommerce_products_will_display();
}

function yobazar_show_filter_area_by_default(){
	return !wp_is_mobile() && yobazar_get_theme_options('ts_show_filter_widget_area_by_default');
}

function yobazar_add_filter_button(){
	if( yobazar_is_active_filter_area() ){
		$show_by_default = yobazar_show_filter_area_by_default();
	?>
		<div class="filter-widget-area-button">
			<a href="#" class="<?php echo esc_attr( $show_by_default?'active':'' ); ?>"><?php esc_html_e('Filter', 'yobazar') ?></a>
		</div>
		
		<div id="ts-filter-widget-area" class="ts-floating-sidebar <?php echo esc_attr( $show_by_default?'active':'' ); ?>">
			<div class="overlay"></div>
			<div class="ts-sidebar-content">
				<span class="close"></span>
				<aside class="filter-widget-area">
					<?php dynamic_sidebar( 'filter-widget-area' ); ?>
				</aside>
			</div>
		</div>
		<?php
	}
}

function yobazar_shop_load_more_html(){
	if( wc_get_loop_prop( 'total_pages' ) == 1 || !woocommerce_products_will_display() ){
		return;
	}
	$loading_type = yobazar_get_theme_options('ts_prod_cat_loading_type');
	if( in_array($loading_type, array('infinity-scroll', 'load-more-button')) ){
		$total = wc_get_loop_prop( 'total' );
		$per_page = wc_get_loop_prop( 'per_page' );
		$current = wc_get_loop_prop( 'current_page' );
		$showing = min($current * $per_page, $total);
	?>
	<div class="ts-shop-result-count">
		<?php 
		if( $showing < $total ){
			printf( esc_html__('You\'re viewed %s of %s products', 'yobazar'), $showing, $total );
		}
		else{
			printf( esc_html__('You\'re viewed all %s products', 'yobazar'), $total );
		}
		?>
	</div>
	<div class="ts-shop-load-more">
		<a class="load-more button"><?php esc_html_e('Load more', 'yobazar'); ?></a>
	</div>
	<?php
	}
}

function yobazar_shop_bottom_content(){
	$bottom_content = yobazar_get_theme_options('ts_prod_cat_bottom_content');
	if( $bottom_content && ( is_tax( get_object_taxonomies( 'product' ) ) || is_post_type_archive('product') ) ){
		echo '<div class="shop-bottom-content">';
		echo do_shortcode( wp_kses_post( $bottom_content ) ); /* Allowed html as post content */
		echo '</div>';
	}
}

function yobazar_empty_woocommerce_stock_html( $html, $product ){
	if( $product->get_type() == 'simple' ){
		return '';
	}
	return $html;
}

function yobazar_before_output_product_categories(){
	return '<div class="list-categories">';
}

function yobazar_after_output_product_categories(){
	return '</div>';
}
/*** End Shop - Category ***/



/*** Single Product ***/

/* Remove hook */
remove_action('woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_title', 5);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50);

/* Add hook */
add_action('woocommerce_before_single_product_summary', 'yobazar_before_single_product_summary_images', 1);
add_action('woocommerce_after_single_product_summary', 'yobazar_after_single_product_summary_images', 0);

add_action('woocommerce_product_thumbnails', 'yobazar_template_loop_product_label', 99);
add_action('woocommerce_product_thumbnails', 'yobazar_template_single_product_video_360_buttons', 99);

add_action('woocommerce_single_product_summary', 'yobazar_template_single_navigation', 1);
add_action('woocommerce_single_product_summary', 'yobazar_template_loop_brands', 1);
add_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10);
add_action('woocommerce_single_product_summary', 'yobazar_template_single_meta', 15);
add_action('woocommerce_single_product_summary', 'yobazar_template_single_countdown', 16);
add_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 20);
add_action('woocommerce_single_product_summary', 'yobazar_template_single_variation_price', 21);
add_action('woocommerce_single_product_summary', 'yobazar_single_product_availability_bar', 25);
add_action('woocommerce_single_product_summary', 'yobazar_single_product_sold_24h', 26);
add_action('woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 29);
add_action('woocommerce_single_product_summary', 'yobazar_single_product_buy_now_button', 31);
add_action('woocommerce_single_product_summary', 'yobazar_single_product_buttons_sharing_start', 31);
add_action('woocommerce_single_product_summary', 'yobazar_ask_about_product_button', 40);
add_action('woocommerce_single_product_summary', 'yobazar_single_product_buttons_end', 41);
add_action('woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 70);
add_action('woocommerce_single_product_summary', 'yobazar_single_product_buttons_sharing_end', 71);

add_action('woocommerce_after_single_product_summary', 'yobazar_product_reviews_tab_content', 11);
add_action('woocommerce_after_single_product_summary', 'yobazar_product_ads_banner', 12);

add_action('woocommerce_after_single_product_summary', 'yobazar_new_arrival_products', 30);

if( function_exists('ts_template_social_sharing') ){
	add_action('woocommerce_share', 'ts_template_social_sharing', 10);
}

add_filter('woocommerce_grouped_product_columns', 'yobazar_woocommerce_grouped_product_columns');

add_filter('woocommerce_product_description_heading', '__return_empty_string');
add_filter('woocommerce_product_additional_information_heading', '__return_empty_string');

add_filter('woocommerce_output_related_products_args', 'yobazar_output_related_products_args_filter');

add_filter('woocommerce_single_product_image_gallery_classes', 'yobazar_add_classes_to_single_product_thumbnail');
add_filter('woocommerce_gallery_thumbnail_size', 'yobazar_product_gallery_thumbnail_size');

add_filter('woocommerce_dropdown_variation_attribute_options_args', 'yobazar_variation_attribute_options_args');
add_filter('woocommerce_dropdown_variation_attribute_options_html', 'yobazar_variation_attribute_options_html', 10, 2);

add_filter('woocommerce_add_to_cart_redirect', 'yobazar_product_buy_now_redirect');

if( !is_admin() ){ /* Fix for WooCommerce Tab Manager plugin */
	add_filter( 'woocommerce_product_tabs', 'yobazar_product_remove_tabs', 999 );
	add_filter( 'woocommerce_product_tabs', 'yobazar_add_product_custom_tab', 90 );
}

function yobazar_calc_discount_percent($regular_price, $sale_price){
	return ( 1 - round($sale_price / $regular_price, 2) ) * 100;
}

add_action('wp_ajax_yobazar_load_product_video', 'yobazar_load_product_video_callback' );
add_action('wp_ajax_nopriv_yobazar_load_product_video', 'yobazar_load_product_video_callback' );
/*** End Product ***/

function yobazar_before_single_product_summary_images(){
	echo '<div class="product-images-summary">';
}

function yobazar_after_single_product_summary_images(){
	echo '</div>';
}

function yobazar_template_single_product_video_360_buttons(){
	if( !is_singular('product') ){
		return;
	}
	
	global $product;
	$video_url = get_post_meta($product->get_id(), 'ts_prod_video_url', true);
	if( $video_url ){
		echo '<a class="ts-product-video-button" href="#" data-product_id="'.$product->get_id().'">'.esc_html__('Video', 'yobazar').'</a>';
		add_action('wp_footer', 'yobazar_add_product_video_popup_modal', 999);
	}
	
	$gallery_360 = get_post_meta($product->get_id(), 'ts_prod_360_gallery', true);
	if( $gallery_360 ){
		$galleries = array_map('trim', explode(',', $gallery_360));
		$image_array = array();
		foreach($galleries as $gallery ){
			$image_src = wp_get_attachment_image_url($gallery, 'woocommerce_single');
			if( $image_src ){
				$image_array[] = "'" . $image_src . "'";
			}
		}
		wp_enqueue_script('threesixty');
		wp_add_inline_script('threesixty', 'var _ts_product_360_image_array = ['.implode(',', $image_array).'];');
		
		echo '<a class="ts-product-360-button" href="#">'.esc_html__('360', 'yobazar').'</a>';
		add_action('wp_footer', 'yobazar_add_product_360_popup_modal', 999);
	}
}

function yobazar_add_product_video_popup_modal(){
	?>
	<div id="ts-product-video-modal" class="ts-popup-modal">
		<div class="overlay"></div>
		<div class="product-video-container popup-container">
			<span class="close"><?php esc_html_e('Close ', 'yobazar'); ?></span>
			<div class="product-video-content"></div>
		</div>
	</div>
	<?php
}

function yobazar_add_product_360_popup_modal(){
	?>
	<div id="ts-product-360-modal" class="ts-popup-modal">
		<div class="overlay"></div>
		<span class="close"><?php esc_html_e('Close ', 'yobazar'); ?></span>
		<div class="product-360-container popup-container">
			<div class="product-360-content"><?php yobazar_load_product_360(); ?></div>
		</div>
	</div>
	<?php
}

function yobazar_add_product_size_chart_popup_modal(){
	?>
	<div id="ts-product-size-chart-modal" class="ts-popup-modal">
		<div class="overlay"></div>
		<div class="product-size-chart-container popup-container">
			<span class="close"><?php esc_html_e('Close ', 'yobazar'); ?></span>
			<div class="product-size-chart-content">
				<?php yobazar_product_size_chart_content(); ?>
			</div>
		</div>
	</div>
	<?php
}

function yobazar_add_classes_to_single_product_thumbnail( $classes ){
	global $product;
	$video_url = get_post_meta($product->get_id(), 'ts_prod_video_url', true);
	if( $video_url ){
		$classes[] = 'has-video';
	}
	$gallery_360 = get_post_meta($product->get_id(), 'ts_prod_360_gallery', true);
	if( $gallery_360 ){
		$classes[] = 'has-360-gallery';
	}
	
	return $classes;
}

function yobazar_product_gallery_thumbnail_size(){
	return 'woocommerce_thumbnail';
}

/* Single Product Video - Register ajax */
function yobazar_load_product_video_callback(){
	if( empty($_POST['product_id']) ){
		die( esc_html__('Invalid Product', 'yobazar') );
	}
	
	$prod_id = absint($_POST['product_id']);

	if( $prod_id <= 0 ){
		die( esc_html__('Invalid Product', 'yobazar') );
	}
	
	$video_url = get_post_meta($prod_id, 'ts_prod_video_url', true);
	ob_start();
	if( !empty($video_url) ){
		echo do_shortcode('[ts_video src='.esc_url($video_url).']');
	}
	die( ob_get_clean() );
}

function yobazar_load_product_360(){
	?>
	<div class="threesixty ts-product-360">
		<div class="spinner">
			<span>0%</span>
		</div>
		<ol class="threesixty_images"></ol>
	</div>
	<?php
}

function yobazar_template_single_countdown(){
	if( yobazar_get_theme_options('ts_prod_count_down') && function_exists('ts_template_loop_time_deals') ){
		ts_template_loop_time_deals();
	}
}

function yobazar_template_single_navigation(){
	if( !yobazar_get_theme_options('ts_prod_next_prev_navigation') ){
		return;
	}
	$prev_post = get_adjacent_post(false, '', true, 'product_cat');
	$next_post = get_adjacent_post(false, '', false, 'product_cat');
	?>
	<div class="single-navigation">
	<?php 
		if( $prev_post ){
			$post_id = $prev_post->ID;
			$product = wc_get_product($post_id);
			?>
			<a href="<?php echo esc_url(get_permalink($post_id)); ?>" rel="prev">
				<div class="product-info prev-product-info">
					<?php echo wp_kses( $product->get_image(), 'yobazar_product_image' ); ?>
				</div>
				<span class="prev-title"><?php esc_html_e('Prev product', 'yobazar'); ?></span>
			</a>
			<?php
		}
		
		if( $next_post ){
			$post_id = $next_post->ID;
			$product = wc_get_product($post_id);
			?>
			<a href="<?php echo esc_url(get_permalink($post_id)); ?>" rel="next">
				<div class="product-info next-product-info">
					<?php echo wp_kses( $product->get_image(), 'yobazar_product_image' ); ?>
				</div>
				<span class="next-title"><?php esc_html_e('Next product', 'yobazar'); ?></span>
			</a>
			<?php
		}
	?>
	</div>
	<?php
}

function yobazar_single_product_availability_bar(){
	global $product;
	
	if( $product->get_type() != 'simple' ){
		return;
	}
	
	if( yobazar_get_theme_options('ts_prod_availability_bar') ){
		$total_sales = $product->get_total_sales();
		$stock_quantity = $product->get_stock_quantity();
		if( $stock_quantity ){
			$total = $total_sales + $stock_quantity;
			$percent = $stock_quantity * 100 / $total;
			?>
			<div class="ts-availability-bar">
				<span><?php printf( esc_html__('Hurry! Only %s left in stock', 'yobazar'), $stock_quantity ); ?></span>
				<div class="progress-bar">
					<span style="width:<?php echo number_format($percent, 2) ?>%"></span>
				</div>
			</div>
			<?php
		}
	}
}

function yobazar_single_product_sold_24h(){
	global $wpdb, $product;
	
	if( $product->get_type() != 'simple' ){
		return;
	}
	
	if( yobazar_get_theme_options('ts_prod_sold_24h') ){
		$product_id = $product->get_id();
		
		$sql = "SELECT SUM(woim.meta_value)
			FROM {$wpdb->prefix}woocommerce_order_itemmeta as woim
			INNER JOIN {$wpdb->prefix}woocommerce_order_itemmeta as woim_2 ON woim_2.order_item_id = woim.order_item_id AND woim_2.meta_key LIKE '_product_id' AND woim_2.meta_value=%s
			INNER JOIN {$wpdb->prefix}woocommerce_order_items as woi ON woi.order_item_id = woim.order_item_id
			INNER JOIN {$wpdb->prefix}posts as p ON p.ID = woi.order_id
			WHERE p.post_status IN ('wc-processing','wc-on-hold','wc-completed')
			AND UNIX_TIMESTAMP(p.post_date) >= (UNIX_TIMESTAMP() - 86400)
			AND woim.meta_key LIKE '_qty'";
		
		$total_sales_24h = (int) $wpdb->get_var( $wpdb->prepare($sql, $product_id) );
		if( $total_sales_24h ){
		?>
			<div class="ts-sold-in-24h">
				<svg width="12" height="15" viewBox="0 0 12 15" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M10.77 8.9298C10.77 10.1949 10.2674 11.4082 9.37288 12.3027C8.47833 13.1973 7.26506 13.6998 5.99998 13.6998C4.7349 13.6998 3.52163 13.1973 2.62708 12.3027C1.73253 11.4082 1.22998 10.1949 1.22998 8.9298C1.22998 6.0998 2.90998 4.5598 4.22998 2.9998L5.00998 4.1598L5.99998 1.2998C5.99998 1.2998 10.77 4.1598 10.77 8.9298Z" stroke="#D9121F" stroke-width="1.5" stroke-miterlimit="10"/>
				<path d="M7.90984 11.6099C7.90984 12.1165 7.70861 12.6023 7.35042 12.9605C6.99222 13.3187 6.50641 13.5199 5.99984 13.5199C5.49328 13.5199 5.00746 13.3187 4.64927 12.9605C4.29108 12.6023 4.08984 12.1165 4.08984 11.6099C4.08984 9.69992 5.99984 8.16992 5.99984 8.16992C5.99984 8.16992 7.90984 9.69992 7.90984 11.6099Z" stroke="#D9121F" stroke-width="1.5" stroke-miterlimit="10"/>
				</svg>
				<?php printf( esc_html__('%s sold in last 24 hours', 'yobazar'), $total_sales_24h ); ?>
			</div>
		<?php
		}
	}
}

function yobazar_template_single_variation_price(){
	if( yobazar_get_theme_options('ts_prod_price') ){
		echo '<div class="ts-variation-price hidden"></div>';
	}
}

function yobazar_variation_attribute_options_args( $args ){
	if( !yobazar_get_theme_options('ts_prod_attr_dropdown') ){
		$args['class'] = 'hidden';
	}
	if( $args['attribute'] ){
		$args['show_option_none'] = esc_html__('Choose your', 'yobazar') . ' ' . wc_attribute_label( $args['attribute'] );
	}
	return $args;
}

function yobazar_get_color_variation_thumbnails(){
	global $product;
	$color_variation_thumbnails = array();
	
	$attribute_name = wc_attribute_taxonomy_name( 'color' );
	$variation_attribute_name = wc_variation_attribute_name( $attribute_name );
	
	$children = $product->get_children();
	if( is_array($children) && count($children) > 0 ){
		foreach( $children as $children_id ){
			$variation_attributes = wc_get_product_variation_attributes( $children_id );
			foreach( $variation_attributes as $attr_name => $attr_value ){
				if( $attr_name == $variation_attribute_name ){
					if( !$attr_value ){ /* Any */
						break;
					}
					if( in_array( $attr_value, array_keys($color_variation_thumbnails) ) ){
						break;
					}
					
					$thumbnail_id = get_post_meta( $children_id, '_thumbnail_id', true );
					if( $thumbnail_id ){
						$thumbnail = wp_get_attachment_image($thumbnail_id, 'woocommerce_thumbnail');
					}
					else{
						$thumbnail = wc_placeholder_img();
					}
					
					$color_variation_thumbnails[$attr_value] = $thumbnail;
					
					break;
				}
			}
		}
	}
	
	return $color_variation_thumbnails;
}

function yobazar_variation_attribute_options_html( $html, $args ){
	$theme_options = yobazar_get_theme_options();
	
	if( $theme_options['ts_prod_attr_dropdown'] ){
		return $html;
	}
	
	global $product;
	
	$attr_color_text = $theme_options['ts_prod_attr_color_text'];
	$use_variation_thumbnail = $theme_options['ts_prod_attr_color_variation_thumbnail'];
	
	$options = $args['options'];
	$attribute_name = $args['attribute'];
	
	ob_start();
	
	if( is_array( $options ) ){
	?>
		<div class="ts-product-attribute">
		<?php 
		$selected_key = 'attribute_' . sanitize_title( $attribute_name );
		
		$selected_value = isset( $_REQUEST[ $selected_key ] ) ? wc_clean( wp_unslash( $_REQUEST[ $selected_key ] ) ) : $product->get_variation_default_attribute( $attribute_name );
		
		// Get terms if this is a taxonomy - ordered
		if( taxonomy_exists( $attribute_name ) ){
			
			$class = 'option';
			$is_attr_color = false;
			$attribute_color = wc_sanitize_taxonomy_name( 'color' );
			if( $attribute_name == wc_attribute_taxonomy_name( $attribute_color ) ){
				if( !$attr_color_text ){
					$is_attr_color = true;
					$class .= ' color';
					
					if( $use_variation_thumbnail ){
						$color_variation_thumbnails = yobazar_get_color_variation_thumbnails();
					}
				}
				else{
					$class .= ' text';
				}
			}
			$terms = wc_get_product_terms( $product->get_id(), $attribute_name, array( 'fields' => 'all' ) );

			foreach ( $terms as $term ) {
				if ( ! in_array( $term->slug, $options ) ) {
					continue;
				}
				$term_name = apply_filters( 'woocommerce_variation_option_name', $term->name );
				
				if( $is_attr_color && !$use_variation_thumbnail ){
					$datas = get_term_meta( $term->term_id, 'ts_product_color_config', true );
					if( $datas ){
						$datas = unserialize( $datas );	
					}else{
						$datas = array(
									'ts_color_color' 				=> "#ffffff"
									,'ts_color_image' 				=> 0
								);
					}
				}
				
				$selected_class = sanitize_title( $selected_value ) == sanitize_title( $term->slug ) ? 'selected' : '';
				
				echo '<div data-value="' . esc_attr( $term->slug ) . '" class="'. $class .' '. $selected_class .'">';
				
				if( $is_attr_color ){
					if( $use_variation_thumbnail ){
						if( isset($color_variation_thumbnails[$term->slug]) ){
							echo '<a href="#">' . $color_variation_thumbnails[$term->slug] . '<span class="ts-tooltip button-tooltip">' . $term_name . '</span></a>';
						}
					}
					else{
						if( absint($datas['ts_color_image']) > 0 ){
							echo '<a href="#">' . wp_get_attachment_image( absint($datas['ts_color_image']), 'ts_prod_color_thumb', true, array('title' => $term_name, 'alt' => $term_name) ) . '<span class="ts-tooltip button-tooltip">' . $term_name . '</span></a>';
						}
						else{
							echo '<a href="#" style="background-color:' . $datas['ts_color_color'] . '"><span class="ts-tooltip button-tooltip">' . $term_name . '</span></a>';
						}
					}
				}
				else{
					echo '<a href="#">' . $term_name . '</a>';
				}
				
				echo '</div>';
			}

		} else {
			foreach( $options as $option ){
				$class = 'option';
				$class .= sanitize_title( $selected_value ) == sanitize_title( $option ) ? ' selected' : '';
				echo '<div data-value="' . esc_attr( $option ) . '" class="' . $class . '"><a href="#">' . esc_html( apply_filters( 'woocommerce_variation_option_name', $option ) ) . '</a></div>';
			}
		}
		?>
	</div>
	<?php
		if( $theme_options['ts_prod_size_chart'] && $theme_options['ts_prod_size_chart_style'] == 'popup' && is_singular('product') ){
			$show_size_chart = false;
			if( taxonomy_exists( $attribute_name ) ){
				if( $attribute_name == wc_attribute_taxonomy_name( wc_sanitize_taxonomy_name('size') ) ){
					$show_size_chart = true;
				}
			}
			else if( sanitize_title( $attribute_name ) == 'size' ){ /* Custom attribute */
				$show_size_chart = true;
			}
		
			if( $show_size_chart && yobazar_get_product_size_chart_id() ){
				echo '<a class="ts-product-size-chart-button" href="#">' . esc_html__('Size guide', 'yobazar') . '</a>';
				add_action('wp_footer', 'yobazar_add_product_size_chart_popup_modal', 999);
				wp_cache_set('yobazar_size_chart_added', 1); /* show in tabs if not added */
			}
		}
	}
	
	return ob_get_clean() . $html;
}

function yobazar_template_single_sku(){
	global $product;
	if ( wc_product_sku_enabled() && ( $product->get_sku() || $product->is_type( 'variable' ) ) ){
		echo '<div class="sku-wrapper product_meta"><span>' . esc_html__( 'Product code', 'yobazar' ) . '</span><span class="sku">' . (( $sku = $product->get_sku() ) ? $sku : esc_html__( 'N/A', 'yobazar' )) . '</span></div>';
	}
}
function yobazar_template_single_availability(){
	global $product;

	$product_stock = $product->get_availability();
	$availability_text = empty($product_stock['availability'])?esc_html__('In Stock', 'yobazar'):esc_attr($product_stock['availability']);
	?>	
		<div class="availability stock <?php echo esc_attr($product_stock['class']); ?>" data-original="<?php echo esc_attr($availability_text) ?>" data-class="<?php echo esc_attr($product_stock['class']) ?>">
			<span><?php esc_html_e('Availability', 'yobazar') ?></span>
			<span class="availability-text"><?php echo esc_html($availability_text); ?></span>
		</div>	
	<?php
}

function yobazar_single_product_buy_now_button(){
	if( yobazar_get_theme_options('ts_enable_catalog_mode') ){
		return;
	}
	
	global $product;
	if( yobazar_get_theme_options('ts_prod_buy_now') && in_array( $product->get_type(), array('simple', 'variable') ) && $product->is_purchasable() && $product->is_in_stock() ){
	?>
		<a href="#" class="button ts-buy-now-button"><?php esc_html_e('Buy it now', 'yobazar'); ?></a>
	<?php
	}
}

function yobazar_product_buy_now_redirect( $url ){
	if( isset($_REQUEST['ts_buy_now']) && $_REQUEST['ts_buy_now'] == 1 ){
		return apply_filters( 'yobazar_product_buy_now_redirect_url', wc_get_checkout_url() );
	}
	return $url;
}

function yobazar_template_single_meta(){
	global $product;
	$theme_options = yobazar_get_theme_options();
	
	echo '<div class="meta-content">';
		do_action( 'woocommerce_product_meta_start' );
		if( $theme_options['ts_prod_sku'] ){
			yobazar_template_single_sku();
		}
		if( $theme_options['ts_prod_availability'] ){
			yobazar_template_single_availability();
		}
		if( $theme_options['ts_prod_cat'] ){
			echo wc_get_product_category_list( $product->get_id(), ', ', '<div class="cats-link"><span>' . esc_html__( 'Categories', 'yobazar' ) . '</span><span class="cat-links">', '</span></div>' );
		}
		if( $theme_options['ts_prod_tag'] ){
			echo wc_get_product_tag_list( $product->get_id(), ', ', '<div class="tags-link"><span>' . esc_html__( 'Tags', 'yobazar' ) . '</span><span class="tag-links">', '</span></div>' );	
		}
		do_action( 'woocommerce_product_meta_end' );
	echo '</div>';
}

/************************************* 
* Group single product buttons sharing 
* Start div 31
* Wishlist 31
* Compare 35
* Ask about product 40
* Close div buttons 41
* Sharing 70
* Close div 71
*************************************/
function yobazar_single_product_buttons_sharing_start(){
	?>
	<div class="single-product-buttons-sharing">
		<div class="single-product-buttons">
	<?php
}

function yobazar_single_product_buttons_end(){
	?>
	</div>
	<?php
}

function yobazar_single_product_buttons_sharing_end(){
	?>
	</div>
	<?php
}

function yobazar_mysql_version_greater_8(){
	if( function_exists('wc_get_server_database_version') ){
		$database_version = wc_get_server_database_version();
		$number = isset($database_version['number']) ? $database_version['number'] : '';
		if( $number ){
			if( version_compare( $number, '8.0.0', '>=' ) ){
				return true;
			}
		}
	}
	return false;
}

/*** Product size chart ***/
function yobazar_get_product_size_chart_id(){
	global $product;
	$product_id = $product->get_id();
	$cache_key = 'yobazar_size_chart_id_of_' . $product_id;
	$size_chart_id = wp_cache_get($cache_key);
	if( false !== $size_chart_id ){
		return $size_chart_id;
	}
	$size_chart_id = get_post_meta($product_id, 'ts_prod_size_chart', true);
	if( $size_chart_id ){
		wp_cache_set($cache_key, $size_chart_id);
		return $size_chart_id;
	}
	$product_cats = wc_get_product_term_ids( $product_id, 'product_cat' );
	if( !empty($product_cats) && is_array($product_cats) ){
		$args = array(
                    'posts_per_page'         => 1,
                    'order'                  => 'DESC',
                    'post_type'              => 'ts_size_chart',
                    'post_status'            => 'publish',
                    'no_found_rows'          => true,
                    'update_post_term_cache' => false,
                    'fields'                 => 'ids',
                );
				
		if( count( $product_cats ) > 1 ){
			$args['meta_query']['relation'] = 'OR';
		}
		
		foreach( $product_cats as $product_cat ){
			$args['meta_query'][] = array(
				'key'     => 'ts_chart_categories',
				'value'   => yobazar_mysql_version_greater_8() ? "\\b{$product_cat}\\b" : "[[:<:]]{$product_cat}[[:>:]]",
				'compare' => 'RLIKE',
			);
		}
		
		$size_charts = new WP_Query( $args );
		if( $size_charts->have_posts() ){
			foreach( $size_charts->posts as $id ){
				$size_chart_id = $id;
			}
		}
		wp_reset_postdata();
	}
	wp_cache_set($cache_key, $size_chart_id);
	
	return $size_chart_id;
}

function yobazar_product_size_chart_content(){
	$chart_id = yobazar_get_product_size_chart_id();
	$chart_content = apply_filters( 'the_content', get_the_content( null, false, $chart_id ) );
	$chart_label = get_post_meta( $chart_id, 'ts_chart_label', true );
	$chart_image = get_post_meta( $chart_id, 'ts_chart_image', true );
	$chart_table = get_post_meta( $chart_id, 'ts_chart_table', true );
	
	if( $chart_table ){
		$chart_table = json_decode( $chart_table, true );
		if( is_array($chart_table) ){
			$chart_table = array_filter($chart_table, function($v, $k){
				return is_array($v) && array_filter($v);
			}, ARRAY_FILTER_USE_BOTH);
		}
	}
	
	$classes = array();
	if( $chart_image ){
		$classes[] = 'has-image';
	}
	
	if( !empty($chart_table) && is_array($chart_table) ){
		$classes[] = 'has-table';
	}
	?>
	<div class="ts-size-chart-content <?php echo implode(' ', $classes); ?>">
		<?php
		if( $chart_label ){
			echo '<h5 class="chart-label">'.esc_html($chart_label).'</h5>';
		}
		
		if( $chart_content ){
			echo '<div class="chart-content">';
				echo wp_kses_post( $chart_content ); /* Allowed html as post content */
			echo '</div>';
		}
		
		if( $chart_image ){
			echo '<div class="chart-image">';
				echo '<img src="'.esc_url($chart_image).'" alt="'.esc_attr($chart_label).'" />';
			echo '</div>';
		}
		
		if( !empty($chart_table) && is_array($chart_table) ){
			echo '<table class="chart-table"><tbody>';
			foreach( $chart_table as $row ){
				echo '<tr>';
				foreach( $row as $col ){
					echo '<td>'.esc_html($col).'</td>';
				}
				echo '</tr>';
			}
			echo '</tbody></table>';
		}
		?>
	</div>
	<?php
}

/*** Product tab ***/
function yobazar_product_remove_tabs( $tabs = array() ){
	if( !yobazar_get_theme_options('ts_prod_tabs') ){
		return array();
	}
	if( yobazar_get_theme_options('ts_prod_separate_reviews_tab') ){
		unset( $tabs['reviews'] );
	}
	return $tabs;
}

function yobazar_product_reviews_tab_content(){
	if( yobazar_get_theme_options('ts_prod_separate_reviews_tab') ){
		comments_template();
	}
}

function yobazar_add_product_custom_tab( $tabs = array() ){
	global $post;
	$theme_options = yobazar_get_theme_options();
	$size_chart_style = $theme_options['ts_prod_size_chart_style'];
	$show_size_chart = $theme_options['ts_prod_size_chart'] 
						&& ( $size_chart_style == 'tab' || ( $size_chart_style == 'popup' && wp_cache_get('yobazar_size_chart_added') === false ) );
						
	if( $show_size_chart && yobazar_get_product_size_chart_id() ){
		$tabs['ts_size_chart'] = array(
			'title'    	=> esc_html__('Size Chart', 'yobazar')
			,'priority' => 25
			,'callback' => 'yobazar_product_size_chart_content'
		);
	}
	
	$override_custom_tab = get_post_meta( $post->ID, 'ts_prod_custom_tab', true );
	
	if( $theme_options['ts_prod_custom_tab'] || $override_custom_tab ){
		if( $override_custom_tab ){
			$custom_tab_title = get_post_meta( $post->ID, 'ts_prod_custom_tab_title', true );
		}
		else{
			$custom_tab_title = $theme_options['ts_prod_custom_tab_title'];
		}
	
		$tabs['ts_custom'] = array(
			'title'    	=> esc_html( $custom_tab_title )
			,'priority' => 90
			,'callback' => 'yobazar_product_custom_tab_content'
		);
	} 
	return $tabs;
}

function yobazar_product_custom_tab_content(){
	global $post;
	
	if( get_post_meta( $post->ID, 'ts_prod_custom_tab', true ) ){
		$custom_tab_content = get_post_meta( $post->ID, 'ts_prod_custom_tab_content', true );
	}
	else{
		$custom_tab_content = yobazar_get_theme_options('ts_prod_custom_tab_content');
	}
	
	echo do_shortcode( stripslashes( wp_specialchars_decode( $custom_tab_content ) ) );
}

/* Ads Banner */
function yobazar_product_ads_banner(){
	if( yobazar_get_theme_options('ts_prod_ads_banner') ){
		echo '<div class="ads-banner">';
		echo do_shortcode( stripslashes( wp_specialchars_decode( yobazar_get_theme_options('ts_prod_ads_banner_content') ) ) );
		echo '</div>';
	}
}

/* Related Products */
function yobazar_output_related_products_args_filter( $args ){
	$args['posts_per_page'] = 6;
	$args['columns'] = 5;
	return $args;
}

/* New Arrival Products */
function yobazar_new_arrival_products(){
	if( !class_exists('WooCommerce') ){
		return;
	}
	
	if( is_singular('product') && !yobazar_get_theme_options('ts_prod_new_arrivals') ){
		return;
	}
	
	if( is_404() ){
		if( !yobazar_get_theme_options('ts_404_new_arrival_products') ){
			return;
		}
		else{
			yobazar_remove_hooks_from_shop_loop();
		}
	}
	
	$args = array(
			'post_type'				=> 'product'
			,'post_status' 			=> 'publish'
			,'posts_per_page' 		=> apply_filters('yobazar_new_arrival_products_limit', 8)
			,'orderby' 				=> 'date'
			,'order' 				=> 'desc'
			,'meta_query' 			=> WC()->query->get_meta_query()
			,'tax_query'           	=> WC()->query->get_tax_query()
		);
		
	$products = new WP_Query( $args );
	
	if( $products->have_posts() ){
	?>
	<section class="woocommerce related products new-arrivals">
		<h2><?php esc_html_e('New Arrivals', 'yobazar'); ?></h2>
		<?php
		woocommerce_product_loop_start();
		while( $products->have_posts() ){
			$products->the_post();
			wc_get_template_part( 'content', 'product' );
		}
		woocommerce_product_loop_end();
		?>
	</section>
	<?php
	}
	
	wp_reset_postdata();
}

/* Change grouped product columns */
function yobazar_woocommerce_grouped_product_columns( $columns ){
	$columns = array('label', 'price', 'quantity');
	return $columns;
}

/*** General hook ***/

/*************************************************************
* Custom group button on product (quickshop, wishlist, compare) 
* Begin tag: 	10000
* Quickshop: 	10001
* Compare:   	10002
* Wishlist:  	10003
* Add To Cart: 	10004
* End tag:   	10005
**************************************************************/
add_action('woocommerce_after_shop_loop_item_title', 'yobazar_template_loop_add_to_cart', 10004 );
function yobazar_product_group_button_start(){	
	echo '<div class="product-group-button">';
}

function yobazar_product_group_button_end(){
	echo '</div>';
}

add_action('init', 'yobazar_wrap_product_group_button', 20);
function yobazar_wrap_product_group_button(){
	add_action('woocommerce_after_shop_loop_item_title', 'yobazar_product_group_button_start', 10000 );
	add_action('woocommerce_after_shop_loop_item_title', 'yobazar_product_group_button_end', 10005 );
}

/* Wishlist */
if( class_exists('YITH_WCWL') ){
	function yobazar_add_wishlist_button_to_product_list(){
		echo '<div class="button-in wishlist">';
		echo do_shortcode('[yith_wcwl_add_to_wishlist]');
		echo '</div>';
	}
	
	if( 'yes' == get_option( 'yith_wcwl_show_on_loop', 'no' ) ){
		add_action( 'woocommerce_after_shop_loop_item_title', 'yobazar_add_wishlist_button_to_product_list', 10003 );
		add_action( 'woocommerce_after_shop_loop_item_2', 'yobazar_add_wishlist_button_to_product_list', 50 );
	
		add_filter( 'yith_wcwl_loop_positions', '__return_empty_array' ); /* Remove button which added by plugin */
	}
	
	add_filter('yith_wcwl_add_to_wishlist_params', 'yobazar_yith_wcwl_add_to_wishlist_params');
	function yobazar_yith_wcwl_add_to_wishlist_params( $additional_params ){
		if( isset($additional_params['container_classes']) && $additional_params['exists'] ){
			$additional_params['container_classes'] .= ' added';
		}
		$additional_params['label'] = '<span class="ts-tooltip button-tooltip" data-title="'.esc_attr__('Add to wishlist', 'yobazar').'">' . esc_html__('Wishlist', 'yobazar') . '</span>';
		return $additional_params;
	}
	
	add_filter('yith_wcwl_browse_wishlist_label', 'yobazar_yith_wcwl_browse_wishlist_label', 10, 2);
	function yobazar_yith_wcwl_browse_wishlist_label( $text = '', $product_id = 0 ){
		if( $product_id ){
			return '<span class="ts-tooltip button-tooltip" data-title="'.esc_attr__('Add to wishlist', 'yobazar').'">' . esc_html__('Wishlist', 'yobazar') . '</span>';
		}
		return $text;
	}
	
	add_filter('yith_wcwl_add_to_wishlist_icon_html', '__return_empty_string'); /* Use theme icon */
	add_filter('yith_wcwl_add_to_wishlist_heading_icon_html', '__return_empty_string'); /* Use theme icon */

	add_action('admin_enqueue_scripts', function(){ /* Disable react notice */
		wp_add_inline_style('yobazar-admin-style', '.yith-plugins_page_yith_wcwl_panel .yith-plugin-fw__notice--warning{display: none;}');
	}, 99);

	if( !get_option('yith_wcwl_rendering_method') ){ /* Use php templates instead of react */
		update_option('yith_wcwl_rendering_method', 'php-templates');
	}
}

/* Compare */
if( class_exists('YITH_Woocompare') ){
	add_action('init', 'yobazar_yith_compare_handle', 30);
	function yobazar_yith_compare_handle(){
		global $yith_woocompare;
		$is_ajax = ( defined( 'DOING_AJAX' ) && DOING_AJAX );
		if( $yith_woocompare->is_frontend() || $is_ajax ){
			if( get_option('yith_woocompare_compare_button_in_products_list') == 'yes' ){
				if( $is_ajax ){
					if( defined('YITH_WOOCOMPARE_DIR') && !class_exists('YITH_Woocompare_Frontend') ){
						$compare_frontend_class = YITH_WOOCOMPARE_DIR . 'includes/class.yith-woocompare-frontend.php';
						if( file_exists($compare_frontend_class) ){
							require_once $compare_frontend_class;
						}
						$yith_woocompare->obj = new YITH_Woocompare_Frontend();
					}
				}
				remove_action( 'woocommerce_after_shop_loop_item', array( $yith_woocompare->obj, 'add_compare_link' ), 20 );
				
				add_action( 'woocommerce_after_shop_loop_item_title', 'yobazar_add_compare_button_to_product_list', 10002 );
				add_action( 'woocommerce_after_shop_loop_item_2', 'yobazar_add_compare_button_to_product_list', 60 );
			}
			
			add_filter( 'option_yith_woocompare_button_text', 'yobazar_compare_button_text_filter', 99 );
		}
	}
	
	function yobazar_add_compare_button_to_product_list(){
		global $yith_woocompare, $product;
		echo '<div class="button-in compare">';
		echo '<a class="compare" href="'.$yith_woocompare->obj->add_product_url( $product->get_id() ).'" data-product_id="'.$product->get_id().'">'.get_option('yith_woocompare_button_text').'</a>';
		echo '</div>';
	}
	
	function yobazar_compare_button_text_filter( $button_text ){
		return '<span class="ts-tooltip button-tooltip" data-title="'.esc_attr__('Add to compare', 'yobazar').'">'.esc_html($button_text).'</span>';
	}
}

/* Ask about product */
function yobazar_ask_about_product_button(){
	$contact_page = yobazar_get_theme_options('ts_prod_contact_page');
	if( $contact_page ){
	?>
	<a href="<?php echo esc_url( get_permalink($contact_page) ); ?>" target="_blank" class="ask-about-product-button"><?php esc_html_e( 'Ask about product', 'yobazar' ); ?></a>
	<?php
	}
}

/*************************************************************
* Group button on product meta (add to cart, wishlist, compare) 
* Begin tag: 30
* Add to cart: 40
* Compare: 60
* quicklist: 50
* End tag: 70
*************************************************************/
add_action('woocommerce_after_shop_loop_item_2', 'yobazar_product_group_button_meta_start', 30);
add_action('woocommerce_after_shop_loop_item_2', 'yobazar_product_group_button_meta_end', 70);
function yobazar_product_group_button_meta_start(){
	echo '<div class="product-group-button-meta">';
}
function yobazar_product_group_button_meta_end(){
	echo '</div>';
}
/*** End General hook ***/

/*** Quantity Input hooks ***/
add_action('woocommerce_before_quantity_input_field', 'yobazar_before_quantity_input_field', 1);
function yobazar_before_quantity_input_field(){
	?>
	<div class="number-button">
		<input type="button" value="-" class="minus" />
	<?php
}

add_action('woocommerce_after_quantity_input_field', 'yobazar_after_quantity_input_field', 99);
function yobazar_after_quantity_input_field(){
	?>
		<input type="button" value="+" class="plus" />
	</div>
	<?php
}

/*** Cart - Checkout hooks ***/
remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display', 10 );
add_action( 'woocommerce_after_cart', 'woocommerce_cross_sell_display', 10 );

add_action('woocommerce_cart_actions', 'yobazar_empty_cart_button');
function yobazar_empty_cart_button(){
?>
	<button type="submit" class="button empty-cart-button" name="ts_empty_cart" value="<?php esc_attr_e('Empty cart', 'yobazar'); ?>"><?php esc_html_e('Empty cart', 'yobazar'); ?></button>
<?php
}

add_action('init', 'yobazar_empty_woocommerce_cart');
function yobazar_empty_woocommerce_cart(){
	if( isset($_POST['ts_empty_cart']) ){
		WC()->cart->empty_cart();
	}
}

add_action('woocommerce_before_checkout_form', 'yobazar_before_checkout_form_start', 1);
add_action('woocommerce_before_checkout_form', 'yobazar_before_checkout_form_end', 999);
function yobazar_before_checkout_form_start(){
	echo '<div class="checkout-login-coupon-wrapper">';
}
function yobazar_before_checkout_form_end(){
	echo '</div>';
}

remove_action('woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10);
add_action('woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 20);

remove_action('woocommerce_before_checkout_form', 'woocommerce_output_all_notices', 10);
add_action('woocommerce_before_checkout_form', 'woocommerce_output_all_notices', 1000);

if( !( is_user_logged_in() || 'no' === get_option( 'woocommerce_enable_checkout_login_reminder' ) ) ){
	add_action('woocommerce_before_checkout_form', function(){
		echo '<div class="checkout-login-wrapper">';
	}, 9);
	add_action('woocommerce_before_checkout_form', function(){
		echo '</div>';
	}, 11);
}

if( function_exists('wc_coupons_enabled') && wc_coupons_enabled() ){
	add_action('woocommerce_before_checkout_form', function(){
		echo '<div class="checkout-coupon-wrapper">';
	}, 19);
	add_action('woocommerce_before_checkout_form', function(){
		echo '</div>';
	}, 21);
}
?>