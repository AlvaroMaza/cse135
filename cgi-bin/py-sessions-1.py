#!/usr/bin/env python
import os
import http.cookies as Cookie

# Start a new session or load an existing one
name = ''
session_key = 'username'
cookie_string = os.environ.get('HTTP_COOKIE')
if cookie_string:
    session_cookie = Cookie.SimpleCookie()
    session_cookie.load(cookie_string)
    if session_key in session_cookie:
        name = session_cookie[session_key].value

if not name:
    name = ''

# Headers
print("Cache-Control: no-cache")
print("Content-type: text/html\n")

# Set the cookie using a header, add extra \n to end headers
if len(name) > 0:
    session_cookie = Cookie.SimpleCookie()
    session_cookie[session_key] = name
    session_cookie[session_key]['path'] = '/'
    session_cookie[session_key]['expires'] = 3600
    print(session_cookie.output())

# Body - HTML
print("<html>")
print("<head><title>Python Sessions</title></head>")
print("<body>")
print("<h1>Python Sessions Page 1</h1>")
print("<table>")

# First check for new Cookie, then Check for old Cookie
if len(name) > 0:
    print(f"<tr><td>Cookie:</td><td>{name}</td></tr>")
elif cookie_string and session_key in session_cookie:
    print(f"<tr><td>Cookie:</td><td>{session_cookie[session_key].value}</td></tr>")
else:
    print("<tr><td>Cookie:</td><td>None</td></tr>")

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
