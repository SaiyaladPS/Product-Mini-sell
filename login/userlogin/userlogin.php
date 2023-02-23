<?php
  session_start();
  require_once '../../connect/connect.php';


  // ເຊັກການເຂົ້າເຖິງ
  if (!isset($_SESSION['login_admin']) && isset($_SESSION['login_admin_password'])) {
    session_destroy();
    header("location: ../login.php");
  }

// ເຊັກຄົົນທີ່ສະໜັກເຂົ້າມາເພືອສະແດງເປັນຄົນນັ້ນ
if (isset($_SESSION['login_admin']) && isset($_SESSION['login_admin_password'])) {
  $userid = $_SESSION['login_admin'];
$password = $_SESSION['login_admin_password'];
$sql_profile_login = "SELECT * FROM login WHERE id = '$userid' AND password = '$password' ";
$query_profile_ligin = mysqli_query($conn,$sql_profile_login);

          $row_porfile_name = mysqli_fetch_assoc($query_profile_ligin);
}



  // ຮູບແບບເລິ່ມຕົ້ນ
  $sql_select_img_default = "SELECT * FROM login WHERE id = 1";
  $query_select_img_default = mysqli_query($conn,$sql_select_img_default);
  $row_select_img_default = mysqli_fetch_assoc($query_select_img_default);

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ສະໜັກພະນັກງານຂາຍ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css" integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../../css/sidebars.css">
    <link rel="stylesheet" href="../../css/alsert_from.css">
    <link rel="stylesheet" href="../../css/profile.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
            <li><a href="../../index.php" class="link-dark d-inline-flex text-decoration-none rounded ">ໜ້າຫຼັກ</a></li>
            <li><a href="../../insert/inserttype.php" class="link-dark d-inline-flex text-decoration-none rounded">ເພິ່ມປະເພດສິນຄ້າ</a></li>
            <li><a href="../../insert/unit/unit.php" class="link-dark d-inline-flex text-decoration-none rounded">ເພິ່ມຫົວໜ່ວຍສິນຄ້າ</a></li>
            <li><a href="../../insert/goods/goods.php" class="link-dark d-inline-flex text-decoration-none rounded">ເພິ່ມສິນຄ້າ</a></li>
            <li><a href="../../insert/receive/receive.php" class="link-dark d-inline-flex text-decoration-none rounded">ເພິ່ມສິນຄ້ານຳເຂົ້າ</a></li>
          </ul>
        </div>
      </li>
      <li class="mb-1">
        <button class="btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed" data-bs-toggle="collapse" data-bs-target="#dashboard-collapse" aria-expanded="false">
          ສິນຄ້ານຳເຂົ້າ
        </button>
        <div class="collapse" id="dashboard-collapse">
          <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
            <li><a href="../../insert/receive/receive_curdate.php" class="link-dark d-inline-flex text-decoration-none rounded">ສິນຄ້ານຳເຂົ້າວັນນີ້</a></li>
            <li><a href="../../insert/receive/receive_sum.php" class="link-dark d-inline-flex text-decoration-none rounded">ສິນຄ້ານຳເຂົ້າທັງໝົດ</a></li>
          </ul>
        </div>
      </li>
      <li class="mb-1">
        <button class="btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed" data-bs-toggle="collapse" data-bs-target="#orders-collapse" aria-expanded="false">
          ສິນຄ້າຂາຍອອກ
        </button>
        <div class="collapse" id="orders-collapse">
          <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
            <li><a href="../../insert/order/order_curdate.php" class="link-dark d-inline-flex text-decoration-none rounded">ສິນຄ້າຂາຍອອກວັນນີ້</a></li>
            <li><a href="../../insert/order/order.php" class="link-dark d-inline-flex text-decoration-none rounded">ສິນຄ້າຂາຍອອກທັງໝົດ</a></li>
            <li><a href="#" class="link-dark d-inline-flex text-decoration-none rounded">ຂໍ້ມູນພະນັກງານຂາຍ</a></li>
          </ul>
        </div>
      </li>
      <li class="border-top my-3"></li>
      <li class="mb-1">
        <button class="btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed" data-bs-toggle="collapse" data-bs-target="#account-collapse" aria-expanded="false">
          ກ່ຽວກັບ
        </button>
        <div class="collapse show" id="account-collapse">
          <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
            <li><a href="#" class="link-dark d-inline-flex text-decoration-none rounded">ຍອດເງີນ</a></li>
            <li><a href="userlogin.php" class="link-dark d-inline-flex text-decoration-none rounded bg-primary">ພະນັກງານຂາຍ</a></li>
            <li><a href="../../logout/logout.php?logout='0'" class="link-dark d-inline-flex text-decoration-none rounded btn btn-danger">ອອກຈາກລະບົບ</a></li>
          </ul>
        </div>
      </li>
    </ul>
  </div>
</div>


<div class="col-sm-10 mt-4">
       
       <div class="container">

        <?php if (isset($_SESSION['error'])) {
          echo $_SESSION['error'];
          unset($_SESSION['error']);
        } ?>
        <?php if (isset($_SESSION['success'])) {
          echo $_SESSION['success'];
          unset($_SESSION['success']);
        } ?>


        <form action="userlogin_db.php" class="text-center"  method="post" enctype="multipart/form-data">
          <label for="" style="font-size: 20px;">ຮູບພະນັກງານ</label>
          <div class="add_profile">
              <div class="img_profile">
              <img src="img/<?php echo $row_select_img_default['img'] ?>" id="previewimg">
              </div>
            <div class="btn_profile">
            <input type="file" name="imguser" id="imginput" accept="image/gif, image/jpeg, image/png">
            <i class="fa-sharp fa-solid fa-folder-plus"></i>
            </div>
          </div>
        <div class="row">
          <div class="col-sm-12">
            <div class="input">
              <input type="text" name="userid" id="" required>
              <label for="">ລະຫັດພະນັກງານ</label>
            </div>
          </div>
        </div>

        <div class="row">
        
        <div class="col-sm-6">
       <div class="input">
         <input type="text" name="fname" required>
         <label for="">ຊື່ພະນັກງານ</label>
       </div>
          <div class="input">
            <input type="text" name="lname" required>
            <label for="">ນາມສະກຸນ</label>
          </div>
          <div class="input">
          <input type="number" name="Tel" id="" required>
          <label for="">ເບີໂທ</label>
          </div>
        </div>


            <div class="col-sm-6">
            <div class="input">
              <input type="password" name="password_1" id="" required>
              <label for="">ລະຫັດຜ່ານ</label>
            </div>
          <div class="input">
            <input type="password" name="password_2" id="" required>
            <label for="">ຍືນຍັນລະຫັດຜ່ານ</label>
          </div>
         <div class="input">
         <select name="userandadmin" id="">
            <option value=""><--ເລືອກລະດັບ--></option>
            <option value="admin">ຜູ້ບໍລິຫານໂປຣແກຣມ</option>
            <option value="user">ພະລັກງານຂາຍທົ່ວໄປ</option>
          </select>
         </div>
            </div>


        </div>

          
          <div class="input_btn">
          <input type="submit" value="ບັັນທືກ" name="submit" class="btn btn-outline-success">
          <input type="reset" value="ລ້າງ" class="btn btn-outline-danger">
          </div>
        </form>

        </div>

          </div>
        </div>
        </div>
  
<script src="../../js/Previewimg.js"></script>
<script src="../../js/sidebars.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>
</html>