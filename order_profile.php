<?php
  session_start(); 
  if($_SESSION[isAdmin] == false) die("Авторизуйтесь.<br /> <a href='/'>Вернуться на главную</a>");
  require_once 'ruditest.php';
  require_once 'database.php';
  require_once 'order_menu.php';
  
  
  
?>
<!-- Admin-Заказчик.--> 
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
		<script type="text/javascript" src="js/lib_order.js"></script>
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
</head>
<body>
<noindex>
<script type="text/javascript">
    var reformalOptions = {
        project_id: 83353,
        project_host: "botinok.reformal.ru",
        tab_orientation: "left",
        tab_indent: "50%",
        tab_bg_color: "#F05A00",
        tab_border_color: "#FFFFFF",
        tab_image_url: "http://tab.reformal.ru/T9GC0LfRi9Cy0Ysg0Lgg0L%252FRgNC10LTQu9C%252B0LbQtdC90LjRjw==/FFFFFF/2a94cfe6511106e7a48d0af3904e3090/left/1/tab.png",
        tab_border_width: 2
    };
    
    (function() {
        var script = document.createElement('script');
        script.type = 'text/javascript'; script.async = true;
        script.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'media.reformal.ru/widgets/v3/reformal.js';
        document.getElementsByTagName('head')[0].appendChild(script);
    })();
</script><noscript><a href="http://reformal.ru"><img src="http://media.reformal.ru/reformal.png" /></a><a href="http://botinok.reformal.ru">Oтзывы и предложения для Сервис управления копирайтерами</a></noscript>
</noindex>

<!-- Меню -->
<div class="top_menu">
<?=ShowOrderMenu();?>
</div>
<!-- / Меню -->

<div class="container_16" style="min-height:600px;">
    <div class="grid_5">

		
	
		<br />
		<!-- Регистрация копирайтера -->
		<center>
	    <div class="boxer" >
		    <h3>Регистрация копирайтера</h3>
			<span class="mini_notice">Только вы сможете давать ему задания.</span>
		    <form id="FormRegCopyman">
		    <label for="LoginRegCopyman">Логин &nbsp;&nbsp;</label></td>
		    <input type="text" id="LoginRegCopyman" name="LoginRegCopyman" size="23" value="" />
			<br /><br />
			<label for="PassRegCopyman">Пароль </label></td>
		    <input type="text" id="PassRegCopyman" name="PassRegCopyman" size="23" value="" />
			<br /><br />
			<label for="WMRRegCopyman">WMR &nbsp;&nbsp;&nbsp;&nbsp;</label></td>
		    <input type="text" id="WMRRegCopyman" name="WMRRegCopyman" size="23" value="" />
			<br /><br />
			<label for="WMZRegCopyman">WMZ &nbsp;&nbsp;&nbsp;&nbsp;</label></td>
		    <input type="text" id="WMZRegCopyman" name="WMZRegCopyman" size="23" value="" />
			<br /><br />
			<label for="QIWIRegCopyman">QIWI &nbsp;&nbsp;&nbsp;&nbsp;</label></td>
		    <input type="text" id="QIWIRegCopyman" name="QIWIRegCopyman" size="23" value="" />
			<br /><br />
			<label for="EmailRegCopyman">Email &nbsp;&nbsp;</label></td>
		    <input type="text" id="EmailRegCopyman" name="EmailRegCopyman" size="23" value="" />
			<br /><br />
			<label for="ICQRegCopyman">ICQ &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label></td>
		    <input type="text" id="ICQRegCopyman" name="ICQRegCopyman" size="23" value="" />
			<br /><br />
			<div id="regCopymanAnswer"></div>
			<button id="BtnregCopyman" class="button" name="BtnregCopyman" tabindex="5" type="submit">Зарегистрировать</button>
	        <img id="regCopymanLoader" src="image/form_hider.gif" />
		    </form>
		</div>
		</center>
		<!-- / Регистрация копирайтера -->
		
		 
		<br />
		

        <!-- Удаление копирайтера --> 		
		<div class="boxer" >
		    <center>
            <h3>Удаление копирайтера</h3>
			<span class="mini_notice">Копирайтер - который имеет невыполненые заказы не может быть удален.</span>
            <form id="FormDeleteCopyright">
				<select id="selectCopyMan">
                    <option selected value="0">Выберите копирайтера</option>
				    <?=GetAllCopymanID();?>
		        </select>
				<br /><br />
                <div id="DeleteCopyrightAnswer"></div>
	            <button id="BtnDeleteCopyright" class="button" name="BtnDeleteCopyright" tabindex="5" type="submit">Удалить</button>
	            <img id="DeleteCopyrightLoader" src="image/form_hider.gif" /> 				
            </form>	
            </center> 			
        </div>		
		<!-- / Удаление копирайтера --> 
		
		
		<br />
		
		
    </div>
    <div class="grid_11">
	    <div class="grid_6">
		    <br />
            <!-- Проверка домена -->
		    <center>
	        <div class="boxer">
		    <h3>Проверить домен</h3>
		    <form id="FormCheckDomain">
		    <label for="checkDomain">Введите домен донора<br />
			<span class="mini_notice">Проверка домена в базе статей.<br />Введите без http:// и без www.</span></label>
			<br />
			<input type="text" id="checkDomain" name="checkDomain" size="23" value="" />
			<br />
			<label for="checkDomainAktseptor">Введите домен акцептора<br />
			<span class="mini_notice">Введите без http:// и без www.</span></label>
			<br />
			<input type="text" id="checkDomainAktseptor" name="checkDomainAktseptor" size="23" value="" />
			<br /><br />
			<div id="CheckDomainAnswer"></div>
			<button id="BtncheckDomain" class="button" name="BtncheckDomain" tabindex="5" type="submit">Проверить домен</button>
	        <img id="CheckDomainLoader" src="image/form_hider.gif" />
		    </form>
		    </div>
		    </center>
		    <!-- / Проверка домена -->
		</div>
		
		<div class="grid_10">
		    <br />
            <!-- Проверка домена -->
		    
	        <div class="boxer">
		    <center>
		        <h3>Miralinks аккаунты. <br /><span class="mini_notice">Список аккаунтов в системе Miralinks.Ru<br />Используются для автоматической модерации статей.</span></h3>
			</center>	
				<!-- Показать список аккаунтов Miralinks -->
				<div id="ListMiraAccounts">
				     <?=ShowMiralinksAccounts($_SESSION[id]);?>
				</div>
				<!-- / End Показать список аккаунтов Miralinks -->
				<!-- Добавление аккаунта MiraLinks -->
				<div style="background:#FFCC66;border-radius:10px;">
				<center>
				<h3>Добавить Miralinks аккаунт</h3>
				<form id="AddMiraAccount">
				    <label for="MiraAccountLogin">Введите логин</label>
			        <br />
			        <input type="text" id="MiraAccountLogin" name="MiraAccountLogin" size="23" value="" />
					<br />
					<label for="MiraAccountPassword">Введите пароль</label>
			        <br />
			        <input type="text" id="MiraAccountPassword" name="MiraAccountPassword" size="23" value="" />
					<br /><br />
					<div id="AddMiraAccountAnswer"></div>
					<button id="BtnAddMiraAccount" class="button" name="BtnAddMiraAccount" tabindex="5" type="submit">Добавить аккаунт</button>
	                <img id="CheckAddedMiraAccount" src="image/form_hider.gif" />
					<br /><br />
				</form>
				</center>
				</div>
				<!-- / End Добавление аккаунта MiraLinks -->
			</div>	
			
			<!-- / End Проверка домена -->
		</div>
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