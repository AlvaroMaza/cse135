<!DOCTYPE html>
<html>
<head>
  <title>CSE 135 - Spain</title>
  <link rel = "icon" href = "images/crown-solid.svg">
  <link rel="stylesheet" href="indexstyle.css">
  <script src="https://cdn.zingchart.com/zingchart.min.js"></script>
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
  <div id="container">
    <div class="chart" id="myChart2"></div>
    <div class="chart" id="myChart3"></div>
  </div>
  <!--<div class="chart2" id="myChart4"></div>-->

  <?php
  $mysqli = new mysqli("localhost", "sammy", "realmadrid", "rest");

  if (mysqli_connect_errno()) {
      printf("Connect failed: %s\n", mysqli_connect_error());
      exit();
  }
  ?>

  <script>

  var langData = [
    <?php
    $langdata = mysqli_query($mysqli, "SELECT Language,COUNT(*) FROM static GROUP BY Language");

    while ($langinfo = mysqli_fetch_array($langdata)) {
          echo  $langinfo['COUNT(*)'] . ',';
    }
    ?>
  ];

  var langLabels = [
    <?php
    $langdata = mysqli_query($mysqli, "SELECT Language,COUNT(*) FROM static GROUP BY Language");

    while ($langinfo = mysqli_fetch_array($langdata)) {
          echo  '"' . $langinfo['Language'] . '",';
    }
    ?>
  ];

  var avgX = [
    <?php
    $xdata = mysqli_query($mysqli, "SELECT AVG(X) FROM mouseactivity GROUP BY type");

    while ($xinfo = mysqli_fetch_array($xdata)) {
          echo  $xinfo['AVG(X)'] . ',';
    }
    ?>
  ];

  var avgY = [
    <?php
    $ydata = mysqli_query($mysqli, "SELECT AVG(Y) FROM mouseactivity GROUP BY type");

    while ($yinfo = mysqli_fetch_array($ydata)) {
          echo  $yinfo['AVG(Y)'] . ',';
    }
    ?>
  ];

  var activityLabels = [
    <?php
    $labelsdata = mysqli_query($mysqli, "SELECT type, AVG(Y) FROM mouseactivity GROUP BY type");

    while ($yinfo = mysqli_fetch_array($labelsdata)) {
          echo  '"' . $yinfo['type'] . '",';
    }
    ?>
  ];
  </script>

  <?php
  $mysqli->close();
  ?>


  <script>
  window.addEventListener('load', function() {

  zingchart.render({
      id: 'myChart2',
      height: 400,
      width: "100%",
      data: myConfig = {
        type: "pie3d",

        plot: {
          'offset-r': "25%"
        },

        title: {
          "text": "Pie chart of the times the server was accessed in English or Spanish"
        },
        series: [{
          text: langLabels[0],
          values: [langData[0]],
          backgroundColor: '#F44336',
        },
        {
          text: langLabels[1],
          values: [langData[1]],
          backgroundColor: '#009688',
        }
        ]
      }
    });

    let colors = {
      blue: 'rgba(151,187,205,1)',
      gray: '#EBEBEB',
      grayDark: '#3F3F3F',
    };


    zingchart.render({
      id: 'myChart3',
      height: 400,
      width: '100%',
      data: {
        type: 'bar',
        title: {
          "text": "Average X and Y coordinates for mouse activities"
        },
        backgroundColor: '#FFF',
        plot: {
          backgroundColor2: 'rgba(151,187,205,1)',
          lineColor: 'rgba(151,187,205,1)',
          lineWidth: '2px',
          marker: {
            backgroundColor: 'rgba(151,187,205,1)',
            borderColor: 'white',
            shadow: false,
          },
        },
        scaleX: {
          labels: activityLabels
        },
        plotarea: {
          backgroundColor: 'white',
        },
        series: [{
            values: avgX,
            alpha: 0.5,
            backgroundColor1: 'rgba(220,220,220,1)',
            backgroundColor2: 'rgba(220,220,220,1)',
            borderBottom: '0px',
            borderColor: '#C7C7C7',
            borderTop: '2px solid #C7C7C7',
            borderWidth: '2px',
            lineColor: 'rgba(220,220,220,1)',
            lineWidth: '2px',
            marker: {
              backgroundColor: 'rgba(220,220,220,1)',
            },
          },
          {
            values: avgY,
            alpha: 0.5,
            backgroundColor1: colors.blue,
            backgroundColor2: colors.blue,
            borderBottom: '0px',
            borderColor: colors.blue,
            borderTop: '2px solid ' + colors.blue,
            borderWidth: '2px',
          },
        ],
      }
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