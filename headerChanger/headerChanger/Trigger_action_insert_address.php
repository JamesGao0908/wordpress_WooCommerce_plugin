<?php 
	// 插入资料
	$address_line_one 	= $_POST["address-line1"];
	$name 				= $_POST["full-name"];
	$phone 				= $_POST["phone"];
	$postal_code		= $_POST["postal-code"];
	$cname 				= $_POST["cname"];
	$sname 				= $_POST["sname"];
	$pname				= $_POST["pname"];

	// echo "name : ".$name."<br>";
	// echo "address_line_one : ".$address_line_one."<br>";	
	// echo "postal_code : ".$postal_code."<br>";
	// echo "phone : ".$phone."<br>";

	
	global $current_user;
	$user_insert_id  = $current_user->ID;

	global $wpdb;
	$wpdb->insert("wp_tb_address", array(
				   "user_id" => $user_insert_id,
				   "name" => $name,
				   "phone" => $phone,
				   "cname" => $cname,
				   "sname" => $sname,
				   "pname" => $pname,
 				   "address_line_1" => $address_line_one,
				   "post_code" => $postal_code,
				   "trigger"=>'0',
	));

	echo "<h1>上传中。。。。</h1>";

	echo "<script>window.location = 'adding_address'</script>";


?>
