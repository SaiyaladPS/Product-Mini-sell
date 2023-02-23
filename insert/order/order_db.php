<?php 

    session_start();
    include('../../connect/connect.php');

        if (isset($_POST['sell'])) {
            $order_g_id = $_POST['g_id'];
            $order_o_qty = $_POST['o_qty'];
            $order_Note = $_POST['Note'];

               if (empty($order_g_id)) {
                $_SESSION['error'] = "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'ກະລຸນາປ້ອນລະຫັດສິນຄ້າ',
                    text: 'ກວດສອບຂໍ້ມູນ ແລະ ປ້ອນຂໍ້ມູນໃຫ້ຄົບ',
                    confirmButtonText: 'ຕົກລົງ'
                })
                </script>";
                header("location: order_curdate.php");
               } else if (empty($order_o_qty)) {
                $_SESSION['error'] = "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'ກະລຸນາປ້ອນຈຳນວນທີ່ຕ້ອງການຂາຍ',
                    text: 'ກວດສອບຂໍ້ມູນ ແລະ ປ້ອນຂໍ້ມູນໃຫ້ຄົບ',
                    confirmButtonText: 'ຕົກລົງ'
                })
                </script>";
                header("location: order_curdate.php");
               } else if ($order_o_qty < 1) {
                $_SESSION['error'] = "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'ຈຳນວນຫ້າມຕິດຄ່າ -',
                    text: 'ຈຳນວນຕ້ອງເປັນຄ່າ + ເທົ່ານັ້ນ',
                    confirmButtonText: 'ຕົກລົງ'
                })
                </script>";
                header("location: order_curdate.php");
               } else {
                $select_goods_sql = "SELECT * FROM goods INNER JOIN type ON goods.Type_T_id = type.T_id INNER JOIN unit ON goods.unit_u_id = unit.u_id
                WHERE goods.g_id = '$order_g_id' ";
               $select_goods_query = mysqli_query($conn,$select_goods_sql);
               $select_goods_row = mysqli_fetch_assoc($select_goods_query);
                   $g_name = $select_goods_row['g_name'];
                   $g_purchase = $select_goods_row['g_purchase'];
                   $g_selling = $select_goods_row['g_selling'];
                   $g_id = $select_goods_row['g_id'];
                   $Type_T_id = $select_goods_row['Type_T_id'];
                   $u_id = $select_goods_row['unit_u_id'];
                   $g_qty = $select_goods_row['g_qty'];
                   
                   
                       if ($g_qty <= 0){
                           $_SESSION['error'] = "<script>
                           Swal.fire({
                            icon: 'error',
                            title: 'ບໍ່ມີສິນຄ້າ $g_name ຢູ່ໃນສະຕ໋ອກສິນຄ້າແລ້ວ',
                            text: 'ກະລຸນາກວດສອບສິນຄ້າ ແລະ ນຳເຂົ້າໃຫມ່',
                            confirmButtonText: 'ຕົກລົງ'
                           })
                           </script>";
                           header("location: order_curdate.php");
                       } else {
                           $insert_orders_sql = "INSERT INTO orders(o_name,o_purchase,o_selling,o_qty,unit_u_id,o_date,o_time,Note,goods_g_id,Type_T_id)
                           VALUES('$g_name',$g_purchase,$g_selling,'$order_o_qty','$u_id',curdate(),curtime(),'$order_Note','$g_id',$Type_T_id)";
                           $insert_orders_query = mysqli_query($conn,$insert_orders_sql);

                           $insert_orderuser_sql = "INSERT INTO orderuser(ou_name,ou_purchase,ou_selling,ou_qty,unit_u_id,ou_date,ou_time,Note,goods_g_id,Type_T_id)
                           VALUES('$g_name',$g_purchase,$g_selling,'$order_o_qty','$u_id',curdate(),curtime(),'$order_Note','$g_id',$Type_T_id)";
                           $insert_orderuser_query = mysqli_query($conn,$insert_orderuser_sql);
                           

                               if ($insert_orders_query) {
                                   $update_goods_sql = "UPDATE goods SET g_qty = g_qty - '$order_o_qty' WHERE g_id = '$order_g_id' ";
                                   $update_goods_query = mysqli_query($conn,$update_goods_sql);
                                       if ($update_goods_query) {
                                        $_SESSION['success'] = "<script>
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'ຂາຍສິນຄ້າ $g_name ແລ້ວ $order_o_qty',
                                            showConfirmButton: false,
                                            timer: 1500
                                        })
                                    </script>";
                                           header("location: order_curdate.php");
                                       }
                               }
                       }
               }
        }



        // ແຈ້ງເຕືອນຍືນຍັນຫຼຶ ຍົກເລິກການລົບ
        if (isset($_GET['delete'])) {
            $delete = $_GET['delete'];
            $delete_name = $_GET['delete_name'];
            $delete_o_qty = $_GET['delete_o_qty'];


            $_SESSION['error'] = "<script>Swal.fire({
                title: 'ຍືນຍັນການລົບ ຫຼື ບໍ?',
                text: 'ຖ້າທ່ານຍືນຍັນທີ່ຈະລົບປະຫວັດການຂາຍສິນຄ້າ $delete_name ຈະບໍ່ສາມາດກູ້ຄືນໄດ້ອີກ',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'ຍືນການລົບ',
                cancelButtonText: 'ຍົກເລິກ'
                }).then((result) => {
                if (result.isConfirmed) {
                window.location.href = 'order_db.php?delete_confirm=" . $delete. "&o_name=" .$delete_name. "&delete_confirm_o_qty=".$delete_o_qty."'
                } else {
                window.location.href = 'order_db.php?delete_not=" . $delete . "&o_name=".$delete_name."'
                }
                })</script>";
                header("location: order.php");
        }

        // ຍືນຍັນການລົບ
        if (isset($_GET['delete_confirm'])) {
            $delete = $_GET['delete_confirm'];
            $delete_name = $_GET['o_name'];
            $delete_confirm_o_qty = $_GET['delete_confirm_o_qty'];

                $delete_goods_sql = "SELECT * FROM goods INNER JOIN orders ON goods.g_id = orders.goods_g_id WHERE o_id = $delete";
                $delete_goods_query = mysqli_query($conn,$delete_goods_sql);
                    $delete_goods_row = mysqli_fetch_assoc($delete_goods_query);
                        $g_name = $delete_goods_row['g_name'];
                        
                        if ($delete_goods_query) {
                            $update_goods_sql = "UPDATE goods INNER JOIN orders ON goods.g_id = orders.goods_g_id SET g_qty = g_qty + $delete_confirm_o_qty WHERE o_id = $delete ";
                            $update_goods_query = mysqli_query($conn,$update_goods_sql);
                                
                                if ($update_goods_query) {
                                        $delete_order_sql = "DELETE FROM orders WHERE o_id = $delete";
                                        $delete_order_query = mysqli_query($conn,$delete_order_sql);

                                        $delete1_orderuser_sql = "DELETE FROM orderuser WHERE ou_id = $delete";
                                         $delete1_orderuser_query = mysqli_query($conn,$delete1_orderuser_sql);
                                            
                                            if ($delete_order_query) {
                                                $_SESSION['success'] = "<script>
                                                Swal.fire({
                                                    icon: 'success',
                                                    title: 'ລົບຂໍ້ມູນການຂາຍສິນຄ້າ $delete_name ສຳເລັດແລ້ວ $delete_confirm_o_qty ຈຳນວນ',
                                                    showConfirmButton: false,
                                                    timer: 1500
                                                })
                                                </script>";
                                                header("location: order.php");
                                            }
                                }
                        }
        }

        // ຍົກເລີກການລົບ
        if (isset($_GET['delete_not'])) {
            $delete_not = $_GET['delete_not'];
            $delete_not_name = $_GET['o_name'];
            $_SESSION['error'] = "<script>
            Swal.fire({
                icon: 'error',
                title: 'ຍົກເລີກການລົບການຂາຍສິນຄ້າ $delete_not_name ແລ້ວ',
                showConfirmButton: false,
                timer: 1500
            })
            </script>";
            header("location: order.php");
        }

?>