<?php
// Start the session
session_start();

// Unset all session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Unset the cookie
setcookie('username', '', time() - 3600, '/');

// Output HTML response
echo '<html>';
echo '<head>';
echo '<title>PHP Session Destroyed</title>';
echo '</head>';
echo '<body>';
echo '<h1>Session Destroyed</h1>';
echo '<a href="/php-cgiform.php">Back to the PHP CGI Form</a><br />';
echo '<a href="/cgi-bin/php-sessions-1.php">Back to Page 1</a><br />';
echo '<a href="/cgi-bin/php-sessions-2.php">Back to Page 2</a>';
echo '</body>';
echo '</html>';
?>