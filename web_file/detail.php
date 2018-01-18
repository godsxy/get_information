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
		<?php include("connect.php") ?>
		<?php
			$detailID = $_GET['id'];
			$sql = "SELECT * FROM `main` WHERE id=".$detailID;
			$result = $conn->query($sql);
			while($row = $result->fetch_assoc()) {
		?>
		<div class="container-fluid">
			<div class="row">
				<button type="button" style="margin-top: 10px;" class="btn btn-default pull-right" onclick="history.go(-1);">Back</button>
			</div>
			<div class="row">
				<hr>
			</div>
			<div class="table-responsive">
				<table class="table">
					<tbody>
						<tr style="background-color: #D2D2D2">
							<th>Jobname:</th>
						</tr>
						<tr>
							<td><?php echo $row['j_name'] ?></td>
						</tr>
						<tr style="background-color: #D2D2D2">
							<th>Corporation:</th>
						</tr>
						<tr>
							<td><?php echo $row['cop_name'] ?></td>
						</tr>
						<tr style="background-color: #D2D2D2">
							<th>Location:</th>
						</tr>
						<tr>
							<td><?php echo $row['loc'] ?></td>
						</tr>
						<tr style="background-color: #D2D2D2">
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
					<tr style="background-color: #EFEFEF;">
						<td style="width: 130px;border-right: 1px">Career Level:</td>
						<td><?php echo $row['level'] ?></td>
					</tr>
					<tr>
						<td style="width: 130px;">Qualification:</td>
						<td><?php echo $row['edu'] ?></td>
					</tr>
					<tr style="background-color: #EFEFEF;">
						<td style="width: 130px;">Industry:</td>
						<td><?php echo $row['indus'] ?></td>
					</tr>
					<tr>
						<td style="width: 130px;">Jobfunction:</td>
						<td><?php echo $row['jfunc'] ?></td>
					</tr>
					<tr style="background-color: #EFEFEF;">
						<td style="width: 130px;">Type:</td>
						<td><?php echo $row['type'] ?></td>
					</tr>

				</tbody>
			</table>
			<?php } ?><hr>
			<button type="button" style="margin-bottom: 10px;" class="btn btn-default pull-right" onclick="history.go(-1);">Back</button>
		</div>

		<!-- jQuery -->
		<script src="//code.jquery.com/jquery.js"></script>
		<!-- Bootstrap JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
		<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
	</body>
</html>
