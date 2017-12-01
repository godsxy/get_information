<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Title Page</title>

		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.2/html5shiv.min.js"></script>
			<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->
	</head>
	<body>
		<?php
			$servername = "localhost";
			$username = "root";
			$password = "123456789";
			$dbname = "jj";
			// Create connection
			$conn = new mysqli($servername, $username, $password, $dbname);
			// Check connection
			if ($conn->connect_error) {
			    die("Connection failed: " . $conn->connect_error);
			}
		?>


		<?php
			 $pagelen  = 10;
			 if (isset($_GET['page'])) {
			 	$page = $_GET['page'];
			 } else {
			 	$page = 1;
			 }
			 $MapName="AroundBangkok";
	         $sql = "SELECT `id`,`j_name`, `cop_name`,`time`, `loc`, `jfunc`, `indus` FROM `main` WHERE `out_date`=0 AND `loc`='$MapName'";
	         $query = $conn->query($sql);
	         $NumCount = mysqli_num_rows($query);
	         $totalPage= ceil($NumCount / $pagelen);
	         $goto = ($page-1) * $pagelen;
	         $SelectData = "SELECT `id`,`j_name`, `cop_name`,`time`, `loc`, `jfunc`, `indus` FROM `main` WHERE `out_date`=0 AND `loc`='$MapName' LIMIT $goto, $pagelen";
	         $QueryData  = $conn->query($SelectData);
		 ?>


		 <div class="container">
		 <div class="row">
		 <div class="col-lg-12">
		 <table class="table table-bordered table-hover">
		 <thead>
		 <tr>
		 <th>#</th>
		 <th>Name</th>
		 <th>Price</th>
		 </tr>
		 </thead>
		 <tbody>
		 <?php while ($result = mysqli_fetch_assoc($QueryData)) { ?>
		 <tr>
		 <td><?php echo $result['id']; ?></td>
		 <td><?php echo $result['j_name']; ?></td>
		 <td><?php echo $result['loc']; ?></td>
		 </tr>
		 <?php } ?>
		 </tbody>
		 </table>
		 <nav>
		 <ul class="pagination">
		 <li>
		 <?php
		 	if ($page >1) {
		 		$back = $page-1;
		 		echo "<a href=$PHP_SELF?page=".$back."><span aria-hidden='true'>&laquo;</span></a>";
		 	}
		 ?>
		 </li>
		 <li>
		 <?php
		 	if($page < $totalPage) {
		 	    $next = $page +1;
		 	    echo "<a href=$PHP_SELF?page=".$next."><span aria-hidden='true'>&raquo;</span></a>";
		 	}
		 ?>
		 </li>
		 </ul>
		 </nav>
		 </div>
		 </div>
		 </div> <!-- /container -->
		
		<!-- jQuery -->
		<script src="//code.jquery.com/jquery.js"></script>
		<!-- Bootstrap JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
		<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
	</body>
</html>