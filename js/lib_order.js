//------------------------------------------
//Форма создания новой статьи
$(document).ready(function(){
		    $("#FormAddNewArticle").validate({
			    rules:{
					MetaKeywords: {
					    required: true,
						minlength: 10,
						maxlength: 256
					},
					SeoURL: {
					    required: true,
						minlength: 5,
						maxlength: 128
					},
					AreaURL: {
					    required: true,
						minlength: 5,
						maxlength: 256
					},
					CountLetter: {
					    required: true,
						minlength: 4,
						maxlength: 4
					},
					CountUrl: {
					    required: true,
						minlength: 1,
						maxlength: 1
					},
					Price1000: {
					    required: true,
						minlength: 2,
						maxlength: 30
					}
                },
                messages:{				
					MetaKeywords: {
					    required: "<br />Введите текст",
						minlength: "<br />Минимум 10 символов",
						maxlength: "<br />Максимум 256 символов"
					},
					SeoURL: {
					    required: "<br />Введите текст",
						minlength: "<br />Минимум 5 символов",
						maxlength: "<br />Максимум 128 символов"
					},
					AreaURL: {
					    required: "<br />Введите текст",
						minlength: "<br />Минимум 5 символов",
						maxlength: "<br />Максимум 256 символов"
					},
					CountLetter: {
					    required: "<br />Введите кол. символов",
						minlength: "<br />Минимум 4 цифры",
						maxlength: "<br />Максимум 4 цифры"
					},
					CountUrl: {
					    required: "<br />Введите кол. символов",
						minlength: "<br />Введите 1 цифру",
						maxlength: "<br />Введите 1 цифру"
					},
					Price1000: {
					    required: "<br />Введите текст",
						minlength: "<br />Минимум 2 символа",
						maxlength: "<br />Максимум 30 символов"
					}
				},
				submitHandler: function(form) {
				    var idCopyMan          = $("#selectCopyMan option:selected").val();
                    var orderDescription   = $("#orderDescription").val();
                    var MetaTitle          = $("#MetaTitle").val();
                    var MetaKeywords       = $("#MetaKeywords").val();
                    var MetaDescription    = $("#MetaDescription").val();
                    var MetaH1             = $("#MetaH1").val();
                    var WantURL            = $("#WantURL").val();
					var SeoURL             = $("#SeoURL").val();
                    var AreaURL            = $("#AreaURL").val();  
                    var MiraAreaURL        = $("#MiraAreaURL").val();
                    var CountLetter        = $("#CountLetter").val();
                    var CountUrl           = $("#CountUrl").val();
					var KeyWordsForCopyman = $("#keyListing").text();
                    var ConditionArea      = $("#ConditionArea").val(); 
                    var Price1000          = $("#Price1000").val();
					var AutoModer;
					var IdMiraAccount;
					var LoginMiraAccount;
					var IdMiraProject;
					if($("#CheckAutoModer").is(':checked') == true)
					    {
					        AutoModer =1;  
							LoginMiraAccount = $("#SelectMiraAccount option:selected").text();
							IdMiraAccount    = $("#SelectMiraAccount option:selected").val();
							IdMiraProject    = $("#ListMiraProjects option:selected").val();
							if (IdMiraProject.match(/^[-\+]?\d+/) === null) {
							    alert('Вы не указали проект MiraLinks');
								return false;
							} 	
						}	
					else	
					    {
						    AutoModer =0;
							LoginMiraAccount = -1;
						    IdMiraAccount =-1;
							IdMiraProject =-1;
						}

	                //Создаем строку запроса
	                var post_par = {'idCopyMan':idCopyMan,'AutoModer':AutoModer,'LoginMiraAccount':LoginMiraAccount,'IdMiraAccount':IdMiraAccount,'IdMiraProject':IdMiraProject, 'orderDescription':orderDescription, 'MetaTitle':MetaTitle, 'MetaKeywords':MetaKeywords, 'MetaDescription':MetaDescription, 'MetaH1':MetaH1, 'WantURL':WantURL, 'SeoURL':SeoURL, 'AreaURL':AreaURL, 'MiraAreaURL':MiraAreaURL, 'CountLetter':CountLetter, 'CountUrl':CountUrl, 'KeyWordsForCopyman':KeyWordsForCopyman, 'ConditionArea':ConditionArea, 'Price1000':Price1000};
					
	                $("#ButtonOrderArticle").hide();
					$("img#OrderArticleLoader").attr("src", "image/pre.gif");
					$("#OrderArticleAnswer").html("");
				    $.ajax({
                          url:'CreatArticle.php',
                          dataType:'json',
			              cache: false, 
	                      type:'POST',
                          data:post_par,
                          complete:ShowMyOrderStatus});
					return false;	   
                }
		    });
		});
