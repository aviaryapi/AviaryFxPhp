# Aviary Effects API PHP Library

## Introduction

A library for the Aviary Effects API written in PHP.

## Test

To test run example/test.php in the browser. This should run all the methods and print the output.

## Instantiate an AviaryFX object

The Aviary Effects API is exposed via the AviaryFX class.

To create an instance of the class with your API key and API secret:

<pre><code>require_once("AviaryFX.php");
$api_key = "demoapp";
$api_secret = "demoappsecret";
$aviaryfx = new AviaryFX($api_key, $api_secret);
</code></pre>

## Get a list of filters

The getFilters() method returns an array of filters that contain the label, uid and description for each filter. These can be used to render images.

To get the array of filters:

<pre><code>$getFiltersResponse = $aviaryfx->getFilters();
print_r($getFiltersResponse);
</code></pre>

## Upload an image to the AviaryFX Service

The upload() method is used to upload image files to the AviaryFX Service to apply effects to them. This method returns an array with a url to the file on the server. The returned image url should be used for subsequent interactions.

To upload an image:

<pre><code>$file = 'uploads/ostrich.jpg';
$uploadResponse = $aviaryfx->upload($file);
print_r($uploadResponse);
</code></pre>

## Render thumbnails

Use the renderOptions() method to render a thumbnail grid of the image with preset filter options for the selected filter. This returns an array with a url to the thumbnail grid and render option parameters for each of the requested number of options for that filter.

To render a 3x3 thumbnail grid with 128px x 128px cells:

<pre><code>$backgroundcolor = "0xFFFFFFFF";
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
</code></pre>

## Render full image

Once an option is selected call the render() method along with the filter ID, image url and the parameters for the selected option. This returns a dict with the URL to rendered image.

<pre><code>$backgroundcolor = "0xFFFFFFFF";
$format = "jpg";
$quality = "100";
$scale = "1";
$width = "0";
$height = "0";
$renderparameters = array	( "parameter" => array	( array("id" => "Gamma", "value" => 2.3908640030750226 ),
array("id" => "Smoothing", "value" => 4 ),
array("id" => "Caption Index", "value" => 50 ) 
)
);
$renderResponse = $aviaryfx->render($backgroundcolor, $format, $quality, $scale, $filepath, $filterid, $width, $height, $renderparameters);
print_r($renderResponse);
</code></pre>

## Methods

Check out the official [Aviary Effects API documentation](http://developers.aviary.com/effects-api) for more details about the Aviary Effects API and class methods.

## Feedback and questions

Found a bug or missing a feature? Don't hesitate to create a new issue here on GitHub, post to the [Google Group](http://groups.google.com/group/aviaryapi) or email us.
