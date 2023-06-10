<!DOCTYPE html>
<html>
<head>
  <title>CSE 135 - Spain</title>
  <link rel = "icon" href = "images/crown-solid.svg">
  <link rel="stylesheet" href="reportstyle.css">
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
        <a href="./index.php">
          <button>Go back to dashboard</button>
        </a>
      </div>
    </div>
  </header>

  <div class = "titles">
    <h3>--------</h3>
    <h3 class="additional-h3">User Languages</h3>
  </div>
  <div id="container">
    <div class="chart">
    </div>
    <div class="chart" id="pie-chart">
    <div id="legend" class="legend-container"></div>
    </div>
  </div>
  <p></p>
  <h3>Table with all static</h3>
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
      </zing-grid></div>


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

    // Define the width and height for the pie chart
    var pieWidth = 400;
    var pieHeight = 400;
    var radius = Math.min(pieWidth, pieHeight) / 2;

    // Create a pie chart
    var pieSvg = d3.select("#pie-chart")
      .append("svg")
      .attr("width", pieWidth)
      .attr("height", pieHeight);

    // Define color scales for different language prefixes
    var colorScaleEs = d3.scaleOrdinal()
      .domain(languages.filter(function(d) { return d.language.startsWith("es"); }).map(function(d) { return d.language; }))
      .range(["#888888", "#787878", "#909090", "#A0A0A0", "#A9A9A9"]);
    var colorScaleEn = d3.scaleOrdinal(d3.schemeGreens[7].reverse()); // Reverse the greens for "en" languages

    var pie = d3.pie()
      .value(function(d) { return d.count; });

    var arc = d3.arc()
      .outerRadius(radius - 10)
      .innerRadius(0);

    var total = d3.sum(languages, function(d) { return d.count; }); // Calculate the total count of all languages

    var pieChart = pieSvg.append("g")
      .attr("transform", "translate(" + pieWidth / 2 + "," + pieHeight / 2 + ")");

    var arcs = pieChart.selectAll(".arc")
      .data(pie(languages))
      .enter()
      .append("g")
      .attr("class", "arc");

    arcs.append("path")
      .attr("d", arc)
      .attr("fill", function(d) {
        if (d.data.language.startsWith("es")) {
          return colorScaleEs(d.data.count);
        } else if (d.data.language.startsWith("en")) {
          return colorScaleEn(d.data.count);
        }
      });

    // Define the width and height for the legend
    var legendWidth = 200;
    var legendHeight = languages.length * 20;

    // Create a legend
    var legendSvg = d3.select("#legend")
      .append("svg")
      .attr("width", legendWidth)
      .attr("height", legendHeight)

    var legendDataEs = pie(languages.filter(function(d) { return d.language.startsWith("es"); })); // Filter "es" languages
    var legendDataEn = pie(languages.filter(function(d) { return d.language.startsWith("en"); })); // Filter "en" languages

    // Sort the legend data for "es" languages by count in descending order
    legendDataEs.sort(function(a, b) {
      return b.data.count - a.data.count;
    });

    // Sort the legend data for "en" languages by count in descending order
    legendDataEn.sort(function(a, b) {
      return b.data.count - a.data.count;
    });

    var legendEs = legendSvg.selectAll(".legend-es")
      .data(legendDataEs)
      .enter()
      .append("g")
      .attr("class", "legend-es")
      .attr("transform", function(d, i) {
        return "translate(0," + i * 20 + ")";
      });

    legendEs.append("rect")
      .attr("x", 0)
      .attr("y", 0)
      .attr("width", 18)
      .attr("height", 18)
      .attr("fill", function(d) {
        return colorScaleEs(d.data.count);
      });

    legendEs.append("text")
      .attr("x", 24)
      .attr("y", 9)
      .attr("dy", ".35em")
      .attr("fill", "white") // Set the text color to white
      .text(function(d) {
        var percentage = (d.data.count / total) * 100;
        return d.data.language + " (" + percentage.toFixed(2) + "%)";
      });

    var legendEn = legendSvg.selectAll(".legend-en")
      .data(legendDataEn)
      .enter()
      .append("g")
      .attr("class", "legend-en")
      .attr("transform", function(d, i) {
        return "translate(0," + (i + legendDataEs.length) * 20 + ")";
      });

    legendEn.append("rect")
      .attr("x", 0)
      .attr("y", 0)
      .attr("width", 18)
      .attr("height", 18)
      .attr("fill", function(d) {
        return colorScaleEn(d.data.count);
      });

    legendEn.append("text")
      .attr("x", 24)
      .attr("y", 9)
      .attr("dy", ".35em")
      .attr("fill", "white") // Set the text color to white
      .text(function(d) {
        var percentage = (d.data.count / total) * 100;
        return d.data.language + " (" + percentage.toFixed(2) + "%)";
      });
    });

  window.onload = function() {
        auth_token = sessionStorage.getItem('auth_token');
        if(auth_token == null){
            console.log('Auth token not present')
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