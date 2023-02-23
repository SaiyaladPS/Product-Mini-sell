<?php
    session_start();
    include('../../connect/connect.php');

    $select_unit_sql = "SELECT * FROM unit";
    $select_unit_query = mysqli_query($conn,$select_unit_sql);
    $select_unit_row = mysqli_fetch_assoc($select_unit_query);
            $select_u_name = $select_unit_row['u_name'];
            $select_u_id = $select_unit_row['u_id'];



    if (isset($_POST['submit'])) {
        $u_name = $_POST['u_name'];
        $Note = $_POST['Note'];

           if (empty($u_name)) {
                $_SESSION['error'] = "<script>
                swal.fire({
                    icon: 'error',
                    title: 'ກະລຸນາລະບຸຫົວໜ່ວຍ',
                    text: 'ກະລຸນາກວດສອບເພືອປ້ອນຂໍ້ມູນໃຫ້ຄົບ',
                    confirmButtonText: 'ຕົກລົງ'
                })
                </script>";
                header("locatioN: unit.php");
            } else {
                
               
                    $insert_unit_sql = "INSERT INTO unit(u_name,u_date,Note)
                VALUES('$u_name',curdate(),'$Note')";
                $insert_unit_query = mysqli_query($conn,$insert_unit_sql);
                    if ($insert_unit_query) {
                        $_SESSION['success'] = "<script>
                        Swal.fire({
                            icon: 'success',
                            title: 'ບັນທືກຫົວໜ່ວຍ $u_name ແລ້ວ',
                            showConfirmButton: false,
                            timer: 1500
                        })
                        </script>";
                        header("location: unit.php");
                    }
                }

            }


    // ແກ້ໄຂ້ຂໍ້ມູນ
    if(isset($_POST['edit'])) {
        $edit_u_id = $_POST['u_id'];
        $edit_u_name = $_POST['u_name'];
        $edit_u_Note = $_POST['Note'];

            if (empty($edit_u_name)) {
                $_SESSION['error'] = "<script>
                Swal.fire({
                    icon: 'warning',
                    title: 'ກະລຸນາລະບຸຫົວໜ່ວຍທີ່ຕ້ອງການປ່ຽນ',
                    confirmButtonText: 'ຕົກລົງ'
                })
                </script>";
                header("location: unit.php");
            } else {
                $select_unit_success_sql = "SELECT * FROM unit WHERE u_id = $edit_u_id " ;
                $select_unit_success_query = mysqli_query($conn,$select_unit_success_sql);
                $select_unit_success_row = mysqli_fetch_assoc($select_unit_success_query);
                $u_name = $select_unit_success_row['u_name'];

                
                if ($select_unit_success_query) {

                            // ເຊັກແກ້ໄຂຂໍ້ມູນທີ່ຊ້ຳກັນ

                            $chech_unit_success_sql = "SELECT * FROM unit WHERE u_name = '$edit_u_name' ";
                            $chech_unit_success_query = mysqli_query($conn,$chech_unit_success_sql);
                            $chech_unit_success_row = mysqli_num_rows($chech_unit_success_query);
                            if ($chech_unit_success_row === 1) {
                                    $_SESSION['error'] = "<script>
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'ຂໍ້ມູນທີ່ທ່ານຕ້ອງການປ່ຽນມີຢູ່ໃນລະບົບແລ້ວ',
                                        text: 'ບໍ່ສາມາດປ່ຽນແປງຂໍ້ມູນດັ່ງກາວໄດ້',
                                        confirmButtonText: 'ຕົກລົງ'
                                    })
                                    </script>";
                                    header("location: unit.php");
                            } else {
                        $update_unit_sql = "UPDATE unit SET u_name = '$edit_u_name',Note = '$edit_u_Note' WHERE u_id = '$edit_u_id' ";
                        $update_unit_query = mysqli_query($conn,$update_unit_sql);
                        
                                if ($update_unit_query) {
                                    $_SESSION['success'] = "<script>
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'ທ່ານໄດ້ປ່ຽນ $u_name ເປັນ $edit_u_name ແລ້ວ ',
                                            showConfirmButton: false,
                                            timer: 1500
                                        })
                                    </script>";
                                         header("location: unit.php");
                                }
                            }
                            
                    }
            }
    }


    // ການລົບ
    if (isset($_GET['delete'])) {
        $delete = $_GET['delete'];
        $delete_name = $_GET['delete_name'];

        $_SESSION['error'] = "<script>Swal.fire({
            title: 'ຍືນຍັນການລົບຫົວໜວ່ຍ $delete_name ຫຼື ບໍ?',
            text: 'ຖ້າທ່ານຍືນຍັນທີ່ຈະະລົບຫົວໜ່ວຍ $delete_name ສິນຄ້າຂອງທ່ານທັ້ງການນຳເຂົ້າ ແລະ ການຂາຍ ທີ່ເປັນຫົວໜ່ວຍ $delete_name ຈະຖືກລົບອອກທັ້ງໝົດ',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'ຍືນການລົບ',
            cancelButtonText: 'ຍົກເລິກ'
            }).then((result) => {
            if (result.isConfirmed) {
            window.location.href = 'unit_db.php?delete_confirm=" . $delete . "&u_name=" .$delete_name. "'
            } else {
            window.location.href = 'unit_db.php?delete_not=" . $delete . "&u_name=".$delete_name."'
            }
            })</script>";
            header("location: unit.php");
    }

    // ຍົກເລີກການລົບ
    if (isset($_GET['delete_not'])) {
        $u_name = $_GET['u_name'];

        $_SESSION['error'] = "<script>
        Swal.fire({
            icon: 'error',
            title: 'ຍົກເລັກການລົບ $u_name ແລ້ວ',
            showConfirmButton: false,
            timer: 1500
        })
        </script>";

        header("location: unit.php");
    }

    // ຍືນຍັນການລົບ

    if (isset($_GET['delete_confirm'])) {
        $delete_confirm = $_GET['delete_confirm'];
        $u_name_confirm = $_GET['u_name'];


        //ລົບຕາຕະລາງນຳເຂົ້າ
        $delete_receive_sql = "DELETE FROM receive WHERE unit_u_id = $delete_confirm ";
        $delete_receive_query = mysqli_query($conn,$delete_receive_sql);

                    if ($delete_receive_query) {
                        // ລົບຕາຕະລາງການຂາຍຂອງ ແອບມິນ
                        $delete_orders_sql = "DELETE FROM orders WHERE unit_u_id = $delete_confirm ";
                        $delete_orders_query = mysqli_query($conn,$delete_orders_sql);

                            if ($delete_orders_query) {
                                // ລົບຕາຕະລາງການຂາຍຂອງ ຍູເຊີ
                                $delete_orderuser_sql = "DELETE FROM orderuser WHERE unit_u_id = $delete_confirm ";
                                $delete_orderuser_query = mysqli_query($conn,$delete_orderuser_sql);

                                    if ($delete_orderuser_query) {
                                        // ລົບຕາຕະລາງສິນຄ້າ 
                                        $delete_goods_sql = "DELETE FROM goods WHERE unit_u_id = $delete_confirm ";
                                        $delete_goods_query = mysqli_query($conn,$delete_goods_sql);

                                                if ($delete_goods_query) {
                                                    // ລົບຕາຕະລາງ ຫົວໜ່ວຍສິນຄ້າ
                                                    $delete_unit_sql = "DELETE FROM unit WHERE u_id = $delete_confirm ";
                                                    $delete_unit_query = mysqli_query($conn,$delete_unit_sql);
                                                            if ($delete_unit_query) {
                                                                
                                                                $_SESSION['error'] = "<script>
                                                                Swal.fire({
                                                                    icon: 'success',
                                                                    title: 'ລົບຫົວໜ່ວຍ $u_name_confirm ແລ້ວ',
                                                                    text: 'ຖ້າທ່ານລົບແລ້ວຈະບໍ່ສາມາດກູ້ຄືນໄດ້ອີກ',
                                                                    showConfirmButton: false,
                                                                    timer: 1500
                                                                })
                                                                </script>";
                                                                header("location: unit.php");
                                                            }
                                                }
                                    }
                            }
                    }
    }

?>