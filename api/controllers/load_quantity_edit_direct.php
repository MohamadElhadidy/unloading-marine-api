<?php

// database connection
require "../../config.php";


$vessel_id = $_POST["vessel_id"];

## Read value
$draw = $_POST['draw'];
$row = $_POST['start'];
$rowperpage = $_POST['length']; // Rows display per page
$rowLength = '';
if($rowperpage  == -1)$rowLength = '';
else $rowLength = "limit ".$row.",".$rowperpage;
$columnIndex = $_POST['order'][0]['column']; // Column index
if($columnIndex == 2){
    $columnName = " cars.".$_POST['columns'][$columnIndex]['data']; 
}elseif($columnIndex == 1){
    $columnName = " direct.qnt_date"; 
}else{
    $columnName = " direct.".$_POST['columns'][$columnIndex]['data']; // Column name
}
$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
$searchValue = mysqli_real_escape_string($con,$_POST['search']['value']); // Search value


## Search 
$searchQuery = 1;
if($searchValue != ''){
$searchQuery = " (direct.type like '%".$searchValue."%' or 
        direct.sn like'%".$searchValue."%' or
        cars.car_no like'%".$searchValue."%' or
        direct.qnt like'%".$searchValue."%' or
        direct.date like'%".$searchValue."%' or
        direct.jumbo like'%".$searchValue."%' or
        direct.room_no like'%".$searchValue."%' or
        direct.kbsh like'%".$searchValue."%' or
        direct.crane like'%".$searchValue."%' or
        direct.hobar like'%".$searchValue."%' or
        direct.custom like'%".$searchValue."%' or
        direct.ename like'%".$searchValue."%' or
        direct.notes like'%".$searchValue."%' ) ";
}

## Total number of records without filtering

$sel = "SELECT count(*) as allcount FROM direct LEFT JOIN cars ON direct.sn=cars.sn AND cars.vessel_id = $vessel_id   WHERE direct.vessel_id= $vessel_id  AND is_delete = 0";

$Records = mysqli_query($con, $sel);
$records = mysqli_fetch_assoc($Records);
$totalRecords = $records['allcount'];





## Total number of record with filtering
$sel = "SELECT count(*) as allcount FROM direct LEFT JOIN cars ON direct.sn=cars.sn AND cars.vessel_id = $vessel_id  WHERE direct.vessel_id= $vessel_id  AND is_delete = 0 AND   $searchQuery ";

$Records = mysqli_query($con, $sel);
$records = mysqli_fetch_assoc($Records);
$totalRecordwithFilter = $records['allcount'];

## Fetch records


//$empQuery = "SELECT * FROM direct where  vessel_id = '$vessel_id' ;    
$empQuery = "SELECT *, direct.id as direct_id, direct.type as type, direct.qnt as direct_qnt FROM direct LEFT JOIN cars ON direct.sn=cars.sn AND cars.vessel_id = $vessel_id  WHERE direct.vessel_id= $vessel_id  AND is_delete = 0 AND   $searchQuery order by    $columnName $columnSortOrder  $rowLength ";
$empRecords = mysqli_query($con, $empQuery);

$data = array();

while ($row = mysqli_fetch_assoc($empRecords)) {

   $id= $row['direct_id'];
   $qnt= $row['direct_qnt'];
   if($row['qnt_date'] == null) $color = 'red';
   else $color = 'black';

   $data[] = array( 
      "sn"=> $row['sn'],
      "edit"=>'<a  class="btn btn-primary" style="font-size: 1rem !important;padding: 2px 2px;" href="update_quantity.php?id='.$id.' ">تعديل</a>',
      "car_no"=>'<p style= "color: blue;font-size: .7rem;">'.$row['car_no'].'</p>',
      "date"=>$row['date'],
      "qnt"=>'<p style= "color:'.$color.'; font-size: .8rem;">'.$qnt.'</p>',
      "type"=>$row['type'],
      "room_no"=>$row['room_no'],
      "jumbo"=>$row['jumbo'],
      "ename"=>$row['ename'],
      "notes"=>$row['notes'],
      "kbsh"=>$row['kbsh'],
      "crane"=>$row['crane'],
      "hobar"=>$row['hobar'],
      "custom"=>$row['custom'],
   );
}

## Response
$response = array(
  "draw" => intval($draw),
  "iTotalRecords" => $totalRecords,
  "iTotalDisplayRecords" => $totalRecordwithFilter,
  "aaData" => $data
);

echo json_encode($response);

?>