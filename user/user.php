<?php
        session_start();
        include('../connect/connect.php');

        if (!isset($_SESSION['login_user'])) {
            session_destroy();
            header("location: ../login/login.php");
        }

          

        $select_order_sql = "SELECT * FROM orderuser INNER JOIN type ON orderuser.Type_T_id = type.T_id INNER JOIN goods ON goods.g_id = orderuser.goods_g_id INNER JOIN unit ON goods.unit_u_id = unit.u_id WHERE ou_date = curdate() ORDER BY ou_id DESC";
        $select_order_query = mysqli_query($conn,$select_order_sql);
        $count = mysqli_num_rows($select_order_query); 

        $number = 1;

        $sum_orderuser_sql = "SELECT SUM(ou_selling) as ou_selling FROM orderuser";
        $sum_orderuser_query = mysqli_query($conn,$sum_orderuser_sql);
        $sum_orderuser_row = mysqli_fetch_assoc($sum_orderuser_query);


        if (isset($_SESSION['login_user']) && isset($_SESSION['login_user_password'])) {
            $userid = $_SESSION['login_user'];
          $password = $_SESSION['login_user_password'];
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css" integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="../css/print.css" media="print">
    <link rel="stylesheet" href="../css/sidebars.css">

 
    <style>
        * {
            font-family: saysettha ot;
        }
        form {
            display: flex;
            justify-content: center;
            align-items: center;
            
        }
        label{
            margin-left: 20px;
            
        }
    </style>
    <title>ການຂາຍສິນຄ້າ</title>
</head>
<body>
    
<div class="container-fluid">
<div class="row">
<div class="col-sm-12">
        <div class="row">
            <div class="col-sm-2">
            <p class="text-center fs-7 mt-1">ຈຳນວນລາຍການທັ້ງໝົດ</p>
          <span class="border border-primary fs-5" style="display:flex; justify-content:center">
            <?php echo $count ?>
          </span>
            </div>

            <div class="col-sm-2">
                <p class="text-center fs-7 mt-1">ລ່ວມລາຄາ</p>
                <span class="border border-primary fs-5" style="display:flex ; justify-content: center;">
                    <?php echo number_format($sum_orderuser_row['ou_selling']) . " ກີບ";?>

                </span>
            </div>

            
        </div>
    <h3 class="text-center mt-2">ຂໍ້ມູນການຂາຍວັນນີ້</h3>
     <!-- ຕົວແຈ້ງເຕືອນຂໍ້ຄວາມ error -->
     <?php if (isset($_SESSION['error'])) {
                             echo $_SESSION['error'];
                                unset($_SESSION['error']);
                            
                     } 
                    
                     if (isset($_SESSION['success'])) { 
                                 echo $_SESSION['success'];
                                    unset($_SESSION['success']);
                            
                         } ?>
                         <a href="../logout/logout.php?logout='0'" class="btn btn-outline-danger"><i class="fa-solid fa-power-off"></i> ອອກຈາກລະບົບ</a>

                         <div class="profile">
          <img src="../login/userlogin/img/<?php echo $row_porfile_name['img'] ?>">
        </div>
        <div class="fname"><?php echo $row_porfile_name['fname'] . " " . $row_porfile_name['lname'] ?></div>


        
    <form action="user_db.php" method="post">
              <label for="">ບາໂຄດ</label>
              <input type="text" name="g_id" class="form-control" style="width: 200px;">
              <label for="">ຈຳນວນ</label>
              <input type="number" name="ou_qty" id="" value="1" class="form-control" style="width: 50px;">
              <label for="">ໜາຍເຫດ</label>
              <input type="text" name="Note" class="form-control" style="width:200px;">
              <div class="form-grop mt-2">
                  <button type="submit" name="sell" class="btn btn-outline-success mx-2"><i class="fa-solid fa-bag-shopping"></i> ຂາຍ</button>
              </div>
          </form>
            
            <?php if ($count == 0) {?>
                <div class="alert alert-success" role="alert" style="margin-top: 200px;">
                        <h3 class="text-center">ຮັບອໍເດີໃຫມ່</h3>
                        </div>
        
        <?php } else { ?>
            <a href="user_db.php?sevs=<?php echo '1'?> " class="btn btn-outline-warning"><i class="fa-solid fa-window-restore"></i> ຮັບອໍເດີໃຫມ່</a>
            <button class="btn btn-outline-success" onclick="window.print()"><i class="fa-solid fa-building-circle-check"></i> ຮັບໃບບິນ</button>
                
                <!-- ປຸມການບັນໃບບິນ -->
                <table class="table table-striped table-hover" style="font-size: 12px; ">
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
                                    <td><?php echo $select_order_row['ou_name'] ?></td>
                                    <td><?php echo number_format($select_order_row['ou_selling']) . " ກີບ" ?></td>
                                    <td><?php echo $select_order_row['ou_qty'] ?></td>
                                    <td><?php echo $select_order_row['u_name'] ?></td>
                                    <td><?php echo $select_order_row['ou_date'] ?></td>
                                    <td><?php echo $select_order_row['ou_time'] ?></td>
                                    <td><?php echo $select_order_row['Note'] ?></td>
                                    <td><?php echo $select_order_row['T_name'] ?></td>
                                    <td><a href="user_db.php?delete=<?php echo $select_order_row['ou_id']?>&ou_qty=<?php echo $select_order_row['ou_qty'] ?>" class="btn btn-outline-danger" style="font-size: 12px"><i class="fa-solid fa-trash"></i> ລົບ</a></td>
                                   
                                    
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
