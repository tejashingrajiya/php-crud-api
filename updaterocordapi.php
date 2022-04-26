<?php
	
	/* header('Content-Type : application/json');	
	header('Access-Control-Allow-Origin : *');
	header('Access-Control-Allow-Method :POST');
	header('Access-Control-Allow-Header : Access-Control-Allow-Header,Content-Type, Access-Control-Allow-Method, Authorization, X-Requested-With'); */
	
	
	$json = file_get_contents('php://input');
	$data = json_decode($json, true);
	
	$id = $data['id'];
	$name = $data['name'];
	$email = $data['email'];
	
	include "connect.php";
	
	$sql = "UPDATE `php_basic` SET `name`='$name',`email`='$email' WHERE id='$id'";
	/* echo "<pre>";
		print_r($result);
		echo "</pre>";
	die; */
	if (mysqli_query($conn, $sql)) {
		echo json_encode(array('msg'=>'value updated json', 'status' => true));
		} else {
		echo json_encode(array('msg'=>'no value updated json', 'status' => false));
	}
?>