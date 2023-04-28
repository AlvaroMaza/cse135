<?php
// Start the session and retrieve session ID from cookie
session_start();
$session_id = session_id();

// Display the stored data
if (isset($_SESSION['data'])) {
    echo "Session data: " . $_SESSION['data'];
} else {
    echo "No session data found.";
}

// Store new data in the session
$_SESSION['data'] = "Some data to store in the session.";

// Display links to other pages
echo "<br />";
echo "<a href=\"/php-sessions1.php\">Session Page 1</a>";
echo "<br />";
echo "<a href=\"/php-cgiform.html\">PHP CGI Form</a>";
echo "<br /><br />";

// Destroy session button
echo "<form action=\"/php-destroy-session.php\" method=\"get\">";
echo "<button type=\"submit\">Destroy Session</button>";
echo "</form>";

echo "</body>";
echo "</html>";
?>