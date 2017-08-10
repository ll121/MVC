<html>
<head><title><?=$title;?></title></head>
<body>
<table width="800" border=1>
<tr><th>id</th><th>用户名</th><th>密码</th><th>emali</th><th>ip</th><th>时间</th><th>操作</th></tr>
<?php foreach($result as $key => $value):?>
<tr>
 <?php foreach($value as $k => $infor):?>
      <td><?=$infor;?></td>    <!-- 每次infor输出一条完整的记录 -->
 <?php endforeach;?>
 <td><a >删除</a></td>
 </tr>
 <?php endforeach;?>
 </table>
</body>


</html>