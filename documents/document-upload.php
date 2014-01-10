<?php
/*
There is 2 parameter for this file 
1) fid (folder id) 
2) filename
3)fname(foldername)

*/

include_once(dirname(dirname(dirname(__FILE__))) . '/classes/profile.class.php');
$fileName = $_GET['filename'];
$a = $_GET['p1'];
$b = $_GET['p2'];


	$error = "";
	$msg = "";
	$fileElementName = $fileName;
	if(!empty($_FILES[$fileElementName]['error']))
	{
		switch($_FILES[$fileElementName]['error'])
		{

			case '1':
				$error = 'The uploaded file exceeds the upload_max_filesize directive in php.ini';
				break;
			case '2':
				$error = 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form';
				break;
			case '3':
				$error = 'The uploaded file was only partially uploaded';
				break;
			case '4':
				$error = 'No file was uploaded.';
				break;

			case '6':
				$error = 'Missing a temporary folder';
				break;
			case '7':
				$error = 'Failed to write file to disk';
				break;
			case '8':
				$error = 'File upload stopped by extension';
				break;
			case '999':
			default:
				$error = 'No error code avaiable';
		}
		
  // print_r($_FILES); die();
	}elseif(empty($_FILES[$fileElementName]['tmp_name']) || $_FILES[$fileElementName]['tmp_name'] == 'none')
	{
		$error = 'No file was uploaded..';
	}else 
	{
		
if($a != '' && $b != ''){

	$directory = dirname(dirname(__FILE__))."/documents/".$a."/".$b ;
	
	$param1Dir = dirname(dirname(__FILE__))."/documents/".$a ;
	
	if(!is_dir( $param1Dir)){
		mkdir($param1Dir . "/");
		if(!is_dir( $directory)) {
		  mkdir($directory . "/");
		}
	}
	
	if(!is_dir( $directory)) {
		  mkdir($directory . "/");
		}

}
if($b == ''){
	$directory = dirname(dirname(__FILE__))."/documents/".$a;
	if(!is_dir( $directory)) {
      mkdir($directory . "/");
    }

}
if($a == ''){
	$directory = dirname(dirname(__FILE__))."/documents";
	if(!is_dir( $directory)) {
    mkdir($directory . "/");
   }

}

$path = $directory ."/"; 
$location = $path . $_FILES[$fileElementName]['name'];

move_uploaded_file($_FILES[$fileElementName]['tmp_name'], $location); 
			$msg =$location;
			//for security reason, we force to remove all uploaded file
			@unlink($_FILES[$fileElementName]);		
	}		
	echo "{";
	echo				"error: '" . $error . "',\n";
	echo				"msg: '" . $msg . "'\n";
	echo "}";
?>