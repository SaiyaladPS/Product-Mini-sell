<?php
  session_start();
  require_once 'connect/connect.php';

  // ເຊັກການລ໋ອກອິນ
    if (!isset($_SESSION['login_admin'])) {
      session_destroy();
      header("location: login/login.php");
    }

        // ຊອກຫາຈຳນວນການຂາຍວັນນີ້ 
        $sql_order_curdate = "SELECT * FROM orders WHERE o_date = curdate()";
        $quer_order_curdate = mysqli_query($conn,$sql_order_curdate);
        $fetch_order_curdate = mysqli_fetch_assoc($quer_order_curdate);
        $row_order_curdate = mysqli_num_rows($quer_order_curdate);

        // ຊອກຫາຈຳນວນນຳເຂົ້າວັນນີ້
        $sql_receive_curdate = "SELECT * FROM receive WHERE r_date = curdate()";
        $query_receive_curdate = mysqli_query($conn,$sql_receive_curdate);
        $row_receive_curdate = mysqli_num_rows($query_receive_curdate);


        // ບວກລົບຈຳນວນເງີນການຂາຍວັນນີ້
        $sql_order_curdate_2 = "SELECT SUM(o_selling*o_qty) as tlto, SUM(o_qty) as o_qty FROM orders WHERE o_date = curdate()";
        $query_order_curdate_2 = mysqli_query($conn,$sql_order_curdate_2);
        $fetch_order_curdate_2 = mysqli_fetch_assoc($query_order_curdate_2);


        // ບວກລົບຈຳນວນເງີນກາຍນຳເຂົ້າວັນນີ້
        $sql_receive_curdate_2 = "SELECT SUM(r_purchase*r_qty) as r_purchase,SUM(r_qty) as r_qty FROM receive WHERE r_date = curdate()";
        $query_receive_curdate_2 = mysqli_query($conn,$sql_receive_curdate_2);
        $fetch_receive_curdate_2 = mysqli_fetch_assoc($query_receive_curdate_2);


        // ຊອກຫາຈຳນວນຢູ່ໃນສະຕ໋ອກສິນຄ້າ
        $sql_goods_curdate = "SELECT * FROM goods";
        $query_goods_curdate = mysqli_query($conn,$sql_goods_curdate);
        $row_goods_curdate = mysqli_num_rows($query_goods_curdate);

        // ບອກລົບຈຳນວນເງີນໃນສະຕ່ອກ
        $sql_goods_curdate_2 = "SELECT SUM(g_qty) as g_qty, SUM(g_purchase*g_qty) as p_and_q FROM goods";
        $query_goods_curdate_2 = mysqli_query($conn,$sql_goods_curdate_2);
        $fetch_goods_curdate_2 = mysqli_fetch_assoc($query_goods_curdate_2);


        // ເຊັກຄົົນທີ່ສະໜັກເຂົ້າມາເພືອສະແດງເປັນຄົນນັ້ນ
        if (isset($_SESSION['login_admin']) && isset($_SESSION['login_admin_password'])) {
          $userid = $_SESSION['login_admin'];
        $password = $_SESSION['login_admin_password'];
        $sql_profile_login = "SELECT * FROM login WHERE id = '$userid' AND password = '$password' ";
        $query_profile_ligin = mysqli_query($conn,$sql_profile_login);
  
                  $row_porfile_name = mysqli_fetch_assoc($query_profile_ligin);
        }
        
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ລາຍງານສະຖານະຂໍ້ມູນ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css" integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/sidebars.css">
    <link rel="stylesheet" href="css/alsert_from.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    

        <div class="container-fluid">
        <div class="row">
          <div class="col-sm-2">
          <div class="flex-shrink-0 p-2 bg-danger text-white" style="width: 225px;">
    <a href="/" class="d-flex align-items-center pb-3 mb-3 link-dark text-decoration-none ">
      <svg class="bi pe-none me-2" width="30" height="24"><use xlink:href="#bootstrap"/></svg>
      <span class="fs-5 fw-semibold">ຮ້ານຂາຍເຄືອງທ້າວໄຊຍະລາດ</span>
    </a>
    
    <div class="border-bottom">
        <div class="profile">
          <img src="login/userlogin/img/<?php echo $row_porfile_name['img'] ?>">
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
            <li><a href="index.php" class="link-dark d-inline-flex text-decoration-none rounded bg-primary">ໜ້າຫຼັກ</a></li>
            <li><a href="insert/inserttype.php" class="link-dark d-inline-flex text-decoration-none rounded">ເພິ່ມປະເພດສິນຄ້າ</a></li>
            <li><a href="insert/unit/unit.php" class="link-dark d-inline-flex text-decoration-none rounded">ເພິ່ມຫົວໜ່ວຍສິນຄ້າ</a></li>
            <li><a href="insert/goods/goods.php" class="link-dark d-inline-flex text-decoration-none rounded">ເພິ່ມສິນຄ້າ</a></li>
            <li><a href="insert/receive/receive.php" class="link-dark d-inline-flex text-decoration-none rounded">ເພິ່ມສິນຄ້ານຳເຂົ້າ</a></li>
          </ul>
        </div>
      </li>
      <li class="mb-1">
        <button class="btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed" data-bs-toggle="collapse" data-bs-target="#dashboard-collapse" aria-expanded="false">
          ສິນຄ້ານຳເຂົ້າ
        </button>
        <div class="collapse" id="dashboard-collapse">
          <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
            <li><a href="insert/receive/receive_curdate.php" class="link-dark d-inline-flex text-decoration-none rounded">ສິນຄ້ານຳເຂົ້າວັນນີ້</a></li>
            <li><a href="insert/receive/receive_sum.php" class="link-dark d-inline-flex text-decoration-none rounded">ສິນຄ້ານຳເຂົ້າທັງໝົດ</a></li>
          </ul>
        </div>
      </li>
      <li class="mb-1">
        <button class="btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed" data-bs-toggle="collapse" data-bs-target="#orders-collapse" aria-expanded="false">
          ສິນຄ້າຂາຍອອກ
        </button>
        <div class="collapse" id="orders-collapse">
          <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
            <li><a href="insert/order/order_curdate.php" class="link-dark d-inline-flex text-decoration-none rounded">ສິນຄ້າຂາຍອອກວັນນີ້</a></li>
            <li><a href="insert/order/order.php" class="link-dark d-inline-flex text-decoration-none rounded">ສິນຄ້າຂາຍອອກທັງໝົດ</a></li>
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
            <li><a href="login/userlogin/userlogin.php" class="link-dark d-inline-flex text-decoration-none rounded">ສະໜັກພະນັກງານ</a></li>
            <li><a href="logout/logout.php?logout='0'" class="link-dark d-inline-flex text-decoration-none rounded btn btn-danger">ອອກຈາກລະບົບ</a></li>
          </ul>
        </div>
      </li>
    </ul>
  </div>
