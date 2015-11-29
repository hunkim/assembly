<?php
error_reporting(E_ALL);
assert_options(ASSERT_BAIL,     true);

if (count($argv) < 2) {
    echo "Usage: $argv[0] <authorjsonfiler>\n\n";
    exit;
}

$db = new mysqli("localhost", "trend", "", "assembly");

// Check connection
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

// Set utf8
$db->set_charset("utf8");

// Read json
$str = file_get_contents($argv[1]);
$json = json_decode($str, true);

$tableName = "Actor";

// Drop table
if ($db->query("DROP TABLE $tableName") === FALSE) {
  echo ("Error: Drop\n" . $db->error);
  return false;
}

// Create table sequence
$sqlCreateTable = createTableSQL($db, $tableName, $json[0]);

echo $sqlCreateTable;

// Create table
if ($db->query($sqlCreateTable) === FALSE) {
  echo ("Error: " . $sqlCreateTable . "\n" . $db->error);
  return false;
}

foreach ($json as $actor) {
  echo ("Adding " . $actor['name_kr'] . "\n");
  insert($db, $tableName, $actor);
}
//readJson('1904016.json', $db);

function createTableSQL($db, $tname, $actor) {
  $sql = "CREATE TABLE $tname (id int NOT NULL AUTO_INCREMENT ";


  foreach ($actor as $key=>$val) {
    $sql.= ", $key varchar(255)";
  }

  $sql .=",PRIMARY KEY (id)) ENGINE = MYISAM;";

  return $sql;
}

function insert($db, $tname, $actor) {
  $sql = "INSERT INTO $tname SET ";

  $idx = 0;
  foreach ($actor as $key=>$val) {
    if ($idx++!=0) {
      $sql .= ",";
    }

    $sql.= "$key='" .  $db->real_escape_string($val) . "'";
  }

  // Create table
  if ($db->query($sql) === FALSE) {
    echo ("Error: " . $sql . "\n" . $db->error);
    return false;
  }


  return true;
}

?>