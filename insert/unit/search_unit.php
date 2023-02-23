<?php
    session_start();
    include('../../connect/connect.php');
 
// ເຊັກການເຂົ້າເຖິງການລ໋ອກອິນ
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
        


    // ອອກຈາກລະບົບ
    if (isset($_GET['logout'])) {
      session_destroy();
      header("location: ../../login/login.php");
    }

    // ຄົນຫາຂໍ້ມູນ
          if (isset($_POST['search'])) {
        $search_name = $_POST['select'];
        
          $select_unit_sql = "SELECT * FROM unit WHERE u_name LIKE '%$search_name%' ORDER BY u_name ASC ";
          $select_unit_query = mysqli_query($conn,$select_unit_sql);
          $select_unit_count = mysqli_num_rows($select_unit_query);
          $_SESSION['success'] = "<script>
          Swal.fire({
              icon: 'success',
              title: 'ຫາຂໍ້ມູນທີ່ຕົງກັບ $search_name ພົບ $select_unit_count ລາຍການ',
              showConfirmButton: false,
              timer: 1500
          })
          </script>";
          }

    $number = 1;




?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ເພິ່ມຫົວໜ່ວຍສິນຄ້າ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css" integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../../css/sidebars.css">
    <link rel="stylesheet" href="../../css/alsert_from.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
            <li><a href="unit.php" class="link-dark d-inline-flex text-decoration-none rounded bg-primary">ເພິ່ມຫົວໜ່ວຍສິນຄ້າ</a></li>
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
            <li><a href="../receive/receive_curdate.php" class="link-dark d-inline-flex text-decoration-none rounded">ສິນຄ້ານຳເຂົ້າວັນນີ້</a></li>
            <li><a href="../receive/receive_sum.php" class="link-dark d-inline-flex text-decoration-none rounded">ສິນຄ້ານຳເຂົ້າທັງໝົດ</a></li>
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
            <li><a href="search_unit.php?logout=1" class="link-dark d-inline-flex text-decoration-none rounded btn btn-danger">ອອກຈາກລະບົບ</a></li>
          </ul>
        </div>
      </li>
    </ul>
  </div>
</div>





<div class="col-sm-10 mt-4">

<!-- ຕົວແຈ້ງເຕືອນ -->
<?php if (isset($_SESSION['error'])) { ?>
        <?php echo $_SESSION['error'];
                 unset($_SESSION['error']);
                 ?>
     <?php } ?>


     
<?php if (isset($_SESSION['success'])) { ?>
    <?php echo $_SESSION['success'];
                 unset($_SESSION['success']);
                 ?>
     <?php } ?>



     <!-- ປຸ່ມ ເພິ່ມ ແລະ ຄົ້ນຫາ -->
     <a href="unit.php?add='1'" class="btn btn-primary">ເພິ່ມ</a>
     <a href="unit.php?search='1'" class="btn btn-primary">ຄົ້ນຫາ</a>

 <?php if ($select_unit_count === 0) { ?>
  <div class="alert alert-danger mt-3" role="alert" style="margin-top: 200px;">
  <h3 class="text-center">ຂໍ້ມູນວ່າງເປົ່າ!?</h3>
</div>
  <?php } else { ?>
       <!-- ຕາຕະລາງ -->
   <table class="table table-striped table-hover" style="font-size: 12px;">
    <thead>
      <tr>
        <th>ລຳດັບທີ່</th>
        <th>ລະຫັດຫົວໜວ່ຍ</th>
        <th>ຫົວໜ່ວຍ</th>
        <th>ລົບຂໍ້ມູນ</th>
        <th>ແກ້ໄຂ</th>
        <th>ໜາຍເຫດ</th>
      </tr>
    </thead>
    <tbody>
      <?php while($select_unit_row = mysqli_fetch_assoc($select_unit_query)) { ?>
          <tr>
            <td><?php echo $number++ ?></td>
            <td><?php echo $select_unit_row['u_id'] ?></td>
            <td><?php echo $select_unit_row['u_name'] ?></td>
            <td><a href="unit_db.php?delete=<?php echo $select_unit_row['u_id'] ?>&delete_name=<?php echo $select_unit_row['u_name'] ?>" class="btn btn-danger" style="font-size: 12px">ລົບຂໍ້ມູນ</a></td>
            <td><a href="unit.php?edit=<?php echo $select_unit_row['u_id'] ?>" class="btn btn-primary" style="font-size: 12px">ແກ້ໄຂ</a></td>
            <td><?php echo $select_unit_row['Note'] ?></td>
          </tr>
        <?php } ?>
    </tbody>
  </table>
    <?php } ?>
</div>
        </div>
        </div>
        </div>
  


       </div>

       </div>


       
<script src="../../js/sidebars.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    </body>
    </html>