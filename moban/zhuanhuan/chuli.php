<?php
include "yinqing.php";
include "sql.php";
$title = '我是标题';
$lianjie = dbConnect('localhost','root','','sqlo','utf8');
$re = dbSelect($lianjie, 'ssql');
$vars =  compact('title','re');
display('muban.html',$vars);
