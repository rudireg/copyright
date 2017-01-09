<?php
session_start(); 
if($_SESSION[isAdmin] == false) die("Авторизуйтесь.<br /> <a href='/'>Вернуться на главную</a>");
require_once 'mysql_connect.php';
require_once 'mysql_qw.php';
require_once 'database.php';

$idCopyMan = $_POST['idCopyMan'];

if(!isset($_POST['idCopyMan']))
  {
    echo '<span style="background:red;padding:5px;">Ошибка</span>';
    return;
  }

//Проверяем есть ли статьи в работе или на модерации
$r = mysql_qw("SELECT COUNT(*) FROM art_article WHERE id_copyright =?", $idCopyMan);
$row = mysql_fetch_row($r);
$total = $row[0];
if($total > 0)
  {
    echo '<span style="background:red;padding:0px;margin:5px;">Вы не можете удалить копирайтера, так как у него есть статьи в работе.</span>';
    return;
  }
mysql_qw("DELETE FROM art_copyright WHERE id=?", $idCopyMan);
echo '<span style="background:green;padding:5px;">Успешно</span>';

?>