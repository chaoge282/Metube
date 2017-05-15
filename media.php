<?php
	session_start();
	include_once "function.php";
?>
<?php
	include "header.php";
?>
<body>

<?php
  include "navbar.php";
?>

<div class="container">
  <div class="row mt-4">
    <div class="col-8">
<?php

// display media
if(isset($_REQUEST['id'])) {
  	$mediaid=$_REQUEST['id'];
	$query = "select * from Media where Id='$mediaid' ";
	$qresult = mysql_query( $query );
	$result = mysql_fetch_assoc($qresult);
	
	//updateMediaTime($_GET['id']);
	$category=$result['Category'];
	$filepath=$result['Path'];
  	$ext = pathinfo($filepath,PATHINFO_EXTENSION);
  	$filename=basename($filepath);
	$type=$result['FileType'];
	$userId=$result['User'];
	$uquery = "select * from User where Id='$userId' ";
	$ures = mysql_query($uquery);
	$uresult = mysql_fetch_assoc($ures);
	$username_uploader = $uresult['Username'];
	$user_id_uploader = $result['User'];

	$num_views = $result['NumViews'];

	if($type == "Image") //view image
	{
?>
		<p>Viewing Picture:</p><br>
		<h2><?php echo $result['Title']; ?></h2>
			<p><small>Num Views: <?php echo $num_views;  ?> </small></p>

<!--
		<img class="media-object" alt="Can Not Display!" width="600" height="280" src="<?php echo $filepath; ?>" />
-->
		<img class='media-object img-fluid' style='max-width: 100%; height: auto;' alt="Can Not Display!" src="<?php echo $filepath; ?>" />
<?php
	}
	elseif($type == "Audio")
	{
?>
	<p>Viewing Audio:</p>
	<h2><?php echo $result['Title'];?></h2>
	<p><small>Num Views: <?php echo $num_views;  ?> </small></p>


	<audio autoplay controls style="width:600;height:100;">
	  <source src="<?php echo $filepath; ?>" type="audio/<?php echo $ext ?>">
	Your browser does not support the audio element.
	</audio>
	<br><br><br><br>

<?php
	}
	else //view movie
	{
?>
	<!-- <p>Viewing Video:<?php echo $result_row[2].$result_row[1];?></p> -->
	<p>Viewing Video:</p>
	<h2><?php echo $result['Title'];?></h2>
		<p><small>Num Views: <?php echo $num_views;  ?> </small></p>

<!--
    <object id="MediaPlayer" width=320 height=286 classid="CLSID:22D6f312-B0F6-11D0-94AB-0080C74C7E95" standby="Loading Windows Media Player components…" type="application/x-oleobject" codebase="http://activex.microsoft.com/activex/controls/mplayer/en/nsmp2inf.cab#Version=6,4,7,1112">

    <param name="filename" value="<?php echo $filename;?>">
    <param name="Showcontrols" value="True">
    <param name="autoStart" value="True">

    <embed type="application/x-mplayer2" src="<?php echo $filepath; ?>" name="MediaPlayer" width=320 height=240></embed>
    </object>
 -->     
 	<video width="600" height="360" autoplay controls>
  		<source src="<?php echo $filepath; ?>" type="video/<?php echo $ext ?>">
  		Your browser does not support the video tag.
	</video>


<?php
  	}
  	// increment num views
  	incr_view_count($mediaid);

?>

<?php
if(isset($_SESSION['username']))
{
    // general info
	if(isset($_REQUEST['id'])){

	$mediaid = $_REQUEST['id'];
	$username=$_SESSION['username'];


	if(isset($_REQUEST['star'])){
	$numstars = $_REQUEST['star'];
	$query="select * from User where Username='$username'";
	$qresult=mysql_query($query);
	$userId=mysql_fetch_assoc($qresult)['Id'];

	$query="select * from Rating where Media=$mediaid and User=$userId";
	$result=mysql_query($query);
	//$row=mysql_fetch_row($result);
		if(mysql_num_rows($result) ==0){
			$query="insert into Rating values(NULL, $numstars, $userId, $mediaid)";
			$result=mysql_query($query);
			echo "<script type='text/javascript'>alert('Thank you for your rating!');</script>";
		}
		else{
			$query="update Rating set NumStars=$numstars where Media=$mediaid and User=$userId";
			$result=mysql_query($query);
			echo "<script type='text/javascript'>alert('Your ratings changed!');</script>";
		}
		}
	}
	if(isset($_REQUEST['comment'])){
	$mediaid = $_REQUEST['id'];
	$username=$_SESSION['username'];
	$text = mysql_real_escape_string($_REQUEST['comment']);

	$query="select * from User where Username='$username'";
	$qresult=mysql_query($query);
	$userId=mysql_fetch_assoc($qresult)['Id'];

	$query = "insert into Comment values (NULL, '$userId', '$mediaid', '$text',NOW())";
	$result = mysql_query($query);

}
?>
	<!-- download -->
    <div class="row-container">
	<a href="channel.php?id=<?php echo $user_id_uploader ?>" style="font-size:2em;"><?php echo $username_uploader ?></a>
	<a href="media_download_process.php?id=<?php echo $mediaid;?>" target="_blank" ><button class="btn btn-warning offset-5">Download</button></a>
	<br>

	<!-- subscribe -->
	<form action="" method='post'>
		<button type="submit" class="btn btn-danger btn-check" type='submit' name='subscribe_submit' style="border-radius:2px font-size:20px;">

				<?php
				$user_id = $_SESSION['user_id'];
				if (isset($_POST['subscribe_submit'])){
					//subscribe or unsubscribe as appropriate
					$is_subscribed = is_subscribed($user_id, $mediaid);
					if ($is_subscribed) unsubscribe($user_id, $mediaid);
					else subscribe($user_id, $mediaid);

				}
				?>

				<?php
				// query db to see if they're subscribed (important that it's after we've made the change, we cant just use the opposite value as above b/c above might not have happened, it only happens if subscribe_submit is set in POST)
				// mark button appropriately
				$is_subscribed = is_subscribed($user_id, $mediaid);
				if ($is_subscribed) echo "Unsubscribe";
				else echo "Subscribe";


				?>
      	</button>
	</form>



	<!-- block -->
	<form action="" method='post'>
		<button type="submit" class="btn btn-danger btn-check" type='submit' name='block_submit' style="border-radius:2px font-size:20px;">

				<?php
				$user_id = $_SESSION['user_id'];
				if (isset($_POST['block_submit'])){
					//subscribe or unsubscribe as appropriate
					$is_blocked = is_blocked($user_id, $mediaid);

					if ($is_blocked) unblock($user_id, $mediaid);
					else block($user_id, $mediaid);

				}
				?>

				<?php
				// query db to see if they're subscribed (important that it's after we've made the change, we cant just use the opposite value as above b/c above might not have happened, it only happens if subscribe_submit is set in POST)
				// mark button appropriately
				$is_blocked = is_blocked($user_id, $mediaid);
				if ($is_blocked) echo "Unblock User";
				else echo "Block User";
				?>
      	</button>
	</form>
	
	<!-- add to playlist -->
	<form action="" method='post'>
		<?php
		$user_id = $_SESSION['user_id'];
		 make_playlist_selector($user_id); // get the playlists just for this user
		 ?> 
		<button type="submit" class="btn btn-danger btn-check" type='submit' name='add_to_list_submit' style="border-radius:2px font-size:20px;">Add to Playlist

				<?php
				if (isset($_POST['add_to_list_submit'])){
					$list_id = $_POST['playlist'];
					//subscribe or unsubscribe as appropriate
					add_to_list($mediaid, $list_id); // add user to playlist $list

				}
				?>

      	</button>

	</form>


	<!-- rate?-->
    </div>
    <div class="row mt-3">
	<label style="font-size:20px;">Rate:</label>
	<div class="stars">
	  <form id="rate" method="post" action="">
	    <input class="star star-5" id="star-5" type="radio" name="star" value="5" onclick="this.form.submit()"/>
	    <label class="star star-5" for="star-5"></label>
	    <input class="star star-4" id="star-4" type="radio" name="star" value="4" onclick="this.form.submit()"/>
	    <label class="star star-4" for="star-4"></label>
	    <input class="star star-3" id="star-3" type="radio" name="star" value="3" onclick="this.form.submit()"/>
	    <label class="star star-3" for="star-3"></label>
	    <input class="star star-2" id="star-2" type="radio" name="star" value="2" onclick="this.form.submit()"/>
	    <label class="star star-2" for="star-2"></label>
	    <input class="star star-1" id="star-1" type="radio" name="star" value="1" onclick="this.form.submit()"/>
	    <label class="star star-1" for="star-1"></label>
	  </form>
	  <br>
<?php
	$query="select * from Media where Id=$mediaid";
	$rresult=mysql_query($query);
	$avgRate=mysql_fetch_assoc($rresult)['AvgRating'];
?>
	  <p>Avage Rating: <?php echo $avgRate; ?></p>
	</div>
    </div>


	<!-- comment -->
    <div id="comments" class="row form-group mt-3">
	<form id="myform" method="post" action="">
      <label style="font-size:20px;">Comments:</label>
      <br>
      <textarea class="form-control" rows="3" type="text" style="width:200%;" name="comment" form="myform" placeholder="Say something" ></textarea>
	<div  class="row mt-2 ml-1">
	<button class="btn btn-primary mr-1" type="submit" onclick="comment()">comment</button>
    	</div>
	</form>
     </div>
<?php
	$query="select * from Comment where Media =$mediaid";
	$result = mysql_query($query);
	$comment = "";
	while($textcom = mysql_fetch_assoc($result)){
	$text = $textcom['Text'];
	$comment .="	<div class='row mt-2 ml-2'>
			<h5>$username: </h5>
			<br>
			<p>$text</p>
			<br>
			</div>";
		}
	echo $comment;
	}
?>
  </div>

	<!-- recommendations -->
  <div class="float-right">
    <h1>Recommended</h1><br>
<?php
// add to query to avoid 
	$user_id = 0;
	if (isset($_SESSION['user_id'])) $user_id = $_SESSION['user_id'];

	$query_end = " and Media.Id not in 
						(select Media.Id from Media, BlockedList
						where 
							Media.User = BlockedList.Owner
						and $user_id = BlockedList.Member)
					and Media.Id not in 
						(select Media.Id from Media where Media.SharingLevel = 'Private')
					and Media.Id not in 
						(
						select Media.Id from Media
						where Media.SharingLevel = 'Friends'
							and Media.Id not in 
							(select Media.Id from Media, ContactList, IsInContactList where
								Media.SharingLevel = 'Friends'
								and Media.User = ContactList.Owner
								and ContactList.Name = 'Friends'
								and ContactList.Id = IsInContactList.List
								and IsInContactList.User = $user_id
							)
							and Media.Id not in 
							(select Media.Id from Media where Media.User = $user_id)
						)";
	$query="select * from Media where Id in (select Media from HasKeyword where Keyword in (select Keyword from HasKeyword where Media=$mediaid) and NOT (Id = $mediaid))"
	.$query_end.
	"LIMIT 5";
	$rresult=mysql_query($query);
	$recommend = "";
	while($recom=mysql_fetch_assoc($rresult)){
	$type = $recom['FileType'];
	$path = $recom['Path'];
	$media_id = $recom['Id'];
	$name = $recom['Title'];
	if($type == 'Video')
		$recommend .="<a href='./media.php?id=$media_id'><img class='media-object' alt='video' width='200' height='180' src=./icons/videoIcon.png /></a>
		<br>
		<p><b>$name</b></p>"
		;

	elseif($type == 'Audio')
		$recommend .="<a href='./media.php?id=$media_id'>
						<img class='media-object' alt='audio' width='200' height='180' src=./icons/audioIcon.png />
					</a>
					<br>
					<p><b>$name</b></p>";

	else
		$recommend .="<a href='./media.php?id=$media_id'>
			<img class='media-object' alt='image' width='200' height='180' src=$path />
		</a>
		<br>
		<p><b>$name</b></p>"
		;

	}
	$recommend .="</div>";
	echo $recommend;

}
else
{
  header('Location: index.php ');
}
?>


  <hr>
    <footer>
      <p>&copy; Database 2017</p>
    </footer>

</div><!--/.container-->

   <script>
    function openNav() {
      document.getElementById("mySidenav").style.width = "200px";
    }

    function closeNav() {
      document.getElementById("mySidenav").style.width = "0";
    }

  </script>

<?php
	include "footer.php";
?>

</body>
</html>
