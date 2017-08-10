
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title><?=$title;?></title>
</head>
<body>
	<?=$con;?>
	<?php if($stu):?>
	我是真区间
	<?php else:?>
	我是假区间
	<?php endif;?><br />
	<?php switch($num): case 1:?>
	    第一个
		<?php break;?>
		<?php case 2:?>
		第二个
		<?php break;?>
		<?php case 3:?>
		第三个
		<?php break;?>
		<?php case 4:?>
		第四个
		<?php break;?>
		<?php case 5:?>
		第五个
		
		<?php endswitch;?><br />
		<?php include 'footer_html.php';?>
		
</body>
</html>