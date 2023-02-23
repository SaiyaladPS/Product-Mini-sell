<?php
        session_start();
        include('../../connect/connect.php');

        // ການເຂົົ້າໜ້າທີ່ບໍ່ໄດ້ຮັບອະນຸຍາດ
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

        $select_order_sql = "SELECT * FROM orders INNER JOIN type ON orders.Type_T_id = type.T_id INNER JOIN goods ON goods.g_id = orders.goods_g_id INNER JOIN unit ON goods.unit_u_id = unit.u_id WHERE o_date = curdate() ORDER BY o_id DESC";
        $select_order_query = mysqli_query($conn,$select_order_sql);
        $count = mysqli_num_rows($select_order_query); 

        $number = 1;


              // ຈຳນວນເພິ່ມເຂົ້າວັນໜີ
      $count_curdate_sql = "SELECT * FROM orders,type WHERE orders.Type_T_id = type.T_id AND o_date = curdate() ";
      $count_curdate_query = mysqli_query($conn,$count_curdate_sql);
      $count_row = mysqli_num_rows($count_curdate_query);

      // ລ່ວມຄາລາທັ້ງໝົດ
      $count_purchase_sql = "SELECT SUM(o_selling) , SUM(o_selling*o_qty) as Total_g_selling,
       SUM(o_qty*o_selling)-SUM(o_qty*o_purchase) as Total_g_snadp FROM orders WHERE o_date = curdate() ";
      $count_purchase_query = mysqli_query($conn,$count_purchase_sql);
      $count_purchase_row = mysqli_fetch_assoc($count_purchase_query);

               // ລົບຂໍ້ມູນ
               if (isset($_GET['delete'])) {
                $delete = $_GET['delete'];
    
                    $delete_goods_sql = "SELECT * FROM goods INNER JOIN orders ON goods.g_id = orders.goods_g_id WHERE o_id = $delete";
                    $delete_goods_query = mysqli_query($conn,$delete_goods_sql);
                        $delete_goods_row = mysqli_fetch_assoc($delete_goods_query);
                            $g_name = $delete_goods_row['g_name'];
                            
                            if ($delete_goods_query) {
                                $update_goods_sql = "UPDATE goods INNER JOIN orders ON goods.g_id = orders.goods_g_id SET g_qty = g_qty + 1 WHERE o_id = $delete ";
                                $update_goods_query = mysqli_query($conn,$update_goods_sql);
                                    
                                    if ($update_goods_query) {
                                            $delete_order_sql = "DELETE FROM orders WHERE o_id = $delete";
                                            $delete_order_query = mysqli_query($conn,$delete_order_sql);

                                            $delete1_orderuser_sql = "DELETE FROM orderuser WHERE ou_id = $delete";
                                         $delete1_orderuser_query = mysqli_query($conn,$delete1_orderuser_sql);
                                                
                                                if ($delete_order_query) {
                                                    $_SESSION['error'] = "ລົບການຂາຍ" . $g_name . "ແລ້ວ";
                                                    header("location: order_curdate.php");
                                                }
                                    }
                            }
            }
            
        
    ?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css" integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../../css/sidebars.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        * {
            font-family: saysettha ot;
        }
    </style>
    <title>ການຂາຍສິນຄ້າ</title>
</head>
<body>
    
