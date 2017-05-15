<?php
session_start();
include_once "function.php";
?>

<?php include "header.php"; ?>

  <body>
	  
	<?php include "navbar.php";?>

	
	<?php if (isset($_SESSION['username'])){?>

     <div class="container mt-5 offset-2">
        <div class="col-12 col-md-9">
          <div class="row">
              <div class="col-10 col-lg-15">
                  <h2>My Groups</h2>
                  <br>
                  <?php
					$query = "SELECT * from DiscGroup where Id in (select DiscGroup from IsInDiscGroup where User = ".$_SESSION['user_id']."); "; 
					$result = mysql_query( $query );
					if (!$result){
					   die ("Could not query the database: <br />". mysql_error());
					}
					
					display_groups($result, false, false, true);
				  ?>
              </div>
          </div> 
          <br>
          <br>
          <div class="row">
            <div class="col-10 col-lg-15">
              <h2>Groups I Manage</h2>
              <br>
              <?php
					$query = "SELECT * from DiscGroup where Owner=".$_SESSION['user_id'].";"; 
					$result = mysql_query( $query );
					if (!$result){
					   die ("Could not query the database: <br />". mysql_error());
					}
					echo "<form action='groups_delete.php' method='post'>";
					display_groups($result, true, false, false);
					echo  '<div class="text-right"><input class="btn" type="submit" value="Delete Selected" /></div>';
					echo "</form>";
					echo "<br><br>";
			  ?>
			</div>
		</div>
		<div class="row">
			<h2>Create New Group</h2><br><br>
			<form class="form-inline" action='groups_create.php' method='post'>
				<input type="text" class="form-control mb-2 mr-sm-2 mb-sm-0" id="name" name="name" placeholder="New Group Name">
				
			<?php
				make_category_selector();
			?>

				<button type="submit" class="btn">Add Group</button>
			</form>
		</div>
		
		<br><br>
		<div class="row">
			<h2>Browse</h2><br><br>
		</div>
		<div class="row">
				<form action='' method='post' class='form-inline'>				
				<?php
					make_category_selector("_browse");
				?>
				<button type="submit" class="btn">Browse</button>
			</form>
		</div>
		
		<br><br>
		<div class='row'>
		<?php
		if(isset($_POST['category_browse'])) {
			$query = "select * from DiscGroup where Category={$_POST['category_browse']}
			;";
			$result = mysql_query($query);
			if (!$result){
				die ("failed <br> ".mysql_error());
			}
			echo "<h2>Browse Results</h2>";
			display_groups($result, false, true, false);
			//~ echo "<p>success</p>";

		}?>
		</div>
		<br>
		<br>
		<br>
		
        </div><!--/span-->
      </div><!--/row-->


<script type="text/javascript" src="js/navbar.js"></script>
<?php include 'footer.php'; ?>
<?php } else { echo "You are not logged in."; } ?> <!-- end if (isset($_SESSION('username') -->
    
  </body>
</html>
