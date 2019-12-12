<?php
function create_serial($params = array()){
    $serial = md5(implode('-', $params));
    $serial = strtoupper($serial);
    $serial = str_split($serial, 4);
    return implode('-', $serial);
}

function split_to_segments($url){
	$return = explode("/", $url);
	array_shift($return);
	if(substr($url, -1) == "/"){
		array_pop($return);
	}
	
	for($i=count($return)+1; $i<=4; $i++){
		$return[$i-1] = false;
	}
	
	return $return;
}

function segments_to_get($segments){
	$_GET['act'] = $segments[0];
	$_GET['subact'] = $segments[1];
	$_GET['id'] = $segments[2];
	$_GET['subid'] = $segments[3];
	$page = (int)array_search('page', $segments);
	
	if($page == 1){
		unset($_GET['id']);
	}
	
	if(count($segments) > 4){
		array_shift($segments);
		array_shift($segments);
		array_shift($segments);
		array_shift($segments);
		$_GET['other'] = implode("/", $segments);
	}
}

function destroy_cookie($cookie){
	setcookie($cookie, '', -1, '/');
}

function check_url($url){
	if(strlen($url) > 4 AND !preg_match('/http\:\/\//', $url))
		$url = 'http://' . $url;
	return $url;
}

function format_filesize($size){
	$mb = round($size/1024/1024, 2) . 'MB';
	$kb = round($size/1024, 2) . 'KB';
	$size = $kb > 1024 ? $mb : $kb;
	return $size;
}

function br2nl($string){
	return preg_replace('/\<br(\s*)?\/?\>/i', "", $string);
} 

function shorten($text, $length){
	return mb_substr($text, 0, $length, 'UTF-8') . ($length < mb_strlen($text, 'UTF-8') ? '...':'');
}

function galotne($nr, $alt1, $alt2){
	$gal = substr($nr, -1);
	if($gal == 1 AND $nr != 11)
		return $alt1;
	else
		return $alt2;   
}

function seo_string($string, $separator = '-'){
	$string = trim($string);
	$string = str_replace(
		["ā", "Ā", "č", "Č", "ē", "Ē", "ģ", "Ģ", "ķ", "Ķ", "ļ", "Ļ", "ī", "Ī", "ū", "Ū", "š", "Š", "ņ", "Ņ", "ž", "Ž"], 
		["a", "a", "c", "c", "e", "e", "g", "g", "k", "k", "l", "l", "i", "i", "u", "u", "s", "s", "n", "n", "z", "z"], 
		$string
	); 
	
	$string = strtolower($string); // convert to lowercase text
	$string = trim(preg_replace("/[^ A-Za-z0-9_]/", " ", $string));
	$string = str_replace(" ", $separator, $string);
	$string = preg_replace("/[ -]+/", "-", $string);
	$string = str_replace($separator.$separator, $separator, $string);
	return $string;
}

function redirect($url, $outofdomain = false){
	$prefix = $outofdomain ? "":SITE_URL;
	header('location: ' . $prefix . $url);
	die();
}

function get_post($index, $secure = false){
	if(isset($_POST[$index])){
		if($secure){
			return htmlspecialchars(urldecode($_POST[$index]));
		}else{
			return ($_POST[$index]);
		}
	}else{
		return false;
	}
}

function get_server($index){
	if(isset($_SERVER[$index])){
		return $_SERVER[$index];
	}else{
		return false;
	}
}

function get_get($index, $secure = false){
	if(isset($_GET[$index])){
		if($secure){
			return htmlspecialchars(urldecode($_GET[$index]));
		}else{
			return urldecode($_GET[$index]);
		}
	}else{
		return false;
	}
}

function get_cookie($index){
	if(isset($_COOKIE[$index])){
		return $_COOKIE[$index];
	}else{
		return false;
	}
}

function get_session($index){
	if(isset($_SESSION[$index])){
		return $_SESSION[$index];
	}else{
		return false;
	}
}

function get_segment($segment, $next = 1){
	global $segments;
	$sn = false;
	$segment_nr = array_search($segment, $segments);
	
	if($segment_nr && isset($segments[$segment_nr + $next]))
		$sn = $segments[$segment_nr + $next];
	
	return $sn;
}

function format_time($time){
	$today = strtotime('Today');
	$yesterday = strtotime('Yesterday');
	$current_year = strtotime(date('Y') . '-01-01');
	$months_en = array(
                       'January',
                       'February',
                       'March',
                       'April',
                       'May',
                       'June',
                       'July',
                       'August',
                       'September',
                       'October',
                       'November',
                       'December');
	$months_lv = array(
                       'Janvārī',
                       'Februārī',
                       'Martā',
                       'Aprīlī',
                       'Maijā',
                       'Jūnijā',
                       'Jūlijā',
                       'Augustā',
                       'Septembrī',
                       'Oktobrī',
                       'Novembrī',
                       'Decembrī');

	if($time >= $today){
		$time = time() - $time;
		$return = $time;
		
		if($time <= 5){
			$return = 'tikko';
		}elseif($time <= 59){
			$return = 'pirms ' . $time . (substr($time, -1) == 1 && $time != 11  ? ' sekundes':' sekundēm');
		}elseif($time <= 60*60-1){
			$time = floor($time/60);
			$return = 'pirms ' . $time .  (substr($time, -1) == 1 && $time != 11  ? ' minūtes':' minūtēm');
		}else{
			$time = floor($time/3600);
			$return = 'pirms ' . $time .  (substr($time, -1) == 1 && $time != 11 ? ' stundas':' stundām');
		}
	}elseif($time < $today and $time >= $yesterday){
		$return = 'Vakar, ' . date('H:i', $time);
	}elseif($time < $current_year){
		$time = date("Y. \g\a\d\a d. F, H:i", $time);
		$return =  mb_strtolower(str_ireplace($months_en, $months_lv, $time), 'UTF8');
	}else{
		$time = date("j. F, H:i", $time);
		$return =  mb_strtolower(str_ireplace($months_en, $months_lv, $time), 'UTF8');
	}
	
	return $return;
}

function encode($array){
	$array = is_array($array) ? $array : [];
	array_walk_recursive($array, 'deencode', 'htmlspecialchars');
	return serialize($array);
}

function decode($str){
	$array = unserialize($str);
	$array = $array ? $array : [];
	array_walk_recursive($array, 'deencode', 'htmlspecialchars_decode');
	return $array;
}

function deencode(&$val, &$key, $func){
	$val = $func($val);
	$key = $func($key);
}

function refresh(){
	header('location: ' . REF);
}