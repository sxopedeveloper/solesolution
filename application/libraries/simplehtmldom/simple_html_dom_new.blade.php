<?php
include_once 'HtmlWeb.php';
use simplehtmldom\HtmlWeb;

function file_get_html($url)
{
	$doc = new HtmlWeb();
	return $html = $doc->load($url);
}

function myCleanData($string)
{
	$string = trim($string);								
	if(get_magic_quotes_gpc()) {
		$string = stripslashes($string);					        
	}

	return $string;
}
?>