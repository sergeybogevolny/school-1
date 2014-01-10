<?php
	//Where images should be uploaded
	define('UPLOAD_PATH', 'uploads/');
	
	//Allowed extensions
	define('ALLOWED_EXTENSIONS', 'jpg|png|jpeg|gif|bmp');
	
	//The maximum width for the image when is saved to temporarily dir
	define('IMAGE_MAX_WIDTH', 800);
	
	//The maximum height for the image when is saved to temporarily dir
	define('IMAGE_MAX_HEIGHT', 500);
	
	//The crop size of the image
	define('IMAGE_CROP_SIZE', 250);
	
	//The file size limit in MB
	define('FILE_SIZE_LIMIT', 5);
?>