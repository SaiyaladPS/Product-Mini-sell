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

      // ດືງຂໍ້ມູນຕາຕະລາງປະເພດອາຫານ
      $sql = "SELECT * FROM goods INNER JOIN type ON goods.Type_T_id = type.T_id INNER JOIN unit ON unit.u_id = goods.unit_u_id";
      $query = mysqli_query($conn,$sql);
      $count = mysqli_num_rows($query);


      // ຈຳນວນເພິ່ມເຂົ້າວັນໜີ
      $count_curdate_sql = "SELECT * FROM goods,type WHERE goods.Type_T_id = type.T_id AND g_date = curdate() ";
      $count_curdate_query = mysqli_query($conn,$count_curdate_sql);

      $count_row = mysqli_num_rows($count_curdate_query);

      // ລ່ວມຄາລາທັ້ງໝົດ
      $count_purchase_sql = "SELECT SUM(g_purchase),SUM(g_selling) ,SUM(g_purchase*g_qty) as Total, SUM(g_selling*g_qty) as Total_g_selling,
       SUM(g_qty*g_selling)-SUM(g_qty*g_purchase) as Total_g_snadp FROM goods";
      $count_purchase_query = mysqli_query($conn,$count_purchase_sql);
      $count_purchase_row = mysqli_fetch_assoc($count_purchase_query);



    //   ແກ້ໄຂຂໍ້ມູນ
    if (isset($_GET['goods_edit'])) {
        $goods_edit = $_GET['goods_edit'];
        $type_edit_id = $_GET['type_edit'];
        $unit_u_id = $_GET['unit_u_id'];

            $edti_sql = "SELECT * FROM goods WHERE g_id = '$goods_edit' ";
            $edti_query = mysqli_query($conn,$edti_sql);
            $edit_row = mysqli_fetch_assoc($edti_query);
            // ຊອກຫາປະເພດສິນຄ້າ
                            $select_type_sql = "SELECT * FROM type WHERE T_id = $type_edit_id";
                            $select_type_query = mysqli_query($conn,$select_type_sql); 
        
                            
        
                            $select_type_sql2 = "SELECT * FROM type";
                            $select_type_query2 = mysqli_query($conn,$select_type_sql2);


                            $edit_unit_sql = "SELECT * FROM unit WHERE u_id = '$unit_u_id' ";
                            $edit_unit_query = mysqli_query($conn,$edit_unit_sql);
                            $edit_unit_sql2 = "SELECT * FROM unit";
                            $edit_unit_query2 = mysqli_query($conn,$edit_unit_sql2);
    }

    $number = 1;


            
                    

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
    <link rel="stylesheet" href="../../css/alsert_from.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <style>
        * {
            font-family: saysettha ot;
        }
    </style>
