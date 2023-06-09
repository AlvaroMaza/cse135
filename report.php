<!DOCTYPE html>
<html>
<head>
  <title>CSE 135 - Spain</title>
  <link rel = "icon" href = "images/crown-solid.svg">
  <link rel="stylesheet" href="indexstyle.css">
  <script src="https://cdn.zingchart.com/zingchart.min.js"></script>
  <script src="https://d3js.org/d3.v7.min.js"></script>
  <script src="https://cdn.zinggrid.com/zinggrid.min.js"></script>
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

  <h3>Number of times the Webpage is entered</h3>
  <div class="chart2">     
    <zing-grid src="https://cse135spain.site/api/static" 
          sort 
          filter 
          pager 
          gridlines="both"
          page-size="5"
          page-size-options="5,10,20"
          caption="What is enabled?"
          theme="black">
          <zg-colgroup>
          <!-- default type is text -->
            <zg-column index="0"></zg-column>
            <zg-column index="1"></zg-column>
            <zg-column index="2"></zg-column>
            <zg-column index="3"></zg-column>
        </zg-colgroup>
      </zing-grid></div>
  <div class = "titles">
    <h3>Heatmap of the mouse moves</h3>
    <h3 class="additional-h3">Log of errors</h3>
  </div>
  <div id="container">
    <div style="flex: 1; display: flex; flex-direction: column;">
      <div id="heatmap"></div>
      <div style="margin: 5px;">
        <p>As you can see, blah blah blah</p>
      </div>
    </div>
    <div class="chart" id="pie-chart">
    </div>
  </div>

  <?php
    $mysqli = new mysqli("localhost", "sammy", "realmadrid", "rest");

    if (mysqli_connect_errno()) {
        printf("Connect failed: %s\n", mysqli_connect_error());
        exit();
    }

    // Fetch language data from the database table
    $query = "SELECT language, COUNT(*) as count FROM static GROUP BY language";
    $result = $mysqli->query($query);

    $languages = array();
    while ($row = $result->fetch_assoc()) {
        $languages[] = array("language" => $row['language'], "count" => $row['count']);
    }

    $result->free();
    $mysqli->close();

    // Pass the language data to JavaScript
    echo "<script>var languages = " . json_encode($languages) . ";</script>";
  ?>


  <script>
  window.addEventListener('load', function() {

    // Create a pie chart
    var pieSvg = d3.select("#pie-chart")
      .append("svg")
      .attr("width", width)
      .attr("height", height);

    var pieWidth = 400;
    var pieHeight = 400;
    var radius = Math.min(pieWidth, pieHeight) / 2;
    var color = d3.scaleOrdinal(d3.schemeCategory10);

    var pie = d3.pie()
      .value(function(d) { return d.count; });

    var arc = d3.arc()
      .outerRadius(radius - 10)
      .innerRadius(0);

    var pieChart = pieSvg.append("g")
      .attr("transform", "translate(" + pieWidth / 2 + "," + pieHeight / 2 + ")");

    var arcs = pieChart.selectAll(".arc")
      .data(pie(languages))
      .enter()
      .append("g")
      .attr("class", "arc");

    arcs.append("path")
      .attr("d", arc)
      .attr("fill", function(d) { return color(d.data.language); });

    arcs.append("text")
      .attr("transform", function(d) { return "translate(" + arc.centroid(d) + ")"; })
      .attr("dy", ".35em")
      .text(function(d) { return d.data.language; });

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