<?php 
    session_start(); 
	if($_SESSION[isAdmin] == false && $_SESSION[isUser] == false) die("�������������.<br /> <a href='/'>��������� �� �������</a>"); 
    require_once 'mysql_connect.php';
    require_once 'mysql_qw.php'; 

	function CountAllFreeArtByIdAdmin222(){
	    return "111111111";
	}

?>