<?php

class Actor {
  var $id = flase;
  var $name;
  var $cname;
  var $party;

  // 안규백(새정치민주연합/安圭伯)
  function Actor($str) {
    echo ("Parsing $str\n");
    $arr = explode('(', $str);
    assert(count($arr)==2);

    $this->name = $arr[0];
    $arr2 = explode('/', $arr[1]);
    assert(count($arr2)==2);

    $this->party = $arr2[0];
    $this->cname = $arr2[1];
  }

  function toString() {
    return "$this->name($this->cname/$this->party)";
  }

  function getId($db) {
    $sql = "SELECT id from Actor where ";
    $sql .= "name='" . $db->real_escape_string($this->name) . "'\n";
    $sql .= "AND cname='" . $db->real_escape_string($this->cname) . "'\n";
    $sql .= "AND party='" . $db->real_escape_string($this->party) . "'\n";

    echo $sql;

    if (($result=$db->query($sql)) === TRUE) {
      $this->id = int_val(mysql_fetch_object($result));
      $echo("We have it: $this->id\n");
      return true;
    } else {
      echo "Error: " . $sql . "\n" . $db->error;
      return false;
    }
  }

  function insertWithBill($db, $billid) {
    assert($this->id);

    $sql = "INSERT INTO CoActor SET ";
    $sql .= "actorid='" . $db->real_escape_string($this->id) . "'\n";
    $sql .= ", billid='" . $db->real_escape_string($billid) . "'\n";

    if ($db->query($sql) === TRUE) {
      echo "New coactor record created successfully.\n";
    } else {
      echo "Error: " . $sql . "\n" . $db->error;
    }
  }

  function insert($db) {
    // we are done!
    if ($this->getId($db)===true) {
      return;
    }
    $sql = "INSERT INTO Actor SET ";
    $sql .= "name='" . $db->real_escape_string($this->name) . "'\n";
    $sql .= ", cname='" . $db->real_escape_string($this->cname) . "'\n";
    $sql .= ", party='" . $db->real_escape_string($this->party) . "'\n";

    if ($db->query($sql) === TRUE) {
      $this->id = $db->insert_id;
      echo "New actor record created successfully. Last inserted ID is: $this->id \n";
    } else {
      echo "Error: " . $sql . "<br>" . $db->error;
    }
  }
}

?>
