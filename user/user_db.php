


<?php 

    session_start();
    include('../connect/connect.php');


        if (isset($_POST['sell'])) {
            $order_g_id = $_POST['g_id'];
            $order_o_qty = $_POST['ou_qty'];
            $order_Note = $_POST['Note'];
            


                $select_goods_sql = "SELECT * FROM goods INNER JOIN type ON goods.Type_T_id = type.T_id 
                 WHERE goods.g_id = '$order_g_id' ";
                $select_goods_query = mysqli_query($conn,$select_goods_sql);
                $select_goods_row = mysqli_fetch_assoc($select_goods_query);
                    $g_name = $select_goods_row['g_name'];
                    $g_purchase = $select_goods_row['g_purchase'];
                    $g_selling = $select_goods_row['g_selling'];
                    $g_id = $select_goods_row['g_id'];
                    $Type_T_id = $select_goods_row['Type_T_id'];
                    $u_name = $select_goods_row['unit_u_id'];
                    $g_qty = $select_goods_row['g_qty'];

                        if ($order_g_id != $g_id){
                            $_SESSION['error'] = "<script>Swal.fire({
                                icon: 'error',
                                title: 'ບໍ່ມີລະຫັດສິນຄ້ານີ້?',
                                text: 'ກະລຸນາກວດສວບລະຫັດຂອງທ່ານໃຫ້ແນ່ໃຈ?',
                                confirmButtonText: 'ຕົກລົງ'
                              })</script>";
                            header("location: user.php");
                        } else if (empty($order_g_id)) {
                            $_SESSION['error'] = "<script>
                            Swal.fire({
                                icon: 'error',
                                title: 'ກະລຸນາໃສ່ລະຫັດສິນຄ້າກອ່ນ',
                                text: 'ກວດສອບຂໍ້ມູນ ແລະ ປ້ອນຂໍ້ມູນໃຫ້ຄົບ',
                                confirmButtonText: 'ຕົກລົງ'
                            })
                            </script>";
                            header("location: user.php");
                        } else if (empty($order_o_qty)) {
                            $_SESSION['error'] = "<script>
                            Swal.fire({
                                icon: 'error',
                                title: 'ກະລຸນາໃສ່ຈຳນວນທີ່ຕ້ອງການຂາຍກອ່ນ',
                                text: 'ກວດສອບຂໍ້ມູນ ແລະ ປ້ອນຂໍ້ມູນໃຫ້ຄົບ',
                                confirmButtonText: 'ຕົກລົງ'
                            })</script>";
                            header("location: user.php");
                        } else if ($order_o_qty < 1) {
                            $_SESSION['error'] = "<script>
                            Swal.fire({
                                icon: 'error',
                                title: 'ຈຳນວນສິນຄ້າຫ້າມມີຄ່າຕິດ -',
                                text: 'ຈຳນວນຕ້ອງເປັນຄ່າ +',
                                confirmButtonText: 'ຕົກລົງ'
                            })
                            </script>";
                            header("location: user.php");
                        } else {
                    
                    
                        if ($g_qty <= 0) {
                            $_SESSION['error'] = "<script>Swal.fire({
                                icon: 'error',
                                title: 'ບໍ່ມີສິນຄ້າ $g_name ໃນສະຕ໋ອກແລ້ວ!',
                                text: 'ກະລຸນາກວດສວບຈຳນວນສິນຄ້າໃນສະຕ໋ອກ!',
                              })</script>";
                            header("location: user.php");
                        } else {
                            $insert_orders_sql = "INSERT INTO orders(o_name,o_purchase,o_selling,o_qty,unit_u_id,o_date,o_time,Note,goods_g_id,Type_T_id)
                            VALUES('$g_name',$g_purchase,$g_selling,'$order_o_qty','$u_name',curdate(),curtime(),'$order_Note','$g_id',$Type_T_id)";


                            $insert_orders_query = mysqli_query($conn,$insert_orders_sql);

                            $insert_orderuser_sql = "INSERT INTO orderuser(ou_name,ou_purchase,ou_selling,ou_qty,unit_u_id,ou_date,ou_time,Note,goods_g_id,Type_T_id)
                            VALUES('$g_name',$g_purchase,$g_selling,'$order_o_qty','$u_name',curdate(),curtime(),'$order_Note','$g_id',$Type_T_id)";
                            $insert_orderuser_query = mysqli_query($conn,$insert_orderuser_sql);

                                if ($insert_orders_query) {
                                    $update_goods_sql = "UPDATE goods SET g_qty = g_qty - $order_o_qty WHERE g_id = '$order_g_id' ";
                                    $update_goods_query = mysqli_query($conn,$update_goods_sql);
                                        if ($update_goods_query) {
                                            $_SESSION['success'] = "<script>Swal.fire({
                                                icon: 'success',
                                                title: 'ຂາຍສິນຄ້າ $g_name ແລ້ວ',
                                                showConfirmButton: false,
                                                timer: 1000
                                              })</script>";
                                            header("location: user.php");
                                        }
                                }
                        }
                    }
        }

        // ລົບຂໍ້ມູນ
         if (isset($_GET['delete'])) {
             $delete = $_GET['delete'];
             $delete_ou_qty = $_GET['ou_qty'];


        $_SESSION['error'] = "<script>Swal.fire({
        title: 'ຍືນຍັນການລົບ ຫຼື ບໍ?',
        text: 'ຖ້າລົບແລ້ວຈະບໍ່ສາມາດກູ້ຄືນມາໄດ້!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'ຍືນການລົບ',
        cancelButtonText: 'ຍົກເລິກ'
        }).then((result) => {
        if (result.isConfirmed) {
        window.location.href = 'user_db.php?delete_confir=" . $delete . "&ou_qty_con=" . $delete_ou_qty ."'
        } else {
        window.location.href = 'user_db.php?delete_not=" . $delete . "&ou_qty_not=". $delete_ou_qty ."'
        }
        })</script>";
        header("location: user.php");
    } 

