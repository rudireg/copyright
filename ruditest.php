<?php 
    session_start(); 
	if($_SESSION[isAdmin] == false && $_SESSION[isUser] == false) die("Авторизуйтесь.<br /> <a href='/'>Вернуться на главную</a>"); 
    require_once 'mysql_connect.php';
    require_once 'mysql_qw.php'; 

	function CountAllFreeArtByIdAdmin222(){
	    return "111111111";
	}

?>