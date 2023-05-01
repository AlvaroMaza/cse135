#!/usr/bin/env python

from http import cookies
import os
import time
import cgi

# Get session ID from cookie
cookie = cookies.SimpleCookie(os.environ.get('HTTP_COOKIE'))
session_id = cookie.get('session_id').value if cookie.get('session_id') else None

# Load session data
if session_id:
    session_file = os.path.join(os.environ['DOCUMENT_ROOT'], 'sessions', session_id)
    if os.path.exists(session_file):
        with open(session_file, 'r') as f:
            session_data = eval(f.read())
    else:
        session_data = {}
else:
    session_data = {}

# Set response headers
headers = [('Content-type', 'text/html'),
           ('Cache-Control', 'no-cache')]

# Build HTML response
body = '<html><head><title>Python Sessions 2</title></head>\n'
body += '<body>'
body += '<h1>Python Sessions Page 2</h1>'
body += '<table>'

# Display stored data
if 'username' in session_data:
    body += '<tr><td>Session Data:</td><td>' + session_data['username'] + '</td></tr>\n'
else:
    body += '<tr><td>Session Data:</td><td>None</td></tr>\n'

body += '</table>'

body += "<br /><a href=\"/cgi-bin/py-sessions-1.py\">Session Page 1</a>"
body += "<br /><a href=\"/py-cgiform.html\">PY CGI Form</a>"
body +="</body>"
body +="</html>"

# Send response with headers and cookie
print(cookie.output())
for header in headers:
    print(header[0] + ': ' + header[1])
print('')
print(body)