<?php

//header('Content-Type : application/json');	
//header('Access-Control-Allow-Origin : *');

$json = file_get_contents('php://input');
$data = json_decode($json, true);

$sid = $data['id'];

include "connect.php";

$sql = "SELECT * FROM php_basic WHERE id={$sid}";
$result = mysqli_query($conn, $sql);
/* echo "<pre>";
	print_r($result);
	echo "</pre>";
	die; */
if (mysqli_num_rows($result) > 0) {
  
  while($record=mysqli_fetch_assoc($result)){
	  $alldata[]=$record;
	  }
  echo json_encode($alldata);
  
} else {
  echo json_encode(array('msg'=>'no value in jeson', 'status' => false));
}
?>