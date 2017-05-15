<!-- usage: playlist_single.php?playlist_id=7 -->

<?php
session_start();
include_once "function.php";
include_once "playlist_functions.php";
?>
<?php include "header.php"; ?>

	<body>
		<div class='container'>
			<div class='row mt-4'>
	<?php include "navbar.php";?>
	<?php if (isset($_SESSION['username'])){?>
	
	<?php 
		// get all the medias in this playlist
		$playlist_id = $_REQUEST['playlist_id'];
		$query = "select * from IsInPlaylist, Media
				where
					IsInPlaylist.List = $playlist_id
					and Media.Id = IsInPlaylist.Media
					order by IsInPlaylist.Id
					;";
		$result = mysql_query($query);
		if (!$result){
			die ( "fail: " . mysql_error());
		}
		
		// display first
		if (mysql_num_rows($result) != 0){
		$i = mysql_fetch_assoc($result);
		$mediaid = $i['Id'];

		display_playlist_media($i);
		

		
		//store info about them for automatic starting & make buttons of all			
		$button_display = "
		<div class='col-md-4 float-right'>
			<h2>Playlist Media</h2>
			";
		$list = "";
		$first_time = true;
		$counter = 0;
		mysql_data_seek($result, 0);
		while ( $i = mysql_fetch_assoc($result) ){
			$media_id = $i['Media'];
			$filepath = $i['Path'];
			$ext =  pathinfo($filepath,PATHINFO_EXTENSION);
			$title = $i['Title'];
			$type=$i['FileType'];
			
			// make button
			$button_display .= "<div class='row mb-2'><button class='btn' onClick='play_specified($counter)'>$title</div></button>";
			$counter++;
			
			// store media's info in list
			if ($first_time == true){
				$first_time = false;
				$list .= " ";
			} else {
				$list .= ", ";
			}
			$list .= "{media_id: '$media_id',
						filepath: '$filepath',
						ext: '$ext',
						title: '$title',
						type: '$type'}
					";
		}
		
		$button_display .= "</div>";
		echo $button_display;
		

		echo "
		<script>
			var MEDIA_LIST = [".$list."];
			var MEDIA_LIST_INDEX = 0;
		</script>";
	} else {
	// end if there are actually rows
	echo "<p> There are no videos in this playlist yet</p>";
	}
	?>

	
	
		</div> <!-- row -->
			</div> <!-- container -->
			
			

	<?php include 'footer.php'; ?>
	<script>
		
		
		function play_next(){
			
			MEDIA_LIST_INDEX++;
			console.log(MEDIA_LIST_INDEX);
			if (MEDIA_LIST_INDEX < MEDIA_LIST.length){
				play_specified(MEDIA_LIST_INDEX);
			}
		
		}
		
		function play_specified(index_to_play)
		{	// index_to_play indexes into MEDIA_LIST  
			
			//~ recall these constants were set in the php
			//~ MEDIA_LIST
			//~ MEDIA_LIST_INDEX 0;
			
			var media = MEDIA_LIST[index_to_play];
			var $media_id = media.media_id;
			var $filepath = media.filepath;
			var $ext = media.ext;
			var $title = media.title;
			var $type = media.type;
			
			// increment the views count
			
			// make new element
			var $r = "<div id='now_playing'>";
			if($type == 'Image') //view image
			{

				$r += "<p>Viewing Picture:</p><br><h2>"+$title+"</h2>"+
				"<img class='media-object img-fluid' style='max-width: 100%; height: auto;' alt='Can Not Display!' src='"+$filepath+"'"+ 
					"id='media'/>";
			}
			else if($type == 'Audio')
			{
				$r += "\
				<p>Viewing Audio:</p>\
				<h2>"+$title+"</h2>\
				<audio autoplay controls style='width:600;height:100;' id='media'>\
				  <source src='"+$filepath+"' type='audio/"+$ext+"'>\
				Your browser does not support the audio element.\
				</audio>\
				<br><br><br><br>";

			}
			else //view movie
			{
				
				$r += "<p>Viewing Video:</p>\
				<h2>"+$title+"</h2>\
				<video width='600' height='360' autoplay controls id='media'>\
					<source src='"+$filepath+"' type='video/"+$ext+"'>\
					Your browser does not support the video tag.\
				</video>";

			}
			$r += "<a href='./media.php?id="+$media_id+"'><button class=' mt-4 btn' ><big>Go to Media</big><br><small>to Rate/Subscribe/Block/Comment</small></button></a>";
			
			$r += "</div>";
			// replace the element with id 'playing_now'
			//$("#playing_now").replaceWith("<p>hellow world</p>");
			
			$("#now_playing").replaceWith($r);
			// load and play (if the type is video -- or audio?)
			

			MEDIA_LIST_INDEX = index_to_play;
			document.getElementById("media").addEventListener("ended", play_next); 

			 
		}
		
		document.getElementById("media").addEventListener("ended", play_next);
		
		//$(document).ready(function(){
			//$("#media").on('ended',function(){
			//  console.log('Video has ended!');
			  
			//});
		//});
	</script>
	<script type="text/javascript" src="js/navbar.js"></script>
	<?php } else { echo "You are not logged in."; } ?> <!-- end if (isset($_SESSION('username') -->
	</body>
	
</html>
