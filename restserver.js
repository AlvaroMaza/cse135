const PORT = 3001;

const express = require('express');
const mysql = require('mysql2');
const bodyParser = require('body-parser');
const cors = require('cors');
const { time } = require('console');

// Create express app
const app = express();

app.use(express.json());


// Better set up CORS properly or not depending on security posture
app.use(cors({
    origin: '*'
}));

// Create connection pool to MySQL database

const pool = mysql.createPool({
    host: '143.198.66.79',
    user: 'sammy',
    password: 'realmadrid',
    database: 'rest'
});

// Enable "promise" for mysql2
const promisePool = pool.promise();

app.get('/static/', async (req, res) => {
    const logs = require('./logs.json');
  
    res.json(logs);
});

app.post('/static/', async (req, res) => {
    try {
        const { url, timestamp, userAgent, screenDimensions } = req.body;

        if (!url || !timestamp || !userAgent || !screenDimensions) {
            console.log('Request Payload:', req.body)
            return res.status(400).send(req.body);
        }

        // Execute SQL query
        const [result] = await promisePool.query('INSERT INTO users (url, timestamp, userAgent, screenDimensions) VALUES (?, ?, ?, ?)', [url, timestamp, userAgent, screenDimensions]);

        // Send response
        res.status(201).send(`User added with ID: ${result.insertId}`);
    } catch (error) {
        // Handle error
        res.status(500).send(error);
    }
});

// Start server
app.listen(PORT, () => {
    console.log(`Server is running on http://localhost:${PORT}`);
});
