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
$db = new mysqli("p:localhost", "trend", "", "assembly");

// Check connection
if ($db->connect_error) {
  echo("Connection failed: " . $db->connect_error);
  exit(0);
}

$db->set_charset("utf8");

if (($result=$db->query("SELECT id from Actor")) === false) {
    echo "Error: " . $sql . "\n" . $db->error;
    return false;
}


if ($result->num_rows == 1) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
       $id = $GET['id'] = $row['id'];

       foreach ($appnames as $apptype) {
          foreach ($optRes as $res) {
            $GET['result'] = $res;
            foreach ($optBy as $by) {
              $GET['by'] = $by;
              $dir = "./api/$id/$res/$by/";
              mkdir($dir);
              $ob_file = fopen("$dir/index.json",'w');
              ob_start('ob_file_callback');

              query_engine($apptype, $GET);
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
