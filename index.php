<!DOCTYPE html>
<html>
<head>
  <title>CSE 135 - Spain</title>
  <link rel = "icon" href = "images/crown-solid.svg">
  <link rel="stylesheet" href="indexstyle.css">
  <script src="https://cdn.zingchart.com/zingchart.min.js"></script>
  <script src="https://d3js.org/d3.v7.min.js"></script>
</head>
<body>
<header>
    <div class="title-container">
      <h1>Analytics Dashboard</h1>
      <div class="buttons-container">
        <button id="logout-button">Logout</button>
        <a href="./crud.html" id="crud-link">
          <button>Go to CRUD</button>
        </a>
      </div>
    </div>
  </header>
  <!--<div id="container">
    <div class="chart" id="myChart2"></div>
    <div class="chart" id="myChart3"></div>
  </div>-->
  <h3>Number of times the webpage is entered</h3>
  <div class="chart2" id="myChart4"></div>

  <?php
    $mysqli = new mysqli("localhost", "sammy", "realmadrid", "rest");

    if (mysqli_connect_errno()) {
        printf("Connect failed: %s\n", mysqli_connect_error());
        exit();
    }

    // Fetch timestamp data from the database table
    $query = "SELECT timestamp FROM static";
    $result = $mysqli->query($query);

    $timestamps = array();
    while ($row = $result->fetch_assoc()) {
      $timestamps[] = strtotime($row['timestamp']) * 1000; // Convert timestamp to milliseconds
    }

    $result->free();
    $mysqli->close();

    // Pass the timestamps to JavaScript
    echo "<script>var timestamps = " . json_encode($timestamps) . ";</script>";
  ?>


  <script>
  window.addEventListener('load', function() {

    // Group timestamps by day
    var counts = d3.rollups(timestamps, v => v.length, d => d3.timeDay.floor(new Date(d)));

    // Extract dates and visit counts
    var dates = counts.map(function(d) {
      return d[0];
    });

    var visitCounts = counts.map(function(d) {
      return d[1];
    });

    // Set up the chart dimensions
    var width = 1400;
    var height = 400;
    var margin = { top: 20, right: 20, bottom: 50, left: 80 };

    // Create an SVG element for the chart
    var svg = d3.select("#myChart4")
      .append("svg")
      .attr("width", width)
      .attr("height", height)

    // Set up the scales for x and y axes
    var xScale = d3.scaleTime()
      .domain(d3.extent(dates))
      .range([margin.left, width - margin.right]);


    // Use a linear scale for the y axis
    var yScale = d3.scaleLinear()
      .domain([0, d3.max(visitCounts)])
      .range([height - margin.bottom, margin.top]);

    // Create the line generator
    var line = d3.line()
    .x(function(d, i) { return xScale(dates[i]); })
    .y(function(d) { return yScale(d); });

    // Create x-axis
    var xAxis = d3.axisBottom(xScale);

    // Append x-axis to the SVG
    svg.append("g")
      .attr("class", "x-axis")
      .attr("transform", "translate(0," + (height - margin.bottom) + ")")
      .call(xAxis);

    // Add x-axis label
    svg.append("text")
      .attr("class", "x-label")
      .attr("text-anchor", "middle")
      .attr("x", width / 2)
      .attr("y", height - margin.bottom + 10 / 2)
      .text("Date");

    // Create y-axis
    var yAxis = d3.axisLeft(yScale);

    // Append y-axis to the SVG
    var yAxisGroup = svg.append("g")
      .attr("class", "y-axis")
      .attr("transform", "translate(" + margin.left + ",0)")
      .call(yAxis);

    // Add y-axis label
    svg.append("text")
      .attr("class", "y-label")
      .attr("text-anchor", "middle")
      .attr("x", -height / 2)
      .attr("y", margin.left / 2)
      .attr("transform", "rotate(-90)")
      .text("Visit Count");

    // Add numbers to the y-axis ticks
    yAxisGroup.selectAll(".tick text")
      .style("font-size", "14px"); // Adjust font size as needed


    // Create the y-axis grid lines
    var yGrid = d3.axisLeft(yScale)
      .tickSize(-width + margin.left + margin.right)
      .tickFormat("");

    // Append the y-axis grid lines to the SVG
    svg.append("g")
      .attr("class", "y-grid")
      .attr("transform", "translate(" + margin.left + ",0)")
      .call(yGrid);

    // Append the line to the SVG
    svg.append("path")
      .datum(visitCounts)
      .attr("fill", "none")
      .attr("stroke", "steelblue")
      .attr("stroke-width", 4)
      .attr("d", line);
  });

  window.onload = function() {
        auth_token = sessionStorage.getItem('auth_token');
        if(auth_token == null){
            console.log('Auth token not present')
            window.location.href = "./login.html";
        }
    };

    
  window.onload = function() {
    var sessionID = sessionStorage.getItem('id');

    if (sessionID) {
      // Send a GET request to the API endpoint
      var url = "https://reporting.cse135spain.site/api/db/" + sessionID;
      var xhr = new XMLHttpRequest();
      xhr.open("GET", url, true);
      xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
          var response = JSON.parse(xhr.responseText);
          var isAdmin = response.admin;

          // Hide the CRUD button if the user is not admin
          if (!isAdmin) {
            var crudLink = document.getElementById("crud-link");
            crudLink.style.display = "none";
          }
        }
      };
      xhr.send();
    } else {
      // Redirect to the login page
      window.location.href = "./login.html";
    }
  };
    

    // Add a click event listener to the logout button
    document.getElementById("logout-button").addEventListener("click", function() {
        // Clear the authentication token from the session storage
        sessionStorage.removeItem("auth_token");
        
        // Redirect the user to the login page
        window.location.href = "./logout.html";
    });


  </script>
</body>
</html>