<?php
    session_start();
    include_once '../../connect/connect.php';

    $location_forder = 'img/';

    if (isset($_POST['submit'])) {
        $img = $_FILES['imguser']['name'];
        $userid = $_POST['userid'];
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $Tel = $_POST['Tel'];
        $password_1 = $_POST['password_1'];
        $password_2 = $_POST['password_2'];
        $userandadmin = $_POST['userandadmin'];

            if (empty($img)) {
                $_SESSION['error'] = "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'ກະລຸນາປ້ອນຮູບພາບຂອງທ່ານ',
                    text: 'ກວດສອບຂໍ້ມູນ ແລະ ປ້ອນໃຫ້ຄົບ',
                    confirmButtonText: 'ຕົກລົງ'
                })
                </script>";
                header("location: userlogin.php");
            } else if (empty($userid)) {
                $_SESSION['error'] = "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'ກະລຸນາປ້ອນ ລະຫັດພະນັກງານ',
                    text: 'ກວດສອບຂໍ້ມູນ ແລະ ປ້ອນໃຫ້ຄົບ,
                    confirmButtonText: 'ຕົກລົງ'
                })
                </script>";
                header("location: userlogin.php");
            } else if (empty($fname)) {
                $_SESSION['error'] = "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'ກະລຸນາປ້ອນຊື່ຂອງທ່ານ',
                    text: 'ກວດສອບຂໍ້ມູນ ແລະ ປ້ອນໃຫ້ຄົບ',
                    confirmButtonText: 'ຕົກລົງ'
                })
                </script>";
                header('location: userlogin.php');
            } else if (empty($lname)) {
                $_SESSION['error'] = "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'ກະລຸນາປ້ອນນາມສະກຸນຂອງທ່ານ',
                    text: 'ກວດສອບຂໍ້ມູນ ແລະ ປ້ອນໃຫ້ຄົບ',
                    confirmButtonText: 'ຕົກລົງ'
                })
                </script>";
                header("location: userlogin.php");
            } else if (empty($Tel)) {
                $_SESSION['error'] = "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'ກະລຸນາປ້ອນເບີໂທຂອງທ່ານ',
                    text: 'ກວດສອບຂໍ້ມູນ ແລະ ປ້ອນໃຫ້ຄົບ',
                    confirmButtonText: 'ຕົກລົງ'
                })
                </script>";
                header("location: userlogin.php");
            } else if (empty($password_1)) {
                $_SESSION['error'] = "<script>
                    Swal.fire({
                        icon: 'error',
                        title: 'ກະລຸນາປ້ອນລະຫັດຜ່ານຂອງທ່ານ',
                        text: 'ກວດສອບຂໍ້ມູນ ແລະ ປ້ອນໃຫ້ຄົບ',
                        confirmButtonText: 'ຕົກລົງ'
                    })
                </script>";
                header("location: userlogin.php");
            } else if (strlen($_POST['password_1']) > 20 || strlen($_POST['password_1']) < 5) {
                $_SESSION['error'] = "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'ລະຫັດຜ່ານຕ້ອງມີຄວາມຍາວລະຫວ່າງ 5 ຫາ 20 ຕົວອັກສອນ',
                    text: 'ກວດສອບຂໍ້ມູນ ແລະ ເຮັດໃຫ້ຖືກຕ້ອງ',
                    confirmButtonText: 'ຕົກລົງ'
                })
                </script>";
                header("location: userlogin.php");
            } else if (empty($password_2)) {
                $_SESSION['error'] = "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'ກະລຸນາຍືນຍັນລະຫັດຜ່ານ',
                    text: 'ກວດສອບຂໍ້ມູນ ແລະ ປ້ອນໃຫ້ຄົບ',
                    confirmButtonText: 'ຕົກລົງ'
                })
                </script>";
                header("location: userlogin.php");
            } else if ($password_1 != $password_2) {
                $_SESSION['error'] = "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'ລະຫັດຜ່ານບໍ່ຕົງກັນ',
                    text: 'ກະລຸນາປ້ອນລະຫັດຍືນຍັນໃຫ້ຕົງກັນ',
                    confirmButtonText: 'ຕົກລົງ'
                })
                </script>";
                header("location: userlogin.php");
            } else if (empty($userandadmin)) {
                $_SESSION['error'] = "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'ກະລຸນາປ້ອນລະດັບຂອງພະນັກງານ',
                    text: 'ກວດສອບຂໍ້ມູນ ແລະ ປ້ອນໃຫ້ຄົບ',
                    confirmButtonText: 'ຕົກລົງ'
                })
                </script>";
                header("location: userlogin.php");
            } else {

                $chck_user_id = "SELECT * FROM login WHERE id = '$userid' ";
                $chck_user_query = mysqli_query($conn,$chck_user_id);
                $chck_user_row = mysqli_num_rows($chck_user_query);

                    if ($chck_user_row === 1) {
                        $_SESSION['error'] = "<script>
                        Swal.fire({
                            icon: 'error',
                            title: 'ມີລະຫັດພະນັກງານນີ້ຢູ່ແລ້ວ',
                            text: 'ກະລຸນາໃຊ້ລະຫັດພະນັກງານອືນ',
                            confirmButtonText: 'ຕົກລົງ'
                        })
                        </script>";
                        header("location: userlogin.php");
                    } else {

                        $imgname = basename($_FILES['imguser']['name']);
                $fileimg = $location_forder . $imgname;
                $fileType = pathinfo($fileimg,PATHINFO_EXTENSION);

                    $allType = array('jpg','png','jpeg','gif','pdf');

                        if (in_array($fileType, $allType)) {
                            if (move_uploaded_file($_FILES['imguser']['tmp_name'], $fileimg)) {
                                $insert_user_sql = "INSERT INTO login(id,img, fname, lname, Tel, password, useradmin ) 
                                VALUES('$userid','$imgname','$fname','$lname','$Tel','$password_1','$userandadmin')";
                                $insert_user_query = mysqli_query($conn,$insert_user_sql);
                                    if ($insert_user_query) {
                                        $_SESSION['error'] = "<script>
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'ບັນທືກຂໍ້ມູນ $fname $lname ສຳເລັດ ລະຫັດຜ່ານແມ່ນ $password_1 ລະຫັດພະນັກງານແມ່ນ $userid',
                                            confirmButtonText: 'ຕົກລົງ'
                                        })
                                        </script>";
                                        header("location: userlogin.php");
                                    }
                            }
                        }

                    }


            }
    }


?>