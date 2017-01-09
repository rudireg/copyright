<?php
   session_start(); 
   if($_SESSION[isAdmin] == false && $_SESSION[isUser] == false) die("Авторизуйтесь.<br /> <a href='/'>Вернуться на главную</a>"); 
   require_once 'mysql_connect.php';
   require_once 'mysql_qw.php'; 
   require_once 'database.php';
   
   $OutData =array();
   $idArticle = $_POST['idArticle'];
   $type = $_POST['type'];
   if(!isset($_POST['idArticle']) || !isset($_POST['type']))
     {
		header("Content-type: text/json");
		$OutData['error']     = 1;
		$OutData['idArticle'] =0;
		$OutData['type'] =0;
		echo json_encode($OutData);
		return;
	 }
    //Удаление
    deleteArticle($idArticle);
	
    header("Content-type: text/json");
    $OutData['error']     = 0;
	$OutData['type']      = $type;
	$OutData['idArticle'] = $idArticle;
    echo json_encode($OutData);
?>