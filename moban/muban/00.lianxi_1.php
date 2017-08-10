<?php
include "00lianxi.php";
$title = '我是标题';
$con = '我是内容';
$stu = true;
$num = mt_rand(1,4);
$name = '靝鑫鹏';
$vars = compact('title','con','stu','num','name');//建立一个数组，变量名成为键名而变量的内容成为该键的值
display('00lianxi.html',$vars);


?>