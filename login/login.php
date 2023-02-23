<?php
    session_start();
        require('../connect/connect.php');
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ເຂົ້າສູ່ລະບົບ</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="../css/login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css" integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>


    <div class="form">
        <h1>ເຂົ້າສູ່ລະບົບ</h1>
    <?php if (isset($_SESSION['error'])) { ?>
        <?php echo $_SESSION['error'];
            unset($_SESSION['error']);
        ?>
        <?php } ?>
        <?php if (isset($_SESSION['success'])) { ?>
            <?php echo $_SESSION['success'];
            unset($_SESSION['success']);
        }
            ?>
        <p><i class="fa-solid fa-user"></i></p>
        <p>User</p>

        <form action="login_db.php" method="post">
        <div class="inputbox">
            <input type="text" name="userid" required>
            <span>ລະຫັດພະນັກງານ</span>
        </div>
        <div class="inputbox">
            <input type="password" name="password" required>
            <span>ລະຫັດຜ່ານ</span>
        </div>
        <div class="inputbox">
            <div class="btn">
            <input type="submit" name="submit" value="ເຂົ້າສູ່ລະບົບ" >
            <input type="reset" value="ລ້າງຂໍ້ມູນ">
            
            </div>
            
        </div>
        
        </form>
        
        
    </div>
</body>
</html>
