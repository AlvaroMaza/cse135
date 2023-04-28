<?php
// Start PHP Session
session_start();

// Include necessary libraries
require_once('CGI.php');
require_once('CGI/Session.php');

// Create a new PHP Session
$session = new CGI_Session("driver:File", null, array('Directory'=>"/tmp"));

// Create CGI Object
$cgi = new CGI();

// Create a new Cookie from the Session ID
$cookie = $cgi->cookie(array('name'=>'CGISESSID', 'value'=>$session->id));

// Send the Cookie in the HTTP response header
header('Set-Cookie: ' . $cookie->as_string());

//Store Data in the PHP Session
$name = $session->param('username') ?: $cgi->param('username');
$session->param("username", $name);

// Output HTML
echo "<html>";
echo "<head>";
echo "<title>PHP Sessions</title>";
echo "</head>";
echo "<body>";

echo "<h1>PHP Sessions Page 1</h1>";

if ($name){
    echo "<p><b>Name:</b> $name";
}else{
    echo "<p><b>Name:</b> You do not have a name set</p>";
}

echo "<br/><br/>";
echo "<a href=\"/cgi-bin/php-sessions-2.php\">Session Page 2</a><br/>";
echo "<a href=\"/php-cgiform.html\">PHP CGI Form</a><br />";
echo "<form style=\"margin-top:30px\" action=\"/cgi-bin/php-destroy-session.php\" method=\"get\">";
echo "<button type=\"submit\">Destroy Session</button>";
echo "</form>";

echo "</body>";
echo "</html>";
?>