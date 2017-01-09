<?php 
    require_once 'mysql_connect.php';
    require_once 'mysql_qw.php';
	
    $login= $_POST['login'];
    $pass  = $_POST['password'];
	
    //session_name('rudi');
    session_start();
	if(strlen($login) < 3 || strlen($pass) < 3) die("Не верные данные входа. <br /> <a href='/index.php'>Вернуться на страницу авторизации.</a>");
    //Проверяем данные в базе данных админа
	$rezult = mysql_qw("SELECT id, login, my_site FROM art_admin WHERE login = ? AND password = ?", $login, $pass);
	
	$count = (int) mysql_num_rows($rezult);
	//Если авторизация админа успешна
	if($count > 0)
	  {
	     $_SESSION[isAdmin] = true;
		 $_SESSION[isUser]  = false;
		 $row = mysql_fetch_object($rezult);
         $_SESSION[id]      = $row->id;	
		 $_SESSION[login]   = $row->login;
		 $_SESSION[my_site]   = $row->my_site;	 
		 
         header('Location: /order_profile.php');		 
	  }
	else
	  { 	   
		    $rezult = mysql_qw("SELECT id, idmyadmin, login FROM art_copyright WHERE login =? AND password =?", $login, $pass);
        	$count = mysql_num_rows($rezult);   
            //Если авторизация копирайтиера успешна
	        if($count > 0)
	           {
			        $_SESSION[isAdmin]   = false;
		            $_SESSION[isUser]    = true;
			        $row = mysql_fetch_object($rezult);
					$_SESSION[id]        = $row->id;	
		            $_SESSION[login]     = $row->login;
					$_SESSION[idmyadmin] = $row->idmyadmin;
			        header('Location: /copyright.php');	
			   }
            else
               {
                   $_SESSION[isAdmin] = false;
				   $_SESSION[isUser]  = false;
			       die("Не верный логин или пароль <br /> <a href='/index.php'>Вернуться на страницу авторизации.</a>");
			   }			 	 
	  }    
?>

 	 	 	 	



