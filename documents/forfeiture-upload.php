<?php

include_once(dirname(dirname(dirname(__FILE__))) . '/classes/profile.class.php');
$id = $_SESSION['nware']['user_id'] ;
$fileName = $_GET['filename'];
$fid = $_GET['fid'];

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

$directory = dirname(dirname(__FILE__)) ."/documents/forfeitures/". $fid ;

if(!is_dir( $directory)) {
    mkdir($directory . "/");
}
$path = dirname(dirname(__FILE__)) ."/documents/forfeitures/". $fid ."/"; 
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