<?php
// database connection
require "../../config.php";

$id =$_GET['id'];
$result = mysqli_query($con,"SELECT *  FROM direct   where  id =  $id ");
$row = mysqli_fetch_assoc($result);
$sn = $row['sn']; 
$move_id = $row['move_id']; 
$vessel_id=$row['vessel_id'];

$result = mysqli_query($con,"SELECT *  FROM cars   where  sn =  '$sn'  AND vessel_id = '$vessel_id'");
$row2 = mysqli_fetch_assoc($result);

$result = mysqli_query($con,"SELECT *  FROM vessels_log   where  vessel_id = '$vessel_id'");
$row3 = mysqli_fetch_assoc($result);

$rooms = mysqli_query($con,"SELECT *  FROM rooms");
$hobars = mysqli_query($con,"SELECT *  FROM hobars");
$kbshs = mysqli_query($con,"SELECT *  FROM kbshs");
$cranes = mysqli_query($con,"SELECT *  FROM cranes");
$types = mysqli_query($con,"SELECT *  FROM types");
?>
<!DOCTYPE html>
<html>
<html>

<head>
    <title>تعديل كارتة الصرف المباشر </title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/css/bootstrap-select.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/js/bootstrap-select.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">

    <style>
    @import url("https://fonts.googleapis.com/css2?family=Changa:wght@600&display=swap");

    html,
    body {
        margin: 0;
        top: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: "Changa", sans-serif !important;
        font-size: 1.2rem;
        direction: rtl;
        overflow: visible;
        text-align: center !important;
        align-items: center !important;
        justify-content: center !important;
    }



    input[type="text"] {
        margin-bottom: 10px;
        text-align: center;

    }

    select {
        font-size: .9rem !important;
    }

    .disabled {
        width: 40vw;
        margin-bottom: 10px;
        text-align: center;
        font-size: .8rem !important;
    }

    .date {
        font-size: .8rem !important;
    }

    select {
        width: 40vw;
        margin-bottom: 10px;
        text-align: center !important;
    }

    .width {
        width: 80vw !important;
    }

    #element {
        display: none;
    }

    p {
        font-size: .8rem;
        width: 30vw !important;
        display: inline-block;
    }

    .text {
        width: 50vw !important;
        margin-bottom: 10px;
        text-align: center;
    }

    .error_input {
        border: red solid 2px !important;
    }
    </style>
</head>

