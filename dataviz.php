<?php
$mysqli = new mysqli("localhost", "sammy", "realmadrid", "rest");

if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

$data = mysqli_query($mysqli, "SELECT * FROM static");

/* Create JavaScript objects from the data */
?>

<script>
var myData = [
  <?php
  while ($info = mysqli_fetch_array($data)) {
      echo $info['f_data'] . ',';
  }
  ?>
];

var myLabels = [
  <?php
  $data = mysqli_query($mysqli, "SELECT * FROM static");
  while ($info = mysqli_fetch_array($data)) {
      echo '"' . $info['f_name'] . '",';
  }
  ?>
];
</script>

<?php
$mysqli->close();
?>

<script>
// Use the myData and myLabels arrays
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