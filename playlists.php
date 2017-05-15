<?php
session_start();
include_once "function.php";
?>

<?php include "header.php"; ?>


<?php
// create playlists
if (isset($_POST['submit_create'])){
	$name = mysql_real_escape_string($_POST['name']);
	$user_id = $_SESSION['user_id'];

	$q1 = "INSERT INTO `db_76dp`.`Playlist` (`Name`, `Owner`, `Id`) VALUES ('$name', '$user_id', NULL);";

	$r1 = mysql_query( $q1 );
	if(! $r1 ) {
		die('Could not create playlist: ' .$q1. mysql_error());
	}
}

// delete playlists
if (isset($_POST['submit_delete'])){
	$playlist_id_to_delete = mysql_real_escape_string($_POST['playlist_to_delete']);
	$user_id = $_SESSION['user_id'];

	$q3 = "DELETE FROM `db_76dp`.`Playlist` WHERE `Playlist`.`Id` = $playlist_id_to_delete";

	$r3 = mysql_query( $q3 );
	if(! $r3 ) {
		die('Could not delete playlist: ' .$q3. mysql_error());
	}
}
?>


  <body>
	<?php include "navbar.php"; ?>
	<?php if (isset($_SESSION['username'])){?>
	<br>
	<div class="container">
		<div class="col-6">
		<?php 
		$user_id = $_SESSION['user_id'];
		$q2 = "
				select * from Playlist 
				where Owner=$user_id;
				";
		$r2 = mysql_query( $q2 );
		if (!$r2){
		   die ("Could not query the database: <br />". mysql_error());
		}
		display_playlists($r2);
		?>
		
		<!-- create playlist-->
		<h2>Create Playlist</h2><br><br>
		<form class="form-inline" action="" method='post'>
				<input type="text" class="form-control mb-2 mr-sm-2 mb-sm-0" id="name" name="name" placeholder="New Playlist Name">
				<button type="submit" class="btn" name='submit_create'>Create</button>
		</form>
		
		</div> <!-- col -->
	</div> <!-- container-->
  </body>

<script type="text/javascript" src="js/navbar.js"></script>
<?php include 'footer.php'; ?>
<?php } else { echo "You are not logged in."; } ?> <!-- end if (isset($_SESSION('username') -->
    
</html>
