<?php
  session_start(); 
  if($_SESSION[isAdmin] == false) die("Авторизуйтесь.<br /> <a href='/'>Вернуться на главную</a>");
  require_once 'database.php';
  require_once 'order_menu.php'
  
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

<script type="text/javascript">
//------------------------------------
function ShowFreeArtNoCopyman(){
   $("#BlockInfoCopyman").hide();
   $("#ListArticles").html("");
   $("#ListArticles").hide();
   $("img#ListArticlesLoader").attr("src", "image/pre.gif");
   $("img#ListArticlesLoader").show();
   $("#BlockListArticles").show();
   
   var SleepListArticle = function(){ 
	       $("img#ListArticlesLoader").attr("src", "image/WhitePixel.gif");
	       $("img#ListArticlesLoader").hide(); 
		   $("#ListArticles").show();
		   $("#ListArticles").load("ShowListArticle.php", {idCopyMan:0,type:0}, function(){   });
		};   

    setTimeout(SleepListArticle, 1000); 
	return false;	
}
//------------------------------------
</script>		
		
		
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
    <div class="grid_6 alpha">
	    <br />
	    <!-- Кол. свободных заданий не привязанных к копирайтеру -->
	    <div class="boxer">
		<table cellspacing="5" width="300">
		    <tr>
		        <td align="left"><span>Свободные задания</span><br /><span class="mini_notice">Не привязанны к копирайтеру</span></td>
		        <td align="right"><span onclick="ShowFreeArtNoCopyman();" class="highlited red underLine pointer"><?=CountFreeArticleNoCopymanByIdAdmin($_SESSION[id]);?></span></td>
			</tr>   
		</table>	
		</div>
	    <!-- / Кол. свободных заданий не привязанных к копирайтеру -->
		<br />
        <!-- Таблица коирайтеров -->
		 <div class="boxer">
		 <div class="table_order_copyman">
		 <center><h2>Выберете копирайтера</h2></center>
		 <hr>
         <table>
		     <tr>
		     <th><span id="copyman">Копирайтер</span></th>
			 <th><span id="inwork">Статьи на выполнении</span></th>
			 <th><span id="inmoder">Статьи на модерации</span></th>
			 <th><span id="inpaid">Статьи на&nbsp;оплату</span></th>
		     </tr>
			 <tr><td colspan="4"><hr></td></tr>
			 <?=ShowStatCopyMan();?>
		 </table>
		 </div>
		 </div>
    </div>
	<div class="grid_10 omega">
	     <br />
	
	    <!-- Личные данные копирайтера -->
        <div id="BlockInfoCopyman" class="BlockInfoCopyman">    
		     <center><img id="InfoCopymanLoader" src="image/WhitePixel.gif" /></center>
		     <div id="InfoCopyman"></div>
        </div>
	    <!-- / Личные данные копирайтера -->
	
	    <!-- Список статей -->
	    <div id="BlockListArticles" class="BlockListArticles">  
	         <center><img id="ListArticlesLoader" src="image/WhitePixel.gif" /></center>
             <div id="ListArticles"></div> 
	    </div>	 
	    <!-- / Список статей -->
	
	</div>
</div>
<div class="clear"></div>








<!-- ---------------------------------------- -->
<!-- Тут модальное окно -->
		<!-- article modal content -->
		<div id="article-modal-content">
			<h3>Редактирование статьи.</h3>
			
