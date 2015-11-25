<?php


if ($argv[0]=='Bill.php') {
  $b = new Bill("","");
  $b->id = "PRC_A1J5J1E1N1K0Q1O4A4V8L1H4C2Q4C9";

  // open DB
  $db = new mysqli("p:localhost", "trend", "", "assembly");
  // Check connection
  if ($db->connect_error) {
      die("Connection failed: " . $db->connect_error);
  }

  $b->insertHTML($db);
}

class Bill {
  var $id;
  var $summary;
  var $title;

  var $result;
  var $proposedby;

  var $proposed;
  var $processed;

  var $titleHTML;
  var $sumHTML;
  var $billHTML;
  var $coActorHTML;

  function Bill($id) {
  $this->id = $id;
  }

  function setTitleSum($title, $summary) {
    $this->title = $title;
    $this->summary = $summary;
  }

  function toString() {
    return "I: $this->id T: $this->titleHTML\n p: $this->proposed\np:$this->processed b:$this->proposedby, r: $this->result s:$this->summary";
  }


  function exist($db) {
    $sql = "SELECT id FROM Bill WHERE id='". $db->real_escape_string($this->id) . "'";
    $result = $db->query($sql);
    return ($result!==false && $result->num_rows > 0);
  }

  function insertHTML($db) {
    if ($this->exist($db)) {
      echo ("$this->id Already there!\n");
      return;
    }

    $sql = "INSERT INTO Bill SET ";
    $sql .= "id='" . $db->real_escape_string($this->id) . "'\n";
    $sql .= ", titleHTML='" . $db->real_escape_string($this->titleHTML) . "'\n";
    $sql .= ", sumHTML='" . $db->real_escape_string($this->sumHTML) . "'\n";
    $sql .= ", billHTML='" . $db->real_escape_string($this->billHTML) . "'\n";
    $sql .= ", coActorHTML='" . $db->real_escape_string($this->coActorHTML) . "'\n";
    $sql .= ", proposedby='" . $db->real_escape_string($this->proposedby) . "'\n";
    $sql .= ", result='" . $db->real_escape_string($this->result) . "'\n";
    $sql .= ", cdate='" . $db->real_escape_string($this->proposed) . "'\n";
    $sql .= ", pdate='" . $db->real_escape_string($this->processed) . "'\n";
    $sql .= ", collected=now();\n";

    if ($db->query($sql) === TRUE) {
      echo "New bill record created successfully.\n";
    } else {
      echo "Error: " . $sql . "<br>" . $db->error;
    }
  }

  function update($db) {
    $this->id = $id;

    $sql = "UPDATE  Bill SET ";
    $sql .= "summary='" . $db->real_escape_string($this->summary) . "'\n";
    $sql .= ", title='" . $db->real_escape_string($this->title) . "'\n";

    $sql .= "WHERE id='" . $db->real_escape_string($this->id) . "';\n";

    echo ($sql);
    if ($db->query($sql) === TRUE) {
      echo "Bill record updated successfully.\n";
    } else {
      echo "Error: " . $sql . "<br>" . $db->error;
    }

    exit();
  }
}

?>
