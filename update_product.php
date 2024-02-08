<?php 
session_start();
 include('config/server.php');
 $proid = $_POST['proid']; 
 $proname = $_POST['pname'];
 $typeid = $_POST['typeID'];
 $price = $_POST['price'];
 $num = $_POST['num'];
 $detail = $_POST['detail'];
 $image = $_POST['txting'];
 //อัพโหลดรูปภาพ
if (is_uploaded_file($_FILES['file1']['tmp_name'])) {
    $new_image_name = 'pro_'.uniqid().".".pathinfo(basename($_FILES['file1']['name']), PATHINFO_EXTENSION);
    $image_upload_path = "./image/".$new_image_name;
    move_uploaded_file($_FILES['file1']['tmp_name'],$image_upload_path);
    } else {
    $new_image_name = "$image";
    }
    //คำสั่ง Update
    $sql = "UPDATE product SET 
    pro_name = '$proname',
    type_id = '$typeid',
    price = '$price',
    amount = '$num',
    detail = '$detail',
    image = '$new_image_name'
    WHERE pro_id = '$proid'";

    $result= mysqli_query($conn,$sql);
    if($result){ 
        echo"<script> alert('แก้ไขข้อมูลเรียบร้อย');  </script>";
        echo"<script> window.location='show_product.php';  </script>";
    }else{
        echo"<script> alert('ไม่สามารถแก้ไขข้อมูลได้');  </script>";
    }
 ?>