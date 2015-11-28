<?php

include_once 'Actor.php';

// for testing
if ($argv[0]=='getCoActors.php') {
  $arr = getActors("PRC_A1J5J1E1N1K0Q1O4A4V8L1H4C2Q4C9");
  foreach ($arr as $a) {
    echo ($a->toString() . "\n");
  }
}

function getActors($content) {
  $txt = strip_tags($content);
  $tokens = preg_split('/\s+/', $txt);

  $proposed = 0;
  $actorArr = [];
  foreach ($tokens as $value) {
    echo("[$value]\n");
    if ($value=="발의의원") {
      echo("Here!");
      $proposed = 1;
      continue;
    }

    if ($value=="찬성의원") {
      echo("Agrred!");
      $proposed = 2;
      continue;
    }

    if ($proposed && strpos($value, ')')) {
      $namearr = parse_names($value);

      // Add actors
      foreach ($namearr as $value) {
        if ($value!='') {
          $a = new Actor($proposed, $value);
          $actorArr[] = $a;
        }
      }
    }
  }

  return $actorArr;
}

function parse_names($str) {
  $namearr = explode( ')', $str);

  return $namearr;
}

?>
