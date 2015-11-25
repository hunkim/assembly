<?php

include 'Actor.php';

// http://likms.assembly.go.kr/bill/jsp/CoactorListPopup.jsp?bill_id=PRC_A1J5J1E1N1K0Q1O4A4V8L1H4C2Q4C9
$url = "http://likms.assembly.go.kr/bill/jsp/SummaryPopup.jsp?bill_id=";
$build = "PRC_A1J5J1E1N1K0Q1O4A4V8L1H4C2Q4C9";


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
exit(0);
} else {
$content = file_get_contents ("bill.html");
}

$txt = strip_tags($content);
$tokens = preg_split('/\n+/', $txt);

$idx = 0;
$title = "";
$summary = "";
foreach ($tokens as $line) {
  if ($line=="" || strpos($line, "제안이유 및 주요내용") || strpos($line, "http://")) {
    continue;
  }

  // assume the first text is the title
  if ($idx++==0) {
    $title = $line;
  } else {
    $summary .= "line\n";
  }
}

echo("Title: $title\n");
echo("Summary: $summary");

?>
