<?php

include_once 'Actor.php';

// for testing
if ($argv[0]=='getCoActors.php') {
  $arr = getActors("PRC_A1J5J1E1N1K0Q1O4A4V8L1H4C2Q4C9");
  foreach ($arr as $a) {
    echo ($a->toString() . "\n");
  }
}

function getActors($billid) {
  // http://likms.assembly.go.kr/bill/jsp/CoactorListPopup.jsp?bill_id=PRC_A1J5J1E1N1K0Q1O4A4V8L1H4C2Q4C9
  $url = "http://likms.assembly.go.kr/bill/jsp/CoactorListPopup.jsp?bill_id=";
  $build = "PRC_A1J5J1E1N1K0Q1O4A4V8L1H4C2Q4C9";


  if (FALSE) {
    $ch = curl_init();
    curl_setopt( $ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; rv:1.7.3) Gecko/20041001 Firefox/0.10.1" );
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_URL, ($url . $build));

    $content = curl_exec($ch);
    curl_close($ch);
    echo $url . $build;
    echo iconv('EUC-KR', 'UTF-8', $content);
  } else {
    $content = file_get_contents ("co.html");
  }

  $txt = strip_tags($content);
  $tokens = preg_split('/\s+/', $txt);

  $proposed = FALSE;
  foreach ($tokens as $value) {
    echo("[$value]\n");
    if ($value=="발의의원") {
      echo("Here!");
      $proposed = TRUE;
      continue;
    }

    if ($value=="찬성의원") {
      echo("Agrred!");
      $proposed = FALSE;
      continue;
    }

    if ($proposed && strpos($value, ')')) {
      $namearr = parse_names($value);
    }
  }

  $actorArr = [];
  foreach ($namearr as $value) {
    if ($value!='') {
      $a = new Actor($proposed, $value);
      $actorArr[] = $a;
    }
  }

  return $actorArr;
}

function parse_names($str) {
  $namearr = explode( ')', $str);

  return $namearr;
}

?>
