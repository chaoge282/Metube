<?php
session_start();
include_once "function.php";
?>
<?php include "header.php"; ?>

<?php if (!isset($_SESSION['username'])){
	echo "You are not logged in.";
} else {?>
	
	<?php
	$disc_id = $_REQUEST['disc_id'];
	$query = 	"select Post.Text, Post.Time, Discussion.Title,  User.Username
				from Post, User, Discussion
				where Post.Discussion=$disc_id 
					&& Post.User = User.Id 
					&& Post.Discussion = Discussion.Id 
				order by Time";
	$result = mysql_query( $query );
	if (!$result){
	   die ("Could not query the database: <br />". mysql_error());
	}
	
	?>
		
	<body>
		<?php include "navbar.php"; ?>
		<br>
		<div class="container">
			<?php 	display_single_discussion($result, $disc_id); ?>
		</div>

	</body>

	<script type="text/javascript" src="js/navbar.js"></script>
	<?php include 'footer.php'; ?>
	</html>

<?php } ?> <!-- end else -->