//---------------------------------------
//Форма редактирования статьи
$(document).ready(function(){
		    $("#FormEditArticle").validate({
			    rules:{
					MetaKeywords: {
					    required: true,
						minlength: 10,
						maxlength: 256
					},
					SeoURL: {
					    required: true,
						minlength: 5,
						maxlength: 128
					},
					AreaURL: {
					    required: true,
						minlength: 5,
						maxlength: 256
					},
					CountLetter: {
					    required: true,
						minlength: 4,
						maxlength: 4
					},
					CountUrl: {
					    required: true,
						minlength: 1,
						maxlength: 1
					},
					Price1000: {
					    required: true,
						minlength: 2,
						maxlength: 30
					}
                },
                messages:{				
					MetaKeywords: {
					    required: "<br />Введите текст",
						minlength: "<br />Минимум 10 символов",
						maxlength: "<br />Максимум 256 символов"
					},
					SeoURL: {
					    required: "<br />Введите текст",
						minlength: "<br />Минимум 5 символов",
						maxlength: "<br />Максимум 128 символов"
					},
					AreaURL: {
					    required: "<br />Введите текст",
						minlength: "<br />Минимум 5 символов",
						maxlength: "<br />Максимум 256 символов"
					},
					CountLetter: {
					    required: "<br />Введите кол. символов",
						minlength: "<br />Минимум 4 цифры",
						maxlength: "<br />Максимум 4 цифры"
					},
					CountUrl: {
					    required: "<br />Введите кол. символов",
						minlength: "<br />Введите 1 цифру",
						maxlength: "<br />Введите 1 цифру"
					},
					Price1000: {
					    required: "<br />Введите текст",
						minlength: "<br />Минимум 2 символа",
						maxlength: "<br />Максимум 30 символов"
					}
				},
				submitHandler: function(form) {
				    var id                 = $("#idEditArticle").val();
				    var idCopyMan          = $("#selectCopyMan option:selected").val();
                    var orderDescription   = $("#orderDescription").val();
                    var MetaTitle          = $("#MetaTitle").val();
                    var MetaKeywords       = $("#MetaKeywords").val();
                    var MetaDescription    = $("#MetaDescription").val();
                    var MetaH1             = $("#MetaH1").val();
					var snippet             = $("#snippet").val();
					var content            = $("#content").val();
                    var WantURL            = $("#WantURL").val();
					var SeoURL             = $("#SeoURL").val();
                    var AreaURL            = $("#AreaURL").val();  
                    var MiraAreaURL        = $("#MiraAreaURL").val();
                    var CountLetter        = $("#CountLetter").val();
                    var CountUrl           = $("#CountUrl").val();
                    var KeyWordsForCopyman = $("#KeyWordsForCopyman").val();
                    var ConditionArea      = $("#ConditionArea").val(); 
                    var Price1000          = $("#Price1000").val();
   
	                //Создаем строку запроса
	                var post_par = {'id':id, 'idCopyMan':idCopyMan, 'orderDescription':orderDescription, 'MetaTitle':MetaTitle, 'MetaKeywords':MetaKeywords, 'MetaDescription':MetaDescription, 'MetaH1':MetaH1, 'snippet':snippet, 'content':content, 'WantURL':WantURL, 'SeoURL':SeoURL, 'AreaURL':AreaURL, 'MiraAreaURL':MiraAreaURL, 'CountLetter':CountLetter, 'CountUrl':CountUrl, 'KeyWordsForCopyman':KeyWordsForCopyman, 'ConditionArea':ConditionArea, 'Price1000':Price1000};

	                $("#ButtonOrderArticle").hide();
					$("img#OrderArticleLoader").attr("src", "image/pre.gif");
					$("#OrderArticleAnswer").html("");
				    $.ajax({
                          url:'editArticle.php',
                          dataType:'json',
			              cache: false, 
	                      type:'POST',
                          data:post_par,
                          complete:ShowMyOrderStatus});
					return false;	   
                }
		    });
		});
