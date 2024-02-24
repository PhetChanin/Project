<?php
session_start();
include('config/server.php'); 

$ids = $_GET['id'];
$sql = "DELETE FROM product WHERE pro_id='$ids'";
$result = mysqli_query($conn, $sql);

if($result) {
    echo "<script>window.location='admin.php';</script>";
} else {
    echo "<script>alert('ไม่สามารถลบข้อมูลได้');</script>";
}

mysqli_close($conn);
?>