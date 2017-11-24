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
                $MapName=$_GET['MapName'];
                $sql = "SELECT `id`,`j_name`, `cop_name`, `loc`, `jfunc`, `indus` FROM `main` WHERE `out_date`=0 AND `loc`='$MapName' ORDER BY `jfunc`";
                $result = $conn->query($sql);
                		if ($result->num_rows > 0) {
		?>
							<div class="table-responsive">
								<table class="table table-hover" id="mainTable">
									<thead>
					                    <tr>
					                        <th>Job Name</th>
					                        <th>Company Name</th>
					                        <th>Job Function</th>
					                        <th>Industry</th>
					                        <th>Location</th>
					                    </tr>
					                </thead>
					                <tbody>
					                	<?php
					                			while($row = $result->fetch_assoc()) {
					                	?>
								                    <tr onclick="document.location = 'detail.php?id= <?php echo $row['id'] ?>';">
									                    <td style='max-width: 250px;table-layout: fixed;word-wrap: break-word;cursor:pointer'><?php echo $row['j_name'] ?> </td>
									                    <td style='max-width: 250px;table-layout: fixed;word-wrap: break-word;cursor:pointer'><?php echo $row['cop_name']?></td>
									                    <td style='max-width: 100px;table-layout: fixed;word-wrap: break-word;cursor:pointer'><?php echo $row['jfunc']?></td>
									                    <td style='max-width: 150px;table-layout: fixed;word-wrap: break-word;cursor:pointer'><?php echo $row['indus']?></td>
									                    <td style='max-width: 90px;table-layout: fixed;word-wrap: break-word;cursor:pointer'><?php echo $row['loc']?></td>
								                    </tr>
					<?php
								                }
                		}
                		else{
                			echo "<h1><center>No Data</center></h1>";
                		}
	                ?>
                </tbody>
			</table>
		</div>
		<!-- jQuery -->
		<script src="//code.jquery.com/jquery.js"></script>
		<!-- Bootstrap JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
		<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
	</body>
</html>