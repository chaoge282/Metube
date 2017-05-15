<?php
session_start();
include_once "function.php";
?>

<?php include "header.php"; ?>

  <body>
	  
	  <?php include "navbar.php"; ?>

	  <?php if (isset($_SESSION['username'])){?>
	  <?php $user_id = $_SESSION['user_id']; ?>
	<br>
	<div class="container">
		<div name=''>
		<!-- display existing contact lists-->
		<div class="row"><h2>Contact Lists</h2></div>
		<?php
			$query = "SELECT  C.Name as list_name,
				C.Id as list_id,
				C.Owner as list_owner_id, 
				User.Id as member_id, 
				User.username as member_username,
				I.Id as connection_id
			from ((ContactList as C LEFT JOIN IsInContactList as I on C.Id = I.List) Left join User on I.User = User.Id)
			where C.Owner = $user_id
			order by Name
			;"; 
			$result = mysql_query( $query );
			if (!$result){
			   die ("Could not query the database: <br />". mysql_error());
			}
			display_contacts($result, true);
		?>
		</div>
		
		<br>
		<br>
		
		
		
		<div class="row">
			<!-- create contact lists-->
			<h2>Create New Contact List: &nbsp; &nbsp;</h2><br><br>
			<form class="form-inline" action='contact_list_create.php' method='post'>
				<input type="text" class="form-control mb-2 mr-sm-2 mb-sm-0" name="name" placeholder="Enter new list name here.">
				<button type="submit" class="btn btn-primary">Create</button>
			</form>
		</div>
		
		<div class="row">
			<!-- create contact lists-->
			<h2>View Message from Non-Contacts: &nbsp; &nbsp;</h2><br><br>
			<button class='btn btn-sm' 
					onClick=location.href='contact_thread_not_in_contact_list.php?'>View Messages from Non-Contacts
			</button>
		</div>
		
	</div> <!-- <div class="container"> -->
	<br>
	<br>
  </body>

<script type="text/javascript" src="js/navbar.js"></script>
<?php include 'footer.php'; ?>
<?php } else { echo "You are not logged in."; } ?> <!-- end if (isset($_SESSION('username') -->
    
</html>
