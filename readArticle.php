<?php
   session_start(); 
   if($_SESSION[isAdmin] == false && $_SESSION[isUser] == false) die("�������������.<br /> <a href='/'>��������� �� �������</a>"); 
   require_once 'mysql_connect.php';
   require_once 'mysql_qw.php'; 
   require_once 'database.php';
   
   $idArticle = $_POST['idArticle'];
   if(!isset($idArticle)) {echo "�� ������� ������"; return;}
   
   readArticle($idArticle);
   
   
?>