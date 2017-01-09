<?php
session_start(); 
if($_SESSION[isAdmin] == false) die("Авторизуйтесь.<br /> <a href='/'>Вернуться на главную</a>");
require_once 'mysql_connect.php';
require_once 'mysql_qw.php';
require_once 'database.php';

$OutData = array();

$idCopyMan          = $_POST['idCopyMan'];
$orderDescription   = $_POST['orderDescription'];
$MetaTitle          = $_POST['MetaTitle'];
$MetaKeywords       = $_POST['MetaKeywords'];
$MetaDescription    = $_POST['MetaDescription'];
$MetaH1             = $_POST['MetaH1'];
$WantURL            = $_POST['WantURL'];
$SeoURL             = $_POST['SeoURL'];
$AreaURL            = $_POST['AreaURL'];
$MiraAreaURL        = $_POST['MiraAreaURL'];
$CountLetter        = $_POST['CountLetter'];
$CountUrl           = $_POST['CountUrl'];
$KeyWordsForCopyman = $_POST['KeyWordsForCopyman'];
$ConditionArea      = $_POST['ConditionArea'];
$Price1000          = $_POST['Price1000'];
$AutoModer          = $_POST['AutoModer'];
$IdMiraAccount      = $_POST['IdMiraAccount']; 
$IdMiraProject      = $_POST['IdMiraProject'];
$LoginMiraAccount   = $_POST['LoginMiraAccount'];

//Проверка првильности введенных данных
 if($idCopyMan < 0 || strlen($MetaKeywords) < 1 || strlen($SeoURL) < 1 || strlen($AreaURL) < 1 || $CountLetter < 1 || $CountUrl < 1 ||  strlen($KeyWordsForCopyman) < 1 || $Price1000 < 1)
 {
    header("Content-type: text/json");
	$OutData['status'] = '0'; 
	print json_encode($OutData);
	return;
 }
 //Проверка правильности внесения данных автомодерации
 if($AutoModer == 1)
   {
        if(!isset($_POST['IdMiraAccount']) || $IdMiraAccount == -1)
	      {
              header("Content-type: text/json");
	          $OutData['status'] = '0'; 
	          print json_encode($OutData);
	          return;
          }
   }
 
$currTime =0;
if($idCopyMan > 0) $currTime = time();

//Добавляем в MySQL
mysql_qw("INSERT INTO art_article (`id`,`id_admin`,`id_copyright`,`auto_moder`,`id_mira_acc`,`login_mira_acc`,`id_mira_project`,`description`,`metatitle`,`metakeywords`,`metadescription`,`slug`,`title`,
`snippet`,`content`,`url_seosite`,`url_area`,`mira_url_area`,`count_letter`,`count_url`,`keyword_admin`,`conditions`,`date_take`,`date_moder`,
`date_money`,`price`) VALUES (NULL ,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,0,0,?)", $_SESSION[id],$idCopyMan,$AutoModer,$IdMiraAccount,$LoginMiraAccount,$IdMiraProject,$orderDescription,$MetaTitle,$MetaKeywords,$MetaDescription,$WantURL,$MetaH1,'','',$SeoURL,$AreaURL,$MiraAreaURL,$CountLetter,$CountUrl,$KeyWordsForCopyman,$ConditionArea,$currTime,$Price1000);

    header("Content-type: text/json");
	$OutData['status'] = '1'; 
	print json_encode($OutData);
	return;
?>

