<?php
	if(isset($_GET['del']))
	{
		$address_id = $_GET['del'];

		global $wpdb;
		$table_name = 'wp_tb_address';

        $sql = "SELECT * FROM $table_name WHERE `id`= $address_id AND `trigger`= 1 ";
        $result_on_triggered_check = $wpdb->get_results($sql);
		
        // 如果要删除的是current送货地址
        if( ! empty($result_on_triggered_check))
        {
            global $woocommerce;
            $woocommerce->customer->set_billing_first_name( "" );
            $woocommerce->customer->set_billing_last_name( "" );
            $woocommerce->customer->set_billing_address_1( "" );
            $woocommerce->customer->set_billing_address_2( "" );
            $woocommerce->customer->set_billing_city( "" );
            $woocommerce->customer->set_billing_state( "" );
            $woocommerce->customer->set_billing_postcode( "" );
            $woocommerce->customer->set_billing_country( "" );
            $woocommerce->customer->set_billing_phone( "" );

            $woocommerce->customer->set_shipping_first_name( "" );
            $woocommerce->customer->set_shipping_last_name( "" );
            $woocommerce->customer->set_shipping_address_1( "" );
            $woocommerce->customer->set_shipping_address_2( "" );
            $woocommerce->customer->set_shipping_city( "" );
            $woocommerce->customer->set_shipping_state( "" ); 
            $woocommerce->customer->set_shipping_postcode( "");
            $woocommerce->customer->set_shipping_country( "" );

        }

        $results = $wpdb->get_results( " DELETE FROM $table_name WHERE  `id` = $address_id  ");

		
	}
	else
	{
		echo "无效删除";
	}



	echo "<script>window.location = 'adding_address'</script>";

?>