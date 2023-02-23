<?php
session_start();
include '../../connect/connect.php';

    if (isset($_POST['sub'])) {
        $sub_g_id = $_POST['sub_g_id'];
        $sub_id = $_POST['sub_id'];
        $sub_selling = $_POST['sub_selling'];
        $sub_qty = $_POST['sub_qty'];
        $sub_unit = $_POST['unit_name'];

            if (empty($sub_id)) {
                $_SESSION['error'] = "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'ກະລຸນາປ້ອນລະຫັດສິນຄ້າຍ່ອຍ',
                    text: 'ກະລຸນາກວດສອບ ແລະ ປ້ອນຂໍ້ມູນໃຫ້ຄົບ',
                    confirmButtonText: 'ຕົກລົງ'
                })
                </script>";
                header("location: ../goods/goods.php");
            } else if (empty($sub_selling)) {
                $_SESSION['error'] = "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'ກະລຸນາປ້ອນລາຄາຂາຍຍ່ອຍ',
                    text: 'ກະລຸນາກວດສອບ ແລະ ປ້ອນຂໍ້ມູນໃຫ້ຄົບ',
                    confirmButtonText: 'ຕົກລົງ'
                });
                </script>";
                header("location: ../goods/goods.php");
            } else if (empty($sub_qty)) {
                $_SESSION['error'] = "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'ກະລຸນາປ້ອນ ຈຳນວນທີ່ຕ້ອງການແຍກ',
                    text: 'ກະລຸນາກວດສອບຂໍ້ມູນ ແລະ ປ້ອນຂໍ້ມູນໃຫ້ຄົບ';
                    confirmButtonText: 'ຕົກລົງ'
                })
                </script>";
                header("location: ../goods/goods.php");
            } else if (empty($sub_unit)) {
                $_SESSION['error'] = "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'ກະລຸນາປ້ອນຫົວໜ່ວຍສິນຄ້າທີ່ແຍກອອກມາ',
                    text: 'ກວດສອບ ແລະ ປ້ອນຂໍ້ມູນໃຫ້ຄົບ',
                    confirmButtonText: 'ຕົກລົງ'
                })
                </script>";
                header("locatin: ../goods/goods.php");
            } else {


                $sql_select_goods = "SELECT * FROM goods WHERE g_id = '$sub_g_id'";
            $query_select_goods = mysqli_query($conn,$sql_select_goods);
            $row_select_goods = mysqli_fetch_assoc($query_select_goods);

            $g_name = $row_select_goods['g_name'];
            $g_sub = $row_select_goods['g_sub'];
            $type_u_id = $row_select_goods['Type_T_id'];
            $g_qty = $row_select_goods['g_qty'];
            $g_id = $row_select_goods['g_id'];

            $sql_select_sub = "SELECT * FROM sub WHERE s_id = $sub_id ";
            $query_select_sub = mysqli_query($conn,$sql_select_sub);
            $row_sub = mysqli_num_rows($query_select_sub);
            $ftch_row = mysqli_fetch_assoc($query_select_sub);
                    // ກວດເຊັກທີ່ມີລະຫັດສິນຄ້າຊ້ຳກັນ ໃຫ້ມີແຕ່ບວກໃສ່ກັບຈຳນວນ
            if ($row_sub == 1) {
                $update_sql_sub = "UPDATE sub SET s_qty = s_qty + ('$g_sub'*'$sub_qty') WHERE s_id = '$sub_id'";
                $update_query_sub = mysqli_query($conn,$update_sql_sub);
                        // ໄປລົບກັບ ຈຳນວນເພັກ ແຍກ ອອກຕາມເປັນຈຳນວນທີ່ກົດນົດ
                    if ($update_query_sub) {
                        $sql_update_goods = "UPDATE goods SET g_qty = g_qty - '$sub_qty' WHERE g_id = '$sub_g_id'";
                        $query_update_goods = mysqli_query($conn,$sql_update_goods);
                        $_SESSION['success'] = "<script>
                        Swal.fire({
                            icon: 'success',
                            title: 'ແຍກສິນຄ້າ $g_name ແລ້ວ',
                            confirmButton: false,
                            timer: 1500
                        })
                        </script>";
                        header("location: ../goods/goods.php");
                    }
            }       

            // ຖ້າລະຫັດບໍ່ມີກໍໃຫ້ບັນທືກເປັນລາຍການໃໝ່
                if ($sub_g_id == $g_id && $ftch_row['s_id'] != $sub_id) {
                    $sql_insert_sub = "INSERT INTO sub(s_id, s_name, s_selling, s_qty, unit_u_id, s_story, s_date, Type_T_id) 
                    VALUES('$sub_id','$g_name',$sub_selling,'$g_sub'*'$sub_qty',$sub_unit,'ສິນຄ້າອອກ',curdate(),$type_u_id)";
                    $query_insert_sub = mysqli_query($conn,$sql_insert_sub);
                    // ລົບຈຳນວນຕາມທີ່ບ່ອນ ເພິ່ມຕາມທີ່ກຳນົດ
                        if ($query_insert_sub) {
                            $sql_update_goods = "UPDATE goods SET g_qty = g_qty - '$sub_qty' WHERE g_id = '$sub_g_id'";
                            $query_update_goods = mysqli_query($conn,$sql_update_goods);
                            $_SESSION['success'] = "<script>
                            Swal.fire({
                                icon: 'success',
                                title: 'ແຍກສິນຄ້າ $g_name ແລ້ວ',
                                confirmButton: false,
                                timer: 1500
                            })
                            </script>";
                            header("location: ../goods/goods.php");
                        }
                }


                
            }
    }



?>