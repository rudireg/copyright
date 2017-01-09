<?php
/* date: 07.02.2014
 * Author: Rudi
 * Description: Парсер строк
 */

class RStrParser
{
    //------------------------------------------------------
	//Вернуть часть строки $str до того момента, как встретиться первое совпадение с $end
    public static function cut_to_str($str, $end){ 
	    $metEnd = strpos($str, $end);
		if(strlen($metEnd) < 1) return NULL;
		return substr($str, 0, $metEnd);
	}
	//------------------------------------------------------
	//Вернуть часть строки $str начиная с первого вхождения $start (не включая $str в результрирующую строку), 
	//до строки $end (не включая $end в результрирующую строку)
    public static function cut_str_to_str($str, $start = NULL, $end = NULL){
	
	    $metStart = ($start === NULL)? 0 : strpos($str, $start);
		if($metStart === false) return NULL;
		if($metStart !== NULL) $metStart += strlen($start);
		
		$tmp = substr($str, $metStart);
		$metEnd = ($end === NULL)? 0 : strpos($tmp, $end);
		if($metEnd === false) return NULL;
		
        if($metEnd === 0)
		    return substr($str, $metStart);
		else
		    return substr($tmp, 0, $metEnd);
	}
	//------------------------------------------------------
	//Вырезать указаное $count колличество символов из $str начиная с начала строки
	//Возвращает удаленный участок строки
    public static function erase_data(&$str, $count){ 
	    if($count > strlen($str)) {
		    $deleted = $str;
			$str = '';
			return $deleted;
		}
	    $deleted = substr($str, 0, $count);
	    $str = substr($str, $count);
		return $deleted;
	}
	//------------------------------------------------------
	//Вырезать участок в строке $str, начиная с начала до начала строки $start
	//Возвращает удаленный участок строки
	public static function erase_to(&$str, $start){ 
	    $pos = strpos($str, $start);
		if($pos === false) return NULL;
	    $deleted = substr($str, 0, $pos);
	    $str = substr($str, $pos);
	    return $deleted;
	}
	//------------------------------------------------------
	//Разбить  строку на массив частей, каждая из которых начинается с $start  и кончается $end
	public static function split($str, $start, $end){ 
	    $res = array();
		while(true) {
		    $metStart = strpos($str, $start);
			if($metStart === false) return $res;
			$metStart += strlen($start);
			$str = substr($str, $metStart);
			$metEnd = strpos($str, $end);
			if($metEnd === false) return $res;
			$res[] = substr($str, 0, $metEnd);
			$str = substr($str, $metEnd + strlen($metEnd));
		};
	}
	//------------------------------------------------------
	
}

?>