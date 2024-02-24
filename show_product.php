<?php 
session_start();
require_once 'config/db.php'; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Show Product</title>
     <!-- Bootstrap CSS -->
     <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" >
     <!-- Option 1: Bootstrap Bundle with Popper -->
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>

</head>
<body>
 
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

            
<div style=" width:30px; height:50px; margin-right: 30px; display: flex; align-items: center;">
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
  <div class="container"> 

  <div class="alert bg-success-subtle h4 text-center mb-4 mt-4" role="alert">
 แสดงข้อมูลสินค้า
</div>
<a href="fr_product.php" id="addProductBtn" class="btn btn-primary active mb-4" aria-current="page">Add+</a>
<table class="table table-bordered border-primary">
<tr> 
    <th>รหัสสินค้า</th>
    <th>ชื่อสินค้า</th>
    <th>ประเภท</th>
    <th>ราคา</th>
    <th>จำนวน</th>
    <th>รายละเอียด</th>
    <th>รูปภาพ</th>
    <th>แก้ไข</th>
    <th>ลบสินค้า</th>
</tr>
<?php
include('config/server.php');

if(isset($_POST['search'])) {
    $search_value = $_POST['search'];
   
    $sql = "SELECT * FROM product WHERE pro_name LIKE '%$search_value%' ORDER BY pro_id";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        echo '<div class="row">';
        while ($row=mysqli_fetch_array($result)){
            echo '<tr>';
            echo '<td>'.$row['pro_id'].'</td>';
            echo '<td>'.$row['pro_name'].'</td>';
            echo '<td>'.$row['type_id'].'</td>';
            echo '<td>'.$row['price'].'</td>';
            echo '<td>'.$row['amount'].'</td>';
            echo '<td>'.$row['detail'].'</td>';
            echo '<td><img src="image/'.$row['image'].'" width="150px" height="100px"></td>';
            echo '<td> <a href="edit_product.php?id='.$row['pro_id'].'"> Edit </a></td> ';
            echo '<td> <a href="delete_product.php?id='.$row['pro_id'].'"> ลบ </a></td> ';
            echo '</tr>';
        }
        echo '</div>';
        
    } else {
        echo "ไม่พบสินค้าที่ค้นหา";
    }
}

mysqli_close($conn);
?>
</table> 
    
  </div>   



</body>
</html>