<?php
include "yinqing.php";
include "sql.php";
$id = $_GET['id'];
$lianjie = dbConnect('localhost','root','','sqlo','utf8');
$re = dbSelect($lianjie, 'ssql','*',"id=$id");
$re = $re[0];
$title='我是编辑';
$vars = compact('title','re');
display('edit.html',$vars);


?>