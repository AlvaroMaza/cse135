#!/usr/bin/env python

from http import cookies
import os
import time
import cgi

# Set up session
session_id = str(time.time())
session_data = {}

# Set cookie with session ID
cookie = cookies.SimpleCookie()
cookie['session_id'] = session_id
cookie['session_id']['path'] = '/'
cookie['session_id']['expires'] = 3600


# Store data in session
form = cgi.FieldStorage()
username = form.getvalue("username")

if username is not None:
    # Store username in session data
    session_data['username'] = username
    cookie['username'] = username
    session_user_id = cookie['username'].value

else:
    cookie_string = os.environ.get('HTTP_COOKIE')
    if cookie_string is not None:
        cookie = cookies.SimpleCookie()
        cookie.load(cookie_string)
        session_user_id = cookie['username'].value

# Set response headers
headers = [('Content-type', 'text/html'),
           ('Cache-Control', 'no-cache')]

# Build HTML response
body = '<html><head><title>Python Sessions</title></head>\n'
body += '<body>'
body += '<h1>Python Sessions Page</h1>'
body += '<table>'

# Display stored data
body += '<tr><td>Session Data:</td><td>' + session_user_id + '</td></tr>\n'

body += '</table>'

body += "<br /><a href=\"/cgi-bin/py-sessions-2.py\">Session Page 2</a>"
body += "<br /><a href=\"/py-state-demo.html\">Python CGI Form</a>"
body +="<br /><br />"
body += "<form action=\"/cgi-bin/py-destroy-session.py\" method=\"get\">"
body +="<button type=\"submit\">Destroy Session</button>"
body += "</form>"
body +="</body>"
body +="</html>"


# Send response with headers and cookie
print(cookie.output())
for header in headers:
    print(header[0] + ': ' + header[1])
print('')
print(body)