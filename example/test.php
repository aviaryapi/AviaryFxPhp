<?php 

	error_reporting(E_ALL);
	ini_set('display_errors', '1');
	
	require_once("AviaryFX.php");
	
	$api_key = "demoapp";
	$api_secret = "demoappsecret";
	
	$aviaryfx = new AviaryFX($api_key, $api_secret);
	
	//getFilters
	echo "<pre><p><strong>Test getFilters: </strong></p>";
	$getFiltersResponse = $aviaryfx->getFilters();
	print_r($getFiltersResponse);
	
	//upload
	echo "<p><strong>Test upload: </strong></p>";
	$file = 'uploads/ostrich.jpg';
	$uploadResponse = $aviaryfx->upload($file);
	print_r($uploadResponse);
	
	//renderOptions
	echo "<p><strong>Test renderOptions: </strong></p>";
	$backgroundcolor = "0xFFFFFFFF";
	$format = "jpg";
	$quality = "100";
	$scale = "1";
	$filepath = $uploadResponse["url"];
	$filterid = "22";
	$cols = "3";
	$rows = "3";
	$cellwidth = "128";
	$cellheight = "128";
	$renderOptionsResponse = $aviaryfx->renderOptions($backgroundcolor, $format, $quality, $scale, $filepath, $filterid, $cols, $rows, $cellwidth, $cellheight);
	print_r($renderOptionsResponse);
	
	//render
	echo "<p><strong>Test render: </strong></p>";
	$backgroundcolor = "0xFFFFFFFF";
	$format = "jpg";
	$quality = "100";
	$scale = "1";
	$width = "0";
	$height = "0";
	$renderparameters = array	( "parameter" => array	( 	array("id" => "Gamma", "value" => 2.3908640030750226 ),
								                            array("id" => "Smoothing", "value" => 4 ),
								                            array("id" => "Caption Index", "value" => 50 ) 
														)
								);
	$renderResponse = $aviaryfx->render($backgroundcolor, $format, $quality, $scale, $filepath, $filterid, $width, $height, $renderparameters);
	print_r($renderResponse);

?>