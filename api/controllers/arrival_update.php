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
$move_id = $_POST['move_id'];
$vessel_id = $_POST['vessel_id'];
$store_no = $_POST['store_no'];
$type = $_POST['type'];
$ename = $_POST['ename'];
$notes = $_POST['notes'];

$data['message'] =$vessel_id ;

$query ="UPDATE   arrival
        SET store_no = '$store_no',
                type = '$type',
                ename = '$ename',
                notes = '$notes'
                where  id = '$id'";

if(mysqli_query($con, $query)){
$query2 ="UPDATE   move
        SET store_no = '$store_no',
                type = '$type'
                where  move_id = '$move_id' AND vessel_id = '$vessel_id'";
}
if(mysqli_query($con, $query2)){
    $pusher->trigger('arrival', 'report', $data);
    $pusher->trigger('stats', 'report', $data);
    echo json_encode(array('success' => 1));
}
else return http_response_code(422);  
?>