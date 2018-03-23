
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="cache-control" content="no-cache" />
        <meta http-equiv="Pragma" content="no-cache" />
        <meta http-equiv="Expires" content="-1" />
        <title>JobsDB Map</title>

        <!-- Bootstrap CSS -->
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
        <!-- jQuery -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <!-- Bootstrap JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.3/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
    <style>
            body{
                background: url("bg.jpg");
                background-repeat: no-repeat;
                background-attachment: fixed;
                background-size: cover;
            }
            .justMenu:hover{
                color: #FFFFFF;
                cursor:pointer
            }
            #map {
                width: 98%;
                height: 95vh;
                background-color: grey;
            }
            .top-left {
                position: absolute;
                top: 8px;
                left: 16px;
            }
            #overlay {
                position: fixed; /* Sit on top of the page content */
                display: none; /* Hidden by default */
                width: 100%; /* Full width (cover the whole page) */
                height: 100%; /* Full height (cover the whole page) */
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background-color: rgba(0,0,0,0.5); /* Black background with opacity */
                z-index: 2; /* Specify a stack order in case you're using a different order for other elements */
                cursor: pointer; /* Add a pointer on hover */
            }
            #overlay2 {
                position: fixed; /* Sit on top of the page content */
                display: none; /* Hidden by default */
                width: 100%; /* Full width (cover the whole page) */
                height: 100%; /* Full height (cover the whole page) */
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background-color: rgba(0,0,0,0.5); /* Black background with opacity */
                z-index: 2; /* Specify a stack order in case you're using a different order for other elements */
                cursor: pointer; /* Add a pointer on hover */
            }
            #title-name{
                position: absolute;
                top: 50%;
                left: 50%;
                font-size: 50px;
                color: white;
                transform: translate(-50%,-50%);
                -ms-transform: translate(-50%,-50%);
            }
            .glyphicon.glyphicon-menu-hamburger{
                font-size: 24px;
                margin-right: 2%;
            }
            .modal-xl {
                    width: 95%;
            }
    </style>
    <!-- it's right menu part -->
    <style>
            /* The alert message box */
            .alertPJf {
                padding: 20px;
                background-color: #f44336; /* Red */
                color: white;
                margin-bottom: 15px;
                display: none;
            }

            /* When moving the mouse over the close button */
            .closebtn:hover {
                color: black;
            }
        /* The side navigation menu */
            .sidenav {
                height: 100%; /* 100% Full-height */
                width: 0; /* 0 width - change this with JavaScript */
                position: fixed; /* Stay in place */
                z-index: 1; /* Stay on top */
                top: 0;
                right: 0;
                background-color: #111; /* Black*/
                overflow-x: hidden; /* Disable horizontal scroll */
                padding-top: 60px; /* Place content 60px from the top */
                transition: 0.5s; /* 0.5 second transition effect to slide in the sidenav */
            }

            /* Position and style the close button (top right corner) */
            .sidenav .closebtn {
                position: absolute;
                top: 0;
                right: 25px;
                font-size: 36px;
                margin-left: 50px;
            }

            /* On smaller screens, where height is less than 450px, change the style of the sidenav (less padding and a smaller font size) */
            @media screen and (max-height: 450px) {
                .sidenav {padding-top: 15px;}
                .sidenav a {font-size: 18px;}
            }


            .dropdown-submenu {
                position: relative;
            }

            .dropdown-submenu>.dropdown-menu {
                top: 0;
                left: 100%;
                margin-top: -6px;
                margin-left: -1px;
                -webkit-border-radius: 0 6px 6px 6px;
                -moz-border-radius: 0 6px 6px;
                border-radius: 0 6px 6px 6px;
            }

            .dropdown-submenu:hover>.dropdown-menu {
                display: block;
            }

            .dropdown-submenu>a:after {
                display: block;
                content: " ";
                float: right;
                width: 0;
                height: 0;
                border-color: transparent;
                border-style: solid;
                border-width: 5px 0 5px 5px;
                border-left-color: #ccc;
                margin-top: 5px;
                margin-right: -10px;
            }

            .dropdown-submenu:hover>a:after {
                border-left-color: #fff;
            }

            .dropdown-submenu.pull-left {
                float: none;
            }

            .dropdown-submenu.pull-left>.dropdown-menu {
                left: -100%;
                margin-left: 10px;
                -webkit-border-radius: 6px 0 6px 6px;
                -moz-border-radius: 6px 0 6px 6px;
                border-radius: 6px 0 6px 6px;
            }
    </style>
    <!-- end -->
    </head>
    <body>
        <?php include("connect.php") ?>
        <div id="mySidenav" class="sidenav ">
            <div class="row">
      				<table style="margin-bottom:0px">
      					<tr>
      						<td class="tableHover closebtn" href="javascript:void(0)"><center> <span class="justMenu glyphicon glyphicon-remove" style="color:#FFFFFF"></span> </center></td>
      					</tr>
      				</table>
      			</div>

            <h2 style="color: #FFFFFF;"><center>Advanced Search</center></h2><hr>
            <form id="sert" name="sert" method="POST">
                <h3 style="color: #FFFFFF;margin-left: 10px;">Province</h3>
                <!-- drop down -->
                <select name="SLpv" id="SLpv" class="form-control" style="margin-left: 10px;width: 220px">
                    <option value="">-- All --</option>
                    <?php
                        //แสดงตัวเลือกจังหวัด
                        $sql = "SELECT id,name FROM location ORDER BY name";
                        $result = $conn->query($sql);
                        while($row = $result->fetch_assoc()) {
                            echo "<option value='".$row["id"]."'>".$row["name"]."</option>";
                        }
                    ?>
                </select>
                <!-- end here -->
                <h3 style="color: #FFFFFF;margin-left: 10px;">Job function</h3>
                <!-- drop down -->
                <select name="SLjfunc" id="SLjfunc" class="form-control" style="margin-left: 10px;width: 220px">
                    <option value="">-- All --</option>
                    <?php
                        //แสดงตัวเลือกประเภทงาน
                        $sql = "SELECT id,name FROM jfunc  ORDER BY name";
                        $result = $conn->query($sql);
                        while($row = $result->fetch_assoc()) {
                            echo "<option value='".$row["id"]."'>".$row["name"]."</option>";
                        }
                    ?>
                </select>
                <!-- end here -->
                <br>
                <center><button id="submit" name="SubmitButton" type="button" class="btn btn-success" style="width: 150px; font-size: 16px;"><b>SUBMIT</b></button></center>
                <br><div class="alertPJf" id="alertPJf" onclick="this.style.display='none';">
                  Too Many Data Please Select <b>Province</b> or <b>Job function</b>.
                </div>
            </form>
        </div>
