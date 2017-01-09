<?php
    session_start(); 
    if($_SESSION[isUser] == false) die("Авторизуйтесь.<br /> <a href='/'>Вернуться на главную</a>"); 
    require_once 'mysql_connect.php';
    require_once 'mysql_qw.php'; 
    require_once 'database.php';
	
	$idArticle = $_POST['idArticle'];
	if(!isset($_POST['idArticle']) || $idArticle < 1)
	  {
	     echo 'Ошибка';
         return;	  
	  }

	//Проверяем не взята ли статья уже - Если взята то выводим сообщение  о сожалении и проверяем есть ли новые статьи для работы
    //Если есть новые статьи  - то предлогаем взять новое задание...
    //Если нет новых статей -  то пишем что нет новых заданий.
	$r = mysql_qw("SELECT date_take FROM art_article WHERE id =?", $idArticle);
	if(mysql_num_rows($r) < 1)
	  {
	     echo 'Ошибка';
         return;	  
	  }
    $row = mysql_fetch_object($r);
	$date_take = $row->date_take;
	if($date_take > 0) //Если статью уже взяли
	  {
        echo '<center><p>К сожалению статью уже взял в работу другой копирайтер.<br />Возможно вы слишком долго думали.</p></center>';
		//Проверить наличие новых статей
		$idMyAdmin = GetIdAdminByIdCopyman($_SESSION[id]);
		$r = mysql_qw("SELECT id FROM art_article WHERE date_take <1 AND id_admin =?", $idMyAdmin);
		if(mysql_num_rows($r) < 1) 
		   { echo '<center>
		                   <h3>Новых заданий нет.</h3> 
						   <button type="submit" onclick="HideListNewTZArticle();">OK</button>
					</center>
		            '; 
		   }
		else                                                                          
		   {
		     echo '<center>
			               <h3>Есть другое задание.</h3> 
			               <button type="submit" onclick="ShowNewArticle();">Посмотреть новое задание</button>
				   </center>';
		   }
		return;
      }	  

    //Если текущая статья свободна... то инициализируем поля id_copyright и date_take	
	mysql_qw("UPDATE art_article SET id_copyright =?, date_take =? WHERE id =?", $_SESSION[id], time(), $idArticle);
	echo '<center><h3>Спасибо что приняли задание.</h3>
	      <button onclick="ShowPerformArticleTask();";>Приступить к выполнению</button>
		  </center>
		  ';
	
?>