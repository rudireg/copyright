<?php
session_start(); 

if($_SESSION[isAdmin] == false) die("Авторизуйтесь.<br /> <a href='/'>Вернуться на главную</a>");

function ShowOrderMenu(){
echo '<div class="top_menu_box"><ul>
<li><a href="/order_profile.php">Профайл <span class="order_login">'.$_SESSION[login].'</span></a></li>
<li><a href="/order.php">Заказать статью</a></li>
<li><a href="/order_stat.php">Статистика</a></li>
<li><a href="/logout.php">Выход</a></li>
</ul>';


echo '<a href="/order_stat.php"></a>
      <div class="order_msg">
      <div id="order_line">
       <table border="0" >
	   <tr>
	       <td id="free"><a href="/order_stat.php">Свободны - <span class="highlighted big">'.CountAllFreeArtByIdAdmin($_SESSION[id]).'</span></a></td> 
		   
		   <td id="work"><a href="/order_stat.php">В работе - <span class="highlighted big">'.CountAllWorkArtByIdAdmin($_SESSION[id]).'</span></a></td> 
           		   
	       <td id="moder"><a href="/order_stat.php">Модерация - <span class="highlighted big"><span class="highlighted big">'.CountAllModerArtByIdAdmin($_SESSION[id]).'</span></a></td> 
	       <td id="pay"><a href="/order_stat.php">На оплату - <span class="highlighted big"><span class="highlighted big">'.CountAllPayArtByIdAdmin($_SESSION[id]).'</span></a></td> 
	   </tr>	   
	   </table>
	</div>   
    </div>
	</div>'; 
}

?>