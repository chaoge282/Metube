<?php
	session_start();
	include_once "function.php";	
?>

<?php include 'header.php'; ?>

<body>
<?php include "navbar.php"; ?>

<?php
	$user_id = 0; // default: good b/c there is no user 0, so it can't be on a blocked list or friends list
	if (isset( $_SESSION['user_id'])){ $user_id = $_SESSION['user_id']; }
		
	$user_id_to_search = $_REQUEST['id'];
	$query="select * from User where Id='$user_id_to_search'";
	$result = mysql_query($query);
	$username= mysql_fetch_assoc($result)['Username'];
  if($username == $_SESSION['username']){
	header('Location: mychannel.php');
}
else{
	//~ $query = "select * from Media where User='$user_id_to_search'"; 
	$query = "select * from Media where 
						Media.User = $user_id_to_search
						and Media.Id not in 
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
							)
						
						; ";
	$result = mysql_query( $query );
	if (!$result){
	   die ("Could not query the media table in the database: <br />". mysql_error());
	}
?>
	<br><br>
	<h2 class="offset-2">Welcome to <?php echo $username ?>'s channel</h2>
    <div class="container mt-5 offset-2">
	
        <div class="col-12 col-md-9">
          <div class="row">
              <div class="col-10 col-lg-15">
                  <h2><?php echo $username ?>'s Media</h2>
<!--
		  <div class="dropdown">
    			<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">&#9769;Add to...
    			<span class="caret"></span></button>
    			<ul class="dropdown-menu">
      				<li class="dropdown-item"><input id="1" type="radio" name="addradio"><label for="1"> contact list</label></li>
      				<li class="dropdown-item"><input id="2" type="radio" name="addradio"><label for="2"> friend list</label></li>
      				<li class="dropdown-item"><input id="3" type="radio" name="addradio"><label for="3"> block list</label> </li>
    			</ul>
			</div> 
-->
	<!-- add to contact list-->
	<form action="" method='post'>
		<?php
		$user_id = $_SESSION['user_id'];
		 make_contact_list_selector($user_id); // get the contact lists just for this user
		 ?> 
		<button type="submit" class="btn btn-danger btn-check" type='submit' name='add_to_list_submit' style="border-radius:2px font-size:20px;">Add to Contact List

				<?php
				if (isset($_POST['add_to_list_submit'])){
					$list_id = $_POST['contact_list'];
					//subscribe or unsubscribe as appropriate
					//~ add_to_contact_list($user_id, $list_id); // add user to playlist $list
					add_to_contact_list($user_id_to_search, $list_id); // add user to playlist $list

				}
				?>

		</button>
	</form>
	

                  <br>
<?php
	make_media_table(5,$result);
?>
	    </div>
	</div>
    </div>
<?php
}
?>

      <hr>

      <footer>
        <p>&copy; Database 2017</p>
      </footer>

    </div><!--/.container-->

<script type="text/javascript" src="js/navbar.js"></script>
<?php include 'footer.php'; ?>
    
    
  </body>
</html>
