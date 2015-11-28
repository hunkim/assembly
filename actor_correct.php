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

?>
