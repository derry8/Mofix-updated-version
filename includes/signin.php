<?php
    session_start();

    include "../config/db_connect.php";

    if(isset($_POST["login_btn"])) {
        $username = $_POST["username"];
        $password = $_POST["password"];

        $query = "SELECT * FROM `users` WHERE `username` = '$username' " or die("Query failed");
        $fetch = mysqli_query($connect, $query);

        if(mysqli_num_rows($fetch) > 0) {
            $row = mysqli_fetch_assoc($fetch);

            if(password_verify($password, $row["password"]) && $row["user_type"] === "normal") {
                $_SESSION["id"] = $row["id"];
                header("location: ../users/home.php");
            }elseif($row["user_type"] === "admin") {
                header("location: ../admin/admin.php");
            }else{
                $error_msg[] = "Incorrect Password or username";
                header("location: ../users/signup and login.php");
            }
        }
    }