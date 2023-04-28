#!/usr/bin/env python

import os
import cgi
import http.cookies
from cgi import escape
from cgi.session import Session

# Create a new Python Session
session = Session(inc=0, driver="File", prefix="py_sess_", directory="/tmp")

# Create a CGI Object
cgi = cgi.FieldStorage()

# Create a new Cookie from the Session ID
cookie = http.cookies.SimpleCookie()
cookie['CGISESSID'] = session.id
print("Set-Cookie:", cookie.output())

#Store Data in that Python Session
name = session.get('username') or cgi.getvalue('username', '')
session.set('username', name)

print("Content-Type: text/html\n")

print("<html>")
print("<head>")
print("<title>Python Sessions</title>")
print("</head>")
print("<body>")

print("<h1>Python Sessions Page 1</h1>")

if name:
    print("<p><b>Name:</b> %s</p>" % escape(name))
else:
    print("<p><b>Name:</b> You do not have a name set</p>")
print("<br/><br/>")
print("<a href=\"/cgi-bin/py-sessions-2.py\">Session Page 2</a><br/>")
print("<a href=\"/py-state-demo.html\">Python CGI Form</a><br />")
print("<form style=\"margin-top:30px\" action=\"/cgi-bin/py-destroy-session.py\" method=\"get\">")
print("<button type=\"submit\">Destroy Session</button>")
print("</form>")

print("</body>")
print("</html>")
