const PORT = 3001;

const express = require('express');
const mysql = require('mysql2');
const bodyParser = require('body-parser');
const cors = require('cors');
const { time } = require('console');

// Create express app
const app = express();

// Use body-parser middleware to parse request bodies
app.use(bodyParser.json());

// Better set up CORS properly or not depending on security posture
app.use(cors({
    origin: '*'
}));

// Create connection pool to MySQL database

const pool = mysql.createPool({
    host: '143.198.66.79',
    user: 'sammy',
    password: 'cse135',
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
        console.log(`${req.body}`);
        if (!url || !timestamp || !userAgent || !screenDimensions) {
            console.log(`${req.body}`);
            return res.status(400).send('Missing info');
        }

        // ZOMG on the way to SQL INJECTION if you don't watch out!

        // Execute SQL query
        const [result] = await promisePool.query('INSERT INTO users (url, timestamp, userAgent, screenDimensions) VALUES (?, ?, ?, ?)', [url, timestamp, userAgent, screenDimensions]);

        // Send response
        res.status(201).send(`User added with ID: ${result.insertId}`);
    } catch (error) {
        // Handle error
        res.status(500).send(error);
    }
});

app.put('/api/:id', async (req, res) => {

    const id = req.params.id;
    const { name, email } = req.body;

    if (!id || !name || !email) {
        return res.status(400).send('Missing id, name, or email');
    }

    try {
        // Execute SQL query
        const [result] = await promisePool.query('UPDATE users SET name = ?, email = ? WHERE id = ?', [name, email, id]);

        // Send response
        res.status(200).send(true);
    } catch (error) {
        // Handle error
        res.status(500).send(error);
    }
})

app.delete('/api/:id', async (req, res) => {
    // delete the user with the given id from the mySQL database
    const id = req.params.id;

    if (!id) {
        return res.status(400).send('Missing id');
    }

    try {
        const [result] = await promisePool.query('DELETE FROM users WHERE id = ?', [id]);

        // Send response
        res.status(200).send(true);

    } catch(error) {
        res.status(500).send(error);
    }

});

// Start server
app.listen(PORT, () => {
    console.log(`Server is running on http://localhost:${PORT}`);
});
