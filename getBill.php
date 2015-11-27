<?php
include_once 'Bill.php';

// Test mode
if ($argv[0]=='getBill.php') {
  $b = getBill("PRC_A1J5J1E1N1K0Q1O4A4V8L1H4C2Q4C9");
  echo ($b->toString());
}

function getBill($id, $content) {
  $txt = strip_tags($content);
  $tokens = preg_split('/\n+/', $txt);

  $idx = 0;
  $title = "";
  $summary = "";
  $start = false;
  foreach ($tokens as $line) {
    $line = trim($line); // let's trim

    if (strpos($line, "제안이유")!==false) {
      $start = true;
    }

    if (!$start) {
      continue;
    }

    if ($line==="" || strpos($line, "제안이유")!==false || strpos($line, "http://")!==false) {
      continue;
    }

    // assume the first text is the title
    if ($idx++==0) {
      $title = $line;
    } else {
      $summary .= "$line\n";
    }
  }

  // 교육기본법 일부개정법률안(1910565) split them
  list($titleOnly, $bid) = explode("(", $title);

  $bill = new Bill($id);
  $bill->bid = intval($bid);

  assert(!$bid);
  assert(!$titleOnly));
  $bill->setTitleSum(trim($titleOnly), trim($summary));
  return $bill;
}
?>
