<?php
// Load the necessary libraries
require_once('CGI/Session.php');

// Set content type to HTML
header('Content-type: text/html');

// Create a new CGI object
$cgi = new CGI();

// Retrieve the session ID from the cookie or query string
$sid = $cgi->cookie('SITE_SID') ?: $cgi->param('sid');

// Create a new CGI session object using the retrieved session ID
$session = new CGI_Session($sid);

// Delete the session
$session->delete();

// Output HTML response
echo '<html>';
echo '<head>';
echo '<title>PHP Session Destroyed</title>';
echo '</head>';
echo '<body>';
echo '<h1>Session Destroyed</h1>';
echo '<a href="/perl-cgiform.html">Back to the Perl CGI Form</a><br />';
echo '<a href="/cgi-bin/perl-sessions-1.pl">Back to Page 1</a><br />';
echo '<a href="/cgi-bin/perl-sessions-2.pl">Back to Page 2</a>';
echo '</body>';
echo '</html>';
?>