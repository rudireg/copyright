<?php
    session_start(); 
    if($_SESSION[isUser] == false) die("Авторизуйтесь.<br /> <a href='/'>Вернуться на главную</a>"); 
    require_once 'mysql_connect.php';
    require_once 'mysql_qw.php'; 
    require_once 'database.php';
	require_once 'miralinks.php';
	//require_once 'RStrParser.php';
	$miralinks = new Miralinks();

	$title       = $_POST['title'];
	$nameArticle = $_POST['title'];
	$note        = $_POST['title'];
	$snippet     = $_POST['snippet'];
	$idArticle   = $_POST['idArticle'];
	$content     = $_POST['content'];
	
	if(!isset($_POST['idArticle']) || !isset($_POST['title']) || !isset($_POST['snippet'])  
	   || !isset($_POST['content']) ||$idArticle < 1)
	  {
	     echo "Ошибка 1";
         return;	  
	  }
	//Проверяем точно ли статья принадлежит данному копирайтеру
	//И является ли статус статьи в начальном уровне 
	$r = mysql_qw("SELECT COUNT(*) FROM art_article WHERE id =? AND id_copyright=? AND date_take >0 AND date_moder <1 
	               AND date_money <1", $idArticle, $_SESSION[id]);
	if(mysql_num_rows($r) < 1) return 0;
    $row = mysql_fetch_row($r);
	if($row[0] < 1)
	  {
	     echo 'Ошибка 2';
         return;	  
	  }
	//Сохраняем изменения без указывания дат  
	mysql_qw("UPDATE art_article SET title =?, snippet =?, content =? WHERE id =?", $title, $snippet, $content, $idArticle);
	//Проверяем title
	if(strlen($title) < 4 || strlen($title) > 255)
	  {
	     echo '<h3>Заголовок должен быть не менее чем <span class="highlighted red">4</span> символа, и не боле <span class="highlighted red">255</span> символов.</h3>
		 <p><button type="submit" onclick="ShowPerformArticleTask();">OK</button></p>';
         return;	  
	  }
	//Проверяем Контент
	//Кол. символов не должно быть мeнее чем указано в требованиях статьи
	$buf = $content;
	$buf = strip_tags($buf);
	$blanc = array("\r\n", "\n", "\r", " ", "\t",  "\"", ",", ".", "-", "!", "?", ":", "&nbsp;");
	$buf = str_replace($blanc, '', $buf);
	$buf = preg_replace ("/[^a-zA-ZА-Яа-я0-9\s]/", "", $buf);
	$buf_len = strlen($buf);
	//Узнаем кол. требуемых символов
	$r = mysql_qw("SELECT count_letter FROM art_article WHERE id =?", $idArticle);
    if(mysql_num_rows($r) < 1)
	  {
	     echo '<h3>Ошибка 3</h3>';
         return;	  
	  }
	$row = mysql_fetch_object($r);
	if($buf_len < $row->count_letter)
	  {
	     echo '<center>
		         <h3>Статья имеет не достаточное кол. символов.</h3>
		         <p>Требования статьи: <span class="highlighted red">'.$row->count_letter.' </span>символов</p>
			     <p>Текущее кол. символов в статье: <span class="highlighted red">'.$buf_len.' </span>символов</p>
				 <p><button type="submit" onclick="ShowPerformArticleTask();">OK</button></p>
			   </center>';
         return;	  
	  }
	
    //Модифицируем статью для заливки в miralinks
	//Вставляем <p>...</p>
	$buf  = $content;
	$arr  = explode("\n", $buf);
	for ($i = 0; $i < count($arr); $i++)
	    {
            if(strlen($arr[$i]) > 5) 
			   $mira .= '<p>'.$arr[$i].'</p>';
	    }
		
	 //Вставляем ключевые слова
     //1.Считываем из MySQL данные статьи
  	 $r = mysql_qw("SELECT * FROM art_article WHERE id =?", $idArticle);
     if(mysql_num_rows($r) < 1)
	  {
	     echo '<h3>Ошибка чтения данных статьи</h3>';
         return;	  
	  }
	 $row = mysql_fetch_object($r); 
	 $seoKeyWords = array();
	 $seoKeyWords = split ('\]', $row->keyword_admin);	
	/* $countKeyInArticle = count($seoKeyWords);
	 $countKeyInArticle --;
	 //Проверяем совпадает ли заданное и предоставленное число ключей.
	 $temper = $content;
	 $temper = str_replace ( "[k]"   , " " , $temper, &$k1);
	 $temper = str_replace ( "[/k]"  , " " , $temper, &$k2);
     $summaK = $k1 + $k2;
     $summaK /= 2;
	 if($k1 != $k2 || $summaK != $countKeyInArticle)
	   {
	        echo '<center>
		         <h3 style="color:red">ОШИБКА !!! Проверьте ключи !!!</h3>
				 <p><span style="color:red;font-size:20px;">Внимание !!!</span><br />Ключевые слова должны идти <b>СТРОГО</b> в том порядке, в котором были даны в задании, и должны быть заключены в теги <span style="color:red;">&lt;k&gt;</span> и <span style="color:red;">&lt;/k&gt;</span> <br />Для примера выделим ключевое слово <b>авто</b> в предложении:<br />
		         <span style="color:black">Выкуп <span style="color:red;">[k]</span><b>авто</b><span style="color:red;">[/k]</span> круглосуточно.</span></p>
				 <p><button type="submit" onclick="HideListNewTZArticle();">OK</button></p>
		         </center>';   
			return;	 
	   } 
	   
	 //Вставляем ключи в текст	
	 foreach($seoKeyWords as $value)
		{ 
			if(strlen($value) > 3)
			{
			    $start  = strpos($value, '[');
			    $end    = strpos($value, ':');
		        $key    = substr($value, $start+1, $end - $start -1);
			    $start  = strpos($value, ':');
			    $end    = strpos($value, ']');
	            $url    = substr($value, $start+1);
			    $keyurl = '<a href="'.$url.'" title="'.$key.'" target="_blanc">';
		        $mira   = str_replace("[/k]", "</a>", $mira,&$count);
				$start  = strpos($mira, "[k]");
				$mira   = substr_replace($mira, $keyurl, $start, 3);
			}
        }	*/
    //Добавляем в конец предложения аффтора:
	$owner_array = array();
	$owner_array[] = '<p>Предоставлено порталом: www.'.$row->url_seosite.'</p>'; 
	$owner_array[] = '<p>Автор контента: www.'.$row->url_seosite.'</p>'; 
	$owner_array[] = '<p>Подготовлено с поддержкой: www.'.$row->url_seosite.'</p>'; 
	$owner_array[] = '<p>Статья от: www.'.$row->url_seosite.'</p>'; 
	$owner_array[] = '<p>Материал любезно предоставлен: www.'.$row->url_seosite.'</p>'; 
	$owner_array[] = '<p>Автоломбард ЗАО: www.'.$row->url_seosite.'</p>'; 
	$owner_array[] = '<p>Подготовлено финансовой компанией: www.'.$row->url_seosite.'</p>'; 
	$owner_array[] = '<p>Источник: www.'.$row->url_seosite.'</p>'; 
	$owner_array[] = '<p>Правообладатель портал: www.'.$row->url_seosite.'</p>'; 
	$owner_array[] = '<p>Ссылаясь на автопортал: www.'.$row->url_seosite.'</p>'; 
	$owner_array[] = '<p>Одобрено компанией: www.'.$row->url_seosite.'</p>'; 
	$owner_array[] = '<p>Содержание согласовано с: www.'.$row->url_seosite.'</p>'; 
	$owner_array[] = '<p>Размещено с согласия: www.'.$row->url_seosite.'</p>'; 
	$owner_array[] = '<p>По вопросам обращаться: www.'.$row->url_seosite.'</p>'; 
	$owner_array[] = '<p>Официальный источник: www.'.$row->url_seosite.'</p>'; 
	
    $mira .= $owner_array[rand(0,14)];
	//Узнаем есть ли не введенные данные
    //metatitle
	if(strlen($row->metatitle) < 5)
	   $row->metatitle = $title; 
	//metadescription
	if(strlen($row->metadescription) < 5)
	   $row->metadescription = $title; 
	//slug
	if(strlen($row->slug) < 1)
	{   	 
		$tmpslug = $title;	
		$converter = array(
	        'а' => 'a',   'б' => 'b',   'в' => 'v',
	        'г' => 'g',   'д' => 'd',   'е' => 'e',
	        'ё' => 'e',   'ж' => 'zh',  'з' => 'z',
	        'и' => 'i',   'й' => 'y',   'к' => 'k',
	        'л' => 'l',   'м' => 'm',   'н' => 'n',
	        'о' => 'o',   'п' => 'p',   'р' => 'r',
	        'с' => 's',   'т' => 't',   'у' => 'u',
	        'ф' => 'f',   'х' => 'h',   'ц' => 'c',
	        'ч' => 'ch',  'ш' => 'sh',  'щ' => 'sch',
	        'ь' => '',    'ы' => 'y',   'ъ' => '',
	        'э' => 'e',   'ю' => 'yu',  'я' => 'ya',
	        'А' => 'A',   'Б' => 'B',   'В' => 'V',
	        'Г' => 'G',   'Д' => 'D',   'Е' => 'E',
	        'Ё' => 'E',   'Ж' => 'Zh',  'З' => 'Z',
	        'И' => 'I',   'Й' => 'Y',   'К' => 'K',
	        'Л' => 'L',   'М' => 'M',   'Н' => 'N',
	        'О' => 'O',   'П' => 'P',   'Р' => 'R',
	        'С' => 'S',   'Т' => 'T',   'У' => 'U',
	        'Ф' => 'F',   'Х' => 'H',   'Ц' => 'C',
	        'Ч' => 'Ch',  'Ш' => 'Sh',  'Щ' => 'Sch',
	        'Ь' => '',    'Ы' => 'Y',   'Ъ' => '',
	        'Э' => 'E',   'Ю' => 'Yu',  'Я' => 'Ya',
		);
		$tmpslug = strtr($tmpslug, $converter);
		$tmpslug = strtolower($tmpslug);
		$tmpslug = preg_replace('~[^-a-z0-9_]+~u', '-', $tmpslug);
		$tmpslug = preg_replace("/--+/","-",$tmpslug); // Удаляем лишние пробелы
		$tmpslug = trim($tmpslug, "-");
		$row->slug = $tmpslug;	
    }
	//snippet
	if(strlen($snippet) < 5)
	    {
	      $buf = $content;	  
		  $row->snippet ="";
		  while(strlen($row->snippet) < 128)
		    {
			   $pos = strpos($buf, ".");
			   $temp = substr($buf, 0, $pos);
			   $row->snippet .= $temp.'.';
			   $temp .=".";
			   $buf = str_replace($temp, "", $buf);
			}
		  $row->snippet .= "..";
		  //Проверяем длину сниппета
		 if(strlen($row->snippet) >= 255)
		    {
			   $row->snippet = substr($row->snippet, 0, 250); 
			   $pos = strrpos($row->snippet, " ");
			   $row->snippet = substr($row->snippet, 0, $pos); 
			   $row->snippet .= "...";
			}
		}  
	else
         $row->snippet = $snippet;	
    //Формирует полный формат MiraLinks
	$file = 'export/'.$row->id_admin.'_'.$row->id_copyright.'_'.$row->id.'.txt';
	$f = fopen($file, "w");
	fprintf($f,"[__title__]\n");
	fprintf($f,"%s\n", $title);
	fprintf($f,"[__description__]\n");
	fprintf($f,"%s\n", $row->description);
	fprintf($f,"[__metatitle__]\n");
	fprintf($f,"%s\n", $row->metatitle);
	fprintf($f,"[__metakeywords__]\n");
	fprintf($f,"%s\n", $row->metakeywords);
	fprintf($f,"[__metadescription__]\n");
	fprintf($f,"%s\n", $row->metadescription);
	fprintf($f,"[__slug__]\n");
	fprintf($f,"%s\n", $row->slug);
	fprintf($f,"[__snippet__]\n");
	fprintf($f,"%s\n", $row->snippet);
	fprintf($f,"[__content__]\n");
	fprintf($f,"%s", $mira);
    fclose($f);

	$typeModer = $row->auto_moder;
	//Если автоматическая модерация
	if($row->auto_moder == 1)
	{
	    $idMiraAccount = $row->id_mira_acc;      //Запомнили ID мира аккаунта в системе
	    $idMiraProject = $row->id_mira_project;  //Запомнили ID мира проекта
		$idAdmin       = $row->id_admin;         //Запомнили ID админа статьи
		//Получить данные авторизации в Miralinks 
	    $r = mysql_qw("SELECT * FROM art_miralinks WHERE id =? AND id_admin =?", $idMiraAccount, $idAdmin); 
		if(mysql_num_rows($r) < 1)
	      {
	         echo '<h3>Ошибка чтения данных админа</h3>';
             return;	  
	      }
		$row_admin = mysql_fetch_object($r); 
		//Авторизовываемся в системе Miralinks
	    $rez = $miralinks->Authorize($row_admin->login, $row_admin->password);
	    if($rez == false) 
		    {echo '<center>
		                     <h3>Ошибка авторизации. Повторите позднее...</h3>
				            <p><button type="submit" onclick="HideListNewTZArticle();">OK</button></p>
		                    </center>'; 
			return;}
		//Загружаем файл
		echo $mira;
		
	    $LoadRezult = $miralinks->UploadFile($title, $row->id_mira_project);

	    if(!strstr($LoadRezult, "<li>Загружено статей: 1 из 1</li>"))
            {
			     echo $LoadRezult;
		         echo '<center>
		         <h3 style="color:red">Ошибка отправки. Повторите позднее...</h3>
				 <p><button type="submit" onclick="HideListNewTZArticle();">OK</button></p>
		         </center>';   
		   	     return;	 
		    } 
	}

	//Если верные данные изменяем статус data_moder
	mysql_qw("UPDATE art_article SET date_moder =? WHERE id =?", time(), $idArticle);
	//Выводим сообщение о результате
	if($typeModer == 1)
	    {
	        echo '<center>
		         <h3>Статья отправлена на модерацию в систему <a href="http://miralinks.ru" title="miralinks.ru">www.miralinks.ru</a></h3>
				 <p><button type="submit" onclick="HideListNewTZArticle();">OK</button></p>
		         </center>';  
        }
    else
        {
            echo '<center>
		         <h3>Статья отправлена на ручную модерацию.</h3>
				 <p><button type="submit" onclick="HideListNewTZArticle();">OK</button></p>
		         </center>';  
        }		
?>