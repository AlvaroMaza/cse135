#!/usr/bin/env python
import os
import http.cookies

# Start session and get session ID
session_id = os.environ.get("HTTP_COOKIE")
if not session_id:
    session_id = str(hash(os.urandom(16)))
    print(f"Set-Cookie: PHPSESSID={session_id}; path=/; HttpOnly")

# Headers
print("Cache-Control: no-cache")

# Get Name from Environment
if "username" in os.environ.get("QUERY_STRING", ""):
    name = os.environ["QUERY_STRING"].split("=")[1]
    os.environ["HTTP_COOKIE"] = f"username={name}; {os.environ.get('HTTP_COOKIE', '')}"
    cookie = http.cookies.SimpleCookie(os.environ["HTTP_COOKIE"])
    name = cookie.get("username").value

# Set the cookie using a header, add extra \n to end headers
if "username" in os.environ.get("HTTP_COOKIE", ""):
    print("Content-type: text/html")
    print(f"Set-Cookie: username={name}; path=/; expires={session_id}; HttpOnly\n")
else:
    print("Content-type: text/html\n")

# Body - HTML
print("<html>")
print("<head><title>Python Sessions</title></head>")
print("<body>")
print("<h1>Python Sessions Page 1</h1>")
print("<table>")

# First check for new Cookie, then Check for old Cookie
if "username" in os.environ.get("HTTP_COOKIE", ""):
    cookie = http.cookies.SimpleCookie(os.environ["HTTP_COOKIE"])
    name = cookie.get("username").value
    print(f"<tr><td>Cookie:</td><td>{name}</td></tr>")
elif "username" in os.environ.get("HTTP_COOKIE", ""):
    print(f"<tr><td>Cookie:</td><td>{os.environ['HTTP_COOKIE']}</td></tr>")
else:
    print("<tr><td>Cookie:</td><td>None</td></tr>")

print("</table>")

# Links for other pages
print("<br />")
print("<a href=\"/cgi-bin/py-sessions-2.py\">Session Page 2</a>")
print("<br />")
print("<a href=\"/python-cgiform.html\">Python CGI Form</a>")
print("<br /><br />")

# Destroy Cookie button
print("<form action=\"/cgi-bin/python-destroy-session.py\" method=\"get\">")
print("<button type=\"submit\">Destroy Session</button>")
print("</form>")

print("</body>")
print("</html>")
