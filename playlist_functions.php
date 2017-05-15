<?php
ob_start();
//~ include_once "mysqlClass.inc.php"; // already included in function.php
include_once "function.php";

function display_playlist_media($i){
	$r = "<div class='col-8'><div id='now_playing'>";
	
	$filepath = $i['Path'];
	$ext =  pathinfo($filepath,PATHINFO_EXTENSION);
	$title = $i['Title'];
	$type=$i['FileType'];
	$mediaid = $i['Media'];
	$num_views = $i['NumViews'];
	
	// increment view count
	incr_view_count($mediaid);
	// show num views
	$r .= "<p><small>NumViews: $num_views</small></p>";
		
	// display different file types in different ways
	if($type == "Image") //view image
	{
	
		$r .= "
		<p>Viewing Picture:</p><br>
		<h2> $title</h2>
		<img class='media-object img-fluid' style='max-width: 100%; height: auto;'  alt='Can Not Display!' src='$filepath' 
			id='media'/>";
	}
	elseif($type == 'Audio')
	{
		$r .= "
		<p>Viewing Audio:</p>
		<h2> $title</h2>
		<audio autoplay controls style='width:600;height:100;' id='media'>
		  <source src='$filepath' type='audio/$ext'>
		Your browser does not support the audio element.
		</audio>
		<br><br><br><br>";

	}
	else //view movie
	{
		
		$r .= "<p>Viewing Video:</p>
		<h2> $title</h2>
		<video width='600' height='360' autoplay controls id='media'>
			<source src='$filepath' type='video/$ext'>
			Your browser does not support the video tag.
		</video>";

	}


		
		
			
	$r .= "<a href='./media.php?id=$mediaid'><button class=' mt-4 btn' ><big>Go to Media</big><br><small>to Rate/Subscribe/Block/Comment</small></button></a>";
	
	$r .= "</div></div>"; // close col-8 and div that holds all visual stuff
	echo $r;
}
?>
