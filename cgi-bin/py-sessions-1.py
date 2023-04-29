#!/usr/bin/env python

import os

# Headers
print("Cache-Control: no-cache")
print("Content-type: text/html")

# Get Name from Environment
username = os.environ.get("QUERY_STRING")
name = ""
if username and username.startswith("u="):
    name = username[2:]

# Set the cookie using a header, add extra \n to end headers
if len(name) > 0:
    print(f"Set-Cookie: {name}")
    print()
else:
    print()

# Body - HTML
print("<html>")
print("<head><title>Python Sessions</title></head>")
print("<body>")
print("<h1>Python Sessions Page 1</h1>")
print("<table>")

# First check for new Cookie, then Check for old Cookie
if len(name) > 0:
    print(f"<tr><td>Cookie:</td><td>{name}</td></tr>")
elif "HTTP_COOKIE" in os.environ and os.environ["HTTP_COOKIE"] != "destroyed":
    print(f"<tr><td>Cookie:</td><td>{os.environ['HTTP_COOKIE']}</td></tr>")
else:
    print("<tr><td>Cookie:</td><td>None</td></tr>")

print("</table>")

# Links for other pages
print("<br />")
print("<a href=\"/cgi-bin/py-sessions-2.py\">Session Page 2</a>")
print("<br />")
print("<a href=\"/py-state-demo.html\">Python CGI Form</a>")
print("<br /><br />")

# Destroy Cookie button
print("<form action=\"/cgi-bin/py-destroy-session.py\" method=\"get\">")
print("<button type=\"submit\">Destroy Session</button>")
print("</form>")

print("</body>")
print("</html>")

