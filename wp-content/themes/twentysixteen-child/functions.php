<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

// BEGIN ENQUEUE PARENT ACTION
// AUTO GENERATED - Do not modify or remove comment markers above or below:

if ( !function_exists( 'chld_thm_cfg_parent_css' ) ):
    function chld_thm_cfg_parent_css() {
        wp_enqueue_style( 'chld_thm_cfg_parent', trailingslashit( get_template_directory_uri() ) . 'style.css', array( 'genericons' ) );
    }
endif;
add_action( 'wp_enqueue_scripts', 'chld_thm_cfg_parent_css', 10 );

// END ENQUEUE PARENT ACTION

// function abc(){
// 	echo '<div>bbbbb</div>';
// }
// add_action( 'woocommerce_single_product_summary', 'abc', 41 );





function is_bought_items() {

    $bought = false;

    // setting the IDs of specific products that are needed to be bought by the customer
    // => Replace the example numbers by your specific product IDs
    $prod_arr = array( '3937');

    // Get all customer orders
    $customer_orders = get_posts( array(
        'numberposts' => -1,
        'meta_key'    => '_customer_user',
        'meta_value'  => get_current_user_id(),
        'post_type'   => 'shop_order', // WC orders post type
        'post_status' => 'wc-completed' // Only orders with status "completed"
    ) );

    // Going through each current customer orders
    foreach ( $customer_orders as $customer_order ) {
        $order = wc_get_order( $customer_order );
        // $order_id = $order->id;

        // Going through each current customer products bought in the order
        foreach ($items as $item) {

            // Your condition related to your 2 specific products Ids
            if ( in_array( $item['product_id'], $prod_arr ) ) {

                $bought = true; // Corrected mistake in variable name
            }
        }
    }

    // return "true" if one the specifics products have been bought before by customer
    if ( $bought ) {
        return true;
    }
}
