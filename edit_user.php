<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include 'config/server.php';

$ids = isset($_GET['id']) ? $_GET['id'] : null;

if ($ids !== null) {
    $sql = "SELECT * FROM users WHERE id=?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $ids);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
}

mysqli_close($conn);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script></head>
    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
    <link rel="stylesheet" href="css.css">
    
    <body>
<nav class="navbar navbar-expand-lg bg-success-subtle">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">
        <a href="user.php"><img src="/work/img/logo1.png" alt="อัจฉราโรงกลึง" width="150" height="75" ></a>
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="user.php">หน้าหลัก</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
             เมนู
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="show_productuser.php">สินค้า</a></li>
             
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
        <form action="show_productuser.php" method="post" class="d-flex" role="search" style="margin-right: 250px;">
                <input list="products" class="form-control me-2" type="search" placeholder="Search" aria-label="Search" style="width: 600px;" name="search" >
                <button class="btn btn-success" type="submit"><img src="/work/img/search.png" width="30" height="30"></button>
                <datalist id="products">
                    <?php echo $datalist; ?>
                </datalist>
            </form>
        </div>

            <div style="position: relative; display: inline-block; margin-right: 20px; d-flex p-2">
              <a class="nav-link active" aria-current="page" href="cart.php" style="width: 40px; height: 40px; display: flex; justify-content: center; align-items: center; position: relative;">
                <iconify-icon icon="ic:baseline-shopping-cart" style="font-size: 30px;"></iconify-icon>
                <span class="badge rounded-pill badge-notification bg-danger" style="position: absolute; top: -5px; right: -5px;"></span>
              </a>
            </div>
            <div style=" width:30px; height:50px; margin-right: 30px; display: flex; align-items: center;">
            <?php
include('config/server.php');


if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


if (isset($_SESSION['user_login']) || isset($_SESSION['admin_login'])) {
    
    if (isset($_SESSION['user_id'])) {
        $userId = $_SESSION['user_id'];

        
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
                <a class="dropdown-item" href="H_order.php">รายการสินค้าที่สั่งซื้อแล้ว</a>
                </li>
                <li>
                <a class="dropdown-item" href="edit_user.php">แก้ไขข้อมูลส่วนตัว</a>
                </li>
                <li>
                <a class="dropdown-item" href="login.php">Logout</a>
                </li>
              
              </ul>
            </div>
         
          </div>
    </div>
  </nav>
  <<div class="container">
    <div class="row">
        <div class="col-sm-6"> 
            <div class="h4 text-center alert alert-success mb-4 mt-4" role="alert">แก้ไขข้อมูลสมาชิก</div>

            <form method="POST" action="Update_user.php">
        <label>Username:</label>
        <input type="text" name="username" class="form-control" value="<?= isset($row['username']) ? $row['username'] : '' ?>"> <br>

        <label>ชื่อ:</label>
        <input type="text" name="firstname" class="form-control" value="<?= isset($row['firstname']) ? $row['firstname'] : '' ?>" > <br>

        <label>นามสกุล:</label>
        <input type="text" name="lastname" class="form-control" value="<?= isset($row['lastname']) ? $row['lastname'] : '' ?>" > <br>

        <label>Email:</label>
        <input type="text" name="email" class="form-control" value="<?= isset($row['email']) ? $row['email'] : '' ?>"> <br>

        <input type="submit" value="Update" class="btn btn-success">
        <a href="user.php" class="btn btn-danger">Cancel</a>
    </form>

        </div>
    </div>
</div>

  </body>
  </html>