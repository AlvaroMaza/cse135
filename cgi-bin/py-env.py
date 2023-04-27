#!/usr/bin/env python

import os

print("Cache-Control: no-cache")
print("Content-type: text/html\n")

# print HTML file top
print("""
<!DOCTYPE html>
<html>
<head>
<title>Environment Variables</title>
</head>
<body>
<h1 align="center">Environment Variables</h1>
<hr>
""")

# Loop over the environment variables and print each variable and its value
for variable, value in sorted(os.environ.items()):
    print(f"<b>{variable}:</b> {value}<br />\n")

# Print the HTML file bottom
print("</body></html>")
