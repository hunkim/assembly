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
}

?>
