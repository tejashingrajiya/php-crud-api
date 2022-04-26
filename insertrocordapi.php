<?php
	
	/* header('Content-Type : application/json');	
	header('Access-Control-Allow-Origin : *');
	header('Access-Control-Allow-Method :POST');
	header('Access-Control-Allow-Header : Access-Control-Allow-Header,Content-Type, Access-Control-Allow-Method, Authorization, X-Requested-With'); */
	
	
	$json = file_get_contents('php://input');
	$data = json_decode($json, true);
	
	$name = $data['name'];
	$email = $data['email'];
	
	include "connect.php";
	
	$sql = "INSERT INTO `php_basic`(`name`, `email`) VALUES ('$name','$email')";
	/* echo "<pre>";
		print_r($result);
		echo "</pre>";
	die; */
	if (mysqli_query($conn, $sql)) {
		echo json_encode(array('msg'=>'value inserted jeson', 'status' => true));
		} else {
		echo json_encode(array('msg'=>'no value inserted jeson', 'status' => false));
	}
?>