//--------------------------------
function ShowNewArticle(){
    $("img#ListNewTZArticleLoader").attr("src","image/pre.gif");
	$("img#ListNewTZArticleLoader").show();
	$("#ListNewTZArticle").hide();
	$("#ListNewTZArticle").html("");	
 
    var SleepFunc = function(){ 
	       $("img#ListNewTZArticleLoader").hide(); 
		   $("#ListNewTZArticle").show();
		   $("#ListNewTZArticle").load("GetTZNewArticle.php", { }, function(){   });
		};   
    setTimeout(SleepFunc, 1000); 
	
	return false;
}
//--------------------------------
function HideNoticeMSG(){
   $("#notice_msg").hide();
}
//--------------------------------
function HideNewTZArticle(){
   $("#TZArticle").hide();
}
function HideListNewTZArticle(){
   $("#ListNewTZArticle").hide();
}
//--------------------------------
//Взять задание
function TakeArticle(idArticle){
   $("img#ListNewTZArticleLoader").attr("src","image/pre.gif");
   $("img#ListNewTZArticleLoader").show();
   $("#ListNewTZArticle").hide();
   $("#ListNewTZArticle").html("");
   
    var SleepFunc = function(){
       $("img#ListNewTZArticleLoader").hide();
	   $("#ListNewTZArticle").show();
	   $("#ListNewTZArticle").load("TypeTZArticle.php", {idArticle:idArticle}, function(){   });
    }
    setTimeout(SleepFunc, 1000);	
    
	return false;
}
//--------------------------------
//Показать форму выполнения задания
function ShowPerformArticleTask(){
   $("img#ListNewTZArticleLoader").attr("src","image/pre.gif");
   $("img#ListNewTZArticleLoader").show();
   $("#ListNewTZArticle").hide();
   $("#ListNewTZArticle").html("");
   
   var SleepFunc = function(){
       $("img#ListNewTZArticleLoader").hide();
	   $("#ListNewTZArticle").show();
	   $("#ListNewTZArticle").load("ShowPerformArticleTask.php", {}, function(){   });
    }
    setTimeout(SleepFunc, 1000);	
    
	return false;
}
//--------------------------------
//Показать результат выполнения попытки отправить на модерацию
function ShowResultMoveArticleInModer(idArticle){
   var title   = $("#formTZtitle").val();
   var snippet = $("#formTZsnippet").val();
   var content = $("#formTZcontent").val();  


   $("img#ListNewTZArticleLoader").attr("src","image/pre.gif");
   $("img#ListNewTZArticleLoader").show();
   $("#ListNewTZArticle").hide();
   $("#ListNewTZArticle").html("");
   
   var SleepFunc = function(){
       $("img#ListNewTZArticleLoader").hide();
	   $("#ListNewTZArticle").show();
	   $("#ListNewTZArticle").load("ResultMoveToModer.php", {'idArticle':idArticle, 'title':title, 'snippet':snippet, 'content':content}, function(){   });
    }
    setTimeout(SleepFunc, 1000);	
    scroll(0,0);
	return false;
}
//--------------------------------



















