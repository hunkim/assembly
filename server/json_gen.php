<?php

header("Access-Control-Allow-Origin: *");
//header("Accept-Encoding: gzip,deflate");
//header("Content-Encoding: gzip");
header("Content-Type: application/json; charset=UTF-8");

$basedir = "/home/ubuntu/assembly-gh/";

include_once 'q_eng.php';

$appnames = ['coact','stat','list'];

$billappnames = ['summary','billactors'];

$rest=['actor'];

$optapp=['order'];

$optRes=['done', 'ongoing', 'pass', 'all'];
$optBy=['rep','co'];

// Persistent Connections
// http://stackoverflow.com/questions/3332074/what-are-the-disadvantages-of-using-persistent-connection-in-pdo
// http://www.php.net/manual/en/mysqli.persistconns.php
$db = new mysqli("p:localhost", "trend", "", "assembly");

// Check connection
if ($db->connect_error) {
  echo("Connection failed: " . $db->connect_error);
  exit(-1);
}

$db->set_charset("utf8");

// No argument, but opt
foreach ($optapp as $apptype) {
  foreach ($optRes as $res) {
    $GET['result'] = $res;
    foreach ($optBy as $by) {
      $GET['by'] = $by;
      $dir = "$basedir/api/$apptype/$res/$by/";
      
      if (!is_dir($dir)) {
        mkdir($dir, 0777, true);
      }

      echo ("Working on $dir...\n");
      $ob_file = fopen("$dir/index.json",'w');
      ob_start('ob_file_callback');

      query_engine($apptype, $GET);
      ob_end_flush();
      checkJSon("$dir/index.json");
    }
  }
}

// bill id
if (($result=$db->query("SELECT distinct(billid) as id from CoActor")) === false) {
    echo "Error: " . $sql . "\n" . $db->error;
    return false;
}

// bill
while($row = $result->fetch_assoc()) {
   $id = $billGET['bid'] = $row['id'];
   //$billGET['debug']=1;

   foreach ($billappnames as $apptype) {
      $dir = "$basedir/api/bill/$id/$apptype/";

      if (!is_dir($dir)) {
        mkdir($dir, 0777, true);
      }

      echo ("Working on $dir...$id\n");
      $ob_file = fopen("$dir/index.json",'w');
      ob_start('ob_file_callback');

      query_engine($apptype, $billGET);
      ob_end_flush();

      checkJSon("$dir/index.json");
    }
}


// No argument
foreach ($restapp as $app) {
  $restGet=[];
  $dir = "$basedir/api/$app/";

  if (!is_dir($dir)) {
    mkdir($dir, 0777, true);
  }

  echo ("Working on $dir...\n");
  $ob_file = fopen("$dir/index.json",'w');
  ob_start('ob_file_callback');

  query_engine($app, $restGet);
  ob_end_flush();

  checkJSon("$dir/index.json");
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
          
          if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
          }

          echo ("Working on $dir...$id\n");
          $ob_file = fopen("$dir/index.json",'w');
          ob_start('ob_file_callback');

          query_engine($apptype, $GET);
          ob_end_flush();
          checkJSon("$dir/index.json");
        }
      }
   }
}








function ob_file_callback($buffer)
{
  global $ob_file;
  fwrite($ob_file,$buffer);
}

function checkJSon($file) {
  $str = file_get_contents($file);
  $json = json_decode($str, true);

  switch (json_last_error()) {
    case JSON_ERROR_NONE:
      echo("$file Sucess!\n");
      return;
    break;
    case JSON_ERROR_DEPTH:
        echo ' - Maximum stack depth exceeded';
    break;
    case JSON_ERROR_STATE_MISMATCH:
        echo ' - Underflow or the modes mismatch';
    break;
    case JSON_ERROR_CTRL_CHAR:
        echo ' - Unexpected control character found';
    break;
    case JSON_ERROR_SYNTAX:
        echo ' - Syntax error, malformed JSON';
    break;
    case JSON_ERROR_UTF8:
        echo ' - Malformed UTF-8 characters, possibly incorrectly encoded';
    break;
    default:
        echo ' - Unknown error';
    break;
  }

  exit(-2);
}


?>
