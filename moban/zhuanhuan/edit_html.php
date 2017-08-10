<html lang="en">
<head>
	<meta charset="UTF-8">
	<title><?=$title;?></title>
</head>
<body>
	<form action='edit.html' method="post">
		用户名：<input type="text" name="usname" value="<?=$re['usname'];?>" /><br />
		密码：<input type="password" name="password" value="<?=$re['password'];?>" /><br />
		邮箱：<input type="text" name="enail" value="<?=$re['enail'];?>" /><br />
		<input type="hidden" name="id" value="<?=$re['id'];?>" /><br />
		<input type="submit" value="保存" />
	</form>
</body>
</html>