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
$sn = $_POST['sn'];
$quantity = $_POST['quantity'];
$jumbo = $_POST['jumbo'];
$move_id = $_POST['move_id'];
$vessel_id = $_POST['vessel_id'];
$qnt_date = date("Y-m-d H:i:s");
$data['message'] = $vessel_id;

$query ="UPDATE   direct
        SET qnt = '$quantity',
                jumbo = '$jumbo',
                qnt_date = '$qnt_date'
                where  id = '$id'
                    ";
mysqli_query($con, $query);
$query2 ="UPDATE   move
        SET qnt = '$quantity',
                jumbo = '$jumbo'
                where  move_id = '$move_id' AND vessel_id = '$vessel_id'";
      $result = mysqli_query($con, $query2);
    if($result){

    $pusher->trigger('direct', 'report', $data);
    $pusher->trigger('quantity', 'report', $data);
    $pusher->trigger('stats', 'report', $data);
    $pusher->trigger('analysis', 'report', $data);
    $pusher->trigger('live', 'add-vessel', $data);
    
    
    $query =mysqli_query($con,"SELECT * from cars  where vessel_id = '$vessel_id' AND  sn  = '$sn' "); ;
    $row = mysqli_fetch_array($query);
    $car_no = $row['car_no'];
    $car_type = $row['car_type'];
    $car_owner = $row['car_owner'];
    if( $car_type == $car_owner ) $car_owner = '';

    $query =mysqli_query($con,"SELECT SUM(qnt) as qnt  from direct  where vessel_id = '$vessel_id' AND is_delete = 0 AND  qnt  IS NOT NULL "); ;
    $rows = mysqli_fetch_assoc($query);
    $qnt= $rows["qnt"];

    $query =mysqli_query($con,"SELECT COUNT(*) as count from direct  where vessel_id = '$vessel_id' AND is_delete = 0 AND  qnt_date   is not null "); ;
    $rows2 = mysqli_fetch_assoc($query);
    $moves= $rows2["count"];

$message1= 'تم إضافة وزن : '.$quantity.' طن ';
	$message1.= "\r\n";
	$message1.= 'لـ'.$car_type
	. '  رقم '.$car_no
	.' كود '.$sn.'   '.$car_owner;
	$message1.= "\r\n";
  $message1.= "\r\n";
    $message1.='*إجمالي الكميه الآن*: '. number_format((float)$qnt, 3, '.', ''). ' طن ، لعدد ' 
    .$moves. ' نقلة ';
    $message1.= "\r\n";
    $message1.= "*(كصرف )*";
    $message1.= "\r\n";


  $message2= 'تم إضافة وزن : '.$quantity.' طن ';
	$message2.= "\r\n";
  $message2.= "\r\n";
  $message2.='*كمية الصرف الآن* : ';
  $message2.=  number_format((float)$qnt, 3, '.', ''). ' طن '. ' / '.$moves. '  نقله   '; 
  $message2.= "\r\n";
  $message2.= "\r\n";
	
    $message3='';

    require "../../telegram.php";
    send($vessel_id ,$message1, 'unloading', false);
    send($vessel_id ,$message2, 'ceo', false);
    send($vessel_id ,$message3, 'ceo', true);
    //send($vessel_id ,$message1, 'client', false);

  echo json_encode(array('success' => 1));
    
}else return http_response_code(422); 
?>