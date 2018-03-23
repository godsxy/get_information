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
		<!-- เรียกใช้งาน c3.css จาก CDN -->
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/c3/0.4.16/c3.css">

    <!-- เรียกใช้งาน d3.v3.min.js และ c3.js จาก CDN -->
    <script src="http://d3js.org/d3.v3.min.js" charset="utf-8"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/c3/0.4.16/c3.js"></script>
		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.2/html5shiv.min.js"></script>
			<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->
		<style media="screen">
		.tableHover:hover {
				background-color: #BFBFBB;
				cursor:pointer;
		}
		</style>
	</head>
	<body>
		<?php include("connect.php") ?>
    <div id="chart"></div>
		<script type="text/javascript">
			listJF=[['x']];
			listCop=[['Company (1:20)']];
			listPv=[['JobFunction']];
		</script>

		<?php
			if (isset($_GET['days'])) {
			 $day = (int)$_GET['days'];
			} else {
			 $day = 8;
			}
			$sqlGetLoc = "SELECT * FROM location ORDER BY name";
			$resultLoc = $conn->query($sqlGetLoc);
			$sum=1;
			$index=0;
			while($row = $resultLoc->fetch_assoc()) {
					if ($sum%10==0) {
						$index++;
						$sum=1;
						?>
						<script>
							listJF.push(['x']);
							listCop.push(['Company (1:20)']);
							listPv.push(['JobFunction']);
						</script>
						<?php
					}
					else {
						$sum++;
					}
						ini_set('max_execution_time', 300);
						$sqlGetData = "SELECT COUNT(DISTINCT(jfunc)),COUNT(DISTINCT(cop_name)) FROM main WHERE curdate()<date_add(`time`,interval ".$day." day) AND `loc`='".$row['id']."'";
						$resultDaTa = $conn->query($sqlGetData);
						while($row2 = $resultDaTa->fetch_assoc()) {
							$LocName=$row['name'];
							$Jfunc=$row2['COUNT(DISTINCT(jfunc))'];
							$CopSum=$row2['COUNT(DISTINCT(cop_name))']/20;
							if ($Jfunc+$CopSum==0) {
								$sum--;
							}
							else {

				?>
							<script type="text/javascript">
								index=<?php echo $index; ?>;
								listJF[index].push('<?php echo $LocName; ?>');
								listPv[index].push('<?php echo $Jfunc; ?>');
								listCop[index].push('<?php echo $CopSum; ?>');
							</script>
				<?php
							}
						}
			}
		?>
		<table class="table">
				<td class="tableHover" id="back"><center> <span class="glyphicon glyphicon-arrow-left"></span> </center></td>
				<td class="tableHover" id="next"><center> <span class="glyphicon glyphicon-arrow-right"></span> </center></td>
		</table>
    <script type="text/javascript">
			slot=0;
      var chart = c3.generate({
        bindto: '#chart',
        data: {
					x:'x',
          columns: [
						listJF[0],
            listCop[0],
            listPv[0]
          ],
          type: 'bar'
        },
				axis:{
            x:{
                type:"category",
            		height: 50,

        		},
				},
				transition: {
        	duration: 100
    		}
      });
			$( "#back" ).click(function() {
				if (slot>0) {
					slot--;
				}
				chart.load({
        columns: [
					listJF[slot],
					listCop[slot],
					listPv[slot]
        ]
    		});
			});
			$( "#next" ).click(function() {
				if (slot<index) {
					slot++;
				}
				chart.load({
        columns: [
					listJF[slot],
					listCop[slot],
					listPv[slot]
        ]
    		});
			});
    </script>

	</body>
</html>
