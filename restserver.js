const PORT = 3001;
const express = require('express');
const mysql = require('mysql');
const bodyParser = require('body-parser');
const cors = require('cors');

// Create express app
const app = express();
app.use(express.json());

// Better set up CORS properly or not depending on security posture
app.use(cors({
  origin: '*'
}));

// Create connection pool to MySQL database
const connection = mysql.createConnection({
  port: '/var/run/mysqld/mysqld.sock',
  host: 'localhost',
  user: 'sammy',
  password: 'realmadrid',
  database: 'rest'
});

// Retrieve every entry logged in the static table
app.get('/static/', async (req, res) => {
  connection.connect()

  connection.query('SELECT 1 + 1 AS solution', (err, rows, fields) => {
    if (err) throw err
  
    console.log('The solution is: ', rows[0].solution)
  })
  
  connection.end()
});

// Start server
app.listen(PORT, () => {
  console.log(`Server is running on http://localhost:${PORT}`);
});