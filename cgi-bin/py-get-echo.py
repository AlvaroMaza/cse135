#!/usr/bin/env python

import os
import urllib.parse

print("Cache-Control: no-cache")
print("Content-type: text/html\n")

# print HTML file top
print("""
<!DOCTYPE html>
<html>
<head>
<title>GET Request Echo</title>
</head>
<body>
<h1 align="center">Get Request Echo</h1>
<hr>
""")

# The Query String is simply an environment variable
query_string = os.environ.get("QUERY_STRING")
print(f"<b>Query String:</b> {query_string}<br />\n")

# Parse the Query String into a dictionary
query_dict = {}
if query_string:
    query_list = query_string.split("&")
    for query_item in query_list:
        name, value = query_item.split("=")
        value = urllib.parse.unquote_plus(value)
        query_dict[name] = value

# Print out the Query String
loop = 0
for key, value in query_dict.items():
    loop += 1
    if loop % 2 != 0:
        print(f"{key} = {value}<br/>\n")

# Print the HTML file bottom
print("</body></html>")
