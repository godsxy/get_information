<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Title Page</title>

		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
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
	</head>
	<body>
		<?php include("connect.php") ?>
    <div id="chart"></div>
		<script type="text/javascript">
			listJF=[];
			listCop=['Company (1:20)'];
			listPv=['Province'];
		</script>

		<?php
			$sqlGetJF = "SELECT DISTINCT(jfunc) FROM main";
			$resultJF = $conn->query($sqlGetJF);
			while($row = $resultJF->fetch_assoc()) {
		?>
				<script type="text/javascript">
					listJF.push('<?php echo $row['jfunc']; ?>');
				</script>
		<?php
				ini_set('max_execution_time', 300);
				$sqlGetPv = "SELECT COUNT(DISTINCT(loc)) FROM main WHERE jfunc='".$row['jfunc']."'";
				$sqlGetCop = "SELECT COUNT(DISTINCT(cop_name)) FROM main WHERE jfunc='".$row['jfunc']."'";
				$resultPv = $conn->query($sqlGetPv);
				$resultCop = $conn->query($sqlGetCop);
				while($row2 = $resultPv->fetch_assoc()) {
		?>
					<script type="text/javascript">
						listPv.push('<?php echo $row2['COUNT(DISTINCT(loc))']; ?>');
					</script>
		<?php
				}
				while($row3 = $resultCop->fetch_assoc()) {
		?>
					<script type="text/javascript">
						listCop.push('<?php echo $row3['COUNT(DISTINCT(cop_name))']/20; ?>');
					</script>
		<?php
				}
			}
		?>

    <script type="text/javascript">
      var chart = c3.generate({
        bindto: '#chart',
        data: {
          columns: [
            listCop,
            listPv
          ],
          type: 'bar'
        },
				axis:{
            x:{
                type:"category",
                categories: listJF,
            label:{
                text:""
                }
            },
        },
      });
    </script>


		<!-- jQuery -->
		<script src="//code.jquery.com/jquery.js"></script>
		<!-- Bootstrap JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
		<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
	</body>
</html>
