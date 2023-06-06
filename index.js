const PORT = 3002;
const express = require("express");
const bodyParser = require("body-parser");
const cors = require('cors');
const user = require("./routes/userRoutes");
const mongoose = require("mongoose");
const mysql = require('mysql2')
const User = require("./model/User"); 

const app = express();

const MONGOURI = "mongodb://127.0.0.1/users";

app.use(bodyParser.json());
app.use(cors())

// Read all users
app.get("/db", async (req, res) => {
  try {
    const users = await User.find();
    res.status(200).json(users);
  } catch (error) {
    res.status(500).json({ error: error.message });
  }
});

// Create a user
app.post("/db", async (req, res) => {
  try {
    const newUser = new User(req.body);
    const savedUser = await newUser.save();
    res.status(201).json(savedUser);
  } catch (error) {
    res.status(500).json({ error: error.message });
  }
});

// Update a user
app.put("/db/:id", async (req, res) => {
  try {
    const updatedUser = await User.findByIdAndUpdate(req.params.id, req.body, { new: true });
    res.status(200).json(updatedUser);
  } catch (error) {
    res.status(500).json({ error: error.message });
  }
});

// Delete a user
app.delete("/db/:id", async (req, res) => {
  try {
    await User.findByIdAndRemove(req.params.id);
    res.status(204).send();
  } catch (error) {
    res.status(500).json({ error: error.message });
  }
});

// Set "Content-Type" header for all routes
app.use((req, res, next) => {
  res.setHeader('Content-Type', 'application/json');
  next();
});

app.use("/user", user);



mongoose.connect(MONGOURI)
.then(() => {
	console.log("Connected to DB");
	app.listen(PORT, () => {
		console.log(`Node is running on http://localhost:${PORT}`);
    });
  })
  .catch((error) => {
	console.log(error);
  });