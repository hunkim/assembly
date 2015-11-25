<?php

class Bill {
  var $id;
  var $summary;
  var $title;

  // 안규백(새정치민주연합/安圭伯)
  function Bill($title, $summary) {
    $this->title = $title;
    $this->summary = $summary;
  }

  function toString() {
    return "$this->title\n$this->summary";
  }

  function insert($db) {
    $sql = "INSERT IGNORE INTO Bill SET ";
    $sql .= "summary='" . $db->real_escape_string($this->summary) . "'\n";
    $sql .= ", title='" . $db->real_escape_string($this->title) . "'\n";

    if ($db->query($sql) === TRUE) {
      echo "New bill record created successfully.\n";
    } else {
      echo "Error: " . $sql . "<br>" . $db->error;
    }
  }
}

?>