// ຍັນຍືນການລົບ

    if ($_GET['delete_confir']) {
        $delete = $_GET['delete_confir'];
        $ou_qty = $_GET['ou_qty_con'];

        $delete_goods_sql = "SELECT * FROM goods INNER JOIN orderuser ON goods.g_id = orderuser.goods_g_id WHERE ou_id = $delete";
        $delete_goods_query = mysqli_query($conn,$delete_goods_sql);
            $delete_goods_row = mysqli_fetch_assoc($delete_goods_query);
                $g_name = $delete_goods_row['g_name'];
               
          if ($delete_goods_query) {
                    $update_goods_sql = "UPDATE goods INNER JOIN orderuser ON goods.g_id = orderuser.goods_g_id SET g_qty = g_qty + $ou_qty WHERE ou_id = $delete ";
                    $update_goods_query = mysqli_query($conn,$update_goods_sql);
                       
                        if ($update_goods_query) {
                                $delete1_orderuser_sql = "DELETE FROM orderuser WHERE ou_id = $delete";
                                $delete1_orderuser_query = mysqli_query($conn,$delete1_orderuser_sql);

                                $delete_order_sql = "DELETE FROM orders WHERE o_id = $delete" ;
                                $delete_order_query = mysqli_query($conn,$delete_order_sql);
                                   
                                   if ($delete_order_query) {
                                    $_SESSION['success'] = "<script>
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'ລົບຂໍ້ການຂາຍ $g_name ແລ້ວ',
                                        showConfirmButton: false,
                                        timer: 1500
                                      })
                                    </script>";
                                    header("location: user.php");
                                    }
                                }
                            }
                        }


// ຍົກເລີກການລົບ

                if ($_GET['delete_not']) {
                    $_SESSION['error'] = "<script>
                    Swal.fire({
                        icon: 'error',
                        title: 'ຍົກເລີກການລົບແລ້ວ',
                        showConfirmButton: false,
                        timer: 1500
                    })
                    </script>";
                    header("location: user.php");
                }





            // ລ້າງຂໍ້ມູນເພືອຮັບອໍເດີໃຫມ່
            if ($_GET['sevs']) {
                $delete_orderuser_sql = "DELETE FROM orderuser";
                $delete_orderuser_query = mysqli_query($conn,$delete_orderuser_sql);
                    
                    if ($delete_orderuser_query) {
                        $_SESSION['success'] = "<script>
                        Swal.fire({
                            icon: 'success',
                            title: 'ຮັບອໍເດີໃຫມ່',
                            timer: 1000
                        })
                        </script>";
                        header("location: user.php"); 
                    }
            }

?>


