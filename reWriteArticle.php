<?php
   session_start(); 
   if($_SESSION[isAdmin] == false && $_SESSION[isUser] == false) die("Авторизуйтесь.<br /> <a href='/'>Вернуться на главную</a>"); 
   require_once 'mysql_connect.php';
   require_once 'mysql_qw.php'; 
   require_once 'database.php';
   
    $OutData =array();
    $idArticle = $_POST['idArticle'];
    if(!isset($_POST['idArticle']))
     {
		header("Content-type: text/json");
		$OutData['error']     = 1;
		$OutData['idArticle'] = 0;
		echo json_encode($OutData);
		return;
	 }
	
    //Проверка, принадлжеит ли ID статьи данному модератору
    $r = mysql_qw("SELECT COUNT(*) FROM art_article WHERE id_admin =? AND id =?", $_SESSION[id], $idArticle); 	
	$row = mysql_fetch_row($r); 
	if($row[0] < 1)
	 {
		header("Content-type: text/json");
		$OutData['error']     = 1;
		$OutData['idArticle'] = 0;
		echo json_encode($OutData);
		return;
	 }
   
    //Обновляем дату модерации в 0
    mysql_qw("UPDATE art_article SET date_moder =0 WHERE id =?", $idArticle);
    header("Content-type: text/json");
	$OutData['error']     = 0;
	$OutData['idArticle'] = $idArticle;
	echo json_encode($OutData);

?>