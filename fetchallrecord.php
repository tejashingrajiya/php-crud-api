<?php

//header('Content-Type : application/json');	
//header('Access-Control-Allow-Origin : *');
include "connect.php";

$sql = "SELECT * FROM php_basic";
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