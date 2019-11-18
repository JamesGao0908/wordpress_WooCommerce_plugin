<?php
include 'Mobile_Detect.php';
include 'my_special_functions.php';

/*
	Plugin Name: 淘宝修改插件
	Plugin URI:
	Description: 这个插件会修改woocommerce的产品页面，移除其脚部的文件，重新加入三个按键，分别为'店铺'，'立即购买'，'加入购物车'。
    Author: 高志强
	Version: 1.0.0
	Author URI: http://310club.com
*/

if (! defined('ABSPATH')) {
    die();
}

add_action('init','DB_build');
function DB_build()
{   
    wc_get_template('../../headerChanger/DB_created.php');
}

add_action( 'storefront_footer' , 'my_footer' , 30);
function my_footer()
{
}

// 更新送货地址
// add_action( 'woocommerce_checkout_update_order_meta', 'my_addition_fun_change_shipping_address', 10, 1 );
function my_addition_fun_change_shipping_address($order_id)
{
    global $wpdb;
    global $current_user;
    $user_id = $current_user->ID;
    
    $sql = "SELECT * FROM `wp_tb_address` WHERE `trigger`=1 AND `user_id`= $user_id";
    $result = $wpdb->get_results($sql);

    if( !empty($result))
    {
        update_post_meta( $order_id, '_billing_first_name', sanitize_text_field( $result[0]->name ) );
        update_post_meta( $order_id, '_billing_last_name', sanitize_text_field( "" ) );
        update_post_meta( $order_id, '_billing_address_1', sanitize_text_field($result[0]->pname."  ".$result[0]->address_line_1 ) );
        update_post_meta( $order_id, '_billing_city', sanitize_text_field( $result[0]->sname ) );
        update_post_meta( $order_id, '_billing_state', sanitize_text_field( $result[0]->cname ) );
        update_post_meta( $order_id, '_billing_postcode', sanitize_text_field( $result[0]->post_code ) );
        update_post_meta( $order_id, '_billing_email', sanitize_text_field( "NULL" ) );
        update_post_meta( $order_id, '_billing_phone', sanitize_text_field( $result[0]->phone ) );

        update_post_meta( $order_id, '_shipping_first_name', sanitize_text_field( $result[0]->name ) );
        update_post_meta( $order_id, '_shipping_last_name', sanitize_text_field( "" ) );
        update_post_meta( $order_id, '_shipping_address_1', sanitize_text_field($result[0]->pname."  ".$result[0]->address_line_1 ) );
        update_post_meta( $order_id, '_shipping_city', sanitize_text_field( $result[0]->sname ) );
        update_post_meta( $order_id, '_shipping_state', sanitize_text_field( $result[0]->cname ) );
        update_post_meta( $order_id, '_shipping_postcode', sanitize_text_field( $result[0]->post_code ) );
        update_post_meta( $order_id, '_shipping_email', sanitize_text_field( "NULL" ) );
        update_post_meta( $order_id, '_shipping_phone', sanitize_text_field( $result[0]->phone ) );
    }
}

//change last_name as a non-reqire option
add_filter( 'woocommerce_default_address_fields', 'modify_woocommerce_default_address_fields', 100, 1 );
function modify_woocommerce_default_address_fields( $fields ) 
{
    $fields['last_name']['required'] = false;
    return $fields;
}

