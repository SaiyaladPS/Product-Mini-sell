<?php
    session_start();
    include('../../connect/connect.php');

// ເຊັກການເຂົ້າເຖິງໜ້ານີ້
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


    $sql = "SELECT * FROM receive INNER JOIN type ON receive.Type_T_id = type.T_id INNER JOIN unit ON receive.unit_u_id = unit.u_id WHERE r_date = curdate() ORDER BY receive.r_id DESC";
    $query = mysqli_query($conn,$sql);
    $count = mysqli_num_rows($query);

    // ຈຳນວນເພິ່ມເຂົ້າມາທັ້ງໝົດ
    $curdate_sql = "SELECT * FROM receive,type WHERE receive.Type_T_id = type.T_id";
    $curdate_query = mysqli_query($conn,$curdate_sql);
    $curdate_count = mysqli_num_rows($curdate_query);

    // ຊອກຫາ ຜົນລວ່ມສະເພາະວັນນີ້
    $select_receive_sum_sql = "SELECT SUM(r_purchase) as sum_purchase, SUM(r_selling) as sum_selling ,SUM(r_purchase*r_qty) as sum_purchase_row,
    SUM(r_selling*r_qty) as sum_selling_sum,SUM(r_selling*r_qty)-SUM(r_purchase*r_qty) as sum_selling_purchase FROM receive WHERE r_date = curdate()";
    $select_receive_sum_query = mysqli_query($conn,$select_receive_sum_sql);
    $select_receive_sum_row = mysqli_fetch_assoc($select_receive_sum_query);

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
            <li><a href="receive.php" class="link-dark d-inline-flex text-decoration-none rounded bg-primary">ເພິ່ມສິນຄ້ານຳເຂົ້າ</a></li>
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
           <?php echo $curdate_count ?>
          </span>
          </div>
          <div class="col-sm-4">
            <p class="text-center fs-7 mt-1">ຈຳນວນລາຍການເພິ່ມເຂົ້າວັນນີ້</p>
          <span class="border border-primary fs-5" style="display:flex; justify-content:center">
          <?php echo $count ?>
          </span>
          </div>
          <div class="col-sm-4">
            <p class="text-center fs-7 mt-1">ລວ່ມລາຄາຊື້ທັ້ງໝົດ/ອັນ</p>
          <span class="border border-primary fs-5" style="display:flex; justify-content:center">
           <?php echo number_format($select_receive_sum_row['sum_purchase']) . " ກີບ" ?>
          </span>
          </div>
          </div>
                  <div class="row">
                  <div class="col-sm-4">
            <p class="text-center fs-7 mt-1">ລວ່ມລາຄາຂາຍທັ້ງໝົດ/ອັນ</p>
          <span class="border border-primary fs-5" style="display:flex; justify-content:center">
          <?php echo number_format($select_receive_sum_row['sum_selling']) . " ກີບ"  ?>
            
          </span>
          </div>
                  <div class="col-sm-4">
            <p class="text-center fs-7 mt-1">ລວ່ມລາຄາຊື້ທັ້ງໝົດ</p>
            
          <span class="border border-primary fs-5" style="display:flex; justify-content:center">
           <?php echo number_format($select_receive_sum_row['sum_purchase_row']) . " ກີບ" ; ?>
          </span>
          </div>
                  <div class="col-sm-4">
            <p class="text-center fs-7 mt-1">ລວ່ມລາຄາຂາຍທັ້ງໝົດ</p>
          <span class="border border-primary fs-5" style="display:flex; justify-content:center">
          <?php echo number_format($select_receive_sum_row['sum_selling_sum']) . " ກີບ" ; ?>
          </span>
          </div>
                  <div class="col-sm-4">
            <p class="text-center fs-7 mt-1">ກຳໄລທັ້ງໝົດທີ່ຄວນໄດ້</p>
          <span class="border border-primary fs-5" style="display:flex; justify-content:center">
           <?php echo number_format($select_receive_sum_row['sum_selling_purchase']) . " ກີບ"  ?>
          </span>
          </div>
                  </div>

                  <!-- ຕົວແຈ້ງເຕືອນ -->
                  <?php if (isset($_SESSION['error'])) { ?>
       
       <?php echo $_SESSION['error'];
       unset($_SESSION['error']);
        ?>

   <?php } ?>
