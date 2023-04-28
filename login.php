<?php
session_start();
include("includes/connection.php");


    if(isset($_POST['login'])) {
        $email = htmlentities(mysqli_real_escape_string($con, $_POST['email']));
        $pass = htmlentities(mysqli_real_escape_string($con, $_POST['password']));
        
        //Retrieving Password from DB to verify with hash
        $select_pass = "select user_pass FROM users2 WHERE user_email = '$email'";
        $result = mysqli_query($con, $select_pass);
        $row = mysqli_fetch_assoc($result);
        $hashed_password = $row['user_pass'];

        if(password_verify($pass, $hashed_password)){
            echo "<script>alert('Password Correct')</script>"; //alert to confirm hash verified
        
        $select_users = "select * from users2 where user_email='$email' and user_pass='$hashed_password' and status='verified'"; 
        $query = mysqli_query($con, $select_users);
        $check_user = mysqli_num_rows($query);

        

        if($check_user == 1) {
            $_SESSION['user_email'] = $email;
            
            echo "<script>window.open('home.php', '_self')</script>";
        }
        
    }
    else {
        echo "<script>alert('Your Email or Password is incorrect')</script>";
    }
}
    


?>