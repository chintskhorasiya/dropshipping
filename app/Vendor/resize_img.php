<?php
class resize_image
{
     private $__errors = array();

		function crop_img($image,$new_width,$new_height,$cropratio,$quality,$resizedir,$color='')
		{
				// Get the size and MIME type of the requested image
				$size	= GetImageSize($image);
				$mime	= $size['mime'];
				
				// Make sure that the requested file is actually an image
				if (substr($mime, 0, 6) != 'image/')
				{
					header('HTTP/1.1 400 Bad Request');
					return 'Error: requested file is not an accepted type: ' . $image;
					exit();
				}
				
				$width			= $size[0];
				$height			= $size[1];

				$maxWidth		= (isset($new_width)) ? (int) $new_width : 0;
				$maxHeight		= (isset($new_height)) ? (int) $new_height: 0;
				
				if (isset($color) && $color!='')
					$color		= preg_replace('/[^0-9a-fA-F]/', '', (string) $color);
				else
					$color		= FALSE;
				
				// If either a max width or max height are not specified, we default to something
				// large so the unspecified dimension isn't a constraint on our resized image.
				// If neither are specified but the color is, we aren't going to be resizing at
				// all, just coloring.
				if (!$maxWidth && $maxHeight)
				{
					$maxWidth	= 99999999999999;
				}
				elseif ($maxWidth && !$maxHeight)
				{
					$maxHeight	= 99999999999999;
				}
				elseif ($color && !$maxWidth && !$maxHeight)
				{
					$maxWidth	= $width;
					$maxHeight	= $height;
				}
				
				// Ratio cropping
				$offsetX	= 0;
				$offsetY	= 0;
				
				if (isset($cropratio))
				{
					$cropRatio		= explode(':', (string) $cropratio);
					if (count($cropRatio) == 2)
					{
						$ratioComputed		= $width / $height;
						$cropRatioComputed	= (float) $cropRatio[0] / (float) $cropRatio[1];
						
						if ($ratioComputed < $cropRatioComputed)
						{ // Image is too tall so we will crop the top and bottom
							$origHeight	= $height;
							$height		= $width / $cropRatioComputed;
							$offsetY	= ($origHeight - $height) / 2;
						}
						else if ($ratioComputed > $cropRatioComputed)
						{ // Image is too wide so we will crop off the left and right sides
							$origWidth	= $width;
							$width		= $height * $cropRatioComputed;
							$offsetX	= ($origWidth - $width) / 2;
						}
					}
				}
								
				// Setting up the ratios needed for resizing. We will compare these below to determine how to
				// resize the image (based on height or based on width)
				$xRatio		= $maxWidth / $width;
				$yRatio		= $maxHeight / $height;
				
				if ($xRatio * $height < $maxHeight)
				{ // Resize the image based on width
					$tnHeight	= ceil($xRatio * $height);
					$tnWidth	= $maxWidth;
				}
				else // Resize the image based on height
				{
					$tnWidth	= ceil($yRatio * $width);
				 	$tnHeight	= $maxHeight;
				}
				
				// Determine the quality of the output image
				$quality	= (isset($quality)) ? (int) $quality : DEFAULT_QUALITY;
								
				// Set up a blank canvas for our resized image (destination)
				$dst	= imagecreatetruecolor($tnWidth, $tnHeight);
				
				// Set up the appropriate image handling functions based on the original image's mime type
				switch ($size['mime'])
				{
					case 'image/gif':
						// We will be converting GIFs to PNGs to avoid transparency issues when resizing GIFs
						// This is maybe not the ideal solution, but IE6 can suck it
						$creationFunction	= 'ImageCreateFromGif';
						$outputFunction		= 'ImagePng';
						$mime				= 'image/png'; // We need to convert GIFs to PNGs
						$doSharpen			= FALSE;
						$quality			= round(10 - ($quality / 10)); // We are converting the GIF to a PNG and PNG needs a compression level of 0 (no compression) through 9
					break;
					
					case 'image/x-png':
					case 'image/png':
						$creationFunction	= 'ImageCreateFromPng';
						$outputFunction		= 'ImagePng';
						$doSharpen			= FALSE;
						$quality			= round(10 - ($quality / 10)); // PNG needs a compression level of 0 (no compression) through 9
					break;
					
					default:
						$creationFunction	= 'ImageCreateFromJpeg';
						$outputFunction	 	= 'ImageJpeg';
						$doSharpen			= TRUE;
					break;
				}
				$docRoot='';
				// Read in the original image
				$src	= $creationFunction($docRoot . $image);
				
				if (in_array($size['mime'], array('image/gif', 'image/png')))
				{
					if (!$color)
					{						
						// If this is a GIF or a PNG, we need to set up transparency
						imagealphablending($dst, false);
						imagesavealpha($dst, true);
					}
					else
					{
						// Fill the background with the specified color for matting purposes
						if ($color[0] == '#')
							$color = substr($color, 1);
						
						$background	= FALSE;
						
						if (strlen($color) == 6)
							$background	= imagecolorallocate($dst, hexdec($color[0].$color[1]), hexdec($color[2].$color[3]), hexdec($color[4].$color[5]));
						else if (strlen($color) == 3)
							$background	= imagecolorallocate($dst, hexdec($color[0].$color[0]), hexdec($color[1].$color[1]), hexdec($color[2].$color[2]));
						if ($background)
							imagefill($dst, 0, 0, $background);
					}
				}
				
				// Resample the original image into the resized canvas we set up earlier
				ImageCopyResampled($dst, $src, 0, 0, $offsetX, $offsetY, $tnWidth, $tnHeight, $width, $height);
				
				if ($doSharpen)
				{
					// Sharpen the image based on two things:
					//	(1) the difference between the original size and the final size
					//	(2) the final size
					$sharpness	=  $this->findSharp($width, $tnWidth);
					
					$sharpenMatrix	= array(
						array(-1, -2, -1),
						array(-2, $sharpness + 12, -2),
						array(-1, -2, -1)
					);
					$divisor		= $sharpness;
					$offset			= 0;
					imageconvolution($dst, $sharpenMatrix, $divisor, $offset);
				}
				
				// Put the data of the resized image into a variable				
				if($outputFunction($dst, $resizedir, $quality))
				{
					return true;
				}
				else
				{
					return false;
				}				
		}
		
