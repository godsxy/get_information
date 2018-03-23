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
    .alert {
        padding: 20px;
        background-color: #f44336; /* Red */
        color: white;
        margin-bottom: 15px;
        display: none;
    }
		</style>
	</head>
	<body>
		<?php include("connect.php") ?>
    <div id="chart"></div>
		<script type="text/javascript">
			listPv=[];
			listCop=['Company (1:20)'];
			listJF=['JobFunction'];
			reslutCop=['Company (1:20)'];
			reslutJF=['JobFunction'];
			reslutPv=[];
		</script>
    <table class="table">
      <form>
         <div class="form-group">
            <td class="tableHover" id="back">
              <label for="locations">Select list (select one):</label>
              <select class="form-control" id="locations">
                <?php
            			if (isset($_GET['days'])) {
            			 $day = (int)$_GET['days'];
            			} else {
            			 $day = 8;
            			}
            			$sqlGetLoc = "SELECT * FROM location ORDER BY name";
            			$resultLoc = $conn->query($sqlGetLoc);
                  $i=1;
            			while($row = $resultLoc->fetch_assoc()) {
                        echo "<option value='".$i."'>".$row["name"]."</option>";
                        $i++;
            						ini_set('max_execution_time', 300);
            						$sqlGetData = "SELECT COUNT(DISTINCT(jfunc)),COUNT(DISTINCT(cop_name)) FROM main WHERE curdate()<date_add(`time`,interval ".$day." day) AND `loc`='".$row['id']."'";
            						$resultDaTa = $conn->query($sqlGetData);
            						while($row2 = $resultDaTa->fetch_assoc()) {
            							$LocName=$row['name'];
            							$Jfunc=$row2['COUNT(DISTINCT(jfunc))'];
            							$CopSum=$row2['COUNT(DISTINCT(cop_name))']/20;
            				?>
            							<script type="text/javascript">
            								listPv.push('<?php echo $LocName; ?>');
            								listJF.push('<?php echo $Jfunc; ?>');
            								listCop.push('<?php echo $CopSum; ?>');
            							</script>
            				<?php
            						}
            			}
            		?>
              </select>
            </td>
    				<td class="tableHover" id="add"><center> <span class="glyphicon glyphicon-plus"></span> </center></td>
         </div>
      </form>
		</table>
    <div class="alert" id="alert" onclick="this.style.display='none';">
      already have it.
    </div>
    <script type="text/javascript">
      doneList=[];
      var chart = c3.generate({
        bindto: '#chart',
        data: {
          columns: [],
          type: 'bar'
        },
        axis:{
            x:{
                type:"category",
								categories:[],
                height: 50,
            },
        },
        transition: {
          duration: 100
        }
      });
      $("#add").click(function(event) {
        loc = document.getElementById("locations").value;
        if (loc in doneList) {
          showAR = document.getElementById("alert");
          showAR.style.display = "block";
        }
        else {
          reslutCop.push(listCop[loc])
          reslutJF.push(listJF[loc])
					reslutPv.push(listPv[loc-1])
          doneList.push(loc);
          chart.load({
          columns: [
  					reslutCop,
  					reslutJF,
          ],
          axis:{
            x:{
              type: 'category',
              categories:reslutPv
            }
          }
      		});
        }

      });
    </script>
	</body>
</html>
