<?php
/**
 * Plugin Name:       one-page-checkout-for-WOOCOMMERCE
 * Plugin URI:        don't follow any link this code is free for you
 * Description:       turn the product page into a checkout page by displaying checkout fields forms on a product page.
 * Version:           1.2.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            FPIXELS.edited by lhfirass
 */

function woo_custom_add_to_cart( $cart_item_data ) {
global $woocommerce;
$woocommerce->cart->empty_cart();
return $cart_item_data;
}
add_filter( 'woocommerce_add_cart_item_data', 'woo_custom_add_to_cart' );
/* change order checkout to arabic */
add_action( 'woocommerce_checkout_after_order_review', 'second_place_order_button', 5 );
function second_place_order_button() {

    $order_button_text = apply_filters( 'woocommerce_order_button_text', __( "Place order", "woocommerce" ) );

    echo '<button type="submit" class="button alt" name="woocommerce_checkout_place_order" id="place_order" value="' . esc_attr( $order_button_text ) . '" data-value="' . esc_attr( $order_button_text ) . '">' . esc_html( $order_button_text ) . '</button>';

}
add_filter( 'woocommerce_order_button_text', 'woo_custom_order_button_text' ); 
function woo_custom_order_button_text() {

    return __( 'اطلب الان', 'woocommerce' ); 

}

/*empty cart if user come to homepage*/
add_action( 'init', 'woocommerce_clear_cart_url' );
function woocommerce_clear_cart_url() {
global $woocommerce;

if ($_SERVER['REQUEST_URI'] === '/') { 
    $woocommerce->cart->empty_cart(); 
}
}

add_filter('woocommerce_short_description','ts_add_text_short_descr');
function ts_add_text_short_descr($description){
    $text="[woocommerce_checkout]";
    return $description.$text;
}
defined('ABSPATH') || exit;
class Allow_Only_one_Product_in_Cart_woocommerce {
    function __construct() {
        add_action( 'woocommerce_before_calculate_totals', array($this,'wcaopc_keep_only_last_cart_item'), 30, 1 );
    }
function wcaopc_keep_only_last_cart_item( $cart ) {
    if ( is_admin() && ! defined( 'DOING_AJAX' ) )
        return;
    if ( did_action( 'woocommerce_before_calculate_totals' ) >= 2 )
        return;
    $cart_items = $cart->get_cart();
    if( count($cart_items) > 1 ){
        $cart_item_keys = array_keys( $cart_items );
        $cart->remove_cart_item( reset($cart_item_keys) );
    }
    }
}
$plugin = new Allow_Only_one_Product_in_Cart_woocommerce ();


add_action( 'template_redirect','add_product_into_cart_when_visit_product_page' );
function add_product_into_cart_when_visit_product_page(){
    if ( class_exists('WooCommerce') ){
        if( is_product() ){
            global $woocommerce;
            $quantity = 1;
            $woocommerce->cart->add_to_cart( get_the_ID(), $quantity );
        }
    } 
}
/* Custom CSS */
function wp_css_custome(){
?>
    <style type="text/css">
        <?php echo get_option('css_field'); ?>
.ast-woocommerce-container .product .product_meta {display:none;}
.ast-woocommerce-container .product .cart {display:none;}
/* Button */
#place_order{
	top:-74px;
}
/* 700px and smaller screen sizes */
@media (max-width:700px){

	/* Button */
	#place_order{
		top:-58px;
		transform:translatex(0px) translatey(0px);
		
	}
	
}
button#place_order {
width: 100%;
}
.woocommerce-billing-fields h3 {display:none;}
#order_review {display:none;}
#order_review_heading {display:none;}
#customer_details .woocommerce-additional-fields {display:none;}
#ast-site-header-cart {display:none;}
#main .woocommerce-products-header {display:none;}
.woocommerce .woocommerce-checkout .col2-set .col-1,
.woocommerce .woocommerce-checkout .col2-set .col-2 {
    width: 100% !important;
}
.woocommerce .woocommerce-checkout .col2-set .col-1 {
    margin-bottom: 30px;
}
</style>
<?php
}
add_action('wp_head','wp_css_custome');