<!DOCTYPE html>
<html>
<head>
  <title>CSE 135 - Spain</title>
  <link rel = "icon" href = "images/crown-solid.svg">
  <script src="https://cdn.zingchart.com/zingchart.min.js"></script>
</head>
<body>

  <div id="myChart2"></div>
  <div id="myChart3"></div>
  <div id="myChart4"></div>

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

  var shiftData = [
    <?php
    $shiftdata = mysqli_query($mysqli,
     "SELECT keyValue, COUNT(*) FROM keyboardactivity WHERE shiftKey = 1 AND keyValue IN ('a', 'e', 'i', 'o', 'u') GROUP BY keyValue;");

    while ($shiftinfo = mysqli_fetch_array($shiftdata)) {
          echo  $shiftinfo['COUNT(*)'] . ',';
    }
    ?>
  ];

  var ctrlData = [
    <?php
    $ctrlsdata = mysqli_query($mysqli,
     "SELECT keyValue, COUNT(*) FROM keyboardactivity WHERE ctrlKey = 1 AND keyValue IN ('a', 'e', 'i', 'o', 'u') GROUP BY keyValue;");

    while ($crtlinfo = mysqli_fetch_array($ctrlsdata)) {
          echo  $crtlinfo['COUNT(*)'] . ',';
    }
    ?>
  ];

  var altData = [
    <?php
    $altdata = mysqli_query($mysqli,
     "SELECT keyValue, COUNT(*) FROM keyboardactivity WHERE altKey = 1 AND keyValue IN ('a', 'e', 'i', 'o', 'u') GROUP BY keyValue;");

    while ($altinfo = mysqli_fetch_array($altdata)) {
          echo  $altinfo['COUNT(*)'] . ',';
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

 
    zingchart.render({
      id: 'myChart4',
      height: 400,
      width: "100%",
      data: {
      type: "line",
      title: {
        "text": "Nº of times Ctrl (red), Shift (blue) or Alt (green) is pressed for each vowel"
        },
      scaleX: {
        labels: [
          "a",
          "e",
          "i",
          "o",
          "u"
        ]
      },
      series: [{
        "values": shiftData
      }, {
        "values": ctrlData
      }, {
        "values": altData
      }]
    }
    });
  });
  </script>
</body>
</html>