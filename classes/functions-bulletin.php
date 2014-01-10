<?php

function theme_path($filename='bulletin/bulletin.txt') {
		$server_array = explode("/", $_SERVER['PHP_SELF']);
	  	$server_array_mod = array_pop($server_array);
	  	$server_info = implode("/", $server_array);
	return $_SERVER['DOCUMENT_ROOT']. $server_info . '/' . $filename;
}

function editor_read() { 
	$file2open = fopen(theme_path(), "r");
	$current_data = @fread($file2open, filesize(theme_path()));
	fclose($file2open);
	return $current_data;
}

function editor_write($editor_text = NULL) {
	$file2open = fopen(theme_path(), "w");
	$current_data = @fwrite($file2open, $editor_text);
	fclose($file2open);
}

?>