<?php
session_start(); 
if($_SESSION[isUser] == false) die("Авторизуйтесь.<br /> <a href='/'>Вернуться на главную</a>");
require_once 'mysql_connect.php';
require_once 'mysql_qw.php';
require_once 'database.php';

function ShowOrderMenu(){
echo '<ul><li><a href="/copyright.php">Профайл <span class="order_login">'.$_SESSION[login].'</span></a></li>
<li><a href="/logout.php">Выход</a></li>'; 
//Если у копирайтера нет статей в работе и при этом есть новые задания - выводим сообщение о новой стате
if(isShowNewArticleMSG($_SESSION[id]) > 0)
   echo '<li><div onclick="ShowNewArticle();" class="new_tz hider">Есть новое задание</div></li>';
echo '</ul>';

}

?>