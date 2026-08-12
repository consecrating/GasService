<?php
/**
 *	Template Name: Blog Template
 */	
get_header();

global $post;
setup_postdata($post);

$page_options = yobazar_get_page_options();

$extra_class = 'columns-' . yobazar_get_theme_options('ts_blog_columns');

$page_column_class = yobazar_page_layout_columns_class($page_options['ts_page_layout']);

$show_breadcrumb = ( !is_home() && !is_front_page() && $page_options['ts_show_breadcrumb'] );
$show_page_title = ( !is_home() && !is_front_page() && $page_options['ts_show_page_title'] );

if( $show_breadcrumb || $show_page_title ){
	$extra_class .= ' show_breadcrumb_'.yobazar_get_theme_options('ts_breadcrumb_layout');
}

yobazar_breadcrumbs_title($show_breadcrumb, $show_page_title, get_the_title());
	
?>
<div class="page-template blog-template page-container container-post <?php echo esc_attr($extra_class) ?>">
	<!-- Page slider -->
	<?php if( $page_options['ts_page_slider'] && $page_options['ts_page_slider_position'] == 'before_main_content' ): ?>
	<div class="top-slideshow">
		<div class="top-slideshow-wrapper">
			<?php yobazar_show_page_slider(); ?>
		</div>
	</div>
	<?php endif; ?>

	<!-- Left Sidebar -->
	<?php if( $page_column_class['left_sidebar'] ): ?>
		<div id="left-sidebar" class="ts-sidebar <?php echo esc_attr($page_column_class['left_sidebar_class']); ?>">
			<aside>
			<?php if( is_active_sidebar($page_options['ts_left_sidebar']) ): ?>
				<?php dynamic_sidebar( $page_options['ts_left_sidebar'] ); ?>
			<?php endif; ?>
			</aside>
		</div>
	<?php endif; ?>			
	
	<div id="main-content" class="<?php echo esc_attr($page_column_class['main_class']); ?>">	
		<div id="primary" class="site-content">
			
			<?php if( get_the_content() ): ?>
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<?php the_content(); ?>
			</article>
			<?php endif; ?>
			
			<?php
				$paged = 1;
				if( is_paged() ){
					$paged = get_query_var('page');
					if( !$paged ){
						$paged = get_query_var('paged');
					}
				}
				
				$args = array(
						'post_type' => 'post'
						,'paged'	=> $paged
					);
					
				$args = apply_filters('yobazar_blog_template_query_args', $args);
				
				$posts = new WP_Query( $args );
				if( $posts->have_posts() ):
				
					if( yobazar_get_theme_options('ts_blog_filter_bar') ){
						wp_enqueue_script( 'isotope' );
						
						$terms = array();
						foreach( $posts->posts as $p ){
							$post_terms = wp_get_post_terms($p->ID, 'category');
							if( is_array($post_terms) ){
								foreach( $post_terms as $term ){
									$terms[$term->slug] = $term->name;
								}
							}
						}
						
						if( !empty($terms) ){
							?>
							<ul class="blog-filter-bar">
								<li data-filter="*" class="current"><?php esc_html_e('All', 'yobazar'); ?></li>
								<?php foreach( $terms as $slug => $name ){ ?>
									<li data-filter="<?php echo '.category-' . esc_attr($slug); ?>"><?php echo esc_html($name); ?></li>
								<?php } ?>
							</ul>
							<?php
						}
					}
				
					echo '<div class="list-posts">';
					while( $posts->have_posts() ) : $posts->the_post();
						get_template_part( 'content', get_post_format() ); 
					endwhile;
					echo '</div>';
					
					wp_reset_postdata();
				else:
					echo '<div class="alert alert-error">'.esc_html__('Sorry. There are no posts to display', 'yobazar').'</div>';
				endif;
				
				yobazar_pagination($posts);
			?>

		</div>
	</div>
	
	
	<!-- Right Sidebar -->
	<?php if( $page_column_class['right_sidebar'] ): ?>
		<div id="right-sidebar" class="ts-sidebar <?php echo esc_attr($page_column_class['right_sidebar_class']); ?>">
			<aside>
			<?php if( is_active_sidebar($page_options['ts_right_sidebar']) ): ?>
				<?php dynamic_sidebar( $page_options['ts_right_sidebar'] ); ?>
			<?php endif; ?>
			</aside>
		</div>
	<?php endif; ?>	
		
</div><!-- #container -->
<?php get_footer(); ?>