<?php
    session_start();
    if($_SESSION[isAdmin] == false) die("Авторизуйтесь.<br /> <a href='/'>Вернуться на главную</a>"); 
    require_once 'mysql_connect.php';
    require_once 'mysql_qw.php'; 
    require_once 'miralinks.php';
    $miralinks = new Miralinks();
   
    $OutData = array();
	$OutData['error'] =0;
    $id = $_POST['id'];
    //Получаем из MySQL логин и пароль данного Mira акка, плюс проверка id админа
    $r = mysql_qw("SELECT * FROM art_miralinks WHERE id =? AND id_admin =?", $id, $_SESSION[id]);
    if(mysql_num_rows($r) < 1) 
	    { 
	       header("Content-type: text/json");
		   $OutData['error'] =1; 
		   echo json_encode($OutData);
		   return; 
	    }
    $row = mysql_fetch_object($r);
    //Авторизация в Miralinks
    $rez = $miralinks->Authorize($row->login, $row->password);
    if($rez == false) 
	    { 
		    header("Content-type: text/json");
  		    $OutData['error'] =2; 
			echo json_encode($OutData);
			return; 
		}
  	//Узнаем ID проектов - получив готовый список SELECT	                   
    $ArraySelect = $miralinks->ParseIdAndNameProjectsMiralinks();
	if($ArraySelect['error'] == 1) 
	    { 
		    header("Content-type: text/json");
  		    $OutData['error'] =3; 
			$OutData['errorText'] = $ArraySelect['errorText']; 
			echo json_encode($OutData);
			return; 
		}
	$OutData['error'] =0;	
	$OutData['select'] = $ArraySelect['select'];
	header("Content-type: text/json");
	echo json_encode($OutData);
	return; 
?>