		function findSharp($orig, $final) // function from Ryan Rud (http://adryrun.com)
		{
			$final	= $final * (750.0 / $orig);
			$a		= 52;
			$b		= -0.27810650887573124;
			$c		= .00047337278106508946;
			
			$result = $a + $b * $final + $c * $final * $final;
			
			return max(round($result), 0);
		}

                public function resize($original, $new_filename, $new_width = 0, $new_height = 0, $quality = 100) 
				{
                    if(!($image_params = getimagesize($original))) {
                        $this->__errors[] = 'Original file is not a valid image: ' . $orignal;
                        return false;
                    }

                    $width = $image_params[0];
                    $height = $image_params[1];

                    /* *
                    if(0 != $new_width && 0 == $new_height) {
                        $scaled_width = $new_width;
                        $scaled_height = floor($new_width * $height / $width);
                    } elseif(0 != $new_height && 0 == $new_width) {
                        $scaled_height = $new_height;
                        $scaled_width = floor($new_height * $width / $height);
                    } elseif(0 == $new_width && 0 == $new_height) { //assume we want to create a new image the same exact size
                        $scaled_width = $width;
                        $scaled_height = $height;
                    } else { //assume we want to create an image with these exact dimensions, most likely resulting in distortion
                        $scaled_width = $new_width;
                        $scaled_height = $new_height;
                    }
                    /* */
                    if($width == $height)
                    {
                        $scaled_height = floor($new_width*$height)/$width;
                        $scaled_width = $new_width;
                    }
                    if($width > $height)
                    {
                        $scaled_height = floor($new_width*$height)/$width;
                        $scaled_width = $new_width;
                    }
                    if($width < $height)
                    {
                        $scaled_width = floor($new_height*$width)/$height;
                        $scaled_height = $new_height;
                    }

                    /* *
                    echo "<br>width ".$width.' new_width '.$new_width;
                    echo "<br>height ".$height.' new_height '.$new_height;
                    echo "<br>scale width ".$scaled_width;
                    echo "<br>scaled_height ".$scaled_height;
                    exit;
                    /* */
                    
                    //create image
                    $ext = $image_params[2];
                    switch($ext) {
                        case IMAGETYPE_GIF:
                            $return = $this->__resizeGif($original, $new_filename, $scaled_width, $scaled_height, $width, $height, $quality);
                            break;
                        case IMAGETYPE_JPEG:
                            $return = $this->__resizeJpeg($original, $new_filename, $scaled_width, $scaled_height, $width, $height, $quality);
                            break;
                        case IMAGETYPE_PNG:
                            $return = $this->__resizePng($original, $new_filename, $scaled_width, $scaled_height, $width, $height, $quality);
                            break;
                        default:
                            $return = $this->__resizeJpeg($original, $new_filename, $scaled_width, $scaled_height, $width, $height, $quality);
                            break;
                    }

                    return $return;
            }

