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
			$dbname = "job_data";
			// Create connection
			$conn = new mysqli($servername, $username, $password, $dbname);
			// Check connection
			if ($conn->connect_error) {
			    die("Connection failed: " . $conn->connect_error);
			}
		?>
		<?php
			$detailID = $_GET['id'];
			$sql = "SELECT * FROM `main` WHERE id=".$detailID;
			$result = $conn->query($sql);
			while($row = $result->fetch_assoc()) {
		?>
		<div class="container-fluid">
			<div class="table-responsive">
				<table class="table">
					<tbody>
						<tr>
							<th>Jobname:</th>
						</tr>
						<tr>
							<td><?php echo $row['j_name'] ?></td>
						</tr>
						<tr>
							<th>Corporation:</th>
						</tr>
						<tr>
							<td><?php echo $row['cop_name'] ?></td>
						</tr>
						<tr>
							<th>Location:</th>
						</tr>
						<tr>
							<td><?php echo $row['loc'] ?></td>
						</tr>
						<tr>
						        <th>Detail:</th>
						</tr>
						<tr>
							<td><?php echo $row['detail'] ?></td>
						</tr>
					</tbody>
				</table>
			</div>
			<table class="table table-bordered">
				<tbody>
					<tr>
						<td style="width: 130px;border-right: 1px">Career Level:</td>
						<td><?php echo $row['level'] ?></td>
					</tr>
					<tr>
						<td style="width: 130px;">Qualification:</td>
						<td><?php echo $row['edu'] ?></td>
					</tr>
					<tr>
						<td style="width: 130px;">Industry:</td>
						<td><?php echo $row['indus'] ?></td>
					</tr>
					<tr>
						<td style="width: 130px;">Jobfunction:</td>
						<td><?php echo $row['jfunc'] ?></td>
					</tr>
					<tr>
						<td style="width: 130px;">Type:</td>
						<td><?php echo $row['type'] ?></td>
					</tr>
					
				</tbody>
			</table>
			<?php } ?>
			<button onclick="history.go(-1);">Back </button>
		</div>
		
		<!-- jQuery -->
		<script src="//code.jquery.com/jquery.js"></script>
		<!-- Bootstrap JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
		<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
	</body>
</html>