<body>
    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading">تعديل كارتة الصرف المباشر</div>
            <div class="panel-body text-center justify-content-center">
                <form id="myform">
                    <input type="hidden" value="<?php echo $id ;?>" id="id">
                    <input type="hidden" value="<?php echo $move_id ;?>" id="move_id">
                    <input type="hidden" value="<?php echo $vessel_id ;?>" id="vessel_id">

                    <input type="text" class="disabled" disabled value="<?php echo $row3['name'];?>">
                    <input type="text" class="disabled" disabled value="<?php echo $row3['type'];?>">

                    <input type="text" class="disabled" disabled value="<?php echo $sn;?>">
                    <input type="text" class="disabled" disabled value="<?php echo $row2['car_no'];?>">
                    <input type="text" disabled class="date" value="<?php echo $row['date'];?>">

                    <select id="room_no">
                        <option value="<?php echo $row['room_no'] ;?>"><?php echo $row['room_no'] ;?></option>
                        <?php   while ($room_no = mysqli_fetch_assoc($rooms)) {
                                    if($room_no["name"] !=  $row['room_no']) echo '<option value="'.$room_no["name"].'">'.$room_no["name"].'</option>';
                        }
                        ?>
                    </select>
                    <select id="hobar">
                        <option value="<?php echo $row['hobar'] ;?>"><?php echo $row['hobar'] ;?></option>
                        <?php   while ($hobar = mysqli_fetch_assoc($hobars)) {
                                    if($hobar["name"] !=  $row['hobar']) echo '<option value="'.$hobar["name"].'">'.$hobar["name"].'</option>';
                        }
                        ?>
                    </select>
                    <select id="kbsh">
                        <option value="<?php echo $row['kbsh'] ;?>"><?php echo $row['kbsh'] ;?></option>
                        <?php   while ($kbsh = mysqli_fetch_assoc($kbshs)) {
                                    if($kbsh["name"] !=  $row['kbsh']) echo '<option value="'.$kbsh["name"].'">'.$kbsh["name"].'</option>';
                        }
                        ?>
                    </select>

                    <select id="crane">
                        <option value="<?php echo $row['crane'] ;?>"><?php echo $row['crane'] ;?></option>
                        <?php   while ($crane = mysqli_fetch_assoc($cranes)) {
                                    if($crane["name"] !=  $row['crane']) echo '<option value="'.$crane["name"].'">'.$crane["name"].'</option>';
                        }
                        ?>
                    </select>

                    <select id="type" class='width'>
                        <option value="<?php echo $row['type'] ;?>"><?php echo $row['type'] ;?></option>
                        <?php   while ($type = mysqli_fetch_assoc($types)) {
                                    if($type["name"] !=  $row['type']) echo '<option value="'.$type["name"].'">'.$type["name"].'</option>';
                        }
                        ?>
                    </select>
                    <p>الرقم الجمركى</p>
                    <input type="text" class="text" dir="ltr" pattern="[0-9]+(\.[0-9]+)?%?" id="custom" name="custom"
                        value="<?php echo $row['custom'];?>">
                    <input type="text" class="disabled" disabled value="<?php echo $row['ename'];?>">
                    <input type="text" class="disabled" disabled value="<?php echo $row['notes'];?>">

                    <button class="btn btn-primary  btn-lg" id='btn-save'>حفظ البيانات</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script src="https://kit.fontawesome.com/715e93c83e.js" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"
    integrity="sha512-37T7leoNS06R80c8Ulq7cdCDU5MNQBwlYoy1TX/WUsLFC2eYNqtKlV0QjH7r8JpG/S0GUMZwebnVFLPd6SU5yg=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/localization/messages_ar.min.js"
    integrity="sha512-bGOftAqe7xfGxaWMsVQR187i+R9E0tXZIUL0idz1NKBBZIW78hoDtFY9gGLEGJFwHPjQSmPiHdm+80QParVi1A=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/additional-methods.min.js"
    integrity="sha512-XZEy8UQ9rngkxQVugAdOuBRDmJ5N4vCuNXCh8KlniZgDKTvf7zl75QBtaVG1lEhMFe2a2DuA22nZYY+qsI2/xA=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/additional-methods.min.js"
    integrity="sha512-XZEy8UQ9rngkxQVugAdOuBRDmJ5N4vCuNXCh8KlniZgDKTvf7zl75QBtaVG1lEhMFe2a2DuA22nZYY+qsI2/xA=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/gh/mgalante/jquery.redirect@master/jquery.redirect.js"></script>
<script>
$("#btn-save").click(function(e) {
    $("#myform").validate({
        rules: {
            custom: {
                required: true
            }
        },
        highlight: function(input) {
            $(input).addClass('error_input');
        },
        unhighlight: function(input) {
            $(input).removeClass('error_input');
        },
        errorPlacement: function(error, element) {
            $(element).append(error);
        },
        submitHandler: function() {
            e.preventDefault();
            var formData = {
                id: $("#id").val(),
                vessel_id: $("#vessel_id").val(),
                move_id: $("#move_id").val(),
                room_no: $("#room_no").val(),
                hobar: $("#hobar").val(),
                kbsh: $("#kbsh").val(),
                crane: $("#crane").val(),
                custom: $("#custom").val(),
                type: $("#type").val()
            };
            $.ajax({
                type: "POST",
                url: '../controllers/direct_update.php',
                data: formData,
                dataType: "json",
                encode: true,
                error: function(xhr, status, error) {
                    msg = 'اعد المحاولة مرة أخرى';
                    $.alert({
                        title: '',
                        type: 'red',
                        content: msg,
                        icon: 'fa fa-warning'
                    })
                },
                success: function(data) {
                    console.log(data);
                    $.confirm({
                        title: 'تم التعديل بنجاح  ',
                        icon: 'fa fa-thumbs-up',
                        content: ' ارجع للخلف',
                        type: 'green',
                        rtl: true,
                        closeIcon: false,
                        draggable: true,
                        dragWindowGap: 0,
                        typeAnimated: true,
                        theme: 'supervan',
                        autoClose: 'okAction|600000000',
                        buttons: {
                            okAction: {
                                text: 'ارجع للخلف',
                                action: function() {
                                    $.redirect("edit.php", "",
                                        "GET", "");
                                }
                            },
                        }
                    })
                }
            })
        }
    })
});
</script>
</script>