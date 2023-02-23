<?php
      session_start();
    include('../connect/connect.php');

// ຖ້າບໍ່ມີການລ່ອກອິນເຂົ້າມາໃຫ້ກັບໄປໜ້າລ໋ອກອິນ
if (!isset($_SESSION['login_admin'])) {
      session_destroy();
      header("location: ../login/login.php");
    }

      // ດືງຂໍ້ມູນຕາຕະລາງປະເພດອາຫານ
      $sql = "SELECT * FROM type ";
      $query = mysqli_query($conn,$sql);
      $count = mysqli_num_rows($query);

      $date_query = mysqli_query($conn,"SELECT * FROM type WHERE T_date = curdate()");
      $date_count = mysqli_num_rows($date_query);


      if (isset($_GET['edit'])){
        $edit = $_GET['edit'];

        $edit_sql = "SELECT * FROM type WHERE T_id = $edit";
        $edit_query = mysqli_query($conn,$edit_sql);

        $reslt = mysqli_fetch_assoc($edit_query);

        
        $_SESSION['success'] = "<script>
        const Toast = Swal.mixin({
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 1500,
          timerProgressBar: true,
          didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
          }
        })
        
        Toast.fire({
          icon: 'success',
          title: 'ເຂົ້າສູ່ໜ້າແກ້ໄຂຂໍ້ມູນ'
        })
        </script>";
      }

      // ລຽງລຳດັບທີ່ 
      $number = 1;

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
    <title>ເພິ່ມປະເພດສິນຄ້າ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css" integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../css/sidebars.css">
    <link rel="stylesheet" href="../css/alsert_from.css">
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
          <img src="../login/userlogin/img/<?php echo $row_porfile_name['img'] ?>">
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
            <li><a href="../index.php" class="link-dark d-inline-flex text-decoration-none rounded">ໜ້າຫຼັກ</a></li>
            <li><a href="inserttype.php" class="link-dark d-inline-flex text-decoration-none rounded bg-primary">ເພິ່ມປະເພດສິນຄ້າ</a></li>
            <li><a href="unit/unit.php" class="link-dark d-inline-flex text-decoration-none rounded">ເພິ່ມຫົວໜ່ວຍສິນຄ້າ</a></li>
            <li><a href="goods/goods.php" class="link-dark d-inline-flex text-decoration-none rounded">ເພິ່ມສິນຄ້າ</a></li>
            <li><a href="../insert/receive/receive.php" class="link-dark d-inline-flex text-decoration-none rounded">ເພິ່ມສິນຄ້ານຳເຂົ້າ</a></li>
          </ul>
        </div>
      </li>
      <li class="mb-1">
        <button class="btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed" data-bs-toggle="collapse" data-bs-target="#dashboard-collapse" aria-expanded="false">
          ສິນຄ້ານຳເຂົ້າ
        </button>
        <div class="collapse" id="dashboard-collapse">
          <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
            <li><a href="../insert/receive/receive_curdate.php" class="link-dark d-inline-flex text-decoration-none rounded">ສິນຄ້ານຳເຂົ້າວັນນີ້</a></li>
            <li><a href="../insert/receive/receive_sum.php" class="link-dark d-inline-flex text-decoration-none rounded">ສິນຄ້ານຳເຂົ້າທັງໝົດ</a></li>
          </ul>
        </div>
      </li>
      <li class="mb-1">
        <button class="btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed" data-bs-toggle="collapse" data-bs-target="#orders-collapse" aria-expanded="false">
          ສິນຄ້າຂາຍອອກ
        </button>
        <div class="collapse" id="orders-collapse">
          <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
            <li><a href="order/order_curdate.php" class="link-dark d-inline-flex text-decoration-none rounded">ສິນຄ້າຂາຍອອກວັນນີ້</a></li>
            <li><a href="order/order.php" class="link-dark d-inline-flex text-decoration-none rounded">ສິນຄ້າຂາຍອອກທັງໝົດ</a></li>
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
            <li><a href="../login/userlogin/userlogin.php" class="link-dark d-inline-flex text-decoration-none rounded">ສະໜັກພະນັກງານ</a></li>
            <li><a href="../logout/logout.php?logout='0'" class="link-dark d-inline-flex text-decoration-none rounded btn btn-danger">ອອກຈາກລະບົບ</a></li>
          </ul>
        </div>
      </li>
    </ul>
  </div>
</div>




