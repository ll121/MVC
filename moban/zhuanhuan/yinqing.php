<?php
function display($tplFile,$vars =null) //定义一个可以将html文件转换成PHP的函数
{
    if (!file_exists($tplFile))//判断传过来的html文件是否存在
    {
    	exit('模板文件不存在');
    }
    //完成模板的替换
    $con = complie($tplFile);
    //生成文件名
    $savePath = str_replace('.', '_',$tplFile).'.php'; 
    //保存替换完成的文件
    file_put_contents($savePath, $con);  
     if(is_array($vars)){
     extract($vars);
	 include "$savePath";
       }
     
}

function complie($tplFile)
{ 
	//读出模板文件.html的内容
	$con = file_get_contents($tplFile);
	 /* var_dump($con); */ 
	//匹配
	$keys = [
           '{$%%}' => '<?=$\1;?>',
		   '{if %%}' => '<?php if(\1):?>',
		   '{else}' => '<?php else:?>',
		   '{/if}' => '<?php endif;?>',
		   '{switch %% case %%}' => '<?php switch(\1): case \2:?>',
		   '{case %%}' => '<?php case \1:?>',
		   '{break}'   =>  '<?php break;?>',
		   '{/switch}' => '<?php endswitch;?>',
		   '{include %%}' => '<?php include "\1";?>',
		   '{for %%}' => '<?php for(\1):?>',
		   '{/for}'   => '<?php endfor;?>',
		   '{foreach %%}' => '<?php foreach(\1):?>',
		   '{/foreach}'  => '<?php endforeach;?>'
          ];

foreach ($keys as $key => $value)
    {
      $key = preg_quote($key,'#');
      $preg = '#'.str_replace('%%', '(.+)',$key).'#';//{$%%}={$(.+)}
      if(strpos($key,'include')){
		  
		  $con = preg_replace_callback($preg,'dealInclude',$con);
	  }else{
		  
	  
	  $con = preg_replace($preg, $value, $con);
	  }
    }
    return $con;

}

function dealInclude($matchs)
{
	/* var_dump($matchs); */
	$file = $matchs[1];
	display($file);
	$savePath = str_replace('.','_',$file).'.php';
	return "<?php include '$savePath';?>";
}