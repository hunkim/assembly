<?php

// http://likms.assembly.go.kr/bill/jsp/CoactorListPopup.jsp?bill_id=PRC_A1J5J1E1N1K0Q1O4A4V8L1H4C2Q4C9
$url = "http://likms.assembly.go.kr/bill/jsp/CoactorListPopup.jsp?bill_id=";
$build = "PRC_A1J5J1E1N1K0Q1O4A4V8L1H4C2Q4C9";


$ch = curl_init();

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HEADER, false);
curl_setopt($ch, CURLOPT_URL, ($url . $build));

$content = curl_exec($ch);
curl_close($ch);

echo $content;

?>
