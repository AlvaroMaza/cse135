const PORT = 3002;
const express = require("express");
const bodyParser = require("body-parser");
const cors = require('cors');
const user = require("./routes/userRoutes");
const mongoose = require("mongoose");
const mysql = require('mysql2')

const app = express();

const MONGOURI = "mongodb://127.0.0.1/users";

app.use(bodyParser.json());
app.use(cors())

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
