<?php
	session_start();
	include_once "function.php";
?>	
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Media</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Bootstrap core CSS -->
    <link href="./css/bootstrap.min.css" rel="stylesheet">
    <link href="./css/sidenav.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="./css/offcanvas.css" rel="stylesheet">
</head>

<body>

<?php
  include "navbar.php";
?>

  <div class="container mt-5 offset-2">
    <div class="col-12 col-md-9">
      <div class="row">
        <div class="col-10 col-lg-15">

<?php
  if(isset($_REQUEST['category'])){
    $name = $_REQUEST['category'];
    $user_id = 0; // default
    if (isset( $_SESSION['user_id'])){     $user_id = $_SESSION['user_id']; }

    $query="select * from Category where Description='$name';";
    $qresult = mysql_query($query);
    $result = mysql_fetch_assoc($qresult);
    echo "<h2>$name</h2><br>";

    $categoryId = $result['Id'];
    //~ $query_a= "select * from Media where Category='$categoryId';";
    $query_a= "
    select * from Media where 
    Category='$categoryId'
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
		)";
	
    $qresult_a = mysql_query($query_a);
    if (!$qresult_a) {die("query failed");}
    make_media_table(5,$qresult_a);
  }
?>

          </div><!--/row-->
        </div><!--/span-->
      </div><!--/row-->

      <hr>

      <footer>
        <p>&copy; Database 2017</p>
      </footer>

</div><!--/.container-->

  <script>
    function openNav() {
      document.getElementById("mySidenav").style.width = "200px";
    }

    function closeNav() {
      document.getElementById("mySidenav").style.width = "0";
    }
  </script>

  <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
    <script src="./js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="./js/ie10-viewport-bug-workaround.js"></script>
    <script src="./js/offcanvas.js"></script>


</body>
</html>
