<?php
/**
*链接数据库
*@param string $host   主机名
*@param string $user   用户名
*@param string $pwd    密码
*@param string $dbname 数据库名
*@param string $charset 字符集
*@return $link  链接的资源
		 false
*/
function dbConnect($host, $user, $pwd, $dbname, $charset = 'utf8')
{
	//链接
	$link = mysqli_connect($host, $user, $pwd);
	//判断
	if (!$link) {
		return false;
	}
	//选择库
	$db = mysqli_select_db($link, $dbname);
	if (!$db) {
		return false;
	}
	//设置字符集
	mysqli_set_charset($link, $charset);
	return $link;
}

function dbInsert($link, $tablename, $data)
{
	$fields = array_keys($data); //字段名
	$fields = join(',', $fields);
	$values = array_values($data);//值
	foreach($values as $k => $v) {
		if (is_string($v)) {
			// '1234fghj'
			$v = "'" . $v . "'";
			$values[$k] = $v;
		}
	}
	$values = join(',', $values);
	$sql = "insert into $tablename($fields) values($values)";
	return sqlQuery($link, $sql, 1);
	//		insert into tablename(username,password,email) values('hanshu',..);
	/* $result = mysqli_query($link, $sql);
	if ($result && mysqli_affected_rows($link)) {
		$id = mysqli_insert_id($link);
		return $id;
	} else {
		return false;
	} */
}

function dbDelete($link, $tablename, $where)
{
	if (empty($where)) {
		return false;
	}
	// 如果是一个数组  and or  变成 age = 18 and  sex = 1  作业
	//
	$sql 	= "delete from $tablename where $where";
	return sqlQuery($link, $sql, 2);
	/* $result = mysqli_query($link, $sql);
	if ($result && mysqli_affected_rows($link)) {
		return mysqli_affected_rows($link);
	} else {
		return false;
	} */
}

function dbUpdate($link, $tablename, $data, $where)
{
	if (empty($where)) {
		return false;
	}
	
	$data = vToStr($data);// '值'
	foreach($data as $k => $v) {
		//username='dhjs' , password='123456sdfg' ,
		$data[$k] = $k . '=' . $v;
	}
	
	$data = join(',', $data);
	$sql = "update $tablename set $data where $where";
	return sqlQuery($link, $sql, 2);
	/* $result = mysqli_query($link, $sql);
	if ($result && mysqli_affected_rows($link)) {
		return mysqli_affected_rows($link);
	} else {
		return false;
	} */
}

/**
*mysqli_fetch_all($result,MYSQLI_ASSOC);//获取查询到的所有数据 以数组形式
 第二个参数 MYSQLI_ASSOC or MYSQLI_NUM 
*/
function dbSelect($link, $tablename, $fields = '*', $where = null, $order = null, $limit = null)
{
	if (is_array($fields)) {
		$fields = implode(',', $fields);
	}
	if ($where) {
		$where = ' where ' . $where;
	}
	if ($order) {
		$where .= ' order by ' . $order;
	}
	if ($limit) {
		$where .= ' limit ' .$limit;
	}
	// *   username username,password
	$sql = "select $fields from $tablename $where";
	return sqlQuery($link, $sql, 3);
	/* $result = mysqli_query($link, $sql);
	if ($result && mysqli_affected_rows($link)) {
		// return mysqli_fetch_all($result,MYSQLI_ASSOC); 
		
	} else {
		return false;
	} */
}
//  1 insert  2 update delete 3 select
function sqlQuery($link, $sql,$stu)
{
	$stuArr = [1, 2, 3];
	if (!in_array($stu, $stuArr)) {
		return false;
	}
	$result = mysqli_query($link, $sql);
	if ($result && mysqli_affected_rows($link)) {
		switch ($stu) {
			case 1:
				$re = mysqli_insert_id($link);
				break;
			case 2:
				$re = mysqli_affected_rows($link);
				break;
			case 3:
				$re = mysqli_fetch_all($result,MYSQLI_ASSOC);
				break;
		}
		return $re;
	} else {
		return false;
	}
	// 
}
 /* $link = dbConnect('localhost', 'root', '123456', 'qf_1704');
 $re = dbSelect($link, 'user_1704');
var_dump($re); */
/*$data = ['username' => 'boboda'];
$re = dbUpdate($link, 'user_1704', $data, "username='dabobo'");
 var_dump($re);
$re = dbDelete($link, 'user_1704', 'id=59');
 var_dump($re);
 $data = [
		'username' 		=> 'dabobo', 
		'password' 		=> md5('bobo'), 
		'email' 		=> 'bobo@qq.com', 
		'ip' 			=> ip2long('127.0.0.1'),
		'create_time' 	=> time()
		];
$re = dbInsert($link, 'user_1704', $data);
var_dump($re); */

function vToStr($values)
{
	foreach($values as $k => $v) {
		if (is_string($v)) {
			// '1234fghj'
			$v = "'" . $v . "'";
			$values[$k] = $v;
		}
	}
	return $values;
}
