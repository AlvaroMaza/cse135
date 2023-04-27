<?php
header("Cache-Control: no-cache");
header("Content-type: text/html");

// print HTML file top
echo <<<END
<!DOCTYPE html>
<html>
<head>
  <title>GET Request Echo</title>
</head>
<body>
  <h1 align="center">Get Request Echo</h1>
  <hr>
END;

// The Query String is simply an environment variable
echo "<b>Query String:</b> {$_SERVER['QUERY_STRING']}<br />\n";

// Credit for this code to parse the Query string:
// https://www.mediacollege.com/internet/perl/query-string.html
if (strlen($_SERVER['QUERY_STRING']) > 0) {
  $buffer = $_SERVER['QUERY_STRING'];
  $pairs = explode("&", $buffer);
  foreach ($pairs as $pair) {
    list($name, $value) = explode("=", $pair);
    $value = urldecode($value);
    $in[$name] = $value; 
  }
}

// Print out the Query String
$loop = 0;
foreach ($in as $key => $value) {
  $loop += 1;
  if($loop % 2 != 0) {
    echo "$key = $value<br/>\n";
  }
}

// Print the HTML file bottom
echo "</body></html>";
?>