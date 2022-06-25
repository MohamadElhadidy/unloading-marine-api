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
$room_no = $_POST['room_no'];
$hobar = $_POST['hobar'];
$crane = $_POST['crane'];
$kbsh = $_POST['kbsh'];
$type = $_POST['type'];
$move_id = $_POST['move_id'];
$vessel_id = $_POST['vessel_id'];
$data['message'] =$vessel_id ;
$query ="UPDATE   loading
        SET room_no = '$room_no',
                hobar = '$hobar',
                crane = '$crane',
                kbsh = '$kbsh',
                type = '$type'
                where  id = '$id'
                    ";

if(mysqli_query($con, $query)){
$query2 ="UPDATE   move
        SET room_no = '$room_no',
                hobar = '$hobar',
                crane = '$crane',
                kbsh = '$kbsh',
                type = '$type'
                where  move_id = '$move_id' AND vessel_id = '$vessel_id'
                    ";
}
if(mysqli_query($con, $query2)){
    $pusher->trigger('loading', 'report', $data);
    $pusher->trigger('stats', 'report', $data);
    echo json_encode(array('success' => 1));
}
else return http_response_code(422);  
?>