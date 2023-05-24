<!DOCTYPE html>
<html>
<head>
  <script src="https://cdn.zingchart.com/zingchart.min.js"></script>
</head>
<body>
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
  </script>
</body>
</html>