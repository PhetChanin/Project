<?php
session_start();
include 'config/server.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


if (isset($_SESSION['user_login']) || isset($_SESSION['admin_login'])) {
    
    if (isset($_SESSION['user_id'])) {
        $userId = $_SESSION['user_id'];

        
        $sql = "SELECT * FROM users WHERE id=?";
        $stmt = mysqli_prepare($conn, $sql);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "i", $userId);
            mysqli_stmt_execute($stmt);

            $result = mysqli_stmt_get_result($stmt);

            if ($result && mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
            } else {
                echo "ไม่พบข้อมูลผู้ใช้";
                exit();
            }

            mysqli_stmt_close($stmt);
        } else {
            echo "เกิดข้อผิดพลาดในการเตรียมคำสั่ง SQL";
            exit();
        }
    } else {
        echo "ไม่ได้กำหนดคีย์ 'user_id' ใน session";
        exit();
    }
} else {
    echo "ไม่ได้เข้าสู่ระบบ";
    exit();
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $username = $_POST['username'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];

    
    $updateSql = "UPDATE users SET username=?, firstname=?, lastname=?, email=? WHERE id=?";
    $updateStmt = mysqli_prepare($conn, $updateSql);

    if ($updateStmt) {
        mysqli_stmt_bind_param($updateStmt, "ssssi", $username, $firstname, $lastname, $email, $userId);
        mysqli_stmt_execute($updateStmt);

        echo "<script>alert('บันทึกข้อมูลเรียบร้อย');</script>";
        echo "<script>window.location='edit_user.php';</script>";

        mysqli_stmt_close($updateStmt);
    } else {
        echo "<script>alert('ไม่สามารถบันทึกข้อมูลได้');</script>";
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    

</head>
<body>
    

</body>
</html>
