<?php
header("Cache-Control: no-cache");
header("Content-type: text/html");
// print HTML file top
echo <<<END
<!DOCTYPE html>
<html><head><title>POST Request Echo</title>
</head><body><h1 align="center">POST Request Echo</h1>
<hr>
END;

// read in post data
$form_data = file_get_contents('php://input');

// parse the post data
parse_str($form_data, $in);

echo "<b>Message Body:</b><br />\n";
echo "<ul>\n";

// print out the post data
$loop = 0;
foreach ($in as $key => $value) {
  $loop += 1;
  if ($loop % 2 != 0) {
    echo "<li>$key = $value</li>\n";
  }
}

echo "</ul>\n";
// Print the HTML file bottom
echo "</body></html>\n";
?>