<?php if (isset($_SESSION['success'])) { ?>

       <?php echo $_SESSION['success'] ;
       unset($_SESSION['success']);
       ?>
 
   <?php } ?>


                  <a href="receive.php?add='1'" class="btn btn-outline-primary"><i class="fa-solid fa-square-plus"></i> ເພິ່ມ</a>
                <!-- ນັບຈຳນວນຂໍ້ມູນຖ້າມີໃຫ້ສະແດງ -->
                <?php if ($count == 0) { ?>
                    <div class="alert alert-danger" role="alert" style="margin-top: 200px;">
                        <h3 class="text-center">ຂໍ້ມູນວ່າງເປົ່າ</h3>
                        </div>
                    <?php } else { ?>

                        

                        <table class="table table-striped table-hover" style="font-size: 12px;">
                            <thead>
                                <tr>
                                    <th>ລຳດັບທີ່</th>
                                    <th>ລະຫັດການນຳເຂົ້າ</th>
                                    <th>ຊື່ສິນຄ້ານຳເຂົ້າ</th>
                                    <th>ລາຄານຳເຂົ້າ</th>
                                    <th>ລາຄາຂາຍອອກ</th>
                                    <th>ປະເພດສິນຄ້າ</th>
                                    <th>ຈຳນວນນຳເຂົ້າ</th>
                                    <th>ຫົວໜວ່ຍ</th>
                                    <th>ວັນທີ່ນຳເຂົ້າ</th>
                                    <th>ຊົ່ວໂມງນຳເຂົ້າ</th>
                                    <th>ໜາຍເຫດ</th>
                                    <th>ລົບ</th>
                                    </tr>
                            </thead>
                            <tbody>
                                <?php while($row = mysqli_fetch_assoc($query)) { ?>
                                    <tr><td><?php echo $number++ ?></td>
                                        <td><?php echo $row['r_id']?></td>
                                        <td><?php echo $row['r_name']?></td>
                                        <td><?php echo number_format($row['r_purchase']) . " ກີບ"?></td>
                                        <td><?php echo number_format($row['r_selling']) . " ກີບ"?></td>
                                        <td><?php echo $row['T_name']?></td>
                                        <td><?php echo $row['r_qty']?></td>
                                        <td><?php echo $row['u_name']?></td>
                                        <td><?php echo $row['r_date']?></td>
                                        <td><?php echo $row['r_time']?></td>
                                        <td><?php echo $row['Note']?></td>
                                        <td><a href="receive_db.php?delete=<?php echo $row['r_id'] ?>&delete_name=<?php echo $row['r_name'] ?>" class="btn btn-outline-danger" style="font-size: 12px;"><i class="fa-solid fa-trash"></i> ລົບ</a></td>
                                       
                                    </tr>
                                    <?php } ?>
                                    
                            </tbody>
                        </table>
                        <?php } ?>
            </div>


        
                <!-- ຟອນບັນທືກຂໍ້ມູນການນຳເຂົ້າ -->      
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
                              
              <form action="receive_db.php" method="post" class="form-add">
    
                <label for="">ລະຫັດສິນຄ້າ</label>
                <input type="text" name="g_id" class="form-control">
                
                <label for="">ຈຳນວນນຳເຂົ້າ</label>
                <input type="number" name="r_qty" class="form-control">

                
                <label for="">ໜາຍເຫດ</label>
                <input type="text" name="Note" class="form-control">
                <div class="form-grop mt-2">
                <button type="submit" name="submit" class="btn btn-outline-primary"><i class="fa-solid fa-square-plus"></i> ນຳເຂົ້າ</button>
                <button type="reset"  class="btn btn-outline-danger"><i class="fa-solid fa-trash"></i> ລ້າງຂໍ້ມູນ</button>
                <a href="receive.php" class="btn btn-outline-success"><i class="fa-solid fa-rotate-left"></i> ກັບຄືນ</a>
                </div>
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