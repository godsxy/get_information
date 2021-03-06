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
			if($_GET['jf'] != ""){
	                		$JFname = $_GET['jf'];
			                if($_GET['pv'] != ""){
			                	$pv=$_GET['pv'];
			                	$sql = "SELECT `id`,`j_name`, `cop_name`,`time`, `loc`, `jfunc`, `indus` FROM `main` WHERE curdate()<date_add(`time`,interval 8 day) AND `loc`='$pv' AND `jfunc`='$JFname' ORDER BY `time` DESC,`jfunc`,`loc`";
			                }
			                else{
			                	$sql = "SELECT `id`,`j_name`, `cop_name`,`time`, `loc`, `jfunc`, `indus` FROM `main` WHERE curdate()<date_add(`time`,interval 8 day) AND `jfunc`='$JFname' ORDER BY `time` DESC,`jfunc`,`loc`";
			                }
			}
			else{
				if($_GET['pv'] != ""){
						$pv=$_GET['pv'];
						$sql = "SELECT `id`,`j_name`, `cop_name`,`time`, `loc`, `jfunc`, `indus` FROM `main` WHERE curdate()<date_add(`time`,interval 8 day) AND `loc`='$pv' ORDER BY `time` DESC,`jfunc`,`loc`";
					}
			}
			$query = $conn->query($sql);
			$NumCount = mysqli_num_rows($query);
			$totalPage= ceil($NumCount / $pagelen);
			$goto = ($page-1) * $pagelen;
			$SelectData = $sql." LIMIT $goto, $pagelen";
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
									                    <td style='max-width: 250px;table-layout: fixed;word-wrap: break-word;cursor:pointer'><?php echo $queryCop?></td>
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
			<!---------------------- ส่วนของเมนูด้านล่างเว็บ ------------------------>
			<ul class=" pager">
				<div class="col-xs-5 col-sm-5 col-md-5 col-lg-5">
				<li style="float: right;">
				<?php
					if ($page >1) {
						$back = $page-1;?>
						<a style='margin-left: 5px' href='<?php echo $PHP_SELF?>?page=<?php echo $back ?>&jf=<?php echo $JFname ?>&pv=<?php echo $pv?>'>Previous</a>
					<?php }
				?>
				</li></div>
				<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
				<li><div class="input-group">
					<input id="getPage" type="number" min="1" max="<?php echo $totalPage ?>" class="form-control" placeholder="<?php echo $page ?>/<?php echo $totalPage ?>">
						<span class="input-group-btn">
							<button class="btn btn-default" type="button" id="summitPage">Go!</button>
						</span>
					
				</div></li>
				</div>
				<div class="col-xs-5 col-sm-5 col-md-5 col-lg-5">
				<li style="float: left;">
				<?php
					if($page < $totalPage) {
						$next = $page +1;?>
							<a style='margin-left: 5px' href='<?php echo $PHP_SELF?>?page=<?php echo $next ?>&jf=<?php echo $JFname ?>&pv=<?php echo $pv?>'>Next</a>
					<?php }
				?>
				</li></div>
			</ul>
		</div>
		<script type="text/javascript">
			$("#summitPage").click(function(event){
				getPage = document.getElementById("getPage").value;
				if (getPage >= 1) {
					if(getPage <= '<?php echo $totalPage ?>'){
						window.location = '<?php echo $PHP_SELF ?>?page='+getPage+'&jf=<?php echo $JFname ?>&pv=<?php echo $pv?>';
					}
				}
			});
		</script>
	</body>
</html>
