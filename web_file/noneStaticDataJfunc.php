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
        margin-bottom: 15px;
        display: none;
    }
		</style>
	</head>
	<body>
		<?php include("connect.php") ?>
    <div id="chart"></div>
		<script type="text/javascript">
			listPv=['x'];
			listCop=['Company (1:20)'];
			listJF=['Location'];
			reslutCop=['Company (1:20)'];
			reslutPv=['Location'];
			reslutJF=['x'];
		</script>
    <table class="table">
			<td class="tableHover" id="reset"><center> <span class="glyphicon glyphicon-repeat"></span> </center></td>
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
            			$sqlGetLoc = "SELECT * FROM jfunc ORDER BY name";
            			$resultLoc = $conn->query($sqlGetLoc);
                  $i=1;
            			while($row = $resultLoc->fetch_assoc()) {

            						ini_set('max_execution_time', 300);
            						$sqlGetData = "SELECT COUNT(DISTINCT(loc)),COUNT(DISTINCT(cop_name)) FROM main WHERE curdate()<date_add(`time`,interval ".$day." day) AND `jfunc`='".$row['id']."'";
            						$resultDaTa = $conn->query($sqlGetData);
            						while($row2 = $resultDaTa->fetch_assoc()) {
            							$jfuncName=$row['name'];
            							$LocSum=$row2['COUNT(DISTINCT(loc))'];
            							$CopSum=$row2['COUNT(DISTINCT(cop_name))']/20;
													if ($LocSum+$CopSum==0) {
													}
													else {
														echo "<option value='".$i."'>".$row["name"]."</option>";
		                        $i++;
            				?>
            							<script type="text/javascript">
            								listPv.push('<?php echo $jfuncName; ?>');
            								listJF.push('<?php echo $LocSum; ?>');
            								listCop.push('<?php echo $CopSum; ?>');
            							</script>
            				<?php
									}
            						}
            			}
            		?>
              </select>
            </td>
    		<td class="tableHover" id="add"><center> <span class="glyphicon glyphicon-plus"></span> </center></td>
    		<td class="tableHover" id="sortMin"><center><span class="glyphicon glyphicon-sort-by-attributes"></span></center></td>
    		<td class="tableHover" id="sortMax"><center><span class="glyphicon glyphicon-sort-by-attributes-alt"></span></center></td>
         </div>
      </form>
		</table>
	<div class="alert alert-info" id="alertSort" role="alert" onclick="this.style.display='none';">
		<p id="textSort"></p>
	</div>
    <div class="alert alert-danger" id="alert" onclick="this.style.display='none';">
      already have it.
    </div>
    <script type="text/javascript">
      doneList=[];
      var chart = c3.generate({
        bindto: '#chart',
        data: {
					x : 'x',
          columns: [],
					empty: { label: { text: "No Data Available" }   },
					onclick: function(d) {
						rIndex=d.index+1;
						if (rIndex > -1) {
						    reslutJF.splice(rIndex, 1);
								reslutCop.splice(rIndex, 1);
								reslutPv.splice(rIndex, 1);
								doneList.splice(rIndex-1, 1);
								if(doneList.length ==0){
									chart.load({
										x : 'x',
									columns: [],
									unload: [reslutJF[0], reslutCop[0],reslutPv[0]],
									type: 'bar',
									labels: true
									});
								}
								else {
									chart.load({
									columns: [
										reslutJF,
										reslutCop,
										reslutPv,
									]
									});
								}
						}
	        },
          type: 'bar',
					labels: true
        },
				tooltip: {
					show: false
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
				notDup=0;
        loc = document.getElementById("locations").value;
				for (i in doneList){
					if(loc==doneList[i]){
						notDup=1;
						break;
					}
				}
        if (notDup == 0) {
          reslutCop.push(listCop[loc])
          reslutPv.push(listJF[loc])
		  reslutJF.push(listPv[loc])
          doneList.push(loc);
          chart.load({
          columns: [
						reslutJF,
  					reslutCop,
  					reslutPv,
          ],
					type: 'bar',
					labels: true
      		});
        }else {
		  showAR = document.getElementById("alert");
          showAR.style.display = "block";
        }

      });
			$("#reset").click(function(event) {
				doneList=[];
				reslutCop=['Company (1:20)'];
				reslutPv=['Location'];
				reslutJF=['x'];
				chart.load({
					x : 'x',
				columns: [],
				unload: [reslutJF[0], reslutCop[0],reslutPv[0]],
				type: 'bar',
				labels: true
				});
				sortType=0;
				swapType=0;
			});
			var sortType=0;
			var swapType=0;
			$("#sortMin").click(function(){
				reslutCop.shift();
				reslutPv.shift();
				reslutJF.shift();
				//1) combine the arrays:
				var list = [];
				var list2 = [];
				if (swapType==0){
					sortType=0;
					swapType=1;
				}
				if (sortType==0) {
					for (var j = 0; j < reslutCop.length; j++){
					    list.push({'jf': reslutJF[j], 'cop': reslutCop[j]*20});
					    list2.push({'jf': reslutJF[j], 'pv': reslutPv[j]});
					}
					//2) sort:
					list.sort(function(a, b) {return ((a.jf < b.jf) ? -1 : ((a.jf == b.jf) ? 0 : 1));});
					list2.sort(function(a, b) {return ((a.jf < b.jf) ? -1 : ((a.jf == b.jf) ? 0 : 1));});

					//3) separate them back out:
					for (var k = 0; k < list.length; k++) {
					    reslutCop[k] = list[k].cop/20;
					    reslutPv[k] = list2[k].pv;
					    reslutJF[k] = list[k].jf;
					}
					sortType++;
					document.getElementById("textSort").innerHTML = "Min To Max Base on JobFunction";
					showARS = document.getElementById("alertSort");
          			showARS.style.display = "block";

				}else if(sortType==1){
					for (var j = 0; j < reslutCop.length; j++){
					    list.push({'cop': reslutCop[j]*20, 'jf': reslutJF[j]});
					    list2.push({'cop': reslutCop[j]*20, 'pv': reslutPv[j]});
					}
					//2) sort:
					list.sort(function(a, b) {return ((a.cop < b.cop) ? -1 : ((a.cop == b.cop) ? 0 : 1));});
					list2.sort(function(a, b) {return ((a.cop < b.cop) ? -1 : ((a.cop == b.cop) ? 0 : 1));});

					//3) separate them back out:
					for (var k = 0; k < list.length; k++) {
					    reslutCop[k] = list[k].cop/20;
					    reslutPv[k] = list2[k].pv;
					    reslutJF[k] = list[k].jf;
					}
					sortType++;
					document.getElementById("textSort").innerHTML = "Min To Max Base on Company";
					showARS = document.getElementById("alertSort");
          			showARS.style.display = "block";
				}else{
					for (var j = 0; j < reslutCop.length; j++){
					    list.push({'pv': reslutPv[j]*1, 'cop': reslutCop[j]*20});
					    list2.push({'pv': reslutPv[j]*1, 'jf': reslutJF[j]});
					}
					//2) sort:
					list.sort(function(a, b) {return ((a.pv < b.pv) ? -1 : ((a.pv == b.pv) ? 0 : 1));});
					list2.sort(function(a, b) {return ((a.pv < b.pv) ? -1 : ((a.pv == b.pv) ? 0 : 1));});

					//3) separate them back out:
					for (var k = 0; k < list.length; k++) {
					    reslutCop[k] = list[k].cop/20;
					    reslutPv[k] = list[k].pv;
					    reslutJF[k] = list2[k].jf;
					}
					sortType=0;
					document.getElementById("textSort").innerHTML = "Min To Max Base on Location";
					showARS = document.getElementById("alertSort");
          			showARS.style.display = "block";
				}
				reslutCop.unshift('Company (1:20)');
				reslutPv.unshift('Location');
				reslutJF.unshift('x');
				chart.load({
		          columns: [
							reslutJF,
		  					reslutCop,
		  					reslutPv,
		          ],
							type: 'bar',
							labels: true
		      		});
			});
			$("#sortMax").click(function(){
				reslutCop.shift();
				reslutPv.shift();
				reslutJF.shift();
				//1) combine the arrays:
				var list = [];
				var list2 = [];
				if (swapType==1){
					sortType=0;
					swapType=0;
				}
				if (sortType==0) {
					for (var j = 0; j < reslutCop.length; j++){
					    list.push({'jf': reslutJF[j], 'cop': reslutCop[j]*20});
					    list2.push({'jf': reslutJF[j], 'pv': reslutPv[j]});
					}
					//2) sort:
					list.sort(function(a, b) {return ((a.jf > b.jf) ? -1 : ((a.jf == b.jf) ? 0 : 1));});
					list2.sort(function(a, b) {return ((a.jf > b.jf) ? -1 : ((a.jf == b.jf) ? 0 : 1));});

					//3) separate them back out:
					for (var k = 0; k < list.length; k++) {
					    reslutCop[k] = list[k].cop/20;
					    reslutPv[k] = list2[k].pv;
					    reslutJF[k] = list[k].jf;
					}
					sortType++;
					document.getElementById("textSort").innerHTML = "Max To Min Base on JobFunction";
					showARS = document.getElementById("alertSort");
          			showARS.style.display = "block";
				}else if(sortType==1){
					for (var j = 0; j < reslutCop.length; j++){
					    list.push({'cop': reslutCop[j]*20, 'jf': reslutJF[j]});
					    list2.push({'cop': reslutCop[j]*20, 'pv': reslutPv[j]});
					}
					//2) sort:
					list.sort(function(a, b) {return ((a.cop > b.cop) ? -1 : ((a.cop == b.cop) ? 0 : 1));});
					list2.sort(function(a, b) {return ((a.cop > b.cop) ? -1 : ((a.cop == b.cop) ? 0 : 1));});

					//3) separate them back out:
					for (var k = 0; k < list.length; k++) {
					    reslutCop[k] = list[k].cop/20;
					    reslutPv[k] = list2[k].pv;
					    reslutJF[k] = list[k].jf;
					}
					sortType++;
					document.getElementById("textSort").innerHTML = "Max To Min Base on Company";
					showARS = document.getElementById("alertSort");
          			showARS.style.display = "block";
				}else{
					for (var j = 0; j < reslutCop.length; j++){
					    list.push({'pv': reslutPv[j]*1, 'cop': reslutCop[j]*20});
					    list2.push({'pv': reslutPv[j]*1, 'jf': reslutJF[j]});
					}
					//2) sort:
					list.sort(function(a, b) {return ((a.pv > b.pv) ? -1 : ((a.pv == b.pv) ? 0 : 1));});
					list2.sort(function(a, b) {return ((a.pv > b.pv) ? -1 : ((a.pv == b.pv) ? 0 : 1));});

					//3) separate them back out:
					for (var k = 0; k < list.length; k++) {
					    reslutCop[k] = list[k].cop/20;
					    reslutPv[k] = list[k].pv;
					    reslutJF[k] = list2[k].jf;
					}
					sortType=0;
					document.getElementById("textSort").innerHTML = "Max To Min Base on Location";
					showARS = document.getElementById("alertSort");
          			showARS.style.display = "block";
				}
				reslutCop.unshift('Company (1:20)');
				reslutPv.unshift('Location');
				reslutJF.unshift('x');
				chart.load({
		          columns: [
							reslutJF,
		  					reslutCop,
		  					reslutPv,
		          ],
							type: 'bar',
							labels: true
		      		});
			});
    </script>
	</body>
</html>
