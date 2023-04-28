<?php
// Headers
header("Cache-Control: no-cache");

// Get Name from Environment
$username = fgets(STDIN);

// Check to see if a proper name was sent
$name = "";
if ($username[0] == 'u')
{
  $name = substr($username, 9);
}

// Set the cookie using a header, add extra \n to end headers
if (strlen($name) > 0)
{
  header("Content-type: text/html");
  setcookie("CSID", $name);
}
else
{
  header("Content-type: text/html");
}

// Body - HTML
echo "<html>";
echo "<head><title>C Sessions</title></head>";
echo "<body>";
echo "<h1>C Sessions Page 1</h1>";
echo "<table>";

// First check for new Cookie, then Check for old Cookie
if (strlen($name) > 0)
{
  echo "<tr><td>Cookie:</td><td>$name</td></tr>";
}
elseif (isset($_COOKIE["CSID"]) && $_COOKIE["CSID"] !== "destroyed")
{
  echo "<tr><td>Cookie:</td><td>" . $_COOKIE["CSID"] . "</td></tr>";
}
else
{
  echo "<tr><td>Cookie:</td><td>None</td></tr>";
}

echo "</table>";

// Links for other pages
echo "<br />";
echo "<a href=\"/cgi-bin/c-sessions-2.cgi\">Session Page 2</a>";
echo "<br />";
echo "<a href=\"/c-cgiform.html\">C CGI Form</a>";
echo "<br /><br />";

// Destroy Cookie button
echo "<form action=\"/cgi-bin/c-destroy-session.cgi\" method=\"get\">";
echo "<button type=\"submit\">Destroy Session</button>";
echo "</form>";

echo "</body>";
echo "</html>";
?>