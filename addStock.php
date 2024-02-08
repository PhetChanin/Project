<?php
session_start();
include('config/server.php'); 
$ids=$_GET['id'];
$sql="SELECT * FROM product WHERE pro_id='$ids'"; 
$hand=mysqli_query($conn,$sql);
$row=mysqli_fetch_array($hand);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- Bootstrap CSS -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" >
     <!-- Option 1: Bootstrap Bundle with Popper -->
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>

</head>
<body>
    <div class="container">
    <div class="row">
    <div class="col-sm-5">
    
    <div class = "alert-success mt-4" role="alert">
   <h4 class="alert alert-danger"> เพิ่มจำนวนสินค้าในสต็อก</h4>
    </div>
    
<form name = "form1" method="post" action="up_stock.php">
<div class ="mb-3 mt-3">
<lable>รหัสสิค้า:</lable>
<input type="text" name="pid" class="form-control"redonly value="<?=$row['pro_id']?>">
</div>
<div class ="mb-3">
<lable>ชื่อสินค้า:</lable>
<input type="text" name="pname" class="form-control"redonly value="<?=$row['pro_name']?>">
</div>
<div class ="mb-3 mt-3">
<lable>เพิ่มจำนวนสินค้า:</lable>
<input type="text" name="pnum" class="form-control" required >
</div>
<input type="submit" name="submit" class= "btn btn-success" value="Submit">
<a href = "index_admin.php" class="btn btn-danger">cancel</a>
</from>
</div> 
  </div>
</div> 
</body>
</html>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
        <script src="js/datatables-simple-demo.js"></script>
