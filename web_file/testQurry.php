<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <? //ส่วนนี้เอาไว้บนสุด
      include("connect.php");
      $mtime = microtime();
    	$mtime = explode(" ",$mtime);
    	$mtime = $mtime[1] + $mtime[0];
    	$starttime = $mtime;
    ?>
    <?php
      $sql = "SELECT COUNT(DISTINCT(loc)),COUNT(DISTINCT(cop_name)) FROM main WHERE curdate()<date_add(`time`,interval 8 day) AND jfunc='1'";
      $result = $conn->query($sql);

    ?>
    <?php //ส่วนนี้เอาไว้ส่วนที่เราจะให้แสดง
      $mtime = microtime();
      $mtime = explode(" ",$mtime);
      $mtime = $mtime[1] + $mtime[0];
      $endtime = $mtime;
      $totaltime = number_format(($endtime - $starttime),2);
      echo "<font face='Tohoma' size='16' color='#2F4F4F'>หน้านี้ประมวลผล ".$totaltime." วินาที";
    ?>
  </body>
</html>
