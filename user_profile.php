<!DOCTYPE html>
<?php
session_start();
include("includes/header.php");

if(!isset($_SESSION['user_email'])){
	header("location: index.php");
}
?>
<html>
<head>
	<title>Find people</title>
	<meta charset="utf-8">
 	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<link rel="stylesheet" type="text/css" href="style/home_style2.css">
</head>

<style>

    #cover-img{
		height: 400px;
		width: 100%;
	}
    #profile-img{
		position: absolute;
		top: 160px;
		left: 40px;
	}
	#update_profile{
		position: relative;
		top: -33px;
		cursor: pointer;
		left: 93px;
		border-radius: 4px;
		background-color: rgba(0,0,0,0.1);
		transform: translate(-50%, -50%);
	}

    #update_profile:hover{
        transition: 0.7s;
    }

	#button_profile{
		position: absolute;
		top: 82%;
		left: 50%;
		cursor: pointer;
        background-color: #04AA6D;
		transform: translate(-50%, -50%);
	}

    #own_posts {
        border: 2px solid #e6e6e6;
        width: 100%;
    }

    #own_posts .row {
        margin-left: 20px;
    }

    #post_image {
        height: 300px;
        width: 100px;
    }

</style>

<body>
    
    <?php
    
        if(isset($_GET['u_id'])) {
            $u_id = $_GET['u_id'];
        }
        if($u_id < 0 || $u_id == "") {
            echo "<script>window.open('home.php', '_self')</script>";
        }
        else {
    
            ?>

            <div class="col-sm-12">
                <?php
                
                    if(isset($_GET['u_id'])) {
                        global $con;
                        $user_id = $_GET['u_id'];
                        $select = "select * from users2 where user_id='$user_id'";
                        $run = mysqli_query($con, $select);
                        $row = mysqli_fetch_array($run);

                        $name = $row['user_name'];
                    }

                ?>

                <?php
                
                    if(isset($_GET['u_id'])) {
                        global $con;

                        $user_id = $_GET['u_id'];
                        $select = "select * from users2 where user_id='$user_id'";
                        $run = mysqli_query($con, $select);
                        $row = mysqli_fetch_array($run);

                        $id = $row['user_id'];
                        $image = $row['user_image'];
                        $name = $row['user_name'];
                        $f_name = $row['f_name'];
                        $l_name = $row['l_name'];
                        $describe_user = $row['describe_user'];
                        $country = $row['user_country'];
                        $gender = $row['user_gender'];
                        $register_date = $row['user_reg_date'];

                        echo "
                            <div class='row'>
                                <div class='col-sm-1'>
                                </div>
                                <center>
                                    <div style='background-color:#e6e6e6;' class='col-sm-3'>
                                        <h2Information about></h2>
                                        <img src='users/$image' height='150' width='150' class='img-circle'>
                                        <br><br>
                                        <ul>
                                            <li class='list-group-item' title='Username'><strong>$f_name $l_name</strong></li>
                                            <li class='list-group-item' title='User Status'><strong>$describe_user</strong></li>
                                            <li class='list-group-item' title='Gender'><strong>$gender</strong></li>
                                            <li class='list-group-item' title='Country'><strong>$user_country</strong></li>
                                            <li class='list-group-item' title='User Registration Date'><strong>$register_date</strong></li>
                                        </ul>
                                    
                            ";
                            $user = $_SESSION['user_email'];
                            $get_user = "select * from users2 where user_email='$user'";
                            $run_user = mysqli_query($con, $get_user);
                            $row = mysqli_fetch_array($run_user);

                            $userown_id = $row['user_id'];

                            if($user_id == $userown_id) {
                                echo "<a href='edit_profile.php?u_id=$userown_id' class='btn btn-success'/>Edit Profile</a><br><br><br>";
                            }
                            echo "
                                </div>
                                </center>
                            ";
                    }
        
                ?>
                <div class="col-sm-8">
                    <center><h1><strong><?php echo "$f_name $l_name"?></strong>'s Posts</h1></center>
                    <?php
                        global $con;

                        if(isset($_GET['u_id'])) {
                            $u_id = $_GET['u_id'];
                        }

                        $get_posts = "select * from posts2 where user_id='$u_id' order by 1 desc limit 5";

                        $run_posts = mysqli_query($con, $get_posts);
                        
                        while($row_posts = mysqli_fetch_array($run_posts)) {
                            $post_id = $row_posts['post_id'];
                            $user_id = $row_posts['user_id'];
                            $content = $row_posts['post_content'];
                            $upload_image = $row_posts['upload_image'];
                            $post_date = $row_posts['post_date'];

                            $user = "select * from users2 where user_id='$user_id' and posts='yes'";
                            $run_user = mysqli_query($con, $user);
                            $row_user = mysqli_fetch_array($run_user);

                            $user_name = $row_user['user_name'];
                            $f_name = $row_user['f_name'];
                            $l_name = $row_user['l_name'];
                            $user_image = $row_user['user_image'];

                            if($content == "No" && strlen($upload_image) >= 1) {
                                echo "
                                    <div id='own_posts'>
                                        <div class='row'>
                                            <div class='col-sm-2'>
                                                <p><img src='users/$user_image' class='img-circle' width='100px' height='100px'></p>
                                            </div>
                                            <div class='col-sm-6'>
                                                <h3><a style='text-decoration:none;cursor:pointer;color:#3897f0;' href='user_profile.php?u_id=$user_id'>$user_name</a></h3>
                                                <h4><small style='color:black;'>Updated post on <strong>$post_date</strong></small></h4>
                                            </div>
                                            <div class='col-sm-4'>
                                            </div>
                                            <div class='row'>
                                                <div class='col-sm-12'>
                                                    <img id='post-img' src='imagepost/$upload_image' style='heoght:350px;'>
                                                </div>
                                            </div><br>
                                        </div><br><br>
                                ";
                            }
                            else if(strlen($content) >= 1 && strlen($upload_image) >= 1) {
                                echo"
                                
                                <div id='own_posts'>
                                    <div class='row'>
                                        <div class='col-sm-2'>
                                            <p><img src='users/$user_image' class='img-circle' width='100px' height='100px'></p>
                                        </div>
                                        <div class='col-sm-6'>
                                            <h3>
                                                <a style='text-decoration: none; cursor: pointer; color: #3897f80;' href='profile.php?u_id=$user_id'>$user_name</a>
                                            </h3>
                                            <h4><small style='color: black;'>Updated a post on <strong>$post_date</strong></small></h4>
                                        </div>
                                        <div class='col-sm-4'>
                                        </div>
                                    </div>
                                    <div class='row'>
                                        <div class='col-sm-12'>
                                            <p>$content</p>
                                            <img id='post-img' src='imagepost/$upload_image' style='height:350px;'>
                                        </div>
                                    </div><br>
                                    
    
                                </div><br><br>
        
                                ";
                            }
                            else {
                                echo"
                                
                                <div id='own_posts'>
                                    <div class='row'>
                                        <div class='col-sm-2'>
                                            <p><img src='users/$user_image' class='img-circle' width='100px' height='100px'></p>
                                        </div>
                                        <div class='col-sm-6'>
                                            <h3>
                                                <a style='text-decoration: none; cursor: pointer; color: #3897f80;' href='profile.php?u_id=$user_id'>$user_name</a>
                                            </h3>
                                            <h4><small style='color: black;'>Updated a post on <strong>$post_date</strong></small></h4>
                                        </div>
                                        <div class='col-sm-4'>
                                        </div>
                                    </div>
                                    <div class='row'>
                                        <div class='col-sm-12'>
                                            <p>$content</p>
                                        </div>
                                    </div><br>
                                    
                                </div><br><br>
        
                                ";
                            }
                            
                        }

                    ?>
                </div>
        </div>
    </div>
    <?php 
        }
    ?>
</body>
</html>