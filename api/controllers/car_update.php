<?php
// database connection
require "../../config.php";
require "../../vendor/autoload.php";

  $options = array(
    'cluster' => 'eu',
    'useTLS' => true
  );
 $pusher = new Pusher\Pusher(
    '027ae0da475a8bfb329b',
    '3710f31eab0abba775cd',
    '1326807',
    $options
  );




$id = $_POST['id'];
$vessel_id = $_POST['vessel_id'];
$str1 = $_POST['carl'];
$carn = $_POST['carn'];
$carn2 = $_POST['carn2'];
$str12 = $_POST['carl2'];
$car_type = $_POST['car_type'];
$car_owner = $_POST['car_owner'];
$car_driver =trim($_POST['car_driver']);

$str2 = preg_replace('/\s\s+/u', ' ', $str1);
$str3=  preg_replace('//u', ' ', $str2);
$str4 = preg_replace('/\s+/', ' ', $str3);
$car_l =trim($str4);
$car_no =$carn.' '.$car_l ;

$str22 = preg_replace('/\s\s+/u', ' ', $str12);
$str32=  preg_replace('//u', ' ', $str22);
$str42 = preg_replace('/\s+/', ' ', $str32);
$car_l2 =trim($str42);
$car_no2 =$carn2.' '.$car_l2 ;



$query ="UPDATE   cars
        SET car_no = '$car_no',
                car_type = '$car_type',
                car_owner = '$car_owner',
                car_no2 = '$car_no2',
                car_driver = '$car_driver'
                where  id = '$id'
                    ";

if(mysqli_query($con, $query)){
    $data['message'] = $vessel_id;
    $pusher->trigger('car', 'report', $data);
    echo json_encode(array('success' => 1));
}
else return http_response_code(422);  
?>