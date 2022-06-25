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





$id = $_POST['id'];
$vessel_id = $_POST['vessel_id'];
$hours = $_POST['hours'];
$minutes = $_POST['minutes'];
$cause = $_POST['cause'];
$ename = $_POST['ename'];
$hours = sprintf("%02d", $hours);
$minutes = sprintf("%02d", $minutes);
$stop_duration =  $hours.$minutes."00";
$data['message'] = $vessel_id;

$query ="UPDATE   stop
        SET cause = '$cause',
                ename = '$ename',
                stop_duration = '$stop_duration'
                where  id = '$id'
                    ";

if(mysqli_query($con, $query)){

    $pusher->trigger('stop', 'report', $data);
    echo json_encode(array('success' => 1));
}
else return http_response_code(422);  
?>