</head>
<body>
    

       <div class="container-fluid">

      <?php require 'nav/nav.php' ?>



        <div class="col-sm-10 mt-2">

                  <a href="goods.php?add='1'" class="btn btn-outline-primary"><i class="fa-solid fa-square-plus"></i> ເພິ່ມ</a>
                  
                  <!-- ນັບຈຳນວນໃນຖານຂໍ້ມູນຖ້າມີໃນສະແດງ ຖ້າບໍ່ມີໃຫ້ສະແດງວ່າ ຂໍ້ມູນວ່າງເປົ່າ -->
                  <?php if ($count == 0) { ?>
                    <div class="alert alert-danger" role="alert" style="margin-top: 200px;">
                      <h3 class="text-center">ຂໍ້ມູນວ່າງເປົ່າ</h3>
                    </div>
                    <?php } else { ?>
                      
                      <a href="goods.php?search='1'" class="btn btn-outline-primary"><i class="fa-solid fa-magnifying-glass"></i> ຄົ້ນຫາດວ້ຍຊື່</a>
                      <a href="goods.php?search_id='1'" class="btn btn-outline-success"><i class="fa-solid fa-barcode"></i> ຄົ້ນຫາດວ້ຍບາໂຄດ</a>
                       <table class="table table-striped table-hover" style="font-size:12px ;">
                            <thead>
                                <tr>
                                  <th>ລຳດັບທີ່</th>
                                    <th>ລະຫັດສິນຄ້າ</th>
                                    <th>ຊື່ສິນຄ້າ</th>
                                    <th>ລາຄາຊື່ເຂົ້າ</th>
                                    <th>ລາຄາຂາຍ</th>
                                    <th>ຈຳນວນ</th>
                                    <th>ຫົວໜວ່ຍ</th>
                                    <th>ຈຳນວນ/ຍ່ອຍ</th>
                                    <th>ວັນທີ່ຮັບເຂົ້າ</th>
                                    <th>ປະເພດສິນຄ້າ</th>
                                    <th>ແຍກຂ້າຍ</th>
                                    <th>ລົບຂໍ້ມູນ</th>
                                    <th>ແກ້ໄຂ</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while($row = mysqli_fetch_assoc($query)) { ?>
                                    <tr>
                                      <td><?php echo $number++ ?></td>
                                        <td><?php echo $row['g_id'] ?></td>
                                        <td><?php echo $row['g_name'] ?></td>
                                        <td><?php echo number_format($row['g_purchase']) . " ກີບ" ?></td>
                                        <td><?php echo number_format($row['g_selling']) . " ກີບ" ?></td>
                                        <td><?php echo $row['g_qty'] ?></td>
                                        <td><?php echo $row['u_name']?></td>
                                        <td><?php echo $row['g_sub'] ?></td>
                                        <td><?php echo $row['g_date'] ?></td>
                                        <td><?php echo $row['T_name'] ?></td>
                                        <td><a href="goods.php?g_sub=<?php echo $row['g_id']?> " class="btn btn-outline-warning" style="font-size: 12px;"><i class="fa-solid fa-people-arrows"></i> ແຍກຍ່ອຍ</a></td>
                                        <td><a href="goods_db.php?goods_delete=<?php echo $row['g_id']; ?>&delete_g_name=<?php echo $row['g_name']?>" class="btn btn-outline-danger" " style="font-size: 12px;""><i class="fa-solid fa-trash"></i> ລົບ</a></td>
                                        <td><a href="goods.php?goods_edit=<?php echo $row['g_id']?>&type_edit=<?php echo $row['T_id']?>&unit_u_id=<?php echo $row['u_id'] ?>" class="btn btn-outline-primary" style="font-size: 12px;"><i class="fa-solid fa-pen-to-square"></i> ແກ້ໄຂ</a></td>
                                    </tr>
                                    <?php } ?>
                            </tbody>
                       </table>

                    <?php } ?>
        </div>



          <!-- ຖ້າມີການຮັບຄ່າຈາກປຸ່ມແກ້ໄຂໃນສະແດງ -->
              <?php if (isset($_GET['goods_edit'])) { ?>
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
          title: 'ເຂົ້າສູ່ໜ້າແກ້ໄຂຂໍ້ມູນແລ້ວ'
        })
        </script>" ?>

                <!-- ແບບຟອນແກ້ໄຂຂໍ້ມູນໃນຖານຂໍ້ມູນ -->
                <form action="goods_db.php" method="post" class="form-edit">
                <input type="hidden" name="edit_g_id" class="form-control" value="<?php echo $edit_row['g_id'] ?>">
                <label for="g_name">ຊື່ສິນຄ້າ</label>
                <input type="text" name="edit_g_name" class="form-control" value="<?php echo $edit_row['g_name'] ?>">
                <label for="g_purchase">ລາຄາຊື້</label>
                <input type="text" name="edit_g_purchase" class="form-control" value="<?php echo $edit_row['g_purchase']?>">
                <label for="g_selling">ລາຄາຂາຍອອກ</label>
                <input type="text" name="edit_g_selling" class="form-control" value="<?php echo $edit_row['g_selling']?>">
                <label for="">ຫົວໜວ່ຍ</label>

                <!-- ແກ້ໄຂ້ຫົວໜ່ວຍເພິ່ມເຕິມ -->
                <select name="edit_u_id" id="" class="form-control">
                  
                  <?php while($edit_unit_row = mysqli_fetch_assoc($edit_unit_query)) { ?>

                        <option value="<?php echo $edit_unit_row['u_id'] ?>"><?php echo $edit_unit_row['u_name'] ?></option>

                    <?php } ?>

                    <?php while($edit_unit_row2 = mysqli_fetch_assoc($edit_unit_query2)) { ?>
                      <?php if ($edit_unit_row2['u_id'] != $unit_u_id) { ?>
                                        <option value="<?php echo $edit_unit_row2['u_id']?>"><?php echo $edit_unit_row2['u_name'] ?></option>
                                        <?php } ?>
                            <?php } ?>

                </select>
               <?php  ?>
                <!-- ສະແດງປະເພດສິນຄ້າໃນໜ້າການແກ້ໄຂຂໍ້ມູນ -->
                <label for="">ປະເພດສິນຄ້າ</label>
                <select name="edit_Type_T_id" id="" class="form-control">

                  <?php while($select_type_row = mysqli_fetch_assoc($select_type_query)) { ?>
                    
                            <option value="<?php echo $select_type_row['T_id']?>"><?php echo $select_type_row['T_name'] ?></option>
                       
                   <?php } ?>

                   <?php while($select_type_row2 = mysqli_fetch_assoc($select_type_query2)) { ?>

                          <?php if ($type_edit_id != $select_type_row2['T_id']) { ?>
                            <option value="<?php echo $select_type_row2['T_id'] ?>"><?php echo $select_type_row2['T_name'] ?></option>
                            <?php } ?>

                    <?php } ?>
                   

                    
                    
                </select>
                <label for="Note">ໜາຍເຫດ</label>
                <input type="text" name="edit_Note" class="form-control" value="<?php echo $edit_row['Note'] ?>">
                <div class="form-grop mt-2">
                    <button type="submit" name="edit" class="btn btn-outline-primary"><i class="fa-solid fa-pen-to-square"></i> ແກ້ໄຂ</button>
                    <button type="reset" class="btn btn-outline-danger"><i class="fa-solid fa-trash"></i> ລ້າງຂໍ້ມູນ</button>
                    <a href="goods.php" class="btn btn-outline-success"><i class="fa-solid fa-rotate-left"></i> ກັບຄືນ</a>
                </div>
            </form>

                      <!-- ຖ້າບໍ່ມີການຮັບຄ່າຈາກ ປຸ່ມແກ້ໄຂຂໍ້ມູນໃຫ້ສະແດງ -->
                <?php } ?>
                    <!-- ຕົວແຈ້ງເຕືອນຂໍ້ຄວາມ error -->
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
                        <!-- ຟອນບັນທຶກຂໍ້ມູນ -->
            <form action="goods_db.php" method="post" class="form-add">
                <label for="g_id">ລະຫັດສິນຄ້າ</label>
                <input type="text" name="g_id" class="form-control">
                <label for="g_name">ຊື່ສິນຄ້າ</label>
                <input type="text" name="g_name" class="form-control">
                <label for="g_purchase">ລາຄາຊື້</label>
                <input type="number" name="g_purchase" class="form-control">
                <label for="g_selling">ລາຄາຂາຍ</label>
                <input type="number" name="g_selling" class="form-control">
                <label for="">ຫົວໜວ່ຍ</label>

                        <?php
                            $select_unit_sql = "SELECT * FROM unit";
                            $select_unit_query = mysqli_query($conn,$select_unit_sql);
                        ?>

                <select name="unit_u_id" id="" class="form-control">
                  <option value=""><--ເລືອກຫົວໜ້ອຍສິນຄ້າ--></option>
                  <?php while($select_unit_row = mysqli_fetch_assoc($select_unit_query)) { ?>
                      <option value="<?php echo $select_unit_row['u_id']?>"><?php echo $select_unit_row['u_name']?></option>

                    <?php } ?>
                  
                </select>
                <label for="">ຈຳນວນຍ່ອຍ</label>
                <input type="number" name="g_sub" id="" class="form-control">
               
                <label for="">ປະເພດສິນຄ້າ</label>
                <select name="Type_T_id" id="" class="form-control">
                    

                    <?php
                    $select_type_sql1 = "SELECT * FROM type";
                    $select_type_query1 = mysqli_query($conn,$select_type_sql1); 
                    ?>
                    <!-- ສະແດງປະເພດສິນຄ້າ -->
                    <option value=""><--ເລືອກປະເພດສິນຄ້າ--></option>
                    <?php while($type_t_name = mysqli_fetch_assoc($select_type_query1)) {?>
                      <option value="<?php echo $type_t_name['T_id']?>"><?php echo $type_t_name['T_name'] ?></option>
                        <?php } ?>
                    
                </select>
                <label for="Note">ໜາຍເຫດ</label>
                <input type="text" name="Note" class="form-control">
                <div class="form-grop mt-2">
                    <button type="submit" name="submit" class="btn btn-outline-primary"><i class="fa-solid fa-floppy-disk"></i> ບັນທືກຂໍ້ມູນ</button>
                    <button type="reset" class="btn btn-outline-danger"><i class="fa-solid fa-trash"></i> ລ້າງຂໍ້ມູນ</button>
                    <a href="goods.php" class="btn btn-outline-success"><i class="fa-solid fa-rotate-left"></i> ກັບຄືນ</a>
                </div>
            </form>
                        
                      <?php } ?>

                       

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
                             <!-- ຟອນຄົ້ນຫາສິນຄ້າ -->
                    <form action="select_goods.php" method="post" class="form-search">
                      <label for="g_name">ຄົ້ນຫາຊື່ສິນຄ້າ</label>
                      <input type="text" name="select_name" class="form-control">
                      <button type="submit" name="select" class="btn btn-outline-primary"><i class="fa-solid fa-magnifying-glass"></i> ຄົ້ນຫາຊື່</button>
                      <a href="goods.php" class="btn btn-outline-success"><i class="fa-solid fa-rotate-left"></i> ກັບຄືນ</a>
                    </form>

                      
                        <?php } ?>

                      <?php if (isset($_GET['search_id'])) { ?>
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

                        <!-- ຟອນຄົ້ນຫາລະຫັດສິນຄ້າ -->

                        <form action="select_goods.php" method="post" class="form-search">
                          <label for="">ຄົ້ນຫາຜ່ານບາໂຄດ</label>
                          <input type="text" name="select_id" class="form-control">
                          <button type="submit" name="select_id_btn" class="btn btn-outline-info"><i class="fa-solid fa-barcode"></i> ຄົ້ນຫາດວ້ຍບາໂຄດ</button>
                           <a href="goods.php" class="btn btn-outline-success"><i class="fa-solid fa-rotate-left"></i> ກັບຄືນ</a>
                        </form>
                        <?php } ?>

                          <?php if (isset($_GET['g_sub'])) { ?>
                            <?php $g_sub = $_GET['g_sub']; ?>
                              <form action="../sub/sub_db.php" method="post" class="form-add">
                                <input type="hidden" name="sub_g_id" value="<?php echo $g_sub ?>">
                                <label for="">ລະຫັດສິນຄ້າຍ່ອຍ</label>
                                <input type="text" name="sub_id" id="" class="form-control">
                                <label for="">ລາຄາຂ້າຍຍ່ອຍ</label>
                                <input type="number" name="sub_selling" id="" class="form-control">
                                <label for="">ຈຳນວນແຍກ</label>
                                <input type="number" name="sub_qty" id="" class="form-control">
                                <label for="">ຫົວໜ່ວຍແຍກ</label>
                                <select name="unit_name" id="" class="form-control">
                                  <option value=""><--ເລືອກຫົວໜ່ວຍ--></option>
                                  <?php $sql_select_unit = "SELECT * FROM unit";
                                  $query_select_unit = mysqli_query($conn,$sql_select_unit) ?>
                                  <?php while($value = mysqli_fetch_assoc($query_select_unit)) { ?>
                                              <option value="<?php echo $value['u_id'] ?>"><?php echo $value['u_name'] ?></option>                                    
                                    <?php } ?>
                                </select>
                                <input type="submit" name="sub" id="" value="ແຍກ" class="btn btn-outline-primary">
                                <input type="reset" value="ລ້າງຂໍ້ມູນ" class="btn btn-outline-danger">
                                <a href="goods.php" class="btn btn-outline-success">ກັບຄືນ</a>
                              </form>
                            <?php } ?>

        </div>

                      
       </div>





<script src="../../js/sidebars.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>
</html>