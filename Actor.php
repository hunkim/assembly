<?php

class Actor {
  var $id = false;
  var $name="";
  var $cname="";
  var $party="";

  var $is_representative=0;
  var $is_proposer=0;
  var $is_assentient=0;
  var $is_withdrawer=0;

  // 안규백(새정치민주연합/安圭伯)
  function Actor($arr) {
    $this->name = $arr['name_kr'];
    $this->party = $arr['party'];

    // quick Fix for 19
    if($this->party==='민주당') {
      $this->party='새정치민주연합';
      echo("Changed the party name!");
    }
    $this->cname = $arr['name_cn'];
  }

  function toString() {
    return "$this->name($this->cname/$this->party) ($this->is_representative/$this->is_proposer -$this->is_withdrawer)";
  }

  function setId($db) {
    $sql = "SELECT id from Actor where ";
    $sql .= "name_kr='" . $db->real_escape_string(($this->name)) . "'\n";

    // No party and cname, let's search for the same name only
    if ($this->cname !== "" && $this->party !== "") {
      if (($result=$db->query($sql)) === false) {
        echo "Error: " . $sql . "\n" . $db->error;
        exit(-1);
      }

      // if there is only one candidate, replace with existing one with cname and party
      if ($result->num_rows == 1) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
          $this->id = intval($row["id"]);
          echo("We have the actor with the same name: $this->id\n");
          return true;
        }
      }
    }

    // Add cname and party in the query
    $sql .= "AND name_cn='" . $db->real_escape_string(($this->cname)) . "'\n";  
    $sql .= "AND party='" . $db->real_escape_string(($this->party)) . "'\n";


    if (($result=$db->query($sql)) === false) {
      echo "Error: " . $sql . "\n" . $db->error;
      exit(-1);
    }

    // We need only one or 0 results.
    if($result->num_rows > 1) { 
      echo ("Cannot be more than one entry: $sql";
    }
    
    // Not found
    if ($result->num_rows == 0) {
      return false;
    }
    

    while($row = $result->fetch_assoc()) {
      $this->id = intval($row["id"]);
      echo("We have the actor already: $this->id\n");
      return true;
    } 

    return false;
  }

  function insertCoActor($db, $billid) {
    assert($this->id);

    $sql = "INSERT INTO CoActor SET ";
    $sql .= "actorid='" . $db->real_escape_string($this->id) . "'\n";
    $sql .= ", billid='" . $db->real_escape_string($billid) . "'\n";

    $sql .= ", is_representative='" . $db->real_escape_string($this->is_representative) . "'\n";
    $sql .= ", is_assentient='" . $db->real_escape_string($this->is_assentient) . "'\n";
    $sql .= ", is_proposer='" . $db->real_escape_string($this->is_proposer) . "'\n";
    $sql .= ", is_withdrawer='" . $db->real_escape_string($this->is_withdrawer) . "'\n";

    if ($db->query($sql) === TRUE) {
      echo "New coactor record created successfully.\n";
      return true;
    } else {
      echo ("Error: " . $sql . "\n" . $db->error);
      return false;
    }
  }

  function insert($db) {
    // we are done!
    if ($this->setId($db)===true) {
      return;
    }

    $sql = "INSERT INTO Actor SET ";
    $sql .= "name_kr='" . $db->real_escape_string(($this->name)) . "'\n";
    $sql .= ", name_cn='" . $db->real_escape_string(($this->cname)) . "'\n";
    $sql .= ", party='" . $db->real_escape_string(($this->party)) . "'\n";

    if ($db->query($sql) === TRUE) {
      $this->id = $db->insert_id;
      echo "New actor record created successfully. Last inserted ID is: $this->id \n";
    } else {
      die ("Error: " . $sql . "<br>" . $db->error);
    }
  }
}
?>