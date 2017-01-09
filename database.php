<?php
  session_start(); 
  if($_SESSION[isAdmin] == false && $_SESSION[isUser] == false) die("Авторизуйтесь.<br /> <a href='/'>Вернуться на главную</a>"); 
  require_once 'mysql_connect.php';
  require_once 'mysql_qw.php'; 
  

//--------------------------------------------
//Выборка юзеров
function GetAllCopymanID(){
  $r = mysql_qw("SELECT id, login FROM art_copyright WHERE idmyadmin =? ORDER BY login DESC", $_SESSION[id]);
  $count = mysql_num_rows($r);
  if($count < 1) return 0;
  for($i=0; $i < $count; $i++)
    {
	    $row = mysql_fetch_object($r);
		echo '<option class="selecters" id="'.$row->id.'" value="'.$row->id.'" >'.$row->login.'</option>';
	}
}
//---------------------------------------------
//Принимает URL для проверки наличия в базе.
//Проверка есть ли данная площадка в списке размещенных 
//Передается ID seo фадмина
//true  -  если площадка есть
//false - если площадки нету
function Check_AreaURL_in_List_by_idSeoAdmin($areaURL, $seoURL){
    $r = mysql_qw("SELECT id FROM art_article WHERE id_admin =? AND url_area =? AND url_seosite =?", 
                   $_SESSION[id], $areaURL, $seoURL); 

    if(mysql_num_rows($r) < 1) 
	   return false;
				   
	return true;			   
}
//---------------------------------------------
//Показать статистика копирайтеров
function ShowStatCopyMan(){
  $r = mysql_qw("SELECT id FROM art_copyright WHERE idmyadmin =? ORDER BY login ASC", $_SESSION[id]);
  if(mysql_num_rows($r) < 1) 
    {
	   echo "<td>Empty</td><td>0</td><td>0</td><td>0</td>";
	   return;
	}

  $countIdCopyman = mysql_num_rows($r);
  $zebra =0;
  for($i=0; $i<$countIdCopyman; $i++)
    {
	    $row     = mysql_fetch_object($r);
	    $login   = getLoginByIdCopyman($row->id);
		$inWork  = ArticleInWorkByIdCopyman($row->id); 
		$inModer = ArticleInModerByIdCopyman($row->id);
		$inPaid  = ArticleInPaidByIdCopyman($row->id);
		//Формируем 1 линию таблицы
		$zebra = $zebra + 1;
		$num  = $zebra % 2;
		if($num > 0) echo '<tr><td><span onclick="ShowInfoCopyman('.$row->id.');" class="CopymanFull underLine" id="'.$row->id.'" >'.$login.'</span></td><td>'.$inWork.'</td><td>'.$inModer.'</td><td>'.$inPaid.'</td></tr>';
		else          echo '<tr class="zebra"><td><span onclick="ShowInfoCopyman('.$row->id.');" class="CopymanFull underLine" id="'.$row->id.'">'.$login.'</span></td><td>'.$inWork.'</td><td>'.$inModer.'</td><td>'.$inPaid.'</td></tr>';
	}
}
//---------------------------------------------
//Получить IDadmin переданого IdCopyman как аргумент
function GetIdAdminByIdCopyman($IdCopyman)
{
    $r = mysql_qw("SELECT idmyadmin FROM art_copyright WHERE id =?", $IdCopyman);
	if(mysql_num_rows($r) < 1) return 0;
	$row = mysql_fetch_object($r);
	$id = $row->idmyadmin;
	return $id;
}
//---------------------------------------------
//Получить IDadmin из табицы art_article передав id статьи
function GetIdAdminByIdArticle($IdArticle)
{
    $r = mysql_qw("SELECT id_admin FROM art_article WHERE id =?", $IdArticle);
	if(mysql_num_rows($r) < 1) return 0;
	$row = mysql_fetch_object($r);
	$id = $row->id_admin;
	return $id;
}
//---------------------------------------------
//Получить логин 
function getLoginByIdCopyman($IdCopyman){
   $r = mysql_qw("SELECT login FROM art_copyright WHERE id=?", $IdCopyman);
   if(mysql_num_rows($r) < 1) return "error";
   $row = mysql_fetch_object($r);
   return $row->login;
}
//---------------------------------------------
//Получить колл. свободных заданий Не привязанны к копирайтеру
function CountFreeArticleNoCopymanByIdAdmin($idAdmin){
   $r = mysql_qw("SELECT COUNT(*) FROM art_article WHERE id_admin =? AND id_copyright =0 AND date_take <1", $idAdmin);
   if(mysql_num_rows($r) < 1) return 0;
   $row = mysql_fetch_row($r);
   $total = $row[0]; // всего записей
   return $total;
}
//---------------------------------------------
//Получить колл. статей - которые никто не взял - тоесть свободные
function ArticleInFreeByIdCopyman($idCopyman){
   $r = mysql_qw("SELECT COUNT(*) FROM art_article WHERE id_copyright =? AND date_take <1 AND date_moder <1 AND date_money <1", $idCopyman);
   if(mysql_num_rows($r) < 1) return 0;
   $row = mysql_fetch_row($r);
   $total = $row[0]; // всего записей
   return $total;
}
//---------------------------------------------
//Получить кол. статей в работе у копирайтера
function ArticleInWorkByIdCopyman($idCopyman){
   $r = mysql_qw("SELECT COUNT(*) FROM art_article WHERE id_copyright =? AND date_take >0 AND date_moder <1 AND date_money <1", $idCopyman);
   if(mysql_num_rows($r) < 1) return 0;
   $row = mysql_fetch_row($r);
   $total = $row[0]; // всего записей
   return $total;
}
//---------------------------------------------
//Получить кол. статей на модерации
function ArticleInModerByIdCopyman($idCopyman){
   $r = mysql_qw("SELECT COUNT(*) FROM art_article WHERE id_copyright =? AND date_take >0 AND date_moder >0 AND date_money <1", $idCopyman);
   $row = mysql_fetch_row($r);
   $total = $row[0]; // всего записей
   return $total;
}
//---------------------------------------------
//Получить кол. оплаченных статей  
function ArticleInPaidByIdCopyman($idCopyman){
   $r = mysql_qw("SELECT COUNT(*) FROM art_article WHERE id_copyright =? AND date_take >0 AND date_moder >0 AND date_money >0", $idCopyman);
   if(mysql_num_rows($r) < 1) return 0;
   $row = mysql_fetch_row($r);
   $total = $row[0]; // всего записей
   return $total;
}
//---------------------------------------------
//Удаление статьи
function deleteArticle($idArticle){
   mysql_qw("DELETE FROM art_article WHERE id =?", $idArticle);
}
//---------------------------------------------
//Считать статью из MySQL
function readArticle($idArticle){
   $r = mysql_qw("SELECT * FROM art_article WHERE id =?", $idArticle);
   if(mysql_num_rows($r) < 1) return 0;
   $row = mysql_fetch_object($r);
   $OutData = array();
   $OutData['id'] = $row->id;
   $OutData['id_admin'] = $row->id_admin;
   $OutData['id_copyright'] = $row->id_copyright;
   $OutData['description'] = $row->description;
   $OutData['metatitle'] = $row->metatitle;
   $OutData['metakeywords'] = $row->metakeywords;
   $OutData['metadescription'] = $row->metadescription;
   $OutData['slug'] = $row->slug;
   $OutData['title'] = $row->title;
   $OutData['snippet'] = $row->snippet;
   $OutData['content'] = $row->content;
   $OutData['url_seosite'] = $row->url_seosite;
   $OutData['url_area'] = $row->url_area;
   $OutData['mira_url_area'] = $row->mira_url_area;
   $OutData['count_letter'] = $row->count_letter;
   $OutData['count_url'] = $row->count_url;
   $OutData['keyword_admin'] = $row->keyword_admin;
   $OutData['conditions'] = $row->conditions;
   $OutData['date_take'] = $row->date_take;
   $OutData['date_moder'] = $row->date_moder;
   $OutData['date_money'] = $row->date_money;
   $OutData['price'] = $row->price;   

   header("Content-type: text/json");
   echo json_encode($OutData);
}
//---------------------------------------------
function ShowMyAdminInfoByMyID()
{
   $myAdminID = GetIdAdminByIdCopyman($_SESSION[id]);
   $r = mysql_qw("SELECT note FROM art_admin WHERE id =?", $myAdminID); 
   if(mysql_num_rows($r) < 1)
     {
	    echo "Нет данных";
		return;
	 }
   $row = mysql_fetch_object($r);
   echo $row->note;   
}
//---------------------------------------------
function ShowMyCopyrightData()
{
    $r = mysql_qw("SELECT * FROM art_copyright WHERE id =?", $_SESSION[id]);
    if(mysql_num_rows($r) < 1) 
	  {
	    echo"Ошибка чтения";
		return;
	  }
	$row = mysql_fetch_object($r);
    
	echo '
    <div>	
	<table border="0">
	<tr><td><span class="mini_notice">Мой ID: </span></td><td><span>'.$row->id.'</span></td></tr>
	<tr><td><span class="mini_notice">ID админа: </span></td><td><span>'.$row->idmyadmin.'</span></td></tr>
	<tr><td><span class="mini_notice">WMR: </span></td><td><span>'.$row->my_wmr.'</span></td></tr>
	<tr><td><span class="mini_notice">WMZ: </span></td><td><span>'.$row->my_wmz.'</span></td></tr>
	<tr><td><span class="mini_notice">QIWI: </span></td><td><span>'.$row->my_qiwi.'</span></td></tr>
	<tr><td><span class="mini_notice">Email: </span></td><td><span>'.$row->email.'</span></td></tr>
	<tr><td><span class="mini_notice">ICQ: </span></td><td><span>'.$row->icq.'</span></td></tr>
	</table>
	</div>
	';  
  
}
//---------------------------------------------
//Показать скока всего должны за не оплаченные статьи
function GetHowManyMustPay($idCopyman){
   $money =0;
   
   if($idCopyman < 1)
       $r = mysql_qw("SELECT price, count_letter FROM art_article WHERE id_copyright =? AND date_money >0", $_SESSION[id]);
   else
       $r = mysql_qw("SELECT price, count_letter FROM art_article WHERE id_copyright =? AND date_money >0", $idCopyman);
   
   $count = mysql_num_rows($r);
   if($count < 1) { echo '0'; return; }
   for($x=0; $x<$count;)
    {
	   $row = mysql_fetch_object($r);
	   //Высчитываем цену за статью
	   $count_letter = $row->count_letter;
	   $price        = $row->price;
	   $ArtPrice     = $price * ($count_letter / 1000); 
	   $money = $money + $ArtPrice;
	   $x = $x + 1;
	}
   
    echo $money;
}
//---------------------------------------------
//Если есть новые статьи и нет статей в работе - то показываем сообщение о наличии новых статьях
// 1 - показать
// 0 - не показывать
function isShowNewArticleMSG($idCopyman)
{
  //Получить кол. статей в работе  
  $ArtInWork = ArticleInWorkByIdCopyman($idCopyman);
  if($ArtInWork > 0) return 0;
  //Проверяем есть ли новые статьи без привязки к копирайтеру
  $newTZ = CountFreeArticleNoCopymanByIdAdmin($_SESSION[idmyadmin]);
  if($newTZ > 0) return 1;
  return 0;
}
//---------------------------------------------
//Посчитать все выполняющиеся статьи заказчика
function CountAllWorkArtByIdAdmin($idAdmin)
{
  $r= mysql_qw("SELECT COUNT(*) FROM art_article WHERE id_admin =? AND date_take >0 AND date_moder <1 AND date_money <1", $idAdmin);
  if(mysql_num_rows($r) < 1) return 0;
  $row = mysql_fetch_row($r);   
  $cnt = $row[0];	
  return $cnt; 	
}
//---------------------------------------------
//Посчитать все модерируемы статьи заказчика
function CountAllModerArtByIdAdmin($idAdmin)
{
  $r= mysql_qw("SELECT COUNT(*) FROM art_article WHERE id_admin =? AND date_take >0 AND date_moder >0 AND date_money <1", $idAdmin);
  if(mysql_num_rows($r) < 1) return 0;
  $row = mysql_fetch_row($r);   
  $cnt = $row[0];	
  return $cnt; 	
}
//---------------------------------------------
//Посчитать все статьи заказчика в очереди на оплату 
function CountAllPayArtByIdAdmin($idAdmin)
{
  $r= mysql_qw("SELECT COUNT(*) FROM art_article WHERE id_admin =? AND date_take >0 AND date_moder >0 AND date_money >0", $idAdmin);
  if(mysql_num_rows($r) < 1) return 0;
  $row = mysql_fetch_row($r);   
  $cnt = $row[0];	
  return $cnt; 	
}
//---------------------------------------------  
//Посчитать все статьи заказчика в очереди на оплату 
function CountAllFreeArtByIdAdmin($idAdmin)
{
  $r= mysql_qw("SELECT COUNT(*) FROM art_article WHERE id_admin =? AND date_take <1 AND date_moder <1 AND date_money <1", $idAdmin);
  if(mysql_num_rows($r) < 1) return 0;
  $row = mysql_fetch_row($r);   
  $cnt = $row[0];	
  return $cnt; 	
}
//--------------------------------------------- 
//Показать список логинов в системе Miralinks
function ShowMiralinksAccounts($idAdmin)
{
    //Показать список аккаунтов в miralinks системе
	$r = mysql_qw("SELECT * FROM art_miralinks WHERE id_admin =?", $idAdmin); 
	$count = mysql_num_rows($r);
	if($count < 1) {echo '<div id="NoticeNoMiraAcc"><center><p style="color:red;">Нет аккаунтов в системе Miralinks</p></center></div>'; return;};
	for($i=0; $i<$count; $i++)
	   {
	        $row = mysql_fetch_object($r);
		 	echo '<div id="area_'.$row->id.'" style="margin-left:50px; margin-bottom:5px; position:relative;">
				           <a onclick="DellMiraAccount('.$row->id.');" title="Удалить" style="cursor:pointer;">
						   <img src="image/x.png" width="25" height="25" style="position:relative; top:8px;"/></a>
						   &nbsp;&nbsp;&nbsp;<img src="image/pixel.png" id="loder_'.$row->id.'" style="position:absolute;left:40px;top:10px;"/>'.$row->login.'
				  </div>';		
	   }
}
//---------------------------------------------
//Показать список Miralinks аккаунтов для создания проекта статьи с автоматической модерацией
function ShowListMiraAccounts()
{
    $r = mysql_qw("SELECT * FROM art_miralinks WHERE id_admin =?", $_SESSION[id]);
    $count = mysql_num_rows($r);
    if($count == 0) {echo '<p style="color:red;">Нет аккаунтов в Miralinks</p>'; return;}
    echo '<select id="SelectMiraAccount">';
	echo '<option selected disabled value="-1">Выберите аккаунт</option>';
    for($i=0; $i<$count; $i++)
      {
	    $row = mysql_fetch_object($r);
		echo '<option id="'.$row->id.'" value="'.$row->id.'">'.$row->login.'</option>';
	  }
    echo '</select>';
}
//---------------------------------------------


  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
?>