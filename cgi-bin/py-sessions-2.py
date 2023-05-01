#!/usr/bin/env python

from http import cookies
import os
import time
import cgi

# Retrieve session ID from cookie
cookie_string = os.environ.get('HTTP_COOKIE')
if cookie_string is not None:
    cookie = cookies.SimpleCookie()
    cookie.load(cookie_string)
    session_id = cookie.get('session_id').value
else:
    # Handle case where session ID cookie is missing
    session_id = None

# Load session
if session_id is not None:
    session_file = 'session_data/' + session_id + '.txt'
    try:
        with open(session_file, 'r') as f:
            session_data = eval(f.read())
    except FileNotFoundError:
        # Handle case where session file is missing
        session_data = {}
else:
    session_data = {}

# Set response headers
headers = [('Content-type', 'text/html'),
           ('Cache-Control', 'no-cache')]

# Build HTML response
body = '<html><head><title>Python Sessions Page 2</title></head>\n'
body += '<body>'
body += '<h1>Python Sessions Page 2</h1>'
body += '<table>'

# Display stored data
if 'username' in session_data:
    body += '<tr><td>Session Data:</td><td>' + session_data['username'] + '</td></tr>\n'
else:
    body += '<tr><td>Session Data:</td><td>None</td></tr>\n'

body += '</table>'

body += "<br /><a href=\"/cgi-bin/py-sessions.py\">Session Page 1</a>"
body += "<br /><a href=\"/py-state-demo.html\">Python CGI Form</a>"
body +="</body>"
body +="</html>"

print('Status: 200 OK')
for header in headers:
    print(f'{header[0]}: {header[1]}')
if session_id is not None:
    print(cookie.output())
print()
print(body)
