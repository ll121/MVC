<!doctype html>
<html lang="en">
<head
	<meta charset="UTF-8">
	<title><?=$title;?></title>
</head>
<body>
	<table width = 800 height = 500 border=1>
		<tr><td>id</td><td>用户名</td><td>密码</td><td>邮箱</td><td>ip</td><td>时间</td><td>操作</td></tr>
       <?php foreach($re as $k => $v):?>
       <tr>
       <?php foreach($v as $n => $info):?>
      <td> <?=$info;?></td>
    
       <?php endforeach;?>
       <td><a href="edit.php?id=<?=$v['id'];?>">编辑</a></td>
   </tr>
       <?php endforeach;?>
   </table>

</body>
</html>