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
const pool = mysql.createPool({
  port: '/var/run/mysqld/mysqld.sock',
  host: 'localhost',
  user: 'sammy',
  password: 'realmadrid',
  database: 'rest'
});

// Retrieve every entry logged in the static table
app.get('/static/', async (req, res) => {
  try {
    const connection = await pool.getConnection();
    const [rows] = await connection.execute('SELECT * FROM static');
    connection.release();
    res.json(rows);
  } catch (error) {
    console.error('Error:', error);
    res.status(500).send(error);
  }
});

// Retrieve a specific entry logged in the static table (that matches the given id)
app.get('/static/:id', async (req, res) => {
  try {
    const connection = await pool.getConnection();
    const [rows] = await connection.execute('SELECT * FROM static WHERE id = ?', [req.params.id]);
    connection.release();
    if (rows.length === 0) {
      return res.status(404).send('Entry not found');
    }
    res.json(rows[0]);
  } catch (error) {
    console.error('Error:', error);
    res.status(500).send(error);
  }
});

// Add a new entry to the static table
app.post('/static/', async (req, res) => {
  try {
    const { url, timestamp, userAgent, screenDimensions } = req.body;
    if (!url || !timestamp || !userAgent || !screenDimensions) {
      console.log('Request Payload:', req.body);
      return res.status(400).send('Missing information');
    }
    const connection = await pool.getConnection();
    const [result] = await connection.execute(
      'INSERT INTO static (url, timestamp, userAgent, screenDimensions) VALUES (?, ?, ?, ?)',
      [url, timestamp, userAgent, JSON.stringify(screenDimensions)]
    );
    connection.release();
    res.status(201).send(`Entry added with ID: ${result.insertId}`);
  } catch (error) {
    console.error('Error:', error);
    res.status(500).send(error);
  }
});

// Delete a specific entry from the static table (that matches the given id)
app.delete('/static/:id', async (req, res) => {
  try {
    const connection = await pool.getConnection();
    const [result] = await connection.execute('DELETE FROM static WHERE id = ?', [req.params.id]);
    connection.release();
    if (result.affectedRows === 0) {
      return res.status(404).send('Entry not found');
    }
    res.status(200).send(`Entry deleted with ID: ${req.params.id}`);
  } catch (error) {
    console.error('Error:', error);
    res.status(500).send(error);
  }
});

// Update a specific entry from the static table (that matches the given id)
app.put('/static/:id', async (req, res) => {
  try {
    const { url, timestamp, userAgent, screenDimensions } = req.body;
    if (!url || !timestamp || !userAgent || !screenDimensions) {
      console.log('Request Payload:', req.body);
      return res.status(400).send('Missing information');
    }
    const connection = await pool.getConnection();
    const [result] = await connection.execute(
      'UPDATE static SET url = ?, timestamp = ?, userAgent = ?, screenDimensions = ? WHERE id = ?',
      [url, timestamp, userAgent, JSON.stringify(screenDimensions), req.params.id]
    );
    connection.release();
    if (result.affectedRows === 0) {
      return res.status(404).send('Entry not found');
    }
    res.status(200).send(`Entry updated with ID: ${req.params.id}`);
  } catch (error) {
    console.error('Error:', error);
    res.status(500).send(error);
  }
});

// Start server
app.listen(PORT, () => {
  console.log(`Server is running on http://localhost:${PORT}`);
});