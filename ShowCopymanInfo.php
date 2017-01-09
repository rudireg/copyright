<?php
   session_start(); 
   if($_SESSION[isAdmin] == false && $_SESSION[isUser] == false) die("Авторизуйтесь.<br /> <a href='/'>Вернуться на главную</a>"); 
   require_once 'mysql_connect.php';
   require_once 'mysql_qw.php'; 
   require_once 'database.php';
  
   $idCopyman = $_POST['idCopyMan'];
   if(!isset($_POST['idCopyMan'])) {echo "Нет данных копирайтера"; return 0;}
   
   $r = mysql_qw("SELECT * FROM art_copyright WHERE id =?", $idCopyman); 
   if(mysql_num_rows($r) < 1) {echo "Нет данных копирайтера"; return 0;};
   $row = mysql_fetch_object($r);
   $countInWork  = ArticleInWorkByIdCopyman($idCopyman);  
   $countInModer = ArticleInModerByIdCopyman($idCopyman);
   $countInPaid  = ArticleInPaidByIdCopyman($idCopyman);   

   echo ' <center><span class="headInfoText">Личные данные копирайтера:</span></center>
		  <hr> 
        <div id="CoprightInfo" class="CoprightInfo">
		<table width="700">
	    <tr>
	        <td valign="top">
			    <span>ID: '.$row->id.'</span><br />
			    <span>'.$row->login.'</span><br />
				<span class="mini_notice">Заработал: </span>';										
	echo '      <span class="highlighted red">'.GetHowManyMustPay($idCopyman).'</span><span class="mini_notice">руб.</span>
			</td>
		    <td valign="top"><span style="">Контакты:</span><br /><span>Email: '.$row->email.'</span><br /><span>ICQ:&nbsp;&nbsp;&nbsp;&nbsp; '.$row->icq.'</span></td>  
		    <td valign="top"><span>Реквизиты:</span><br />
			    <span>WMZ: '.$row->my_wmz.'</span><br />
			    <span>WMR: '.$row->my_wmr.'</span><br />
				<span>QIWI: '.$row->my_qiwi.'</span><br />
			</td>
	    </tr>
        </table>
		</div>
	<br />
	<center><span style="font-size:22px;">Статьи копирайтера:</span></center>
	<br />
	<table width="700">
	    <tr>
	        <td><span onclick="ShowListArticles('.$idCopyman.', 1);" class="inworking">В работе - <span id="CInWork">'.$countInWork.'</span></span></td>
	        <td><span onclick="ShowListArticles('.$idCopyman.', 2);" class="inmodering">На модерации - <span id="CInModer">'.$countInModer.'</span></span></td>
	        <td><span onclick="ShowListArticles('.$idCopyman.', 3);" class="inpaiding">На оплату - <span id="CInPaid">'.$countInPaid.'</span></span></td>
	    </tr>
	</table>
	<hr>
	
	';  

?>

