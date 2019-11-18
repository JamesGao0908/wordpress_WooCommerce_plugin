<?php

// 原来checkout的界面 上面是地址 下面是购物车
include 'my_special_functions.php';
// include 'headerChanger.php';


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

<?php 
//checkout page on mobile
$detect = new Mobile_Detect(); 
if($detect->isMobile())
{
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
				global $wpdb;
			    global $current_user;

			    $user_id = $current_user->ID;

				$wpdb->query("SET NAMES 'utf8'");

				if( isset($_GET['user_address_change']))
				{
					$sql_update_set_to_off = "UPDATE `wp_tb_address` SET `trigger` = '0' WHERE `user_id` = $user_id ";
					$sql_update_set_to_on  = "UPDATE `wp_tb_address` SET `trigger` = '1' WHERE `wp_tb_address`.`id` = '{$_GET['user_address_change']}' AND `user_id` = $user_id";

					$wpdb->query($sql_update_set_to_off);
					$wpdb->query($sql_update_set_to_on);
				}
				if( ! empty($woocommerce->customer->get_shipping_first_name()) ||
					! empty($woocommerce->customer->get_billing_phone()) ||
					! empty($woocommerce->customer->get_billing_country())	||
					! empty($woocommerce->customer->get_billing_state()) ||
					! empty($woocommerce->customer->get_billing_city()) ||
					! empty($woocommerce->customer->get_billing_address_1()) ||
					! empty($woocommerce->customer->get_billing_postcode())
				)
				{	
					echo $woocommerce->customer->get_shipping_first_name( )."   ";
			    	echo $woocommerce->customer->get_billing_phone(  )."<br>";
			    
			    	echo translate_country_from_Eng_to_Zh($woocommerce->customer->get_billing_country( ))."  ";
			    	echo translate_state_from_Eng_to_Zh($woocommerce->customer->get_billing_state())."   ";
			    	echo $woocommerce->customer->get_billing_city( )."   ";
			    	echo $woocommerce->customer->get_billing_address_1( )."  ";
			  		echo $woocommerce->customer->get_billing_postcode( );
				}
				else
				{
					echo "无有效地址";
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
<?php 
}
//checkout page on pc
else
{
	echo "<div class='address_box'>";
		echo "<div class='address_box_header header-wrapper'>";
			echo "<h2 class='header-title' >确认收货地址<a href='../adding_address' class='header-operation'>管理收货地址</a></h2>";
		echo "</div>";
		echo "<div class='address_box_body address-list'>";
			global $current_user;
			global $wpdb;

			// $sql_result_1 = $wpdb->get_results("SELECT COUNT(*) FROM  `wp_tb_address` WHERE user_id = {$current_user->ID}  AND `trigger` = 1");

			$sql_result = $wpdb->get_results("SELECT * FROM `wp_tb_address` WHERE `user_id` = {$current_user->ID} ");
			
			if( ! empty($sql_result))
			{
				foreach($sql_result as $row)
				{
					$id = $row->id;
		            $user_id = $row->user_id;
		            $name = $row->name;
		            $phone =  $row->phone;
		            $address_line_1 = $row->address_line_1;
		            $cname = $row->cname;
		            $sname = $row->sname;
		            $pname = $row->pname;
		            $post_code = $row->post_code;
		            $trigger = $row->trigger;

		            if($trigger == 1)
		            {

						echo "<div style='
						border-color: rgb(255, 68, 0);
						background-color: rgb(255, 240, 232);
						box-shadow: rgb(243, 243, 243) 5px 5px 0px' 
    					class='addr-item-wrapper OneRow addr-default' id='div_address_box_".$id."'>";
						?>
						<div style="display: inline-block;" class="selected-description" id=<?php echo "div_address_box_labor_".$id; ?> ><i class="fas fa-map-marker-alt"></i><span class="marker-tip"> 寄送至</span></div>
						<input id=<?php echo $id;?> role="radio" tabindex="0" type="radio" class="next-radio-input" checked="true">
						<?php

			            echo "<span>".$cname." ".$sname." ".$pname." ".$row->address_line_1." (".$name." 收) ".$phone."</span>";
			            echo "</div>";
		            }
		            else
		            {
						echo "<div class='addr-item-wrapper OneRow addr-default' id='div_address_box_".$id."'>";
						?>
						<div class="selected-description" id=<?php echo "div_address_box_labor_".$id; ?> ><i class="fas fa-map-marker-alt"></i><span class="marker-tip"> 寄送至</span></div>
						<input id=<?php echo $id;?> role="radio" tabindex="0" type="radio" class="next-radio-input">
						<?php

			            echo "<span>".$cname." ".$sname." ".$pname." ".$row->address_line_1." (".$name." 收) ".$phone."</span>";
			            echo "</div>";
		        	}
				}	
			}
			else
			{
				echo "<h1>无地址，添加地址</h1>";
			}

		echo "</div>";
		echo "<div class='operations'><button type='button' class='next-btn next-medium next-btn-normal operation OneRow' >使用新地址</button></div>";
	echo "</div>";
	echo "<div class='items_box'>";
		echo "<h2 class='header_title'>确认订单信息</h2>";
		echo "<table class='items_box_table' >";
			echo "<thead>";
				echo "<tr>";
					echo "<th>店铺宝贝</th>";
					echo "<th>名称</th>";
					echo "<th>单价</th>";
					echo "<th>数量</th>";
					echo "<th>小计</th>";
				echo "</tr>";
			echo "</thead>";

			echo "<tbody>";
				global $woocommerce;
				$items = $woocommerce->cart->get_cart();
				foreach($items as $item => $values) 
				{
					echo "<tr>"; 
					$_product =  wc_get_product( $values['data']->get_id()); 
					$_price = get_post_meta($values['product_id'] , '_price', true);
					$_getProductDetail = wc_get_product( $values['product_id'] );//product image
					$_total = (float)$_price * (float)$values['quantity'];

					echo "<th style='background-color:#FBFCFF;'>".$_getProductDetail->get_image()."</th>";
					echo "<th style='background-color:#FBFCFF;'>".$_product->get_title()."</th>";
					echo "<th style='background-color:#FBFCFF;'>".wp_kses_post($_price)."</th>";
					echo "<th style='background-color:#FBFCFF;'>".$values['quantity']."</th>";
					echo "<th style='background-color:#FBFCFF;'>".wp_kses_post($_total)."</th>";
					echo "</tr>";	
				}
				echo "<tr>";
					echo "<td style='background-color:#F2F7FF' colspan='3'></td>";
					echo "<td style='background-color:#F2F7FF' ><a>小计 : </a></td>";
					echo "<td style='background-color:#F2F7FF' >".wp_kses_post(WC()->cart->get_cart_subtotal())."</td>";
				echo "</tr>";

				echo "<tr>";
					echo "<td style='background-color:#F2F7FF' colspan='2'></td>";
					echo "<td style='background-color:#F2F7FF' >"."<a>运费 : </a>"."</td>";

					echo "<td style='background-color:#F2F7FF'>";
					echo "<div class='dropdown'>";
	  					echo "<button class='dropbtn'>选择运送方式</button>";
	  					echo "<div class='dropdown-content'>";
							echo "<a href='#''>Link 1</a>";

						echo "</div>";
					echo "</div>";

					echo "</td>";

					echo "<td style='background-color:#F2F7FF' >"."</td>";
				echo "</tr>";

			echo "</tbody>";
		echo "</table>";
	echo "</div>";
	echo "<div class='deliver_box' >";

		echo "<div class='box__wrapper'>";
			echo "<div class='box__shadow'>";
				    global $woocommerce;
				   	echo "<div>实付款 : ".woocommerce_checkout_mypart()."</div>";
				   	echo "<div><span> 寄送至 : ".translate_country_from_Eng_to_Zh($woocommerce->customer->get_billing_country())." ".translate_state_from_Eng_to_Zh($woocommerce->customer->get_billing_state())." ".$woocommerce->customer->get_billing_city()." ".$woocommerce->customer->get_billing_address_1()."</span><br>";
				   	echo "<span> 收货人 : ".$woocommerce->customer->get_billing_first_name()."  ".$woocommerce->customer->get_billing_phone()."</span><br></div>";
			echo "</div>";
		echo "</div>";

		echo "<div class='submitOrderPC_1'>";
			echo "<a href='../cart' class='goback_button'>返回购物车</a>";
			echo "<a class='final_submit_button_my_addition'>提交订单</a>";

		echo "</div>";
	echo "</div>";
}

?>


<?php endforeach; ?>

<?php if ( ! wc_ship_to_billing_address_only() && wc_shipping_enabled() ) : ?>
	</div>
	<?php
endif;
