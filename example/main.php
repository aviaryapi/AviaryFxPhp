<?php 

	error_reporting(E_ALL);
	ini_set('display_errors', '1');
	
	require_once("AviaryFX.php");
	
	if( isset( $_GET['q'] ) ) { $method = $_GET['q']; }
	if( isset( $_POST['filterid'] ) ) { $filterid = $_POST['filterid']; }
	if( isset( $_POST['filepath'] ) ) { $filepath = $_POST['filepath']; }
	if( isset( $_POST['renderParameters'] ) ) { $renderparameters = $_POST['renderParameters']; }
	
	$api_key = "demoapp";
	$api_secret = "demoappsecret";
	
	$aviaryfx = new AviaryFX($api_key, $api_secret);
	
	//getFilters
	if($method == "getFilters") {
		$getFiltersResponse = $aviaryfx->getFilters();
	  	echo json_encode( $getFiltersResponse );
	}
	
	//upload
	if($method == "upload") {
		$uploadsDirectory = 'uploads/';
		//path on windows
		//$uploadsDirectory = 'C:\path\to\folder\uploads\\';
		$fieldname = 'file';
		if( !empty( $_FILES[$fieldname] ) ) {
			$now = time(); 
			while( file_exists( $uploadFilename = $uploadsDirectory.$now.'-'.$_FILES[$fieldname]['name'] ) ) { $now++; }
			@move_uploaded_file($_FILES[$fieldname]['tmp_name'], $uploadFilename) or die('receiving directory insuffiecient permission');
			$uploadResponse = $aviaryfx->upload($uploadFilename);
			echo json_encode( $uploadResponse );
			unlink($uploadFilename); //removes the file after uploading to the server
		}
	}
	
	//renderOptions
	if($method == "renderOptions") {
		$backgroundcolor = "0xFFFFFFFF";
		$format = "jpg";
		$quality = "100";
		$scale = "1";
		$cols = "3";
		$rows = "3";
		$cellwidth = "128";
		$cellheight = "128";
		$renderOptionsResponse = $aviaryfx->renderOptions($backgroundcolor, $format, $quality, $scale, $filepath, $filterid, $cols, $rows, $cellwidth, $cellheight);
		echo json_encode($renderOptionsResponse);
	}
	
	//render
	if($method == "render") {
		$backgroundcolor = "0xFFFFFFFF";
		$format = "jpg";
		$quality = "100";
		$scale = "1";
		$width = "0";
		$height = "0";
		$renderparameters = json_decode( stripcslashes( $renderparameters ), TRUE);
		$renderResponse = $aviaryfx->render($backgroundcolor, $format, $quality, $scale, $filepath, $filterid, $width, $height, $renderparameters);
		echo json_encode( $renderResponse );
	}

?>