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
			listJF=[['JobFunction']];
			listCop=[['Company (1:20)']];
			listPv=[['x']];
			backUplistJF=[];
			backUplistPv=[];
			backUplistCop=[];
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
						ini_set('max_execution_time', 300);
						$sqlGetData = "SELECT COUNT(DISTINCT(jfunc)),COUNT(DISTINCT(cop_name)) FROM main WHERE curdate()<date_add(`time`,interval ".$day." day) AND `loc`='".$row['id']."'";
						$resultDaTa = $conn->query($sqlGetData);
						while($row2 = $resultDaTa->fetch_assoc()) {
							$LocName=$row['name'];
							$Jfunc=$row2['COUNT(DISTINCT(jfunc))'];
							$CopSum=$row2['COUNT(DISTINCT(cop_name))']/20;
							if ($Jfunc+$CopSum==0) {
								continue;
							}
							else {

				?>
							<script type="text/javascript">
								backUplistJF.push('<?php echo $Jfunc; ?>');
								backUplistPv.push('<?php echo $LocName; ?>');
								backUplistCop.push('<?php echo $CopSum; ?>');
							</script>
				<?php
							}
						}
			}
		?>
		<table class="table">
				<td class="tableHover" id="back"><center> <span class="glyphicon glyphicon-arrow-left"></span> </center></td>
				<td class="tableHover" id="sortMin"><center><span class="glyphicon glyphicon-sort-by-attributes"></span></center></td>
				<td type="button"><center><p id="page"></p></center></td>
				<td class="tableHover" id="sortMax"><center><span class="glyphicon glyphicon-sort-by-attributes-alt"></span></center></td>
				<td class="tableHover" id="next"><center> <span class="glyphicon glyphicon-arrow-right"></span> </center></td>
		</table>
		<div class="alert alert-info" id="alertSort" role="alert" onclick="this.style.display='none';">
		<p id="textSort"></p>
	</div>
    <script type="text/javascript">
    	function addToMainArray(){
	    	sum=1;
	    	index=0;
	    	listJF=[];
	    	listCop=[];
	    	listPv=[];
	    	listJF.push(['JobFunction']);
			listCop.push(['Company (1:20)']);
			listPv.push(['x']);
	    	for(i=0;i<backUplistCop.length;i++){
	    		if (sum == 10) {
	    		sum=1;
	    		index++;
		    		listJF.push(['JobFunction']);
					listCop.push(['Company (1:20)']);
					listPv.push(['x']);
		    	}
		    	else{
		    		sum++;
		    		listJF[index].push(backUplistJF[i]);
		    		listPv[index].push(backUplistPv[i]);
		    		listCop[index].push(backUplistCop[i]);
		    	}
	    	}
    	}
    	addToMainArray()
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
          type: 'bar',
					labels: true
        },
				tooltip: {
					show: false
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
		document.getElementById("page").innerHTML = (slot+1)+"/"+(index+1);

			$( "#back" ).click(function() {
				if (slot>0) {
					slot--;
					document.getElementById("page").innerHTML = (slot+1)+"/"+(index+1);

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
					document.getElementById("page").innerHTML = (slot+1)+"/"+(index+1);

				}
				chart.load({
			        columns: [
								listJF[slot],
								listCop[slot],
								listPv[slot]
			        ]
    			});
			});
		var sortType=0;
		var swapType=0;
		$("#sortMin").click(function(){
				//1) combine the arrays:
				var list = [];
				var list2 = [];
				if (swapType==0){
					sortType=0;
					swapType=1;
				}
				if (sortType==0) {
					for (var j = 0; j < backUplistCop.length; j++){
					    list.push({'pv': backUplistPv[j], 'cop': backUplistCop[j]*20});
					    list2.push({'pv': backUplistPv[j], 'jf': backUplistJF[j]});
					}
					//2) sort:
					list.sort(function(a, b) {return ((a.pv < b.pv) ? -1 : ((a.pv == b.pv) ? 0 : 1));});
					list2.sort(function(a, b) {return ((a.pv < b.pv) ? -1 : ((a.pv == b.pv) ? 0 : 1));});

					//3) separate them back out:
					for (var k = 0; k < list.length; k++) {
					    backUplistCop[k] = list[k].cop/20;
					    backUplistPv[k] = list[k].pv;
					    backUplistJF[k] = list2[k].jf;
					}
					sortType++;
					document.getElementById("textSort").innerHTML = "Min To Max Base on JobFunction";
					showARS = document.getElementById("alertSort");
          			showARS.style.display = "block";

				}else if(sortType==1){
					for (var j = 0; j < backUplistCop.length; j++){
					    list.push({'cop': backUplistCop[j]*20, 'jf': backUplistJF[j]});
					    list2.push({'cop': backUplistCop[j]*20, 'pv': backUplistPv[j]});
					}
					//2) sort:
					list.sort(function(a, b) {return ((a.cop < b.cop) ? -1 : ((a.cop == b.cop) ? 0 : 1));});
					list2.sort(function(a, b) {return ((a.cop < b.cop) ? -1 : ((a.cop == b.cop) ? 0 : 1));});

					//3) separate them back out:
					for (var k = 0; k < list.length; k++) {
					    backUplistCop[k] = list[k].cop/20;
					    backUplistPv[k] = list2[k].pv;
					    backUplistJF[k] = list[k].jf;
					}
					sortType++;
					document.getElementById("textSort").innerHTML = "Min To Max Base on Company";
					showARS = document.getElementById("alertSort");
          			showARS.style.display = "block";
				}else{
					for (var j = 0; j < backUplistCop.length; j++){
					    list.push({'jf': backUplistJF[j]*1, 'cop': backUplistCop[j]*20});
					    list2.push({'jf': backUplistJF[j]*1, 'pv': backUplistPv[j]});
					}
					//2) sort:
					list.sort(function(a, b) {return ((a.jf < b.jf) ? -1 : ((a.jf == b.jf) ? 0 : 1));});
					list2.sort(function(a, b) {return ((a.jf < b.jf) ? -1 : ((a.jf == b.jf) ? 0 : 1));});

					//3) separate them back out:
					for (var k = 0; k < list.length; k++) {
					    backUplistCop[k] = list[k].cop/20;
					    backUplistPv[k] = list2[k].pv;
					    backUplistJF[k] = list[k].jf;
					}
					sortType=0;
					document.getElementById("textSort").innerHTML = "Min To Max Base on Location";
					showARS = document.getElementById("alertSort");
          			showARS.style.display = "block";
				}
				addToMainArray()
				chart.load({
		          columns: [
						listJF[0],
		            listCop[0],
		            listPv[0]
		          ],
							type: 'bar',
							labels: true
		      		});
				slot=0;
				document.getElementById("page").innerHTML = (slot+1)+"/"+(index+1);
			});
			$("#sortMax").click(function(){
				//1) combine the arrays:
				var list = [];
				var list2 = [];
				if (swapType==1){
					sortType=0;
					swapType=0;
				}
				if (sortType==0) {
					for (var j = 0; j < backUplistCop.length; j++){
					    list.push({'pv': backUplistPv[j], 'cop': backUplistCop[j]*20});
					    list2.push({'pv': backUplistPv[j], 'jf': backUplistJF[j]});
					}
					//2) sort:
					list.sort(function(a, b) {return ((a.pv > b.pv) ? -1 : ((a.pv == b.pv) ? 0 : 1));});
					list2.sort(function(a, b) {return ((a.pv > b.pv) ? -1 : ((a.pv == b.pv) ? 0 : 1));});

					//3) separate them back out:
					for (var k = 0; k < list.length; k++) {
					    backUplistCop[k] = list[k].cop/20;
					    backUplistPv[k] = list[k].pv;
					    backUplistJF[k] = list2[k].jf;
					}
					sortType++;
					document.getElementById("textSort").innerHTML = "Max To Min Base on JobFunction";
					showARS = document.getElementById("alertSort");
          			showARS.style.display = "block";
				}else if(sortType==1){
					for (var j = 0; j < backUplistCop.length; j++){
					    list.push({'cop': backUplistCop[j]*20, 'jf': backUplistJF[j]});
					    list2.push({'cop': backUplistCop[j]*20, 'pv': backUplistPv[j]});
					}
					//2) sort:
					list.sort(function(a, b) {return ((a.cop > b.cop) ? -1 : ((a.cop == b.cop) ? 0 : 1));});
					list2.sort(function(a, b) {return ((a.cop > b.cop) ? -1 : ((a.cop == b.cop) ? 0 : 1));});

					//3) separate them back out:
					for (var k = 0; k < list.length; k++) {
					    backUplistCop[k] = list[k].cop/20;
					    backUplistPv[k] = list2[k].pv;
					    backUplistJF[k] = list[k].jf;
					}
					sortType++;
					document.getElementById("textSort").innerHTML = "Max To Min Base on Company";
					showARS = document.getElementById("alertSort");
          			showARS.style.display = "block";
				}else{
					for (var j = 0; j < backUplistCop.length; j++){
					    list.push({'jf': backUplistJF[j]*1, 'cop': backUplistCop[j]*20});
					    list2.push({'jf': backUplistJF[j]*1, 'pv': backUplistPv[j]});
					}
					//2) sort:
					list.sort(function(a, b) {return ((a.jf > b.jf) ? -1 : ((a.jf == b.jf) ? 0 : 1));});
					list2.sort(function(a, b) {return ((a.jf > b.jf) ? -1 : ((a.jf == b.jf) ? 0 : 1));});

					//3) separate them back out:
					for (var k = 0; k < list.length; k++) {
					    backUplistCop[k] = list[k].cop/20;
					    backUplistPv[k] = list2[k].pv;
					    backUplistJF[k] = list[k].jf;
					}
					sortType=0;
					document.getElementById("textSort").innerHTML = "Max To Min Base on Location";
					showARS = document.getElementById("alertSort");
          			showARS.style.display = "block";
				}
				addToMainArray()
				chart.load({
		          columns: [
						listJF[0],
		            listCop[0],
		            listPv[0]
		          ],
							type: 'bar',
							labels: true
		      		});
				slot=0;
				document.getElementById("page").innerHTML = (slot+1)+"/"+(index+1);
			});
    </script>

	</body>
</html>
