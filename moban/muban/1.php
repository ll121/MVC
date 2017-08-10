<?php
$reg = '/\d+/';
$str = '23456@#$%';
echo preg_replace_callback($reg, 'demo', $str);
function demo($matches)
{
	var_dump($matches);
	return 'bbbb';
}




<?php //递归删除
function delDir($filename){
	if(is_dir($filename)){
		$dir = opendir($filename);
		readdir($dir);
		readdir($dir);
		while($file = readdir($dir)){
			$path = $filename.'/'.$file;
			if (is_dir($path)){
				delDir($path);
			}else{
				unlink($path);
			}
		}
		closedir($dir);
		rmdir($filename);
	}else{
		unlink($filename);
	}
}
delDir('bbs');






?>