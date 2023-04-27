#!/usr/bin/env python
import cgi

print("Cache-Control: no-cache")
print("Content-type: text/html \n")

# print HTML file top
print("""
<!DOCTYPE html>
<html>
<head>
<title>POST Request Echo</title>
</head>
<body>
<h1 align="center">POST Request Echo</h1>
<hr>
""")

form = cgi.FieldStorage()
post_data = {}
for key in form.keys():
    post_data[key] = form.getvalue(key)

print("<b>Message Body:</b><br />\n")
print("<ul>\n")

# Print out the POST data
for key in post_data:
    print(f"<li>{key} = {post_data[key]}</li>\n")

print("</ul>\n")

# Print the HTML file bottom
print("</body></html>\n")
