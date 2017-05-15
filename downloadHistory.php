<?php
	session_start();
	include_once "function.php";	
?>

<?php include 'header.php'; ?>

<body>
<?php include "navbar.php"; ?>

<br/><br/>
<?php
	$username=$_SESSION['username'];
	$wquery="select * from User where Username='$username'";
	$wresult = mysql_query($wquery);
	$userId= mysql_fetch_assoc($wresult)['Id'];

	$qquery = "select * from Media where Id in (select distinct Media from Download where User='$userId')";
	$result = mysql_query($qquery);
	if (!$result){
	   die ("Could not query the media table in the database: <br />". mysql_error());
	}
?>
    <div class="container mt-5 offset-2">
	
        <div class="col-12 col-md-9">
          <div class="row">
              <div class="col-10 col-lg-15">
                  <h2>Download History</h2>
                  <br>
<?php
	make_media_table(5,$result);
?>
		</div>
		</div>
	</div>


      <hr>

      <footer>
        <p>&copy; Database 2017</p>
      </footer>

    </div><!--/.container-->

<script type="text/javascript" src="js/navbar.js"></script>
<?php include 'footer.php'; ?>
    
    
  </body>
</html>
