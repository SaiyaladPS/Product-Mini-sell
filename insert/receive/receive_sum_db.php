<?php
        session_start();
        include('../../connect/connect.php');


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
            window.location.href = 'receive_sum_db.php?delete_confirm=" . $delete . "&delete_r_name=" .$delete_name. "'
            } else {
            window.location.href = 'receive_sum_db.php?delete_not=" . $delete . "&delete_r_name=".$delete_name."'
            }
            })</script>";
            header("location: receive_sum.php");
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
                                                    header("location: receive_sum.php");
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
                header("location: receive_sum.php");
            }

?>