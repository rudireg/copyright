<?php
  session_start(); 
  if($_SESSION[isUser] == false) die("Авторизуйтесь.<br /> <a href='/'>Вернуться на главную</a>");
  require_once 'database.php';
  require_once 'copyright_menu.php'
  
?>
<!-- Профайл копирайтера. --> 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
		<title>Заказчик статьи.</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <link href="css/960.css" rel="stylesheet" type="text/css" media="all" />
        <link href="css/style.css" rel="stylesheet" type="text/css" media="all" />
        <link type='text/css' href='css/basic.css' rel='stylesheet' media='screen' />
		<!-- IE6 "fix" for the close png image -->
        <!--[if lt IE 7]>
        <link type='text/css' href='css/basic_ie.css' rel='stylesheet' media='screen' />
        <![endif]-->
		
        <script type="text/javascript" src="js/jquery.js"></script>
		<script type="text/javascript" src="js/lib_copyright.js"></script>
        <script type="text/javascript" src="js/jquery.validate.js"></script>
		<script type="text/javascript" src="js/jquery.form.js"></script>
		<script type="text/javascript" src="js/xmlHttpRequest.js"></script>	
		<script type='text/javascript' src='js/jquery.simplemodal.js'></script>
		
<style type="text/css">
label.error {
        color: red;
        font-style: italic;
}
input.error {
        border: 1px dotted #f00;
}
textarea.error {
        border: 1px dotted #f00;
}
</style>

<script type="text/javascript">

</script>		
		
		
</head>
<body>
<!-- Меню -->
<div class="top_menu">
<?=ShowOrderMenu();?>
</div>
<!-- / Меню -->

<div class="container_16" style="min-height:600px;">
    <div class="grid_5">
	<br />
	<div class="boxer">
        <h2>Счетчик статей</h2>
	    <table>
		    <tr>
			    <td>Статьи в работе:</td>
				<td><span style="color:orange"><?=ArticleInWorkByIdCopyman($_SESSION[id]);?></span></td>
			</tr>
			<tr>
			    <td>Статьи на модерации:</td>
				<td><span style="color:red"><?=ArticleInModerByIdCopyman($_SESSION[id]);?></span></td>
			</tr>
			<tr>
			    <td>Оплаченые статьи:</td>
				<td><span style="color:green"><?=ArticleInPaidByIdCopyman($_SESSION[id]);?></span></td>
			</tr>
		</table>
	</div>	
    <hr>

	
    </div>
    <div class="grid_11">
	 1111
        
		
    </div>
</div>
<div class="clear"></div>

<br /><br />
<!-- Подвал -->
<div class="footer">
<p class="mini_notice">Сервис заказа статей у своих копирайтеров.<br />2012 - <a href="http://art.botinok.in">http://art.botinok.in</a></p>
</div>
<!-- / Подвал -->
</body>
</html>