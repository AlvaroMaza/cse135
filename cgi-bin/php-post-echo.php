<?php
header("Cache-Control: no-cache");
header("Content-type: text/html");

echo <<< END
<!DOCTYPE html>
<html>
<head>
	<title>Environment Variables</title>
</head>
<body>
	<h1 align="center">Environment Variables</h1>
	<hr>
END;

// Loop over the environment variables and print each variable and its value
foreach ($_SERVER as $key => $value) {
  echo "<b>$key:</b> $value<br />\n";
}

echo <<< END
</body>
</html>
END;
?>