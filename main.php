<?php
error_reporting(E_ALL);
assert_options(ASSERT_BAIL,     true);

include_once 'Actor.php';
include_once 'Bill.php';
include_once 'getCoActor.php';
include_once 'getBill.php';

$db = new mysqli("p:localhost", "trend", "", "assembly");

// Check connection
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

// Perform Query
$result = $db->query("SELECT * from Bill");
if (!$result) {
    $message  = 'Invalid query: ' . $db->error . "\n";
    die($message);
}


if ($result->num_rows <= 0) {
  die($message  = 'no result query: ' . $db->error . "\n");
}

// output data of each row
while($row = $result->fetch_assoc()) {
    $sumHTML = $row['sumHTML'];
    $coActorHTML =  $row['coActorHTML'];
    $id = $row['id'];

    echo ("Working on $id\n");

    $bill = getBill($id, $sumHTML);
    // insert bill to DB
    $bill->update($db);


    $actors = getActors($coActorHTML);

    foreach ($actors as $a) {
        $a->insert($db);
        $a->insertWithBill($db, $id);
    }
}

$db->close();

?>
