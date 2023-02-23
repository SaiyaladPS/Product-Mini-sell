<?php
    session_start();
    include('../../connect/connect.php');

        if (isset($_POST['submit'])) {
            $g_id = $_POST['g_id'];
            $r_qty = $_POST['r_qty'];
            $Note = $_POST['Note'];

                if (empty($g_id)) {
                        $_SESSION['error'] = "<script>
                        Swal.fire({
                            icon: 'warning',
                            title: 'ທ່ານຍັງບໍ່ໄດ້ປ້ອນລະຫັດສິນຄ້າທີ່ຕ້ອງການນຳເຂົ້າ',
                            text: 'ກະລຸນາປ້ອນຂໍ້ມູນໃຫ້ຄົບ',
                            confirmButtonText: 'ຕົກລົງ'
                        })
                        </script>";
                        header("location: receive.php");
                } else if (empty($r_qty)) {
                    $_SESSION['error'] = "<script>
                    Swal.fire({
                        icon: 'warning',
                        title: 'ທ່ານຍັງບໍ່ໄດ້ປ້ອນຈຳນວນທີ່ທ່ານຕ້ອງການນຳເຂົ້າ',
                        text: 'ກະລຸນາປ້ອນຂໍ້ມູນໃຫ້ຄົບ',
                        confirmButtonText: 'ຕົກລົງ'
                    })
                    </script>";
                    header("location: receive.php");
                } else {
           
                    $goods_select_sql = "SELECT * FROM goods WHERE g_id = '$g_id'";
                    $goods_select_query = mysqli_query($conn,$goods_select_sql);
                    $goods_select_row = mysqli_fetch_assoc($goods_select_query);
                    $goods_select_numrow = mysqli_num_rows($goods_select_query);
                    $g_name = $goods_select_row['g_name'];
                    $g_purchase = $goods_select_row['g_purchase'];
                    $g_selling = $goods_select_row['g_selling'];
                    $Type_T_id = $goods_select_row['Type_T_id'];
                    $unit_u_id = $goods_select_row['unit_u_id'];
                           
                        if ($goods_select_numrow === 1) {
                            
                           
                                $receive_insert_sql = "INSERT INTO receive(r_name,r_purchase,r_selling,r_qty,unit_u_id,r_date,r_time,Note,Type_T_id,goods_g_id)
                                VALUES('$g_name',$g_purchase,$g_selling,'$r_qty','$unit_u_id',curdate(),curtime(),'$Note',$Type_T_id,'$g_id')";
                                $receive_insert_query = mysqli_query($conn,$receive_insert_sql);

                                    if ($receive_insert_query) {
                                        $goods_update_sql = "UPDATE goods SET g_qty = g_qty + $r_qty WHERE g_id = '$g_id'";
                                        $goods_update_query = mysqli_query($conn,$goods_update_sql);
                                        $_SESSION['success'] = "<script>
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'ນຳເຂົ້າສິນຄ້າ $g_name ຈຳນວນ $r_qty ສຳເລັດແລ້ວ ',
                                            showConfirmButton: false,
                                            timer: 1500
                                        })
                                        </script>";
                                        header("location: receive.php");
                                    }
                                
                           
                        } else {
                            $_SESSION['error'] = "<script>
                            Swal.fire({
                                icon: 'error',
                                title: 'ບໍ່ມີລະຫັດສິນຄ້ານີຢູ່ໃນສະຕ໋ອກສິນຄ້າ',
                                text: 'ກະລຸນາກວດສອບເບິ່ງສະຕ໋ອກຂອງທ່ານໃຫ້ແນ່ໃຈ',
                                confirmButtonText: 'ຕົກລົງ'
                            })
                            </script>";
                            header("location: receive.php");
                        }
                            
                     
                        

                   
                }
            }

                // ແຈ້ງເຕືອນຍືນຍັນ ຫຼຶ ຍົກເລີກການລົບ
                if (isset($_GET['delete'])) {
                    $delete = $_GET['delete'];
                    $delete_name = $_GET['delete_name'];


                    $_SESSION['error'] = "<script>Swal.fire({
                        title: 'ຍືນຍັນການລົບ ຫຼື ບໍ?',
                        text: 'ຖ້າທ່ານຕ້ອງການທີ່ຈະລົບສິນຄ້າ $delete_name ຈະບໍ່ມີການນຳເຂົ້າສະເພາະຈຳນວນລາຍການນີ້',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'ຍືນການລົບ',
                        cancelButtonText: 'ຍົກເລິກ'
                        }).then((result) => {
                        if (result.isConfirmed) {
                        window.location.href = 'receive_db.php?delete_confirm=" . $delete . "&delete_r_name=" .$delete_name. "'
                        } else {
                        window.location.href = 'receive_db.php?delete_not=" . $delete . "&delete_r_name=".$delete_name."'
                        }
                        })</script>";
                        header("location: receive.php");
                }
               




                // ຍືນຍັນການລົບຂໍ້ມູນ
                if (isset($_GET['delete_confirm'])) {
                    $delete = $_GET['delete_confirm'];
                    $delete_r_name = $_GET['delete_r_name'];
                                $select_receive_sql = "SELECT * FROM receive WHERE r_id = $delete";
                                $select_receive_query = mysqli_query($conn,$select_receive_sql);
                                $select_receive_row = mysqli_fetch_assoc($select_receive_query);
                                $r_qty = $select_receive_row['r_qty'];
                                        if ($select_receive_query) {
                                            $select_goods_sql = "SELECT * FROM goods";
                                            $select_goods_query = mysqli_query($conn,$select_goods_sql);
                                            $select_goods_row = mysqli_fetch_assoc($select_goods_query);
                                            $goods_id = $select_goods_row['g_id'];
                                                    if ($select_goods_query) {
                                                        $delete_goods_sql = "UPDATE goods INNER JOIN receive ON receive.goods_g_id = goods.g_id SET goods.g_qty = goods.g_qty - '$r_qty' WHERE r_id = $delete" ;
                                                        $delete_goods_query = mysqli_query($conn,$delete_goods_sql);
                                                            if ($select_goods_query) {
                                                                $delete_sql = "DELETE FROM receive WHERE r_id = $delete";
                                                                $delete_query = mysqli_query($conn,$delete_sql);
                                                                $_SESSION['success'] = "<script>
                                                                Swal.fire({
                                                                    icon: 'success',
                                                                    title: 'ລົບສິນຄ້າ $delete_r_name ສຳເລັດແລ້ວ',
                                                                    showConfirmButton: false,
                                                                    timer: 1500
                                                                })
                                                                </script>";
                                                                header("location: receive.php");
                                                            }
                                                    }
                                        }
                        } 

                        // ຍົກເລີກການລົບ
                        if (isset($_GET['delete_not'])) {
                            $delete_r_name = $_GET['delete_r_name'];
                            $_SESSION['error'] = "<script>
                            Swal.fire({
                                icon: 'error',
                                title: 'ຍົກເລີການລົບສິນຄ້າ $delete_r_name ສຳເລັດແລ້ວ',
                                showConfirmButton: false,
                                timer: 1500
                            })
                            </script>";
                            header("location: receive.php");
                        }

                
?>