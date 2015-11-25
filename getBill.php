<?php

include_once 'Bill.php';

if ($argv[0]=='getBill.php') {
  $b = getBill("PRC_A1J5J1E1N1K0Q1O4A4V8L1H4C2Q4C9");
  echo ($b->toString());
}

function getBill($billId) {
  // http://likms.assembly.go.kr/bill/jsp/CoactorListPopup.jsp?bill_id=PRC_A1J5J1E1N1K0Q1O4A4V8L1H4C2Q4C9
  $url = "http://likms.assembly.go.kr/bill/jsp/SummaryPopup.jsp?bill_id=";
  //.DS_Store$build = "PRC_A1J5J1E1N1K0Q1O4A4V8L1H4C2Q4C9";


  if (false) {
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
    $content = file_get_contents ("bill.html");
  }

  $txt = strip_tags($content);
  $tokens = preg_split('/\n+/', $txt);

  $idx = 0;
  $title = "";
  $summary = "";
  foreach ($tokens as $line) {
    $line = trim($line); // let's trim

    if ($line=="" || strpos($line, "제안이유")!==false || strpos($line, "http://")!==false) {
      continue;
    }

    // assume the first text is the title
    if ($idx++==0) {
      $title = $line;
    } else {
      $summary .= "$line\n";
    }
  }

  $bill = new Bill($title, $summary);
  return $bill;
}
?>
