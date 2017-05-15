<?php
	session_start();
	include_once "function.php";	
?>

<?php include 'header.php'; ?>

<body>
<?php include "navbar.php"; ?>

    <div class="container mt-5 offset-2">
	<?php
		$user_id = 0; // default: good b/c there is no user 0, so it can't be on a blocked list or friends list
		if (isset( $_SESSION['user_id'])){ $user_id = $_SESSION['user_id']; }
	?>


        <div class="col-12 col-md-9">
          <div class="row">
              <div class="col-10 col-lg-15">
                  <h2>Recently Uploaded</h2>
                  <br>
                  <?php
					//~ $query = "SELECT * from Media order by UploadTime Limit 15; "; 
					$query = "select * from Media where 
						Media.Id not in 
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
						
						order by UploadTime desc Limit 15; "; 
					$result = mysql_query( $query );
					if (!$result){
					   die ("Could not query the media table in the database: <br />". mysql_error());
					}
					make_media_table(5, $result);
				  ?>
              </div>
          </div>
          <br>
          <br>
          <div class="row">
            <div class="col-10 col-lg-15">
              <h2>Most Viewed</h2>
              <br>
				<?php
					$query ="select * from Media where 
						Media.Id not in 
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
					 order by NumViews desc Limit 15; "; 
					$result = mysql_query( $query );
					if (!$result){
					   die ("Could not query the media table in the database: <br />". mysql_error());
					}
					make_media_table(5, $result);
				?>

          </div><!--/row-->
        </div><!--/span-->
      </div><!--/row-->

      <hr>

      <footer>
        <p>&copy; Database 2017</p>
      </footer>

    </div><!--/.container-->

<script type="text/javascript" src="js/navbar.js"></script>
<?php include 'footer.php'; ?>
    
    
  </body>
</html>



