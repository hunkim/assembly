<?php

class Bill {
  var $id;
  var $summary;
  var $title;

  var $result;
  var $by;

  var $proposed;
  var $processed;

  var $titleHTML;
  var $sumHTML;
  var $billHTML;
  var $coActorHTML;

  // 안규백(새정치민주연합/安圭伯)
  function Bill($title, $summary) {
    $this->title = $title;
    $this->summary = $summary;
  }

  function toString() {
    return "I: $this->id T: $this->title\n p: $this->proposed\np:$this->processed b:$this->by, r: $this->result s:$this->summary";
  }


  function exist($db) {
    $result = $db->query("SELECT id FROM HTML WHERE id='". $db->real_escape_string($this->id) ."'");

    return ($result!==false && $result->num_rows > 0);
  }

  function insertHTML($db) {
    if ($this->exist($db)) {
      echo ("$this->id Already there!");
      return;
    }

    $sql = "INSERT IGNORE INTO Bill SET ";
    $sql .= "id='" . $db->real_escape_string($this->id) . "'\n";
    $sql .= ", titleHTML='" . $db->real_escape_string($this->titleHTML) . "'\n";
    $sql .= ", sumHTML='" . $db->real_escape_string($this->sumHTML) . "'\n";
    $sql .= ", billHTML='" . $db->real_escape_string($this->billHTML) . "'\n";
    $sql .= ", titleHTML='" . $db->real_escape_string($this->titleHTML) . "'\n";
    $sql .= ", coActorHTML='" . $db->real_escape_string($this->coActorHTML) . "'\n";
    $sql .= ", by='" . $db->real_escape_string($this->by) . "'\n";
    $sql .= ", result='" . $db->real_escape_string($this->result) . "'\n";
    $sql .= ", proposed='" . $db->real_escape_string($this->proposed) . "'\n";
    $sql .= ", processed='" . $db->real_escape_string($this->processed) . "'\n";
    $sql .= ", collected=now()'\n";

    if ($db->query($sql) === TRUE) {
      echo "New bill record created successfully.\n";
    } else {
      echo "Error: " . $sql . "<br>" . $db->error;
    }
  }

  function insert($db, $id) {
    $this->id = $id;

    $sql = "INSERT IGNORE INTO Bill SET ";
    $sql .= "id='" . $db->real_escape_string($this->id) . "'\n";
    $sql .= ", summary='" . $db->real_escape_string($this->summary) . "'\n";
    $sql .= ", title='" . $db->real_escape_string($this->title) . "'\n";

    if ($db->query($sql) === TRUE) {
      echo "New bill record created successfully.\n";
    } else {
      echo "Error: " . $sql . "<br>" . $db->error;
    }
  }
}

?>
