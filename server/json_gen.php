<?php

header("Access-Control-Allow-Origin: *");
//header("Accept-Encoding: gzip,deflate");
//header("Content-Encoding: gzip");
header("Content-Type: application/json; charset=UTF-8");

$basedir = "/home/ubuntu/assembly-gh/";

include_once 'q_eng.php';

$appnames = ['coact','stat','list'];

$billappnames = ['summary','billactors'];

$restapp=['actor', 'order'];

$optRes=['done', 'ongoing', 'pass', 'all'];
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


// bill id
if (($result=$db->query("SELECT distinct(billid) as id from CoActor")) === false) {
    echo "Error: " . $sql . "\n" . $db->error;
    return false;
}

// bill
while($row = $result->fetch_assoc()) {
   $id = $billGET['bid'] = $row['id'];
   $billGET['debug']=1;

   foreach ($billappnames as $apptype) {
      $dir = "$basedir/api/bill/$id/$apptype/";
      mkdir($dir, 0777, true);

      echo ("Working on $dir...$id\n");
      $ob_file = fopen("$dir/index.json",'w');
      ob_start('ob_file_callback');

      query_engine($apptype, $billGET);
      ob_end_flush();
    }
}


// No argument
foreach ($restapp as $app) {
  $restGet=[];
  $dir = "$basedir/api/$app/";
  mkdir($dir, 0777, true);

  echo ("Working on $dir...\n");
  $ob_file = fopen("$dir/index.json",'w');
  ob_start('ob_file_callback');

  query_engine($app, $restGet);
  ob_end_flush();
}


// get actors
if (($result=$db->query("SELECT id from Actor")) === false) {
    echo "Error: " . $sql . "\n" . $db->error;
    return false;
}

// actor
while($row = $result->fetch_assoc()) {
   $id = $GET['id'] = $row['id'];

   foreach ($appnames as $apptype) {
      foreach ($optRes as $res) {
        $GET['result'] = $res;
        foreach ($optBy as $by) {
          $GET['by'] = $by;
          $dir = "$basedir/api/actor/$id/$apptype/$res/$by/";
          mkdir($dir, 0777, true);

          echo ("Working on $dir...$id\n");
          $ob_file = fopen("$dir/index.json",'w');
          ob_start('ob_file_callback');

          query_engine($apptype, $GET);
          ob_end_flush();
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
