<?php
    ob_start();
    session_start();
    include 'config/server.php';

    if(isset($_GET["Line"]))
    {
        $Line = $_GET["Line"];

        // ตรวจสอบว่าตำแหน่งที่ต้องการลบไม่เป็นค่าว่าง
        if($_SESSION["strProductID"][$Line] != "")
        {
            // ตรวจสอบว่ามีจำนวนสินค้ามากกว่า 1 ชิ้น
            if($_SESSION["strQty"][$Line] > 1)
            {
                // ลดจำนวนสินค้า 1 ชิ้น
                $_SESSION["strQty"][$Line]--;
            }
            else
            {
                // ลบสินค้าที่ตำแหน่งที่ระบุ ถ้ามีเพียง 1 ชิ้น
                unset($_SESSION["strProductID"][$Line]);
                unset($_SESSION["strQty"][$Line]);
                $_SESSION["itemChanged"] = $Line;
                $_SESSION["intLine"]--;

                // ตรวจสอบว่าตะกร้าไม่ว่าง
                if(count($_SESSION["strProductID"]) > 0)
                {
                    // รีอินเด็กซ์ของ strProductID และ strQty
                    $_SESSION["strProductID"] = array_values($_SESSION["strProductID"]);
                    $_SESSION["strQty"] = array_values($_SESSION["strQty"]);
                }
                else
                {
                    // ถ้าไม่มีสินค้าในตระกร้าให้ตะกร้าขึ้นเป็นเลข 0
                    $_SESSION["intLine"] = 0;
                }
            }
        }
    }

    header("location:cart.php");
?>
