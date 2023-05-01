#!/usr/bin/env python

from http import cookies

# Set up cookie
cookie = cookies.SimpleCookie()
cookie['session_id'] = ''
cookie['session_id']['path'] = '/'
cookie['session_id']['expires'] = 0

# Set response headers
headers = [('Content-type', 'text/html'),           ('Cache-Control', 'no-cache')]

# Build HTML response
body = '<html><head><title>Python Sessions - Session Destroyed</title></head>\n'
body += '<body>'
body += '<h1>Session Destroyed</h1>'
body += "<br /><a href=\"/cgi-bin/py-sessions-1.py\">Session Page 1</a>"
body += "<br /><a href=\"/cgi-bin/py-sessions-2.py\">Session Page 2</a>"
body += "<br /><a href=\"/py-state-demo.html\">PY CGI Form</a>"
body +="</body>"
body +="</html>"

# Send response with headers and cookie
print(cookie.output())
for header in headers:
    print(header[0] + ': ' + header[1])
print('')
print(body)