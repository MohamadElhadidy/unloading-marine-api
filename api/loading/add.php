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
$room_no = $_POST['room1'];
$hobar = $_POST['hobar1'];
$kbsh = $_POST['kbash1'];
$crane = $_POST['cran1'];
$ename = $_POST['oname1']; 
$notes = $_POST['notes1']; 

$id = $param[0];
$load_date = date("Y-m-d H:i:s");
$move_id=1;

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
    $move_id = $vessel_id.'0000';
}
if($move_id !=1){

      //insert loading
      $query ="INSERT INTO loading (vessel_id,sn,type, hobar,kbsh,room_no, ename,notes,move_id,crane, date) VALUES 
      ('$vessel_id', '$sn', '$type', '$hobar', '$kbsh', '$room_no', '$ename', '$notes', '$move_id', '$crane', '$load_date')";
      mysqli_query($con, $query);

    //insert move
    $query2 ="INSERT INTO move (vessel_id,sn,type, hobar ,kbsh, room_no, move_id, crane, loading, load_date)
      VALUES ('$vessel_id', '$sn', '$type', '$hobar', '$kbsh', '$room_no', '$move_id', '$crane', '1', '$load_date') ";
    mysqli_query($con, $query2);

    $pusher->trigger('travel', 'report', $data);
    $pusher->trigger('quantity', 'report', $data);
    $pusher->trigger('loading', 'report', $data);
    $pusher->trigger('stats', 'report', $data);
    $pusher->trigger('analysis', 'report', $data);

   
                $query =mysqli_query($con,"SELECT  count(*) as count from move where   vessel_id = '$vessel_id' AND arrival =1  AND move_type = 'normal'  "); ;
            $counts = mysqli_fetch_assoc($query);
            $normal_moves = $counts['count'];

              $query =mysqli_query($con,"SELECT  count(*) as count from move where   vessel_id = '$vessel_id'   AND move_type = 'normal'  "); ;
            $counts = mysqli_fetch_assoc($query);
            $moves = $counts['count'];


             $query =mysqli_query($con,"SELECT  count(*) as count from move where   vessel_id = '$vessel_id' AND arrival =1  AND move_type = 'direct'  "); ;
            $counts = mysqli_fetch_assoc($query);
            $direct_moves = $counts['count'];
     
    $query =mysqli_query($con,"SELECT * from cars  where vessel_id = '$vessel_id' AND  sn  = '$sn' "); ;
    $row2 = mysqli_fetch_array($query);
    $car_no = $row2['car_no'];
    $car_type = $row2['car_type'];
    $car_owner = $row2['car_owner'];
    if( $car_type == $car_owner ) $car_owner = '';

      if( $hobar == 'بدون هوابر' ) $hobar = '';
      if( $kbsh == 'بدون كباشات أوناش' ) $kbsh = '';
      if( $crane == 'بدون أوناش' ) $crane = '';

            
    $message1= '<<  تم تحميل  '.$car_type.' رقم '.$car_no.' كود '.$sn.' '.$car_owner.' '.$room_no.' '.$hobar.' '.$crane.' '.$kbsh.' '.$type.'  على الرصيف ' .  ' - ' .$ename ;
    $message1.= "\r\n";
    $message1.= "*(كتخزين )*";
    $message1.= "\r\n";
    $message1.= 'وقت التحميل  : '.$load_date;
    $message1.= "\r\n";
    $message1.=' عدد النقلات التي تم تحميلها كتخزين الآن : ' .$moves. ' نقله ';
	  $message1.= "\r\n";

            require "../../telegram.php";
            // send($vessel_id ,$message1, 'it', false);
            send($vessel_id ,$message1, 'unloading', false);

    echo json_encode(array('car_no' => $row["car_no"]));

}
else return http_response_code(422);