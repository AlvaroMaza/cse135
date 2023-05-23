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
const pool = mysql.createConnection({
  port: '/var/run/mysqld/mysqld.sock',
  host: 'localhost',
  user: 'sammy',
  password: 'realmadrid',
  database: 'rest'
});

app.get('/static/', async (req, res) => {
  try {
    // Execute SQL query to fetch data from the 'users' table
    //const connection = await pool.getConnection();
    const [rows] = await connection.execute('SELECT * FROM users');
    connection.release();

    // Send the fetched data as the response
    res.json(rows);
  } catch (error) {
    // Handle error
    console.error('Error:', error);
    res.status(500).send(error);
  }
});

app.post('/static/', async (req, res) => {
  try {
    const { url, timestamp, userAgent, screenDimensions } = req.body;

    if (!url || !timestamp || !userAgent || !screenDimensions) {
      console.log('Request Payload:', req.body);
      return res.status(400).send('Missing information');
    }

    // Execute SQL query
    // const connection = await pool.getConnection();
    const [result] = await connection.execute(
      'INSERT INTO users (url, timestamp, userAgent, screenDimensions) VALUES (?, ?, ?, ?)',
      [url, timestamp, userAgent, JSON.stringify(screenDimensions)]
    );
    connection.release();

    // Send response
    res.status(201).send(`User added with ID: ${result.insertId}`);
  } catch (error) {
    // Handle error
    console.error('Error:', error);
    res.status(500).send(error);
  }
});

// Start server
app.listen(PORT, () => {
  console.log(`Server is running on http://localhost:${PORT}`);
});