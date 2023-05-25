<!DOCTYPE html>
<html>
<head>
  <script src="https://cdn.zingchart.com/zingchart.min.js"></script>
</head>
<body>
  <div id="myChart"></div>
  <div id="myChart2"></div>
  <div id="myChart3"></div>
  <div id="myChart4"></div>

  <?php
  $mysqli = new mysqli("localhost", "sammy", "realmadrid", "rest");

  if (mysqli_connect_errno()) {
      printf("Connect failed: %s\n", mysqli_connect_error());
      exit();
  }

  $data = mysqli_query($mysqli, "SELECT * FROM performance");
  ?>

  <script>
  var myData = [
    <?php
    while ($info = mysqli_fetch_array($data)) {
        echo $info['loadEndTime'] . ',';
    }
    ?>
  ];

  var myLabels = [
    <?php
    $data = mysqli_query($mysqli, "SELECT * FROM performance");
    while ($info = mysqli_fetch_array($data)) {
        echo '"' . $info['loadStartTime'] . '",';
    }
    ?>
  ];

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
      id: "myChart",
      width: "100%",
      height: 400,
      data: {
        type: 'bar',
        title: {
          text: "Data Pulled from MySQL Database"
        },
        'scale-x': {
          labels: myLabels
        },
        series: [{
          values: myData
        }]
      }
    });
  });

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
          "text": "A Pie Chart"
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

    var myConfig = 
 
    zingchart.render({
      id: 'myChart4',
      height: 400,
      width: "100%",
      data: {
      type: "line",
      series: [{
        "values": [20, 40, 25, 50, 15, 45, 33, 34]
      }, {
        "values": [5, 30, 21, 18, 59, 50, 28, 33]
      }, {
        "values": [30, 5, 18, 21, 33, 41, 29, 15]
      }]
    }
    });
  </script>
  </script>
</body>
</html>