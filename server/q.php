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

// Basic information SQL
switch($apptype) {
  case 'coact':
   $sql = "select name, cname, party, actorid as id, count(actorid) c from CoActor c ".
          " inner join Actor a on a.id=actorid inner join  (select distinct(billid) from CoActor ".
          " where actorid = ?) x on x.billid=c.billid group by actorid order by c desc limit 11;";
    break;
  case 'stat':
    $sql = "select count(*) as c, YEAR(cdate) as y, MONTH(cdate) as m from CoActor c ";
    $sql .= " INNER JOIN Bill b on b.id = c.billid INNER Join Actor a on a.id=c.actorid ";
    $sql .= " where a.id = ? group by YEAR(cdate), MONTH(cdate) order by YEAR(cdate), MONTH(cdate) ;";
    break;
  case 'list':
    $sql = "select b.id, title, cdate, pdate, result from Bill b ";
    $sql .= "INNER JOIN CoActor c on c.billid = b.id where c.actorid=? ";
    $sql .= " order by cdate desc";
    break;
  case 'all':
    $sql = "select a.name, a.cname, a.party, a.id actorid, count(*) as c from CoActor c ";
    $sql .= "INNER JOIN Actor a ON a.id = c.actorid group by actorid order by c desc; ";

  case 'summary':
    $sql = "select summary from Bill where id = ?;";

  case 'billactors':
    $sql = "select name, cname, party  from Actor a Inner join CoActor c on a.id = c.actorid where c.billid = ? order by name;";
}
// process and print
processQuery($sql);

/**
* Main function
*/
function processQuery($sql) {
  $startyear = intval($_GET['startyear']);
  $endyear = intval($_GET['endyear']);

  $id = intval($_GET['id']);
  $debug = $_GET['debug'];


  $bid = intval($_GET['bid']);

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
		echo ($sql);
		echo ($type);
	}

	// Persistent Connections
  // http://stackoverflow.com/questions/3332074/what-are-the-disadvantages-of-using-persistent-connection-in-pdo
  // http://www.php.net/manual/en/mysqli.persistconns.php
  $conn = new mysqli("p:localhost", "trend", "", "assembly");
	// Check connection
	if ($conn->connect_error) {
			if ($debug) {echo("Connection failed: " . $conn->connect_error);}
      exit(0);
	}

  $stmt = $conn->prepare($sql);
	if (!$stmt) {
		 if ($debug) {echo("Prepare $sql failed: ($conn->errno)  $conn->error");}
     exit(0);
	}

  // http://stackoverflow.com/questions/16236395/bind-param-with-array-of-parameters
  call_user_func_array(array($stmt, "bind_param"), array_merge(array($type), $params));

  $stmt->execute();

	// Need to install
	// sudo apt-get install php5-mysqlnd
  $result = $stmt->get_result();

  $rows=array();
  while($row = $result->fetch_array(MYSQLI_ASSOC)) {
    $rows[] = $row;
  }

	//
  //http://php.net/manual/de/function.gzencode.php
  //print gzencode(json_encode($rows,JSON_UNESCAPED_UNICODE));
  print (json_encode($rows,JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE));

	$conn->close();
}
?>
