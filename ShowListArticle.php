<?php
   session_start(); 
   if($_SESSION[isAdmin] == false && $_SESSION[isUser] == false) die("Авторизуйтесь.<br /> <a href='/'>Вернуться на главную</a>"); 
   require_once 'mysql_connect.php';
   require_once 'mysql_qw.php'; 
   require_once 'database.php';
   
   $idCopyman = $_POST['idCopyMan'];
   $type      = $_POST['type'];  
   if(!isset($_POST['idCopyMan']) || !isset($_POST['type'])) {echo "Не верный запрос."; return 0;}

   if($type == 0)        //Показать свободные статьи нет привязанные к копирайтеру
     {
         $r = mysql_qw("SELECT id,auto_moder,id_mira_acc,login_mira_acc,title,date_take,date_moder,date_money,url_area,count_letter,url_seosite,price FROM art_article WHERE id_copyright =0 AND id_admin =?", $_SESSION[id]); 
     }	 
   else if($type == 1)       //Если показать статьи в работе
     {
	    $r = mysql_qw("SELECT id,auto_moder,id_mira_acc,login_mira_acc,title,date_take,date_moder,date_money,url_area,count_letter,url_seosite,price FROM art_article WHERE id_copyright =? AND date_take > 0 AND date_moder < 1 AND date_money < 1", $idCopyman); 
	 }
   else if($type == 2) //Если показать статьи на модерации
     {
	    $r = mysql_qw("SELECT id,auto_moder,id_mira_acc,login_mira_acc,title,date_take,date_moder,date_money,url_area,count_letter,url_seosite,price FROM art_article WHERE id_copyright =? AND date_take > 0 AND date_moder > 0 AND date_money < 1", $idCopyman); 
	 }
   else                 //Если показать оплаченые статьи 
        $r = mysql_qw("SELECT id,auto_moder,id_mira_acc,login_mira_acc,title,date_take,date_moder,date_money,url_area,count_letter,url_seosite,price FROM art_article WHERE id_copyright =? AND date_take > 0 AND date_moder > 0 AND date_money > 0", $idCopyman); 
   
    $count = mysql_num_rows($r);
	if($count < 1) {echo "<h3>Нет статей.</h3>"; return 0;}
	if($type == 0) {echo "<center><h2>Свободные задания без копирайтера.</h2></center>";}
	
	for($x=0; $x < $count; $x++)
	    {   
		   $row = mysql_fetch_object($r);  
           echo '<div id="one_article_'.$row->id.'" style="position:relative">';	
           if($type == 0)
            {
              echo'<div class="InFree">';
			  $date_time_array = getdate($row->date_take);
			  $date_take = "$date_time_array[year]"."/"."$date_time_array[mon]"."/"."$date_time_array[mday]"; 
			  $date_moder =0;
              $date_money =0;
            }			
		   else if($type == 1)     
		    {  
			  echo'<div class="InWork">';
			  $date_time_array = getdate($row->date_take);
			  $date_take = "$date_time_array[year]"."/"."$date_time_array[mon]"."/"."$date_time_array[mday]"; 
              $date_moder =0;
              $date_money =0;		 
			}  
		   else if($type == 2)
		    {
			  echo'<div class="InModer">';
			  $date_time_array = getdate($row->date_take);
			  $date_take = "$date_time_array[year]"."/"."$date_time_array[mon]"."/"."$date_time_array[mday]"; 
			  $date_time_array = getdate($row->date_moder);
			  $date_moder = "$date_time_array[year]"."/"."$date_time_array[mon]"."/"."$date_time_array[mday]"; 
			  $date_money = 0;
			}  
		   else 
            {
              echo'<div class="InPaid">';
			  $date_time_array = getdate($row->date_take);
			  $date_take = "$date_time_array[year]"."/"."$date_time_array[mon]"."/"."$date_time_array[mday]"; 
			  $date_time_array = getdate($row->date_moder);
			  $date_moder = "$date_time_array[year]"."/"."$date_time_array[mon]"."/"."$date_time_array[mday]"; 
			  $date_time_array = getdate($row->date_money);
			  $date_money = "$date_time_array[year]"."/"."$date_time_array[mon]"."/"."$date_time_array[mday]"; 
			}  
		    //Делаем вывод списка 
		    echo' <table width="680">
				  <tr><td>Тип модерации: ';
			if($row->auto_moder == 0)	
                echo '<span style="color:red;"><b>Ручной</b></span>';	
            else
				echo '<span style="color:green;"><b>Автомат</b></span> - <b>'.$row->login_mira_acc.'</b>';							  
		    echo '</td></tr>
		          <tr><td colspan="3"><b>'.$row->title.'</b></td></tr>
		          <tr>';
				  
			if($type != 0) echo '<td>Заказали: '.$date_take.'</td>';	
	 
			if($date_moder > 0)  echo '<td>Модерация: '.$date_moder.'</td>';
			else                 echo '<td></td>';
			if($date_money > 0)	 echo '<td>На оплату: '.$date_money.'</td>';	 
			else		         echo '<td></td>'; 
    
	        $fullPrice = $row->price * ($row->count_letter / 1000);
			echo'
 			      </tr>
		          <tr>
				     <td>Площадка: <a href="http://'.$row->url_area.'" target="_ablanc">'.$row->url_area.'</a></td>
					 <td>Кол. знаков: <b>'.$row->count_letter.'</b></td>
					 <td>Цена '.$fullPrice.' руб.</td>
				  </tr>
				  <tr>
				     <td>Акцептор: <a href="http://'.$row->url_seosite.'" target="_ablanc">'.$row->url_seosite.'</a></td>
					 <td></td>';
			if($type == 1 || $type == 0) echo '<td></td>';		 
			else if($type == 2) echo '<td><span id="payArticle" onclick="payedArticle('.$row->id.');" style="color:green;font-weight:bold;" title="Перенести статью в готовые к оплате">На оплату</span></td>';	 
			else		        echo '<td>Ждет оплату</td>';		 
			echo '</tr>
		          </table>
		          </div>';  
			echo 'ID: '.$row->id.' &nbsp;&nbsp;&nbsp;&nbsp; 
			      <span id="lookArticle" onclick="exportArticle('.$row->id.');">Экспортировать</span>
				  &nbsp;&nbsp;&nbsp;&nbsp; 
				  <span id="editArticle" onclick="editArticle('.$row->id.','.$type.');">Редактировать</span> 
				  &nbsp;&nbsp;&nbsp;&nbsp;';
			
			if($type == 2) //Если статья на модерации - показываем меню доработки статьи
			  {
                echo '<span id="reWriteArticle" onclick="reWriteArticle('.$row->id.','.$type.');">На доработку</span> 
				  &nbsp;&nbsp;&nbsp;&nbsp;';
              }
			
			echo '<span id="deleteArticle" onclick="deleteArticle('.$row->id.','.$type.');">Удалить</span>
				  <img style="position:absolute;bottom:0px;" id="loder_'.$row->id.'" src="image/WhitePixel.gif">';
			echo '<hr></div>';
		}
   
   
   
   
   
   

?>

