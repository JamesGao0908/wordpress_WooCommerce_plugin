<?php

/*
	Plugin Name: 头部修改插件
	Plugin URI:
	Description: 这个插件会修改woocommerce的产品页面，移除其脚部的文件，重新加入三个按键，分别为'店铺'，'立即购买'，'加入购物车'。
    Author: 高志强
	Version: 1.0.0
	Author URI: http://310club.com
*/
if (! defined('ABSPATH')) {
    die();
}
// 移除在产品界面的脚部，并且加上三个新的按钮
function remove_footer_links( $links ) 
{
	//判别是不是在产品界面
	if( wc_get_product(get_the_ID()) != null)
	{
		//修改 $links 函数数据
		unset( $links );
	
		$links = array(
			'home'=> array(
				'priority' => 10,
				'callback' => 'go_home_button',				
			),
			'my_addition_cart' => array(
				'priority' => 20,
				'callback' => 'add_to_cart',
			),			
			'my_addition_buy_now'=> array(
				'priority' => 30,
				'callback' => 'buy_now',
			),
		);
	}

	return $links;
}

// 移除购物车界面下面的脚部
function remove_footer_cart( $links )
{
	if( is_cart() )
	{
		unset( $links );
		$links = array(
			'home'=> array(
				'priority' => 40,
				'callback' => 'go_home_button',				
			),
			'my_addition_go_checkout'=> array(
				'priority' => 50,
				'callback' => 'go_checkout_now',				
			),
		);
	}
	return $links;

}
function go_checkout_now()
{
	echo '<div class= "bar-btn_c" ><a href="http://localhost/wordpress/index.php/checkout/" style="text-decoration:none; color:white;">提交订单</a></div>';
}

function go_home_button()
{
	echo '<a href="' . esc_url( home_url( '/' ) ) . '">' . __( 'Home' ) . '</a>';
}
function add_to_cart() 
{
	echo '<div class="bar-btn_a"><a href="http://localhost/wordpress/index.php/product/pepe-positive-expiratory-pressure-exerciser/?add-to-cart=89" style="text-decoration:none; color:white;">加入购物车</a></div>';
}
function buy_now() 
{
    //产品ID
    $current_product_id = get_the_ID();
    $product = wc_get_product( $current_product_id );
    //导出到checkout界面
    $checkout_url = WC()->cart->get_checkout_url();
	echo '<div class="bar-btn_b"><a href="'.$checkout_url.'?add-to-cart='.$current_product_id.'" style="text-decoration:none; color:white;">立即购买</a></div>';
}

add_filter( 'storefront_handheld_footer_bar_links', 'remove_footer_cart',899);
add_filter( 'storefront_handheld_footer_bar_links', 'remove_footer_links',900);

//添加自定义 css 添加在最后，以免跑的太快被覆盖
add_action( 'wp_enqueue_scripts', 'prefix_add_my_stylesheet' ,999);
function prefix_add_my_stylesheet() {
    wp_register_style( 'prefix-style','http://localhost/wordpress/wp-content/plugins/headerchanger/my.css');
    wp_enqueue_style( 'prefix-style' );
}


?>