<div class="container-fluid">
<div class="row">
          <div class="col-sm-2">
          <div class="flex-shrink-0 p-2 bg-danger text-white" style="width: 225px;">
    <a href="/" class="d-flex align-items-center pb-3 mb-3 link-dark text-decoration-none">
      <svg class="bi pe-none me-2" width="30" height="24"><use xlink:href="#bootstrap"/></svg>
      <span class="fs-5 fw-semibold">ຮ້ານຂາຍເຄືອງທ້າວໄຊຍະລາດ</span>
    </a>

    <div class="border-bottom">
        <div class="profile">
          <img src="../../login/userlogin/img/<?php echo $row_porfile_name['img'] ?>">
        </div>
        <div class="fname"><?php echo $row_porfile_name['fname'] . " " . $row_porfile_name['lname'] ?></div>
    </div>

    <ul class="list-unstyled ps-0">
      <li class="mb-1">
        <button class="btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed" data-bs-toggle="collapse" data-bs-target="#home-collapse" aria-expanded="true">
          ບັນທືກລາຍການ
        </button>
        <div class="collapse" id="home-collapse">
          <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
            <li><a href="../../index.php" class="link-dark d-inline-flex text-decoration-none rounded">ໜ້າຫຼັກ</a></li>
            <li><a href="../inserttype.php" class="link-dark d-inline-flex text-decoration-none rounded">ເພິ່ມປະເພດສິນຄ້າ</a></li>
            <li><a href="../unit/unit.php" class="link-dark d-inline-flex text-decoration-none rounded">ເພິ່ມຫົວໜ່ວຍສິນຄ້າ</a></li>
            <li><a href="../goods/goods.php" class="link-dark d-inline-flex text-decoration-none rounded">ເພິ່ມສິນຄ້າ</a></li>
            <li><a href="../receive/receive.php" class="link-dark d-inline-flex text-decoration-none rounded">ເພິ່ມສິນຄ້ານຳເຂົ້າ</a></li>
          </ul>
        </div>
      </li>
      <li class="mb-1">
        <button class="btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed" data-bs-toggle="collapse" data-bs-target="#dashboard-collapse" aria-expanded="false">
          ສິນຄ້ານຳເຂົ້າ
        </button>
        <div class="collapse" id="dashboard-collapse">
          <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
            <li><a href="../receive/receive_curdate.php" class="link-dark d-inline-flex text-decoration-none rounded ">ສິນຄ້ານຳເຂົ້າວັນນີ້</a></li>
            <li><a href="../receive/receive_sum.php" class="link-dark d-inline-flex text-decoration-none rounded">ສິນຄ້ານຳເຂົ້າທັງໝົດ</a></li>
          </ul>
        </div>
      </li>
      <li class="mb-1">
        <button class="btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed" data-bs-toggle="collapse" data-bs-target="#orders-collapse" aria-expanded="false">
          ສິນຄ້າຂາຍອອກ
        </button>
        <div class="collapse show" id="orders-collapse">
          <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
            <li><a href="order_curdate.php" class="link-dark d-inline-flex text-decoration-none rounded bg-primary">ສິນຄ້າຂາຍອອກວັນນີ້</a></li>
            <li><a href="../order/order.php" class="link-dark d-inline-flex text-decoration-none rounded">ສິນຄ້າຂາຍອອກທັງໝົດ</a></li>
            <li><a href="#" class="link-dark d-inline-flex text-decoration-none rounded">ຂໍ້ມູນພະນັກງານຂາຍ</a></li>
          </ul>
        </div>
      </li>
      <li class="border-top my-3"></li>
      <li class="mb-1">
        <button class="btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed" data-bs-toggle="collapse" data-bs-target="#account-collapse" aria-expanded="false">
          ກ່ຽວກັບ
        </button>
        <div class="collapse" id="account-collapse">
          <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
            <li><a href="#" class="link-dark d-inline-flex text-decoration-none rounded">ຍອດເງີນ</a></li>
            <li><a href="../../login/userlogin/userlogin.php" class="link-dark d-inline-flex text-decoration-none rounded">ສະໜັກພະນັກງານ</a></li>
            <li><a href="../../logout/logout.php?logout='0'" class="link-dark d-inline-flex text-decoration-none rounded btn btn-danger">ອອກຈາກລະບົບ</a></li>
          </ul>
        </div>
      </li>
    </ul>
  </div>
</div>
<div class="col-sm-10">

