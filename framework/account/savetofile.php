<?php
if (isset($_FILES['myFile'])) {
    // Example:
	session_start();
	$sessionUsr = $_SESSION['login_user'];
	$base = $_SERVER['DOCUMENT_ROOT'].'/usr/img/';

    move_uploaded_file($_FILES['myFile']['tmp_name'], $base . $_FILES['myFile']['name']);   

    $imgName = $_FILES['myFile']['name'];
    $finalImage = $base . $_FILES['myFile']['name'];
    $imageTh = $base. "thumbs/". $_FILES['myFile']['name'];

    //make_thumb($finalImage, $imageTh, 400); 
    $newThumb = CroppedThumbnail($finalImage,75,100);
    //db_stamp($imgName, $sessionUsr);
}

function db_stamp($imgUrl, $usr){

	include '../mysqlconn/mysql_login.php';
	$date = date('Format String', time());
	
	$db = mysql_select_db("psn", $connection);

	$query = "insert into ImageUrls (ImgUrl, ClientId, ServiceId, ImgD) values ('$imgUrl', '$usr', '1', '$date')";
	$result = mysql_query($query);

}


function make_thumb($src, $dest, $desired_width) {

	/* read the source image */
	$source_image = imagecreatefromjpeg($src);
	$width = imagesx($source_image);
	$height = imagesy($source_image);
	
	/* find the "desired height" of this thumbnail, relative to the desired width  */
	$desired_height = floor($height * ($desired_width / $width));
	
	/* create a new, "virtual" image */
	$virtual_image = imagecreatetruecolor($desired_width, $desired_height);
	
	/* copy source image at a resized size */
	imagecopyresampled($virtual_image, $source_image, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);
	
	/* create the physical thumbnail image to its destination */
	imagejpeg($virtual_image, $dest);
}


function CroppedThumbnail($imgSrc,$thumbnail_width,$thumbnail_height) { //$imgSrc is a FILE - Returns an image resource.
    //getting the image dimensions  
    list($width_orig, $height_orig) = getimagesize($imgSrc);   
    $myImage = imagecreatefromjpeg($imgSrc);
    $ratio_orig = $width_orig/$height_orig;
    
    if ($thumbnail_width/$thumbnail_height > $ratio_orig) {
       $new_height = $thumbnail_width/$ratio_orig;
       $new_width = $thumbnail_width;
    } else {
       $new_width = $thumbnail_height*$ratio_orig;
       $new_height = $thumbnail_height;
    }
    
    $x_mid = $new_width/2;  //horizontal middle
    $y_mid = $new_height/2; //vertical middle
    
    $process = imagecreatetruecolor(round($new_width), round($new_height)); 
    
    imagecopyresampled($process, $myImage, 0, 0, 0, 0, $new_width, $new_height, $width_orig, $height_orig);
    $thumb = imagecreatetruecolor($thumbnail_width, $thumbnail_height); 
    imagecopyresampled($thumb, $process, 0, 0, ($x_mid-($thumbnail_width/2)), ($y_mid-($thumbnail_height/2)), $thumbnail_width, $thumbnail_height, $thumbnail_width, $thumbnail_height);

    imagedestroy($process);
    imagedestroy($myImage);
    return $thumb;
}










?>