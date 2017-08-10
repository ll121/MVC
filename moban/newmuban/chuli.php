<?php
include "yinqing.php";
$title = '我是标题';
$con = '我是内容';
$stu = true;
$num = mt_rand(1,5);
$name = '靝鑫鹏';
$vars =  compact('title','con','stu','num','name');
display('muban.html',$vars);