<!DOCTYPE html>
<html>
<head>
  <script src="https://cdn.zingchart.com/zingchart.min.js"></script>
</head>
<body>
  <h1>MyChart</h1>
  <div id="myChart"></div>

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
  </script>

  <?php
  $mysqli->close();
  ?>

  <script>
  window.addEventListener('load', function() {
    let chartConfig = {
      type: 'line',
      title: {
        text: 'Click On Node To Freeze The tooltip'
      },
      subtitle: {
        text: 'Click and drag label vertically.'
      },
      plot: {
        tooltip: {
          visible: false
        },
        cursor: 'hand'
      },
      scaleX: {
        markers: [],
        offsetEnd: '75px',
        labels: ['1','2','3','4','5','6','7']
      },
      crosshairX: {},
      series: [{
          text: 'Apple Sales',
          values: myData
        },
        {
          text: 'Peach Sales',
          values: myLabels
        }
      ]
    };

    zingchart.render({
      id: 'myChart',
      data: chartConfig,
      height: '100%',
      width: '100%',
    });
  });

  
  </script>
</body>
</html>