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
    $columnName = " arrival.qnt_date"; 
}else{
    $columnName = " arrival.".$_POST['columns'][$columnIndex]['data']; // Column name
}
$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
$searchValue = mysqli_real_escape_string($con,$_POST['search']['value']); // Search value


## Search 
$searchQuery = 1;
if($searchValue != ''){
$searchQuery = " (arrival.type like '%".$searchValue."%' or 
        arrival.sn like'%".$searchValue."%' or
        cars.car_no like'%".$searchValue."%' or
        arrival.qnt like'%".$searchValue."%' or
        arrival.store_no like'%".$searchValue."%' or
        arrival.date like'%".$searchValue."%' or
        arrival.jumbo like'%".$searchValue."%' or
        arrival.ename like'%".$searchValue."%' or
        arrival.notes like'%".$searchValue."%' ) ";
}

## Total number of records without filtering

$sel = "SELECT count(*) as allcount FROM arrival LEFT JOIN cars ON arrival.sn=cars.sn AND cars.vessel_id = $vessel_id  WHERE arrival.vessel_id= $vessel_id ";

$Records = mysqli_query($con, $sel);
$records = mysqli_fetch_assoc($Records);
$totalRecords = $records['allcount'];





## Total number of record with filtering
$sel = "SELECT count(*) as allcount FROM arrival LEFT JOIN cars ON arrival.sn=cars.sn AND cars.vessel_id = $vessel_id  WHERE arrival.vessel_id= $vessel_id AND   $searchQuery ";

$Records = mysqli_query($con, $sel);
$records = mysqli_fetch_assoc($Records);
$totalRecordwithFilter = $records['allcount'];

## Fetch records


//$empQuery = "SELECT * FROM arrival where  vessel_id = '$vessel_id' ;    
$empQuery = "SELECT *, arrival.id as arrival_id, arrival.type as type, arrival.qnt as arrival_qnt FROM arrival LEFT JOIN cars ON arrival.sn=cars.sn AND cars.vessel_id = $vessel_id  WHERE arrival.vessel_id= $vessel_id AND   $searchQuery order by    $columnName $columnSortOrder  $rowLength ";
$empRecords = mysqli_query($con, $empQuery);

$data = array();

while ($row = mysqli_fetch_assoc($empRecords)) {

   $id= $row['arrival_id'];
   $qnt= $row['arrival_qnt'];
   if($row['qnt_date'] == null) $color = 'red';
   else $color = 'black';

   $data[] = array( 
      "sn"=> $row['sn'],
      "edit"=>'<a  class="btn btn-primary" style="font-size: 1rem !important;padding: 2px 2px;" href="update_quantity.php?id='.$id.' ">تعديل</a>',
      "car_no"=>'<p style= "color: blue;font-size: .7rem;">'.$row['car_no'].'</p>',
      "date"=>$row['date'],
      "qnt"=>'<p style= "color:'.$color.'; font-size: .8rem;">'.$qnt.'</p>',
      "type"=>$row['type'],
      "store_no"=>$row['store_no'],
      "jumbo"=>$row['jumbo'],
      "ename"=>$row['ename'],
      "notes"=>$row['notes'],
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