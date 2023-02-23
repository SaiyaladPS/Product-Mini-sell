<?php
    session_start();

    if (isset($_GET['logout'])) {
        unset($_SESSION['login_admin']);
        unset($_SESSION['login_user']);
        $_SESSION['success'] = "<script>
        Swal.fire({
            icon: 'success',
            title: 'ທ່ານໄດ້ອອກຈາກລະບົບສຳເລັດແລ້ວ',
            showConfirmButton: false,
            timer: 1500
          })
        </script>";
        header("location: ../login/login.php");
    }


?>