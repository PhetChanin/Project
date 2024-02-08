<?php
session_start();
include 'config/server.php';
    $cusName=$_POST['cus_name'];
    $cusAddress=$_POST['cus_add'];
    $cusTel=$_POST['cus_tel'];

   //อัพโหลดรูปภาพ
    if (is_uploaded_file($_FILES['file1']['tmp_name'])) {
    $new_image_name = 'pro_'.uniqid().".".pathinfo(basename($_FILES['file1']['name']), PATHINFO_EXTENSION);
    $image_upload_path = "./image1/".$new_image_name;
    move_uploaded_file($_FILES['file1']['tmp_name'],$image_upload_path);
    } else {
    $new_image_name = "";
    }
    
    $sql = "INSERT INTO tb_order (cus_name, address, telephone, total_price, order_status, image1)
        VALUES ('$cusName', '$cusAddress', '$cusTel', '" . $_SESSION["sumPriceProduct"] . "', '1', '$new_image_name')";
mysqli_query($conn, $sql);

$orderID = mysqli_insert_id($conn);
$_SESSION["order_id"] = $orderID;

for ($i=0; $i <=(int)$_SESSION["intLine"]; $i++){ 
    if(($_SESSION["strProductID"][$i] != "")){
    // ดึงข้อมูลสินค้า
    $sql1="select * from product where pro_id = '" .$_SESSION["strProductID"][$i]."' "; 
    $result1 = mysqli_query($conn,$sql1);
    $row1=mysqli_fetch_array($result1);
    $price = $row1['price'];
    $total = $_SESSION["strQty"][$i] * $price;

    $sql2 = "insert into order_detail(orderID,pro_id,orderPrice,orderQty,Total)
    values('$orderID','".$_SESSION["strProductID"][$i]."','$price','".$_SESSION["strQty"][$i]."','$total')";
    if (mysqli_query($conn,$sql2)){
        //ตัดสต็อกสินค้า
        $sql3 = "update product set amount = amount - '".$_SESSION["strQty"][$i]."' 
        where pro_id = '".$_SESSION["strProductID"][$i]."'";
        mysqli_query($conn,$sql3);
        //echo "<script> alert('บันทึกข้อมูลเรียบร้อยแล้ว') </script>";
        echo "<script> window.location='print_order.php'; </script>";
     
    }

    }


}
mysqli_close($conn);
unset($_SESSION["intLine"]);
unset($_SESSION["strProductID"]);
unset($_SESSION["strQty"]);
unset($_SESSION["sumPriceProduct"]);

?> 
