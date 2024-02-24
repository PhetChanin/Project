<?php
ob_start();
session_start();
include 'config/server.php';
$amount = $_GET["amount"];

if(!isset($_SESSION["intLine"])) {
    // ตรวจสอบว่าแถวเป็นค่าว่างมั๊ย ถ้าว่างให้ทำงานใน {}
    $_SESSION["intLine"] = 0;
    $_SESSION["strProductID"][0] = $_GET["id"];   //รหัสสินค้า  
    $_SESSION["strQty"][0] = 1;                 //จำนวนสินค้า
    $_SESSION["itemChanged"] = 1;
$_SESSION["intLine"]++; // เพิ่มจำนวนรายการในตะกร้า
$_SESSION["strProductID"][$intNewLine] = $_GET["id"]; // คาดว่าคุณได้รับรหัสสินค้าจากสตริงคิวรีสตริง
$_SESSION["strQty"][$intNewLine] = 1; // คาดว่าคุณจะเพิ่มสินค้า 1 รายการทุกรายการ
    header("location:cart.php");
} else {
    $key = array_search($_GET["id"], $_SESSION["strProductID"]);
    if((string)$key != "") {
        if ($_SESSION["strQty"][$key] < $amount) {
            $_SESSION["strQty"][$key] += 1;
        } else {
            echo "ไม่สามารถเพิ่มสินค้าได้ เนื่องจากเกินจำนวนสินค้าสูงสุดที่กำหนด";
        }
    } else {
        $_SESSION["intLine"] = $_SESSION["intLine"] + 1;
        $intNewLine = $_SESSION["intLine"];
        $_SESSION["strProductID"][$intNewLine] = $_GET["id"];
        $_SESSION["strQty"][$intNewLine] = 1;
    }
    header("location:cart.php");
}

?>