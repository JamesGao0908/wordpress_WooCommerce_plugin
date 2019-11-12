<?php

if ( ! function_exists( 'custom_mini_cart' ) ) {
	function custom_mini_cart() { 
	    echo '<a href="#" class="dropdown-back" data-toggle="dropdown"> ';
	    echo '<i class="fa fa-shopping-cart" aria-hidden="true"></i>';
	    echo '<div class="basket-item-count" style="display: inline;">';
	    echo '<span class="cart-items-count count">';
	    echo WC()->cart->get_cart_contents_count();
	    echo '</span>';
	    echo '</div>';
	    echo '</a>';
	    echo '<ul class="dropdown-menu dropdown-menu-mini-cart">';
	    echo '<li> <div class="widget_shopping_cart_content">';
	    woocommerce_mini_cart();
	    echo '</div></li></ul>';
	}
	add_shortcode( '[custom-techno-mini-cart]', 'custom_mini_cart' );
}

if ( ! function_exists( 'is_adding_address' ) ) {

	/**
	 * Is_adding_address - Returns true when viewing the checkout page.
	 *
	 * @return bool
	 */
	function is_adding_address() {
		return is_page('adding_address');
	}
}


?>
