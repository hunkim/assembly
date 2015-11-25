<?php

header("Access-Control-Allow-Origin: *");
//header("Accept-Encoding: gzip,deflate");
//header("Content-Encoding: gzip");
header("Content-Type: application/json; charset=UTF-8");

// Get app name
$tname = substr($_SERVER['PATH_INFO'], 1);

if (!$tname) {
  exit(0);
}

// Basic information SQL
$sql = "select a.name, a.cname, a.party, actorid, count(*) as c from CoActor c INNER JOIN Actor a ON a.id = c.actorid where 1=? group by actorid order by c desc; ";

// process and print
processQuery($sql);

/**
* Main function
*/
function processQuery($sql) {
  $startyear = intval($_GET['startyear']);
  $endyear = intval($_GET['endyear']);

	// No end year, give it enough
  if ($endyear ==0) $endyear = 3000;

  $i=1;
	// make array and type
  $params = [&$i];
  $type = "i";

	$debug = false;
	foreach ($_GET as $key=>$val) {
		if ($key=='debug') {
			$debug = true;
			continue;
		}

		if ($val=="") {
			continue;
		}

  	$sql .= " AND " . $key . "=? ";
		$type .= "s";

		// need array element here, since we need a reference
		$decoded_val[$key] = urldecode($val);
		$params[] = &$decoded_val[$key];
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
