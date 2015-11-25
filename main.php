<?php

include 'Actor.php';
include 'Bill.php';
include 'getCoActor.php';
include 'getBill.php';


// Need to get it from somewhere
$billId = "PRC_A1J5J1E1N1K0Q1O4A4V8L1H4C2Q4C9"

$bill = getBill($billId);

// open DB
$db = new mysqli("p:localhost", "trend", "only!trend!", "assembly");
// Check connection
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

// insert bill to DB
$bill->insert($db);

$actors = getActors($billId);

foreach ($actors as $a) {
  $a->insert($db);
  $a->insertWithBill($db, $bill->id);
}

$db->close();
?>
