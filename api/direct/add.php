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

$param = explode('|', urldecode($_POST['v']));
$id = $param[0];
$car_no = $_POST['carno'];
$carn2 = $_POST['carn2'];
$str12 = $_POST['carl2'];
$car_owner =trim($_POST['mok']);
$car_driver =trim($_POST['name']);


$str22 = preg_replace('/\s\s+/u', ' ', $str12);
$str32=  preg_replace('//u', ' ', $str22);
$str42 = preg_replace('/\s+/', ' ', $str32);
$car_l2 =trim($str42);
$car_no2 =$carn2.' '.$car_l2 ;

$type = $_POST['type1'];
$room_no = $_POST['room1'];
$hobar = $_POST['hobar1'];
$kbsh = $_POST['kbash1'];
$crane = $_POST['cran1'];
$ename = $_POST['oname1']; 
$notes = $_POST['notes1']; 
$custom = $_POST['custom1']; 

$load_date = date("Y-m-d H:i:s");
$move_id=1;
$sn = 1 ;

$result = mysqli_query($con,"SELECT *  FROM vessels_log   where id = '$id' AND done = 0 ");
$row = mysqli_fetch_assoc($result);
$vessel_id = $row['vessel_id']; 
$data['message'] = $vessel_id;

if(empty($notes))$notes="-";

//select move_id
$sql = "select * from move where vessel_id = '$vessel_id'   ORDER BY move_id  DESC LIMIT 1";
$result = mysqli_query($con,$sql);
if(mysqli_num_rows($result)  > 0 ){
        $row = mysqli_fetch_assoc($result);
        $move_id +=$row['move_id']; 
}else {
    $move_id = $vessel_id.'00000';
}
$sql = "select * from cars where vessel_id = '$vessel_id'   AND  type = 'direct'  ORDER BY id  DESC LIMIT 1";
$result = mysqli_query($con,$sql);
if(mysqli_num_rows($result)  > 0 ){
        $row = mysqli_fetch_assoc($result);
        $sn +=$row['sn']; 
}

$sql = "select * from cars where vessel_id = '$vessel_id'  AND car_no = '$car_no'  ";
$result = mysqli_query($con,$sql);
if(mysqli_num_rows($result)  > 0 ){
     $row = mysqli_fetch_assoc($result);
        $sn =$row['sn'];
}




if($move_id !=1){

$sql = "select * from cars where vessel_id = '$vessel_id'  AND car_no = '$car_no'  ";
$result = mysqli_query($con,$sql);
if(mysqli_num_rows($result)  == 0 ){
         //insert car 
      $query ="INSERT INTO cars (vessel_id, sn, car_no, car_no2, car_owner, car_driver, start_date,done, type )
        VALUES ('$vessel_id' , '$sn',  '$car_no', '$car_no2', '$car_owner', '$car_driver',  '$load_date', '1', 'direct')";
          mysqli_query($con, $query);
}


      //insert direct
      $query ="INSERT INTO direct (vessel_id,sn,type, hobar,kbsh,room_no, ename,notes,move_id,crane, custom, date) VALUES 
      ('$vessel_id', '$sn', '$type', '$hobar', '$kbsh', '$room_no', '$ename', '$notes', '$move_id', '$crane',  '$custom',  '$load_date')";
      mysqli_query($con, $query);

    //insert move
    $query2 ="INSERT INTO move (vessel_id,sn,type, hobar ,kbsh, room_no, move_id, crane, loading, arrival, load_date, arrival_date, move_type)
      VALUES ('$vessel_id', '$sn', '$type', '$hobar', '$kbsh', '$room_no', '$move_id', '$crane',   '1', '1', '$load_date', '$load_date', 'direct') ";
    mysqli_query($con, $query2);

    $pusher->trigger('travel', 'report', $data);
    $pusher->trigger('quantity', 'report', $data);
    $pusher->trigger('direct', 'report', $data);
    $pusher->trigger('stats', 'report', $data);
    $pusher->trigger('analysis', 'report', $data);
    $pusher->trigger('live', 'add-vessel', $data);
    
            $query =mysqli_query($con,"SELECT  count(*) as count , SUM(qnt) as total from move where   vessel_id = '$vessel_id' AND arrival =1 AND is_delete = 0 AND move_type = 'normal'  "); ;
            $counts = mysqli_fetch_assoc($query);
            $normal_moves = $counts['count'];
            $normal_qnt =number_format((float)$counts['total'], 3, '.', '');


             $query =mysqli_query($con,"SELECT  count(*) as count, SUM(qnt) as total  from move where   vessel_id = '$vessel_id' AND arrival =1 AND is_delete = 0 AND move_type = 'direct'  "); ;
            $counts = mysqli_fetch_assoc($query);
            $direct_moves = $counts['count'];
            $direct_qnt =number_format((float)$counts['total'], 3, '.', '');

    $query =mysqli_query($con,"SELECT * from cars  where vessel_id = '$vessel_id' AND  car_no  = '$car_no' "); ;
    $row2 = mysqli_fetch_array($query);
    $car_type = $row2['car_type'];
    $car_owner = $row2['car_owner'];
    if( $car_type == $car_owner ) $car_owner = '';

     if( $hobar == 'بدون هوابر' ) $hobar = '';
      if( $kbsh == 'بدون كباشات أوناش' ) $kbsh = '';
      if( $crane == 'بدون أوناش' ) $crane = '';

            
    $message1= '<<  تم تحميل  سيارة'.$car_type.' رقم '.$car_no.' '.$car_owner.' '.$room_no.' '.$hobar.' '.$crane.' '.$kbsh.' '.$type.' على الرصيف ' .  ' - ' .$ename;
    $message1.= "\r\n";
    $message1.= "*(كصرف مباشر)*";
    $message1.= "\r\n";
    $message1.= 'وقت التحميل  : '.$load_date;
    $message1.= "\r\n";
    $message1.=' عدد نقلات الصرف المباشر  الآن : ' .$direct_moves. ' نقله ';
	  $message1.= "\r\n";


    if($normal_moves != 0){
    $message2='*متوسط كمية التخزين الآن* : ';
    $message2.= "\r\n";
    $message2.= $normal_qnt. ' طن '. '  /  '. $normal_moves. '  نقله   '; 
    $message2.= "\r\n";
    $message2.= "\r\n";

    }
      if($direct_moves != 0){
    $message2.='*متوسط كمية الصرف الآن* : ';
    $message2.= "\r\n";
    $message2.= $direct_qnt. ' طن '. '  /  '. $direct_moves. '  نقله   '; 
    $message2.= "\r\n";
    $message2.= "\r\n";
    }
    
    $message3='';

            require "../../telegram.php";
            send($vessel_id ,$message1, 'unloading', false);
            send($vessel_id ,$message2, 'ceo', false);
            send($vessel_id ,$message3, 'ceo', true);
            //send($vessel_id ,$message2, 'client', false);


    echo json_encode(array('car_no' => $row["car_no"]));

}
else return http_response_code(422);