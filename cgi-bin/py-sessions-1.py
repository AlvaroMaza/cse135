from flask import Flask, request, make_response
from flask_session import Session
from html import escape

app = Flask(__name__)
app.config['SESSION_TYPE'] = 'filesystem'
app.config['SESSION_FILE_DIR'] = '/tmp'
app.config['SESSION_COOKIE_NAME'] = 'CGISESSID'
Session(app)

@app.route('/')
def index():
    session = Session()
    name = session.get('username') or request.args.get('username', '')
    session['username'] = name

    resp = make_response('')
    resp.set_cookie('CGISESSID', session.sid)
    resp.headers['Content-Type'] = 'text/html'
    resp.data += '<html><head><title>Python Sessions</title></head><body>'
    resp.data += '<h1>Python Sessions Page 1</h1>'

    if name:
        resp.data += '<p><b>Name:</b> %s</p>' % escape(name)
    else:
        resp.data += '<p><b>Name:</b> You do not have a name set</p>'

    resp.data += '<br/><br/><a href="/cgi-bin/py-sessions-2.py">Session Page 2</a><br/>'
    resp.data += '<a href="/py-state-demo.html">Python CGI Form</a><br />'
    resp.data += '<form style="margin-top:30px" action="/cgi-bin/py-destroy-session.py" method="get">'
    resp.data += '<button type="submit">Destroy Session</button>'
    resp.data += '</form></body></html>'

    return resp

if __name__ == '__main__':
    app.run(debug=True)
