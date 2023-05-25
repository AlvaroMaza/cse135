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
app.get('/static/', (req, res) => {
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
app.get('/static/:id', (req, res) => {
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
app.post('/static/', (req, res) => {
  const {
    url,
    timestamp,
    userAgent,
    language,
    cookieEnabled,
    jsEnabled,
    imagesEnabled,
    cssEnabled,
    screenDimensions,
    windowDimensions,
    connectionType
  } = req.body;

  if (!url || !timestamp || !userAgent || !language || 
      typeof cookieEnabled !== 'boolean' ||
      typeof jsEnabled !== 'boolean' ||
      typeof imagesEnabled !== 'boolean' ||
      typeof cssEnabled !== 'boolean' ||
      !screenDimensions || !windowDimensions || !connectionType) {
    console.log('Request Payload:', req.body);
    return res.status(400).send('Missing or invalid information');
  }

  const formattedTimestamp = new Date(timestamp).toISOString().slice(0, 19).replace('T', ' ');

  connection.query(
    'INSERT INTO static (url, timestamp, userAgent, language, cookieEnabled, jsEnabled, imagesEnabled, cssEnabled, screenDimensions, windowDimensions, connectionType) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)',
    [
      url,
      formattedTimestamp,
      userAgent,
      language,
      cookieEnabled,
      jsEnabled,
      imagesEnabled,
      cssEnabled,
      JSON.stringify(screenDimensions),
      JSON.stringify(windowDimensions),
      connectionType
    ],
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
app.delete('/static/:id', (req, res) => {
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
app.put('/static/:id', (req, res) => {
  const {
    url,
    timestamp,
    userAgent,
    language,
    cookieEnabled,
    jsEnabled,
    imagesEnabled,
    cssEnabled,
    screenDimensions,
    windowDimensions,
    connectionType
  } = req.body;

  if (!url || !timestamp || !userAgent || !language || 
      typeof cookieEnabled !== 'boolean' ||
      typeof jsEnabled !== 'boolean' ||
      typeof imagesEnabled !== 'boolean' ||
      typeof cssEnabled !== 'boolean' ||
      !screenDimensions || !windowDimensions || !connectionType) {
    console.log('Request Payload:', req.body);
    return res.status(400).send('Missing or invalid information');
  }

  const formattedTimestamp = new Date(timestamp).toISOString().slice(0, 19).replace('T', ' ');

  connection.query(
    'UPDATE static SET url = ?, timestamp = ?, userAgent = ?, language = ?, cookieEnabled = ?, jsEnabled = ?, imagesEnabled = ?, cssEnabled = ?, screenDimensions = ?, windowDimensions = ?, connectionType = ? WHERE id = ?',
    [
      url,
      formattedTimestamp,
      userAgent,
      language,
      cookieEnabled,
      jsEnabled,
      imagesEnabled,
      cssEnabled,
      JSON.stringify(screenDimensions),
      JSON.stringify(windowDimensions),
      connectionType,
      req.params.id
    ],
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



// Add a new entry to the performance table
app.post('/performance/', (req, res) => {
  const {
    timing,
    loadStartTime,
    loadEndTime,
    totalLoadTime
  } = req.body;

  if (!timing || !loadStartTime || !loadEndTime || !totalLoadTime) {
    console.log('Request Payload:', req.body);
    return res.status(400).send('Missing or invalid information');
  }

  connection.query(
    'INSERT INTO performance (timing, loadStartTime, loadEndTime, totalLoadTime) VALUES (?, ?, ?, ?)',
    [
      JSON.stringify(timing),
      loadStartTime,
      loadEndTime,
      totalLoadTime
    ],
    (error, results) => {
      if (error) {
        console.error('Error:', error);
        res.status(500).send(error);
      } else {
        res.status(201).send(`Performance data added with ID: ${results.insertId}`);
      }
    }
  );
});

// Retrieve every entry logged in the performance table
app.get('/performance/', (req, res) => {
  connection.query('SELECT * FROM performance', (error, results) => {
    if (error) {
      console.error('Error:', error);
      res.status(500).send(error);
    } else {
      res.json(results);
    }
  });
});

// Delete a specific entry from the performance table (that matches the given id)
app.delete('/performance/:id', (req, res) => {
  connection.query('DELETE FROM performance WHERE id = ?', [req.params.id], (error, results) => {
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

// Update a specific entry from the performance table (that matches the given id)
app.put('/performance/:id', (req, res) => {
  const {
    timing,
    loadStartTime,
    loadEndTime,
    totalLoadTime
  } = req.body;

  if (!timing || !loadStartTime || !loadEndTime || !totalLoadTime) {
    console.log('Request Payload:', req.body);
    return res.status(400).send('Missing or invalid information');
  }

  const formattedTimestamp = new Date(timestamp).toISOString().slice(0, 19).replace('T', ' ');

  connection.query(
    'UPDATE performance SET timing = ?, loadStartTime = ?, loadEndTime = ?, totalLoadTime = ? WHERE id = ?',
    [
      timing,
      loadStartTime,
      loadEndTime,
      totalLoadTime,
      req.params.id
    ],
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


// Add a new entry to the errors table
app.post('/errors/', (req, res) => {
  const {
    errorMsg,
    url,
    lineNumber,
    columnNumber,
    errorObj,
  } = req.body;

  if (!errorMsg || !url || !lineNumber || !columnNumber || !errorObj) {
    console.log('Request Payload:', req.body);
    return res.status(400).send('Missing or invalid information');
  }

  connection.query(
    'INSERT INTO errors (errorMsg, url, lineNumber, columnNumber, errorObj) VALUES (?, ?, ?, ?, ?)',
    [
      errorMsg,
      url,
      lineNumber,
      columnNumber,
      JSON.stringify(errorObj)
    ],
    (error, results) => {
      if (error) {
        console.error('Error:', error);
        res.status(500).send(error);
      } else {
        res.status(201).send(`Error data added with ID: ${results.insertId}`);
      }
    }
  );
});

// Retrieve every entry logged in the errors table
app.get('/errors/', (req, res) => {
  connection.query('SELECT * FROM errors', (error, results) => {
    if (error) {
      console.error('Error:', error);
      res.status(500).send(error);
    } else {
      res.json(results);
    }
  });
});


// Delete a specific entry from the errors table (that matches the given id)
app.delete('/errors/:id', (req, res) => {
  connection.query('DELETE FROM errors WHERE id = ?', [req.params.id], (error, results) => {
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

// Update a specific entry from the errors table (that matches the given id)
app.put('/errors/:id', (req, res) => {
  const {
    errorMsg,
    url,
    lineNumber,
    columnNumber,
    errorObj,
  } = req.body;

  if (!errorMsg || !url || !lineNumber || !columnNumber || !errorObj) {
    console.log('Request Payload:', req.body);
    return res.status(400).send('Missing or invalid information');
  }

  connection.query(
    'UPDATE errors SET errorMsg = ?, url = ?, lineNumber = ?, columnNumber = ?, errorObj = ? WHERE id = ?',
    [
      errorMsg,
      url,
      lineNumber,
      columnNumber,
      errorObj,
      req.params.id
    ],
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


// Add a new entry to the mouseactivity table
app.post('/mouseactivity/', (req, res) => {
  const { type, data } = req.body;

  if (!type || !data) {
    console.log('Request Payload:', req.body);
    return res.status(400).send('Missing or invalid information');
  }
  
  const x = data['x'];
  const y = data['y'];
  let button
  try {
    button = data['button'];
  }
  catch(err) {
    button = null;
  };
  connection.query(
    'INSERT INTO mouseactivity (type, x, y, button) VALUES (?, ?, ?, ?)',
    [type, x, y, button],
    (error, results) => {
      if (error) {
        console.error('Error:', error);
        res.status(500).send(error);
      } else {
        res.status(201).send(`Mouse activity data added with ID: ${results.insertId}`);
      }
    }
  );
});

// Retrieve every entry logged in the mouseactivity table
app.get('/mouseactivity/', (req, res) => {
  connection.query('SELECT * FROM mouseactivity', (error, results) => {
    if (error) {
      console.error('Error:', error);
      res.status(500).send(error);
    } else {
      res.json(results);
    }
  });
});

// Delete a specific entry from the mouseactivity table (that matches the given id)
app.delete('/mouseactivity/:id', (req, res) => {
  connection.query('DELETE FROM mouseactivity WHERE id = ?', [req.params.id], (error, results) => {
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

// Update a specific entry from the mouseactivity table (that matches the given id)
app.put('/mouseactivity/:id', (req, res) => {
  const { type, data } = req.body;

  if (!type || !data) {
    console.log('Request Payload:', req.body);
    return res.status(400).send('Missing or invalid information');
  }
  
  const x = data['x'];
  const y = data['y'];
  let button
  try {
    button = data['button'];
  }
  catch(err) {
    button = null;
  };

  connection.query(
    'UPDATE mouseactivity SET type = ?, x = ?, y = ?, button = ? WHERE id = ?',
    [
      type,
      x,
      y,
      button,
      req.params.id
    ],
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

// Add a new entry to the keyboardactivity table
app.post('/keyboardactivity/', (req, res) => {
  const { type, data } = req.body;

  if (!type || !data) {
    console.log('Request Payload:', req.body);
    return res.status(400).send('Missing or invalid information');
  }
  
  const { keyValue, code, shiftKey, ctrlKey, altKey, metaKey } = data;

  connection.query(
    'INSERT INTO keyboardactivity (type, keyValue, code, shiftKey, ctrlKey, altKey, metaKey) VALUES (?, ?, ?, ?, ?, ?, ?)',
    [type, keyValue, code, shiftKey, ctrlKey, altKey, metaKey],
    (error, results) => {
      if (error) {
        console.error('Error:', error);
        res.status(500).send(error);
      } else {
        res.status(201).send(`Keyboard activity data added with ID: ${results.insertId}`);
      }
    }
  );
});

// Retrieve every entry logged in the keyboardactivity table
app.get('/keyboardactivity/', (req, res) => {
  connection.query('SELECT * FROM keyboardactivity', (error, results) => {
    if (error) {
      console.error('Error:', error);
      res.status(500).send(error);
    } else {
      res.json(results);
    }
  });
});

// Delete a specific entry from the keyboardactivity table (that matches the given id)
app.delete('/keyboardactivity/:id', (req, res) => {
  connection.query('DELETE FROM keyboardactivity WHERE id = ?', [req.params.id], (error, results) => {
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

// Update a specific entry from the keyboardactivity table (that matches the given id)
app.put('/keyboardactivity/:id', (req, res) => {
  const { type, data } = req.body;

  if (!type || !data) {
    console.log('Request Payload:', req.body);
    return res.status(400).send('Missing or invalid information');
  }
  
  const { keyValue, code, shiftKey, ctrlKey, altKey, metaKey } = data;

  connection.query(
    'UPDATE keyboardactivity SET type = ?, keyValue = ?, code = ?, shiftKey = ?, ctrlKey = ?, altKey = ?, metaKey = ? WHERE id = ?',
    [type, keyValue, code, shiftKey, ctrlKey, altKey, metaKey, req.params.id],
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

// Add a new entry to the keyboardactivity table
app.post('/idleactivity/', (req, res) => {
  const data  = req.body;

  if (!data) {
    console.log('Request Payload:', req.body);
    return res.status(400).send('Missing or invalid information');
  }
  
  const { breakStartTimestamp, breakEndTimestamp, breakDuration} = data;

  const formattedBreakStartTimestamp = new Date(breakStartTimestamp).toISOString().slice(0, 19).replace('T', ' ');
  const formattedBreakEndTimestamp = new Date(breakEndTimestamp).toISOString().slice(0, 19).replace('T', ' ');

  connection.query(
    'INSERT INTO idleactivity (breakStartTimestamp, breakEndTimestamp, breakDuration) VALUES (?, ?, ?)',
    [formattedBreakStartTimestamp, formattedBreakEndTimestamp, breakDuration],
    (error, results) => {
      if (error) {
        console.error('Error:', error);
        res.status(500).send(error);
      } else {
        res.status(201).send(`Idle break added with ID: ${results.insertId}`);
      }
    }
  );
});

// Retrieve every entry logged in the keyboardactivity table
app.get('/idleactivity/', (req, res) => {
  connection.query('SELECT * FROM idleactivity', (error, results) => {
    if (error) {
      console.error('Error:', error);
      res.status(500).send(error);
    } else {
      res.json(results);
    }
  });
});

// Delete a specific entry from the keyboardactivity table (that matches the given id)
app.delete('/idledactivity/:id', (req, res) => {
  connection.query('DELETE FROM idleactivity WHERE id = ?', [req.params.id], (error, results) => {
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

// Update a specific entry from the keyboardactivity table (that matches the given id)
app.put('/idleactivity/:id', (req, res) => {
  const data = req.body;

  if (!data) {
    console.log('Request Payload:', req.body);
    return res.status(400).send('Missing or invalid information');
  }
  
  const { breakStartTimestamp, breakEndTimestamp, breakDuration} = data;

  const formattedBreakStartTimestamp = new Date(breakStartTimestamp).toISOString().slice(0, 19).replace('T', ' ');
  const formattedBreakEndTimestamp = new Date(breakEndTimestamp).toISOString().slice(0, 19).replace('T', ' ');

  connection.query(
    'UPDATE idleactivity SET breakStartTimestamp = ?, breakEndTimestamp = ?, breakDuration = ? WHERE id = ?',
    [formattedBreakStartTimestamp, formattedBreakEndTimestamp, breakDuration, req.params.id],
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

// Add a new entry to the pageactivity table
app.post('/pageactivity/', (req, res) => {
  const { type, page } = req.body;

  if (!type || !page) {
    console.log('Request Payload:', req.body);
    return res.status(400).send('Missing or invalid information');
  }

  connection.query(
    'INSERT INTO pageactivity (type, page) VALUES (?, ?)',
    [type, page],
    (error, results) => {
      if (error) {
        console.error('Error:', error);
        res.status(500).send(error);
      } else {
        res.status(201).send(`Page activity data added with ID: ${results.insertId}`);
      }
    }
  );
});

// Retrieve every entry logged in the pageactivity table
app.get('/pageactivity/', (req, res) => {
  connection.query('SELECT * FROM pageactivity', (error, results) => {
    if (error) {
      console.error('Error:', error);
      res.status(500).send(error);
    } else {
      res.json(results);
    }
  });
});

// Delete a specific entry from the pageactivity table (that matches the given id)
app.delete('/pageactivity/:id', (req, res) => {
  connection.query('DELETE FROM pageactivity WHERE id = ?', [req.params.id], (error, results) => {
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

// Update a specific entry from the pageactivity table (that matches the given id)
app.put('/pageactivity/:id', (req, res) => {
  const { type, page } = req.body;

  if (!type || !page) {
    console.log('Request Payload:', req.body);
    return res.status(400).send('Missing or invalid information');
  }

  connection.query(
    'UPDATE pageactivity SET type = ?, page = ? WHERE id = ?',
    [type, page, req.params.id],
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