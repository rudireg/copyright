<?php
   session_start();
   require_once 'mysql_connect.php';
   require_once 'mysql_qw.php';
	
   $login    = $_POST['login'];
   $password = $_POST['password'];
   $email    = $_POST['email'];
   $icq      = $_POST['icq'];
   
   $OutData  = array();
   $OutData['error'] =0;
   
    if(!isset($_POST['login']) || !isset($_POST['password']) || !isset($_POST['email']))
     {
	          header("Content-type: text/json");
	          $OutData['error'] = '1'; 
	          print json_encode($OutData);
	          return;
	 }
	//Проверяем в базе админов на наличие дубликатов логинов
	$r = mysql_qw("SELECT login FROM art_admin WHERE login =?", $login);
	if(mysql_num_rows($r) > 0)
	 {
	          header("Content-type: text/json");
	          $OutData['error'] = '2'; 
	          print json_encode($OutData);
	          return;
	 }
	//Проверяем в базе админов на наличие дубликатов логинов
	$r = mysql_qw("SELECT login FROM art_copyright WHERE login =?", $login);
	if(mysql_num_rows($r) > 0)
	 {
	          header("Content-type: text/json");
	          $OutData['error'] = '2'; 
	          print json_encode($OutData);
	          return;
	 } 
	//Проверяем в базе на наличие дубликатов email
	$r = mysql_qw("SELECT email FROM art_admin WHERE email =?", $email);
	if(mysql_num_rows($r) > 0)
	 {
	          header("Content-type: text/json");
	          $OutData['error'] = '3'; 
	          print json_encode($OutData);
	          return;
	 }
    //Заносим данные юзера в базу данных
	$notes = 'Email: '.$email.' ICQ: '.$icq;
	mysql_qw("INSERT INTO `rudi_article`.`art_admin` (`id` ,`login` ,`password` ,`email` ,`icq` ,`my_site` ,`note`) VALUES (NULL , ?, ?, ?, ?, '', ?)", $login, $password, $email, $icq, $notes);
	
	header("Content-type: text/json");
	$OutData['reg'] = '1'; 
	print json_encode($OutData);
	return;

?>