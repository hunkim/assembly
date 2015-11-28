<?php
error_reporting(E_ALL);
assert_options(ASSERT_BAIL,     true);

include_once 'Bill.php';
include_once 'Actor.php';

if (count($argv) < 2) {
    echo "Usage: $argv[0] <json_dir>\n\n";
    exit;
}

$db = new mysqli("p:localhost", "trend", "", "assembly");

// Check connection
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

//readJson('1904016.json', $db);

$dir = $argv[1];
$d = dir($dir);
while (false !== ($entry = $d->read())) {
  if(!is_dir("$dir/$entry") && endsWith($entry, ".json")) {
    readJson("$dir/$entry", $db);
  }
}

function readJson($jsonfile, $db) {
  $str = file_get_contents($jsonfile);
  $json = json_decode($str, true);
  //print_r ($json);

  $bill = new Bill($json);

  print $bill->toString();

  // Let's skip ZZ
  if (startsWith($bill->id, 'ZZ') {
    return;
  }

  assert($bill->link_id!=="", "Bill ID Needed for $entry!");
  $bill->insert($db);


  // Let's work on the actors
  foreach ($json['proposers'] as $a) {
      $actor = new Actor($a);
      $actor->is_proposer = 1;
      $actor->is_representative = is_representative($actor->name, $json['status_infos']);
      $actor->insert($db);
      $actor->insertCoActor($db, $bill->id);

      print $actor->toString() . "\n";
    }

    foreach ($json['withdrawers'] as $a) {
      $actor = new Actor($a);
      $actor->is_withdrawer = 1;
      $actor->insert($db);
      $actor->insertCoActor($db, $bill->id);

      print $actor->toString() . "\n";
    }
}

/*
[status_infos] => Array
(
    [0] => Array
    (
        [0] =>  의 안 번 호 : 1904016
        [1] =>  제   안   자 : 이한성의원 등 10인
        [2] =>  제 안 일 자 : 2013-03-08
    )
*/
function is_representative($name, $status_info) {
    foreach ($status_info as $info) {
      foreach ($info as $value) {
        if (strpos($value, "제   안   자") !== false) {
          if( strpos($value,$name) !== false) {
            return true;
          }
        }
      }
    }
    return false;
}

//http://stackoverflow.com/questions/834303/startswith-and-endswith-functions-in-php
function startsWith($haystack, $needle) {
    // search backwards starting from haystack length characters from the end
    return $needle === "" || strrpos($haystack, $needle, -strlen($haystack)) !== FALSE;
}

function endsWith($haystack, $needle) {
    // search forward starting from end minus needle length characters
    return $needle === "" || (($temp = strlen($haystack) - strlen($needle)) >= 0 && strpos($haystack, $needle, $temp) !== FALSE);
}


function _test() {
  _test_is_representative();
}

function _test_is_representative() {
  $status_info= [['의 안 번 호 : 1904016', '제   안   자 : 이한성의원 등 10인', '제 안 일 자 : 2013-03-08']];
  assert(is_representative('김성훈', $status_info)===false, '김성훈 not in');
  assert(is_representative('이한성', $status_info)===true, '이한성 in');
}
?>
