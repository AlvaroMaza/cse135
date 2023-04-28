<?php
// Headers
header("Cache-Control: no-cache");
header("Content-type: text/html");

// Get session ID from the cookie
if(isset($_COOKIE['PHPSESSID'])) {
    session_id($_COOKIE['PHPSESSID']);
}

// Start or resume session
session_start();

// Get stored session data
if(isset($_SESSION['data'])) {
    $data = $_SESSION['data'];
} else {
    $data = "No data found in session.";
}

// Body - HTML
echo "<html>";
echo "<head><title>PHP Sessions Page 2</title></head>\n";
echo "<body>";
echo "<h1>PHP Sessions Page 2</h1>";
echo "<p>Session Data: $data</p>";

// Links for other pages
echo "<br />";
echo "<a href=\"/cgi-bin/php-sessions1.php\">Session Page 1</a>";
echo "<br />";
echo "<a href=\"/php-cgiform.html\">PHP CGI Form</a>";
echo "<br /><br />";

// Destroy session button
echo "<form action=\"/cgi-bin/php-destroy-session.php\" method=\"get\">";
echo "<button type=\"submit\">Destroy Session</button>";
echo "</form>";

echo "</body>";
echo "</html>";
?>