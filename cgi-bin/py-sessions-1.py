#!/usr/bin/env python

import cgi
import cgitb
import os
import hashlib
from http import cookies
from cgi import escape
from cgi import parse_qs, escape
from uuid import uuid4

# Enable error reporting for debugging purposes
cgitb.enable()

# Create a session ID
session_id = str(uuid4())

# Get the form data
form = cgi.FieldStorage()

# Get the username from the form data
username = form.getvalue('username')

# Store the username in the session
session = cgi.FieldStorage()
session['username'] = username

# Set a session cookie with the session ID
session_cookie = cookies.SimpleCookie()
session_cookie['session_id'] = session_id
session_cookie['session_id']['expires'] = 30 * 24 * 60 * 60  # 30 days
session_cookie['session_id']['path'] = '/'
session_cookie['session_id']['httponly'] = True
print(session_cookie.output())

# Headers
print("Cache-Control: no-cache")
print("Content-type: text/html\n")

# Body - HTML
print("<html>")
print("<head><title>Python Sessions</title></head>")
print("<body>")
print("<h1>Python Sessions Page 1</h1>")
print("<table>")

# First check for new Cookie, then Check for old Cookie
if len(username) > 0:
    print(f"<tr><td>Cookie:</td><td>{username}</td></tr>")
elif session_cookie and session_id in session_cookie:
    print(f"<tr><td>Cookie:</td><td>{session_cookie.output()}</td></tr>")
else:
    print("<tr><td>Cookie:</td><td>Unknown</td></tr>")

print("</table>")

# Links for other pages
print("<br />")
print("<a href=\"/cgi-bin/python-sessions-2.py\">Session Page 2</a>")
print("<br />")
print("<a href=\"/python-cgiform.html\">Python CGI Form</a>")
print("<br /><br />")

# Destroy Cookie button
print("<form action=\"/cgi-bin/python-destroy-session.py\" method=\"get\">")
print("<button type=\"submit\">Destroy Session</button>")
print("</form>")

print("</body>")
print("</html>")
