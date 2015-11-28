<?php

header("Access-Control-Allow-Origin: *");
//header("Accept-Encoding: gzip,deflate");
//header("Content-Encoding: gzip");
header("Content-Type: application/json; charset=UTF-8");

include_once 'q_eng.php';

// use the query engine
query_engine($appname, $_GET);

?>
