<?php
function display($stplFile, $vars)
{
	//判断模板文件是否存在
	if(!file_exists($stplFile)){
		exit('模板文件不存在');
	}
	//转成PHP文件
	$con = complie($stplFile);
	//生成PHP文件名
	$savePath = str_replace('.','_',$stplFile).'.php';
	//写入新生成的文件
	file_put_contents($savePath,$con);
	//读取新生成的PHP文件
	if(is_array($vars)){
		extract($vars);
		include $savePath;
	}	
}
function complie($stplFile)
{
	$con = file_get_contents($stplFile);
	$keys = [
	      '{$%%}'  => '<?=$\1;?>',
		  '{foreach %%}' => '<?php foreach(\1):?>',
		  '{/foreach}'   => '<?php endforeach;?>'
	];
	foreach($keys as $key =>$value){
		$key = preg_quote($key, '#');// 转义正则表达式字符
		$reg = '#' . str_replace('%%','(.+)',$key) . '#';
	
	if(strpos($key,'include')){
		$con = preg_replace_callback($reg,'dealInclude',$con);
	}else{
		$con = preg_replace($reg,$value,$con);
	  } 
	}
	return $con;
	
}

function dealInclude($matchs)
{
	$file = $matchs[1];
	display($file);
	$savePath = str_replace('.','_',$file).'.php';
	return "<?php include '$savePath';?>";
}






?>