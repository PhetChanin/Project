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
                    
                    <h4 class="alert alert-danger">แสดงข้อมูลการสั่งซื้อสินค้า (ยังไม่ได้ชำระเงิน) </h4>
                    <div>
                        <br>
                    <a href = "report_order_yes.php"><button type="button" class="btn btn-outline-success ">ชำระเงินแล้ว</button></a>
                    <a href = "report_order.php"><button type="button" class="btn btn-outline-success">ยังไม่ชำระเงิน</button></a>
                    <a href = "report_order_no.php"><button type="button" class="btn btn-outline-success">ยกเลิกใบสั่งซื้อ</button></a>
                </div>
                <div class="card-body">
                    <table id="datatablesSimple"class="table table-striped"> 
                        <thead>
                            <tr>
                                <th>เลขที่ใบสั่งซื้อ</th>
                                <th>ลูกค้า</th>
                                <th>ที่อยู่จัดส่งสินค้า</th>
                                <th>เบอร์โทรศัพท์</th>
                                <th>ราคารวมสุทธิ</th>
                                <th>วันที่สั่งซื้อ</th>
                                <th>สถานะการสั่งซื้อ</th>
                                <th>รายละเอียด</th>
                                <th>ปรับสถานะการชำระเงิน</th>
                                <th>ยกเลิกการสั่งซื้อ</th>
                            </tr>
                        </thead>
                            <?php
                            include('config/server.php');
                            $sql = "select * from tb_order where order_status='1' order by reg_data DESC";
                            $result = mysqli_query($conn, $sql);
                            while ($row = mysqli_fetch_array($result)) {
                            $status = $row['order_status'];
                           ?>
                                <tr>
                                    <td><?= $row['orderID'] ?></td>
                                    <td><?= $row['cus_name'] ?></td>
                                    <td><?= $row['address'] ?></td>
                                    <td><?= $row['telephone'] ?></td>
                                    <td><?= $row['total_price'] ?></td>
                                    <td><?= $row['reg_data'] ?></td>
                                    <td>
                                        <?php
                                        if($status == 1){
                                            echo "<b style='color:blue'> ยังไม่ชำระเงิน </b>";
                                        }else if ($status == 2){
                                            echo "<b style='color:green'> ชำระเงินแล้ว </b>";
                                        }else if ($status == 0){
                                            echo "<b style='color:red'> ยกเลิกการสั่งซื้อ </b>";
                                        }
                                        ?>
                                    </td>
                                    <td><a href="report_order_detail.php?id=<?= $row['orderID'] ?>" class="btn btn-success">รายละเอียด</a></td>
                                    <td><a href="pay_order.php?id=<?= $row['orderID'] ?>" class="btn btn-warning" onclick="del1(this.href); return false;">ปรับสถานะ</a></td>
                                    
                                    <td><a href="cancel_order.php?id=<?= $row['orderID'] ?>" class="btn btn-danger" onclick="del(this.href); return false;">ยกเลิก</a></td>
                                </tr>
                            <?php
                            }
                            //mysqli_close($conn)
                            ?>
                        
                    </table>
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

        <script>
    function del(mypage) {
        var agree = confirm('คุณต้องการยกเลิกใบสั่งซื้อสินค้าหรือไม่');
        if (agree) {
            window.location = mypage;
        }
    }

    function del1(mypage1) {
        var agree = confirm('คุณต้องการปรับสถานะการชำระเงินหรือไม่');
        if (agree) {
            window.location = mypage1;
        }
    }
</script>
