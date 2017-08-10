<?php    //模板引擎
//封装一个可以将HTML转换为PHP
function display($splFile ,$vars = null)//先传过来一个文件
{
	//1.判断文件是否存在
	if(!file_exists($splFile))
	{
		exit('模板文件不存在');
	}
	//2.完成模板文件的替换
	$con = complie($splFile);
	
	//3.生成php文件
	      //00lianxi.html ===> 00lianxi_html.php
	 $savePath = str_replace('.','_',$splFile).'.php';//子字符串的替换
	//4.保存模板文件替，换完的
	file_put_contents($savePath,$con);
	if(is_array($vars))
	{
		extract($vars);//从数组中将变量导入到当前的符号表把compact封装在数组中的变量解析出来
	
	include $savePath;//把生成的php文件包含进来，为的是可以直接运行新建的文件
	                   //由于新生成的文件里面会有变量，所以要传过来
	
	}
}




function complie($splFile)
{
	//读出模板文件.html中的内容
	$con = file_get_contents($splFile);
	//匹配
	$keys = [//把谁替换为谁
	      '{$%%}' => '<?=$\1?>',
	      '{if %%}' => '<?php if(\1):?>' ,
          '{else}' => 	'<?php else:?>',
          '{/if}'	=> '<?php endif;?>',
		  '{switch %% case %%}' => '<?php switch(\1): case \2: ?>',
    	  '{case %%}' => '<?php case \1: ?>',
          '{break}'	  => '<?php break; ?>', 
	      '{/switch}' => '<?php endswitch;?>', 
	      '{include %%}' => '<?php include "\1";?>',
		  '{for %%}'   => '<?php for(\1): ?>',
		  '{/for}'   => '<?php endfor; ?>',
		  '{foreach %%}' => '<?php foreach(\1):?>',
		  '{/foreach}' => '<?php endforeach;?>'
		  
	];//流程控制的替代语法
	foreach($keys as $key => $value)
	{ 
	   $key = preg_quote($key,'#');//转义正则表达式字符
	   //{$%%} => {\$%%}
	   //#{\$%%}#
	   //#{\$(.+)}#
	    $preg = '#'. str_replace('%%','(.+)',$key) .'#';
	   if(strpos($key,'include'))//判断key里面是否包含include,如果存在返回出现的位置。
	   {                         //因为include在大括号里面所以不会返回0；
		 $con = preg_replace_callback($preg,'dealInclude',$con);//执行一个正则表达式搜索并且使用一个回调进行替换  
	                                                            //第一个参数正则表达式，第二个参数传一个函数
	                                                             //第三个参数从哪里替换
	   }else{
		   $con = preg_replace($preg,$value,$con);//第一个参数正则表达式，第二个参数要替换成什么
		                                       //第三个参数从哪里替换
	   }           
	  
		
	}
	    return $con;

}
function dealInclude($matchs)//在使用preg_replace_callback()回调函数时会自动传一个参数
{
	/* var_dump($matchs);  */      //参数是匹配到的东西  0 => string '{include footer.html}' (length=21)
                                                         //1 => string 'footer.html' (length=11)
    $file = $matchs[1];
	display($file);//把footer.html转换成PHP文件
	$savePath = str_replace('.','_',$file).'.php';//子字符串的替换
	return 	"<?php include'$savePath';?>";										
												
												}





















?>