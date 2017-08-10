<html><!--模板-->
<head><title><?=$title?></title>
</head>
<body>
    <?=$con?>
	<br />
	<?php if($stu):?>
	我是真区间
	这里的大括号并不是固定的，<br />
	因为我们的正则约定的是从大括号开始匹配<br />
	所以这也是大括号开始<br />
	<?php else:?><br />
	我是假区间
	<?php endif;?>
	<br />
	<?php switch($num): case 4: ?>在处理switch时，别忘了在后面跟着一种情况否则显示为空（错误）
	
	             第4个
		  <?php break; ?>
	<?php case 1: ?>
	   第一个
	   <?php break; ?>
	 <?php case 2: ?>
	   第2个
	   <?php break; ?>
     <?php case 3: ?>
	   第3个
	   <?php break; ?>
	   <?php endswitch;?><br />
	   <?php include'footer_html.php';?>在进行include时要进行判断，引进来的文件里面若是包含的有变量也要解析
	   <!-- <?php foreach($arr as $key => $value):?>
	       <?=$key?>
		   <?=$value?>
		   <?php endforeach;?> -->
	   
	   
	   
	   
	   
</body>
</html>