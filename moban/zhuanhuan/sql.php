<?php
/**函数的封装
*链接数据库
*@
*/
function dbConnect ($host, $user, $pwd, $dbname, $charset = 'utf8')
{
    $lianjie = mysqli_connect($host, $user, $pwd );//由于封装函数是用来调用所以主机，用户，密码都是传参过来
    if (!$lianjie)//判断函数是否链接成功
	{
	return false;
	}
	$db = mysqli_select_db($lianjie,$dbname);//选着数据库的时候数据库的名字是传参过来的
	if(!$db)
	{
	return false;
	}
	 mysqli_set_charset($lianjie,$charset);//设置字符集，字符的参数时传参过来的默认为utf8

	 return $lianjie;
	 
} 
 
/* $lianjie =  dbConnect('localhost', 'root' , '', 'sqlo');
var_dump($lianjie); */                                              //链接数据库封印完成

/**函数的封装
*插入数据库
*@
*/
function dbInsetr($lianjie,$tablename,$data)
{    
     /*   $data = ['usname' => 'tianxinpeng',
	            'password' => md5('44'),
				'email' => '123@sda'	
		];  */
    $fields = array_keys($data);//字段名
	$fields = join(',',$fields);//与implode类似，把数组转为字符串
	$values = array_values($data);//值
     foreach($values as $k => $v)//把值遍历
	 {
		 if (is_string($v)){
			 $v = "'".$v."'"; //如果遍历出来的值是个字符串就给他加上''号
			 $values[$k] = $v;//把加过引号的值从新赋值给k
		 }
	 }
	 $values = join(',',$values);

  $sql = "insert into  $tablename($fields)  values($values) ";//传过来一个键值对（表，值）
	    //insert intu tablename(usname, password ,email) values ('tianxinpeng','44','123@sda')
		return  sqlQuery($lianjie, $sql, 1);
	 /* $result = mysqli_query($lianjie,$sql);
	  if ($result && mysqli_affected_rows($lianjie))
	  {
		  $id = mysqli_insert_id($lianjie);
		  return $id;
	  }else{
		  return false;
	  } */
}

/* $lianjie =  dbConnect('localhost', 'root' , '', 'sqlo');
$data = ['usname' => 'bibi', 
          'password' => md5('bibi'),
          'enail' => 'bibi@qq.com',
           'ip' => ip2long('127.0.0.1'),
           'time' => time()		   
 ];
$re = dbInsetr($lianjie,'ssql',$data);
var_dump($re);
 */
/**函数的封装
*删除数据库
*@
*/
function dbDelete($lianjie, $tablename, $where)
{ 
  if(empty($where)){
	  return false;
  }
	//如果where条件传过来的是一个数组，and or或者between and
	
	$sql = "delete from  $tablename where $where";
	return  sqlQuery($lianjie, $sql, 2);
	/* $result = mysqli_query($lianjie,$sql);
    if ($result && mysqli_affected_rows($lianjie)){
      return mysqli_affected_rows($lianjie);//受影响的行数	
	}else{
		return false;
	} */
}
/*  $lianjie =  dbConnect('localhost', 'root' , '', 'sqlo');
  $re = dbDelete($lianjie, 'ssql','id=10');//where条件要是数组不想处理就直接传ID= 10and...，也可
  var_dump($re); */

  /**函数的封装
*修改数据库
*@
*/ 
   
   function dbUpdate($lianjie,$tablename,$data,$where)
  { 
	 if(empty($where)){
	  return false;
  }
   /* $data = ['usname' => 'bibi', 
          'password' => md5('bibi'),
          'enail' => 'bibi@qq.com',
           'ip' => ip2long('127.0.0.1'),
           'time' => time()		   
 ]; */
	
	$data = toStr($data);//把键值对变成值带引号

	foreach ($data as $k => $v)
	{ //給值加上引号usname='dhjs',password='25a13a'
     	$data[$k] = $k . '=' .$v;	
	}
	
	$data = join(',',$data);
   
	  $sql = "update $tablename set $data where $where";
	return  sqlQuery($lianjie, $sql, 2);
     /*   $result = mysqli_query($lianjie,$sql);
	 
    if ($result && mysqli_affected_rows($lianjie)){
      return mysqli_affected_rows($lianjie);//受影响的行数	
	}else{
		return false;
	}  */
  
  } 
/*  $lianjie =  dbConnect('localhost', 'root' , '', 'sqlo');
 $data = ['usname' => '厉害了'];
 $re = dbUpdate($lianjie, 'ssql',$data,"usname='666'");//where条件要是数组不想处理就直接传ID= 10and...，也可
  var_dump($re);  */


   /**函数的封装
*查询数据库
*@
*/ 
function dbSelect($lianjie, $tablename, $fields = '*', $where = null, $orde = null, $limit = null)
{
	if(is_array($fields))
	{
		$fields = implode(',',$fields);
	}

	if($where)
	{
		$where = ' where '.$where;
	}
	if($orde)
	{
		$where .= ' order by '.$order;
	}
	if ($limit)
	{
		$where .= ' limit '.$limit;
	}

	 $sql = "select $fields  from $tablename $where";//where 条件最终是个字符串，例如：age>15 order by money desc limit 5.
	 return  sqlQuery($lianjie, $sql, 3);
	
	/*
	$result = mysqli_query($lianjie,$sql);
	 
    if ($result && mysqli_affected_rows($lianjie)){
      return mysqli_fetch_all($result,MYSQLI_ASSOC);//以数组的形式返回查询到的所有值，MYSQLI_ASSOC返回关联数组，MYSQLI_NUM返回索引数组	
	}else{
		return false;
	}  */
	
	
}
/*  $lianjie =  dbConnect('localhost', 'root' , '', 'sqlo');
$re = dbSelect($lianjie,'ssql');
var_dump($re);
var_dump(mysqli_error($lianjie)) ;  */
  
 /**函数的封装
*函数的执行，以及结果集的分析
*@
*/
  function sqlQuery($lianjie, $sql,$stu)
{
	$stuArr = [1, 2, 3];
	if (!in_array($stu, $stuArr)) {
		return false;
	}
	$result = mysqli_query($lianjie, $sql);
	if ($result && mysqli_affected_rows($lianjie)) {
		switch ($stu) {
			case 1:
				$re = mysqli_insert_id($lianjie);
				break;
			case 2:
				$re = mysqli_affected_rows($lianjie);
				break;
			case 3:
				$re = mysqli_fetch_all($result,MYSQLI_ASSOC);
				break;
		}
		return $re;
	} else {
		return false;
	}
	
}
  
  
 
   /**函数的封装
*传参的时候有的参数需要加上引号
*@
*/ 
  function toStr($values)//在传值的时候需要个字符串加上''
{             // $sql = "insert into  $tablename($fields)  values($values) ";//传过来一个键值对（表，值）
	 foreach($values as $k => $v)//把值遍历
	 {
		 if (is_string($v)){
			 $v = "'".$v."'"; //如果遍历出来的值是个字符串就给他加上''号
			 $values[$k] = $v;//把加过引号的值从新赋值给k
		 }
	 }
	 return $values;
} 



























?>

