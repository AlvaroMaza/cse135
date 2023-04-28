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
foreach ($in as $key => $value) {
  echo "$key = $value<br/>\n";
}

// Print the HTML file bottom
echo "</body></html>";
?>