//---------------------------------------
function ShowMyOrderStatus(data){
    var vata = $.parseJSON(data.responseText);
    if(vata.status == 0) //Не удача
	    var msg = '<span style="font-size:20px;background:red; padding:10px; border:1px solid #CCCCCC; border-radius:5px;">Неудача</span><br /><br />';	
	else if(vata.status == 1) //Удача
	    {
            var msg = '<span style="font-size:20px;background:green; padding:10px; border:1px solid #CCCCCC;  border-radius:5px;">Успешно</span><br /><br />';
			$("#FormAddNewArticle").resetForm();
			$("#RezSectedMiraAccount").hide();
			$("#AutoModerBlock").hide();
			//Стираем ключи
			$("#keyListing").empty();
			
			
		}
	else if(vata.status == 2) //Уже существует
	     var msg = '<span style="font-size:20px;background:red; height:15px; padding:10px; border:1px solid #CCCCCC;  border-radius:5px;">Повторный URL площадки.</span><br /><br />';

	var localFunc = function(){
	    $("img#OrderArticleLoader").attr("src", "image/form_hider.gif");
	    $("#OrderArticleAnswer").html(msg); 
		$("#ButtonOrderArticle").show(); 
	};   
    setTimeout(localFunc, 1000); 	
}
//---------------------------------------
function ShowInfoCopyman(idCopyMans){	
    $("#BlockInfoCopyman").show();
    $("img#InfoCopymanLoader").attr("src", "image/pre.gif");
    $("img#InfoCopymanLoader").show();
    $("#InfoCopyman").hide();
    $("#BlockListArticles").hide();

    var SleepFunc = function(){ 
	       $("img#InfoCopymanLoader").hide(); 
		   $("img#InfoCopymanLoader").attr("src", "image/WhitePixel.gif");
		   $("#InfoCopyman").show();
		   $("#InfoCopyman").load("ShowCopymanInfo.php", {idCopyMan: idCopyMans}, function(){   });
		};   

    setTimeout(SleepFunc, 1000); 
	return false;	   
}
//---------------------------------------
function ShowListArticles(idCopyMan, type){
    $("#BlockListArticles").show();
    $("img#ListArticlesLoader").attr("src", "image/pre.gif");
    $("img#ListArticlesLoader").show();
    $("#ListArticles").html("");
	$("#ListArticles").hide();

	var SleepListArticle = function(){ 
	       $("img#ListArticlesLoader").attr("src", "image/WhitePixel.gif");
	       $("img#ListArticlesLoader").hide(); 
		   $("#ListArticles").show();
		   $("#ListArticles").load("ShowListArticle.php", {idCopyMan:idCopyMan,type:type}, function(){   });
		};   

    setTimeout(SleepListArticle, 1000); 
	return false;	   
}
//---------------------------------------
//Доработка статьи
function reWriteArticle(idArticle){
    if(!confirm("Уверены что хотите отправить статью на доработку ?")) { return false; }
	
	var idLoader = 'img#loder_' + idArticle;
	$(idLoader).attr("src", "image/pre.gif");
	$(idLoader).show();

	var LoadFunc = function(){
	     var post_par = {'idArticle':idArticle};
         $.ajax({
             url: 'reWriteArticle.php',
             dataType:'json',
		     cache: false, 
	         type:'POST',
             data:post_par,
             complete:ShowResultReWriteArticle});
		}
    setTimeout(LoadFunc, 1000);
	
    return false;
}
//--------------------------------------------------
function ShowResultReWriteArticle(data){
	var vata = $.parseJSON(data.responseText);
    var idLoader = 'img#loder_' + vata.idArticle;
	var LoadFunc = function(){
	     $(idLoader).attr("src", "image/WhitePixel.gif");
	     $(idLoader).hide();
		 var blockArtile = "#one_article_" + vata.idArticle;
		 $(blockArtile).hide();
		}
	setTimeout(LoadFunc, 1000);	 
}
//---------------------------------------
//Удаление статьи
function deleteArticle(idArticle, type){
    if(!confirm("Уверены что хотите удалить статью?")) { return false; }
	
	var idLoader = 'img#loder_' + idArticle;
	$(idLoader).attr("src", "image/pre.gif");
	$(idLoader).show();

	var LoadFunc = function(){
	     var post_par = {'idArticle':idArticle,'type':type};
         $.ajax({
             url: 'deleteArticle.php',
             dataType:'json',
		     cache: false, 
	         type:'POST',
             data:post_par,
             complete:ShowResultArticleDelete});
		}
    setTimeout(LoadFunc, 1000);
	
    return false;
}
//--------------------------------------------------
function ShowResultArticleDelete(data){
	var vata = $.parseJSON(data.responseText);
    var idLoader = 'img#loder_' + vata.idArticle;
	var LoadFunc = function(){
	     $(idLoader).attr("src", "image/WhitePixel.gif");
	     $(idLoader).hide();
		 var blockArtile = "#one_article_" + vata.idArticle;
		 $(blockArtile).hide();
		}
	setTimeout(LoadFunc, 1000);	 
}
//-------------------------------------
function editArticle(idArticle, type){
    var post_dat = {'idArticle':idArticle,'type':type};
    $.ajax({
      url: 'readArticle.php',
	  dataType: 'json',
	  type: 'POST',
	  cache: false,
	  data: post_dat,
	  complete: ShowEditArticle});

	return false;  
}
//-------------------------------------
function ShowEditArticle(data){
   var vata = $.parseJSON(data.responseText);
   
   //Отображаем форму
   $('#article-modal-content').modal();
   
   //Инициализируем форму
   $('#idEditArticle').val(vata.id);
   var selected = "#selectCopyMan [value='" + vata.id_copyright + "']";
   $(selected).attr("selected", "selected");
   $('#orderDescription').html(vata.description);
   $('#MetaTitle').val(vata.metatitle);
   $('#MetaKeywords').html(vata.metakeywords);
   $('#MetaDescription').html(vata.metadescription);
   $('#MetaH1').val(vata.title);
   $('#snippet').html(vata.snippet);
   $('#content').html(vata.content);
   $('#WantURL').val(vata.slug);
   $('#SeoURL').val(vata.url_seosite);
   $('#AreaURL').val(vata.url_area);
   $('#MiraAreaURL').val(vata.mira_url_area);
   $('#CountLetter').val(vata.count_letter);
   $('#CountUrl').val(vata.count_url);
   $('#KeyWordsForCopyman').html(vata.keyword_admin);
   $('#ConditionArea').html(vata.conditions);
   $('#Price1000').val(vata.price);
}
//-------------------------------------
//Экспорт статьи
function exportArticle(idArticle){   
    var post_par = {'idArticle':idArticle};
    $.ajax({
             url: 'exportArticle.php',
             dataType:'json',
		     cache: false, 
	         type:'POST',
             data:post_par,
             complete:ShowResultArticleExport});

    return false;	
}
//-------------------------------------------
function ShowResultArticleExport(data){
	var vata = $.parseJSON(data.responseText); 	
    if(vata.error >0){  
    	alert('Error Export: ' + vata.error);
	}
	else
    {	 
	    $.modal('<center><div><h1 style="color:#FFF">Выберете один из вариантов:</h1>  <p><a href="' + vata.urlfile_simple + '" target="_blanc" style="text-decoration:underline">Просмотреть статью</a></p> <p><a href="' + vata.urlfile_miralinks + '" target="_blanc" style="text-decoration:underline">Скачать в формате Miralinks</a></p></div><center>');
	}
}
//-------------------------------------------
//Форма добавления нового Miralinks аккаунта
$(document).ready(function(){
        $("#AddMiraAccount").validate({
		     rules:{
			    MiraAccountLogin: {
				    required: true,
					minlength: 2,
					maxlength: 127
				},
				MiraAccountPassword: {
				    required: true,
					minlength: 2,
					maxlength: 127
				}
			 },
			 messages:{
			    MiraAccountLogin: {
				    required: "<br />Введите текст",
					minlength: "<br />Минимум 2 символа",
					maxlength: "<br />Максимум 127 символов"
				},
				MiraAccountPassword: {
				    required: "<br />Введите текст",
					minlength: "<br />Минимум 2 символа",
					maxlength: "<br />Максимум 127 символов"
				}
			 },
			 submitHandler: function(form) {
                    var login    = $("#MiraAccountLogin").val();
					var password = $("#MiraAccountPassword").val();
	                //Создаем строку запроса
	                var post_par = {'login':login, 'password':password};

	                $("#BtnAddMiraAccount").hide();
					$("img#CheckAddedMiraAccount").show();
					$("img#CheckAddedMiraAccount").attr("src", "image/pre.gif");
					$("#AddMiraAccountAnswer").html("");
					var LoadFunc = function(){
				        $.ajax({
                          url:'AddMiralinksAccount.php',
                          dataType:'json',
			              cache: false, 
	                      type:'POST',
                          data:post_par,
                          complete:ShowRezultAddedMiraAccount});
						}
					setTimeout(LoadFunc, 1000);		
					return false;	   
                }
		});
});
//---------------------------------------
function ShowRezultAddedMiraAccount(data){
    $("img#CheckAddedMiraAccount").hide();
	$("#BtnAddMiraAccount").show();
   
	var vata = $.parseJSON(data.responseText); 
	var msg ="";
	if(vata.error == 1)
	  {
    	msg = 'Ошибка';
		$("#AddMiraAccountAnswer").html('<center><div style="padding:5px; background:#FF9999">' + msg + '</div></center><br />');
	  }
	else if(vata.id >= 0)	
	  {
	    msg = 'Аккаунт добавлен в систему.';
		$("#AddMiraAccountAnswer").html('<center><div style="padding:5px; background:#66CC66">' + msg + '</div></center><br />');

		var forAdd = '<div id="area_' + vata.id + '" style="margin-left:50px; margin-bottom:5px; position:relative;"><a onclick="DellMiraAccount(' + vata.id + ');" title="Удалить" style="cursor:pointer;"><img src="image/x.png" width="25" height="25" style="position:relative; top:8px;"/></a>&nbsp;&nbsp;&nbsp;<img src="image/pixel.png" id="loder_' + vata.id + '" style="position:absolute;left:40px;top:10px;"/>' + vata.login + '</div>';
		
		$("#NoticeNoMiraAcc").hide();
		$("#ListMiraAccounts").append(forAdd);
		$("#MiraAccountLogin").attr('value','');
		$("#MiraAccountPassword").attr('value','');
	  }	
    else  
	  {
	    msg = 'Данный логин уже есть в системе.'; 
		$("#AddMiraAccountAnswer").html('<center><div style="padding:5px; background:#FF9999">' + msg + '</div></center><br />');
	  } 	
}
//-------------------------------------------
//Форма создания новой статьи
$(document).ready(function(){
		    $("#FormCheckDomain").validate({
			    rules:{
                    checkDomain: {
					    required: true,
						minlength: 4,
						maxlength: 256
					},
					checkDomainAktseptor: {
					    required: true,
						minlength: 4,
						maxlength: 256
					}
                },
                messages:{				
		            checkDomain: {
					    required: "<br />Введите текст",
						minlength: "<br />Минимум 4 символа",
						maxlength: "<br />Максимум 256 символов"
		            },
					checkDomainAktseptor: {
					    required: "<br />Введите текст",
						minlength: "<br />Минимум 4 символа",
						maxlength: "<br />Максимум 256 символов"
					}
				},
				submitHandler: function(form) {
                    var checkDomain          = $("#checkDomain").val();
					var checkDomainAktseptor = $("#checkDomainAktseptor").val();
	                //Создаем строку запроса
	                var post_par = {'checkDomain':checkDomain, 'checkDomainAktseptor':checkDomainAktseptor};

	                $("#BtncheckDomain").hide();
					$("img#CheckDomainLoader").show();
					$("img#CheckDomainLoader").attr("src", "image/pre.gif");
					$("#CheckDomainAnswer").html("");
					var LoadFunc = function(){
				        $.ajax({
                          url:'CheckDomain.php',
                          dataType:'json',
			              cache: false, 
	                      type:'POST',
                          data:post_par,
                          complete:ShowCheckDomain});
						}
					setTimeout(LoadFunc, 1000);	
						
					return false;	   
                }
		    });
		});
