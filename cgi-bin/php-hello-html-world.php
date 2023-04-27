<?php
header("Cache-Control: no-cache");
header("Content-type: text/html");

echo "<html>";
echo "<head>";
echo "<title>Hello, Perl!</title>";
echo "</head>";
echo "<body>";

echo "<marquee>Wow!</marquee>";
echo "<h1 align=\"center\">cse135Spain was here - Hello, Perl!</h1>";
echo "<hr>";
echo "<p>This page was generated with the PHP programming language</p>";

$date = date('Y-m-d H:i:s');
echo "<p>Current Time: $date</p>";

// IP Address is an environment variable when using CGI
$address = $_SERVER['REMOTE_ADDR'];
echo "<p>Your IP Address: $address</p>";

echo "</body>";
echo "</html>";
?>