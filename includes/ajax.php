<?php 
//Start session
session_start();

$error = $msg = '';

//include config, function and image class
require_once("../config.php");
require_once("functions.php");
require_once("SimpleImage.php");

//Because we are in includes/ folder we need to go back one dir to have the right upload path
$uploadpath = '../' . UPLOAD_PATH;

//Set a unique name for the file. You should use your user id or something to know 
$filename = substr(md5( microtime() ), 0, 15);

//If the acction is not specified set it to webcam
if (!isset($_POST['action']))
	$_POST['action'] = 'webcam';

//Switch by action
switch ($_POST['action'])
{
	case 'upload':
		//Get php.ini upload limit
		$max_post     = (int)(ini_get('post_max_size'));
		$max_upload   = (int)(ini_get('upload_max_filesize'));
		$memory_limit = (int)(ini_get('memory_limit'));
		$upload_limit = min($max_upload, $max_post, $memory_limit);
		
		//Check if the image isset
		if (isset($_FILES['uploadimage']['tmp_name']))
		{	
			//Check if the image was uploaded
			if (!is_uploaded_file($_FILES['uploadimage']['tmp_name'])) {
				$error = 1;
			}
			else
			{
				//Get image size
				$image_size = $_FILES['uploadimage']['size'];

				if ($image_size > $upload_limit *100*100*100  or $image_size > FILE_SIZE_LIMIT *100*100*100) {
					$error = 'big';
				}
				else
				{
					//Get file name
					$file = $_FILES['uploadimage']['name']; 
					//Get file extension
					$ext = get_file_ext($file);
					//Get allowed extensions
					$allowed_ext =  explode('|', ALLOWED_EXTENSIONS);
					
					//Check if extension is allowed
					if (!in_array($ext, $allowed_ext) ) {
						$error = implode(', ', $allowed_ext); 
					}
					else
					{
						$ext = '.'.$ext;

						//Set temporarily upload path
						$tmp_path = $uploadpath . 'tmp/';

						//Create dirs if not exists
						if (!is_dir($tmp_path))
							mkdir($tmp_path);
						
						$path = $tmp_path . basename( $filename.$ext );

						//Check if the file was uploaded
						if(move_uploaded_file($_FILES['uploadimage']['tmp_name'], $path))
						{
							//If the file extension is bmp we need some extra functions
							if ($ext == '.bmp')
								require_once('BMP.php');

							//Set dir permissions
							chmod($path, 0777);
							//If the image is bigger than the maximum width resize it
							if(imgWidth($path) > IMAGE_MAX_WIDTH)
							{
								$image = new SimpleImage();
								$image->load($path);
								$image->resizeToWidth(IMAGE_MAX_WIDTH);
								$image->save($path);
							}
							//If the image is bigger than the maximum height resize it
							if(imgHeight($path) > IMAGE_MAX_HEIGHT)
							{
								$image = new SimpleImage();
								$image->load($path);
								$image->resizeToHeight(IMAGE_MAX_HEIGHT);
								$image->save($path);
							}
							//image url
							$msg = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['REQUEST_URI']) . '/' . $path;
							//image file session
							$_SESSION['_tmp_image']  = $filename . $ext;
							
						}
						else $error = 1;
					}
				}
			}
		}
		else $error = 1;
	break;
	
	case 'save_image':
		//Check if the image session and cropping values are set
		if(isset($_SESSION['_tmp_image'], $_POST['x1'], $_POST['y1'], $_POST['w'], $_POST['h']))
		{
			//Set temporarily upload path
			$tmp_path = $uploadpath . 'tmp/';
			//Create dirs if not exists
			if (!is_dir($tmp_path))
				mkdir($tmp_path);

			$tmp_path .= $_SESSION['_tmp_image'];

			//Set new path
			$path = $uploadpath . 'avatars/' . $_SESSION['_tmp_image'];
			
			//crop image
			cropImage($path, $tmp_path, $_POST['w'], $_POST['h'], $_POST['x1'], $_POST['y1'], IMAGE_CROP_SIZE/$_POST['w']);
			
			
			/*	Here you may want to insert  $_SESSION['_tmp_image'] into database so you know what avatar has */


			//delete temporarily image
			@unlink($tmp_path);

			//return image url
			$msg = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['REQUEST_URI']) 
				. '/' . $path . '?'. time(); //add the current timestamp at the end so the image won't be cached;

			//Set a user session with the avatar
			$_SESSION['user_avatar'] = $msg;

			//unset the temp session
			unset($_SESSION['_tmp_image']);
		}
		else $error = 1;
	break;

	case 'webcam':
		//get file data
		$jpeg_data = file_get_contents('php://input');
		if (!empty($jpeg_data))
		{
			//set filename
			$filename = $filename . '.jpg';
			//set session
			$_SESSION['_tmp_image'] = $filename;

			$filename = $uploadpath .'tmp/' . $filename;
			//save image
			$result = file_put_contents( $filename, $jpeg_data );
			if ($result) {
				//return file url
				$msg = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['REQUEST_URI']). '/' . $filename;
			}
			else $error = 1;
		}
		else $error = 1;
	break;
}
//json response
echo  json_encode(array('error' => $error, 'msg' => $msg));
?>