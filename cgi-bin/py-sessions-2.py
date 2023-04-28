#!/usr/bin/env python
import os
import cgi
import http.cookies
from html import escape
from session import Session

# Create a new CGI Object
cgi = cgi.FieldStorage()

# Get the Session ID from the Cookie
cookie = http.cookies.SimpleCookie(os.environ.get('HTTP_COOKIE'))
sid = cookie.get('CGISESSID')
session = Session(sid=sid, inc=0, driver="File", prefix="py_sess_", directory="/tmp")

# Access Stored Data
name = session.get("username", "")

print("Content-Type: text/html\n")

print("<html>")
print("<head>")
print("<title>Python Sessions</title>")
print("</head>")
print("<body>")

print("<h1>Python Sessions Page 2</h1>")

if name:
    print("<p><b>Name:</b> %s</p>" % escape(name))
else:
    print("<p><b>Name:</b> You do not have a name set</p>")
print("<br/><br/>")
print("<a href=\"/cgi-bin/py-sessions-1.py\">Session Page 1</a><br/>")
print("<a href=\"/py-state-demo.html\">Python CGI Form</a><br />")
print("<form style=\"margin-top:30px\" action=\"/cgi-bin/py-destroy-session.py\" method=\"get\">")
print("<button type=\"submit\">Destroy Session</button>")
print("</form>")

print("</body>")
print("</html>")
