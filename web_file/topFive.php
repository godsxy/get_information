<!DOCTYPE html>
<html lang="eng">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Title Page</title>

        <!-- Bootstrap CSS -->
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.3/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
        <?php
            if (isset($_GET['days'])) {
                $day = (int)$_GET['days'];
            } else {
                $day = 8;
            }
            include("connect.php");
            $sqlGetCop="SELECT `cop_name`,COUNT(`cop_name`) FROM `main` WHERE curdate()<date_add(`time`,interval ".$day." day) GROUP BY `cop_name` HAVING COUNT(`cop_name`) > 1 ORDER BY COUNT(`cop_name`) DESC LIMIT 5";
            $sqlGetJfunc="SELECT `jfunc`,COUNT(`jfunc`) FROM `main` WHERE curdate()<date_add(`time`,interval ".$day." day) GROUP BY `jfunc` HAVING COUNT(`jfunc`) > 1 ORDER BY COUNT(`jfunc`) DESC LIMIT 5";
            $sqlGetLoc="SELECT `loc`,COUNT(`loc`) FROM `main` WHERE curdate()<date_add(`time`,interval ".$day." day) GROUP BY `loc` HAVING COUNT(`loc`) > 1 ORDER BY COUNT(`loc`) DESC LIMIT 5";
            $resultGetCop = $conn->query($sqlGetCop);
            $resultGetJfunc = $conn->query($sqlGetJfunc);
            $resultGetLoc = $conn->query($sqlGetLoc);
        ?>
        <br>
        <div class="container">
            <div class="row">
                <div role="tabpanel">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active">
                            <a href="#cop" aria-controls="cop" role="tab" data-toggle="tab">Top 5 Company</a>
                        </li>
                        <li role="presentation">
                            <a href="#jfunc" aria-controls="jfunc" role="tab" data-toggle="tab">Top 5 Job Function</a>
                        </li>
                        <li role="presentation">
                            <a href="#loc" aria-controls="loc" role="tab" data-toggle="tab">Top 5 Location</a>
                        </li>
                    </ul>
                
                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="cop">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Rating</th>
                                        <th>Name</th>
                                        <th>Total Recruitment</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                    $index=1;
                                    while($row = $resultGetCop->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td>".$index."</td>";
                                        $sqlGetName = "SELECT `name` FROM `cop_name` WHERE `id`=".$row['cop_name'];
                                        $resultGetName = $conn->query($sqlGetName);
                                        while($row2 = $resultGetName->fetch_assoc()) {
                                            echo "<td>".$row2['name']."</td>";
                                        }
                                        echo "<td>".$row['COUNT(`cop_name`)']."</td>";
                                        echo "</tr>";
                                        $index++;
                                    }
                                ?>
                                </tbody>
                            </table>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="jfunc">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Rating</th>
                                        <th>Name</th>
                                        <th>Total Recruitment</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                    $index=1;
                                    while($row = $resultGetJfunc->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td>".$index."</td>";
                                        $sqlGetName = "SELECT `name` FROM `jfunc` WHERE `id`=".$row['jfunc'];
                                        $resultGetName = $conn->query($sqlGetName);
                                        while($row2 = $resultGetName->fetch_assoc()) {
                                            echo "<td>".$row2['name']."</td>";
                                        }
                                        echo "<td>".$row['COUNT(`jfunc`)']."</td>";
                                        echo "</tr>";
                                        $index++;
                                    }
                                ?>
                                </tbody>
                            </table>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="loc">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Rating</th>
                                        <th>Name</th>
                                        <th>Total Recruitment</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                    $index=1;
                                    while($row = $resultGetLoc->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td>".$index."</td>";
                                        $sqlGetName = "SELECT `name` FROM `location` WHERE `id`=".$row['loc'];
                                        $resultGetName = $conn->query($sqlGetName);
                                        while($row2 = $resultGetName->fetch_assoc()) {
                                            echo "<td>".$row2['name']."</td>";
                                        }
                                        echo "<td>".$row['COUNT(`loc`)']."</td>";
                                        echo "</tr>";
                                        $index++;
                                    }
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
        
        <!-- jQuery -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <!-- Bootstrap JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </body>
</html>
