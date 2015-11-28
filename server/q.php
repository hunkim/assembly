<?php

header("Access-Control-Allow-Origin: *");
//header("Accept-Encoding: gzip,deflate");
//header("Content-Encoding: gzip");
header("Content-Type: application/json; charset=UTF-8");

include_once 'q_eng.php';

// Get app name
$apptype = substr($_SERVER['PATH_INFO'], 1);

// use the query engine
query_engine($apptype, $_GET);

?>