<div class="form_box">
<form id="FormEditArticle">
    <table>
	<td><label for="idEditArticle">ID статьи: </label></td>
	<td><input id="idEditArticle" name="idEditArticle" type="text" size="10" readonly /></td>	
	<tr><td colspan="2"><hr></td></tr>
	<tr>
	<td valign="top"><label>Копирайтер <br /><span class="mini_notice">(по желанию)</span></label></td>
	<td valign="top">
	    <select id="selectCopyMan">
                <option selected value="0">Выберите копирайтера</option>
				<?=GetAllCopymanID();?>
		</select>			
	</td>
	</tr>
	<tr><td colspan="2"><hr></td></tr>
    <tr>
	<td valign="top"><label for="orderDescription">Описание<br /><span class="mini_notice">Видите только Вы</span></label></td>
	<td valign="top"><textarea id="orderDescription" rows="5" cols="27" name="orderDescription"></textarea></td>
	</tr>
	<tr><td colspan="2"><hr></td></tr>
	<tr>
	<td><label for="MetaTitle" >META title<br /><span class="mini_notice">Заглавие страницы</span></label></td>
	<td><input id="MetaTitle" name="MetaTitle" type="text" size="31" placeholder="Заглавие страницы" /></td>
	</tr>
	<tr><td colspan="2"><hr></td></tr>
	<tr>
	<td valign="top"><label for="MetaKeywords" >META keywords <span class="red">*</span><br /><span class="mini_notice">Ключ. слова c каждой строки через запятую.</span><label></td>
	<td valign="top"><textarea id="MetaKeywords" rows="5" cols="27" name="MetaKeywords"></textarea></td>
	</tr>
	<tr><td colspan="2"><hr></td></tr>
	<tr>
	<td valign="top"><label for="MetaDescription">META description<br /><span class="mini_notice">Краткое описание</span></label></td>
	<td valign="top"><textarea id="MetaDescription" rows="5" cols="27" name="MetaDescription"></textarea></td>
	</tr>
	<tr><td colspan="2"><hr></td></tr>
    <tr>
	<td><label for="MetaH1">&lt;H1&gt;<br /><span class="mini_notice">Заголовок статьи</span></label></td>
	<td><input id="MetaH1" name="MetaH1" type="text" size="31" placeholder="Заголовок статьи" /></td>
	</tr>
	<tr>
	<td><label for="snippet">snippet <br /><span class="mini_notice">Краткое содержание статьи</span></label></td>
	<td valign="top"><textarea id="snippet" rows="5" cols="30" name="snippet"></textarea></td>
	</tr>
	<tr>
	<td><label for="content">Содержание<br /><span class="mini_notice">Полное содержание статьи</span></label></td>
	<td valign="top"><textarea id="content" rows="15" cols="30" name="content"></textarea></td>
	</tr>
    <tr><td colspan="2"><hr></td></tr>
    <tr>
	<td><label for="WantURL">Желаемый URL статьи</label></td>
	<td><input id="WantURL" name="WantURL" type="text" size="31" placeholder="Желаемый URL" /></td>
	</tr>
	<tr><td colspan="2"><hr></td></tr>
	<tr>
	<td><label for="SeoURL">URL продвигаемого сайта <span class="red">*</span><br /><span class="mini_notice">Без http:// и без www.</span></label></td>
	<td><input id="SeoURL" name="SeoURL" type="text" size="31" placeholder="seo.ru" /></td>
	</tr>
	<tr><td colspan="2"><hr></td></tr>
    <tr>
	<td><label for="AreaURL">URL площадки <span class="red">*</span><br /><span class="mini_notice">Без http:// и без www.</span></label></td>
	<td><input id="AreaURL" name="AreaURL" type="text" size="31" placeholder="area.ru" /></td>
	</tr>
	<tr><td colspan="2"><hr></td></tr>
	<tr>
	<td><label for="MiraAreaURL">MiraUrl профайла</label></td>
	<td><input id="MiraAreaURL" name="MiraAreaURL" type="text" size="31" placeholder="URL Mira профайла" /></td>
	</tr>
	<tr><td colspan="2"><hr></td></tr>
    <tr>
	<td><label for="CountLetter">Кол. символов <span class="red">*</span></label></td>
	<td><input id="CountLetter" name="CountLetter" type="text" size="31" placeholder="2000" value="2000"/></td>
	</tr>
	<tr><td colspan="2"><hr></td></tr>
    <tr>
	<td><label for="CountUrl">Кол. URL <span class="red">*</span></label></td>
	<td><input id="CountUrl" name="CountUrl" type="text" size="31" placeholder="2" value="2" /></td>
	</tr>
	<tr><td colspan="2"><hr></td></tr>
    <tr>
	
	
	
	
	
	
    <td valign="top"><label for="KeyWordsForCopyman">Ключ. слова <br />Для копирайтера<br /><span class="mini_notice">Формат [Ключ:URL]</span></label></td>
	<td valign="top"><textarea id="KeyWordsForCopyman" rows="5" cols="27" name="KeyWordsForCopyman"></textarea></td>
	</tr>
	<tr><td colspan="2"><hr></td></tr>
	<tr>
    <td valign="top"><label for="ConditionArea">Требования площадки</label></td>
	<td valign="top"><textarea id="ConditionArea" rows="5" cols="27" name="ConditionArea"></textarea></td>
	</tr>
	<tr><td colspan="2"><hr></td></tr> 
	<tr>
	<td><label for="Price1000" >Ставка за 1000 символов (руб.) <span class="red">*</span></label></td>
	<td><input id="Price1000" name="Price1000" type="text" size="31" placeholder="70" value="70" /></td>
	</tr>
	<tr><td colspan="2"><hr></td></tr> 
	<tr>
	<td colspan="2" align="center">
	<div id="OrderArticleAnswer"></div>
	<button id="ButtonOrderArticle" class="button" name="submit_login" tabindex="5" type="submit">Редактировать</button>
	<img id="OrderArticleLoader" src="image/form_hider.gif" />
	
	</td>
	</tr>  
	</table>
    </form>
    </div><!-- end <div class="form_box"> -->
	</div>

	<!-- preload the images -->
	<div style='display:none'>
	    <img src='image/x.png' alt='' />
	</div>
<!-- / Тут модальное окно -->
<!-- ---------------------------------------- -->








<!-- Подвал -->
<div class="footer">
<p class="mini_notice">Сервис заказа статей у своих копирайтеров.<br />2012 - <a href="http://art.botinok.in">http://art.botinok.in</a></p>
</div>
<!-- / Подвал -->
</body>
</html>