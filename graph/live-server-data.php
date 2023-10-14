<?php 
  // Set the JSON header
  header("Content-type: text/json");
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbName = "iot";
  $port = 3306;
  $conn = new mysqli($servername, $username, $password, $dbName, $port);

  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  $sql = "SELECT * FROM sensor ORDER BY id DESC LIMIT 1";
  $result = $conn->query($sql);

  if ($result->num_rows>0){
    while($row=$result->fetch_array()){
          $x = strtotime($row[1])*1000;
          $y = (int)$row[2];
          $z = (int)$row[3];
          $a = (int)$row[4];
    }
    $ret = array($x,$y,$z, $a);
    $ret1 = array($x,$z);
    echo json_encode($ret);
  }

  $conn->close();
?>
