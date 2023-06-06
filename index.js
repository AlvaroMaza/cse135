const PORT = 3002;
const express = require("express");
const bodyParser = require("body-parser");
const cors = require('cors');
const user = require("./routes/userRoutes");
const mongoose = require("mongoose");
const mysql = require('mysql2')
const User = require("../model/User"); 

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