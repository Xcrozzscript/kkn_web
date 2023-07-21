<?php
  include 'database.php';

  if (!empty($_POST)) {

    $id = $_POST['id'];

    $myObj = (object)array();
    $pdo = Database::connect();

    $sql = 'SELECT * FROM esp32_table_update WHERE id="' . $id . '"';
    foreach ($pdo->query($sql) as $row) {
      $date = date_create($row['date']);
      $dateFormat = date_format($date,"d-m-Y");
      
      $myObj->id = $row['id'];
      $myObj->suhu = $row['suhu'];
      $myObj->ph = $row['ph'];
      $myObj->salinitas = $row['salinitas'];
      $myObj->ls_time = $row['time'];
      $myObj->ls_date = $dateFormat;

      $myJSON = json_encode($myObj);

      echo $myJSON;
    }
    Database::disconnect();
  }
?>