    public function getErrors()
    {
            return $this->__errors;
    }
    private function __resizeGif($original, $new_filename, $scaled_width, $scaled_height, $width, $height)
    {

        $error = false;

        if(!($src = imagecreatefromgif($original))) {
            $this->__errors[] = 'There was an error creating your resized image (gif).';
            $error = true;
        }

        if(!($tmp = imagecreatetruecolor($scaled_width, $scaled_height))) {
            $this->__errors[] = 'There was an error creating your true color image (gif).';
            $error = true;
        }

        if(!imagecopyresampled($tmp, $src, 0, 0, 0, 0, $scaled_width, $scaled_height, $width, $height)) {
            $this->__errors[] = 'There was an error creating your true color image (gif).';
            $error = true;
        }

        if(!($new_image = imagegif($tmp, $new_filename))) {
            $this->__errors[] = 'There was an error writing your image to file (gif).';
            $error = true;
        }

        imagedestroy($tmp);

        if(false == $error) {
            return $new_image;
        }

        return false;
    }

    private function __resizeJpeg($original, $new_filename, $scaled_width, $scaled_height, $width, $height, $quality)
    {
        $error = false;

        if(!($src = imagecreatefromjpeg($original))) {
            $this->__errors[] = 'There was an error creating your resized image (jpg).';
            $error = true;
        }

        if(!($tmp = imagecreatetruecolor($scaled_width, $scaled_height))) {
            $this->__errors[] = 'There was an error creating your true color image (jpg).';
            $error = true;
        }

        if(!imagecopyresampled($tmp, $src, 0, 0, 0, 0, $scaled_width, $scaled_height, $width, $height)) {
            $this->__errors[] = 'There was an error creating your true color image (jpg).';
            $error = true;
        }

        if(!($new_image = imagejpeg($tmp, $new_filename, $quality))) {
            $this->__errors[] = 'There was an error writing your image to file (jpg).';
            $error = true;
        }

        imagedestroy($tmp);

        if(false == $error) {
            return $new_image;
        }

        return false;
    }

    private function __resizePng($original, $new_filename, $scaled_width, $scaled_height, $width, $height, $quality)
    {
        $error = false;
        /**
         * we need to recalculate the quality for imagepng()
         * the quality parameter in imagepng() is actually the compression level,
         * so the higher the value (0-9), the lower the quality. this is pretty much
         * the opposite of how imagejpeg() works.
         */
        $quality = ceil($quality / 10); // 0 - 100 value
        if(0 == $quality) {
            $quality = 9;
        } else {
            $quality = ($quality - 1) % 9;
        }


        if(!($src = imagecreatefrompng($original))) {
            $this->__errors[] = 'There was an error creating your resized image (png).';
            $error = true;
        }

        if(!($tmp = imagecreatetruecolor($scaled_width, $scaled_height))) {
            $this->__errors[] = 'There was an error creating your true color image (png).';
            $error = true;
        }

        imagealphablending($tmp, false);

        if(!imagecopyresampled($tmp, $src, 0, 0, 0, 0, $scaled_width, $scaled_height, $width, $height)) {
            $this->__errors[] = 'There was an error creating your true color image (png).';
            $error = true;
        }

        imagesavealpha($tmp, true);

        if(!($new_image = imagepng($tmp, $new_filename, $quality))) {
            $this->__errors[] = 'There was an error writing your image to file (png).';
            $error = true;
        }

        imagedestroy($tmp);

        if(false == $error) {
            return $new_image;
        }
        return false;
    }
}


?>