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


$sn = $_POST['sn1'];
$param = explode('|', urldecode($_POST['v']));
$type = $_POST['type1'];
$store_no = $_POST['store_no1'];
$qnt = $_POST['qnt1'];
$jumbo = $_POST['jumbo1'];
$ename = $_POST['oname1']; 
$notes = $_POST['notes1']; 
$move_id = '';

$id = $param[0];
$arrival_date = date("Y-m-d H:i:s");

$result = mysqli_query($con,"SELECT *  FROM vessels_log   where id = '$id' AND done = 0 ");
$row = mysqli_fetch_assoc($result);
$vessel_id = $row['vessel_id']; 
$data['message'] = $vessel_id;

if(empty($notes))$notes="-";

//select move_id
$result1 = mysqli_query($con, "SELECT * FROM move WHERE sn = '$sn'  AND vessel_id = '$vessel_id'  AND  arrival = 0");
$row = mysqli_fetch_assoc($result1);
$move_id = $row['move_id']; 
$load_date = $row['load_date'];   


//assign vessel_start_date
$result2 = mysqli_query($con, "SELECT * FROM  arrival where vessel_id = '$vessel_id' " );
if(mysqli_num_rows($result2) == 0)  mysqli_query($con,"UPDATE vessels_log SET start_date = '$arrival_date' Where vessel_id = '$vessel_id'");

if($move_id != ''){
      //insert arrival 
    $result3 = mysqli_query($con, "INSERT INTO arrival (vessel_id,sn,type, store_no,qnt,jumbo, ename,notes,move_id, date) VALUES 
      ('$vessel_id' ,'$sn','$type', '$store_no','$qnt','$jumbo', '$ename','$notes','$move_id', '$arrival_date')");
      if($result3){
        //update move
        mysqli_query($con, "UPDATE move  
            SET arrival = 1,
            store_no = '$store_no',
            jumbo = '$jumbo',
            qnt = '$qnt',
            arrival_date = '$arrival_date'
            Where move_id = '$move_id' AND sn = '$sn'  AND vessel_id = '$vessel_id'");

            $pusher->trigger('travel', 'report', $data);
            $pusher->trigger('arrival', 'report', $data);
            $pusher->trigger('stats', 'report', $data);
            $pusher->trigger('analysis', 'report', $data);
            $pusher->trigger('live', 'add-vessel', $data);
            
            $date1 =strtotime($load_date); 
            $date2 =strtotime($arrival_date);
            $diff =  $date2  - $date1;
            $h = $diff / 3600 % 24;
            $m = $diff / 60 % 60; 
            if($h == 0) $hour = ''; else $hour=$h." "."ساعة";
            if($m == 0) $minute = ''; else $minute=$m." "."دقيقة";
            $time_now=$minute." ".$hour;

            $query =mysqli_query($con,"SELECT * from cars  where vessel_id = '$vessel_id' AND  sn  = '$sn' "); ;
            $row = mysqli_fetch_array($query);
            $car_no = $row['car_no'];
            $car_type = $row['car_type'];
            $car_owner = $row['car_owner'];
            if( $car_type == $car_owner ) $car_owner = '';

            $query =mysqli_query($con,"SELECT  count(*) as count , SUM(qnt) as total from move where   vessel_id = '$vessel_id' AND arrival =1 AND is_delete = 0 AND move_type = 'normal'  "); ;
            $counts = mysqli_fetch_assoc($query);
            $normal_moves = $counts['count'];
            $normal_qnt =number_format((float)$counts['total'], 3, '.', '');

            $query =mysqli_query($con,"SELECT  count(*) as count from move where   vessel_id = '$vessel_id'  AND arrival =1 AND   sn  = '$sn' AND is_delete = 0  "); ;
            $nums = mysqli_fetch_assoc($query);
            $num = $nums['count'];

            $query =mysqli_query($con,"SELECT  count(*) as count, SUM(qnt) as total  from move where   vessel_id = '$vessel_id' AND arrival =1 AND is_delete = 0 AND move_type = 'direct'  "); ;
            $counts = mysqli_fetch_assoc($query);
            $direct_moves = $counts['count'];
            $direct_qnt =number_format((float)$counts['total'], 3, '.', '');

            $message1= '>>   تم تعتيق '.$car_type.' رقم '.$car_no.' كود '.$sn.' '.$car_owner.' '.$type.' ' .$store_no .  ' - ' .''.$ename.'';
            $message1.= "\r\n";
            $message1.= "\r\n";
            $message1.= 'وقت التعتيق  : '.$arrival_date;
            $message1.= "\r\n";
            $message1.= 'مدة الرحلة : '.$time_now;
            $message1.= "\r\n"; 
            $message1.= ' *متوسط النقلة* : '.$qnt. ' طن  ';
            $message1.= "\r\n";
            $message1.=' عدد نقلات السيارة النقل الآن : ' .$num. ' نقله ';
            $message1.= "\r\n";
            $message1.= "\r\n";
            $message1.=' عدد نقلات التخزين الآن : ' .$normal_moves. ' نقله ';
	          $message1.= "\r\n";
            $message1.='*متوسط كمية التخزين الآن* : ';
            $message1.= "\r\n";
            $message1.= $normal_qnt. ' طن ';
	          $message1.= "\r\n";
    

    
    $message2.= ' *تم إضافة وزن* : '.$qnt. ' طن  ';
    $message2.= "\r\n";
    $message2.= "\r\n";
    $message2='*متوسط كمية التخزين الآن* : ';
    $message2.= "\r\n";
    $message2.= $normal_qnt. ' طن '. '  /  '. $normal_moves. '  نقله   '; 
    $message2.= "\r\n";
    $message2.= "\r\n";

    
     
    
    $message3='';
    
            require "../../telegram.php";
            send($vessel_id ,$message1, 'unloading', false);
            send($vessel_id ,$message2, 'ceo', false);
            send($vessel_id ,$message3, 'ceo', true);
            //send($vessel_id ,$message1, 'shipping', false);
    }
}