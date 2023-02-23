<?php
        session_start();
        include('../../connect/connect.php');

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
                window.location.href = 'order_curdate_db.php?delete_confirm=" . $delete. "&o_name=" .$delete_name. "&delete_confirm_o_qty=" .$delete_o_qty."'
                } else {
                window.location.href = 'order_curdate_db.php?delete_not=" . $delete . "&o_name=".$delete_name." '
                }
                })</script>";
                header("location: order_curdate.php");
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
                                                header("location: order_curdate.php");
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
            header("location: order_curdate.php");
        }



?>