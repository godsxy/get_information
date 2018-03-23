<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Detail</title>

		<!-- Bootstrap CSS -->
		<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
		<!-- jQuery -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
		<!-- Bootstrap JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.2/html5shiv.min.js"></script>
			<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->
		<style>
			.tableHover:hover {
			    background-color: #BFBFBB;
			}
		</style>
	</head>
	<body>
		<?php include("connect.php") ?>
		<?php
			$detailID = $_GET['id'];
			$sql = "SELECT * FROM `main` WHERE id=".$detailID;
			$result = $conn->query($sql);
			while($row = $result->fetch_assoc()) {
				$sqlCop = "SELECT `name` FROM `cop_name` WHERE `id`=".$row['cop_name'];
				$sqlJfunc = "SELECT `name` FROM `jfunc` WHERE `id`=".$row['jfunc'];
				$sqlLoc = "SELECT `name` FROM `location` WHERE `id`=".$row['loc'];
				$queryCop = $conn->query($sqlCop);
				$queryCop = mysqli_fetch_assoc($queryCop);
				$queryCop = $queryCop['name'];
				$queryFunc = $conn->query($sqlJfunc);
				$queryFunc = mysqli_fetch_assoc($queryFunc);
				$queryFunc = $queryFunc['name'];
				$queryLoc = $conn->query($sqlLoc);
				$queryLoc = mysqli_fetch_assoc($queryLoc);
				$queryLoc = $queryLoc['name'];
		?>
		<div class="container-fluid">
			<div class="row">
				<table class="table" style="margin-bottom:0px">
					<tr>
						<td class="tableHover" onclick="history.go(-1);"><center> <span class="glyphicon glyphicon-repeat"></span> </center></td>
						<td class="tableHover" onclick="window.open('?id=<?php echo $detailID; ?>', '_blank');
"><center> <span class="glyphicon glyphicon-new-window"></span> </center></td>
					</tr>
				</table>
				<hr style="margin-top:0px">
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
							<td><?php echo $queryCop ?></td>
						</tr>
						<tr style="background-color: #D2D2D2">
							<th>Location:</th>
						</tr>
						<tr>
							<td><?php echo $queryLoc ?></td>
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
						<td><?php echo $queryFunc ?></td>
					</tr>
					<tr style="background-color: #EFEFEF;">
						<td style="width: 130px;">Type:</td>
						<td><?php echo $row['type'] ?></td>
					</tr>

				</tbody>
			</table>
			<?php } ?>
			<div class="row">
				<hr style="margin-bottom:0px">
				<table class="table" style="margin-top:0px">
					<tr>
						<td class="tableHover" onclick="history.go(-1);"><center> <span class="glyphicon glyphicon-repeat"></span> </center></td>
						<td class="tableHover" onclick="window.open('?id=<?php echo $detailID; ?>', '_blank');
"><center> <span class="glyphicon glyphicon-new-window"></span> </center></td>
					</tr>
				</table>
			</div>
		</div>

	</body>
</html>
