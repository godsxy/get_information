
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

            /* The navigation menu links */
            .sidenav a {
                padding: 8px 8px 8px 32px;
                text-decoration: none;
                font-size: 25px;
                color: #818181;
                display: block;
                transition: 0.3s
            }

            /* When you mouse over the navigation links, change their color */
            .sidenav a:hover, .offcanvas a:focus{
                color: #f1f1f1;
            }

            /* Position and style the close button (top right corner) */
            .sidenav .closebtn {
                position: absolute;
                top: 0;
                right: 25px;
                font-size: 36px;
                margin-left: 50px;
            }

            /* Style page content - use this if you want to push the page content to the right when you open the side navigation */
            #main {
                transition: margin-left .5s;
                padding: 20px;
            }

            /* On smaller screens, where height is less than 450px, change the style of the sidenav (less padding and a smaller font size) */
            @media screen and (max-height: 450px) {
                .sidenav {padding-top: 15px;}
                .sidenav a {font-size: 18px;}
            }
    </style>
    <!-- end -->
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
        <div id="mySidenav" class="sidenav">
            <a href="javascript:void(0)" class="closebtn">&times;</a>
            <h2 style="color: #FFFFFF;"><center>Advanced Search</center></h2><hr>
            <form id="sert" name="sert" method="POST">
                <h3 style="color: #FFFFFF;margin-left: 10px;">Province</h3>
                <!-- drop down -->
                <select name="SLpv" id="SLpv" class="form-control" style="margin-left: 10px;width: 220px">
                    <option value="">-- All --</option>
                    <?php
                        $sql = "SELECT DISTINCT(loc) FROM main WHERE out_date='0' ORDER BY loc";
                        $result = $conn->query($sql);
                        while($row = $result->fetch_assoc()) {
                            echo "<option value='".$row["loc"]."'>".$row["loc"]."</option>";
                        }
                    ?>
                </select>
                <!-- end here -->
                <h3 style="color: #FFFFFF;margin-left: 10px;">Job function</h3>
                <!-- drop down -->
                <select name="SLjfunc" id="SLjfunc" class="form-control" style="margin-left: 10px;width: 220px">
                    <option value="">-- All --</option>
                    <?php
                        $sql = "SELECT id,name FROM job_func ORDER BY name";
                        $result = $conn->query($sql);
                        while($row = $result->fetch_assoc()) {
                            echo "<option value='".$row["id"]."'>".$row["name"]."</option>";
                        }
                    ?>
                </select>
                <!-- end here -->
                <br>
                <center><button id="submit" name="SubmitButton" type="button" class="btn btn-success" style="width: 150px; font-size: 16px;"><b>SUBMIT</b></button></center>
            </form>
        </div>
        <div class="container">
            <div class="row">
                <span id="btn-nav" class="glyphicon glyphicon-menu-hamburger pull-right justMenu" style="font-size: 24px;"><b>Search</b></span>
                <div id="map" style="border: 2px solid #000000;" class="col-xs-12 col-sm-12 col-md-12 col-lg-12"></div>
            </div>
        </div>
        <div id="overlay" onclick="off()">
            <div id="title-name">JobsDB Map</div>
        </div>
        <script src="./system.js"></script>
        <script src="./province.js"></script>
        <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB7bPUBMzGNhJi-lju4_zyV-0eVAj8PBnk&callback=initMap"></script>
        <script>
            var dataCounty=[];
        </script>
        <?php
            $sumC=0;
            $sql = "SELECT DISTINCT(loc) FROM main WHERE out_date='0'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                // output data of each row
                while($row = $result->fetch_assoc()) {
                    //echo '"'.trim($row["loc"]).'",';
                    $sumC+=1;
        ?>
                    <script>
                        dataCounty.push(String("<?php echo(trim($row["loc"]));?>"))
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
          <div class="modal-dialog modal-xl" style="height: 90%;"">

            <!-- Modal content-->
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
        <script>
            $(submit).click(function(event){
                document.getElementById('MFS').src = "load.php";
                var pv,jf;
                pv = document.getElementById("SLpv").value;
                jf = document.getElementById("SLjfunc").value;
                //document.getElementById("bodyModalForS").innerHTML = "จังหวัด: "+pv +"สายอาชีพ: " + jf;
                console.log(pv +" "+ jf)
                $.ajax({
                    url: 'tableResult.php?pv='+pv+'&jf='+jf,
                    dataType: 'html',
                    type: 'GET',
                })
                .done(function() {
                    document.getElementById('MFS').src = 'tableResult.php?pv='+pv+'&jf='+jf;
                    $(ModalForS).modal('show');
                    console.log("success");
                })
                .fail(function() {
                    console.log("error");
                })
                
            });
        </script>
        <!-- END -->
    </body>
</html>