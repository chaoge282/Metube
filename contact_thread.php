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
		$other_id = $_REQUEST['contact_id'];
		$query = "select Message.Sender as sender_id, 
					Message.Reciever as receiver_id,
					Message.SentTime as time,
					Message.Text as text,
					User.Username as sender_name
					from Message, User
					where Message.Sender = User.Id 
					and (
						(Message.Sender = '$user_id' AND Message.Reciever='$other_id') 
						or (Message.Sender = '$other_id' AND Message.Reciever='$user_id')
						)
					order by SentTime;
		";
		$result = mysql_query( $query );
		if (!$result){
		   die ("Could not query the database: <br />". mysql_error());
		}
		display_messages($result);
		
	// reply
	echo 
	"<div class='list-group-item  align-items-start'>
		<div class='form-group'>
			<form action='contact_thread_create_message.php' method='POST'>
				<input type='hidden' name='from_id' value='$user_id'>
				<input type='hidden' name='to_id' value='$other_id'>
				<textarea rows='5' cols='100' class='form-control' name='text' placeholder='Reply Here'></textarea>
				<button type='submit' class=' mt-2 btn btn-primary'>Reply</button>
			</form>
		</div>
	</div>
	";
			
		?>
	</div> <!-- container -->
  </body>


<script type="text/javascript" src="js/navbar.js"></script>
<?php include 'footer.php'; ?>
<?php } else { echo "You are not logged in."; } ?> <!-- end if (isset($_SESSION('username') -->
    
</html>
