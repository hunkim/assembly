<?php

header("Access-Control-Allow-Origin: *");
//header("Accept-Encoding: gzip,deflate");
//header("Content-Encoding: gzip");
header("Content-Type: application/json; charset=UTF-8");

include_once 'q_eng.php';

$appnames = ['coact','stat','list', 'all', 'summary','order', 'actor'];
$optRes=['done', 'onging', 'pass'];
$optBy=['rep','co'];

// Persistent Connections
// http://stackoverflow.com/questions/3332074/what-are-the-disadvantages-of-using-persistent-connection-in-pdo
// http://www.php.net/manual/en/mysqli.persistconns.php
$conn = new mysqli("p:localhost", "trend", "", "assembly");

// Check connection
if ($conn->connect_error) {
  echo("Connection failed: " . $conn->connect_error);
  exit(0);
}

$conn->set_charset("utf8");

if (($result=$db->query("SELECT id from Actor")) === false) {
    echo "Error: " . $sql . "\n" . $db->error;
    return false;
}


if ($result->num_rows == 1) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
       $id = $GET['id'] = $row['id'];

       foreach ($appnames as $value) {
          foreach ($optRes as $res) {
            $GET['result'] = $res;
            foreach ($optBy as $by) {
              $GET['by'] = $by;

              $ob_file = fopen("./api/$id/$res/$by/index.json",'w');
              ob_start('ob_file_callback');

              query_engine($apptype, $_GET);
            }
          }
       }
    }
}


function ob_file_callback($buffer)
{
  global $ob_file;
  fwrite($ob_file,$buffer);
}




?>
