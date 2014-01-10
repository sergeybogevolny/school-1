<?php
function get_file_ext($file)
{
	$ext = strtolower($file[strlen($file)-4].$file[strlen($file)-3].$file[strlen($file)-2].$file[strlen($file)-1]);
	if ($ext[0] == '.')
		$ext = substr($ext, 1, 3);
	return $ext;
}

function cropImage($save_path, $image_path, $width, $height, $start_width, $start_height, $scale)
{
	list($imagewidth, $imageheight, $imageType) = getimagesize($image_path);
	$imageType = image_type_to_mime_type($imageType);
	
	$newImageWidth = ceil($width * $scale);
	$newImageHeight = ceil($height * $scale);
	$newImage = imagecreatetruecolor($newImageWidth, $newImageHeight);

	switch($imageType)
	{
		case "image/gif":
			$source = imagecreatefromgif($image_path); 
			break;
	    case "image/pjpeg":
		case "image/jpeg":
		case "image/jpg":
			$source = imagecreatefromjpeg($image_path); 
			break;
	    case "image/png":
		case "image/x-png":
			$source = imagecreatefrompng($image_path); 
			break;
  	}

	imagecopyresampled($newImage, $source, 0, 0, $start_width, $start_height, $newImageWidth, $newImageHeight, $width, $height);
	
	switch($imageType)
	{
		case "image/gif":
	  		imagegif($newImage, $save_path); 
			break;
      	case "image/pjpeg":
		case "image/jpeg":
		case "image/jpg":
	  		imagejpeg($newImage, $save_path, 90); 
			break;
		case "image/png":
		case "image/x-png":
			imagepng($newImage, $save_path);  
			break;
    }
	chmod($save_path, 0777);
	return $save_path;
}
function imgHeight($image)
{
	$size = getimagesize($image);
	$height = $size[1];
	return $height;
}
function imgWidth($image)
{
	$size = getimagesize($image);
	$width = $size[0];
	return $width;
}
?>