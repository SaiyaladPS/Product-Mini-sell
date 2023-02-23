<?php
    session_start();
    include('../../connect/connect.php');

    if (!isset($_SESSION['login_admin'])) {
      session_destroy();
      header("location: ../../login/login.php");
    }

    // ເຊັກຄົົນທີ່ສະໜັກເຂົ້າມາເພືອສະແດງເປັນຄົນນັ້ນ
    if (isset($_SESSION['login_admin']) && isset($_SESSION['login_admin_password'])) {
      $userid = $_SESSION['login_admin'];
    $password = $_SESSION['login_admin_password'];
    $sql_profile_login = "SELECT * FROM login WHERE id = '$userid' AND password = '$password' ";
    $query_profile_ligin = mysqli_query($conn,$sql_profile_login);

              $row_porfile_name = mysqli_fetch_assoc($query_profile_ligin);
    }

    
    if (isset($_POST['select'])){
        $select_name = $_POST['select_name'];

            if (empty($select_name)) {
                $_SESSION['error'] = "ກະລຸນາປ້ອນຊື່ສິນຄ້າເພືອຄົ້ນຫາ";
                header("location: goods.php");
            } else {
             
                      $select_sql = "SELECT * FROM goods INNER JOIN type ON goods.Type_T_id = type.T_id INNER JOIN unit ON goods.unit_u_id = unit.u_id WHERE goods.g_name LIKE '%$select_name%' ORDER BY goods.g_name ASC ";
                    $select_query = mysqli_query($conn,$select_sql);

                    $select_count = mysqli_num_rows($select_query);
              

                    $_SESSION['success'] = "<script>
                    Swal.fire({
                      icon: 'success',
                      title: 'ຄົ້ນຫາຂໍ້ມູນທີ່ຕົງກັບ $select_name ພົບ $select_count ລາຍການ',
                      showConfirmButton: false,
                      timer: 1500
                    })
                    </script>";
            }
    }

    if (isset($_POST['select_id_btn'])) {
      $select_id = $_POST['select_id'];

      if (empty($select_id)) {
        $_SESSION['error'] = "ກະລຸນາປ້ອນລະຫັດສິນຄ້າເພືອຄົ້ນຫາ";
        header("location: goods.php");
    } else {
     
              $select_sql_id = "SELECT * FROM goods INNER JOIN type ON goods.Type_T_id = type.T_id INNER JOIN unit ON goods.unit_u_id = unit.u_id WHERE goods.g_id = '$select_id' ORDER BY goods.g_date ASC ";
            $select_query = mysqli_query($conn,$select_sql_id);

            $select_count = mysqli_num_rows($select_query);
      

            $_SESSION['success'] = "<script>
            Swal.fire({
              icon: 'success',
              title: 'ຄົ້ນຫາຂໍ້ມູນທີ່ຕົງກັບ $select_id ພົບ $select_count',
              showConfirmButton: false,
              timer: 1500
            })
            </script>";
    }
    }

    
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ເພິ່ມສິນຄ້າ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css" integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../../css/sidebars.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        * {
            font-family: saysettha ot;
        }
    </style>
</head>
<body>
    

    <div class="container-fluid">
        
    <!-- ການສະແດງ ເມມູ -->
        <?php require ('nav/nav.php') ?>


          <?php if (isset($_SESSION['error'])) {
            echo $_SESSION['error'];
            unset($_SESSION['error']);
          }
            if (isset($_SESSION['success'])) {
              echo $_SESSION['success'];
              unset($_SESSION['success']);
            }
           ?>


<div class="col-sm-10 mt-2">
          <a href="goods.php?add='1'" class="btn btn-outline-primary"><i class="fa-solid fa-square-plus"></i> ເພິ່ມ</a>
          <a href="goods.php?search='1'" class="btn btn-outline-primary"><i class="fa-solid fa-magnifying-glass"></i> ຄົ້ນຫາ</a>
          <a href="goods.php?search_id='1'" class="btn btn-outline-success"><i class="fa-solid fa-barcode"></i> ຄົ້ນດວ້ຍບາໂຄດ</a>
          <a href="goods.php" class="btn btn-outline-primary"><i class="fa-solid fa-rotate-left"></i> ກັບຄືນ</a>
            <?php if ($select_count == 0) { ?>
                            <div class="alert alert-danger" role="alert" style="margin-top: 200px;">
            <h3 class="text-center">ຂໍ້ມູນວ່າງເປົ່າ</h3>
                                </div>
                <?php } else { ?>

                       <table class="table table-striped table-hover" style="font-size:12px ;">
                            <thead>
                                <tr>
                                    <th>ລະຫັດສິນຄ້າ</th>
                                    <th>ຊື່ສິນຄ້າ</th>
                                    <th>ລາຄາຊື່ເຂົ້າ</th>
                                    <th>ລາຄາຂາຍອອກ</th>
                                    <th>ຈຳນວນ</th>
                                    <th>ຫົວໜວ່ຍ</th>
                                    <th>ວັນທີ່ຮັບເຂົ້າ</th>
                                    <th>ໜາຍເຫດ</th>
                                    <th>ປະເພດສິນຄ້າ</th>
                                    <th>ລົບຂໍ້ມູນ</th>
                                    <th>ແກ້ໄຂ</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while($row = mysqli_fetch_assoc($select_query)) { ?>
                                    <tr>
                                        <td><?php echo $row['g_id'] ?></td>
                                        <td><?php echo $row['g_name'] ?></td>
                                        <td><?php echo number_format($row['g_purchase']) . " ກີບ" ?></td>
                                        <td><?php echo number_format($row['g_selling']) . " ກີບ" ?></td>
                                        <td><?php echo $row['g_qty'] ?></td>
                                        <td><?php echo $row['u_name'] ?></td>
                                        <td><?php echo $row['g_date'] ?></td>
                                        <td><?php echo $row['Note'] ?></td>
                                        <td><?php echo $row['T_name'] ?></td>
                                        <td><a href="goods_db.php?goods_delete=<?php echo $row['g_id']; ?>&delete_g_name=<?php echo $row['g_name']?>" class="btn btn-outline-danger" " style="font-size: 12px;""><i class="fa-solid fa-trash"></i> ລົບ</a></td>
                                        <td><a href="goods.php?goods_edit=<?php echo $row['g_id']?>&type_edit=<?php echo $row['T_id']?>&unit_u_id=<?php echo $row['u_id'] ?>" class="btn btn-outline-primary" style="font-size: 12px;"><i class="fa-solid fa-pen-to-square"></i> ແກ້ໄຂ</a></td>
                                    </tr>
                                    <?php } ?>
                            </tbody>
                       </table>


                    <?php } ?>
        </div>




        </div>

    </div>



<script src="../../js/sidebars.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>
</html>