<div class="col-sm-10 mt-4">
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

         
    <div class="row">
      <div class="col-sm-4">
      <h3 class="text-center fs-4">ຈຳນວນລາຍການທັງໝົດ</h3><div class="card fs-5 text-center"><?php echo $count . " <div style = 'color:red'>ລາຍການ</div>" ?></div>
      </div>
      <div class="col-sm-4">
        <h3 class="text-center fs-4">ຈຳນວນເພິ່ມເຂົ້າວັນນີ້</h3><div class="card fs-5 text-center"><?php echo $date_count . " <div style = 'color:red'>ລາຍການ</div>" ?></div>
      </div>
    </div>

          <a href="inserttype.php?add='1'" class="btn btn-outline-primary my-2"><i class="fa-solid fa-square-plus"></i> ເພິ່ມ</a>
          
          <?php if ($count === 0) { ?>
            <div class="alert alert-danger mt-3" role="alert" style="margin-top: 200px;">
              <h3 class="text-center">ຂໍ້ມູນວ່າງເປົ່າ!?</h3>
            </div>
            <?php } else { ?>
              
              
              <a href="inserttype.php?search='1'" class="btn btn-outline-primary my-2"><i class="fa-solid fa-magnifying-glass"></i> ຄົນຫາ</a>


<!-- ແຈ້ງເຕືອນແກ້ໄຂ -->
            <?php if (isset($_SESSION['editerror'])) { ?>
        <?php echo $_SESSION['editerror'];
                 unset($_SESSION['editerror']);
                 ?>
     <?php } ?>
<?php if (isset($_SESSION['editsuccess'])) { ?>
    <?php echo $_SESSION['editsuccess'];
                 unset($_SESSION['editsuccess']);
                 ?>
     <?php } ?>
          
       <!-- ຕາຕະລາງ -->
   <table class="table table-striped table-hover" style="font-size: 12px;">
    <thead>
      <tr>
        <th>ລຳດັບທີ່</th>
        <th>ລະຫັດປະເພດ</th>
        <th>ປະເພດສິນຄ້າ</th>
        <th>ລົບຂໍ້ມູນ</th>
        <th>ແກ້ໄຂ</th>
        <th>ໜາຍເຫດ</th>
      </tr>
    </thead>
    <tbody>
      <?php while($row = mysqli_fetch_assoc($query)) { ?>
          <tr>
            <td><?php echo $number++ ?></td>
            <td><?php echo $row['T_id'] ?></td>
            <td><?php echo $row['T_name'] ?></td>
            <td><a href="inserttype_db.php?delete=<?php echo $row['T_id'] ?>&T_name=<?php echo $row['T_name']?>" class="btn btn-outline-danger" style="font-size: 12px"><i class="fa-solid fa-trash"></i> ລົບຂໍ້ມູນ</a></td>
            <td>
              <a href="inserttype.php?edit=<?php echo $row['T_id'] ?>" class="btn btn-outline-primary" style="font-size: 12px"><i class="fa-solid fa-pen-to-square"></i> ແກ້ໄຂ</a>
            </td>
            <td><?php echo $row['Note'] ?></td>
          </tr>
        <?php } ?>
    </tbody>
  </table>
    <?php } ?>
</div>


          
     <?php if (isset($_GET['edit'])) { ?>
       
       <!-- ຟອນແກ້ໄຂຂໍ້ມູນ -->
       <form action="inserttype_db.php" method="post" class="form-edit">
        <input type="hidden" name="T_id" value="<?php echo $reslt['T_id'] ?>">
      <label class="label-control" for="T_name">ປະເພດສິນຄ້າ</label> <i class="fa-solid fa-keyboard"></i>
      <input type="text" name="T_name" class="form-control" value="<?php echo $reslt['T_name'] ?>">
      <label class="label-control" for="Note">ໜາຍເຫດ</label> <i class="fa-solid fa-note-sticky"></i>
      <input type="text" name="Note" class="form-control" value="<?php echo $reslt['Note']?>">
      <div class="form-group mt-2">
      <button type="submit" name="edit" class="btn btn-outline-success"><i class="fa-solid fa-pen-to-square"></i> ແກ້ໄຂ</button>
      <button type="reset" class="btn btn-outline-danger"><i class="fa-solid fa-trash"></i> ລ້າງຂໍ້ມູນ</button>
      <a href="inserttype.php" class="btn btn-outline-primary"><i class="fa-solid fa-rotate-left"></i> ກັບຄືນ</a>
      </div>
    </form>
            <?php } ?>


 <!-- ຟອນບັນທືກຂໍ້ມູນ -->
    <?php if (isset($_GET['add'])) { ?>
      <?php echo "<script>
        const Toast = Swal.mixin({
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 1500,
          timerProgressBar: true,
          didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
          }
        })
        
        Toast.fire({
          icon: 'success',
          title: 'ເຂົ້າສູ່ໜ້າບັນທືກຂໍ້ມູນແລ້ວ'
        })
        </script>" ?>
      
      <form action="inserttype_db.php" method="post" class="form-add">
      <label class="label-control" for="T_name">ປະເພດສິນຄ້າ</label>
      <input type="text" name="T_name" class="form-control">
      <label class="label-control" for="Note">ໜາຍເຫດ</label>
      <input type="text" name="Note" class="form-control">
      <div class="form-group mt-2">
      <button type="submit" name="submit" class="btn btn-outline-success"><i class="fa-solid fa-floppy-disk"></i> ບັນທືກ</button>
      <button type="reset" class="btn btn-outline-danger"><i class="fa-solid fa-trash"></i> ລ້າງຂໍ້ມູນ</button>
      <a href="inserttype.php" class="btn btn-outline-primary"><i class="fa-solid fa-rotate-left"></i> ກັບຄືນ</a>
      
      </div>
    </form>
    <?php } ?>
    


    <!-- ຟອນຄົ້ນຫາຂໍ້ມູນ -->
      <?php if (isset($_GET['search'])) { ?>

        <?php echo "<script>
        const Toast = Swal.mixin({
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 1500,
          timerProgressBar: true,
          didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
          }
        })
        
        Toast.fire({
          icon: 'success',
          title: 'ເຂົ້າສູ່ໜ້າຄົ້ນຫາຂໍ້ມູນແລ້ວ'
        })
        </script>" ?>

        <form action="search.php" method="post" class="form-search">
        <label for="">ຄົ້ນຫາປະເພດສິນຄ້າ</label>
        <input type="text" name="select" class="form-control">
        <button type="submit" name="search" class="btn btn-outline-primary mt-2"><i class="fa-solid fa-magnifying-glass"></i> ຄົ້ນຫາ</button>
        <a href="inserttype.php" class="btn btn-outline-primary mt-2"><i class="fa-solid fa-rotate-left"></i> ກັບຄືນ</a>
      </form>
        <?php } ?>
        </div>
        </div>
        </div>
  

<script src="../js/sidebars.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>
</html>