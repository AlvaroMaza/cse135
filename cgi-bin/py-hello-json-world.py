#!/usr/bin/env python

import datetime
import json
import os

print("Cache-Control: no-cache")
print("Content-type: application/json\n")

date = datetime.datetime.now().strftime('%c')
address = os.environ.get("REMOTE_ADDR")

message = {'title': 'Hello, Python!', 'heading': 'Hello, Python!', 'message': 'This page was generated with the Python programming language', 'time': date, 'IP': address}

json_output = json.dumps(message)
print(json_output)
