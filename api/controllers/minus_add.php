<?php
// database connection
require "../../config.php";
require "../../vendor/autoload.php";

  $options = array(
    'cluster' => 'eu',
    'u
    seTLS' => true
  );
 $pusher = new Pusher\Pusher(
    '027ae0da475a8bfb329b',
    '3710f31eab0abba775cd',
    '1326807',
    $options
  );


  


$vessel_id = $_POST['vessel_id'];
$sn = $_POST['sn'];
$hours = $_POST['hours'];
$minutes = $_POST['minutes'];
$cause = $_POST['cause'];
$employee = $_POST['employee'];
  $data['message'] =$vessel_id ;
$hours = sprintf("%02d", $hours);
$minutes = sprintf("%02d", $minutes);
$minus_duration =  $hours.$minutes."00";
$date = date("Y-m-d H:i:s");

$query ="INSERT INTO minus  (vessel_id, sn, cause, ename, minus_duration, date)
        VALUES('$vessel_id','$sn' , '$cause', '$employee','$minus_duration','$date')";

if(mysqli_query($con, $query)){

    $result =  mysqli_query($con,"SELECT *  FROM cars  where vessel_id = '$vessel_id' AND sn ='$sn' AND done = 0 ");
    $row = mysqli_fetch_assoc($result);
    $pusher->trigger('minus', 'report', $data);
    echo json_encode(array('car_no' => $row["car_no"]));
}
else return http_response_code(422);
            
?>