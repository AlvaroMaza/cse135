<?php
// Headers
header("Cache-Control: no-cache");
header("Content-type: text/html");

// Retrieve session ID from cookie
session_id($_COOKIE['PHPSESSID']);

// Start the session
session_start();

// Body - HTML
echo "<html>";
echo "<head><title>PHP Sessions Page 2</title></head>\n";
echo "<body>";
echo "<h1>PHP Sessions Page 2</h1>";
echo "<table>";

// Display the stored data
if (isset($_SESSION['data'])) {
    echo "<tr><td>Session Data:</td><td>" . $_SESSION['data'] . "</td></tr>\n";
} else {
    echo "<tr><td>Session Data:</td><td>None</td></tr>\n";
}

echo "</table>";

// Links for other pages
echo "<br />";
echo "<a href=\"/cgi-bin/php-sessions1.php\">Session Page 1</a>";
echo "<br />";
echo "<a href=\"/php-cgiform.html\">PHP CGI Form</a>";
echo "<br /><br />";

echo "</body>";
echo "</html>";
?>