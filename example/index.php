<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<title>Ostrich Php Example</title>
		<link rel="stylesheet" type="text/css" href="css/style.css" />
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js"></script>
		<script type="text/javascript" src="js/ajaxfileupload.js"></script>
		<script type="text/javascript" src="js/jquery.json-2.2.js"></script>
		<script type="text/javascript" src="js/aviaryFXExample.js"></script>
	</head>
	
	<body>
	
		<!-- container -->
		<div id="container">
		
			<!-- leftPanel -->
			<div id="leftPanel">
				<!-- pancontainer -->
				<div class="pancontainer" data-orient="center" data-canzoom="yes">
					<img id="imageArea" src="images/ostrich_retro.jpg" />
				</div><!-- /pancontainer -->
			</div><!-- /leftPanel -->
			
			<!-- rightPanel -->
			<div id="rightPanel">
				<!-- uploadForm -->
				<div id="uploadForm">
					<form id="upload" enctype="multipart/form-data" method="post">
						<input id="file" type="file" name="file" />
						<input id="submit" type="submit" name="submit" value="Upload" />
					</form>
				</div><!-- /uploadForm -->
				
				<!-- effectOptions -->
				<div id="effectOptions" style="display: none;">
					<select class="selectEffect">
						<option selected="selected">-- Select an effect --</option>
					</select>
					<div id="thumbs" style="display: none;"></div>					
				</div><!-- /effectOptions -->
			</div><!-- /rightPanel -->
			
			<!-- loader -->
			<div id="loader" style="display:none;">
				<img id="loading" src="images/loader.gif" />
			</div><!-- /loader -->
			
			<div class="clearfix"></div>
			
		</div><!-- /container -->
		
		<!-- <p><img id="thumbImageSample" src="" alt="" /></p> -->
		
	</body>
	
</html>