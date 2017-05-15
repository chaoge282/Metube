<!-- usage: playlist_single.php?playlist_id=7 -->

<?php
session_start();
include_once "function.php";
include_once "playlist_functions.php";
?>
<?php include "header.php"; ?>
<?php include "navbar.php";?>
<?php if (isset($_SESSION['username'])){?>
	<body>
		<div class='container'>
			<div class='row mt-4'>
				<div id="keywords"></div>
			</div> <!-- row -->
		</div> <!-- container -->
			
			

	<?php include 'footer.php'; ?>
	<script src="bower_components/jqcloud2/dist/jqcloud.min.js"></script>
	<link rel="stylesheet" href="bower_components/jqcloud2/dist/jqcloud.min.css">
	
	<script>
	<?php
	// sql query to get all words with their weights
	// turn into string verison of js object
	
	$q = "select * from Keyword  where Count <> 0 group by Id order by Count limit 50;";
	$r = mysql_query ($q);
	if (!$r) {die("failure".mysql_error().$q);}
	$i = mysql_fetch_assoc($r);
	$words_str = "var words = [
	{'text': '{$i['Text']}', 'weight': {$i['Count']}}";
	while (	$i = mysql_fetch_assoc($r) ){
		$words_str .= ", {'text': '{$i['Text']}', 'weight': {$i['Count']}}";
	}
	$words_str .= "];";

	echo $words_str;
	echo "$('#keywords').jQCloud(words, {width: 700, height:400})";

	?>

</script>
	<script type="text/javascript" src="js/navbar.js"></script>
	<?php } else { echo "You are not logged in."; } ?> <!-- end if (isset($_SESSION('username') -->
	</body>
	
</html>
