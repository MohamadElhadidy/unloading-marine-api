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

?>
<!DOCTYPE html>
<html>
<html>

<head>
    <title>حذف نقلة صرف المباشر</title>
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
            <div class="panel-heading">حذف نقلة صرف المباشر</div>
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
                    <input type="text" class="disabled" disabled value="<?php echo $row['room_no'];?>">
                    <input type="text" class="disabled" disabled value="<?php echo $row['hobar'];?>">
                    <input type="text" class="disabled" disabled value="<?php echo $row['kbsh'];?>">
                    <input type="text" class="disabled" disabled value="<?php echo $row['crane'];?>">
                    <input type="text" class="disabled" disabled value="<?php echo $row['type'];?>">
                    <input type="text" class="disabled" disabled value="<?php echo $row['custom'];?>">
                    <input type="text" class="disabled" disabled value="<?php echo $row['custom'];?>">
                    <input type="text" class="disabled" disabled value="<?php echo $row['ename'];?>">
                    <input type="text" class="disabled" disabled value="<?php echo $row['notes'];?>">
                    <br>
                    <button class="btn btn-danger  btn-lg" id='btn-save'>حذف </button>
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
            e.preventDefault();
              $.confirm({
                title: '',
                icon: 'fa fa-warning',
                content: 'هل أنت متأكد من عملية الحذف ؟ ',
                type: 'red',
                rtl: true,
                closeIcon: false,
                closeIconClass: 'fa fa-close',
                draggable: true,
                dragWindowGap: 0,
                typeAnimated: true,
                theme: 'supervan',
                autoClose: 'cancelAction|60000',
                buttons: {
                    ok: {
                        text: 'حذف',
                        btnClass: 'btn-red',
                        action: function() {
                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                                }
                            });
                             var formData = {
                                    id: $("#id").val(),
                                    vessel_id: $("#vessel_id").val(),
                                    move_id: $("#move_id").val()
                                    };
                            $.ajax({
                                type: "POST",
                                data: formData,
                                url: '../controllers/direct_remove.php',
                                error: function() {
                                    $.alert({
                                        title: '',
                                        type: 'red',
                                        content: 'اعد المحاولة مرة أخرى',
                                        icon: 'fa fa-warning',
                                    });
                                }
                            }).done(function(data) {
                                                 $.confirm({
                        title: 'تم الحذف بنجاح  ',
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
                                    $.redirect("delete.php", "",
                                        "GET", "");
                                }
                            },
                        }
                    })
                            });

                        }
                    },
                    cancelAction: {
                        text: 'لا',
                        action: function() {
                            $.alert({
                                title: '',
                                type: 'red',
                                content: 'تم إلغاء عملية الحذف',
                                icon: 'fa fa-warning',
                            });
                            
                        }
                    },
                }
            });
        
});
</script>
</script>