//Ajax adding address into woocommerce_setting_address on mobile and pc platform
add_action("wp_ajax_my_action_update_address", "my_action_update_address");
function my_action_update_address()
{
    $update_address_info['address_id']=$_POST['address_id'];
    global $woocommerce;
    global $wpdb;
    global $current_user;

    $wpdb->query("SET NAMES 'utf8'");
    $sql = "SELECT * FROM `wp_tb_address` WHERE id =".$_POST['address_id'];
    $result = $wpdb->get_results($sql);

    $update_address_info['result'] = $wpdb->get_results($sql); 

    if( !empty($result))
    {   
        //set it
        $woocommerce->customer->set_billing_first_name( $result[0]->name );
        $woocommerce->customer->set_billing_last_name( "  " );
        $woocommerce->customer->set_billing_address_1(  $result[0]->pname."  ".$result[0]->address_line_1 );
        $woocommerce->customer->set_billing_address_2( " " );
        $woocommerce->customer->set_billing_city( $result[0]->sname );
        $woocommerce->customer->set_billing_state( translate_state_from_Zh_to_Eng($result[0]->cname) );
        $woocommerce->customer->set_billing_postcode( $result[0]->post_code );
        $woocommerce->customer->set_billing_country( "CN" );
        $woocommerce->customer->set_billing_phone( $result[0]->phone );

        $woocommerce->customer->set_shipping_first_name( $result[0]->name );
        $woocommerce->customer->set_shipping_last_name( " " );
        $woocommerce->customer->set_shipping_address_1( $result[0]->pname."  ".$result[0]->address_line_1 );
        $woocommerce->customer->set_shipping_address_2( " " );
        $woocommerce->customer->set_shipping_city( $result[0]->sname );
        $woocommerce->customer->set_shipping_state( translate_state_from_Zh_to_Eng($result[0]->cname) ); 
        $woocommerce->customer->set_shipping_postcode( $result[0]->post_code );
        $woocommerce->customer->set_shipping_country( "CN" );
        
        $wpdb->query("UPDATE `wp_tb_address` SET `trigger` = 0 WHERE `user_id`=".$current_user->ID);
        $wpdb->query("UPDATE `wp_tb_address` SET `trigger` = 1 WHERE `id` =".$_POST['address_id']);

        $update_address_info['custom']="success";
    }
    else
    {
        $update_address_info['custom']="fail";
    }

    $update_address_info = json_encode($update_address_info);
    
    echo $update_address_info;
    
    die(); 
}

//此处是添加自定义Ajax
//cid->sid->pid
//输入cid 输出sid
add_action("wp_ajax_my_action_adding_address", 'my_adding_address_editing');
// add_action("wp_ajax_nopriv_my_action_adding_address", 'my_adding_address_editing');
function my_adding_address_editing()
{
    $response['cid'] = $_POST['cid'];

    global $wpdb;
    $wpdb->query("SET NAMES 'utf8'");        
    
    $sql = "SELECT * FROM `wp_tb_district` WHERE id =".$response['cid'];
    $result = $wpdb->get_results($sql);
    $response['cname'] = $result[0]->name.$result[0]->suffix;


    $sql_require_city = "SELECT * FROM `wp_tb_district` WHERE parent_id =". $response['cid'];
    $require_city = $wpdb->get_results($sql_require_city);

    $response['result'] = $require_city;

    $response = json_encode($response);  
    
    echo $response;

    die();
}
//输入sid 得出qid
add_action("wp_ajax_my_action_adding_address_sid", 'my_adding_address_editing_sid');
// add_action("wp_ajax_nopriv_my_action_adding_address_sid", 'my_adding_address_editing_sid');
function my_adding_address_editing_sid()
{   
    $state_info['sid'] =$_POST['sid'];

    global $wpdb;
    $wpdb->query("SET NAMES 'utf8'"); 

    $sql = "SELECT * FROM `wp_tb_district` WHERE id =".$state_info['sid'];
    $result = $wpdb->get_results($sql);
    $state_info['sname'] = $result[0]->name.$result[0]->suffix;


    $sql_require_city="SELECT * FROM `wp_tb_district` WHERE parent_id=".$state_info['sid'];

    $state_info['result'] = $wpdb->get_results($sql_require_city);

    if(count($state_info['result']) == 0)
    {
        //显示详细资料页
        $state_info['continue'] = 0;
    }
    else
    {
        //继续寻找下级别地区
        $state_info['continue'] = 1;   
    }

    $state_info = json_encode($state_info);
    echo $state_info;
    
    die();
}
//输入qid 获取具体地址
add_action("wp_ajax_my_action_adding_address_pid", 'my_adding_address_editing_pid');
// add_action("wp_ajax_nopriv_my_action_adding_address_pid", 'my_adding_address_editing_pid');
function my_adding_address_editing_pid()
{   
    $subs_info['pid'] = $_POST['pid'];

    global $wpdb;
    $wpdb->query("SET NAMES 'utf8'"); 
    $sql = "SELECT * FROM `wp_tb_district` WHERE id =".$subs_info['pid'];
    $result = $wpdb->get_results($sql);
    $subs_info['pname'] = $result[0]->name.$result[0]->suffix;

    $subs_info = json_encode($subs_info);
    echo $subs_info;

    $state_info['sname'] = $state_info['sname']." ".$subs_info['pname'];
    die();
}