</div>


<div class="col-sm-10 mt-4">
        <div class="row">

          <div class="col-sm-4">
          <div class="card bg-primary text-center"><i class="fa-solid fa-bag-shopping" style="font-size: 150px;text-align: right;opacity: 30%;position: absolute;right: 0;"></i>
            <h4 class="mt-3">ຂາຍວັນນີ້ <span class="badge bg-warning rounded-pill"><?php echo $row_order_curdate ?> ລາຍການ</span></h4>
            <h5>ສິນຄ້າ <span class="badge bg-warning rounded-pill"><?php echo $fetch_order_curdate_2['o_qty']?> ຈຳນວນ</span></h5>
            <h5>ຈຳນວນເງີນ <span class="badge bg-success rounded-pill"><?php echo number_format($fetch_order_curdate_2['tlto']) ?> ກີບ</span></h5>
            <a href="insert/order/order_curdate.php" class="btn text-light">ອ່າມເພິ່ມເຕິມ <i class="fa-solid fa-arrow-right"></i></a>
          </div>
        </div>

        <div class="col-sm-4">
          <div class="card bg-primary text-center"><i class="fa-solid fa-file-import" style="font-size: 150px;text-align: right;opacity: 30%;position: absolute;right: 0;"></i>
            <h4 class="mt-3">ນຳເຂົ້າວັນນີ້ <span class="badge bg-warning rounded-pill"><?php echo  $row_receive_curdate ?> ລາຍການ</span></h4>
            <h5>ສິນຄ້າ <span class="badge bg-warning rounded-pill"><?php echo $fetch_receive_curdate_2['r_qty'] ?> ຈຳນວນ</span></h5>
            <h5>ຈຳນວນເງີນຊື້ເຂົ້າ <span class="badge bg-danger rounded-pill"><?php echo number_format($fetch_receive_curdate_2['r_purchase']) ?> ກີບ</span></h5>
            <a href="insert/receive/receive_curdate.php" class="btn text-light">ອ່າມເພິ່ມເຕິມ <i class="fa-solid fa-arrow-right"></i></a>
          </div>
        </div>


        <div class="col-sm-4">
          <div class="card bg-primary text-center"><i class="fa-solid fa-square-nfi" style="font-size: 150px;text-align: right;opacity: 30%;position: absolute;right: 0;"></i>
            <h4 class="mt-3">ສະຕ໋ອກສິນຄ້າ <span class="badge bg-warning rounded-pill"><?php echo  $row_goods_curdate ?> ລາຍການ</span></h4>
            <h5>ສິນຄ້າ <span class="badge bg-warning rounded-pill"><?php echo $fetch_goods_curdate_2['g_qty'] ?> ຈຳນວນ</span></h5>
            <h5>ຈຳນວນເງີນຊື້ເຂົ້າ <span class="badge bg-danger rounded-pill"><?php echo number_format($fetch_goods_curdate_2['p_and_q']) ?> ກີບ</span></h5>
            <a href="insert/goods/goods.php" class="btn text-light">ອ່າມເພິ່ມເຕິມ <i class="fa-solid fa-arrow-right"></i></a>
          </div>
        </div>






          </div>
        </div>
        </div>
  

<script src="js/sidebars.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>
</html>