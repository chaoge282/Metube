    // general info
	if(isset($_REQUEST['id'])){

	$mediaid = $_REQUEST['id'];
	$username=$_SESSION['username'];

	$query="select * from Media where Id=$mediaid";
	$rresult=mysql_query($query);
	$avgRate=mysql_fetch_assoc($rresult)['AvgRating'];
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
	$text = $_REQUEST['comment'];

	$query="select * from User where Username='$username'";
	$qresult=mysql_query($query);
	$userId=mysql_fetch_assoc($qresult)['Id'];

	$query = "insert into Comment values (NULL, '$userId', '$mediaid', '$text',NOW())";
	$result = mysql_query($query);


}
?>
	<!-- download -->
    <div class="row-container">
	<a href="channel.php?id=<?php echo $userId ?>" style="font-size:2em;"><?php echo $username ?></a>
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
	//~ }
?>
  </div>
