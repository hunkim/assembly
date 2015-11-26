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


$json = '[{
  "articles": [
    [1997, 1],
    [1998, 5],
    [1999, 5],
    [2000, 2],
    [2001, 6],
    [2002, 28],
    [2003, 21],
    [2004, 18],
    [2005, 17],
    [2006, 50],
    [2007, 40],
    [2008, 46],
    [2009, 52],
    [2010, 39],
    [2011, 61],
    [2012, 40],
    [2013, 26]
  ],
  "total": 457,
  "name": "Movement disorders : official journal of the Movement Disorder Society"
}, {
  "articles": [
    [1989, 1],
    [1992, 1],
    [1995, 1],
    [1997, 2],
    [1998, 2],
    [1999, 11],
    [2000, 1],
    [2001, 6],
    [2002, 8],
    [2003, 9],
    [2004, 13],
    [2005, 13],
    [2006, 9],
    [2007, 10],
    [2008, 33],
    [2009, 25],
    [2010, 26],
    [2011, 28],
    [2012, 30],
    [2013, 16]
  ],
  "total": 245,
  "name": "Stereotactic and functional neurosurgery"
}, {
  "articles": [
    [1981, 1],
    [1985, 1],
    [1988, 1],
    [1992, 1],
    [1993, 1],
    [1996, 2],
    [1998, 2],
    [1999, 2],
    [2000, 9],
    [2001, 2],
    [2002, 15],
    [2003, 17],
    [2004, 19],
    [2005, 17],
    [2006, 10],
    [2007, 22],
    [2008, 14],
    [2009, 25],
    [2010, 29],
    [2011, 15],
    [2012, 23],
    [2013, 9]
  ],
  "total": 237,
  "name": "Journal of neurosurgery"
}, {
  "articles": [
    [1967, 1],
    [1975, 6],
    [1976, 1],
    [1977, 5],
    [1978, 3],
    [1979, 8],
    [1980, 5],
    [1981, 6],
    [1982, 5],
    [1983, 11],
    [1984, 5],
    [1985, 5],
    [1986, 5],
    [1987, 9],
    [1988, 4],
    [1989, 6],
    [1990, 7],
    [1991, 8],
    [1992, 9],
    [1993, 2],
    [1994, 4],
    [1995, 8],
    [1996, 6],
    [1997, 8],
    [1998, 3],
    [1999, 8],
    [2000, 6],
    [2001, 5],
    [2002, 8],
    [2003, 8],
    [2004, 3],
    [2005, 5],
    [2006, 5],
    [2007, 4],
    [2008, 6],
    [2009, 8],
    [2010, 3],
    [2011, 4],
    [2012, 4],
    [2013, 1]
  ],
  "total": 218,
  "name": "Brain research"
}, {
  "articles": [
    [1987, 3],
    [1990, 1],
    [1981, 1],
    [1997, 2],
    [1998, 3],
    [1999, 4],
    [2000, 2],
    [2001, 5],
    [2002, 5],
    [2003, 1],
    [2004, 4],
    [2005, 17],
    [2006, 12],
    [2007, 13],
    [2008, 19],
    [2009, 14],
    [2010, 21],
    [2011, 23],
    [2012, 21],
    [2013, 19],
    [1983, 1]
  ],
  "total": 191,
  "name": "Neurosurgery"
}, {
  "articles": [
    [1996, 1],
    [1997, 2],
    [1998, 3],
    [1999, 3],
    [2000, 15],
    [2001, 11],
    [2002, 12],
    [2003, 8],
    [2004, 18],
    [2005, 9],
    [2006, 21],
    [2007, 13],
    [2008, 13],
    [2009, 16],
    [2010, 5],
    [2011, 9],
    [2012, 10],
    [2013, 9]
  ],
  "total": 178,
  "name": "Neurology"
}, {
  "articles": [
    [2000, 1],
    [2001, 1],
    [2002, 1],
    [2003, 5],
    [2004, 6],
    [2005, 8],
    [2006, 9],
    [2007, 23],
    [2008, 18],
    [2009, 18],
    [2010, 18],
    [2011, 20],
    [2012, 29],
    [2013, 19]
  ],
  "total": 176,
  "name": "Parkinsonism & related disorders"
}, {
  "articles": [
    [1975, 2],
    [1976, 3],
    [1977, 3],
    [1979, 6],
    [1980, 4],
    [1981, 3],
    [1982, 2],
    [1983, 2],
    [1984, 4],
    [1985, 6],
    [1986, 5],
    [1987, 7],
    [1988, 3],
    [1989, 2],
    [1990, 7],
    [1991, 7],
    [1992, 3],
    [1993, 6],
    [1994, 8],
    [1995, 6],
    [1996, 5],
    [1997, 3],
    [1998, 5],
    [1999, 1],
    [2000, 5],
    [2001, 2],
    [2002, 5],
    [2003, 2],
    [2004, 6],
    [2005, 5],
    [2006, 5],
    [2007, 7],
    [2008, 5],
    [2009, 2],
    [2010, 5],
    [2011, 1],
    [2012, 3],
    [2013, 2]
  ],
  "total": 158,
  "name": "Experimental brain research. Experimentelle Hirnforschung. Exp\u00e9rimentation c\u00e9r\u00e9brale"
}, {
  "articles": [
    [1976, 1],
    [1991, 1],
    [1993, 1],
    [1994, 1],
    [1981, 1],
    [1999, 4],
    [2001, 3],
    [2002, 10],
    [2003, 12],
    [2004, 9],
    [2005, 18],
    [2006, 8],
    [2007, 8],
    [2008, 15],
    [2009, 7],
    [2010, 14],
    [2011, 14],
    [2012, 11],
    [2013, 9]
  ],
  "total": 147,
  "name": "Journal of neurology, neurosurgery, and psychiatry"
}, {
  "articles": [
    [1964, 1],
    [1973, 1],
    [1975, 1],
    [1976, 1],
    [1978, 1],
    [1979, 2],
    [1980, 2],
    [1982, 1],
    [1983, 1],
    [1984, 4],
    [1985, 3],
    [1986, 3],
    [1987, 4],
    [1988, 6],
    [1989, 1],
    [1990, 3],
    [1991, 3],
    [1992, 3],
    [1993, 6],
    [1994, 6],
    [1995, 2],
    [1996, 6],
    [1997, 3],
    [1998, 4],
    [1999, 2],
    [2000, 4],
    [2001, 2],
    [2002, 1],
    [2003, 3],
    [2004, 5],
    [2005, 10],
    [2006, 5],
    [2007, 7],
    [2008, 12],
    [2009, 8],
    [2010, 4],
    [2011, 2],
    [2012, 8],
    [2013, 6]
  ],
  "total": 147,
  "name": "Journal of neurophysiology"
}, {
  "articles": [
    [1986, 1],
    [1991, 2],
    [1993, 1],
    [1997, 1],
    [2000, 2],
    [2001, 4],
    [2002, 2],
    [2003, 3],
    [2004, 6],
    [2005, 5],
    [2006, 7],
    [2007, 10],
    [2008, 14],
    [2009, 8],
    [2010, 14],
    [2011, 10],
    [2012, 11],
    [2013, 5],
    [1982, 1],
    [1983, 1]
  ],
  "total": 108,
  "name": "Brain : a journal of neurology"
}, {
  "articles": [
    [1999, 1],
    [2001, 2],
    [2002, 2],
    [2004, 2],
    [2005, 5],
    [2006, 6],
    [2007, 3],
    [2008, 15],
    [2009, 13],
    [2010, 15],
    [2011, 13],
    [2012, 11],
    [2013, 13],
    [1983, 1]
  ],
  "total": 102,
  "name": "Experimental neurology"
}, {
  "articles": [
    [2005, 5],
    [2006, 8],
    [2007, 4],
    [2008, 3],
    [2009, 20],
    [2010, 24],
    [2011, 22],
    [2012, 11]
  ],
  "total": 97,
  "name": "Conference proceedings : ... Annual International Conference of the IEEE Engineering in Medicine and Biology Society. IEEE Engineering in Medicine and Biology Society. Conference"
}, {
  "articles": [
    [1987, 1],
    [1991, 1],
    [1995, 1],
    [1996, 2],
    [1979, 1],
    [1998, 1],
    [1999, 2],
    [2000, 1],
    [2001, 1],
    [2002, 2],
    [2004, 3],
    [2005, 4],
    [2006, 2],
    [2007, 3],
    [2008, 5],
    [2009, 8],
    [2010, 19],
    [2011, 17],
    [2012, 13],
    [2013, 9]
  ],
  "total": 96,
  "name": "Acta neurochirurgica"
}, {
  "articles": [
    [1984, 1],
    [1986, 1],
    [1991, 1],
    [1993, 1],
    [1995, 1],
    [1996, 3],
    [1997, 1],
    [1999, 2],
    [2001, 1],
    [2002, 2],
    [2003, 2],
    [2004, 3],
    [2005, 2],
    [2006, 7],
    [2007, 6],
    [2008, 9],
    [2009, 4],
    [2010, 4],
    [2011, 7],
    [2012, 15],
    [2013, 14]
  ],
  "total": 87,
  "name": "The Journal of neuroscience : the official journal of the Society for Neuroscience"
}, {
  "articles": [
    [1999, 3],
    [2000, 1],
    [2001, 5],
    [2002, 4],
    [2003, 6],
    [2005, 7],
    [2006, 5],
    [2007, 6],
    [2008, 9],
    [2009, 9],
    [2010, 13],
    [2011, 8],
    [2012, 4],
    [2013, 7]
  ],
  "total": 87,
  "name": "Journal of neurology"
}, {
  "articles": [
    [2003, 1],
    [2004, 4],
    [2005, 3],
    [2006, 6],
    [2007, 3],
    [2008, 6],
    [2009, 4],
    [2010, 12],
    [2012, 7],
    [2013, 7]
  ],
  "total": 85,
  "name": "Neuromodulation : journal of the International Neuromodulation Society"
}, {
  "articles": [
    [1982, 1],
    [1983, 1],
    [1985, 1],
    [1986, 1],
    [1988, 4],
    [1990, 1],
    [1991, 1],
    [1992, 2],
    [1993, 2],
    [1994, 2],
    [1995, 4],
    [1997, 2],
    [1998, 1],
    [1999, 1],
    [2001, 1],
    [2002, 2],
    [2004, 3],
    [2005, 3],
    [2006, 3],
    [2007, 3],
    [2008, 8],
    [2009, 4],
    [2010, 3],
    [2011, 5],
    [2012, 12],
    [2013, 6]
  ],
  "total": 77,
  "name": "Neuroscience"
}, {
  "articles": [
    [1995, 1],
    [1997, 1],
    [2002, 4],
    [2003, 8],
    [2005, 5],
    [2006, 13],
    [2007, 40],
    [2008, 3]
  ],
  "total": 75,
  "name": "Acta neurochirurgica. Supplement"
}, {
  "articles": [
    [1999, 2],
    [2000, 1],
    [2002, 7],
    [2003, 2],
    [2004, 4],
    [2005, 6],
    [2006, 11],
    [2007, 3],
    [2008, 6],
    [2009, 6],
    [2010, 6],
    [2011, 4],
    [2012, 9],
    [2013, 4]
  ],
  "total": 71,
  "name": "Clinical neurophysiology : official journal of the International Federation of Clinical Neurophysiology"
}, {
  "articles": [
    [1993, 1],
    [1994, 1],
    [1995, 1],
    [1998, 1],
    [2000, 2],
    [2002, 1],
    [2003, 5],
    [2004, 3],
    [2005, 2],
    [2006, 4],
    [2007, 6],
    [2008, 4],
    [2009, 10],
    [2010, 13],
    [2011, 2],
    [2012, 8],
    [2013, 2]
  ],
  "total": 66,
  "name": "The European journal of neuroscience"
}, {
  "articles": [
    [2001, 1],
    [2002, 1],
    [2003, 1],
    [2004, 1],
    [2005, 2],
    [2006, 2],
    [2007, 8],
    [2008, 4],
    [2009, 3],
    [2010, 6],
    [2011, 14],
    [2012, 12],
    [2013, 8]
  ],
  "total": 63,
  "name": "NeuroImage"
}, {
  "articles": [
    [2000, 1],
    [2001, 2],
    [2002, 3],
    [2003, 1],
    [2004, 4],
    [2005, 7],
    [2006, 2],
    [2007, 5],
    [2008, 3],
    [2009, 7],
    [2010, 5],
    [2011, 4],
    [2012, 7],
    [2013, 6]
  ],
  "total": 57,
  "name": "Journal of clinical neuroscience : official journal of the Neurosurgical Society of Australasia"
}, {
  "articles": [
    [2008, 2],
    [2009, 5],
    [2010, 8],
    [2011, 5],
    [2012, 14],
    [2013, 23]
  ],
  "total": 57,
  "name": "Brain stimulation"
}, {
  "articles": [
    [1987, 1],
    [1988, 1],
    [1996, 1],
    [1997, 1],
    [2000, 1],
    [2002, 1],
    [2004, 2],
    [2005, 2],
    [2006, 2],
    [2007, 4],
    [2008, 5],
    [2009, 7],
    [2010, 5],
    [2011, 11],
    [2012, 7],
    [2013, 5]
  ],
  "total": 56,
  "name": "Journal of neuroscience methods"
}, {
  "articles": [
    [1982, 1],
    [1983, 3],
    [1984, 2],
    [1985, 1],
    [1986, 1],
    [1988, 2],
    [1989, 2],
    [1990, 3],
    [1991, 2],
    [1992, 1],
    [1993, 2],
    [1994, 1],
    [1995, 1],
    [1996, 1],
    [1998, 3],
    [2001, 1],
    [2002, 2],
    [2004, 1],
    [2005, 2],
    [2006, 2],
    [2007, 3],
    [2008, 1],
    [2009, 3],
    [2010, 2],
    [2011, 1],
    [2012, 4]
  ],
  "total": 53,
  "name": "Brain research bulletin"
}, {
  "articles": [
    [2001, 1],
    [2002, 2],
    [2004, 6],
    [2005, 2],
    [2006, 4],
    [2008, 6],
    [2009, 4],
    [2010, 19],
    [2011, 1],
    [2012, 3]
  ],
  "total": 48,
  "name": "Neurosurgical focus"
}, {
  "articles": [
    [1991, 1],
    [1995, 1],
    [1998, 1],
    [1999, 2],
    [2000, 4],
    [2001, 2],
    [2002, 3],
    [2003, 2],
    [2004, 6],
    [2005, 5],
    [2007, 1],
    [2008, 2],
    [2009, 4],
    [2010, 2],
    [2011, 1],
    [2012, 4],
    [2013, 4]
  ],
  "total": 45,
  "name": "Annals of neurology"
}, {
  "articles": [
    [2004, 2],
    [2005, 1],
    [2006, 3],
    [2007, 5],
    [2008, 2],
    [2009, 5],
    [2010, 10],
    [2011, 8],
    [2012, 5],
    [2013, 4]
  ],
  "total": 45,
  "name": "Journal of neural engineering"
}, {
  "articles": [
    [1999, 1],
    [2000, 1],
    [2001, 5],
    [2004, 1],
    [2005, 7],
    [2006, 7],
    [2007, 2],
    [2008, 3],
    [2009, 4],
    [2010, 5],
    [2011, 6],
    [2012, 2]
  ],
  "total": 44,
  "name": "Archives of neurology"
}]';

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
    break;

  case 'billactors':
    $sql = "select name, cname, party, a.id  from Actor a Inner join CoActor c on a.id = c.actorid where c.billid = ? order by name;";
    break;

  case 'allorder':
    $sql = "select a.id, a.name, a.cname, a.party, year(cdate) as y, month(cdate) as m, count(distinct b.id) as c from CoActor c inner join Actor a on a.id=c.actorid inner join Bill b on c.billid=b.id  group by actorid, y, m order by a.id, y, m";
    break;

  case 'order':
    $sql = "select  name, cname, party, id, count(distinct billid) as c, count(distinct billid)+50 as value  from CoActor c inner join Actor a on a.id = c.actorid group by actorid order by name";
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

  $rows=[];
  $child= [];
  if ($apptype=='order') {
    while($row = $result->fetch_array(MYSQLI_ASSOC)) {
          $child[] = $row;
          // Check it's ready to be added
          if (rand(1,15)==1) {
              $rows[]=['name'=>'ord'.$row['id'], 'children'=>$child];
              $child = [];
          }
    }

    // Add last one
    $child[] = $data;
    $rows[]=['name'=>'ordlast', 'children'=>$child];

    // Should start with childeren
    $rows = ['name'=>'all', 'children'=>$rows];
  } else {
    while($row = $result->fetch_array(MYSQLI_ASSOC)) {
      $rows[] = $row;
    }
  }


	//
  //http://php.net/manual/de/function.gzencode.php
  //print gzencode(json_encode($rows,JSON_UNESCAPED_UNICODE));
  print (json_encode($rows,JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE));

	$conn->close();
}
?>