<!------------------------------------------------ MAIN    -------------------------------------------->
        <div class="container">
            <div class="row">

                  <div class="dropdown">
                      <span id="dLabel" class="glyphicon glyphicon-stats justMenu dropdown-toggle" data-toggle="dropdown" style="font-size: 24px;"><b>Statistic </b></span>
                		    <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                          <li class="dropdown-header">None Conditionr</li>
                          <li class="dropdown-submenu">
                            <a>Job Function</a>
                            <ul class="dropdown-menu">
                              <li><a  href="#" id="NoneCon1" value="8" loc="staticDataJfunc.php" head="Job Function">1 Week</a></li>
                              <li><a  href="#" id="NoneCon2" value="31" loc="staticDataJfunc.php" head="Job Function">1 Month</a></li>
                              <li><a  href="#" id="NoneCon3" value="91" loc="staticDataJfunc.php" head="Job Function">3 Month</a></li>
                            </ul>
                          </li>
                          <li class="dropdown-submenu">
                            <a  href="#">Location</a>
                            <ul class="dropdown-menu">
                              <li><a  href="#" id="NoneCon4" value="8" loc="staticDataLoc.php" head="Location">1 Week</a></li>
                              <li><a  href="#" id="NoneCon5" value="31" loc="staticDataLoc.php" head="Location">1 Month</a></li>
                              <li><a  href="#" id="NoneCon6" value="91" loc="staticDataLoc.php" head="Location">3 Month</a></li>
                            </ul>
                          </li>
                          <li class="divider"></li>
                          <li class="dropdown-header">Condition</li>
                          <li class="dropdown-submenu">
                            <a  href="#">Job Function</a>
                            <ul class="dropdown-menu">
                              <li><a  href="#">1 Week</a></li>
                              <li><a  href="#">1 Month</a></li>
                              <li><a  href="#">3 Month</a></li>
                            </ul>
                          </li>
                          <li class="dropdown-submenu">
                            <a  href="#">Location</a>
                            <ul class="dropdown-menu">
                              <li><a  href="#">1 Week</a></li>
                              <li><a  href="#">1 Month</a></li>
                              <li><a  href="#">3 Month</a></li>
                            </ul>
                          </li>
                        </ul>
                  <span id="btn-nav" class="glyphicon glyphicon-search pull-right justMenu" style="font-size: 24px;"><b>Search</b>&nbsp</span>
                </div>
            </div>
            <div class="row">
                <div id="map" style="border: 2px solid #000000;" class="col-xs-12 col-sm-12 col-md-12 col-lg-12"></div>
            </div>
        </div>
