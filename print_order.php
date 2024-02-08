<?php
session_start();
include 'config/server.php';
$sql = "select * from tb_order where orderID= '".$_SESSION["order_id"]."'";
$result = mysqli_query($conn, $sql);
$rs = mysqli_fetch_array($result);
$total_price = $rs['total_price'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>รายการสั่งซื้อ</title>
    <!-- Bootstrap CSS -->
   <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" >
   <!-- Option 1: Bootstrap Bundle with Popper -->
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</head>
<body>
<div class="container">
  <div class="row">
    <div class="col-md-10">
      <div class="alert alert-success h4 text-center mt-4" role="alert">
        การสั่งซื้อเสร็จสมบูรณ์
      </div>
      เลขที่การสั่งซื้อ : <?=$rs['orderID'];?> <br>
      ชื่อ-นามสกุล (ลูกค้า) : <?=$rs['cus_name'];?> <br>
      ที่อยู่การจัดส่ง : <?=$rs['address']; ?> <br>
      เบอร์โทรศัพท์ : <?=$rs['telephone'];?>  <br>
      <br>
      <div class="card mb-4 mt-4">
        <div class="card-body">
          <table class="table table-hover">
            <thead>
              <tr>
                <th>รหัสสินค้า</th>
                <th>ชื่อสินค้า</th>
                <th>ราคา</th>
                <th>จำนวนที่สั่งซื้อ</th>
                <th>ราคารวม</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $sql1 = "select * from order_detail d,product p where d.pro_id=p.pro_id and d.orderID= '".$_SESSION["order_id"]."'";
              $result1 = mysqli_query($conn, $sql1);
              while($row = mysqli_fetch_array($result1)){
              ?>
              <tr>
                <td><?=$row['pro_id']?></td>
                <td><?=$row['pro_name']?></td>
                <td><?=$row['orderPrice']?></td>
                <td><?=$row['orderQty']?></td>
                <td><?=$row['Total']?></td>
              </tr>
              <?php
              }
              ?>
            </tbody>
          </table> 
          <h6 class="text-end"> ค่าจัดส่ง  100.00 บาท </h6>
          <h6 class="text-end"> รวมเป็นเงิน <?=number_format($total_price, 2)?> บาท </h6>
        </div>
      </div>
      <div>
        ***กรุณาโอนเงินภายใน 7 วัน หลังการซื้อ โอนเงินผ่านธนาคาร SCB ชื่อบัญชี นายมะยม เรียนดี ประเภทบัญชีออมทรัพย์ เลขที่บัญชี 999999999 <br>
      </div>
      <div id="printButton" class="text-center">
        <a href="user.php" class="btn btn-success">Back</a>
        <button onclick="printPage()" class="btn btn-success">Print</button>
    </div>
    </div>
  </div>
  <script>
        function printPage() {
            var printButton = document.getElementById("printButton");
            printButton.style.display = "none"; 
            window.print();
            printButton.style.display = "block"; 
        }
    </script>
</div>
</body>
</html>
