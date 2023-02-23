<?php   
    session_start();
        include('../connect/connect.php');
               // ບັນທືກຂໍ້ມູນ
    if (isset($_POST['submit'])) {
        $T_name = $_POST['T_name'];
        $Note = $_POST['Note'];
           if (empty($T_name)) {
            $_SESSION['error'] = "<script>
            Swal.fire({
                icon: 'error',
                title: 'ທ່ານຍັງບໍ່ໄດ້ປ່ອນ ປະເພດສິນຄ້າ!',
                text: 'ກະລຸນາປ້ອນຂໍ້ມູນໃຫ້ຄົບ!',
                confirmButtonText: 'ຕົກລົງ'
            })
            </script>";
            header("location: inserttype.php");
          } else {


                    $select_sql_check_name = "SELECT * FROM type WHERE T_name = '$T_name' ";
                    $select_query_check_name = mysqli_query($conn,$select_sql_check_name);
                    $select_row_check_name = mysqli_num_rows($select_query_check_name);
                 if ($select_row_check_name === 1) {
                    $_SESSION['error'] = "<script>
                    Swal.fire({
                        icon: 'error',
                        title: 'ມີປະເພດສິນຄ້ານີ້ແລ້ວ!',
                        text: 'ກະລຸນາໃຊ້ ປະເພດສິນຄ້າ ໃຫມ່ທີ່ບໍ່ຊ້ຳກັນ!',
                        confirmButtonText: 'ຕົກລົງ'
                    })
                    </script>";
                    header("location: inserttype.php");
                } else {
                    $insert = "INSERT INTO type(T_name,T_date,Note) VALUES('$T_name',curdate(),'$Note') ";
                    $reslt = mysqli_query($conn,$insert);
                        if ($reslt) {
                            $_SESSION['success'] = "<script>
                            Swal.fire({
                                icon: 'success',
                                title: 'ບັນທືກປະເພດສິນຄ້າ $T_name ແລ້ວ',
                                showConfirmButton: false,
                                timer: 1500
                            })
                            </script>";
                            header("location: inserttype.php");
                        }
                }
            
          }

          
      }

    //   ລົບຂໍ້ມູນ
    if (isset($_GET['delete'])) {
        $delete_form = $_GET['delete'];
        $T_name_form = $_GET['T_name'];

        $_SESSION['error'] = "<script>Swal.fire({
            title: 'ຍືນຍັນການລົບ ຫຼື ບໍ?',
            text: 'ຖ້າທ່ານຍືນຍັນທີ່ປະລົບປະເພດສິນຄ້າ $T_name_form ສິນຄ້າຂອງທ່ານທັ້ງການນຳເຂົ້າ ແລະ ການຂາຍ ທີ່ເປັນປະເພດສິນຄ້າ $T_name_form ຈະຖືກລົບອອກທັ້ງໝົດ',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'ຍືນການລົບ',
            cancelButtonText: 'ຍົກເລິກ'
            }).then((result) => {
            if (result.isConfirmed) {
            window.location.href = 'inserttype_db.php?delete_confirm=" . $delete_form . "&T_name=" .$T_name_form. "'
            } else {
            window.location.href = 'inserttype_db.php?delete_not=" . $delete_form . "&T_name=".$T_name_form."'
            }
            })</script>";
            header("location: inserttype.php");
    }
    // ຍືນຍັນການລົບ
    if ($_GET['delete_confirm']) {
        $delete = $_GET['delete_confirm'];
        $T_name = $_GET['T_name'];
        



                                // ລົບຕາຕະລາງ ນຳເຂົ້າ
                            $delete_sql_receive = "DELETE FROM receive WHERE Type_T_id = $delete ";
                            $delete_query_receive = mysqli_query($conn,$delete_sql_receive);
        

                            if ($delete_query_receive) {
                                // ລົບຕາຕະລາງ ການຂາຍແອບມິນ
                                $delete_sql_orders = "DELETE FROM orders WHERE Type_T_id = $delete ";
                                $delete_query_orders = mysqli_query($conn,$delete_sql_orders);

                                    if ($delete_query_orders) {
                                        // ລົບຕາຕະລາງ ການຂາຍຍູເສີ
                                        $delete_sql_orderuser = "DELETE FROM orderuser WHERE Type_T_id = $delete ";
                                        $delete_query_orderuser = mysqli_query($conn,$delete_sql_orderuser);

                                                if ($delete_query_orderuser) { 
                                                                // ລົບຕາຕະລາງ ສິນຄ້າ
                                                                    $delete_sql_goods = "DELETE FROM goods WHERE Type_T_id = $delete ";
                                                                    $delete_query_goods = mysqli_query($conn,$delete_sql_goods);

                                                            if ($delete_query_goods) {
                                                                            // ລົບຕາຕະລາງປະເພດສິນຄ້າ
                                                                            $delete_sql = "DELETE FROM type WHERE T_id = $delete ";
                                                                            $delete_query = mysqli_query($conn,$delete_sql);
                                                                                        

                                                                                    if ($delete_query) {
                                                                                        $_SESSION['success'] = "<script>
                                                                                                Swal.fire({
                                                                                                    icon: 'success',
                                                                                                    title: 'ລົບຂໍ້ມູນ $T_name ແລ້ວ',
                                                                                                    showConfirmButton: false,
                                                                                                    timer: 1500
                                                                                                })
                                                                                            </script>";
                                                                                        header("location: inserttype.php");
                                                                                    }
                                        }
                                    }
                            }
                }
            
            
        } 
            
        


    // ຍົກເລິກການລົບ
    if ($_GET['delete_not']) {
        $T_name = $_GET['T_name'];
            $_SESSION['error'] = "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'ຍົກເລີກການລົບ $T_name ແລ້ວ',
                    showConfirmButton: false,
                    timer: 1500
                })
            </script>";
            header("location: inserttype.php");
    }


    



    
    // ແກ້ໄຂຂໍ້ມູນ
    if (isset($_POST['edit'])) {
        $T_id = $_POST['T_id'];
        $T_name = $_POST['T_name'];
        $Note = $_POST['Note'];

        if (empty($T_id)){
            $_SESSION['editerror'] = "<script>
            Swal.fire({
                icon: 'warning',
                title: 'ກະລຸນາປ້ອນລະຫັດປະເພດສິນຄ້າ',
                showConfirmButton: false,
                timer: 1500
            })
            </script>";
            header("location: inserttype.php");
        } else if (empty($T_name)) {
            $_SESSION['editerror'] = "<script>
            Swal.fire({
               
                    icon: 'warning',
                    title: 'ກະລຸນາປ້ອນປະເພດສິນຄ້າທີ່ທ່ານຕ້ອງການປ່ຽນ',
                    text: 'ກະລຸນາປ້ອນເບິ່ງຂໍ້ມູນທີ່ທ່ານຕ້ອງການປ່ຽນ ແລະ ລະບຸໃຫ້ຄົບ',
                    showConfirmButton: false,
                    timer: 1500
            })
            </script>";
            header("location: inserttype.php");
        } else {
            $select_type_sql = "SELECT * FROM type WHERE T_id = $T_id ";
            $select_type_query = mysqli_query($conn,$select_type_sql);
            $select_type_row = mysqli_fetch_assoc($select_type_query);
            $T_name_edit = $select_type_row['T_name'];


            

            if ($select_type_query) {
                    // ເຊັກວ່າມີຂໍ້ມູນຊ້ຳບໍ່
                    $check_type_sql = "SELECT * FROM type WHERE T_name = '$T_name' ";
                    $check_type_query = mysqli_query($conn,$check_type_sql);
                    $check_type_row = mysqli_num_rows($check_type_query);
                if ($check_type_row === 1) {
                    $_SESSION['error'] = "<script>
                    Swal.fire({
                        icon: 'error',
                        title: 'ຂໍ້ມູນທີ່ທ່ານຕ້ອງການປ່ຽນມີຢູ່ໃນລະບົບແລ້ວ',
                        text: 'ກະລຸນາໃຊ້ຂໍ້ມູນອືນ',
                        confirmButtonText: 'ຕົກລົງ'
                    })
                    </script>";
                    header("location: inserttype.php");

                } else {
                    $edti_sql = "UPDATE type set T_name = '$T_name',Note = '$Note' WHERE T_id = $T_id ";
                    $edti_query = mysqli_query($conn,$edti_sql);


                    if ($edti_query) {
                        $_SESSION['editsuccess'] = "<script>
                        Swal.fire({
                            icon: 'success',
                            title: 'ແກ້ໄຂຂໍ້ມູນແລ້ວ',
                            text: 'ທ່ານໄດ້ແກ້ໄຂ $T_name_edit ເປັນ $T_name ',
                            showConfirmButton: false,
                            timer: 1500
                        })
                        </script>";
                        header("location: inserttype.php");
                    }
                    
                }
            }
        }
    }

?>