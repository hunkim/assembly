<?php

class Actor {
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
    return "$name($cname/$party)";
  }
}

?>