<!----------------------------------------------------------------------------------------------------->
        <div id="overlay" onclick="off()">
            <div id="title-name">JobsDB Map</div>
        </div>
        <div id="overlay2">
            <div id="title-name">Please wait.</div>
        </div>
        <script src="./system.js"></script>
        <script src="./province.js"></script>
        <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB7bPUBMzGNhJi-lju4_zyV-0eVAj8PBnk&callback=initMap"></script>
        <script>
            var dataCounty=[];
        </script>
        <?php
            //ดึงรายชื่อจังหวัดเพื่อโชว์จุดบนแผนที่
            $sumC=0;
            $sql = "SELECT name FROM location";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                // output data of each row
                while($row = $result->fetch_assoc()) {
                    //echo '"'.trim($row["loc"]).'",';
                    $sumC+=1;
        ?>
                    <script>
                        dataCounty.push(String("<?php echo(trim($row["name"]));?>"))
                    </script>
        <?php
                }
            } else {
                echo "ไม่เจอ";
            }
            //echo $sumC;
            $conn->close();
        ?>
        <!-- ModalJobList -->
        <div id="myModal" class="modal fade" role="dialog">
          <div class="modal-dialog modal-xl" style="height: 90%;">
            <!-- Modal content -->
            <div class="modal-content"  style="height: 100%;">
                <div class="modal-header" style="background-color: #B5B5B5">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title"><center style="font-size: 24px;color: #FFFFFF;text-shadow: -1px 0 black, 0 1px black, 1px 0 black, 0 -1px black;">Jobs List</center></h4>
                </div>
                <div style="padding: 0 0 0 0;height: 650px" class="modal-body">
                  <iframe id="MFM" style="width: 100%;height: 100%" frameBorder="0"  src=""></iframe>
                </div>
            </div>
          </div>
        </div>
        <!-- END -->

        <!-- ModalSeart -->
        <div id="ModalForS" class="modal fade" role="dialog">
          <div class="modal-dialog modal-xl" style="height: 90%;">

            <!-- Modal content-->
            <div class="modal-content" style="height: 100%;">
              <div class="modal-header" style="background-color: #B5B5B5">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><center style="font-size: 24px;color: #FFFFFF;text-shadow: -1px 0 black, 0 1px black, 1px 0 black, 0 -1px black;">RESULT</center></h4>
              </div>
              <div style="padding: 0 0 0 0;height: 650px" class="modal-body">
                <iframe id="MFS" style="width: 100%;height: 100%" frameBorder="0"  src=""></iframe>
              </div>
            </div>

          </div>
        </div>

        <!-- Modalstatic -->
        <div id="ModalForStatic" class="modal fade" role="dialog">
          <div class="modal-dialog modal-xl" style="height: 90%;">

            <!-- Modal content-->
            <div class="modal-content" style="height: 100%;">
              <div class="modal-header" style="background-color: #B5B5B5">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><center id="textHead" style="font-size: 24px;color: #FFFFFF;text-shadow: -1px 0 black, 0 1px black, 1px 0 black, 0 -1px black;">RESULT</center></h4>
              </div>
              <div style="padding: 0 0 0 0;height: 650px" class="modal-body">
                <iframe id="MFST" style="width: 100%;height: 100%" frameBorder="0"  src=""></iframe>
              </div>
            </div>

          </div>
        </div>
        <?php
        //loop เลือก static แบบไม่มีเงื่อนไข
          for ($i=1; $i <7 ; $i++) {
        ?>
          <script>
            $("#NoneCon<?php echo $i ?>").click(function(event) {
              days = $("#NoneCon<?php echo $i ?>").attr("value");
              path = $("#NoneCon<?php echo $i ?>").attr("loc");
              head = $("#NoneCon<?php echo $i ?>").attr("head");
              console.log(days);
              console.log(path);
              document.getElementById("overlay2").style.display = 'inline';
              $("#textHead").text(head);
              document.getElementById('MFST').src = path+"?days="+days;
              $.ajax({
                url: path+'?days='+days,
                type: 'GET',
                dataType: 'html'
              })
              .done(function() {
                document.getElementById("overlay2").style.display = 'none';
                $(ModalForStatic).modal('show');
                console.log("success!!!");
              })

            });
          </script>
        <?php
          }
        ?>
        <script>
            $(submit).click(function(event){
                document.getElementById('MFS').src = "load.php";
                var pv,jf;
                pv = document.getElementById("SLpv").value;
                jf = document.getElementById("SLjfunc").value;
                Apjf = document.getElementById("alertPJf");
                if (pv+jf == "") {
                  console.log("เห้ยใส่ด้วย");
                  Apjf.style.display = "block";
                }else {
                  //document.getElementById("bodyModalForS").innerHTML = "จังหวัด: "+pv +"สายอาชีพ: " + jf;
                  console.log(pv +" "+ jf)
                  $(ModalForS).modal('show');
                  $.ajax({
                      url: 'tableResult.php?pv='+pv+'&jf='+jf,
                      dataType: 'html',
                      type: 'GET',
                  })
                  .done(function() {
                      document.getElementById('MFS').src = 'tableResult.php?pv='+pv+'&jf='+jf;
                  })
                  .fail(function() {
                      console.log("error");
                  })
                }


            });
        </script>
        <!-- END -->
    </body>
</html>