//---------------------------------------
function ShowCheckDomain(data){
    $("img#CheckDomainLoader").hide();
	$("#BtncheckDomain").show();
   
	var vata = $.parseJSON(data.responseText); 
	var msg ="";
	if(vata.error == 1)
	  {
    	msg = 'Ошибка';
		$("#CheckDomainAnswer").html('<center><div style="padding:5px; background:#FF9999">' + msg + '</div></center><br />');
	  }
	else if(vata.idArticle == 0)	
	  {
	    msg = 'Нет домена';
		$("#CheckDomainAnswer").html('<center><div style="padding:5px; background:#66CC66">' + msg + '</div></center><br />');
	  }	
    else  
	  {
	    msg = 'Есть домен'; 
		$("#CheckDomainAnswer").html('<center><div style="padding:5px; background:#FF9999">' + msg + '</div></center><br />');
	  } 	
}
//-------------------------------------
//Форма создания новой статьи
$(document).ready(function(){
		    $("#FormRegCopyman").validate({
			    rules:{
                    LoginRegCopyman: {
					    required: true,
						minlength: 4,
						maxlength: 32
					},
					PassRegCopyman: {
					    required: true,
						minlength: 4,
						maxlength: 32
					}
                },
                messages:{				
		            LoginRegCopyman: {
					    required: "<br />Введите текст",
						minlength: "<br />Минимум 4 символа",
						maxlength: "<br />Максимум 32 символа"
		            },
					PassRegCopyman: {
					    required: "<br />Введите текст",
						minlength: "<br />Минимум 4 символа",
						maxlength: "<br />Максимум 32 символа"
		            }
				},
				submitHandler: function(form) {
                    var login    = $("#LoginRegCopyman").val();
					var password = $("#PassRegCopyman").val();
					var wmr      = $("#WMRRegCopyman").val();
					var wmz      = $("#WMZRegCopyman").val();
					var qiwi     = $("#QIWIRegCopyman").val();
					var email    = $("#EmailRegCopyman").val();
					var icq      = $("#ICQRegCopyman").val();
	                //Создаем строку запроса
	                var post_par = {'login':login, 'password':password, 'wmr':wmr, 'wmz':wmz, 'qiwi':qiwi, 'email':email, 'icq':icq};

	                $("#BtnregCopyman").hide();
					$("img#regCopymanLoader").show();
					$("img#regCopymanLoader").attr("src", "image/pre.gif");
					$("#regCopymanAnswer").html("");
					var LoadFunc = function(){
				        $.ajax({
                          url:'RegCopyman.php',
                          dataType:'json',
			              cache: false, 
	                      type:'POST',
                          data:post_par,
                          complete:ShowRegCopyman});
						}
					setTimeout(LoadFunc, 1000);	
						
					return false;	   
                }
		    });
		});