<div class="row">
          <div class="col-sm-4">
            <p class="text-center fs-7 mt-1">ຈຳນວນລາຍການທັ້ງໝົດ</p>
          <span class="border border-primary fs-5" style="display:flex; justify-content:center">
            <?php echo $count ?>
          </span>
          </div>
          <div class="col-sm-4">
            <p class="text-center fs-7 mt-1">ຈຳນວນລາຍການເພິ່ມເຂົ້າວັນນີ້</p>
          <span class="border border-primary fs-5" style="display:flex; justify-content:center">
            <?php echo $count_row ?>
          </span>
          </div>
         
          
                  <div class="col-sm-4">
            <p class="text-center fs-7 mt-1">ລວ່ມລາຄາຂາຍທັ້ງໝົດ/ອັນ</p>
          <span class="border border-primary fs-5" style="display:flex; justify-content:center">
            <?php echo number_format($count_purchase_row['SUM(o_selling)']) . " ກີບ" ?>
          </span>
          </div>
                 
                  <div class="col-sm-4">
            <p class="text-center fs-7 mt-1">ລວ່ມລາຄາຂາຍທັ້ງໝົດ</p>
          <span class="border border-primary fs-5" style="display:flex; justify-content:center">
            <?php echo number_format($count_purchase_row['Total_g_selling']) . " ກີບ" ?>
          </span>
          </div>
                  <div class="col-sm-4">
            <p class="text-center fs-7 mt-1">ກຳໄລທັ້ງໝົດທີ່ຄວນໄດ້</p>
          <span class="border border-primary fs-5" style="display:flex; justify-content:center">
            <?php echo number_format($count_purchase_row['Total_g_snadp']) . " ກີບ" ?>
          </span>
          </div>
                  </div>

                  <!-- ຕົວແຈ້ງເຕືອນ -->
                  <?php if (isset($_SESSION['error'])) { ?>
                    <?php echo $_SESSION['error'];
                    unset($_SESSION['error']); 
                    ?>
            <?php } ?>  

                <?php if(isset($_SESSION['success'])) { ?>
                      <?php echo $_SESSION['success'];
                      unset($_SESSION['success']); 

                      ?>
                  <?php }?>

                  <!-- ຟອຍຂາຍສິນຄ້າ -->
                  <form action="order_db.php" method="post">
                    <div class="row">
                      <div class="col-sm-3">
                      <label for="">ລະຫັດສິນຄ້າ</label>
                    <input type="text" name="g_id" class="form-control">
                    <button type="submit" name="sell" class="btn btn-outline-success"><i class="fa-solid fa-bag-shopping"></i> ຂາຍ</button>
                  </div>
                  <div class="col-sm-1">
                    <label for="">ຈຳນວນ</label>
                    <input type="number" name="o_qty" id="" class="form-control" value="1" style="width: 50px;">
                  </div>
                
                <div class="col-sm-3">
                  
                  <label for="">ໜາຍເຫດ</label>
                  <input type="text" name="Note" class="form-control">
                  <div class="form-grop mt-2">
                      </div>
                    </div>
                    </div>
                    
                </form>
            
            <?php if ($count == 0) {?>
                <div class="alert alert-danger" role="alert" style="margin-top: 200px;">
                        <h3 class="text-center">ຂໍ້ມູນວ່າງເປົ່າ</h3>
                        </div>
        
        <?php } else { ?>
          <h3 class="text-center mt-2">ຂໍ້ມູນການຂາຍວັນນີ້</h3>
          
                <table class="table table-striped table-hover" style="font-size: 12px;">
                    <thead>
                        <tr>
                            <th>ລຳດັບທີ່</th>
                            <th>ລະຫັດສິນຄ້າ</th>
                            <th>ຊື່ສິນຄ້າ</th>
                            <th>ລາຄາຂາຍ</th>
                            <th>ຈຳນວນ</th>
                            <th>ຫົວໜວ່ຍ</th>
                            <th>ວັນທີ່ຂາຍ</th>
                            <th>ຊົ່ວໂມງຂາຍ</th>
                            <th>ໜາຍເຫດ</th>
                            <th>ປະເພດສິນຄ້າ</th>
                            <th>ລົບ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($select_order_row = mysqli_fetch_assoc($select_order_query)) { ?>
                                <tr>
                                    <td><?php echo $number++ ?></td>
                                    <td><?php echo $select_order_row['g_id'] ?></td>
                                    <td><?php echo $select_order_row['o_name'] ?></td>
                                    <td><?php echo number_format($select_order_row['o_selling']) . " ກີບ" ?></td>
                                    <td><?php echo $select_order_row['o_qty'] ?></td>
                                    <td><?php echo $select_order_row['u_name'] ?></td>
                                    <td><?php echo $select_order_row['o_date'] ?></td>
                                    <td><?php echo $select_order_row['o_time'] ?></td>
                                    <td><?php echo $select_order_row['Note'] ?></td>
                                    <td><?php echo $select_order_row['T_name'] ?></td>
                                    <td><a href="order_curdate_db.php?delete=<?php echo $select_order_row['o_id']?>
                                    &delete_name=<?php echo $select_order_row['o_name'] ?>&delete_o_qty=<?php echo $select_order_row['o_qty'] ?>" class="btn btn-outline-danger" style="font-size: 12px;"><i class="fa-solid fa-trash"></i> ລົບ</a></td>
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