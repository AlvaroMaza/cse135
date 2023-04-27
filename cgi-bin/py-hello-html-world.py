#!/usr/bin/env python

import datetime
import os

print("Cache-Control: no-cache")
print("Content-type: text/html\n")

print("<html>")
print("<head>")
print("<title>Hello, Python!</title>")
print("</head>")
print("<body>")

print("<marquee>Wow!</marquee>")
print("<h1 align=\"center\">cse135Spain was here - Hello, Python!</h1>")
print("<hr>")
print("<p>This page was generated with the Python programming language</p>")

now = datetime.datetime.now()
print(f"<p>Current Time: {now}</p>")

# IP Address is an environment variable when using CGI
address = os.environ.get("REMOTE_ADDR")
print(f"<p>Your IP Address: {address}</p>")

print("</body>")
print("</html>")
