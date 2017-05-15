<?php
  session_start();
  include_once "function.php";  
?>

<?php include 'header.php'; ?>

<body>
<?php include "navbar.php"; ?>

    <div class="container mt-5 offset-2">
  <?php if(isset($_SESSION['user_id'])){ ?>

        <div class="col-12 col-md-9">
          <div class="row">
              <div class="col-10 col-lg-15">
                  <h2>My subscriptions</h2>
                  <br>
  <?php
    $userId = $_SESSION['user_id'];
    $query = "select * from Media where User in (select ToUser from IsSubscribed where FromUser =$userId)";
    $result = mysql_query($query);
    if(!$result){die("query failed");}
    make_media_table(5,$result);
  ?>



          </div><!--/row-->
        </div><!--/span-->
      </div><!--/row-->

      <hr>

      <footer>
        <p>&copy; Database 2017</p>
      </footer>
<?php } else { echo "you are not logged in"; } ?> <!-- end if is set user_id -->

    </div><!--/.container-->

<script type="text/javascript" src="js/navbar.js"></script>
<?php include 'footer.php'; ?>
    
    
  </body>
</html>
