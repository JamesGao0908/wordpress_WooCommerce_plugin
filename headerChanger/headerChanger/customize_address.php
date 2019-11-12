<?php

// 原来checkout的界面 上面是地址 下面是购物车
include 'my_special_functions.php';

defined( 'ABSPATH' ) || exit;

$customer_id = get_current_user_id();

if ( ! wc_ship_to_billing_address_only() && wc_shipping_enabled() ) {
	$get_addresses = apply_filters(
		'woocommerce_my_account_get_addresses',
		array(
			'billing'  => __( 'Billing address', 'woocommerce' ),
			'shipping' => __( 'Shipping address', 'woocommerce' ),
		),
		$customer_id
	);
} else {
	$get_addresses = apply_filters(
		'woocommerce_my_account_get_addresses',
		array(
			'billing' => __( 'Billing address', 'woocommerce' ),
		),
		$customer_id
	);
}

$oldcol = 1;
$col    = 1;
?>

<?php if ( ! wc_ship_to_billing_address_only() && wc_shipping_enabled() ) : ?>
	<div class="u-columns woocommerce-Addresses col2-set addresses">
<?php endif; ?>

<?php foreach ( $get_addresses as $name => $address_title ) : ?>
	<?php
		$address = wc_get_account_formatted_address( $name );
		$col     = $col * -1;
		$oldcol  = $oldcol * -1;
	?>

	<div class="my_addition_special_class">
		
		<div class="my_addition_special_class_1">
			<i class="fas fa-map-marker-alt"></i>
		</div>
	
		<div class="my_addition_special_class_2">
			<header class="woocommerce-Address-title title">
				<h3><?php echo esc_html( $address_title ); ?></h3>
				<!-- 编辑地址 -->
				<a href="<?php echo esc_url( wc_get_endpoint_url( '../my-account/edit-address', $name ) ); ?>" class="edit"><?php echo $address ? esc_html__( 'Edit', 'woocommerce' ) : esc_html__( 'Add', 'woocommerce' ); ?></a>

				<a href="<?php echo esc_url( wc_get_endpoint_url( '../my-account/form-edit-address', $name ) ); ?>" class="edit"><?php echo $address ? esc_html__( 'Edit', 'woocommerce' ) : esc_html__( 'Add', 'woocommerce' ); ?></a>

			</header>
			<address>
				<a href='<?php echo "../adding_address" ?>' class="my_addition_special_class_2_a" style=" text-decoration:none; ">
				<?php 	
						global $woocommerce; 
						$customer = $woocommerce->customer; 

						$address_id = $_GET['user_address_change'];

						global $current_user;
						$user_id = $current_user->ID;

						global $wpdb;			
				        $wpdb->query("SET NAMES 'utf8'");

				        //如果有返回 有登陆， 把返回的信息设置为on
				        //如果没有返回则 取值第一个
				        // echo "user_id :".$user_id."<br>";
				        // echo "address_id :".$address_id."<br>";

				        if(! empty($address_id) )
				        {
				        	$sql_update_set_to_off = "UPDATE `wp_tb_address` SET `trigger` = '0' WHERE `user_id` = $user_id ";
				        	$sql_update_set_to_on  = "UPDATE `wp_tb_address` SET `trigger` = '1' WHERE `wp_tb_address`.`id` = '{$address_id}' AND `user_id` = $user_id";

				        	$wpdb->query($sql_update_set_to_off);
				        	$wpdb->query($sql_update_set_to_on);

				        }
				        else
				        {
				        	$sql_update_set_to_off_default =" UPDATE `wp_tb_address` SET `trigger` = '0' WHERE `user_id` = $user_id ";
				        	$sql_update_set_to_on_default = " UPDATE  `wp_tb_address` SET `trigger` = '1' WHERE user_id = $user_id  ORDER BY id LIMIT 1";
				        	$wpdb->query($sql_update_set_to_off_default);
				        	$wpdb->query($sql_update_set_to_on_default);
				        }

				        $sql1 = "SELECT * FROM `wp_tb_address` WHERE `user_id` = $user_id AND `trigger` = 1";
					    $sql1_result = $wpdb->get_results($sql1);

					    if(!empty($sql1_result))
					    {
					    	foreach($sql1_result as $row)
					    	{
					            $id = $row->id;
					            $user_id = $row->user_id;
					            $name = $row->name;
				                $phone =  $row->phone;
				                $address_line_1 = $row->address_line_1;
								$cname = $row->cname;
								$sname = $row->sname;
				                $post_code = $row->post_code;

				                echo "收件人 : ".$name."    ".$phone."<br>";
					            echo "地址 : 中国 ".$cname." ".$sname." ".$address_line_1." ".$post_code;
				        	}
					    }
					    else
		        		{
		        			echo "无地址, 点击添加地址";
		        		}
				?>
				</a>
			</address>
		</div>
		<div class="my_addition_special_class_3">
			<a href='<?php echo "../adding_address" ?>' ><i class="fas fa-angle-right"></i></a>
		</div>
	</div>

	<div class="my_addition_mini_cart_items">
		<?php 
			woocommerce_mini_cart();
		?>

	</div>
	<div>
	</div>


<?php endforeach; ?>

<?php if ( ! wc_ship_to_billing_address_only() && wc_shipping_enabled() ) : ?>
	</div>
	<?php
endif;
