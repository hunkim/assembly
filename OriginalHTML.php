<?php
error_reporting(E_ALL);
assert_options(ASSERT_BAIL,     true);

include 'Bill.php';


if (count($argv) < 2) {
    echo "Usage: $argv[0] <listhtml_dir>\n\n";
    exit;
}

// open DB
$db = new mysqli("p:localhost", "trend", "", "assembly");
// Check connection
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

$path = $argv[1];
$d = dir($argv[1]);
while (false !== ($entry = $d->read())) {
    if(endsWith($entry, ".html")) {
        $billid = process("$path/$entry");
        exit;

        $billid = "PRC_A1J5J1E1N1K0Q1O4A4V8L1H4C2Q4C9";


        if (exist($db, $billid)) {
          echo "$billid is already in our DB!\b";
        } else {
          storeContent($db, $billid);
        }
    }
}

//http://stackoverflow.com/questions/834303/startswith-and-endswith-functions-in-php
function startsWith($haystack, $needle) {
    // search backwards starting from haystack length characters from the end
    return $needle === "" || strrpos($haystack, $needle, -strlen($haystack)) !== FALSE;
}
function endsWith($haystack, $needle) {
    // search forward starting from end minus needle length characters
    return $needle === "" || (($temp = strlen($haystack) - strlen($needle)) >= 0 && strpos($haystack, $needle, $temp) !== FALSE);
}

function process($file) {
  $content = file_get_contents ($file);

  $txt = strip_tags($content);
  $txt = iconv('EUC-KR', 'UTF-8', $content);
  $tokens = preg_split('/\s+/', $txt);

  $billArr = [];
  $bill = false;
  $title = "";
  foreach ($tokens as $line) {
    if (startsWith($line, 'href="javascript:GoDetail(')) {
        if ($bill) {
          // Do something with bill
          echo $bill->toString() ."\n";
          exit();
        }

        $bill = new Bill("","");
        $bill->id = parseBillId($line);
        continue;
    }

    if (!$bill) {
      continue;
    }

    echo ($line . " => " . isDate($line) . "\n");

    if (isDate($line)) {
      if (!$bill->proposed) {
          $bill->proposed = $line;
      } else if (!$bill->processed) {
          $bill->processed = $line;
      }
      continue;
    }

    if (startsWith($line, 'title="')) {
      $title .= $line;
      $titleMode = ttue;
      continue;
    }


    if ($title != "") {
        $title.= $line;
    }

    if (strpos($line, ')">')!==false) {
      $title = "";
      $arr = explode('"', $title);
      if (count($arr)>2) {
        $bill->title = $arr[1];
      }
    }

    switch($line) {
      case '부결':
      case '철회':
      case '대안반영폐기':
      case '수정가결':
      case '원안가결':
        $bill->result = $line;
        break;
      case '위원장':
      case '의원':
      case '정부':
        $bill->by = $line;
        break;

      case '공포':
      case '본회의의결':
    }
  }
  print_r($tokens);
}

//2015-04-30
function isDate($str) {
  return is_numeric(str_replace( '-', '', $str));
}

// [1032] => href="javascript:GoDetail('PRC_D1P4R1J2E3V1C1H4S3J8V2K2F8M4Z7')"
function parseBillId($str) {
  $arr = explode("'", $str);
  print_r($arr);
  if (count($arr)<2) {
    return "";
  }

  return $arr[1];

  return "";
}

function exist($db, $billid) {
  $result = $db->query("SELECT id FROM HTML WHERE id='". $db->real_escape_string($billid) ."'");

  return ($result!==false && $result->num_rows > 0);
}

function storeContent($db, $billid) {
  // http://likms.assembly.go.kr/bill/jsp/CoactorListPopup.jsp?bill_id=PRC_A1J5J1E1N1K0Q1O4A4V8L1H4C2Q4C9
  $courl = "http://likms.assembly.go.kr/bill/jsp/CoactorListPopup.jsp?bill_id=$billid";
  $sumurl = "http://likms.assembly.go.kr/bill/jsp/SummaryPopup.jsp?bill_id=$billid";
  $billurl = "http://likms.assembly.go.kr/bill/jsp/BillDetail.jsp?bill_id=$billid";

  $cocontent = getContentURL($courl);
  if ($cocontent==null) {
    return;
  }

  $sumcontent = getContentURL($sumurl);
  if ($sumcontent==null) {
    return;
  }

  $billcontent = getContentURL($billurl);
  if ($billcontent==null) {
    return;
  }

  $sql = "INSERT INTO HTML SET ";
  $sql .= "id='" . $db->real_escape_string(($billid)) . "'\n";
  $sql .= ", summary='" . $db->real_escape_string(($sumcontent)) . "'\n";
  $sql .= ", coactor='" . $db->real_escape_string(($cocontent)) . "'\n";
  $sql .= ", bill='" . $db->real_escape_string(($billcontent)) . "'\n";

  if ($db->query($sql) === TRUE) {
    echo "New actor record created successfully.\n";
  } else {
    echo "Error: " . $sql . "<br>" . $db->error;
  }
}

// http://likms.assembly.go.kr/bill/jsp/CoactorListPopup.jsp?bill_id=PRC_A1J5J1E1N1K0Q1O4A4V8L1H4C2Q4C9
function getContentURL($url) {
    $ch = curl_init();
    curl_setopt( $ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; rv:1.7.3) Gecko/20041001 Firefox/0.10.1" );
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, true);
    curl_setopt($ch, CURLOPT_URL, $url);

    echo "Connecting ... $url\n";
    if(($content=curl_exec($ch)) === false) {
      echo 'Curl error: ' . curl_error($ch);
      return null;
    }

    curl_close($ch);
    echo "Done!\n";
    return iconv('EUC-KR', 'UTF-8', $content);
}

?>
