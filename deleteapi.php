<?php
//header('Content-Type : application/json');	
//header('Access-Control-Allow-Origin : *');

$json = file_get_contents('php://input');
$data = json_decode($json, true);

$sid = $data['id'];

include "connect.php";

$sql = "DELETE FROM `php_basic` WHERE id=('$sid')";
$result = mysqli_query($conn, $sql);
/* echo "<pre>";
	print_r($result);
	echo "</pre>";
	die; */
if (mysqli_query($conn, $sql)) {
		echo json_encode(array('msg'=>'value deleted json', 'status' => true));
		} else {
		echo json_encode(array('msg'=>'no value deleted json', 'status' => false));
	}
?>