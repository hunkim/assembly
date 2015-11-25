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

  // 안규백(새정치민주연합/安圭伯)
  function Bill($title, $summary) {
    $this->title = $title;
    $this->summary = $summary;
  }

  function toString() {
    return "I: $this->id T: $this->title\n p: $this->proposed\np:$this->processed b:$this->by, r: $this->result s:$this->summary";
  }


  function exist($db) {
    $sql = "SELECT id FROM HTML WHERE id='". $db->real_escape_string($this->id) . "'";
    $result = $db->query($sql);
    echo ($sql);
    return ($result!==false && $result->num_rows > 0);
  }

  function insertHTML($db) {
    if ($this->exist($db)) {
      echo ("$this->id Already there!");
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
