<?php
  require 'database.php';

  if (!empty($_POST)) {
    $id = $_POST['id'];
    $suhu = $_POST['suhu'];
    $ph = $_POST['ph'];
    $salinitas = $_POST['salinitas'];
//...
    date_default_timezone_set("Asia/Jakarta");
    $tm = date("H:i:s");
    $dt = date("Y-m-d");
    //........................................
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //
    $sql = "UPDATE esp32_table_update SET suhu = ?, ph = ?, salinitas = ?, time = ?, date = ? WHERE id = ?";
    $q = $pdo->prepare($sql);
    $q->execute(array($suhu,$ph,$salinitas,$tm,$dt,$id));
    Database::disconnect();
    //........................
    $id_key;
    $board = $_POST['id'];
    $found_empty = false;

    $pdo = Database::connect();

    while ($found_empty == false) {
      $id_key = generate_string_id(10);

      $sql = 'SELECT * FROM esp32_table_record WHERE id="' . $id_key . '"';
      $q = $pdo->prepare($sql);
      $q->execute();

      if (!$data = $q->fetch()) {
        $found_empty = true;
      }
    }
 

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$sql = "INSERT INTO esp32_table_record (id,board,suhu,ph,salinitas,time,date) values(?, ?, ?, ?, ?, ?, ?, ?, ?)";
		$q = $pdo->prepare($sql);
		$q->execute(array($id_key,$board,$suhu,$ph,$salinitas,$tm,$dt));

    Database::disconnect();
  }

  function generate_string_id($strength = 16) {
    $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $input_length = strlen($permitted_chars);
    $random_string = '';
    for($i = 0; $i < $strength; $i++) {
      $random_character = $permitted_chars[mt_rand(0, $input_length - 1)];
      $random_string .= $random_character;
    }
    return $random_string;
  }

?>