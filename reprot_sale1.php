<?php
session_start();
include('config/server.php'); 
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
            <div class="card mb-4">
                <div class="card-header">
                    
                    <h4 class="alert alert-danger">รายงานสินค้าที่ชำระเงินแล้ว</h4>
                    <div>
                        <br>
                </div>
                <form name="form1" method="post" action="reprot_sale1.php">
                <div class="row">
                    <div class="col-sm-2"> 
                        <input type="date" name="dt1" class="form-control">
                    </div>
                    <div class="col-sm-2"> 
                        <input type="date" name="dt2" class="form-control">
                    </div>
                    <div class="col-sm-4">
                    <button type="submit" class="btn btn-primary"><img src="/work/img/search.png" alt="" width="16" height="16"></i>
                    </button>
                    </div>
                </div>
              </form>
                <div class="card-body">
                    <table id="datatablesSimple"class="table table-striped"> 
                        <thead>
                            <tr>
                                <th>เลขที่ใบสั่งซื้อ</th>
                                <th>ลูกค้า</th>
                                <th>วันที่สั่งซื้อ</th>
                                <th>ที่อยู่จัดส่งสินค้า</th>
                                <th>เบอร์โทรศัพท์</th>
                                <th>ราคารวมสุทธิ</th>
                                

                               
                            </tr>
                        </thead>
                        <?php
include('config/server.php');
$ddt1 = @$_POST['dt1'];
$ddt2 = @$_POST['dt2'];
$add_date = date('Y/m/d', strtotime($ddt2 . "+1 days"));
if (($ddt1 != "") && ($ddt2 != "")) {
    echo "ค้นหาจากวันที่ $ddt1 ถึง $ddt2";
    $sql = "select * from tb_order where order_status='2' and reg_data BETWEEN '$ddt1' and '$add_date' order by reg_data DESC";
} else {
    $sql = "select * from tb_order where order_status='2' order by reg_data DESC";
}
$total_sum = 0;
$result = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_array($result)) {
$total_sum = $total_sum + $row['total_price'];
?>
    <tr>
        <td><?= $row['orderID'] ?></td>
        <td><?= $row['cus_name'] ?></td>
        <td><?= $row['reg_data'] ?></td>
        <td><?= $row['address'] ?></td>
        <td><?= $row['telephone'] ?></td>
        <td><?= $row['total_price'] ?></td>

        <td>

        </td>

<?php
}
mysqli_close($conn)
?>

                        
                    </table>
                    <div class="text-end"><b>รวมเป็นเงิน<?=number_format($total_sum,2) ?>บาท</b></div>
                </div>
            </div>
        </main>
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
