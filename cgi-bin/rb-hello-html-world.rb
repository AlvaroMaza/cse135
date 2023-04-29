#!/usr/bin/env ruby

require 'date'
require 'cgi'

cgi = CGI.new

puts "Cache-Control: no-cache"
puts "Content-type: text/html\n"

puts "<html>"
puts "<head>"
puts "<title>Hello, Ruby!</title>"
puts "</head>"
puts "<body>"

puts "<marquee>Wow!</marquee>"
puts "<h1 align=\"center\">cse135Spain was here - Hello, Ruby!</h1>"
puts "<hr>"
puts "<p>This page was generated with the Ruby programming language</p>"

now = DateTime.now
puts "<p>Current Time: #{now}</p>"

# IP Address is an environment variable when using CGI
address = cgi.remote_addr
puts "<p>Your IP Address: #{address}</p>"

puts "</body>"
puts "</html>"
