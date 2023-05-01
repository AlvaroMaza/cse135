#!/usr/bin/env python

import os
from http.cookies import SimpleCookie

# Load session using the session ID stored in the cookie
if 'PYSESSID' in os.environ['HTTP_COOKIE']:
    session_id = os.environ['HTTP_COOKIE'].split('=')[1]
    os.environ['REQUEST_METHOD'] = 'GET'  # Ensure subsequent requests are GET requests
else:
    session_id = None

# Headers
print("Cache-Control: no-cache")
print("Content-type: text/html\n")

# Body - HTML
print("<html>")
print("<head><title>PY Sessions</title></head>\n")
print("<body>")
print("<h1>PHP Sessions Page 2</h1>")
print("<table>")

# Check if session data is stored
if session_id:
    from http import cookies
    cookie = SimpleCookie()
    cookie['PYSESSID'] = session_id
    cookie['PYSESSID']['path'] = '/'
    cookie['PYSESSID']['expires'] = 3600
    print(cookie.output())
    print("<tr><td>Session Data:</td><td>" + os.environ['HTTP_COOKIE'] + "</td></tr>\n")
elif 'username' in os.environ['QUERY_STRING']:
    name = os.environ['QUERY_STRING'].split('=')[1]
    print(f"Set-Cookie: username={name}; path=/; expires=" + str(time.time()+3600) + "; HttpOnly")
    print("<tr><td>Session Data:</td><td>" + name + "</td></tr>\n")
else:
    print("<tr><td>Session Data:</td><td>None</td></tr>\n")

print("</table>")

# Links for other pages
print("<br />")
print("<a href=\"/cgi-bin/py-sessions-1.py\">Session Page 1</a>")
print("<br />")
print("<a href=\"/py-cgiform.html\">PHP CGI Form</a>")
print("<br /><br />")

# Destroy Session button
print("<form action=\"/cgi-bin/py-destroy-session.py\" method=\"get\">")
print("<button type=\"submit\">Destroy Session</button>")
print("</form>")

print("</body>")
print("</html>")