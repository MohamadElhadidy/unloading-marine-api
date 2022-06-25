<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الإحصائيات</title>
    <style>
    body {
        direction: rtl;
        text-align: center;
        line-height: 1;
    }

    .header th,
    td {
        border: 1px solid #424242;
    }

    ::placeholder {
        color: blue;
        text-align: center;
    }

    table {
        border-collapse: collapse;
        width: 95vw;
    }

    th,
    td {
        text-align: center;
        padding: 3px;
    }


    th {
        background-color: #ffffff;
        border: 1px solid #424242;
        color: #000000;
    }

    table tbody {
        Background-color: #fff;
        color: #000;
        font-weight: bold;

    }

    tr:nth-child(even) {
        background-color: #979797
    }

    tr {
        border-bottom: 0px;
    }

    .header th {
        background-color: #f1ffee26;
        color: black;
    }

    .header td {
        color: red;
    }

    .clock th {
        font-weight: bold;
        color: green;
        background-color: #ee82ee;
    }
    </style>
</head>

<body>

</body>

</html>
<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
$vessel_id=$_GET["vessel_id"];
require '../../config.php';
$outputa = '';
$outputb = '';
$outputc = '';
$outputf = '';
$outputff = '';
$output1= '';
$output2= '';
$output3= '';
$output4= '';
$output5= '';
$output6= '';
$output8= '';
$output00 = '';

$colors =['#0a8fdb','#ff8000','#0a8fdb','#0a8fdb','#0a8fdb','#0a8fdb'];

$query1 ="select * from vessels_log  WHERE vessel_id = '$vessel_id'  ";
$result1 = mysqli_query($con, $query1);

if (mysqli_num_rows($result1) > 0) {
    $row1 = mysqli_fetch_assoc($result1);
    $vessel = $row1["name"];
    $type =$row1["type"];
    $quay =$row1["quay"];
    $client =$row1["client"];
    $start_date =$row1["start_date"];
    $qnt =$row1["qnt"];
    $done=$row1["done"];
}
if($done == 0)$search =" done = 0 AND";else $search ="";


$query8 ="select count(*) as count from cars where done =0 AND  vessel_id = '$vessel_id'  ";
$result8 = mysqli_query($con, $query8);

if(mysqli_num_rows($result8) > 0) {
    $row8= mysqli_fetch_assoc($result8);
    $count7 = $row8['count'];
}

$query8 ="select count(*) as count from cars where   vessel_id = '$vessel_id'    ";
$result8 = mysqli_query($con, $query8);

if(mysqli_num_rows($result8) > 0) {
    $row8= mysqli_fetch_assoc($result8);
    $count2 = $row8['count'];
}





$count_1= 0;
$query2 ="select count(*) as count from cars where done = '0'  AND  vessel_id = '$vessel_id'   AND type =  'normal'   GROUP BY  car_no ";
$result2 = mysqli_query($con, $query2);

 while ($row2 = mysqli_fetch_assoc($result2)) {
         $count_1++;
        }

$count3=0;
$query8 ="select  * from cars where   vessel_id = '$vessel_id'   AND type =  'normal' GROUP BY  car_no  ";
$result8 = mysqli_query($con, $query8);

        while ($row8 = mysqli_fetch_assoc($result8)) {
         $count3++;
        }

        $count_3=0;
$query8 ="select  * from cars where   vessel_id = '$vessel_id'   AND type =  'direct' GROUP BY  car_no  ";
$result8 = mysqli_query($con, $query8);

        while ($row8 = mysqli_fetch_assoc($result8)) {
         $count_3++;
        }
$query3 ="select count(*) as count from move where  arrival = 1 AND vessel_id = '$vessel_id'";
$result3 = mysqli_query($con, $query3);

if(mysqli_num_rows($result3) > 0) {
    $row3 = mysqli_fetch_assoc($result3);
    $count0 = $row3['count'];
}


$count4=0;
$query33 ="select * from cars where vessel_id = '$vessel_id' AND  $search car_type='سيارة الشركة'   AND type =  'normal' GROUP BY car_no";
$result33 = mysqli_query($con, $query33);
 while (mysqli_fetch_assoc($result33)) {
         $count4++;
        }
$count5=0;
$query44 ="select * from cars where  $search  vessel_id = '$vessel_id' AND  car_type='سيارة قلاب'   AND type =  'normal'  GROUP BY car_no";  
$result44 = mysqli_query($con, $query44);

 while (mysqli_fetch_assoc($result44)) {
         $count5++;
        }
$count6=0;
$query3 ="select * from cars where   vessel_id = '$vessel_id' AND $search car_type='سيارة توكتوك'   AND type =  'normal'  GROUP BY car_no";
$result3 = mysqli_query($con, $query3);

while (mysqli_fetch_assoc($result3)) {
         $count6++;
        }
$count7=0;
$query11 ="select * from cars where   vessel_id = '$vessel_id' AND $search car_type='سيارة جرار'   AND type =  'normal'  GROUP BY car_no";
$result11 = mysqli_query($con, $query11);

while (mysqli_fetch_assoc($result11)) {
         $count7++;
        }


        
        //time
$query4 = "SELECT * FROM arrival where  vessel_id = '$vessel_id'  AND is_delete = 0 order by id asc LIMIT 1";
$result4 = mysqli_query($con, $query4);

$query44 = "SELECT * FROM direct where  vessel_id = '$vessel_id'  AND is_delete = 0 order by id asc LIMIT 1";
$result44 = mysqli_query($con, $query44);

if(mysqli_num_rows($result4) == 0 AND mysqli_num_rows($result44) == 0){
    $day=0;
    $hour=0;
    $minute=0;
}
else{

if(mysqli_num_rows($result4) > 0) {
    $row4= mysqli_fetch_assoc($result4);
    $date= $row4['date'];
    $normal_date =strtotime($date);
}

if(mysqli_num_rows($result44) > 0) {
    $row44= mysqli_fetch_assoc($result44);
    $date= $row44['date'];
    $direct_date =strtotime($date);
}
if($normal_date == NULL) $normal_date = 999999*9999999*999999;
if($direct_date == NULL) $direct_date = 999999*9999999*999999;

if($normal_date > $direct_date){
    if($done == 1){
    $result66 = mysqli_query($con, "SELECT * FROM direct where  vessel_id = '$vessel_id'  AND is_delete = 0 order by id desc LIMIT 1");
    $row66= mysqli_fetch_assoc($result66);
    $date= $row66['date'];
    $current_time =strtotime($date);

    }else{
    $current_time = strtotime(date("Y-m-d H:i:s"));
    }

    $diff =  $current_time - $direct_date;
}else{
    if($done == 1){
        $result66 = mysqli_query($con, "SELECT * FROM arrival where  vessel_id = '$vessel_id'  AND is_delete = 0 order by id desc LIMIT 1");
        $row66= mysqli_fetch_assoc($result66);
        $date= $row66['date'];
        $current_time =strtotime($date);

    }else{
        $current_time = strtotime(date("Y-m-d H:i:s"));
    }
        $diff =  $current_time -$normal_date;
}
    $d = $diff / 86400;
    if($d > 7){
        $d =  number_format((float) $d, 0, '.', '');
    }else{
        $d = $diff / 86400 % 7; 
    }
    
    $h = $diff / 3600 % 24;
    $m = $diff / 60 % 60;

    $day=$d * 24;
    //$minute=$m % 60;
    $hour=$h +  $day + $minute;

}

