#!/usr/bin/python

import os
from http.cookies import SimpleCookie
from cgi import FieldStorage
from html import escape
import cgi
import cgitb

cgitb.enable()

print("Content-type: text/html\n")

cookie = SimpleCookie(os.environ.get("HTTP_COOKIE"))
sid = cookie.get("SITE_SID").value if cookie.get("SITE_SID") else None

session = cgi.Session(
    session_options={
        'id': sid,
        'cookie_only': True,
        'directory': '/tmp'
    }
)

session.delete()

print("<html>")
print("<head>")
print("<title>Python Session Destroyed</title>")
print("</head>")
print("<body>")
print("<h1>Session Destroyed</h1>")
print("<a href=\"/py-state-demo.html\">Back to the Python CGI Form</a><br />")
print("<a href=\"/cgi-bin/py-sessions-1.py\">Back to Page 1</a><br />")
print("<a href=\"/cgi-bin/py-sessions-2.py\">Back to Page 2</a>")
print("</body>")
print("</html>")
