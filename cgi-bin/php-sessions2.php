<?php
// Load session using the session ID stored in the cookie
if(isset($_COOKIE['PHPSESSID'])) {
    session_start();
    session_id($_COOKIE['PHPSESSID']);
}

// Headers
header("Cache-Control: no-cache");
header("Content-type: text/html");

// Body - HTML
echo "<html>";
echo "<head><title>PHP Sessions</title></head>\n";
echo "<body>";
echo "<h1>PHP Sessions Page 2</h1>";
echo "<table>";

// Check if session data is stored
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

// Destroy Session button
echo "<form action=\"/cgi-bin/php-destroy-session.php\" method=\"get\">";
echo "<button type=\"submit\">Destroy Session</button>";
echo "</form>";

echo "</body>";
echo "</html>";
?>