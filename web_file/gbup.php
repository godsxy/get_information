<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <?php
    include("connect.php");
    ini_set('max_execution_time', 0);
    $sql = "SELECT id,name FROM cop_name";
    $result = $conn->query($sql);
    $i = 0;
    $data=[];
    while($row = $result->fetch_assoc()) {
        //$data[]=$row["id"];
        $i++;
        $sql = "UPDATE main SET cop_name2=".$row["id"]." WHERE cop_name='".$row["name"]."'";
        $conn->query($sql);
    }
    echo "<br>DONE!! HAVE ";
    echo $i;
    ?>

  </body>
</html>
