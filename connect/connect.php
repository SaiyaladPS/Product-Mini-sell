<?php
    $server = "localhost";
    $username = "root";
    $password = "96778932";
    $dbname = "mydb";

    $conn = mysqli_connect($server,$username,$password,$dbname);

    if (!$conn) {
        die("ເກິດຂໍ້ຜິດພາດ") . mysqli_connect_error();
    }
?>