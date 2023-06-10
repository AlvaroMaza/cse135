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
    <div class="chart" id="screen-width-histogram"></div>
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
    // Fetch window dimensions data from the database table
    $query = "SELECT windowDimensions FROM static";
    $result = $mysqli->query($query);

    $windowDimensions = array();
    while ($row = $result->fetch_assoc()) {
        $windowDimensions[] = json_decode($row['windowDimensions']);
    }

    $result->free();
    $mysqli->close();

    // Pass the language data to JavaScript
    echo "<script>var languages = " . json_encode($languages) . ";</script>";
    echo "<script>var screenDimensions = " . json_encode($windowDimensions) . ";</script>";
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
      .range(["#F0F0F0", "#D8D8D8", "#B8B8B8", "#707070"]);
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






    // Get an array of screen widths
    var screenWidths = screenDimensions.map(function(d) {
        return d.width;
    });

    // Get an array of screen heights
    var screenHeights = screenDimensions.map(function(d) {
        return d.height;
    });

    // Define the dimensions and margins for the histogram chart
    var histogramWidth = 600;
    var histogramHeight = 400;
    var histogramMargin = { top: 20, right: 20, bottom: 50, left: 50 };

    // Create the SVG container for the width histogram chart
    var widthHistogramSvg = d3.select("#screen-width-histogram")
        .append("svg")
        .attr("width", histogramWidth)
        .attr("height", histogramHeight);

    // Create the x-scale for screen widths
    var xWidthScale = d3.scaleLinear()
        .domain([0, d3.max(screenWidths)])
        .range([histogramMargin.left, histogramWidth - histogramMargin.right]);

    // Create the histogram bins for screen widths
    var widthHistogramBins = d3.histogram()
        .value(function(d) { return d; })
        .domain(xWidthScale.domain())
        .thresholds(xWidthScale.ticks(10))
        (screenWidths);

    // Create the y-scale for the width histogram
    var yWidthScale = d3.scaleLinear()
        .domain([0, d3.max(widthHistogramBins, function(d) { return d.length; })])
        .range([histogramHeight - histogramMargin.bottom, histogramMargin.top]);

    // Create the x-axis for width histogram
    var xWidthAxis = d3.axisBottom(xWidthScale);

    // Create the y-axis for width histogram
    var yWidthAxis = d3.axisLeft(yWidthScale);

    // Append the x-axis to the width histogram SVG container
    widthHistogramSvg.append("g")
        .attr("transform", "translate(0," + (histogramHeight - histogramMargin.bottom) + ")")
        .call(xWidthAxis);

    // Append the y-axis to the width histogram SVG container
    widthHistogramSvg.append("g")
        .attr("transform", "translate(" + histogramMargin.left + ",0)")
        .call(yWidthAxis);

    // Create the width histogram bars
    widthHistogramSvg.selectAll("rect")
        .data(widthHistogramBins)
        .enter()
        .append("rect")
        .attr("x", function(d) { return xWidthScale(d.x0) + 1; })
        .attr("y", function(d) { return yWidthScale(d.length); })
        .attr("width", function(d) { return xWidthScale(d.x1) - xWidthScale(d.x0) - 1; })
        .attr("height", function(d) { return histogramHeight - histogramMargin.bottom - yWidthScale(d.length); })
        .attr("fill", "steelblue");

    // Create the SVG container for the height histogram chart
    var heightHistogramSvg = d3.select("#screen-height-histogram")
        .append("svg")
        .attr("width", histogramWidth)
        .attr("height", histogramHeight);

    // Create the x-scale for screen heights
    var xHeightScale = d3.scaleLinear()
        .domain([0, d3.max(screenHeights)])
        .range([histogramMargin.left, histogramWidth - histogramMargin.right]);

    // Create the histogram bins for screen heights
    var heightHistogramBins = d3.histogram()
        .value(function(d) { return d; })
        .domain(xHeightScale.domain())
        .thresholds(xHeightScale.ticks(10))
        (screenHeights);

    // Create the y-scale for the height histogram
    var yHeightScale = d3.scaleLinear()
        .domain([0, d3.max(heightHistogramBins, function(d) { return d.length; })])
        .range([histogramHeight - histogramMargin.bottom, histogramMargin.top]);

    // Create the x-axis for height histogram
    var xHeightAxis = d3.axisBottom(xHeightScale);

    // Create the y-axis for height histogram
    var yHeightAxis = d3.axisLeft(yHeightScale);

    // Append the x-axis to the height histogram SVG container
    heightHistogramSvg.append("g")
        .attr("transform", "translate(0," + (histogramHeight - histogramMargin.bottom) + ")")
        .call(xHeightAxis);

    // Append the y-axis to the height histogram SVG container
    heightHistogramSvg.append("g")
        .attr("transform", "translate(" + histogramMargin.left + ",0)")
        .call(yHeightAxis);

    // Create the height histogram bars
    heightHistogramSvg.selectAll("rect")
        .data(heightHistogramBins)
        .enter()
        .append("rect")
        .attr("x", function(d) { return xHeightScale(d.x0) + 1; })
        .attr("y", function(d) { return yHeightScale(d.length); })
        .attr("width", function(d) { return xHeightScale(d.x1) - xHeightScale(d.x0) - 1; })
        .attr("height", function(d) { return histogramHeight - histogramMargin.bottom - yHeightScale(d.length); })
        .attr("fill", "steelblue"); 

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