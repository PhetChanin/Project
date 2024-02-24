<?php 
session_start();
 include('config/server.php'); 
$idpro = $_GET['id'];
$sql1 = "SELECT * FROM product WHERE pro_id = '$idpro' ";
$result = mysqli_query($conn,$sql1);
$rs=mysqli_fetch_array($result);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</head>
<body>

    <div class = "container">
        <div class = "row">
            <div class = "col-sm-6"  >
            </div>
<div class="alert bg-success-subtle h4 text-center mb-4 mt-4" role="alert">
 แก้ไขข้อมูลสินค้า
</div>
<form name = "form1" method = "post" action= "#" enctype = "multipart/form-data" >
    <label> รหัสสินค้าสินค้า: </label>
    <input type = "text" name = "proid" class = "form-control"  value =<?=$rs['pro_id']?>>   
    <label> ชื่อสินค้า: </label>
    <input type = "text" name = "pname" class = "form-control"  value =<?=$rs['pro_name']?>>     
    <label> ประเภทสินค้า: </label>

    <select class="form-select" name = "typeID">

    <?php
    $sql="SELECT * FROM type ORDER BY type_name";
    $hand=mysqli_query($conn,$sql);
    while($row=mysqli_fetch_array($hand)){
    

    ?>

     <option value="<?=$row['type_id']?>"><?=$row['type_name']?></option>
    <?php
    }
    mysqli_close($conn);
    ?>
    </select>

    <label> ราคา: </label>
    <input type = "text" name = "price" class = "form-control"  value =<?=$rs['price']?>> <br>
    <label> จำนวน: </label>
    <input type = "text" name = "num" class = "form-control" value =<?=$rs['amount']?>> <br>
    <label> รายละเอียด: </label>
    <input type = "text" name = "detail" class = "form-control" value =<?=$rs['detail']?>> <br>
    <label> รูปภาพ: </label>
    <img src= "image/<?=$rs['image']?>" width = "120">
    <input type = "file" name = "file1" required> <br>
    <input type = "hidden" name = "txting" class = "form-control" value =<?=$rs['image']?>>
    <button type="Submit" class="bg-success-subtle">Uudate</button>
    <input class="bg-success-subtle" type="reset" value="Cancel">
    
</form>        
        </div>
    </div>
</body>
</html>