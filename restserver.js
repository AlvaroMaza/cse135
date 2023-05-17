const PORT = 3001;

const express = require('express');
const mysql = require('mysql2');
const bodyParser = require('body-parser');
const cors = require('cors');

// Create express app
const app = express();

app.get('/api/', function(req, res){
    res.send("Hello from the root application URL");
});

app.get('/api/test/', function(req, res){
    res.send("Hello from the 'test' URL");
});
// Start server
app.listen(PORT, () => {
    console.log(`Server is running on http://localhost:${PORT}`);
});
