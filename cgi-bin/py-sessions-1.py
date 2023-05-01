#!/usr/bin/env python

from http import cookies
import os
import time

# Set up session
session_id = str(time.time())
session_data = {}

# Set cookie with session ID
cookie = cookies.SimpleCookie()
cookie['session_id'] = session_id
cookie['session_id']['path'] = '/'
cookie['session_id']['expires'] = 3600

# Store data in session
session_data['username'] = os.environ['username']


# Set response headers
headers = [('Content-type', 'text/html'),
           ('Cache-Control', 'no-cache')]

# Build HTML response
body = '<html><head><title>Python Sessions</title></head>\n'
body += '<body>'
body += '<h1>Python Sessions Page</h1>'
body += '<table>'

# Display stored data
if 'username' in session_data:
    body += '<tr><td>Session Data:</td><td>' + session_data['username'] + '</td></tr>\n'
else:
    body += '<tr><td>Session Data:</td><td>None</td></tr>\n'

body += '</table>'
body += '<br /><a href="/cgi-bin/python-sessions2.py">Session Page 2</a>'
body += '<br /><br /><form action="/cgi-bin/python-destroy-session.py" method="get">'
body += '<button type="submit">Destroy Session</button></form>'
body += '</body></html>'

# Send response with headers and cookie
print(cookie.output())
for header in headers:
    print(header[0] + ': ' + header[1])
print('')
print(body)