<?php

class Actor {
  var $edible;
  var $color;

  // 안규백(새정치민주연합/安圭伯)
  function Vegetable($str) {
    echo ("Parsing $str\n");
    $arr = preg_split('/\/)/', $str);
    print_r($arr);
  }
}

?>
