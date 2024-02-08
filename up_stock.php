<?php
session_start();
include('config/server.php'); 
$ids=$_POST['pid'];
$nums=$_POST['pnum'];

$sql="UPDATE product set amount= amount + $nums WHERE pro_id='$ids' ";
$hand=mysqli_query($conn,$sql);
if($hand){
    echo "<script>alert('อัปเดคจำนวนสินค้าเรียบร้อย'); </script>"; 
    echo "<script>window.location='index_admin.php'; </script>";
}else{
    echo "<script>alert('ไม่สามารถอัปเดคจำนวนสินค้าได้'); </script>"; 

}
mysqli_close($conn);
?>