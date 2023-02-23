<?php
    session_start();
    include('../../connect/connect.php');

  // ເຊັກການລ່ອກອິນການເຂົ້າເຖິງໜ້ານີ້
  if (!isset($_SESSION['login_admin'])) {
      session_start();
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
    

    $sql = "SELECT * FROM sub INNER JOIN unit ON sub.unit_u_id = unit.u_id INNER JOIN type ON type.T_id = sub.Type_T_id";
    $query = mysqli_query($conn,$sql);
    $count = mysqli_num_rows($query);

    // ລຳດັບທີ່
    $number = 1;

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ສິນຄ້ານຳເຂົ້າ</title>
</head>
<body>
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
    <link rel="stylesheet" href="../../css/alsert_from.css">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        * {
            font-family: saysettha ot;
        }
    </style>
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
        <div class="collapse show" id="home-collapse">
          <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
            <li><a href="../../index.php" class="link-dark d-inline-flex text-decoration-none rounded">ໜ້າຫຼັກ</a></li>
            <li><a href="../inserttype.php" class="link-dark d-inline-flex text-decoration-none rounded">ເພິ່ມປະເພດສິນຄ້າ</a></li>
            <li><a href="../unit/unit.php" class="link-dark d-inline-flex text-decoration-none rounded">ເພິ່ມຫົວໜ່ວຍສິນຄ້າ</a></li>
            <li><a href="../goods/goods.php" class="link-dark d-inline-flex text-decoration-none rounded">ເພິ່ມສິນຄ້າ</a></li>
            <li><a href="../sub/sub.php" class="link-dark d-inline-flex text-decoration-none rounded bg-primary">ເພິ່ມສິນຄ້າຍ່ອຍ</a></li>
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
            <li><a href="receive_curdate.php" class="link-dark d-inline-flex text-decoration-none rounded">ສິນຄ້ານຳເຂົ້າວັນນີ້</a></li>
            <li><a href="receive_sum.php" class="link-dark d-inline-flex text-decoration-none rounded">ສິນຄ້ານຳເຂົ້າທັງໝົດ</a></li>
          </ul>
        </div>
      </li>
      <li class="mb-1">
        <button class="btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed" data-bs-toggle="collapse" data-bs-target="#orders-collapse" aria-expanded="false">
          ສິນຄ້າຂາຍອອກ
        </button>
        <div class="collapse" id="orders-collapse">
          <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
            <li><a href="../order/order_curdate.php" class="link-dark d-inline-flex text-decoration-none rounded">ສິນຄ້າຂາຍອອກວັນນີ້</a></li>
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

            <!-- ຕົວແຈ້ງເຕືອນ -->
            <?php if (isset($_SESSION['error'])) { ?>
       
       <?php echo $_SESSION['error'];
       unset($_SESSION['error']);
        ?>

   <?php } ?>
<?php if (isset($_SESSION['success'])) { ?>

       <?php echo $_SESSION['success'] ;
       unset($_SESSION['success']);
}
       ?>
      

                <!-- ນັບຈຳນວນຂໍ້ມູນຖ້າມີໃຫ້ສະແດງ -->
                <?php if ($count == 0) { ?>
                    <div class="alert alert-danger" role="alert" style="margin-top: 200px;">
                        <h3 class="text-center">ຂໍ້ມູນວ່າງເປົ່າ</h3>
                        </div>
                    <?php } else { ?>
                      <a href="receive_sum.php?search='1'" class="btn btn-outline-primary"><i class="fa-solid fa-magnifying-glass"></i> ຄົ້ນຫາ</a>
                        <table class="table table-striped table-hover" style="font-size: 12px;">
                            <thead>
                                <tr>
                                    <th>ລຳດັບທີ່</th>
                                    <th>ລະຫັດການແຍກ</th>
                                    <th>ຊື່ສິນຄ້າ</th>
                                    <th>ລາຄາຂາຍອອກ</th>
                                    <th>ປະເພດສິນຄ້າ</th>
                                    <th>ຈຳນວນນຳເຂົ້າ</th>
                                    <th>ຫົວໜວ່ຍ</th>
                                    <th>ສະຖານະນຳເຂົ້າ</th>
                                    <th>ວັນທີ່ນຳເຂົ້າ</th>
                                    <th>ລົບ</th>
                                    </tr>
                            </thead>
                            <tbody>
                                <?php while($row = mysqli_fetch_assoc($query)) { ?>
                                    <tr><td><?php echo $number++ ?></td>
                                        <td><?php echo $row['s_id']?></td>
                                        <td><?php echo $row['s_name']?></td>
                                        <td><?php echo number_format($row['s_selling']) . " ກີບ"?></td>
                                        <td><?php echo $row['T_name']?></td>
                                        <td><?php echo $row['s_qty']?></td>
                                        <td><?php echo $row['u_name']?></td>
                                        <td><?php echo $row['s_story']?></td>
                                        <td><?php echo $row['s_date']?></td>
                                        <td><a href="receive_sum_db.php?delete=<?php echo $row['s_id'] ?>&delete_name=<?php echo $row['s_name'] ?>" class="btn btn-outline-danger" style="font-size: 12px;"><i class="fa-solid fa-trash"></i> ລົບ</a></td>
                                        
                                    </tr>
                                    <?php } ?>
                                    
                            </tbody>
                        </table>
                        
                        <?php } ?>
            </div>

            <?php if (isset($_GET['search'])) { ?>
                  <form action="search_receive_sum.php" method="post" class="form-search">
                    <label for="">ຄົ້ນຫາຊື້ສິນຄ້າ</label>
                    <input type="text" name="search_name" class="form-control">
                    <button type="submit" name="search" class="btn btn-outline-primary"><i class="fa-solid fa-magnifying-glass"></i> ຄົ້ນຫາ</button>
                    <a href="receive_sum.php" class="btn btn-outline-success"><i class="fa-solid fa-rotate-left"></i> ກັບຄືນ</a>
                  </form>
              <?php } ?>



       </div>


<script src="../../js/sidebars.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>
</html>
</body>
</html>