echo' 



	<table  id="customers" >
  <thead>
            <tr>
             <th style="background-color: #808080; color:white; border: 2px solid black;padding: 1px;font-size: 12px;"> اسم الباخره  </th>
                <th style="background-color: #808080; color:white; border: 2px solid black;padding: 1px;font-size: 12px;">رقم الرصيف  </th>
                   <th style="background-color: #808080; color:white; border: 2px solid black;padding: 1px;font-size: 12px;"> الصنف</th>
                   <th style="background-color: #808080; color:white; border: 2px solid black;padding: 1px;font-size: 12px;"> الكمية</th>


            </tr>

        </thead>
        
        <tbody>
             <tr>
                <th style="background-color: #FFF8DC;color:#660033; border: 2px solid #000000;padding: 1px;font-size: 12px;">  '.$vessel.'</th>
                <th style="background-color: #FFF8DC;color:#660033; border: 2px solid #000000;padding: 1px;font-size: 12px;"> '.$quay.'</th>
                 <th style="background-color:#FFF8DC;color:#660033; border: 2px solid #000000;padding: 1px;font-size: 12px;">  '.$type.'</th>
             <th style="background-color: #FFF8DC;color:#000000; border: 2px solid #000000;padding: 1px;font-size: 12px;">    <span style="color:#660033;">' . $qnt . '</span> طن</th>

 
            </tr>

        </tbody>
       
        </table>
        ';
     if($count3 !=0){   
echo'   
   	<table  id="customers" style= "margin-bottom:5px;margin-top:5px;">
  
        <tbody>
            <tr>
                <th style="background-color: #FFF8DC;color:#110259; border: 2px solid #000;padding: 1px;font-size:14px;">
                إجمالي السيارات من البدايه
                :  <span style="color:#ff1a1a;">' . $count3 . '</span></th>
                ';
                if($done == 0){
                    echo'
            <th style="background-color: #FFF8DC;color:#110259; border: 2px solid #000;padding: 1px;font-size:14px;">السيارات الحاليه :  <span style="color:green;">' . $count_1 . '</span></
            th>';
                }
if($count6!= 0   ){      
if($count6==0 AND $done ==0)$g=0; else { echo ' 
<th style="background-color: #FFF8DC;color:#110259; border: 2px solid #000;padding: 1px;font-size:14px;">
سـ توكتوك
:  <span style="color:green;">' . $count6 . '</span></th>';
}
}

if($count5!= 0   ){ 
if($count5==0 AND $done ==0)$g=0; else { echo '
<th style="background-color: #FFF8DC;color:#110259; border: 2px solid #000;padding: 1px;font-size:14px;">
سـ قلاب 
:  <span style="color:green;">' . $count5 . '</span></th>';}}
if($count4!=0   ){            
if($count4==0 AND $done ==0)$g=0; else { echo '
<th style="background-color: #FFF8DC;color:#110259; border: 2px solid #000;padding: 1px;font-size:14px;">
سـ شركة 
:  <span style="color:green;">' . $count4 . '</span></th>';}}
if($count7!=0   ){ 
if($count7==0 AND $done ==0)$g=0; else { echo '
<th style="background-color: #FFF8DC;color:#110259; border: 2px solid #000;padding: 1px;font-size:14px;">سـ جرار

:  <span style="color:green;">' . $count7 . '</span></th>';}}

          echo'  </tr>

        </tbody>
        </table>
        ';
}
  if($count_3 !=0){ 
        echo'   
   	<table  id="customers" style= "margin-bottom:5px;margin-top:5px;">
  
        <tbody>
            <tr>
                <th style="background-color: #FFF8DC;color:#110259; border: 2px solid #000;padding: 1px;font-size:14px;">
               عدد سيارات الصرف
                :  <span style="color:#ff1a1a;">' . $count_3 . '</span></th>
                </tr></tbody></table>';

     }

$queryf ="select SUM(qnt) as qnts ,Count(*) as count,  SUM(jumbo) as jumbo from move where arrival = '1'  AND   vessel_id = '$vessel_id'  AND is_delete = 0  AND move_type = 'normal'";
$resultf = mysqli_query($con, $queryf);

    $normal = mysqli_fetch_assoc($resultf);
    $normal_count_all = $normal['count'];
    $normal_qnt = $normal["qnts"];
    $normal_count= $normal['count'];
    $normal_jumbo=$normal['jumbo'];





$queryf ="select SUM(qnt) as qnts ,Count(*) as count,  SUM(jumbo) as jumbo from move where arrival = '1'  AND   vessel_id = '$vessel_id'  AND is_delete = 0  AND move_type = 'direct'";
$resultf = mysqli_query($con, $queryf);

    $direct = mysqli_fetch_assoc($resultf);
    $direct_count_all = $direct['count'];


$queryff ="select SUM(qnt) as qnts ,Count(*) as count,  SUM(jumbo) as jumbo from direct where   vessel_id = '$vessel_id'  AND is_delete = 0 AND  qnt_date IS NOT NULL   ";
$resultff = mysqli_query($con, $queryff);

    $direct2 = mysqli_fetch_assoc($resultff);
    $direct_qnt = $direct2["qnts"];
    $direct_count= $direct2['count'];
    $direct_jumbo=$direct2['jumbo'];

    $all_qnt =  $direct_qnt  + $normal_qnt;
    $all_count= $direct_count  + $normal_count;
    $all_jumbo= $direct_jumbo  + $normal_jumbo;
$outputf.='
        
        		<table  id="customers" style= "margin-bottom:10px;">
  
        <thead>
            <thead>
            <tr>
    
              ';  if($normal_count_all != 0) { $outputf.='
             <th style="background-color: #b35900; color:white; border: 2px solid black;padding: 1px;font-size:12px;">نقلات التخزين</th>
                <th style="background-color: #b35900; color:white; border: 2px solid black;padding: 1px;font-size:12px;"> متوسط كمية التخزين</th>
                <th style="background-color: #b35900; color:white; border: 2px solid black;padding: 1px;font-size:12px;">متوسط النقلة</th>
  ';  }$outputf.='
            </tr>

        </thead>


           <tbody>
            <tr>
           ';  if($normal_count_all != 0) {$outputf.='
                          <th style="background-color: #FFFFFF ;color:black; border: 2px solid black;padding: 1px;font-size:15px;">  <span style="color:blue;">' .$normal_count_all .'  </span>  </th>

                             <th style="background-color: #FFFFFF ;color:black; border: 2px solid black;padding: 1px;font-size:15px;">  <span style="color:red;">' . number_format((float)$normal_qnt, 3, '.', '') .'  </span> 
                             <th style="background-color: #FFFFFF ;color:black; border: 2px solid black;padding: 1px;font-size:15px;">  <span style="color:red;">' . number_format((float)$normal_qnt / $normal_count_all, 3, '.', '') .'  </span> 
             </th>
              ';  }$outputf.='
            </tr>

        </tbody>
        </table>
        ';
        $outputf.='
        
        		<table  id="customers" style= "margin-bottom:10px;">
  
        <thead>
            <thead>
            <tr>
             ';  if($direct_count_all != 0) { $outputf.='
             <th style="background-color: #b35900; color:white; border: 2px solid black;padding: 1px;font-size:12px;">نقلات الصرف</th>
             <th style="background-color: #b35900; color:white; border: 2px solid black;padding: 1px;font-size:12px;">رصيد الصرف</th>
              ';  }$outputf.='
            </tr>

        </thead>


           <tbody>
            <tr>
            ';  if($direct_count_all != 0) {$outputf.='
              <th style="background-color: #FFFFFF ;color:black; border: 2px solid black;padding: 1px;font-size:16px;">  <span style="color:blue;">' .$direct_count_all .'  </span>  </th>
              <th style="background-color: #FFFFFF ;color:black; border: 2px solid black;padding: 1px;font-size:16px;">  <span style="color:red;">(' . number_format((float)$direct_qnt, 3, '.', '') .' ) </span> 
             <span style="font-size: 16px;color:blue;">  ( '.$direct_count.'  )</span>';  if($direct_jumbo != 0 ) {$outputf.='<span style="font-size: 16px;color:green;">  ( '.$direct_jumbo .') </span>';} $outputf.='</th>
              ';  }$outputf.='
                         
            </tr>

        </tbody>
        </table>
        ';

        $outputf.='
        
        		<table  id="customers" style= "margin-bottom:10px;">
  
        <thead>
            <thead>
            <tr>
  ';  if($all_count != 0) { $outputf.='
                   <th style="background-color: #420547; color:white; border: 2px solid black;padding: 1px;font-size:15px;"> الرصيد الآن (متوسط)</th>

  ';  }$outputf.='
            </tr>

        </thead>


           <tbody>
            <tr>
   ';  if($all_count != 0) {$outputf.='
              <th style="background-color: #FFFFFF ;color:black; border: 2px solid black;padding: 1px;font-size:16px;">  <span style="color:red;">(' . number_format((float)$all_qnt, 3, '.', '') .' ) </span> 
             <span style="font-size: 16px;color:blue;">  ( '.$all_count .'  )</span> ';  if($all_jumbo != 0 ) {echo'<span style="font-size: 16px;color:green;">  ( '.$all_jumbo .') </span>';} $outputf.='</th>
              ';  }echo'
            </tr>

        </tbody>
        </table>
        ';
echo'
<table  id="customers" style= "margin-bottom:5px;margin-top:5px;">
  
        <tbody>
              <tr>
                <th style="background-color: #fff5e6;color:#000000;"> مدة التشغيل</th>';      if($hour != 0){
                 echo'
                                <th style="background-color: #fff5e6;color:#000000;"><span style="color:green;">'.$hour.'  ساعة  </span> </th>'; }
                                 echo'                
            </tr>
        </tbody>
        </table>
        ';


$output0='<div class="row"><div class="col-lg-4">';
$query1 ="select * from  move where arrival = '1'  AND  vessel_id = '$vessel_id'  AND is_delete = 0 AND hobar != 'بدون هوابر' GROUP BY hobar";
$result1 = mysqli_query($con, $query1);
$i=0;
$output1 .= '

        	<table  id="customers" style= "margin-bottom:5px;">
  
        <thead>
            <tr>
             <th style="background-color:'.$colors[$i].'; color:white; border: 1px solid black;">رقم الهوبر</th>
               
                  <th style="background-color:'.$colors[$i].'; color:white; border: 1px solid black;">عدد النقلات </th>
                  
 <th style="background-color:'.$colors[$i].'; color:white; border: 1px solid black;">الكمية بالطن </th>
            </tr>


        </thead>
        <tbody>';

if ($result1->num_rows > 0) {
    while ($row1 = mysqli_fetch_assoc($result1)) {
   
        $query11 ="select SUM(qnt) as qnts ,hobar,COUNT(id) as count from move where hobar = '".$row1["hobar"]."' AND vessel_id = '$vessel_id'  AND is_delete = 0  ";
        $result11= mysqli_query($con, $query11);
        if(mysqli_num_rows($result11) > 0) {
            $row11= mysqli_fetch_assoc($result11);
            $qnts1 = $row11['qnts'];
        }
       $query33 ="select SUM(qnt) as qnts, COUNT(id) as count from direct where hobar = '".$row1["hobar"]."'  AND  vessel_id = '$vessel_id'  AND is_delete = 0  AND qnt_date is not null ";
        $result33= mysqli_query($con, $query33);

        if(mysqli_num_rows($result33) > 0) {
            $row111= mysqli_fetch_assoc($result33);
            $qnts111 = $row11['qnts'];
            $count111 = $row111['count'];
        }

            $query33 ="select   COUNT(id) as count from loading where hobar = '".$row1["hobar"]."'  AND  vessel_id = '$vessel_id'  AND is_delete = 0   ";
        $result33= mysqli_query($con, $query33);

        if(mysqli_num_rows($result33) > 0) {
            $row111= mysqli_fetch_assoc($result33);
            $count1111 = $row111['count'];
        }
        $count11 = $count111 +  $count1111;

        $output1 .= '<tr>  
             <th color:black; border: 1px solid black;padding: 1px;font-size:12px;">   <span style="color:black;">' . $row11["hobar"] . '</span> </th>
               <th color:black; border: 1px solid black;padding: 1px;font-size:12px;">   <span style="color:black;">'.$row11["count"]. ' </span> </th>
              <th color:black; border: 1px solid black;font-size:12px;">   <span style="color:black;">' . number_format((float)$qnts1, 3, '.', '')  . ' </span> <span style="color:blue;">(' .$count11  . ') </span> </th>

            </tr>  ';
            
    }
}
$output1 .='</tbody></table>';

$query2 ="select * from  move where  vessel_id = '$vessel_id'  AND is_delete = 0   GROUP BY store_no  ";
$result2 = mysqli_query($con, $query2);
$i=1;
$output2 .= '
        	<table  id="customers"  style= "margin-bottom:5px;"> 
        <thead>
            <tr>
             <th style="background-color:'.$colors[$i].'; color:white; border: 1px solid black;font-size:12px;">رقم المخزن</th>
                  <th style="background-color:'.$colors[$i].'; color:white; border: 1px solid black;font-size:12px;">عدد النقلات </th>

            </tr>

        </thead>
        <tbody>';
if ($result2->num_rows > 0) {
    while ($row2 = mysqli_fetch_assoc($result2)) {
        $name2 = $row2["store_no"];
        $query22 = "select SUM(qnt) as qnts , store_no ,COUNT(id) as count from move where store_no = '$name2' AND  vessel_id = '$vessel_id'  AND is_delete = 0 ";
        $result22 = mysqli_query($con, $query22);
        if (mysqli_num_rows($result22) > 0) {
            $row22 = mysqli_fetch_assoc($result22);
            $qnts2 = $row22['qnts'];
        }

    $query33 ="select SUM(qnt) as qnts, COUNT(id) as count from arrival where store_no ='$name2'  AND  vessel_id = '$vessel_id'  AND is_delete = 0  AND qnt_date is not null ";
        $result33= mysqli_query($con, $query33);

        if(mysqli_num_rows($result33) > 0) {
            $row424= mysqli_fetch_assoc($result33);
            $qnts22 = $row424['qnts'];
            $count22 = $row424['count'];
        }



        if($row22["store_no"] != null){
 $output2 .= '<tr>  
             <th color:black; border: 1px solid black;font-size:12px;">   <span style="color:black;">'.$row22["store_no"].'</span> </th>
              <th color:black; border: 1px solid black;font-size:12px;">   <span style="color:black;">'.$row22["count"]. ' </span> </th>

            </tr> ';
        }
       
    }
}
$output2 .='</tbody></table>';



$query8 ="select * from  move where  vessel_id = '$vessel_id'  AND is_delete = 0   GROUP BY type  ";
$result8 = mysqli_query($con, $query8);
$i=1;
$output8 .= '
        	<table  id="customers"  style= "margin-bottom:5px;"> 
        <thead>
            <tr>
           <th style="background-color:'.$colors[$i].'; color:white; border: 1px solid black;font-size:12px;"> الصنف</th>
            <th style="background-color:'.$colors[$i].'; color:white; border: 1px solid black;font-size:12px;">عدد النقلات </th>
           <th style="background-color:'.$colors[$i].'; color:white; border: 1px solid black;font-size:12px;">اجمالي الكمية </th>

            </tr>

        </thead>
        <tbody>';
if ($result8->num_rows > 0) {
    while ($row8 = mysqli_fetch_assoc($result8)) {
        $name8 = $row8["type"];
        $query88 = "select SUM(qnt) as qnts , type ,COUNT(id) as count from move where type = '$name8' AND  vessel_id = '$vessel_id'  AND is_delete = 0 ";
        $result88 = mysqli_query($con, $query88);
        if (mysqli_num_rows($result88) > 0) {
            $row88 = mysqli_fetch_assoc($result88);
            $qnts8 = $row88['qnts'];
        }
                 $query33 ="select SUM(qnt) as qnts, COUNT(id) as count from direct where type = '$name8'  AND  vessel_id = '$vessel_id'  AND is_delete = 0  AND qnt_date is not null ";
        $result33= mysqli_query($con, $query33);

        if(mysqli_num_rows($result33) > 0) {
            $row484= mysqli_fetch_assoc($result33);
            $qnts88 = $row484['qnts'];
            $count888 = $row484['count'];
        }
        $query33 ="select  COUNT(id) as count from loading where type = '$name8'  AND  vessel_id = '$vessel_id'  AND is_delete = 0   ";
        $result33= mysqli_query($con, $query33);

        if(mysqli_num_rows($result33) > 0) {
            $row484= mysqli_fetch_assoc($result33);
            $count8888 = $row484['count'];
        }



        $count88 = $count888 +  $coun8888;
        
        $output8 .= '<tr>  
             <th color:black; border: 1px solid black;font-size:12px;">   <span style="color:black;">'.$row88["type"].'</span> </th>
              <th color:black; border: 1px solid black;font-size:12px;">   <span style="color:black;">'.$row88["count"]. ' </span> </th>
              <th color:black; border: 1px solid black;font-size:12px;">   <span style="color:black;">' . number_format((float)$qnts8, 3, '.', '')  . ' </span> <span style="color:blue;">(' .$count88  . ') </span> </th>

            </tr> ';
    }
}
$output8 .='</tbody></table>';

$query3 ="select * from  move where arrival = '1'  AND  vessel_id = '$vessel_id'  AND is_delete = 0 GROUP BY room_no  order by room_no asc";

// //////////////////////////// السعة add
$no='0';
if($vessel_id == '1080') $arr = [1350,2800,1950]; 
if($vessel_id == '1079') $arr = [2500,2500];
if($vessel_id == '1081') $arr = [1000,3000,2000];
if($vessel_id == '1082') $arr =[4500,5800,5800,5250];
if($vessel_id == '1084') $arr =[4600];
if($vessel_id == '1088') $arr = [4700,6000,6000,5900];
if($vessel_id == '1089') $arr = [8400,10900,10000,8800,10000,11500,8400];
$result3 = mysqli_query($con, $query3);
$i=2;
$output3 .= '
        	<table  id="customers" style= "margin-bottom:5px;">
        <thead>
            <tr>
             <th style="background-color:'.$colors[$i].'; color:white; border: 1px solid black;">رقم العنبر</th>
              <th style="background-color:'.$colors[$i].'; color:white; border: 1px solid black;">عدد النقلات </th>
              <th style="background-color:'.$colors[$i].'; color:white; border: 1px solid black;">اجمالي الكمية </th>


           
            </tr>

        </thead>
        <tbody>';

if ($result3->num_rows > 0) {
    $p=0;
    while ($row3 = mysqli_fetch_assoc($result3)) {
           
        $query33 ="select SUM(qnt) as qnts ,room_no ,COUNT(id) as count from move where room_no = '".$row3["room_no"]."'  AND  vessel_id = '$vessel_id'  AND is_delete = 0  ";
        $result33= mysqli_query($con, $query33);

        if(mysqli_num_rows($result33) > 0) {
            $row33= mysqli_fetch_assoc($result33);
            $qnts44 = $row33['qnts'];

        }
        
        $queryf ="select SUM(qnt) as qnts ,Count(*) as count,  SUM(jumbo) as jumbo from move where arrival = '1'  AND   vessel_id = '$vessel_id'  AND is_delete = 0  AND move_type = 'normal' AND room_no = '".$row3["room_no"]."' ";
$resultf = mysqli_query($con, $queryf);

    $normal = mysqli_fetch_assoc($resultf);
    $normal_count_all = $normal['count'];
    
            $query33 ="select SUM(qnt) as qnts, COUNT(id) as count from direct where room_no = '".$row3["room_no"]."'  AND  vessel_id = '$vessel_id'  AND is_delete = 0  AND qnt_date is not null ";
        $result33= mysqli_query($con, $query33);

        if(mysqli_num_rows($result33) > 0) {
            $row44= mysqli_fetch_assoc($result33);
            $count444 = $row44['count'];
        }

        $count44 = $count444 +  $normal_count_all;

          $R = $arr[$p] - $qnts3 ;

        
         $R =number_format((float)$R, 3, '.', '');
         
// ////////////////////////////////////add vessel id
         $vessel_ids=[1080,1079,1081,1082,1084,1088,1089];
         
         if(!in_array($vessel_id,$vessel_ids)) 
         {
             $arr[$p]='-';
             $R='-';
         }

        $output3 .= '
            <tr>  
             <th color:black; border: 1px solid black;font-size:12px;">   <span style="color:black;">'.$row33["room_no"].'</span> </th>
              <th color:black; border: 1px solid black;font-size:12px;">   <span style="color:black;">'.$row33["count"]. ' </span> </th>
              <th color:black; border: 1px solid black;font-size:12px;">   <span style="color:black;">' . number_format((float)$qnts44, 3, '.', '')  . ' </span> <span style="color:blue;">(' .$count44  . ') </span> </th>

            </tr> ';
            $p++;
    }
}
$output3 .='</tbody></table>';
/*
$query4 ="select * from  move  where  vessel_id = '$vessel_id'  AND is_delete = 0  AND arrival = '1'  AND hla1 != 'بدون حِلل' GROUP BY hla1";
$result4 = mysqli_query($con, $query4);
$i=3;
$output4 .= '
        	<table  id="customers" style= "margin-bottom:5px;">
        <thead>
            <tr>
             <th style="background-color:'.$colors[$i].'; color:white; border: 1px solid black;">رقم الحله</th>
              <th style="background-color:'.$colors[$i].'; color:white; border: 1px solid black;">عدد النقلات </th>
              <th style="background-color:'.$colors[$i].'; color:white; border: 1px solid black;">اجمالي الكمية </th>

            </tr>

        </thead>
        <tbody>';
if ($result4->num_rows > 0) {
    while ($row4 = mysqli_fetch_assoc($result4)) {
        $query44 ="select SUM(qnt) as qnts ,hla1,COUNT(id) as count from move where hla1 = '".$row4["hla1"]."' AND  vessel_id = '$vessel_id'  AND is_delete = 0";
        $result44= mysqli_query($con, $query44);
        if(mysqli_num_rows($result44) > 0) {
            $row44= mysqli_fetch_assoc($result44);
            $qnts4 = $row44['qnts'];
        }
        $output4 .= '
 <tr>  
             <th color:black; border: 1px solid black;padding: 1px;font-size:12px;">   <span style="color:black;">'.$row44["hla1"].'</span> </th>
               <th color:black; border: 1px solid black;padding: 1px;font-size:12px;">   <span style="color:black;">'.$row44["count"]. ' </span> </th>
                        <th color:black; border: 1px solid black;padding: 1px;font-size:12px;">   <span style="color:black;">' . number_format((float)$qnts4, 3, '.', '')  . ' </span> </th>

            </tr>';
            
    }
}
$query4 ="select * from  move  where  vessel_id = '$vessel_id'  AND is_delete = 0  AND arrival = '1'  AND hla2 != 'بدون حِلل' GROUP BY hla2";
$result4 = mysqli_query($con, $query4);
$i=3;

if ($result4->num_rows > 0) {
    while ($row4 = mysqli_fetch_assoc($result4)) {
        $query44 ="select SUM(qnt) as qnts ,hla2,COUNT(id) as count from move where hla2 = '".$row4["hla2"]."' AND  vessel_id = '$vessel_id'  AND is_delete = 0";
        $result44= mysqli_query($con, $query44);
        if(mysqli_num_rows($result44) > 0) {
            $row44= mysqli_fetch_assoc($result44);
            $qnts4 = $row44['qnts'];
        }
        $output4 .= '
 <tr>  
             <th color:black; border: 1px solid black;padding: 1px;font-size:12px;">   <span style="color:black;">'.$row44["hla2"].'</span> </th>
               <th color:black; border: 1px solid black;padding: 1px;font-size:12px;">   <span style="color:black;">'.$row44["count"]. ' </span> </th>
                        <th color:black; border: 1px solid black;padding: 1px;font-size:12px;">   <span style="color:black;">' . number_format((float)$qnts4, 3, '.', '')  . ' </span> </th>

            </tr>';
            
    }
}
$output4 .='</tbody></table>';*/

$query5 ="select * from  move where vessel_id = '$vessel_id'  AND is_delete = 0 AND arrival = '1' AND kbsh !='بدون كباشات أوناش'  GROUP BY kbsh    ";
$result5= mysqli_query($con, $query5);
$i=4;
$output5 ='
        	<table  id="customers"  style= "margin-bottom:5px;">
        <thead>
            <tr>
             <th style="background-color:'.$colors[$i].'; color:white; border: 1px solid black;">رقم الكباش</th>
             <th style="background-color:'.$colors[$i].'; color:white; border: 1px solid black;">عدد النقلات </th>
             <th style="background-color:'.$colors[$i].'; color:white; border: 1px solid black;">اجمالي الكمية </th>

            </tr>

        </thead>
        <tbody>';
if ($result5->num_rows > 0) {
    while ($row5 = mysqli_fetch_assoc($result5)) {
        $query55 ="select SUM(qnt) as qnts , kbsh,COUNT(id) as count  from move where kbsh = '".$row5["kbsh"]."' AND vessel_id = '$vessel_id'  AND is_delete = 0 ";
        $result55= mysqli_query($con, $query55);
        if(mysqli_num_rows($result55) > 0) {
            $row55= mysqli_fetch_assoc($result55);
            $qnts5= $row55['qnts'];
        }

    $query33 ="select SUM(qnt) as qnts, COUNT(id) as count from direct where kbsh = '".$row5["kbsh"]."'  AND  vessel_id = '$vessel_id'  AND is_delete = 0  AND qnt_date is not null ";
        $result33= mysqli_query($con, $query33);

        if(mysqli_num_rows($result33) > 0) {
            $row454= mysqli_fetch_assoc($result33);
            $qnts55 = $row454['qnts'];
            $count555 = $row454['count'];
        }

           $query33 ="select  COUNT(id) as count from loading where kbsh = '".$row5["kbsh"]."'    AND  vessel_id = '$vessel_id'  AND is_delete = 0   ";
        $result33= mysqli_query($con, $query33);

        if(mysqli_num_rows($result33) > 0) {
            $row484= mysqli_fetch_assoc($result33);
            $count5555 = $row484['count'];
        }



        $count55 = $count555 +  $count5555;

        $output5 .= '
 <tr>  
             <th color:black; border: 1px solid black;padding: 1px;font-size:12px;">   <span style="color:black;">'.$row55["kbsh"].'</span> </th>
              <th color:black; border: 1px solid black;padding: 1px;font-size:12px;">   <span style="color:black;">'.$row55["count"]. ' </span> </th>
              <th color:black; border: 1px solid black;font-size:12px;">   <span style="color:black;">' . number_format((float)$qnts5, 3, '.', '')  . ' </span> <span style="color:blue;">(' .$count55  . ') </span> </th>

            </tr>';
    }
}
$output5 .='</tbody></table>';

$query6="select * from  move where vessel_id = '$vessel_id'  AND is_delete = 0 AND  arrival = '1' AND crane != 'بدون أوناش' GROUP BY crane ";
$result6 = mysqli_query($con, $query6);
$i=5;
$output6 ='
        	<table  id="customers"  style= "margin-bottom:5px;">
        <thead>
            <tr>
             <th style="background-color:'.$colors[$i].'; color:white; border: 1px solid black;font-size:12px;">رقم الونش</th>
             <th style="background-color:'.$colors[$i].'; color:white; border: 1px solid black;font-size:12px;">عدد النقلات </th>
             <th style="background-color:'.$colors[$i].'; color:white; border: 1px solid black;font-size:12px;">اجمالي الكمية </th>
            </tr>

        </thead>
        <tbody>';
if ($result6->num_rows > 0) {
    while ($row6 = mysqli_fetch_assoc($result6)) {
        $query66 ="select SUM(qnt) as qnts ,crane,COUNT(id) as count  from move where crane = '".$row6["crane"]."' AND vessel_id = '$vessel_id'  AND is_delete = 0 ";
        $result66= mysqli_query($con, $query66);
        if(mysqli_num_rows($result66) > 0) {
            $row66= mysqli_fetch_assoc($result66);
            $qnts6 = $row66['qnts'];
        }

           $query33 ="select SUM(qnt) as qnts, COUNT(id) as count from direct where crane = '".$row6["crane"]."'  AND  vessel_id = '$vessel_id'  AND is_delete = 0  AND qnt_date is not null ";
        $result33= mysqli_query($con, $query33);

        if(mysqli_num_rows($result33) > 0) {
            $row464= mysqli_fetch_assoc($result33);
            $qnts66 = $row464['qnts'];
            $count666 = $row464['count'];
        }

                   $query33 ="select  COUNT(id) as count from loading where crane = '".$row6["crane"]."'    AND  vessel_id = '$vessel_id'  AND is_delete = 0   ";
        $result33= mysqli_query($con, $query33);

        if(mysqli_num_rows($result33) > 0) {
            $row484= mysqli_fetch_assoc($result33);
            $count6666 = $row484['count'];
        }



        $count66 = $count666 +  $count6666;

        $output6 .= '
 <tr>  
             <th color:black; border: 1px solid black;font-size:12px;">   <span style="color:black;">'.$row66["crane"].'</span> </th>
             <th color:black; border: 1px solid black;font-size:12px;">   <span style="color:black;">'.$row66["count"]. ' </span> </th>
              <th color:black; border: 1px solid black;font-size:12px;">   <span style="color:black;">' . number_format((float)$qnts6, 3, '.', '')  . ' </span> <span style="color:blue;">(' .$count66  . ') </span> </th>
            </tr>';
    }
}
$output6 .='</tbody></table>';

$query7="select * from  cars where vessel_id = '$vessel_id'  AND type='normal' group by car_no ";
$result7 = mysqli_query($con, $query7);
$i=5;
$output7 ='
<div class ="col-lg-8">
        <table  id="customers"  style= "margin-bottom:5px;">
        <thead>
            <tr>
            
                <th style="background-color:#008000; color:white; border: 1px solid black;padding: 1px;font-size:12px;">كود</th>
                 <th style="background-color:#008000; color:white; border: 1px solid black;padding: 1px;font-size:12px;">رقم السيارة</th>
                 <th style="background-color:#008000; color:white; border: 1px solid black;padding: 1px;font-size:12px;">النوع </th>
             <th style="background-color:#008000; color:white; border: 1px solid black;padding: 1px;font-size:12px;font-size:12px;">مقاول</th>
                <th style="background-color:#008000; color:white; border: 1px solid black;padding: 1px;font-size:12px;">نقلات</th>
                <th style="background-color:#008000; color:white; border: 1px solid black;padding: 1px;font-size:12px;">الكميه </th>
                 <th style="background-color:#008000; color:white; border: 1px solid black;padding: 1px;font-size:12px;">المتوسط</th>';
                if ($jumbo !='0'){ $output7 .= '<th style="background-color:#008000; color:white; border: 1px solid black;padding: 1px;font-size:12px;">جامبو</th>';}

            
                $output7 .= ' <th style="background-color:#008000; color:white; border: 1px solid black;padding: 1px;font-size:12px">دخول</th>
                  <th style="background-color:#008000; color:white; border: 1px solid black;padding: 1px;font-size:12px">خروج</th>

            </tr>

        </thead>
        <tbody>';

if ($result7->num_rows > 0) {
    $m=1;
    while ($row7 = mysqli_fetch_assoc($result7)) {
        $car_no = $row7["car_no"];
        $query777="select * from  cars where vessel_id = '$vessel_id' and car_no = '$car_no' order by start_date asc";
        $result777 = mysqli_query($con, $query777);
        $sns=[];
        $color=[];
        $start_date=[];
        $exit_date=[];
    if ($result777->num_rows > 0) {
        $qnts7=0;
        $count7=0;
        $count77=0;
        $count999=0;
        
        while ($row777 = mysqli_fetch_assoc($result777)) {
            array_push($sns,$row777['sn']);
            array_push($start_date,$row777['start_date']);
            if($row777['exit_date']!=''){
                array_push($exit_date,$row777['exit_date']);
            }else{
                array_push($exit_date,'_______');
            }
            
            
        $query77 ="select SUM(qnt) as qnts ,count(id) as count from move where sn = '".$row777["sn"]."' AND vessel_id = '$vessel_id'  AND is_delete = 0 ";
        $result77= mysqli_query($con, $query77);
        if(mysqli_num_rows($result77) > 0) {
            $row77= mysqli_fetch_assoc($result77);
            $qnts7 += $row77['qnts'];
            $count7 += $row77['count'];
        }
        $query77 ="select SUM(qnt) as qnts ,count(id) as count from move where sn = '".$row777["sn"]."' AND vessel_id = '$vessel_id'  AND is_delete = 0 AND arrival = '1' ";
        $result77= mysqli_query($con, $query77);
        if(mysqli_num_rows($result77) > 0) {
            $row77= mysqli_fetch_assoc($result77);
            $count77 += $row77['count'];
        }
         $query779="select SUM(jumbo) as jumbo ,count(id) as count from move where sn = '".$row777["sn"]."' AND vessel_id = '$vessel_id'  AND is_delete = 0  ";
        $result779= mysqli_query($con, $query779);
        if(mysqli_num_rows($result779) > 0) {
            $row779= mysqli_fetch_assoc($result779);
            $count999 += $row779['jumbo'];
        }
         if($row777['done']==0){
            array_push($color,'green');
            $row777["exit_date"] ='ــــــــــ';
        }
        else {
            array_push($color,'red');
        }
      
        }
        }
       
        
        
      if($count77  != 0 ){
             $avg =$qnts7 /$count77 ;
        }else {
            $avg='';
        }
        
        $output7 .= '
       <tr>  
            <th >  
            ';
            for($i=0;$i < count($sns); $i++){
                $sn = $sns[$i];
             $output7 .= '
            <span style="color:'. $color[$i].';padding: 1px;font-size:12px;">' .$sn . ' </span> 
            
            ';
            }
            $output7 .= '
            
            </th>
            
            
            
            
            
            
            
            
            <th >   <span style="color:'. end($color).';padding: 1px;font-size:12px;">'.$row7["car_no"].'</span> </th>
            <th >   <span style="color:'. end($color).';padding: 1px;font-size:12px;">'.$row7["car_type"].'</span> </th>
            <th >   <span style="color:'. end($color).';padding: 1px;font-size:12px;">'.$row7["car_owner"].'</span> </th>

            <th >   <span style="color:'. end($color).';padding: 1px;font-size:12px;">'.$count77.'</span> </th> 
            <th >   <span style="color:'. end($color).';padding: 1px;font-size:12px;">' . number_format((float)$qnts7, 3, '.', '') . ' </span> </th>
            <th >   <span style="color:'. end($color).';padding: 1px;font-size:12px;">' . number_format((float)$avg, 3, '.', '') . ' </span> </th>';
                   if ($jumbo !='0'){ $output7 .= ' <th >  <span style="color:'. end($color).';padding: 1px;font-size:12px;">'.$count999.'</span> </th>';}
                    $output7 .= '<th >   <span style="color:'. end($color).';padding: 1px;font-size:10px;">' . $start_date[0] . ' </span> </th>
            <th >   <span style="color:'. end($color).';padding: 1px;font-size:10px;">
                   '.end($exit_date).'
                     </span> </th>
        </tr>';
        $m++;
    }
}
$output7 .='</tbody></table>';


$output77 ='
        	<div class ="col-lg-8">
        <table  id="customers"  style= "margin-bottom:5px;">
        <thead>
            <tr>
              <th style="background-color:#008000; color:white; border: 1px solid black;font-size:10px;">المقاول</th>
             <th style="background-color:#008000; color:white; border: 1px solid black;font-size:10px;">عدد السيارات</th>
             <th style="background-color:#008000; color:white; border: 1px solid black;font-size:10px;">عدد النقلات</th>
             <th style="background-color:#008000; color:white; border: 1px solid black;font-size:10px;">إجمالى الكمية</th>
             
             ';

           $output77 .=' </tr>

        </thead>
        <tbody>
        ';
       
       
$query9 ="select * from  cars where vessel_id = '$vessel_id'   AND type =  'normal'  group by car_owner   ";
$result9= mysqli_query($con, $query9); 
   if ($result9->num_rows > 0) {
    while ($row9 = mysqli_fetch_assoc($result9)) {
        $moves=0;
        $qnts=0;
        $car_owner=$row9['car_owner'];
        $cars =[];

        $output77 .= '
                <tr>  
             <th color:black; border: 1px solid black;font-size:12px;">   <span style="color:black;">'.$car_owner.'</span> </th>
             ';
             
       $query99 ="select * from  cars where car_owner = '$car_owner'  AND  vessel_id = '$vessel_id' ";
        $result99= mysqli_query($con, $query99);
        if ($result99->num_rows > 0) {
          while ($row99 = mysqli_fetch_assoc($result99)) {
               array_push($cars,$row99["sn"]);
         }
         }
         $count= count($cars);
        for($s=0;$s<$count;$s++){
             
        $query099 ="select SUM(qnt) as qnts ,COUNT(id) as count  from move where sn = '$cars[$s]'  AND vessel_id = '$vessel_id'  AND is_delete = 0 ";
        $result099= mysqli_query($con, $query099);
        if(mysqli_num_rows($result099) > 0) {
            $row099= mysqli_fetch_assoc($result099);
            $qnts += $row099['qnts'];
            $moves += $row099['count'];
          
        }  
        }
        
           $output77 .= '
            <th color:red; border: 1px solid black;font-size:12px;">   <span style="color:black;">
           ' . $count  . ' </th>
           <th color:red; border: 1px solid black;font-size:12px;">   <span style="color:black;">
           ' . $moves  . ' </th>
           
             <th color:red; border: 1px solid black;font-size:12px;">   <span style="color:black;">
           ' . $qnts  . ' </span> </th>
           ';
           
           
       
             $output77 .= ' </tr>';
 
              }}
$output77 .='</tbody></table></div>';

$query9 ="select * from  move where vessel_id = '$vessel_id'  AND is_delete = 0 AND arrival = '1'  GROUP BY room_no    ";
$result9= mysqli_query($con, $query9);
$i=4;
$room_no =[];
$output9 ='
        	<table  id="customers"  style= "margin-bottom:5px;">
        <thead>
            <tr>
              <th style="background-color:'.$colors[$i].'; color:white; border: 1px solid black;">رقم الهوبر</th>';
            if ($result9->num_rows > 0) {
              while ($row9 = mysqli_fetch_assoc($result9)) {
                  array_push($room_no,$row9["room_no"]);
                  $output9 .='
             <th style="background-color:'.$colors[$i].'; color:white; border: 1px solid black;">'.$row9["room_no"].'</th>';
}
}
           $output9 .=' </tr>

        </thead>
        <tbody>
        ';
       
        $hobar =[];
    $query99 ="select * from  move where arrival = '1'  AND  vessel_id = '$vessel_id'  AND is_delete = 0 AND hobar != 'بدون هوابر' GROUP BY hobar";
        $result99= mysqli_query($con, $query99);
        if ($result99->num_rows > 0) {
          while ($row99 = mysqli_fetch_assoc($result99)) {
               array_push($hobar,$row99["hobar"]);
         }
         }
         for($s=0;$s<count($hobar);$s++){
        $output9 .= '
                <tr>  
             <th color:black; border: 1px solid black;font-size:12px;">   <span style="color:black;">'.$hobar[$s].'</span> </th>
             ';
              for($f=0;$f<count($room_no);$f++){
                 $query099 ="select SUM(qnt) as qnts ,COUNT(id) as count  from move where hobar = '$hobar[$s]' AND room_no ='$room_no[$f]'  AND vessel_id = '$vessel_id'  AND is_delete = 0 ";
        $result099= mysqli_query($con, $query099);
        if(mysqli_num_rows($result099) > 0) {
            $row099= mysqli_fetch_assoc($result099);
            $qnts9 = $row099['qnts'];
            $count9 = $row099['count'];
            if($count9 =='0') $count9='';else $count9= '('.$count9.')';
            if($qnts9 =='0' or !$qnts9)  $qnts9='';else $qnts9 = number_format((float)$qnts9, 3, '.', '');
        }  
           $output9 .= '
           <th color:red; border: 1px solid black;font-size:12px;">   <span style="color:black;">
           ' . $qnts9  . ' </span><span style="color:blue;">'.$count9.' </span> </th>';
           }
             $output9 .= ' </tr>';
         }
  
$output9 .='</tbody></table>';


$query9 ="select * from  move where vessel_id = '$vessel_id'  AND is_delete = 0 AND arrival = '1'  GROUP BY room_no    ";
$result9= mysqli_query($con, $query9);
$i=1;
$room_no =[];


$output19 ='
        	<table  id="customers"  style= "margin-bottom:5px;font-size:10px;">
        <thead>
            <tr>
              <th style="background-color:'.$colors[$i].'; color:white;font-size:12px; border: 1px solid black;">الصنف</th>';
            if ($result9->num_rows > 0) {
              while ($row9 = mysqli_fetch_assoc($result9)) {
                  array_push($room_no,$row9["room_no"]);
                  $output19 .='
             <th style="background-color:'.$colors[$i].'; color:white; border: 1px solid black;">'.$row9["room_no"].'</th>';
}
}
           $output19 .=' </tr>

        </thead>
        <tbody>
        ';
       
        $type =[];
    $query99 ="select * from  move where arrival = '1'  AND  vessel_id = '$vessel_id'  AND is_delete = 0  GROUP BY type";
        $result99= mysqli_query($con, $query99);
        if ($result99->num_rows > 0) {
          while ($row99 = mysqli_fetch_assoc($result99)) {
               array_push($type,$row99["type"]);
         }
         }
         for($s=0;$s<count($type);$s++){
        $output19 .= '
                <tr>  
             <th color:black; border: 1px solid black;font-size:12px;">   <span style="color:black;">'.$type[$s].'</span> </th>
             ';
              for($f=0;$f<count($room_no);$f++){
                 $query099 ="select SUM(qnt) as qnts ,COUNT(id) as count  from move where type = '$type[$s]' AND room_no ='$room_no[$f]'  AND vessel_id = '$vessel_id'  AND is_delete = 0 ";
        $result099= mysqli_query($con, $query099);
        if(mysqli_num_rows($result099) > 0) {
            $row099= mysqli_fetch_assoc($result099);
            $qnts9 = $row099['qnts'];
            $count9 = $row099['count'];
            if($count9 =='0') $count9='';else $count9= '('.$count9.')';
            if($qnts9 =='0' or !$qnts9)  $qnts9='';else $qnts9 = number_format((float)$qnts9, 3, '.', '');
        }  
           $output19 .= '
           <th color:red; border: 1px solid black;font-size:12px;">   <span style="color:black;">
           ' . $qnts9  . ' </span><span style="color:blue;">'.$count9.' </span> </th>';
           }
             $output19 .= ' </tr>';
         }
  
$output19 .='</tbody></table>';


$query10 ="select * from  move where vessel_id = '$vessel_id'  AND is_delete = 0 AND arrival = '1'  GROUP BY room_no    ";
$result10= mysqli_query($con, $query10);
$i=4;
$room_no =[];
$output10 ='
        	<table  id="customers"  style= "margin-bottom:5px;">
        <thead>
            <tr>
               <th style="background-color:'.$colors[$i].';color:white; border: 1px solid black;font-size:12px;">
               
               رقم الونش
               
               </th>';
               
              
            if ($result10->num_rows > 0) {
              while ($row10 = mysqli_fetch_assoc($result10)) {
                  array_push($room_no,$row10["room_no"]);
                  $output10 .='
                  
                  <th style="background-color:'.$colors[$i].';color:white; border: 1px solid black;font-size:10px;"> 
                  '.$row10["room_no"].'</th>';
                  
                  
                  
                  
                  
}
}
           $output10 .=' </tr>

        </thead>
        <tbody>
        ';
       
        $crane =[];
    $query1010 ="select * from  move where arrival = '1'  AND  vessel_id = '$vessel_id'  AND is_delete = 0 AND crane != 'بدون أوناش' GROUP BY crane";
        $result1010= mysqli_query($con, $query1010);
        if ($result1010->num_rows > 0) {
          while ($row1010 = mysqli_fetch_assoc($result1010)) {
               array_push($crane,$row1010["crane"]);
         }
         }
         for($s=0;$s<count($crane);$s++){
        $output10 .= '
                <tr>  
             <th color:black; border: 1px solid black;font-size:12px;">   <span style="color:black;">'.$crane[$s].'</span> </th>
             ';
              for($f=0;$f<count($room_no);$f++){
                 $query01010 ="select SUM(qnt) as qnts ,COUNT(id) as count  from move where crane = '$crane[$s]' AND room_no ='$room_no[$f]'  AND vessel_id = '$vessel_id'  AND is_delete = 0 ";
        $result01010= mysqli_query($con, $query01010);
        if(mysqli_num_rows($result01010) > 0) {
            $row01010= mysqli_fetch_assoc($result01010);
            $qnts10 = $row01010['qnts'];
            $count10 = $row01010['count'];
            if($count10 =='0') $count10='';else $count10= '('.$count10.')';
            if($qnts10 =='0' or !$qnts10)  $qnts10='';else $qnts10 = number_format((float)$qnts10, 3, '.', '');
        }  
           $output10 .= '
           <th color:red; border: 1px solid black;font-size:12px;">   <span style="color:black;">
           ' . $qnts10  . ' </span><span style="color:blue;">'.$count10.' </span> </th>';
           }
             $output10 .= ' </tr>';
         }
  
$output10 .='</tbody></table>';



$query7="select * from  cars where vessel_id = '$vessel_id'   AND type =  'normal' group by car_no";
$result7 = mysqli_query($con, $query7);
$i=5;
$output17 ='
<div class ="col-lg-8">
        <table  id="customers"  style= "margin-bottom:5px;">
        <thead>
            <tr>
            
                <th style="background-color:#008000; color:white; border: 1px solid black;padding: 1px;font-size:12px;">كود</th>
                 <th style="background-color:#008000; color:white; border: 1px solid black;padding: 1px;font-size:12px;">رقم السيارة</th>
                 <th style="background-color:#008000; color:white; border: 1px solid black;padding: 1px;font-size:12px;">النوع </th>
             <th style="background-color:#008000; color:white; border: 1px solid black;padding: 1px;font-size:12px;font-size:12px;">مقاول</th>
                <th style="background-color:#008000; color:white; border: 1px solid black;padding: 1px;font-size:12px;">وزن المحاور</th>
                <th style="background-color:#008000; color:white; border: 1px solid black;padding: 1px;font-size:12px;">وزن الفارغ </th>
                 <th style="background-color:#008000; color:white; border: 1px solid black;padding: 1px;font-size:12px;">حد الحمولة</th>

            </tr>

        </thead>
        <tbody>';

if ($result7->num_rows > 0) {
    $m=1;
    while ($row7 = mysqli_fetch_assoc($result7)) {
        if($row7['done']==0){
            $color ='green';
            $row7["exit_date"] ='ــــــــــ';
        }
        else {
            $color = 'red';
        }
     $mehwer = $row7["mehwer"];
      $vacant = $row7["vacant"];
     
      
        $output17 .= '
       <tr>  
            <th >   <span style="color:'.$color.';padding: 1px;font-size:9px;">' . $row7["sn"] . ' </span> </th>
            <th >   <span style="color:'.$color.';padding: 1px;font-size:9px;">'.$row7["car_no"].'</span> </th>
            <th >   <span style="color:'.$color.';padding: 1px;font-size:9px;">'.$row7["car_type"].'</span> </th>
            <th >   <span style="color:'.$color.';padding: 1px;font-size:9px;">'.$row7["car_owner"].'</span> </th>
             <th >   <span style="color:'.$color.';padding: 1px;font-size:9px;"> '. number_format((float)$mehwer, 3, '.', '') .'</span> </th>
              <th >   <span style="color:'.$color.';padding: 1px;font-size:9px;">'. number_format((float)$vacant, 3, '.', '') .'</span> </th>
               <th >   <span style="color:'.$color.';padding: 1px;font-size:9px;">'.number_format((float)$row7["limits"], 3, '.', '').'</span> </th>
               
               
              </tr>';
                   
        $m++;
    }
}
$output17 .='</tbody></table>';



  $query11 ="select * from  move where  vessel_id = '$vessel_id'  AND is_delete = 0 AND room_no != ''";
  $result11= mysqli_query($con, $query11); $room_no=1; if ($result11->num_rows == 0) $room_no=0;
    $query11 ="select * from  move where  vessel_id = '$vessel_id'  AND is_delete = 0 AND hobar != 'بدون هوابر'";
  $result11= mysqli_query($con, $query11); $hobar=1; if ($result11->num_rows == 0) $hobar=0;      
//    $query11 ="select * from  move where  vessel_id = '$vessel_id'  AND is_delete = 0 AND hla1 != 'بدون حِلل'";
 // $result11= mysqli_query($con, $query11); $hla1=1; if ($result11->num_rows == 0) $hla1=0;  
   $query11 ="select * from  move where  vessel_id = '$vessel_id'  AND is_delete = 0 AND kbsh != 'بدون كباشات أوناش'";
  $result11= mysqli_query($con, $query11); $kbsh=1; if ($result11->num_rows == 0) $kbsh=0;  
   $query11 ="select * from  move where  vessel_id = '$vessel_id'  AND is_delete = 0 AND crane != 'بدون أوناش'";
  $result11= mysqli_query($con, $query11); $crane=1; if ($result11->num_rows == 0) $crane=0;  
  $query11 ="select * from  arrival where  vessel_id = '$vessel_id'  AND is_delete = 0 ";
  $result11= mysqli_query($con, $query11); $stores=1; if ($result11->num_rows == 0) $stores=0;  






echo $outputa;
echo $outputb;
echo $outputf;
echo $outputc;
echo $output0;

//room_no
if($room_no =='1') echo $output3;
//hobar
if($hobar =='1') echo $output1;
//hobar-room_no
if($hobar =='1' AND $room_no=='1')echo $output9;


//hla1
//if($hla1 =='1')echo $output4;
//kbsh
if($kbsh =='1')echo $output5;
//crane
if($crane =='1')echo $output6;
//crane-room_no
if($crane =='1' AND $room_no=='1')echo $output10;
//type
echo $output8;
echo $output19;

//store_no
if($stores =='1')  echo $output2;


echo '</div>';

//cars
 if($count3 !=0){   echo $output77;}
 if($count3 !=0){  echo $output7;}
//echo $output17;
