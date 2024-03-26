<?php
session_start();
include('config/server.php');

//รายการสั่งซื้อสินค้าที่ยังไม่ชำระเงิน
$sql1="select COUNT(orderID) AS order_no from tb_order where order_status='1' ";
$hand1=mysqli_query($conn,$sql1);
$row1=mysqli_fetch_array($hand1);
//รายการสั่งซื้อสินค้าที่ชำระเงินแล้ว
$sql2="select COUNT(orderID) AS order_yes from tb_order where order_status='2' ";
$hand2=mysqli_query($conn,$sql2);
$row2=mysqli_fetch_array($hand2);
//รายการสั่งซื้อสินค้าที่ยกเลิกใบสั่งซื้อ
$sql3="select COUNT(orderID) AS order_cancle from tb_order where order_status='0' ";
$hand3=mysqli_query($conn,$sql3);
$row3=mysqli_fetch_array($hand3);
//รายการสั่งซื้อสินค้าที่เหลือน้อยกว่า10ชิ้น
$sql4="select COUNT(pro_id) AS pro_num from product where amount < 10 ";
$hand4=mysqli_query($conn,$sql4);
$row4=mysqli_fetch_array($hand4);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
    <link rel="stylesheet" href="css.css">
  </head>
    <body class="sb-nav-fixed">
    <nav class="navbar navbar-expand-lg bg-success-subtle">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">
        <img src="/work/img/logo1.png" alt="อัจฉราโรงกลึง" width="150" height="75" >
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="admin.php">หน้าหลัก</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              เมนู
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="index_admin.php">Product</a></li>
              <li><a class="dropdown-item" href="show_product.php">แก้ไขสินค้า</a></li>
              <li><a class="dropdown-item" href="reprot_sale1.php">รายงานการสั่งซื้อ</a></li>
            </ul>
          </li>
          <?php
            include('config/server.php'); 
            $sql="SELECT * FROM product ORDER BY pro_name ";
            $result = mysqli_query($conn,$sql);
            $datalist = "";
            while ($row=mysqli_fetch_array($result)){
                $datalist .= "<option value='" . $row['pro_name'] . "'>";
            }
            mysqli_close($conn);
        ?>
        <div style="display: flex; align-items: center;">
        <form action="show_product.php" method="post" class="d-flex" role="search" style="margin-right: 250px;">
                <input list="products" class="form-control me-2" type="search" placeholder="Search" aria-label="Search" style="width: 600px;" name="search" >
                <button class="btn btn-success" type="submit"><img src="/work/img/search.png" width="30" height="30"></button>
                <datalist id="products">
                    <?php echo $datalist; ?>
                </datalist>
            </form>
        </div>

            <div style=" width:30px; height:50px; margin-right: 50px; display: flex; align-items: center;">
            <?php
include('config/server.php');

// Ensure session_start() is called only once at the beginning
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if the user is logged in and if the user ID is set in the session
if (isset($_SESSION['user_login']) || isset($_SESSION['admin_login'])) {
    // Get the user ID from the session
    if (isset($_SESSION['user_id'])) {
        $userId = $_SESSION['user_id'];

        // Use prepared statements to prevent SQL injection
        $sql = "SELECT * FROM users WHERE id = ?";

        $stmt = mysqli_prepare($conn, $sql);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "i", $userId);
            mysqli_stmt_execute($stmt);

            $result = mysqli_stmt_get_result($stmt);

            if ($result && mysqli_num_rows($result) > 0) {
                echo '<div class="row">';
                while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                    echo '<tr>';
                    echo '<td>' . $row['firstname'] . '</td>';
                    echo '<td>' . $row['lastname'] . '</td>';
                }
                echo '</div>';
            } else {
                echo "ไม่พบข้อมูลผู้ใช้";
            }

            mysqli_stmt_close($stmt);
        } else {
            echo "เกิดข้อผิดพลาดในการเตรียมคำสั่ง SQL";
        }
    } else {
        echo "ไม่ได้กำหนดคีย์ 'user_id' ใน session";
    }
} else {
    echo "ไม่ได้เข้าสู่ระบบ";
}

mysqli_close($conn);
?>
            </div>
            <div class="dropdown" style="display: inline-block; margin-right: 20px;">
              <button class="btn btn-secondary rounded-circle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false" style="width: 40px; height: 40px; padding: 0;">
                <iconify-icon icon="carbon:user-avatar-filled" width="100%" height="100%" style="border-radius: 50%;"></iconify-icon>
              </button>
              <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                <li>
                  <a class="dropdown-item" href="login.php">Logout</a>
                </li>
              </ul>
            </div>
          </div>
    </div>
  </nav>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                    <h1 class="alert alert-danger">ข้อมูลการสั่งซื้อและข้อมูลสินค้า</h1>
                        
                        <div class="row">
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-primary text-white mb-4">
                                    <div class="card-body">รายการสั่งซื้อสินค้า(ยังไม่ชำระเงิน)<h4>[<?=$row1['order_no']?>]</h4></div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="report_order.php">View Details</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-success text-white mb-4">
                                    <div class="card-body">รายการสั่งซื้อสินค้า(ชำระเงินแล้ว)<h4>[<?=$row2['order_yes']?>]</h4></div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="report_order_yes.php">View Details</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-danger text-white mb-4">
                                    <div class="card-body">รายการสั่งซื้อสินค้า(ยกเลิกใบสั่งซื้อ)<h4>[<?=$row3['order_cancle']?>]</h4></div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="report_order_no.php">View Details</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                            <div class="card bg-warning text-white mb-4">
                                <div class="card-body">รายการสั่งซื้อสินค้าที่เหลือน้อยกว่า10ชิ้น<h4>[<?=$row4['pro_num']?>]</h4></div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                     <a class="small text-white stretched-link" href="pro_stock.php">View Details</a>
                                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                DataTable Example
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered border-primary">
                                    <thead>
                                        <tr>
                                            <th>รหัสสิค้า</th>
                                            <th>ชื่อสินค้า</th>
                                            <th>รายละเอียด</th>
                                            <th>ประเภทสินค้า</th>
                                            <th>ราคา</th>
                                            <th>จำนวน</th>
                                            <th>สต็อกสินค้า</th>
                                        </tr>
                                        
                                    </thead>
                                    <tbody>
                                        <?php
                                        include('config/server.php');
                                        $sql = "SELECT * FROM product p, type t WHERE p.type_id = t.type_id";
                                        $hand = mysqli_query($conn, $sql);
                                        while ($row = mysqli_fetch_array($hand)) {  
                                            ?>
                                        <tr>
                                        <td><img src="/work/image/<?php echo $row['image']; ?>" width="150px" height="100px"></td>
                                        <td><?= $row['pro_id'] ?></td>
                                        <td><?= $row['pro_name'] ?></td>
                                        <td><?= $row['detail'] ?></td>
                                        <td><?= $row['price'] ?></td>
                                        <td><?=$row['amount'] ?></td>
                                        <td><a href="addStock.php?id=<?=$row['pro_id']?>"class="btn btn-success">เพิ่ม</a></td>

                                        </tr>
                                        
                                        <?php
                                        }
                                        mysqli_close($conn);
                                        ?>
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </main>
                
            </div>
        </div>
        <footer class="foot">   
    <marquee behavior="" direction="">
  ติดต่อ/ติดตามสินค้า ได้ที่ LINE ID : @139wwlud Tel : 064-1749954
  </marquee>
  </footer>
    </body>
    </html>