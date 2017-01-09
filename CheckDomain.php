<?php
session_start(); 
if($_SESSION[isAdmin] == false) die("Авторизуйтесь.<br /> <a href='/'>Вернуться на главную</a>");
require_once 'mysql_connect.php';
require_once 'mysql_qw.php';
require_once 'database.php';

$OutData = array();

$checkdomain          = $_POST['checkDomain'];
$checkDomainAktseptor = $_POST['checkDomainAktseptor'];

if(!isset($_POST['checkDomain']) || !isset($_POST['checkDomainAktseptor']))
  {
    $OutData['error'] = 1;
	header("Content-type: text/json");
	echo json_encode($OutData);
	return;
  }

 $r = mysql_qw("SELECT id FROM art_article WHERE url_area =? AND url_seosite =? AND id_admin =?", 
                $checkdomain, $checkDomainAktseptor, $_SESSION[id]); 
 if(mysql_num_rows($r) < 1)
    {
        $OutData['error']     = 0;
		$OutData['idArticle'] = 0;
	    header("Content-type: text/json");
	    echo json_encode($OutData);
	    return;
    }
 $row = mysql_fetch_object($r);
 
 $OutData['error']     = 0;
 $OutData['idArticle'] = $row->id;
 header("Content-type: text/json");
 echo json_encode($OutData);
?>