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
if($columnIndex == 1){
    $columnName = " cars.".$_POST['columns'][$columnIndex]['data']; }
else{
    $columnName = " loading.".$_POST['columns'][$columnIndex]['data']; // Column name
}
$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
$searchValue = mysqli_real_escape_string($con,$_POST['search']['value']); // Search value


## Search 
$searchQuery = 1;
if($searchValue != ''){
   $searchQuery = " (loading.type like '%".$searchValue."%' or 
        loading.sn like'%".$searchValue."%' or
        cars.car_no like'%".$searchValue."%' or
        loading.hobar like'%".$searchValue."%' or
        loading.kbsh like'%".$searchValue."%' or
        loading.date like'%".$searchValue."%' or
        loading.crane like'%".$searchValue."%' or
        loading.ename like'%".$searchValue."%' or
        loading.room_no like'%".$searchValue."%' ) ";
}

## Total number of records without filtering

$sel = "SELECT count(*) as allcount FROM loading LEFT JOIN cars ON loading.sn=cars.sn AND cars.vessel_id = $vessel_id  WHERE loading.vessel_id= $vessel_id ";

$Records = mysqli_query($con, $sel);
$records = mysqli_fetch_assoc($Records);
$totalRecords = $records['allcount'];





## Total number of record with filtering
$sel = "SELECT count(*) as allcount FROM loading LEFT JOIN cars ON loading.sn=cars.sn AND cars.vessel_id = $vessel_id  WHERE loading.vessel_id= $vessel_id AND   $searchQuery ";

$Records = mysqli_query($con, $sel);
$records = mysqli_fetch_assoc($Records);
$totalRecordwithFilter = $records['allcount'];

## Fetch records


//$empQuery = "SELECT * FROM loading where  vessel_id = '$vessel_id' ;    
$empQuery = "SELECT *, loading.type as loading_type FROM loading LEFT JOIN cars ON loading.sn=cars.sn AND cars.vessel_id = $vessel_id  WHERE loading.vessel_id= $vessel_id AND   $searchQuery order by  $columnName $columnSortOrder  $rowLength ";
$empRecords = mysqli_query($con, $empQuery);

$data = array();

while ($row = mysqli_fetch_assoc($empRecords)) {

$loading_type= $row['loading_type'];


   $data[] = array( 
      "sn"=> $row['sn'],
      "car_no"=>$row['car_no'],
      "date"=>$row['date'],
      "type"=>$loading_type,
      "room_no"=>$row['room_no'],
      "hobar"=>$row['hobar'],
      "kbsh"=>$row['kbsh'],
      "crane"=>$row['crane'],
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