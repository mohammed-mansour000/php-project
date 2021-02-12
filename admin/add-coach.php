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
        <h3 class="add-user-title mb-3 mt-lg-2 mt-4"><i class="fa fa-angle-right text-secondary"></i> Edit Coach</h3>    
            <div class="row">
                <div class="col-12">

                <?php

                        //print the form errors
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

                            <!------------------------------------------------------------------------>
                        <!-- you cant upload images without ( enctype="multipart/form-data" ) in the form -->
                             <!------------------------------------------------------------------------>

                        <!-- start username field -->

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label label-left">Username</label>
                            <div class="col-sm-10">
                                <input type="text" name="username" class="form-control"  placeholder="Username">
                            </div>
                        </div>

                        <!-- end username field -->

                          <!-- start full-name field -->

                          <div class="form-group row">
                            <label class="col-sm-2 col-form-label label-left">FullName</label>
                            <div class="col-sm-10">
                                <input type="text" name="full_name" class="form-control" placeholder="FullName">
                            </div>
                          </div>

                        <!-- end full-name field -->

                        <!-- start Email field -->

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label label-left">Email</label>
                            <div class="col-sm-10">
                                <input type="email" name="email"  class="form-control" placeholder="Email Must Be Valid">
                            </div>
                        </div>

                        <!-- end Email field -->

                        <!-- start Password field -->

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label label-left">Password</label>
                            <div class="col-sm-10">
                                <input type="password" name="password" class="form-control password" autocomplete="new-password" placeholder="Password Must Be Hard">
                            </div>
                        </div>

                        <!-- end Password field -->

                        <!-- start confirm-password field -->

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label label-left">Confirm Password</label>
                            <div class="col-sm-10">
                                <input type="password" class="form-control"  name="confirm-password" placeholder="Confirm Password">
                            </div>
                        </div>

                        <!-- end confirm-password field -->

                         <!-- start contact field -->

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label label-left">Coach Contact No.</label>
                            <div class="col-sm-10">
                                <input type="number" name="coach_contact"  class="form-control" placeholder="Enter Contact No.">
                            </div>
                        </div>

                        <!-- end contact field -->

                        <!-- start avatar field -->

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label label-left">Coach Profile</label>
                            <div class="col-sm-10">
                                <input type="file" name="profile_pic" class="form-control" placeholder="">
                            </div>
                        </div>

                        <!-- end avatar field -->

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label label-left">Coach Gender</label>
                            <div class="col-sm-10">
                                <select class="form-control" name="coach_gender">
                                    <option value="">--Please choose an option--</option>
                                    <option value="1">Male</option>
                                    <option value="2">Female</option>
                                </select>
                            </div>
                        </div>

                        <!-- start Save button -->

                        <div class="form-group row">
                            <div class="offset-md-2 col-sm-10 mt-3">
                                <input type="submit" value="Add Coach" class="btn btn-primary">
                            </div>
                        </div>

                        <!-- end Save button -->

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
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm-password'];
    $contact_no = $_POST['coach_contact'];
    $coach_gender = $_POST['coach_gender'];


    //fill the $errors if error found
    if(empty($username)){

        $_SESSION['testErrors'][]='Username Cant Be <strong>Empty</strong>';

    }

    if(empty($full_name)){

        $_SESSION['testErrors'][]='Name Cant Be <strong>Empty</strong>';

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

    if(empty($contact_no)){

        $_SESSION['testErrors'][]='Contact No. Cant Be <strong>Empty</strong>';

    }

    if( ! empty($avatarName) && ! in_array($avatarExtension,$avatarAllowedExtension)){
               
        $_SESSION['testErrors'][]='This Extension of Image is Not  <strong>Allowed</strong>';

    }

    if($avatarSize > 4194304){

        $_SESSION['testErrors'][]='Avatar Can\'t Be Larger Than  <strong>4MB</strong>';  

    }

    if(empty($coach_gender)){

        $_SESSION['testErrors'][]='Coach Gender Cant Be <strong>Empty</strong>';

    }

    //if no error then insert the user
    if(empty($_SESSION['testErrors'])){

        //add avatar and give it random name... the avatars uploaded are exists in admin\uploads\avatars
        $avatar = "";

        if( !empty($avatarName) ) {

        $avatar = rand(0,100000). "_" .$avatarName;

        move_uploaded_file($avatarTmp,"uploads\avatars\\". $avatar);

        }


        $query = "INSERT INTO users(username, full_name, email, password, date, user_gender, user_contact, profile_pic, userStatus) 
        VALUES('$username', '$full_name', '$email' , '$password' , now(), '$coach_gender', '$contact_no', '$avatar', 2)";
        $result = mysqli_query($con,$query);

        if($result == 1){ //msg if inserted normally
            
            $_SESSION['success'] = 'Coach Inserted Successfully';
            header("location:add-coach.php");

        }else{ // msg if error occured
            
            $_SESSION['error'] = "Coach Insertion Failed";
            header("location:add-coach.php");
            
        }

    }else{

        header("location: add-coach.php");

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