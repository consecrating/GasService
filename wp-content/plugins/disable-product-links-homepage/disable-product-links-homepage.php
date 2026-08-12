<?php
/**
 * Plugin Name: Disable Product Links on Homepage
 * Description: Removes clickable links from WooCommerce products shown on the homepage only.
 * Version: 1.0
 * Author: Sanctify
 */

add_action('template_redirect', 'disable_product_links_homepage');
function disable_product_links_homepage() {
    if (is_front_page()) {
        remove_action('woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10);
        remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5);
    }
}
?>
