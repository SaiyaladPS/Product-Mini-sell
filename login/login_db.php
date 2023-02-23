<?php
    session_start();
    include('../connect/connect.php');

    if (isset($_POST['submit'])) {
        $userid = $_POST['userid'];
        $password = $_POST['password'];

            if (empty($userid)) {
                $_SESSION['error'] = "<script>
                Swal.fire({
                    icon: 'warning',
                    title: 'ກະລຸນາປ້ອນລະຫັດພະນັກງານເພືອເຂົ້າສູ່ລະບົບ',
                    confirmButtonText: 'ຕົກລົງ'
                })
                </script>";
                header("location: login.php");
            } else if (empty($password)) {
                $_SESSION['error'] = "<script>
                Swal.fire({
                    icon: 'warning',
                    title: 'ກະລຸນາປ້ອນລະຫັດຜ່ານຂອງທ່ານເພືອເຂົ້າສູ່ລະບົບ',
                    confirmButtonText: 'ຕົກລົງ'
                })
                </script>";
                header("location: login.php");
            } else {
                $login_check_sql = "SELECT * FROM login WHERE id = '$userid' AND password = '$password'";
                $login_check_query = mysqli_query($conn,$login_check_sql);
                $login_check_numrows = mysqli_num_rows($login_check_query);

                    if ($login_check_numrows === 0) {
                        $_SESSION['error'] = "<script>
                        Swal.fire({
                            icon: 'error',
                            title: 'ລະຫັດຜ່ານ ຫຼຶ ຊື່ຂອງທ່ານບໍ່ຖືກຕ້ອງ',
                            confirmButtonText: 'ຕົກລົງ'
                        })
                        </script>";
                        header("location: login.php");
                    } else {
                        $login_useradmin_sql = "SELECT useradmin FROM login WHERE id = '$userid' AND password = '$password' ";
                        $login_useradmin_query = mysqli_query($conn,$login_useradmin_sql);
                        $login_useradmin_row = mysqli_fetch_assoc($login_useradmin_query);

                            if ($login_useradmin_row['useradmin'] === 'admin') {
                                $_SESSION['login_admin'] = $userid;
                                $_SESSION['login_admin_password'] = $password;
                                header("location: ../index.php");
                            } else if ($login_useradmin_row['useradmin'] === 'user') {
                                $_SESSION['login_user'] = $userid;
                                $_SESSION['login_user_password'] = $password;
                                header("location: ../user/user.php");
                            }
                    }
            }
    }


?>