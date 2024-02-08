<?php

session_start();
require_once 'config/db.php';

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (empty($username)) {
        $_SESSION['error'] = 'กรุณากรอกชื่อ';
        header("location: login.php");
    } else if (empty($password)) {
        $_SESSION['error'] = 'กรุณากรอกรหัสผ่าน';
        header("location: login.php");
    } else if (strlen($_POST['password']) > 20 || strlen($_POST['password']) < 5) {
        $_SESSION['error'] = 'รหัสผ่านต้องมีความยาวระหว่าง 5 ถึง 20 ตัวอักษร';
        header("location: login.php");
    } else {
        try {

            $check_data = $conn->prepare("SELECT * FROM users WHERE username = :username");
            $check_data->bindParam(":username", $username);
            $check_data->execute();
            $row = $check_data->fetch(PDO::FETCH_ASSOC);
if ($check_data->rowCount() > 0) {
                if ($username == $row['username']) {
                    if (password_verify($password, $row['password'])) {
                        $userId = $row['id']; // เก็บค่า id ของผู้ใช้

                        // Set user ID in the session
                        $_SESSION['user_id'] = $userId;

                        // ตรวจสอบบทบาทของผู้ใช้
                        if ($row['urole'] == '1') {
                            $_SESSION['admin_login'] = $userId;
                            header("location: admin.php?id=$userId"); // ส่งค่า id ไปยังหน้า admin.php
                            exit(); // จบการทำงานทันทีหลังจาก header
                        } else {
                            $_SESSION['user_login'] = $userId;
                            header("location: user.php?id=$userId"); // ส่งค่า id ไปยังหน้า user.php
                            exit(); // จบการทำงานทันทีหลังจาก header
                        }
                    } else {
                        $_SESSION['error'] = 'รหัสผ่านผิด';
                        header("location: login.php");
                        exit(); // จบการทำงานทันทีหลังจาก header
                    }
                } else {
                    $_SESSION['error'] = 'อีเมลผิด';
                    header("location: login.php");
                    exit(); // จบการทำงานทันทีหลังจาก header
                }
            } else {
                $_SESSION['error'] = 'ไม่มีข้อมูลในระบบ';
                header("location: login.php");
                exit(); // จบการทำงานทันทีหลังจาก header
            }

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}

?>