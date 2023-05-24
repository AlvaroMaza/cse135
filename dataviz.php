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
        echo $info['loadStartTime'] . ',';
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
  "type": "bar",
  "title": {
    "text": "Change me please!"
  },
  "plot": {
    "value-box": {
      "text": "%v"
    },
    "tooltip": {
      "text": "%v"
    }
  },
  "legend": {
    "toggle-action": "hide",
    "header": {
      "text": "Legend Header"
    },
    "item": {
      "cursor": "pointer"
    },
    "draggable": true,
    "drag-handler": "icon"
  },
  "scale-x": {
    "values": [
      "1",
      "2",
      "3",
      "4",
      "5",
      "6",
      "7",
    ]
  },
  "series": [
    {
      "values": myData,
      "text": "apples"
    },
    {
      "values": myLabels,
      "text": "oranges"
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