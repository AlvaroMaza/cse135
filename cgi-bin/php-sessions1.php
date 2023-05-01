<?php
// Start session and get session ID
session_start();
$id = session_id();

// Headers
header("Cache-Control: no-cache");

// Get Name from Environment
if(isset($_POST['username'])) {
    $name = $_POST['username'];
    $_SESSION['username'] = $name;
}

// Set the cookie using a header, add extra \n to end headers
if (isset($name)) {
    header("Content-type: text/html");
    header("Set-Cookie: username=$name; path=/; expires=" . time()+3600 . "; HttpOnly\n");
} else {
    header("Content-type: text/html\n");
}

// Body - HTML
echo "<html>";
echo "<head><title>PHP Sessions</title></head>\n";
echo "<body>";
echo "<h1>PHP Sessions Page 1</h1>";
echo "<table>";

// Check if session data is stored
if (isset($_SESSION['username'])) {
    echo "<tr><td>Session Data:</td><td>" . $_SESSION['username'] . "</td></tr>\n";
} else {
    echo "<tr><td>Session Data:</td><td>None</td></tr>\n";
}


echo "</table>";

// Links for other pages
echo "<br />";
echo "<a href=\"/cgi-bin/php-sessions2.php\">Session Page 2</a>";
echo "<br />";
echo "<a href=\"/php-state-demo.html\">PHP CGI Form</a>";
echo "<br /><br />";

// Destroy Session button
echo "<form action=\"/cgi-bin/php-destroy-session.php\" method=\"get\">";
echo "<button type=\"submit\">Destroy Session</button>";
echo "</form>";

echo "</body>";
echo "</html>";

// Save session ID in a cookie
setcookie('PHPSESSID', $id, time()+3600, '/');
?>