<?php
header("Cache-Control: no-cache");
header("Content-type: text/html");

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

// The Query String is available in the $_SERVER superglobal variable
$queryString = $_SERVER["QUERY_STRING"];
parse_str($queryString, $queryArray);

foreach ($queryArray as $key => $value) {
  echo "$key = $value<br/>\n";
}

echo "</body></html>";
?>