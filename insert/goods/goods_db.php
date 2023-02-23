<?php
    session_start();
    include('../../connect/connect.php');



    // ບັນທືກຂໍ້ມູນ
    if (isset($_POST['submit'])) {
        $g_id = $_POST['g_id'];
        $g_name = $_POST['g_name'];
        $g_purchase = $_POST['g_purchase'];
        $g_selling = $_POST['g_selling'];
        $unit_u_id = $_POST['unit_u_id'];
        $g_sub = $_POST['g_sub'];
        $Note = $_POST['Note'];
        $type_id = $_POST['Type_T_id'];

                if (empty($g_id)) {
                     $_SESSION['error'] = "<script>
                     Swal.fire({
                        icon: 'warning',
                        title: 'ທ່ານຍັງບໍ່ໄດ້ປ້ອນຂໍ້ມູນລະຫັດສິນຄ້າ',
                        text: 'ກະລຸນາກວດສອບ ແລະ ປ້ອນຂໍ້ມູນໃຫ້ຄົບ',
                        confirmButtonText: 'ຕົກລົງ'
                     })
                     </script>";
                     header("location: goods.php");
                } else if (empty($g_name)) {
                    $_SESSION['error'] = "<script>
                    Swal.fire({
                        icon: 'warning',
                        title: 'ທ່ານຍັງບໍ່ໄດ້ປ້ອນຂໍ້ມູນຊື່ສິນຄ້າ',
                        text: 'ກະລຸນາກວດສອບ ແລະ ປ້ອນຂໍ້ມູນໃຫ້ຄົບ',
                        confirmButtonText: 'ຕົກລົງ'
                    })
                    </script>";
                    header("location: goods.php");
                
                } else if (empty($g_selling)) {
                    $_SESSION['error'] = "<script>
                        swal.fire({
                            icon: 'warning',
                            title: 'ທ່ານຍັງບໍ່ໄດ້ຕັ້ງລາຄາທີ່ຕ້ອງການຂາຍ',
                            text: 'ກະລຸນາກວດສອບ ແລະ ປ້ອນຂໍ້ມູນໃຫ້ຄົບ',
                            confirmButtonText: 'ຕົກລົງ'
                        })
                    </script>";
                    header("location: goods.php");
                } else if (empty($unit_u_id)) {
                    $_SESSION['error'] = "<script>
                    Swal.fire({
                        icon: 'warning',
                        title: 'ທ່ານຍັງບໍ່ໄດ້ປ້ອນຫົວໜ່ວຍການນຳເຂົ້າ',
                        text: 'ກະລຸນາກວດສອບ ແລະ ປ້ອນຂໍ້ມູນໃຫ້ຄົບ',
                        confirmButtonText: 'ຕົກລົງ'
                    })
                    </script>";
                    header("location: goods.php");
                } else if (empty($type_id)) {
                    $_SESSION['error'] = "<script>
                    Swal.fire({
                        icon: 'warning',
                        title: 'ທ່ານຍັງບໍ່ໄດ້ປ້ອນປະເພດສິນຄ້າ',
                        text: 'ກະລຸນາກວດສອບ ແລະ ປ້ອນຂໍ້ມູນໃຫ້ຄົບ',
                        confirmButtonText: 'ຕົກລົງ'
                    })
                    </script>";
                    header("location: goods.php");
                } else {
                    $check_id_sql = "SELECT * FROM goods WHERE g_id = '$g_id'";
                    $check_id_query = mysqli_query($conn,$check_id_sql);
                    $check_row = mysqli_num_rows($check_id_query);

                        if ($check_row === 1) {
                            $_SESSION['error'] = "<script>
                            Swal.fire({
                                icon: 'error',
                                title: 'ມີລະຫັດສິນຄ້ານີ້ຢູ່ໃນລະບົບແລ້ວ',
                                text: 'ກະລຸນາກວດສອບໃຫ້ແນ່ໃຈວ່າລະຫັດສິນຄ້າທີ່ທ່ານຕ້ອງການປ້ອນບໍ່ໄດ້ຊ້ຳກັບສິນຄ້າໂຕອືນ',
                                confirmButtonText: 'ຕົກລົງ'
                            })
                            </script>";
                            header("location: goods.php");
                        } else {
                           

                                        $inser_sql = "INSERT INTO goods(g_id, g_name, g_purchase, g_selling, g_qty,g_sub,unit_u_id, g_date, Note, Type_T_id) 
                            VALUES ('$g_id','$g_name',$g_purchase,$g_selling,'0','$g_sub','$unit_u_id',curdate(),'$Note',$type_id)";
                            $inser_query = mysqli_query($conn,$inser_sql);
                                if ($inser_query) {
                                    $_SESSION['success'] = "<script>
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'ບັນທືກຂໍ້ມູນ $g_name ສຳເລັດແລ້ວ',
                                        showConfirmButton: false,
                                        timer: 1500
                                    })
                                    </script>";
                                    header("location: goods.php");
                                }
                                    }
                        }
                }



                // ລົບແຈ້ງເຕືອນ ຍືນຍັນຫຼຶ ຍົກເລີກ
            if (isset($_GET['goods_delete'])) {
                $delete = $_GET['goods_delete'];
                $delete_name = $_GET['delete_g_name'];
                $_SESSION['error'] = "<script>Swal.fire({
                    title: 'ຍືນຍັນການລົບ ຫຼື ບໍ?',
                    text: 'ຖ້າທ່ານຍືນຍັນທີ່ປະລົບສິນຄ້າ $delete_name ສິນຄ້າຂອງທ່ານທັ້ງການນຳເຂົ້າ ແລະ ການຂາຍ ທີ່ເປັນສິນຄ້າ $delete_name ຈະຖືກລົບອອກທັ້ງໝົດ',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'ຍືນຍັນການລົບ',
                    cancelButtonText: 'ຍົກເລິກ'
                    }).then((result) => {
                    if (result.isConfirmed) {
                    window.location.href = 'goods_db.php?delete_confirm=" . $delete . "&delete_name=" .$delete_name. "'
                    } else {
                    window.location.href = 'goods_db.php?delete_not=" . $delete . "&delete_name=".$delete_name."'
                    }
                    })</script>";
                    header("location: goods.php");

            }


                // ຍົກເລີກການລົບ
                if (isset($_GET['delete_not'])) {
                    $delete_not = $_GET['delete_not'];
                    $delete_not_name = $_GET['delete_name'];

                        $_SESSION['error'] = "<script>
                        Swal.fire({
                            icon: 'error',
                            title: 'ທ່ານໄດ້ຍົກເລີກການລົບ $delete_not_name ແລ້ວ',
                            text: 'ສາມາດລົບ $delete_not_name ໄດ້',
                            showConfirmButton: false,
                            timer: 1500
                        })
                        </script>";

                        header("location: goods.php");
                }


                
    // ຍືນຍັນການລົບ
    if (isset($_GET['delete_confirm'])) {
        $delete_confirm = $_GET['delete_confirm'];
        $delete_g_name = $_GET['delete_name'];

                    $delete_receive_sql = "DELETE FROM receive WHERE goods_g_id = '$delete_confirm' ";
                    $delete_receive_query = mysqli_query($conn,$delete_receive_sql);
                        if ($delete_receive_query) {
                            $delete_orders_sql = "DELETE FROM orders WHERE goods_g_id = '$delete_confirm' ";
                            $delete_orders_query = mysqli_query($conn,$delete_orders_sql);
                                
                                if($delete_orders_query){
                                        $delete_orderuser_sql = "DELETE FROM orderuser WHERE goods_g_id = '$delete_confirm' ";
                                        $delete_orderuser_query = mysqli_query($conn,$delete_orderuser_sql);
                                }
                                            if ($delete_orderuser_query) {
                                                $delete_sql = "DELETE FROM goods WHERE g_id = '$delete_confirm'";
                                                $delete_query = mysqli_query($conn,$delete_sql);                                 
                                                $_SESSION['success'] = "<script>
                                                Swal.fire({
                                                    icon: 'success',
                                                    title: 'ທ່ານໄດ້ລົບຂໍ້ມູນ $delete_g_name ແລ້ວ',
                                                    showConfirmButton: false,
                                                    timer: 1500
                                                })
                                                </script>";
                                                header("location: goods.php");
                                            }
                        }
                            
                }

    // ແກ້ໄຂຂໍ້ມູນ 
    if (isset($_POST['edit'])) {
        $edit_g_id = $_POST['edit_g_id'];
        $edit_g_name = $_POST['edit_g_name'];
        $edit_g_purchase = $_POST['edit_g_purchase'];
        $edit_g_selling = $_POST['edit_g_selling'];
        $edit_g_unit = $_POST['edit_u_id'];
        $edit_Note = $_POST['edit_Note'];
        $edit_g_Type_T_id = $_POST['edit_Type_T_id'];

                if (empty($edit_g_id)) {
                    $_SESSION['error'] = "<script>
                    Swal.fire({
                        icon: 'warning',
                        title: 'ທ່ານຍັງບໍ່ໄດ້ປ້ອນລະຫັດສິນຄ້າທີ່ທ່ານຕ້ອງການປ່ຽນ',
                        text: 'ກະລຸນາກວດສອບ ແລະ ປ້ອນຂໍ້ມູນໃຫ້ຄົບ',
                        confirmButtonText: 'ຕົກລົງ'
                    })
                    </script>";
                    header("location: goods.php");
                } else if (empty($edit_g_name)) {
                    $_SESSION['error'] = "<script>
                    Swal.fire({
                        icon: 'warning',
                        title: 'ທ່ານຍັງບໍ່ໄດ້ປ້ອນຊື້ສິນຄ້າທີ່ທ່ານຕ້ອງການປ່ຽນ',
                        text: 'ກະລຸນາກວດສອບ ແລະ ປ້ອນຂໍ້ມູນໃຫ້ຄົບ',
                        confirmButtonText: 'ຕົກລົງ'
                    })
                    </script>";
                    header("location: goods.php");
                } else if (empty($edit_g_purchase)) {
                    $_SESSION['error'] = "<script>
                    Swal.fire({
                        icon: 'warning',
                        title: 'ທ່ານຍັງບໍ່ໄດ້ປ້ອນຄາລາຊື້ສິນຄ້າທີ່ທ່ານຕ້ອງການປ່ຽນ',
                        text: 'ກະລຸນາກວດສອບ ແລະ ປ້ອນຂໍ້ມູນໃຫ້ຄົບ',
                        confirmButtonText: 'ຕົກລົງ'
                    })
                    </script>";
                    header("location: goods.php");
                } else if (empty($edit_g_selling)) {
                    $_SESSION['error'] = "<script>
                    Swal.fire({
                        icon: 'warning',
                        title: 'ທ່ານຍັງບໍ່ໄດ້ປ້ອນຄາລາຂາຍສິນຄ້າທີ່ທ່ານຕ້ອງການປ່ຽນ',
                        text: 'ກະລຸນາກວດສອບ ແລະ ປ້ອນຂໍ້ມູນໃຫ້ຄົບ',
                        confirmButtonText: 'ຕົກລົງ'
                    })
                    </script>";
                    header("location: goods.php");
                } else if (empty($edit_g_Type_T_id)) {
                    $_SESSION['error'] = "<script>
                    Swal.fire({
                        icon: 'warning',
                        title: 'ທ່ານຍັງບໍ່ໄດ້ປ້ອນປະເພດສິນຄ້າທີ່ທ່ານຕ້ອງການປ່ຽນ',
                        text: 'ກະລຸນາກວດສອບ ແລະ ປ້ອນຂໍ້ມູນໃຫ້ຄົບ',
                        confirmButtonText: 'ຕົກລົງ'
                    })
                    </script>";
                    header("location: goods.php");
                } else if (empty($edit_g_unit)) {
                    $_SESSION['error'] = "<script>
                    Swal.fire({
                        icon: 'warning',
                        title: 'ທ່ານຍັງບໍ່ໄດ້ປ້ອນຫົວໜ່ວຍສິນຄ້າທີ່ທ່ານຕ້ອງການປ່ຽນ',
                        text: 'ກະລຸນາກວດສອບ ແລະ ປ້ອນຂໍ້ມູນໃຫ້ຄົບ',
                        confirmButtonText: 'ຕົກລົງ'
                    })
                    </script>";
                    header("location: goods.php");
                } else {
                        $check_edit_sql = "SELECT * FROM goods WHERE g_id = '$edit_g_id' ";
                        $check_edit_query = mysqli_query($conn,$check_edit_sql);
                       

                                
                                    $edit_sql = "UPDATE goods SET g_name = '$edit_g_name',
                                     g_purchase = $edit_g_purchase, g_selling = $edit_g_selling,
                                     Note = '$edit_Note',Type_T_id = $edit_g_Type_T_id, unit_u_id = '$edit_g_unit' WHERE g_id = '$edit_g_id' ";
                                     
                                     $edit_query = mysqli_query($conn,$edit_sql);

                                        if ($edit_query) {
                                            $edit_receive_sql = "UPDATE receive SET r_name = '$edit_g_name',
                                            unit_u_id = '$edit_g_unit',Type_T_id = $edit_g_Type_T_id, r_purchase = $edit_g_purchase,r_selling = $edit_g_selling
                                             WHERE goods_g_id = '$edit_g_id' AND r_date = curdate() ";
                                            $edit_receive_query = mysqli_query($conn,$edit_receive_sql);
                                            

                                                if ($edit_receive_query) {
                                                    
                                                        
                                                    $_SESSION['success'] = "<script>
                                                    Swal.fire({
                                                        icon: 'success',
                                                        title: 'ປ່ຽນແປງຂໍ້ມູນສຳເລັດແລ້ວ',
                                                        showConfirmButton: false,
                                                        timer: 1500
                                                    })
                                                    </script>";
                                                            header("location: goods.php");
  
                                                }
                                        }
                                
                }
    }



?>