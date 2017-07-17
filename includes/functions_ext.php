<?php



function myreplace($string) {
	preg_match_all('/&#(\d*)/', $string, $matches);
	foreach($matches[1] as $num) {
		$string = str_replace("&#$num;", html_entity_decode($num), $string);
	}
	return $string;
}
?>