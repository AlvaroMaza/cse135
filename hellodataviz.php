<!DOCTYPE html>
<html>
 
<head>
  <meta charset="utf-8">
  <title>ZingSoft Demo</title>
 
  <script nonce="undefined" src="https://cdn.zingchart.com/zingchart.min.js"></script>


</head>
 
<body>

    <?php
      /* Open connection to "rest" MySQL database. */
      $mysqli = new mysqli("localhost", "sammy", "realmadrid", "rest");
      
      /* Check the connection. */
      if (mysqli_connect_errno()) {
          printf("Connect failed: %s\n", mysqli_connect_error());
          exit();
      }
      
      /* Fetch result set from static table */
      $data=mysqli_query($mysqli, "SELECT * FROM static");
      echo $data
    ?>
  
</body>
 
</html>