// 新增page用来编辑用户的地址。
add_filter( 'the_content', 'my_fun_4' , 0);
function my_fun_4( $content ) 
{
    // address_list_for_picking_right_deliever_address website => index.php/adding_address 
    if ( is_adding_address() ) 
    {
        wc_get_template('../../headerChanger/customize_is_adding_address.php');
    }
    // adding new address 
    elseif( is_page('editing_address') )
    {
        wc_get_template('../../headerChanger/customize_editing_address.php');
    }
    elseif (is_page('action_insert_address')) 
    {
        wc_get_template('../../headerChanger/Trigger_action_insert_address.php');
    }
    elseif (is_page('delete')) 
    {
        wc_get_template('../../headerChanger/Trigger_action_delete_address.php');
    }
    return $content;
}

// 基本原理是 checkout 基本都不给显示了，然后调取自己写的一块内容，把收货地址写在头部就行
// 网址是index.php/checkout
add_action('woocommerce_before_checkout_form','my_fun_1');
function my_fun_1()
{
    wc_get_template('../../headerChanger/customize_address.php');		
}

//移除并且自定义购物车界面的脚部--手机屏幕
add_filter( 'storefront_handheld_footer_bar_links', 'remove_footer_cart' , 899);
function remove_footer_cart( $links )
{
	if( is_cart())
	{
		unset( $links );
		$links = array(
			'home'=> array(
				'priority' => 40,
				'callback' => 'go_home_button',				
			),
			'my_addition_total_amount_cart_total_amount'=> array(
				'priority' => 50,
				'callback' => 'cart_total_amount',				
			),
			'my_addition_go_checkout'=> array(
				'priority' => 60,
				'callback' => 'cart_go_checkout_now',				
			),
		);
	}
    elseif(is_checkout() )
    {
        unset( $links );
        $links = array(
            'home'=> array(
                'priority' => 40,
                'callback' => 'go_home_button',             
            ),
            'my_addition_total_amount_checkout_total_amount'=> array(
                'priority' => 50,
                'callback' => 'checkout_total_amount',               
            ),
            'my_addition_go_checkout'=> array(
                'priority' => 60,
                'callback' => 'checkout_go_checkout_now',               
            ),
        );
    }
    elseif(is_product() )
	{
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
    elseif(is_adding_address())
	{
		$links = array(
			'my_addition_adding_address'=> array(
				'priority' => 10,
				'callback' => 'editing_adding_new_address',	
			)
		);
		
	}
    elseif(is_page('editing_address')) 
    {
        $links = array(
            'my_addition_editing_address'=> array(
                'priority' => 10,
                'callback' => 'editing_new_address', 
            )
        );
    }
	return $links;
}

//handheld bar 底部的按钮
function editing_new_address()
{
    // echo "<a style='color:white;' href='#'>提交地址</a>";
    echo "<button type='submit' form='form1' value='提交地址'>提交地址</button>";
}

//handheld bar 底部的按钮
function editing_adding_new_address()
{
    echo "<a style='color:white;' href='../editing_address' class='adding_new_editing_address'>新增地址</a>";
}



//在cart手机界面，底部的中间位置添加一个合计的ajax，
function cart_total_amount( )
{
	global $woocommerce;
	?>
		<div id="cart_container">
			<span >合计 :</span>
			<a class="my_Ajax-cart-contents"></a>
		</div>
	<?php
}
add_filter( 'woocommerce_add_to_cart_fragments', 'my_Ajax', 999 );
function my_Ajax($fragments)
{
  global $woocommerce;
  ob_start();
  my_addition_ajax_cart_total();
  $fragments['a.my_Ajax-cart-contents'] = ob_get_clean();
  return $fragments;
}
function my_addition_ajax_cart_total()
{
  	?>
  	<a class="my_Ajax-cart-contents" href="<?php echo esc_url( wc_get_cart_url())?>" title="<?php esc_attr_e( 'View your shopping cart', 'storefront' ); ?>">
	<?php 
    echo wp_kses_post(WC()->cart->get_total()); 
    // echo wp_kses_post(WC()->cart->get_cart_shipping_total());
    ?>
	</a>
	<?php 
}

//在结账画面ajax显示总金额
add_filter('woocommerce_update_order_review_fragments', 'price_bottom_checkout',999);
function price_bottom_checkout($arr)
{
    ob_start();
    woocommerce_checkout_mypart();
    $arr['.woocommerce-checkout-review-my-part'] = ob_get_clean();
    return $arr;
}
function woocommerce_checkout_mypart()
{
    echo "<a class='woocommerce-checkout-review-my-part' >".wp_kses_post(WC()->cart->get_total())."</a>";
}
function checkout_total_amount()
{
    echo "<div id='cart_container'>";
    echo "<span>合计 : </span>";
    echo "<a class='woocommerce-checkout-review-my-part'></a>";
    echo "</div>";
}

//Insert our address into $checkout->shipping_address
function checkout_go_checkout_now()
{
	echo '<a class= "bar-btn_c go_end_payment" style="text-decoration:none; color:white; text-indent:0px;">下单</a>';
}

function cart_go_checkout_now()
{
    echo '<a class= "bar-btn_c" href="checkout" style="text-decoration:none; color:white; text-indent:0px;">提交订单</a>';
}

function go_home_button()
{
	echo '<a href="' . esc_url( home_url( '/' ) ) . '">' . '</a>';
}

function add_to_cart() 
{ 
	$current_product_id = get_the_ID();
	?>
		<a class ="bar-btn_a" href="<?php echo '?add-to-cart='.$current_product_id;?>" style="color:white; text-indent:0px">加入购物车</a>
	<?php
}

function buy_now() 
{
    //产品ID
    $current_product_id = get_the_ID();
    $product = wc_get_product( $current_product_id );
    //导出到checkout界面
    $checkout_url = WC()->cart->get_checkout_url();
	echo '<a class="bar-btn_b" href="'.$checkout_url.'?add-to-cart='.$current_product_id.'" style="text-indent:0px; text-decoration:none; color:white;">立即购买</a>';
}


//移除手机上小屏幕在商店界面的Add in cart按钮
add_action('woocommerce_after_shop_loop_item','my_addition_remove_button',1);
function my_addition_remove_button()
{
	$detect = new Mobile_Detect();
    if (is_shop() && $detect->isMobile()) {
        remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart');
        remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 20);
    }
}

