<?php 

 ob_start(); //output buffering start

 session_start();

 require "connection.php";

 if(isset($_SESSION['username']) && $_SESSION['userStatus'] == 1){

    include 'includes/templates/header.php';   ?>

    <?php include "includes/templates/navbar.php" ?>

<?php 

// now we will check from GET if GET = edit or GET = delete or its normal GET

$do='';

if(isset($_GET['do'])){

    $do=$_GET['do'];

}
else{

    $do='Manage';
    
}

if($do == "Manage"){ ?>

    <div class="content-wrapper">
        <div class="content">
        <h3 class="add-user-title mb-3 mt-lg-2 mt-4"><i class="fa fa-angle-right text-secondary"></i> Add User</h3>
            <div class="row">
                <div class="col-12">
                
            <?php
            
                /* if($_SERVER['REQUEST_METHOD']=='POST'){

                    $_SESSION['success'] = '';
                    $_SESSION['error'] = '';

                    //check if all fields is correct
                    $username = $_POST['username'];
                    $email = $_POST['email'];
                    $password = $_POST['password'];
                    $confirm_password = $_POST['confirm-password'];

                    //create an array to add errors
                    $errors = array();

                    //fill the $errors if error found
                    if(empty($username)){

                        $errors[]='Username Cant Be <strong>Empty</strong>';
    
                    }
    
                    if(empty($email)){
    
                        $errors[]='Email Cant Be <strong>Empty</strong>';
    
                    }

                    if(empty($password) && empty($confirm_password)){
    
                        $errors[]='Password Cant Be <strong>Empty</strong>';
    
                    }

                    if($password != $confirm_password){
                        $errors[]="Password doesn't  <strong>Match</strong>";
                    }

                    //if no error then insert the user
                    if(empty($errors)){

                        $query = "INSERT INTO users(username,password,email,userStatus,date) 
                        VALUES('$username', '$password', '$email' ,0 , now())";
                        $result = mysqli_query($con,$query);
                
                        if($result == 1){ //msg if inserted normally
                            
                            $_SESSION['success'] = 'user inserted successfully';
                            header("location:add-user.php");

                        }else{ // msg if error occured
                            
                            $_SESSION['error'] = "user insertion failed";
                            header("location:add-user.php");
                            
                        }


                    }else{  // display the errors

                        foreach($errors as $error){

                            echo "<div class='alert alert-danger'>";
                                echo $error;
                                echo "<button type='button' class='close' data-dismiss='alert' aria-label='Close'>";
                                    echo "<span aria-hidden='true'>&times;</span>";
                                echo "</button>";
                            echo "</div>";

                        }

                    }

                }    */         

            ?>

                    <?php

                        if(!empty($_SESSION['testErrors'])){

                            foreach($_SESSION['testErrors'] as $msg){
                                echo "<div class='alert alert-danger'>";
                                    echo $msg;
                                    echo "<button type='button' class='close' data-dismiss='alert' aria-label='Close'>";
                                        echo "<span aria-hidden='true'>&times;</span>";
                                    echo "</button>";
                                echo "</div>";
                            }

                            $_SESSION['testErrors'] = '';
                        }

                    ?>
                    <?php //print the session msg

                          if(isset($_SESSION['success']) && !empty($_SESSION['success'])){

                                echo "<div class='alert alert-success'>";
                                    echo $_SESSION['success'];
                                    echo "<button type='button' class='close' data-dismiss='alert' aria-label='Close'>";
                                        echo "<span aria-hidden='true'>&times;</span>";
                                    echo "</button>";
                                echo "</div>";

                                $_SESSION['success'] = '';
                          
                            }

                            if(isset($_SESSION['error']) && !empty($_SESSION['error'])){

                                echo "<div class='alert alert-danger'>";
                                    echo $_SESSION['error'];
                                    echo "<button type='button' class='close' data-dismiss='alert' aria-label='Close'>";
                                        echo "<span aria-hidden='true'>&times;</span>";
                                    echo "</button>";
                                echo "</div>";
                                
                                $_SESSION['error'] = '';

                            }
                    ?>

                <form class="form-horizontal" action="?do=Insert" method="POST" enctype="multipart/form-data">

                    <!-- start username field -->
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label label-left">User Name</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="username"   placeholder="Username">
                        </div>                        
                    </div>
                    <!-- end username field -->

                    <!-- start email field -->
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label label-left" >Email</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="email" placeholder="Email Must Be Valid">
                        </div>
                    </div>
                    <!-- end email field -->

                    <!-- start password field -->
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label label-left">Password</label>
                        <div class="col-sm-10">
                            <input type="password" class="form-control" name="password" placeholder="Password Must Be Hard">
                        </div>
                    </div>
                    <!-- end password field -->

                    <!-- start confirm-password field -->
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label label-left"  >Confirm Password</label>
                        <div class="col-sm-10">
                            <input type="password" class="form-control"  name="confirm-password" placeholder="Confirm Password">
                        </div>
                    </div>
                    <!-- end confirm-password field -->

                    <!-- start avatar field -->

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label label-left">User Profile</label>
                        <div class="col-sm-10">
                            <input type="file" name="profile_pic" class="form-control" placeholder="">
                        </div>
                    </div>

                    <!-- end avatar field -->

                    <!-- start add_user field -->
                    <div class="form-group row">
                        <div class="offset-md-2 col-sm-10 mt-3">
                            <input type="submit" name="add_user" value="Add User" class="btn btn-primary">
                        </div>
                    </div>
                    <!-- end add_user field -->

                    

                </form>
                </div>
            </div> <!-- end of row -->
        </div> <!-- end of container -->
    </div> <!-- end of content-wrapper -->

<?php }else if($do == "Insert"){ 

        if($_SERVER['REQUEST_METHOD']=='POST'){

            //prepare sessions
            $_SESSION['testErrors'] = array();
            $_SESSION['success'] = '';
            $_SESSION['error'] = '';

            //upload avatar variables

            $avatarName = $_FILES['profile_pic']['name'];
            $avatarSize = $_FILES['profile_pic']['size'];
            $avatarTmp  = $_FILES['profile_pic']['tmp_name'];
            $avatarType = $_FILES['profile_pic']['type'];
            
            //list of allowed file type to apload

            $avatarAllowedExtension = array("jpeg", "jpg", "png", "gif");

            //get avatar extension
            
            $avatarExtension = strtolower(end(explode('.', $avatarName)));

            //check if all fields is correct
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $confirm_password = $_POST['confirm-password'];

            //create an array to add errors
            $errors = array();

            //fill the $errors if error found
            if(empty($username)){

                $_SESSION['testErrors'][]='Username Cant Be <strong>Empty</strong>';

            }

            if(empty($email)){

                $_SESSION['testErrors'][]='Email Cant Be <strong>Empty</strong>';

            }

            if(empty($password) && empty($confirm_password)){

                $_SESSION['testErrors'][]='Password Cant Be <strong>Empty</strong>';

            }

            if($password != $confirm_password){
                $_SESSION['testErrors'][]="Password doesn't  <strong>Match</strong>";
            }

            if( ! empty($avatarName) && ! in_array($avatarExtension,$avatarAllowedExtension)){
               
                $_SESSION['testErrors'][]='<div class="alert alert-danger">This Extension of Image is Not  <strong>Allowed</strong></div>';
        
            }
        
            if($avatarSize > 4194304){
        
                $_SESSION['testErrors'][]='<div class="alert alert-danger">Avatar Can\'t Be Larger Than  <strong>4MB</strong></div>';  
        
            }

            //if no error then insert the user
            if(empty($_SESSION['testErrors'])){

                //add avatar and give it random name... the avatars uploaded are exists in admin\uploads\avatars
                $avatar = "";

                if( !empty($avatarName) ) {

                $avatar = rand(0,100000). "_" .$avatarName;

                move_uploaded_file($avatarTmp,"uploads\avatars\\". $avatar);

                }

                $query = "INSERT INTO users(username,password,email,userStatus,date,profile_pic) 
                VALUES('$username', '$password', '$email' ,0 , now(),'$avatar')";
                $result = mysqli_query($con,$query);

                if($result == 1){ //msg if inserted normally
                    
                    $_SESSION['success'] = 'user inserted successfully';
                    header("location:add-user.php");

                }else{ // msg if error occured
                    
                    $_SESSION['error'] = "user insertion failed";
                    header("location:add-user.php");
                    
                }

            }else{

                header("location: add-user.php");

            }

        }
}


?>

<?php  include 'includes/templates/footer.php';

}else{ //if user try directly to go to dashboard

        header("location: ../login.php");
        exit();
    }
   
 ob_end_flush(); //release the output

?>