//---------------------------------------
function ShowRegCopyman(data){
 
    $("img#regCopymanLoader").hide();
	$("#BtnregCopyman").show();
   
	var vata = $.parseJSON(data.responseText); 
	if(vata.error == 1)
	  {
    	msg = 'Ошибка';
		$("#regCopymanAnswer").html('<center><div style="padding:5px; background:#FF9999">' + msg + '</div></center><br />');
	  }
	else if(vata.status == 0)  
	  {
	    msg = 'Логин занят';
		$("#regCopymanAnswer").html('<center><div style="padding:5px; background:#FF9999">' + msg + '</div></center><br />');
	  }
	else 
	  {
	    msg = 'Успешно';
		$("#regCopymanAnswer").html('<center><div style="padding:5px; background:#66CC66">' + msg + '</div></center><br />');
		$("#FormRegCopyman").trigger( 'reset' );
	  }	
}
//--------------------------------------------
//Занести статью в статус оплаченных
function payedArticle(idArticle){
    if(!confirm("Перенести на оплату ?")) { return false; }
	
	var idLoader = 'img#loder_' + idArticle;
	$(idLoader).attr("src", "image/pre.gif");
	$(idLoader).show();
 
	var LoadFunc = function(){
	     var post_par = {'idArticle':idArticle};
         $.ajax({
             url: 'moveToPaidArticle.php',
             dataType:'json',
		     cache: false, 
	         type:'POST',
             data:post_par,
             complete:ShowMoveToPaidArticle});
		}
    setTimeout(LoadFunc, 1000);
 
    return false;
}
//--------------------------------------------------
function ShowMoveToPaidArticle(data){
	var vata = $.parseJSON(data.responseText);
    var idLoader = 'img#loder_' + vata.idArticle;

	$(idLoader).attr("src", "image/WhitePixel.gif");
	$(idLoader).hide();
	
	if(vata.error == 1)
	  {
	      alert('Ошибка');
	  }
	else  
	  {
	      var blockArtile = "#one_article_" + vata.idArticle;
	      $(blockArtile).hide();
	  }
}
//-------------------------------------
$(document).ready(function(){
		    $("#FormDeleteCopyright").validate({
				submitHandler: function(form) {
				    $("#DeleteCopyrightLoader").attr("src","image/pre.gif");
					$("#DeleteCopyrightLoader").show();
					$("#DeleteCopyrightAnswer").html("");
					$("#DeleteCopyrightAnswer").hide();
					$("#BtnDeleteCopyright").hide();
				
				    var SleepFunc = function (){
				            $("#DeleteCopyrightLoader").attr("src","image/WhitePixel.gif");
					        $("#DeleteCopyrightLoader").hide();
					        $("#BtnDeleteCopyright").show();
				            var idCopyMan = $("#selectCopyMan option:selected").val();
					        if(idCopyMan < 1) 
					          {
					             $("#DeleteCopyrightAnswer").html("<span style='background:red;padding:5px;'>Укажите копирайтера</span>"); 
						         $("#DeleteCopyrightAnswer").show();
					          }
					        else             
					         {
								$("#DeleteCopyrightAnswer").load("deleteCopyrighter.php", {idCopyMan:idCopyMan}, function(){   });
						        $("#DeleteCopyrightAnswer").show();
						     } 
			            }
					setTimeout(SleepFunc, 1000);	
				}
			});
});
//-------------------------------------
//Добавить ключ
function ButtonAddKey(){
    if (ButtonAddKey.count == undefined) ButtonAddKey.count = 0; //Инициализовать при первом вызове 
    var keyName = $("#keyName").val();
    var keyURL  = $("#keyURL").val();  
    var keyListing = '<div id="' + ButtonAddKey.count + '"> <a  style="cursor:pointer;" onclick="HideKey(' + ButtonAddKey.count + ');"><img src="/image/x.png" width="25" height="25" style="position:relative;top:5px;" /></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[' + keyName + ':' + keyURL + ']<hr></div>';
	
    $("#keyListing").append(keyListing);
	$("#keyName").attr('value','');
	$("#keyURL").attr('value','');
	ButtonAddKey.count = ButtonAddKey.count + 1;
}
//-------------------------------------
function HideKey(id){
    var ids = '#' + id;
	$(ids).empty();
}
//-------------------------------------
function DellMiraAccount(id)
{
    if(!confirm("Уверены что хотите удалить аккаунт Miralinks ?")) { return false; }
    var idLoader = 'img#loder_' + id;
	$(idLoader).attr("src", "image/loading.gif");
	$(idLoader).show();
   
         var LoadFunc = function(){
	     var post_par = {'id':id};
         $.ajax({
             url: 'dellMiraAccount.php',
             dataType:'json',
		     cache: false, 
	         type:'POST',
             data:post_par,
             complete:HideDelletedMiraAccount});
		}
    setTimeout(LoadFunc, 1000);

	return false;  
}
/*---------------------------------------------------------*/
function HideDelletedMiraAccount(data)
{
    var vata = $.parseJSON(data.responseText);
    var idLoader = 'img#loder_' + vata.id;
	var LoadFunc = function(){
	     $(idLoader).attr("src", "image/pixel.png");
	     $(idLoader).hide();
		 var blockIP = "#area_" + vata.id;
		 $(blockIP).hide();
		}
	setTimeout(LoadFunc, 1000);	 
}
/*---------------------------------------------------------*/
//Показать и скрыть блок автомодерации
function ShowHideAutoModerBlock()
{
    if($("#CheckAutoModer").is(':checked') == true)
	   {
          $("#AutoModerBlock").show();  
		  $("#AutoModerBlock :contains('Выберите аккаунт')").attr("selected", "selected");
	   }	
	else 
	   {
          $("#AutoModerBlock").hide();	
		  $("#RezSectedMiraAccount").hide();
	   }	
}
/*---------------------------------------------------------*/
//Выводим список проектов выбраного аккаунта Miralinks
function chek_selected_mira_account(item,name)
{
   if($("#CheckAutoModer").is(':checked') == true)
    {
        $("#RezSectedMiraAccount").show();   
        var id = "";
        $(item.children).each(function () {
           if(this.selected) id = $(this).val();
        });
		
		var idLoader = 'img#RezSelectMiraAccLoader';
	    $("img#RezSelectMiraAccLoader").attr("src", "image/loading.gif");
		$("#RezSectedMiraAccount").html("");
	    $("img#RezSelectMiraAccLoader").show();

        var LoadFunc = function(){
	        var post_par = {'id':id};
            $.ajax({
                url: 'AuthMiraAndGetProjectsId.php',
                dataType:'json',
		        cache: false, 
	            type:'POST',
                data:post_par,
                complete:ShowRezAuthMiraAndGetProjectsId});
		}
        setTimeout(LoadFunc, 1);
	    return false; 
    }
}
/*---------------------------------------------------------*/
//Показать результат парсинга ID проектов аккаунта в Miralinks
function ShowRezAuthMiraAndGetProjectsId(data)
{  
    var vata = $.parseJSON(data.responseText);
    var idLoader = "img#RezSelectMiraAccLoader";
	$(idLoader).attr("src", "image/pixel.png");
    if(vata.error > 0) 
 	   {$("#RezSectedMiraAccount").append('<p style="color:red">Ошибка чтения проектов #'+ vata.error +'<br />'+ vata.errorText +'</p>'); return;}
	   
	var obj = vata.select;
	var txt, str;
	txt = "<option disabled selected>Укажите проект</option>";
	$.each(obj, function(i, val) {
	    while(val.indexOf("\\")+1)
          val = val.replace("\\", "%");
	    val = unescape(val);
        txt += "<option value='" + i + "'>" + val + "</option>";
     });

    $("#RezSectedMiraAccount").html('<select id="ListMiraProjects">' + txt + '</select>'); 
}
/*---------------------------------------------------------*/















