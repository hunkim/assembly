<?php
error_reporting(E_ALL);
assert_options(ASSERT_BAIL,     true);

include 'Actor.php';
include 'Bill.php';
include 'getCoActor.php';
include 'getBill.php';

// Need to get it from somewhere
$billid = "PRC_A1J5J1E1N1K0Q1O4A4V8L1H4C2Q4C9";

$bill = getBill($billid);

// open DB
$db = new mysqli("p:localhost", "trend", "", "assembly");
// Check connection
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

// insert bill to DB
$bill->insert($db, $billid);

$actors = getActors($billid);

foreach ($actors as $a) {
  $a->insert($db);
  $a->insertWithBill($db, $bill->id);
}

$db->close();
?>
