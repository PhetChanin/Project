<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    
</head>
<body>

<div class="header" align="center">
<br>
<br> 
<br>

</div>
        <form action="login_db.php"  method="post">
            <?php if(isset($_SESSION['error'])) { ?>
                <div class="alert alert-danger" role="alert">
                    <?php 
                        echo $_SESSION['error'];
                        unset($_SESSION['error']);
                    ?>
                </div>
            <?php } ?>
            <?php if(isset($_SESSION['success'])) { ?>
                <div class="alert alert-success" role="alert">
                    <?php 
                        echo $_SESSION['success'];
                        unset($_SESSION['success']);
                    ?>
                </div>
            <?php } ?>

            <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card">
                    <div class="card">
                        <div class="card-header bg-primary text-white text-center"><h2>Login</h2> </div>
                        <div class="card-body">
                                <div class="mb-3">
                                <div class="mb-3 ">
                                    <label for="username" class="form-label">Username</label>
                                    <input type="username" class="form-control" name="username" aria-describedby="username">
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control" name="password">
                                </div>
                                <div align="center">
                                <button type="submit" align="center" name="login" class="btn btn-primary">login</button>
                                </div>
                                <br>
                                <p class="text-center">ยังไม่เป็นสมาชิกใช่ไหม? <a href="register.php">คลิกที่นี่เพื่อสมัครสมาชิก</a></p>
                            </form>
                        </div>
                    </div>
                </div>              
            </div>
        </div>
       
    
</body>
</html>