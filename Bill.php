<?php

class Bill {
  var $id;
  var $summary;
  var $title;

  var $result;
  var $by;

  var $proposed;
  var $processed;

  // 안규백(새정치민주연합/安圭伯)
  function Bill($title, $summary) {
    $this->title = $title;
    $this->summary = $summary;
  }

  function toString() {
    return "T: $this->title\n p: $this->proposed\np:$this->processed b:$this->by, r: $this->result s:$this->summary";
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
