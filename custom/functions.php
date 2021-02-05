<?php
/**
 * Functions.php
 *
 * @package  Theme_Customisations
 * @author   WooThemes
 * @since    1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * functions.php
 * Add PHP snippets here
 */


$allowed_thursdays_fridays_ids = [84, 83];
$allowed_sunday_ids = [86, 85];

add_filter( 'woocommerce_add_to_cart_validation', 'checkCartContents', 99, 2 );
function checkCartContents($passed, $added_product_id) {
	$items = [];
	foreach( WC()->cart->get_cart() as $cart_item ){
    	array_push($items, $cart_item['product_id']);
	}

	if(in_array($added_product_id, $allowed_thursdays_fridays_ids)) {
		$wrongItemIsInCart = false;
		foreach($items as $item) {
			if(in_array($item, $allowed_sunday_ids)) {
				$wrongItemIsInCart = true;
			}
		}

		if($wrongItemIsInCart) {
			wc_empty_cart();
			return $passed;
		}
	} elseif(in_array($added_product_id, $allowed_sundays_ids)) {
		$wrongItemIsInCart = false;
		foreach($items as $item) {
			if(in_array($item, $allowed_thursdays_fridays_ids)) {
				$wrongItemIsInCart = true;
			}
		}

		if($wrongItemIsInCart) {
			wc_empty_cart();
			return $passed;
		}
	} else {
		return $passed;
	}
}