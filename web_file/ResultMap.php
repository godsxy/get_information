<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Title Page</title>

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
	</head>
	<body>
		<?php include("connect.php") ?>
		<?php
				$pagelen  = 10;
				if (isset($_GET['page'])) {
					$page = (int)$_GET['page'];
				} else {
					$page = 1;
				}
                $MapName=$_GET['MapName'];
								$SelectMapId = "SELECT `id` FROM `location` WHERE `name`='$MapName'";
								$queryMapId = $conn->query($SelectMapId);
								while($row = mysqli_fetch_assoc($queryMapId)){
									$mapId = $row['id'];
								}
                $sql = "SELECT `id`,`j_name`, `cop_name`,`time`, `loc`, `jfunc`, `indus` FROM `main` WHERE curdate()<date_add(`time`,interval 8 day) AND `loc`='$mapId'";
                $query = $conn->query($sql);
                $NumCount = mysqli_num_rows($query);
                $totalPage= ceil($NumCount / $pagelen);
                $goto = ($page-1) * $pagelen;
                $SelectData ="SELECT `id`,`j_name`, `cop_name`,`time`, `loc`, `jfunc`, `indus` FROM `main` WHERE curdate()<date_add(`time`,interval 8 day) AND `loc`='$mapId' ORDER BY `time` DESC,`jfunc` LIMIT $goto, $pagelen";
                $QueryData  = $conn->query($SelectData);
                		if ($QueryData->num_rows > 0) {
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
					                        <th>Time</th>
					                    </tr>
					                </thead>
					                <tbody>
					                	<?php
					                			while($row = mysqli_fetch_assoc($QueryData)) {
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
								                    <tr onclick="document.location = 'detail.php?id= <?php echo $row['id'] ?>';">
									                    <td style='max-width: 250px;table-layout: fixed;word-wrap: break-word;cursor:pointer'><?php echo $row['j_name'] ?> </td>
									                    <td style='max-width: 250px;table-layout: fixed;word-wrap: break-word;cursor:pointer'><?php echo $queryCop ?></td>
									                    <td style='max-width: 100px;table-layout: fixed;word-wrap: break-word;cursor:pointer'><?php echo $queryFunc?></td>
									                    <td style='max-width: 150px;table-layout: fixed;word-wrap: break-word;cursor:pointer'><?php echo $row['indus']?></td>
									                    <td style='max-width: 90px;table-layout: fixed;word-wrap: break-word;cursor:pointer'><?php echo $queryLoc?></td>
									                    <td style='max-width: 90px;table-layout: fixed;word-wrap: break-word;cursor:pointer'><?php echo $row['time']?></td>
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
			<ul class="pagination">
		 <li>
		 <?php
		 	if ($page >1) {
		 		$back = $page-1;?>
				<a style='margin-left: 5px' href='<?php echo $PHP_SELF ?>?page=<?php echo 1 ?>&MapName=<?php echo $MapName ?>'><span aria-hidden='true' class="glyphicon glyphicon-fast-backward"></span></a>
				<a style='margin-left: 5px' href='<?php echo $PHP_SELF ?>?page=<?php echo $back ?>&MapName=<?php echo $MapName ?>'><span aria-hidden='true' class="glyphicon glyphicon-triangle-left"></span></a>
		 	<?php }
		 ?>
		 </li>
		 <li><?php echo "<span style='margin-left: 5px' aria-hidden='true'>".$page."</span>"; ?></li>
		 <li>
		 <?php
		 	if($page < $totalPage) {
		 	    $next = $page +1; ?>
					<a style='margin-left: 5px' href='<?php echo $PHP_SELF ?>?page=<?php echo $next ?>&MapName=<?php echo $MapName ?>'><span aria-hidden='true' class="glyphicon glyphicon-triangle-right"></span></a>
					<a style='margin-left: 5px' href='<?php echo $PHP_SELF ?>?page=<?php echo $totalPage ?>&MapName=<?php echo $MapName ?>'><span aria-hidden='true' class="glyphicon glyphicon-fast-forward"></span></a>
		 <?php	}
		 ?>
		 </li>
		 </ul>
		</div>
	</body>
</html>
