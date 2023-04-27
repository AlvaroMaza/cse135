<?php

header("Cache-Control: no-cache");
header("Content-type: application/json");

$date = date('Y-m-d H:i:s');
$address = $_SERVER['REMOTE_ADDR'];

$message = array('title' => 'Hello, PHP!', 'heading' => 'Hello, PHP!', 'message' => 'This page was generated with the PHP programming language', 'time' => $date, 'IP' => $address);

$json = json_encode($message);
echo "$json\n";
?>