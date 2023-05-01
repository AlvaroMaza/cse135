#!/usr/bin/env python

from http.cookies import SimpleCookie
import os

# Start session and get session ID
from uuid import uuid4

session_id = str(uuid4())

# Get Name from Environment
name = None
if 'username' in os.environ:
    name = os.environ['username']

# Set the cookie
cookie = SimpleCookie()
if name:
    cookie['username'] = name
    cookie['username']['path'] = '/'
    cookie['username']['expires'] = 3600
    cookie['username']['httponly'] = True

# Headers
print("Cache-Control: no-cache")
if name:
    print("Content-type: text/html")
    print(cookie.output(header=''))
else:
    print("Content-type: text/html\n")

# Body - HTML
print("<html>")
print("<head><title>Python Sessions</title></head>")
print("<body>")
print("<h1>Python Sessions Page 1</h1>")
print("<table>")

# First check for new Cookie, then Check for old Cookie
if name:
    print("<tr><td>Cookie:</td><td>{}</td></tr>".format(name))
elif 'HTTP_COOKIE' in os.environ:
    cookie.load(os.environ['HTTP_COOKIE'])
    if 'username' in cookie:
        print("<tr><td>Cookie:</td><td>{}</td></tr>".format(cookie['username'].value))
else:
    print("<tr><td>Cookie:</td><td>None</td></tr>")

print("</table>")

# Links for other pages
print("<br />")
print("<a href=\"/cgi-bin/py-sessions-2.py\">Session Page 2</a>")
print("<br />")
print("<a href=\"/py-cgiform.py\">Python CGI Form</a>")
print("<br /><br />")

# Destroy Cookie button
print("<form action=\"/cgi-bin/py-destroy-session.py\" method=\"get\">")
print("<button type=\"submit\">Destroy Session</button>")
print("</form>")

print("</body>")
print("</html>")

# Save session ID in a cookie
cookie = SimpleCookie()
cookie['PYSESSID'] = session_id
cookie['PYSESSID']['path'] = '/'
cookie['PYSESSID']['expires'] = 3600