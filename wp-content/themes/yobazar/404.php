<?php 
get_header();

$theme_options = yobazar_get_theme_options();

$text_clipping = $theme_options['ts_text_clipping'];
$image_404 = $theme_options['ts_image_not_found'];
$image_404 = !empty($image_404['url'])?$image_404['url']:'';

yobazar_breadcrumbs_title(true, false, '');
?>
	<div class="page-container show_breadcrumb_<?php echo esc_attr($theme_options['ts_breadcrumb_layout']); ?>">
		<div id="main-content">	
			<div id="primary" class="site-content">
				<article>
					<div class="not-found <?php echo esc_attr($text_clipping?'has-text-clipping':''); ?>">
						<div class="content-404 <?php echo ('' != $image_404)?'ts-col-12':'ts-col-24'; ?>">
							<h1><?php esc_html_e('404', 'yobazar'); ?></h1>
							<h5><?php esc_html_e('This page has been probably moved somewhere...', 'yobazar'); ?></h5>
							<p><?php esc_html_e('Please back to homepage or check our offer', 'yobazar'); ?></p>
							<a href="<?php echo esc_url( home_url('/') ) ?>" class="button"><?php esc_html_e('Back to homepage', 'yobazar'); ?></a>
						</div>
						
						<?php if( $image_404 ): ?>
							<div class="image-404 ts-col-12">
							
								<?php if( $text_clipping ): ?>
								<div class="text-clipping"><?php echo esc_html($text_clipping); ?></div>
								<?php endif; ?>
								
								<img src="<?php echo esc_url($image_404); ?>" alt="<?php esc_attr_e('404 image', 'yobazar'); ?>" />
								
							</div>
						<?php endif; ?>
					</div>
					<?php yobazar_new_arrival_products(); ?>
				</article>
			</div>
		</div>
	</div>
<?php
get_footer();