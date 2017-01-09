<?php
    session_start(); 
	if($_SESSION[isAdmin] == false) die("Авторизуйтесь.<br /> <a href='/'>Вернуться на главную</a>"); 
    require_once 'mysql_connect.php';
    require_once 'mysql_qw.php'; 
    require_once 'database.php';
	
	$OutData = array();
	$login    = $_POST['login'];
    $password = $_POST['password'];

	$OutData['error'] = 0;
	if(!isset($_POST['login']) || !isset($_POST['password']))
       {
            $OutData['error'] = 1;
	        header("Content-type: text/json");
	        echo json_encode($OutData);
	        return;
       }
	//Проверить на дубликат
	$r = mysql_qw("SELECT login FROM art_miralinks WHERE login =?", $login);
	if(mysql_num_rows($r) > 0)
	   {
            $OutData['id'] = -1;
	        header("Content-type: text/json");
	        echo json_encode($OutData);
	        return;
       }
	//Занести логин и пароль в базу
	mysql_qw("INSERT INTO art_miralinks (`id` ,`id_admin` ,`login` ,`password`) VALUES (NULL , ?, ?, ?)",
    	     $_SESSION[id], $login, $password);
	
	$r = mysql_qw("SELECT id FROM art_miralinks WHERE login =?", $login);
	$row = mysql_fetch_object($r);
	
	
    $OutData['id']    = $row->id;
	$OutData['login'] = $login;
	header("Content-type: text/json");
	echo json_encode($OutData);
?>