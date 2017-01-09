<?php
session_start(); 
if($_SESSION[isAdmin] == false) die("Авторизуйтесь.<br /> <a href='/'>Вернуться на главную</a>");
require_once 'mysql_connect.php';
require_once 'mysql_qw.php';
require_once 'database.php';

$OutData = array();

$login    = $_POST['login'];
$password = $_POST['password'];
$wmr      = $_POST['wmr'];
$wmz      = $_POST['wmz'];
$qiwi     = $_POST['qiwi'];
$email    = $_POST['email'];
$icq      = $_POST['icq'];

if(!isset($_POST['login']) || !isset($_POST['password']))
  {
    $OutData['error'] = 1;
	header("Content-type: text/json");
	echo json_encode($OutData);
	return;
  }

  //Проверка - есть ли такой логин уже зарегестрированный в базе копирайтеров
  $r = mysql_qw("SELECT id FROM art_copyright WHERE login=?", $login);
  if(mysql_num_rows($r) > 0)
  {
    $OutData['error']  = 0;
	$OutData['status'] = 0;
	header("Content-type: text/json");
	echo json_encode($OutData);
	return;
  }
  //Проверка - есть ли такой логин уже зарегестрированный в базе копирайтеров
  $r = mysql_qw("SELECT id FROM art_admin WHERE login=?", $login);
  if(mysql_num_rows($r) > 0)
  {
    $OutData['error']  = 0;
	$OutData['status'] = 0;
	header("Content-type: text/json");
	echo json_encode($OutData);
	return;
  }
  
  mysql_qw("INSERT INTO art_copyright (id, idmyadmin, login, password, my_wmr, my_wmz, my_qiwi, email, icq) VALUES (NULL , ?, ?, ?, ?, ?, ?, ?, ?)", 
            $_SESSION[id], $login, $password, $wmr, $wmz, $qiwi, $email, $icq);
  
    $OutData['error'] = 0;
	$OutData['status'] = 1;
	header("Content-type: text/json");
	echo json_encode($OutData);
?>