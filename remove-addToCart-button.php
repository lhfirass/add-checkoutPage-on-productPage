/**
* @snippet Add ‘View Product’ button before ‘Add to Cart’ in WooCommerce
* @source https://www.wptechnic.com/?p=6692
* @compatible WC 6.3.1
*/
add_action('woocommerce_after_shop_loop_item', 'wptechnic_custom_button_view_product', 5 );
function wptechnic_custom_button_view_product() {
    global $product;

    // Ignore for Variable and Group products
    if( $product->is_type('variable') || $product->is_type('grouped') ) return;

    // Display the custom button
    echo '<a style="margin-right:5px" class="button wptechnic-custom-button-view-product" href="' . esc_attr( $product->get_permalink() ) . '">' . __('View product') . '</a>';
}