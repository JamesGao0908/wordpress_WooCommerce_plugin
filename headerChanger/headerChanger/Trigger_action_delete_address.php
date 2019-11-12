<?php
	if(isset($_GET['del']))
	{
		$address_id = $_GET['del'];

		global $wpdb;
		$table_name = 'wp_tb_address';
		$results = $wpdb->get_results( " DELETE FROM $table_name WHERE  `id` = $address_id  ");
		
	}
	else
	{
		echo "无效删除";
	}

	echo "<script>window.location = 'adding_address'</script>";

?>