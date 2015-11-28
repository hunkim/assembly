<?php
error_reporting(E_ALL);
assert_options(ASSERT_BAIL,     true);

$db = new mysqli("p:localhost", "trend", "", "assembly");

// Check connection
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

$db->set_charset("utf8");

$sql = "SELECT id, name from Actor where cname='' AND party=''";

if (($result=$db->query($sql)) === false) {
      echo "Error: " . $sql . "\n" . $db->error;
      return false;
}

$noparty=[];

if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    $noparty[] = $row;
  }
}

print_r ($noparty);
foreach ($noparty as $act) {
    $id = getOneId($db, $act['name']);

    if ($id != -1) {
      
    }
}


function getOneId($db, $name) {
  $sql = "SELECT id, name, party, cname from Actor where name='" . $name . "' AND cname<>'' AND party<>''";

  if (($result=$db->query($sql)) === false) {
      echo "Error: " . $sql . "\n" . $db->error;
      return false;
  }

    $id = "";

  if ($result->num_rows == 1) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
      echo ("$name \n");
     // print_r($row);
      $id = $row['id'];
    }

    return $id;
  } else {
    echo "[!!] $result->num_rows";
  }
return -1;
}


?>