// 如果是手机，修改商店的缩略图的大小
add_filter('storefront_woocommerce_args','my_addition_mobile_shop');
function my_addition_mobile_shop($var)
{
    $detect_1 = new Mobile_Detect();
    if ($detect_1->isMobile())
    {
    	$var['single_image_width'] = 1300;
    	$var['thumbnail_image_width'] = 1300;
    }
    return $var;
}

//add on customize Js
add_action( 'wp_enqueue_scripts', 'my_enqueue' );
function my_enqueue() {    
    $detect_1 = new Mobile_Detect();
    if ($detect_1->isMobile())
    {
        wp_enqueue_script( 'ajax-script', get_template_directory_uri() . '../../../plugins/headerChanger/js/my_js_mobile.js', array('jquery') );
        wp_localize_script( 'ajax-script', 'my_ajax_object',
            array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
    }
    else
    {
        wp_enqueue_script( 'ajax-script', get_template_directory_uri() . '../../../plugins/headerChanger/js/my_js_pc.js', array('jquery') );
        wp_localize_script( 'ajax-script', 'my_ajax_object',
            array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
    }
}


//add on customize css
add_action( 'wp_enqueue_scripts', 'add_theme_scripts', 900);
function add_theme_scripts() {
    wp_register_style( 'prefix-style', get_template_directory_uri() . '../../../plugins/headerChanger/css/my.css');
    wp_enqueue_style( 'prefix-style' );
    // wp_enqueue_script( 'script', get_template_directory_uri() . '../../../plugins/headerChanger/js/my-js.js', array ( 'jquery' ), 1.1, true);
    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) )
    {
      wp_enqueue_script( 'comment-reply' );
    }

    $detect = new Mobile_Detect();
    if($detect->isMobile())
    {
    	if(is_shop())
    	{
       		wp_register_style( 'prefix-style_1', get_template_directory_uri() . '../../../plugins/headerChanger/css/my_addition_mobile_shop.css');
        	wp_enqueue_style( 'prefix-style_1' );
    	}
    	elseif (is_cart()) 
    	{
    		wp_register_style( 'prefix-style_2', get_template_directory_uri() . '../../../plugins/headerChanger/css/my_addition_mobile_cart.css');
    		wp_enqueue_style( 'prefix-style_2' );
    	}
    	elseif (is_front_page()) 
        {
    		wp_register_style( 'prefix-style_3', get_template_directory_uri() . '../../../plugins/headerChanger/css/my_addition_home.css');
    		wp_enqueue_style( 'prefix-style_3' );
    	}
    	elseif (is_checkout() ) 
        {
			if(is_user_logged_in())
    		{
    			// 用户必须登录才能选择地址
    			wp_register_style( 'prefix-style_4', get_template_directory_uri() . '../../../plugins/headerChanger/css/my_addition_mobile_checkout_login.css');
    			wp_enqueue_style( 'prefix-style_4' );

                wp_enqueue_script( 'script', get_template_directory_uri() . '../../../plugins/headerChanger/js/my_js_mobile_checkout.js', array ( 'jquery' ), 1.1, true);
    		}
    		else
    		{
    			// 用户要是没有登录 force他登录 
                echo "请先登录";
    			wp_register_style( 'prefix-style_5', get_template_directory_uri() . '../../../plugins/headerChanger/css/my_addition_mobile_checkout_unlogin.css');
    			wp_enqueue_style( 'prefix-style_5' );
    		}
    	}
    	elseif(is_adding_address())
    	{
    		wp_register_style( 'prefix-style_6', get_template_directory_uri() . '../../../plugins/headerChanger/css/my_addition_mobile_adding_address.css');
    		wp_enqueue_style( 'prefix-style_6' );
    	}
        elseif ( is_page('editing_address')) {
            wp_register_style( 'prefix-style_7', get_template_directory_uri() . '../../../plugins/headerChanger/css/my_addition_mobile_editing_address.css');
            wp_enqueue_style( 'prefix-style_7' );
        }
    }
    else
    {
        if(is_checkout())
        {
            wp_register_style( 'prefix-style_8', get_template_directory_uri() . '../../../plugins/headerChanger/css/my_addition_pc_checkout_login.css');
            wp_enqueue_style( 'prefix-style_8' );

            wp_enqueue_script( 'script', get_template_directory_uri() . '../../../plugins/headerChanger/js/my_js_pc_checkout.js', array ( 'jquery' ), 1.1, true);
        }
        elseif(is_page('editing_address'))
        {
            wp_register_style( 'prefix-style_9', get_template_directory_uri() . '../../../plugins/headerChanger/css/my_addition_pc_editing_address.css');
            wp_enqueue_style( 'prefix-style_9' );
        }
        elseif(is_adding_address())
        {
            wp_register_style( 'prefix-style_10', get_template_directory_uri() . '../../../plugins/headerChanger/css/my_addition_pc_adding_address.css');
            wp_enqueue_style( 'prefix-style_10' );
        }

    }
}

?>