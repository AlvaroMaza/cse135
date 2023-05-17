const express = require('express');
const mysql = require('mysql2');

const app = express();
const port = 3001;

app.use(express.json());

// Create a connection pool
const pool = mysql.createPool({
  host: '143.198.66.79',
  user: 'root',
  password: 'cse135',
  database: 'rest',
});

// Helper function to execute SQL queries using the connection pool
const executeQuery = async (query, values) => {
  const connection = await pool.getConnection();
  try {
    const [rows, fields] = await connection.query(query, values);
    return rows;
  } finally {
    connection.release();
  }
};

app.post('/static/', async (req, res) => {
  try {
    const { url, timestamp, userAgent, screenDimensions } = req.body;

    // Perform validation
    if (!url || !timestamp || !userAgent || !screenDimensions) {
      return res.status(400).send('Missing required information');
    }

    // Execute SQL query to insert data into the database
    const query = 'INSERT INTO users (url, timestamp, userAgent, screenDimensions) VALUES (?, ?, ?, ?)';
    const values = [url, timestamp, userAgent, JSON.stringify(screenDimensions)];

    await executeQuery(query, values);

    // Send response
    res.status(201).send('User added successfully');
  } catch (error) {
    // Handle error
    console.error(error);
    res.status(500).send('Internal Server Error');
  }
});

app.listen(port, () => {
  console.log(`Server running on port ${port}`);
});