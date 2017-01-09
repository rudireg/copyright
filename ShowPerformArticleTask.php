<?php
    session_start(); 
    if($_SESSION[isUser] == false) die("Авторизуйтесь.<br /> <a href='/'>Вернуться на главную</a>"); 
    require_once 'mysql_connect.php';
    require_once 'mysql_qw.php'; 
    require_once 'database.php';
	
	//Узнаем есть ли у нас текущее невыполненое задание
	//Если нет не выполненых заданий показываем сообщение об их отсутствии
	$r = mysql_qw("SELECT * FROM art_article WHERE id_copyright =? AND date_take >0 AND date_moder <1 AND date_money <1",  $_SESSION[id]);
	if(mysql_num_rows($r) < 1)
	  {
	    echo '<center>
		       <h2>Нет невыполненых заданий</h2>
		       <button type="button" onclick="HideListNewTZArticle();">OK</button>
			  </center>'; 
		return;	  
	  } 
	$row = mysql_fetch_object($r);

	//Если все таки есть невыполненое задание
	//Показываем форму для выполнения задания
	echo ' <span>Требования статьи:</span><br /> 
	       <span class="mini_notice">ID статьи: </span><span class="highlighted red">'.$row->id.'</span>
		   &nbsp;&nbsp;&nbsp;
		   <span class="mini_notice">Цена: </span><span class="highlighted red">'.$row->price * ($row->count_letter / 1000).' </span><span class="mini_notice">руб.</span>
		   &nbsp;&nbsp;&nbsp;
		   <span class="mini_notice">Кол. знаков: </span><span class="highlighted red">'.$row->count_letter.' </span><span class="mini_notice">без пробелов</span><br />'; 
	//Выводим ключевые слова через запятую...
	$seoKeyWords = array();
	$seoKeyWords = split ('\]', $row->keyword_admin);	 
	$countSeoKeyWords =0;
	foreach($seoKeyWords as $value)
		{
            if(strlen($value) > 3)
			   $countSeoKeyWords = $countSeoKeyWords +1; 
        }	
    echo '<span class="mini_notice">Ключевые слова -</span> <span class="highlighted red" id="keyword_list">'.$countSeoKeyWords.'</span> <span      class="mini_notice">шт. (каждая новая строка):</span><br />
			   <span class="info_text">';	
		
    foreach($seoKeyWords as $value)
		{
            if(strlen($value) > 3)
			   {
			      $start = strpos($value, '[');
				  $end   = strpos($value, ':');
				  $rez   = substr($value, $start+1, $end - $start -1);
				  echo     $rez; 
				  echo '<br />';
			   }	
        }	
		
	echo '<span class="mini_notice">Площадка где будет размещена статья (Донор):</span><br />
			   <a href="http://'.$row->url_area.'" target="_blanc" title="Донор"><span class="info_anchor">www.'.$row->url_area.'</span></a>
			   <br />
			   <span class="mini_notice">Адрес донора в системе www.mirainks.ru:</span><br />
			   <a href="http://'.$row->mira_url_area.'" target="_blanc" title="Профайл в Миралинкс"><span class="info_anchor">www.'.$row->mira_url_area.'</span></a>
			   <br />
			   <span class="mini_notice">Акцептор - сайт на который ведут ссылки (ключ. слова) с сайта площадки-донора:</span><br />
			   <a href="http://'.$row->url_seosite.'" target="_blanc" title="Акцептор"><span class="info_anchor">www.'.$row->url_seosite.'</span></a>
			   <br />
			   <span class="mini_notice">Требования статьи:</span><br />
			   <span class="info_text">'.$row->conditions.'</span>';   
		
  	echo '<hr>
	      <form> 
		  <p><label for="formTZtitle"><span class="mini_notice">Залоговок статьи:</span></label></p>
		  <p><input type="text" id="formTZtitle" name="formTZtitle" value="'.$row->title.'" size="80" /></p>
		  <p><label for="formTZsnippet"><span class="mini_notice">Краткое вступление в статью (сниппет):</span></label></p>
		  <p><textarea id="formTZsnippet" rows="5" cols="80" name="formTZsnippet">'.$row->snippet.'</textarea></p>
		  <p><label for="formTZcontent"><span class="mini_notice">Содержание:</span></label></p>
		  <p><textarea id="formTZcontent" rows="20" cols="80" name="formTZcontent">'.$row->content.'</textarea></p>
		    <script>
                // Replace the <textarea id="formTZcontent"> with a CKEditor
                // instance, using default configuration.
                //CKEDITOR.replace( "formTZcontent" );
				$( "#formTZcontent" ).ckeditor();
            </script>
		  <p><center><div id="answer_MoveArticleToModer"></div></center></p>
		  <p><center><img id="loader_MoveArticleToModer" src="image/WhitePixel.gif" /></center></p>	  
		  <button type="button" 
		  onclick="ShowResultMoveArticleInModer('.$row->id.');">Отправить на модерацию</button>
		  </form>
		  <p>После отправки статьи удостоверьтесь в положительном результате её загрузки.</p>';
	
?>