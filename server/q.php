<?php

header("Access-Control-Allow-Origin: *");
//header("Accept-Encoding: gzip,deflate");
//header("Content-Encoding: gzip");
header("Content-Type: application/json; charset=UTF-8");

// Get app name
$apptype = substr($_SERVER['PATH_INFO'], 1);

if (!$apptype) {
  exit(0);
}

$optQuery = " ";
foreach ($_GET as $key => $value) {
  if ($value==0) {
    continue;
  }

  switch($key) {
    case 'done':
      $optQuery .= " and b.status='처리' ";
      break;

    case 'ongoing':
      $optQuery .= " and b.status='계류' ";
      break;

    case 'pass':
      $optQuery .= " and (b.status_detail='의결' or b.status_detail='공포' or b.status_detail='정부이송') ";
      break;

    case 'representative':
      $optQuery .= " and c.is_representative=1 ";
      break;

  }
  # code...
}

$json = '[{}]';

// Basic information SQL
switch($apptype) {
  case 'coact':
   $sql = "select name, cname, party, actorid as id, count(actorid) c from CoActor c ".
          " inner join Actor a on a.id=actorid inner join  (select distinct(billid) from CoActor ".
          " where actorid = ?) x on x.billid=c.billid group by actorid order by c desc limit 11;";
    break;
  case 'stat':
    $sql = "select count(*) as c, YEAR(proposed_date) as y, MONTH(proposed_date) as m from CoActor c ";
    $sql .= " INNER JOIN Bill b on b.id = c.billid INNER Join Actor a on a.id=c.actorid ";
    $sql .= " where a.id = ? $optQuery group by YEAR(proposed_date), MONTH(proposed_date) order by YEAR(proposed_date), MONTH(proposed_date) ;";
    break;

  case 'list':
    $sql = "select b.id, b.link_id, title, proposed_date, decision_date, status, status_detail, actor_count from Bill b ";
    $sql .= "INNER JOIN CoActor c on c.billid = b.id where c.actorid=? $optQuery ";
    $sql .= " order by proposed_date desc";
    break;

  case 'all':
    $sql = "select a.name, a.cname, a.party, a.id actorid, count(*) as c from CoActor c ";
    $sql .= "INNER JOIN Actor a ON a.id = c.actorid group by actorid order by c desc; ";

  case 'summary':
    $sql = "select summary from Bill where id = ?;";
    break;

  case 'billactors':
    $sql = "select name, cname, party, a.id  from Actor a Inner join CoActor c on a.id = c.actorid where c.billid = ? order by name;";
    break;

  case 'allorder':
    $sql = "select a.id, a.name, a.cname, a.party, year(proposed_date) as y, month(proposed_date) as m, count(distinct b.id) as c from CoActor c inner join Actor a on a.id=c.actorid inner join Bill b on c.billid=b.id  group by actorid, y, m order by a.id, y, m";
    break;

  // This for the circle viz
  case 'order':
    $sql = "select  name, cname, party, id, count(distinct billid) as c, count(distinct billid)+50 as value  from CoActor c inner join Actor a on a.id = c.actorid group by actorid order by c desc";
    break;

  // This is for the autocomplete search
  case 'actor':
    $sql = "select CONCAT_WS('(', name,   CONCAT(CONCAT_WS('/', cname, party),')') ) as info, id from Actor order by name";
    break;

  default:
    print $json;
    exit(0);
}
// process and print
processQuery($apptype, $sql);

/**
* Main function
*/
function processQuery($apptype, $sql) {
  $startyear = intval($_GET['startyear']);
  $endyear = intval($_GET['endyear']);

  $id = intval($_GET['id']);
  $debug = $_GET['debug'];


  $bid = $_GET['bid'];

  $params = [];
  $type = "";

  if($id) {
    // make array and type
    $params = [&$id];
    $type = "i";
  } else if ($bid) {
    // make array and type
    $params = [&$bid];
    $type = "s";
  }

	// add the last part
  //$sql .= $sql_append;

	if($debug) {
 		print_r($params);
		echo ("S: $sql\nT: $type\n");
	}

	// Persistent Connections
  // http://stackoverflow.com/questions/3332074/what-are-the-disadvantages-of-using-persistent-connection-in-pdo
  // http://www.php.net/manual/en/mysqli.persistconns.php
  $conn = new mysqli("p:localhost", "trend", "", "assembly");
	// Check connection
	if ($conn->connect_error) {
			echo("Connection failed: " . $conn->connect_error);
      exit(0);
	}

  $conn->set_charset("utf8");

  $stmt = $conn->prepare($sql);
	if (!$stmt) {
		 echo("Prepare $sql failed: ($conn->errno)  $conn->error");
     exit(0);
	}

  // http://stackoverflow.com/questions/16236395/bind-param-with-array-of-parameters
  call_user_func_array(array($stmt, "bind_param"), array_merge(array($type), $params));

  $stmt->execute();

	// Need to install
	// sudo apt-get install php5-mysqlnd
  $result = $stmt->get_result();

  if ($debug) {
    echo ("Result is ready!");
  }

  $rows=[];
  $child= [];
  if ($apptype=='order') {
    $idx = 0;
    while($row = $result->fetch_array(MYSQLI_ASSOC)) {
        $row['info'] = $row['name']."(" . $row['cname'] . "/". $row['party']. ")";
        $child[] = $row;
        // Check it's ready to be added
        //if (rand(7,15)==1) {
        if ($idx++%30===0) {
            $rows[]=['name'=>'ord'.$row['id'], 'children'=>$child];
            $child = [];
        }
    }

    // Add last one
    $rows[]=['name'=>'ordlast', 'children'=>$child];

    // Should start with childeren
    $rows = ['name'=>'all', 'children'=>$rows];
  } else {
    if ($debug) echo ("Result is ready!");
    
    while($row = $result->fetch_array(MYSQLI_ASSOC)) {
      $rows[] = $row;
    }
  }

  if ($debug) {
    echo ("Row data is ready!");
  }

	//
  //http://php.net/manual/de/function.gzencode.php
  //print gzencode(json_encode($rows,JSON_UNESCAPED_UNICODE));
//  print (json_encode($rows,JSON_UNESCAPED_UNICODE));
// Turn on output buffering with the gzhandler

  if (!debug) ob_start('ob_gzhandler');
  print (json_encode($rows,JSON_UNESCAPED_UNICODE));
  if (!$debug) {
    retuen;
  }
  switch (json_last_error()) {
          case JSON_ERROR_NONE:
              // echo ' - No errors';
          break;
          case JSON_ERROR_DEPTH:
              echo ' - Maximum stack depth exceeded';
          break;
          case JSON_ERROR_STATE_MISMATCH:
              echo ' - Underflow or the modes mismatch';
          break;
          case JSON_ERROR_CTRL_CHAR:
              echo ' - Unexpected control character found';
          break;
          case JSON_ERROR_SYNTAX:
              echo ' - Syntax error, malformed JSON';
          break;
          case JSON_ERROR_UTF8:
              echo ' - Malformed UTF-8 characters, possibly incorrectly encoded';
          break;
          default:
              echo ' - Unknown error';
          break;
      }
}
?>
