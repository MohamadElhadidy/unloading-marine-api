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
$hours = $_POST['hours'];
$minutes = $_POST['minutes'];
$cause = $_POST['cause'];
$employee = $_POST['employee'];
$data['message'] =$vessel_id;
$hours = sprintf("%02d", $hours);
$minutes = sprintf("%02d", $minutes);
$stop_duration =  $hours.$minutes."00";
$date = date("Y-m-d H:i:s");

$query ="INSERT INTO stop  (vessel_id, cause, ename, stop_duration, date)
        VALUES('$vessel_id', '$cause', '$employee','$stop_duration','$date')";

if(mysqli_query($con, $query)){

    $result = mysqli_query($con,"SELECT *  FROM vessels_log   where vessel_id = '$vessel_id' AND done = 0 ");
    $row = mysqli_fetch_assoc($result);
    $pusher->trigger('stop', 'report', $data);
    echo json_encode(array('name' => $row["name"]));
}
else return http_response_code(422);
            
?>