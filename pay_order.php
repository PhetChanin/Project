<?php
session_start();
include('config/server.php'); 
$ids=$_GET['id'];
$sql="UPDATE tb_order SET order_status = 2  WHERE orderID='$ids'  ";
$result=mysqli_query($conn,$sql);
if($result){
    echo "<script>window.location='report_order.php';</script>";
} else{
    echo "<script>('ไม่สามารถลบข้อมูลได้');</script>";
}

mysqli_close($conn);
?>