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

/*
assembly_id int,
id  int NOT NULL UNIQUE,
link_id varchar(255) NOT NULL UNIQUE,
title varchar(255),

summary TEXT,

proposed_date DATE,
decision_date DATE,
collected_date DATE,

represent_actor int,

withdrawer_count int,
actor_count int,

proposer_type varchar(255),
status varchar(255),
PRIMARY KEY (id)
*/
class Bill {
  var $id; // key to get others
  var $link_id;
  var $assembly_id;
  var $title;
  var $summary;

  var $proposed_date;
  var $decision_date;
  var $collected_date;

  var $withdrawer_count;
  var $actor_count;

  var $proposer_type;
  var $status;
  var $status_detail;

  function Bill($json) {
    $this->id = $json['bill_id'];
    $this->link_id = $json['link_id'];
    $this->assembly_id = $json['assembly_id'];

    $this->title = $json['title'];
    $this->summary = implode(" ", $json['summaries']);

    $this->proposed_date = $json['proposed_date'];
    $this->decision_date = $json['decision_date'];
    //$this->collected_date = mysqlnow

    $this->withdrawer_count = count($json['withdrawers']);
    $this->actor_count = count($json['proposers']);

    $this->proposer_type = $json['proposer_type'];
    $this->status = $json['status'];
    $this->status_detail = $json['status_detail'];
  }

  function toString() {
      return "I: $this->id ($this->link_id)\n".
            "\tT: $this->title\n".
            "\tP: $this->proposed_date and $this->decision_date\n".
            "\tA: $this->actor_count (- $this->withdrawer_count)\n".
            "\tP: $this->proposer_type\n".
            "\tR: $this->status ($this->status_detail)\n".
            "\tS:$this->summary";
  }


  function exist($db) {
    $sql = "SELECT id FROM Bill WHERE id='". $db->real_escape_string($this->id) . "'";
    $result = $db->query($sql);
    return ($result!==false && $result->num_rows > 0);
  }

  function insert($db) {
    if ($this->exist($db)) {
      echo ("Bill [$this->id] is already there!\n");
      return;
    }

    $sql = "INSERT INTO Bill SET ";
    $sql .= "id='" . $db->real_escape_string($this->id) . "'\n";
    $sql .= ", link_id='" . $db->real_escape_string($this->link_id) . "'\n";
    $sql .= ", assembly_id='" . $db->real_escape_string($this->assembly_id) . "'\n";

    $sql .= ", title='" . $db->real_escape_string($this->title) . "'\n";
    $sql .= ", summary='" . $db->real_escape_string($this->summary) . "'\n";

    $sql .= ", actor_count='" . $db->real_escape_string($this->actor_count) . "'\n";
    $sql .= ", withdrawer_count='" . $db->real_escape_string($this->withdrawer_count) . "'\n";

    $sql .= ", proposer_type='" . $db->real_escape_string($this->proposer_type) . "'\n";
    $sql .= ", status='" . $db->real_escape_string($this->status) . "'\n";
    $sql .= ", status_detail='" . $db->real_escape_string($this->status_detail) . "'\n";

    $sql .= ", proposed_date='" . $db->real_escape_string($this->proposed_date) . "'\n";
    $sql .= ", decision_date='" . $db->real_escape_string($this->decision_date) . "'\n";
    $sql .= ", collected_date=now();\n";

    if ($db->query($sql) === TRUE) {
      echo "New bill record created successfully.\n";
    } else {
      die ("Error: " . $sql . "\n" . $db->error);
    }
  }
}

?>
