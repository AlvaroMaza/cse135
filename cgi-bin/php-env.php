<?php
header("Cache-Control: no-cache");
header("Content-type: text/html");

echo <<<END
<!DOCTYPE html>
<html>
<head>
<title>Environment Variables</title>
</head>
<body>
<h1 align="center">Environment Variables</h1>
<hr>
END;

foreach ($_SERVER as $variable => $value) {
  echo "<b>$variable:</b> $value<br />\n";
}

echo "</body></html>";
?>