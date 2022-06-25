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



$sn = $_POST['snc'];
$param = explode('|', urldecode($_POST['v']));
$carn = $_POST['carn'];
$str1 = $_POST['carl'];

$carn2 = $_POST['carn1'];
$str12 = $_POST['carl1'];
$car_type = $_POST['ctc'];
$car_owner =trim($_POST['cnc']);
$car_driver =trim($_POST['name']);
$time = $_POST['hr'].':'.$_POST['mt'];
$date = $_POST['yer'].'-'.$_POST['mon'].'-'.$_POST['dy'];

$id = $param[0];
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

$start_date = $date.' '.$time;

$result1 = mysqli_query($con,"SELECT *  FROM vessels_log   where id = '$id' AND done = 0 ");
$row = mysqli_fetch_assoc($result1);
$vessel_id = $row['vessel_id']; 
$data['message'] = $vessel_id;

$query ="INSERT INTO cars (vessel_id, sn, car_no, car_no2, car_owner, car_type, car_driver, start_date )
VALUES ('$vessel_id' , '$sn',  '$car_no', '$car_no2', '$car_owner', '$car_type', '$car_driver',  '$start_date')";

if(mysqli_query($con, $query)) {     
    $pusher->trigger('car', 'report', $data);
    $pusher->trigger('stats', 'report', $data);
    $pusher->trigger('live', 'add-vessel', $data);
	if($car_type == $car_owner) $car_owner = '';
    
    $query = mysqli_query($con, "SELECT COUNT(id) as count FROM cars where  vessel_id = '$vessel_id' AND done = 0");
    $total_cars = mysqli_fetch_assoc($query );

	$message1='  تم إضافة  '.$car_type
    .' رقم '.$car_no
	.' كود '.$sn.' '.$car_owner
	.'  إلى منظومة التفريغ ';
	$message1.= "\r\n";
	$message1.= 'وقت الدخول : '.$start_date;
    $message1.= "\r\n";
	$message1.= 'إجمالى السيارات الحالية : *'.$total_cars['count'].'*';




    $message2='  تم إضافة  '.$car_type
    .' رقم '.$car_no
	.' كود '.$sn.' '.$car_owner
	.'  إلى منظومة التفريغ ';
	$message2.= "\r\n";
	$message2.= 'وقت الدخول : '.$start_date;
    $message2.= "\r\n";
	$message2.= 'إجمالى السيارات الحالية : *'.$total_cars['count'].'*';
    $message2.= "\r\n";
	
	$message3 = "";

    require "../../telegram.php"; 
	// send($vessel_id ,$message1, 'it', false);
    // send($vessel_id ,$message3, 'it', true);
	send($vessel_id ,$message1, 'unloading', false);
	send($vessel_id ,$message2, 'ceo', false);
	send($vessel_id ,$message3, 'ceo', true);
    return http_response_code(200);
}
return http_response_code(422);
?>