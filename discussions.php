<?php
session_start();
include_once "function.php";
?>

<?php include "header.php"; ?>

  <body>
	  
	  <?php include "navbar.php"; ?>
	  <?php if (isset($_SESSION['username'])){?>
	<br>
	<div class="container">
		<div>
		<!-- get my discussions, order them by group, display them as buttons that open a new tab-->
		<div class="row"><h2>Discussions for My Groups</h2></div>
		<?php		
			$user_id = $_SESSION['user_id'];
			$query = "SELECT G.Name as group_name, D.Title as disc_name, D.Id as disc_id
			from Discussion as D, DiscGroup as G, IsInDiscGroup as I
			where D.DiscGroup = G.Id
			and I.DiscGroup = G.Id
			and I.User = $user_id
			 order by D.DiscGroup;"; 
			$result = mysql_query( $query );
			if (!$result){
			   die ("Could not query the database: <br />". mysql_error());
			}
			display_discussions($result, false);
		?>
		</div>
		
		<br>
		<br>
		
		<div id='discussions_i_manage'>
		<div class="row"><h2>Discussions I Manage</h2></div>
		<?php
			$query = "SELECT G.Name as group_name, D.Title as disc_name, D.Id as disc_id
			from Discussion as D, DiscGroup as G
			where D.DiscGroup = G.Id
			and D.Owner = ".$_SESSION['user_id']."
			order by D.DiscGroup;"; 
			$result = mysql_query( $query );
			if (!$result){
			   die ("Could not query the database: <br />". mysql_error());
			}
			display_discussions($result, true);
		?>
			<form>
				
			</form>
		
		</div>
		
		
		<div class="row">
			<h2>Add New Discussion</h2><br><br>
			<form class="form-inline" action='discussions_create.php' method='post'>
				<input type="text" class="form-control mb-2 mr-sm-2 mb-sm-0" name="disc_name" placeholder="Discussion Name">
				
			<?php
				$query = "SELECT Name as group_name, Id from DiscGroup where 1;";
				$result = mysql_query( $query );
				if (!$result){
				   die ("Could not query the database: <br />". mysql_error());
				}
				make_group_selector($result);
			?>

				<button type="submit" class="btn">Add</button>
			</form>


		</div>
		
	</div> <!-- <div class="container"> -->
	<br>
	<br>
  </body>

<script type="text/javascript" src="js/navbar.js"></script>
<?php include 'footer.php'; ?>
<?php } else { echo "You are not logged in."; } ?> <!-- end if (isset($_SESSION('username') -->
    
</html>
