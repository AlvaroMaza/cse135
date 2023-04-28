<?php
// Headers
header("Cache-Control: no-cache");
header("Content-type: text/html");

// Body - HTML
echo "<html>";
echo "<head><title>C Sessions</title></head>\n";
echo "<body>";
echo "<h1>C Sessions Page 2</h1>";
echo "<table>";

if (isset($_COOKIE['CGISESSID']) && $_COOKIE['CGISESSID'] !== "destroyed") {
    echo "<tr><td>Cookie:</td><td>" . $_COOKIE['CGISESSID'] . "</td></tr>\n";
} else {
    echo "<tr><td>Cookie:</td><td>None</td></tr>\n";
}

echo "</table>";

// Links for other pages
echo "<br />";
echo "<a href=\"/cgi-bin/c-sessions-1.cgi\">Session Page 1</a>";
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