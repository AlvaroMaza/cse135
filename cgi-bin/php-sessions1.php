<?php
// Headers
header("Cache-Control: no-cache");

// Get Name from Environment
$stdin = fopen("php://stdin", "r");
$username = fgets($stdin, 1000);
fclose($stdin);

// Check to see if a proper name was sent
$name = "";
if (strpos($username, "username=") !== false) {
    $name = substr($username, 9);
}

// Set the cookie using a header, add extra \n to end headers
if (strlen($name) > 0) {
    header("Content-type: text/html");
    header("Set-Cookie: $name\n");
} else {
    header("Content-type: text/html\n");
}

// Body - HTML
echo "<html>";
echo "<head><title>PHP Sessions</title></head>\n";
echo "<body>";
echo "<h1>PHP Sessions Page 1</h1>";
echo "<table>";

// First check for new Cookie, then Check for old Cookie
if (strlen($name) > 0) {
    echo "<tr><td>Cookie:</td><td>$name</td></tr>\n";
} else if (isset($_COOKIE['PHPSESSID'])) {
    echo "<tr><td>Cookie:</td><td>" . $_COOKIE['PHPSESSID'] . "</td></tr>\n";
} else {
    echo "<tr><td>Cookie:</td><td>None</td></tr>\n";
}

echo "</table>";

// Links for other pages
echo "<br />";
echo "<a href=\"/php-sessions2.php\">Session Page 2</a>";
echo "<br />";
echo "<a href=\"/php-cgiform.html\">PHP CGI Form</a>";
echo "<br /><br />";

// Destroy Cookie button
echo "<form action=\"/php-destroy-session.php\" method=\"get\">";
echo "<button type=\"submit\">Destroy Session</button>";
echo "</form>";

echo "</body>";
echo "</html>";
?>