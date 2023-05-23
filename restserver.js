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

// Connect to MySQL database
connection.connect((err) => {
  if (err) {
    console.error('Error connecting to database:', err);
    return;
  }
  console.log('Connected to MySQL database');
});

// Retrieve every entry logged in the static table
app.get('/api/static', (req, res) => {
  connection.query('SELECT * FROM static', (error, results) => {
    if (error) {
      console.error('Error:', error);
      res.status(500).send(error);
    } else {
      res.json(results);
    }
  });
});

// Retrieve a specific entry logged in the static table (that matches the given id)
app.get('/api/static/:id', (req, res) => {
  connection.query('SELECT * FROM static WHERE id = ?', [req.params.id], (error, results) => {
    if (error) {
      console.error('Error:', error);
      res.status(500).send(error);
    } else if (results.length === 0) {
      res.status(404).send('Entry not found');
    } else {
      res.json(results[0]);
    }
  });
});

// Add a new entry to the static table
app.post('/api/static', (req, res) => {
  const { url, timestamp, userAgent, screenDimensions } = req.body;
  if (!url || !timestamp || !userAgent || !screenDimensions) {
    console.log('Request Payload:', req.body);
    return res.status(400).send('Missing information');
  }
  connection.query(
    'INSERT INTO static (url, timestamp, userAgent, screenDimensions) VALUES (?, ?, ?, ?)',
    [url, timestamp, userAgent, JSON.stringify(screenDimensions)],
    (error, results) => {
      if (error) {
        console.error('Error:', error);
        res.status(500).send(error);
      } else {
        res.status(201).send(`Entry added with ID: ${results.insertId}`);
      }
    }
  );
});

// Delete a specific entry from the static table (that matches the given id)
app.delete('/api/static/:id', (req, res) => {
  connection.query('DELETE FROM static WHERE id = ?', [req.params.id], (error, results) => {
    if (error) {
      console.error('Error:', error);
      res.status(500).send(error);
    } else if (results.affectedRows === 0) {
      res.status(404).send('Entry not found');
    } else {
      res.status(200).send(`Entry deleted with ID: ${req.params.id}`);
    }
  });
});

// Update a specific entry from the static table (that matches the given id)
app.put('/api/static/:id', (req, res) => {
  const { url, timestamp, userAgent, screenDimensions } = req.body;
  if (!url || !timestamp || !userAgent || !screenDimensions) {
    console.log('Request Payload:', req.body);
    return res.status(400).send('Missing information');
  }
  connection.query(
    'UPDATE static SET url = ?, timestamp = ?, userAgent = ?, screenDimensions = ? WHERE id = ?',
    [url, timestamp, userAgent, JSON.stringify(screenDimensions), req.params.id],
    (error, results) => {
      if (error) {
        console.error('Error:', error);
        res.status(500).send(error);
      } else if (results.affectedRows === 0) {
        res.status(404).send('Entry not found');
      } else {
        res.status(200).send(`Entry updated with ID: ${req.params.id}`);
      }
    }
  );
});

// Start server
app.listen(PORT, () => {
  console.log(`Server is running on http://localhost:${PORT}`);
});