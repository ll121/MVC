<?php
include "date.php";
include "mysql_link.php";

$title = '用户列表';
$link = dbConnect('localhost','root','','sqlo','utf8');
$result = dbSelect($link, 'ssql');

$vars = compact('title','result');
display('test.html',$vars);
?>