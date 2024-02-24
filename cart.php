<?php
session_start();
require_once 'config/db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
   <!-- Bootstrap CSS -->
   <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" >
     <!-- Option 1: Bootstrap Bundle with Popper -->
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>

</head>
<body>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var cartItemCount = <?php echo isset($_SESSION["intLine"]) ? $_SESSION["intLine"] : 0; ?>;  
        document.getElementById("cartItemCount").innerText = cartItemCount;
        if (cartItemCount > 0) {
            document.getElementById("cartItemCount").classList.add("bg-danger");
        } else {
            document.getElementById("cartItemCount").classList.remove("bg-danger");
        }
        var updatedCartItemCount = <?php echo isset($_SESSION["intLine"]) ? $_SESSION["intLine"] : 0; ?>;
        var itemChanged = <?php echo isset($_SESSION["itemChanged"]) ? $_SESSION["itemChanged"] : 0; ?>;
        if (itemChanged === +1) {
            document.getElementById("cartItemCount").innerText = cartItemCount + 1;
        }
        if (itemChanged === -1) {
            document.getElementById("cartItemCount").innerText = updatedCartItemCount;
        }
        <?php $_SESSION["itemChanged"] = 0 ?>
    });
</script>
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
                <span class="badge rounded-pill badge-notification bg-danger" id="cartItemCount" style="position: absolute; top: -5px; right: -5px;" >></span>
              </a>
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


    <div class = "container" >
    <form id="form1" method="POST" action="insert_cart.php" enctype="multipart/form-data">

    <div class = "row">
        <div class = "col-md-10">
        <br><div class="alert alert-success" role="alert">
  การสั่งซื้อสินค้า
</div>
<?php
if (isset($_SESSION["intLine"]) && $_SESSION["intLine"] >= 0) {
?>
    <table class="table table-hover">
    <tr>
        <th>ลำดับที่</th>
        <th>ชื่อสินค้า</th>
        <th>ราคา</th>
        <th>จำนวนสินค้าที่สั่ง</th>
        <th>สินค้าในสต็อก</th>
        <th>ราคารวม</th>
        <th>เพิ่ม - ลด</th>
        <th>ลบ</th>
    </tr>

    <?php
    include('config/server.php');
    $sumPrice = 0;
    $sumPriceProduct = 0;
    $displayOrder = 1;
    for ($i = 0; $i <= (int)$_SESSION["intLine"]; $i++) {
        if (isset($_SESSION["strProductID"][$i]) && $_SESSION["strProductID"][$i] != "") {
            $sql1 = "SELECT * FROM product WHERE pro_id = '" . $_SESSION["strProductID"][$i] . "'";
            $result1 = mysqli_query($conn, $sql1);
            $row_pro = mysqli_fetch_array($result1);
            $Total = $_SESSION["strQty"][$i];
            $sum = $Total * $row_pro['price'];
            $sumPrice += $sum;
            $sumPriceProduct = $sumPrice + 100;
            $_SESSION["sumPriceProduct"] = $sumPriceProduct;
    ?>
            <tr>
                <td><?= $displayOrder++ ?></td>
                <td><img src="../work/image/<?= $row_pro['image'] ?>" width="80" height="100" class="border"><?= $row_pro['pro_name'] ?></td>
                <td><?= $row_pro['price'] ?></td>
                <td><?= $_SESSION["strQty"][$i] ?></td>
                <td><?= $row_pro['amount'] ?> </td>
                <td><?= $sum ?></td>
                <td>
                    <a href="order.php?id=<?= $row_pro['pro_id']?>& amount=<?= $row_pro['amount'] ?>" class="btn btn-outline-primary">+</a>
                    <?php if ($_SESSION["strQty"][$i] > 1) { ?>
                        <a href="order_del.php?id=<?= $row_pro['pro_id'] ?>" class="btn btn-outline-primary">-</a>
                    <?php } ?>
                </td>
                <td><a href="pro_delete.php?Line=<?= $i ?>"><img src="img/delete.png" width="30"></a></td>
            </tr>
    <?php
        }
    }
    ?>
    <tr>
        <td class="text-end" colspan="4">ค่าจัดส่ง</td>
        <td class="text-center">100</td>
        <td>บาท</td>
    </tr>
    <tr>
        <td class="text-end" colspan="4">รวมเป็นเงิน</td>
        <td class="text-center"><?= $sumPriceProduct ?></td>
        <td>บาท</td>
    </tr>
</table>
    <div style= "text-align:right">
    <a href="user.php"><button type = "button" class="btn btn-outline-secondary">เลือกสินค้า</button></a>
    <button type="submit" class="btn btn-outline-primary">ยืนยันการสั่งซื้อ</button>
    
    </div>
        </div>
   
    <?php
} else {
    // No products in the system
    echo '<div class="alert alert-warning" role="alert">ไม่มีสินค้าในระบบ</div>';
}
?>
 <br>
        <div class="row">
    <div class="col-md-4">
    <div class="alert alert-success" role="alert">
    <h4 class="alert-heading">ข้อมูลสำหรับจัดส่งสินค้า</h4>
</div>
ชื่อ-นามสกุล:
<input tpe = "text" name="cus_name" class ="form-control mt-2" required placeholder = "ชื่อ-นามสกุล...."><br>
ที่อยู่จัดส่งสินค้า:<br>
<textarea class = "from-control mt-2" required placeholder = "ที่อยู่...." name = "cus_add" rows="3"></textarea><br>
เบอร์โทรศัพท์:
<input tpe = "number" name="cus_tel" class ="form-control mt-2" required placeholder = "เบอร์โทรศัพท์...."><br>
    <div class="alert alert-success" role="alert">
<h4 class="alert-heading">แนบสลิป</h4></div>
  <h5> *** ธนาคาร SCB ชื่อบัญชี นายมะยม เรียนดี ประเภทบัญชีออมทรัพย์ เลขที่บัญชี 999999999 *** </h5><br>
<label> รูปภาพ: </label>
    <img src= "image1/" width = "120">
    <input type = "file" name = "file1" required> <br><br><br>
    </div>
  </div>
    </form>
    <br><br><br>
        </div>
</body>
</html>