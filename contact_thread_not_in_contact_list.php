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
		<?php
		$user_id = $_SESSION['user_id'];  

		// subquery gets the ids of all people in my contact lists
		// get all messages where the reciever was me and the sender was not in that list
		$query = "select Message.Sender as sender_id, 
				Message.Reciever as receiver_id,
				Message.SentTime as time,
				Message.Text as text,
				Message.Id as message_id,
				User.Username as sender_name
			from Message, User
			where Message.Reciever = $user_id 
			and Message.Sender = User.Id
			AND Message.Sender not in
				(SELECT I.User
				from (ContactList as C JOIN IsInContactList as I on C.Id = I.List)
				where C.Owner = $user_id)
			order by SentTime
				;";
		
		$result = mysql_query( $query );
		if (!$result){
		   die ("Could not query the database: <br />". mysql_error());
		}
		display_messages($result);
		
	// can not reply
			
		?>
	</div> <!-- container -->
  </body>


<script type="text/javascript" src="js/navbar.js"></script>
<?php include 'footer.php'; ?>
<?php } else { echo "You are not logged in."; } ?> <!-- end if (isset($_SESSION('username') -->
    
</html>
