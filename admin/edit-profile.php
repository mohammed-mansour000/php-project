<?php 

 ob_start(); //output buffering start

 session_start();

 $pageTitle='Edit Profile';

 if(isset($_SESSION['username']) && $_SESSION['userStatus'] == 1){

    include 'includes/templates/header.php';

    include "includes/templates/navbar.php"; ?>

<?php 

    require "connection.php";
    $id = $_SESSION['userID'];
    $query = "SELECT * FROM users WHERE id = '$id'";
    $result = mysqli_query($con,$query);
    $rows = mysqli_fetch_array($result);

?>

<div class="content-wrapper">
        <div class="content">
            <h3 class="add-user-title mb-3 mt-lg-2 mt-4"><i class="fa fa-angle-right text-secondary"></i> Edit Profile</h3>
            <div class="row">
                <div class="col-12">
                
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
                            echo "<div class='alert alert-info'>";
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

                <form class="" action="<?php echo "?do=Update"?>" method="POST" enctype="multipart/form-data">
                        
                    <!-- start username field -->
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label label-left">Username</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="username" value="<?php echo $rows['username'] ?>" >
                        </div>                        
                    </div>
                    <!-- end username field -->

                     <!-- start fullname field -->

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label label-left">Fullname</label>
                        <div class="col-sm-10">
                            <input type="text" name="full_name" class="form-control" value="<?php echo $rows['full_name'] ?>" placeholder="Fullname">
                        </div>
                    </div>

                    <!-- end fullname field -->

                    <!-- start email field -->

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label label-left" >Email</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="email" value="<?php echo $rows['email'] ?>">
                        </div>
                    </div>

                    <!-- end email field -->

                    <!-- start password field -->

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label label-left">Password</label>
                        <div class="col-sm-10">
                            <input type="password" class="form-control" name="password" value="<?php echo $rows['password'] ?>" >
                        </div>
                    </div>

                    <!-- end password field -->

                    <!-- start confirm-password field -->

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label label-left"  >Confirm Password</label>
                        <div class="col-sm-10">
                            <input type="password" class="form-control"  name="confirm-password" value="<?php echo $rows['password'] ?>" >
                        </div>
                    </div>

                    <!-- end confirm-password field -->

                    <!-- start contact field -->

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label label-left">Coach Contact No.</label>
                        <div class="col-sm-10">
                            <input type="number" name="user_contact"  class="form-control" value="<?php echo $rows['user_contact'] ?>" placeholder="Enter Contact No.">
                        </div>
                    </div>

                    <!-- end contact field -->

                    <!-- start old avatar -->

                    <input type="hidden"  name="old_avatar" value="<?php echo $rows['profile_pic']?>">

                    <!-- end old avatar -->

                    <!-- start avatar field -->

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label label-left">User Profile</label>
                        <div class="col-sm-10">
                            <input type="file" name="profile_pic" class="form-control" placeholder="">
                        </div>
                    </div>

                    <!-- end avatar field -->

                    <!-- start gender -->

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label label-left">Coach Gender</label>
                        <div class="col-sm-10">
                            <select class="form-control"  name="user_gender">
                                <option value="">--Please choose an option--</option>
                                <option value="1" <?php if($rows['user_gender']==1) echo "selected" ?>>Male</option>
                                <option value="2" <?php if($rows['user_gender']==2) echo "selected" ?>>Female</option>
                            </select>
                        </div>
                    </div>

                    <!-- end gender -->

                    <!-- start update field -->

                    <div class="form-group row">
                        <div class="offset-md-2 col-sm-10 mt-3">
                            <input type="submit" name="update_user" value="Update" class="btn btn-info">
                        </div>
                    </div>

                    <!-- end update field -->
                </form>
                </div>
            </div> <!-- end of row -->
        </div> <!-- end of contianer -->
    </div>  <!-- end of content-wrapper -->


<?php

if(isset($_GET['do']) && $_GET['do'] == 'Update'){

        //now if update button pressed 
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
        $contact_no = $_POST['user_contact'];
        $user_gender = $_POST['user_gender'];


        //fill the $errors if error found
        if(empty($username)){

            $_SESSION['testErrors'][]='Username Cant Be <strong>Empty</strong>';

        }

        if(empty($full_name)){

            $_SESSION['testErrors'][]='Fullname Cant Be <strong>Empty</strong>';

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

        if(empty($user_gender)){

            $_SESSION['testErrors'][]='Gender Cant Be <strong>Empty</strong>';

        }

         //if no error then update the user
         if(empty($_SESSION['testErrors'])){

            //add avatar and give it random name... the avatars uploaded are exists in admin\uploads\avatars
            $avatar = "";

            if( !empty($avatarName) ) {

                $avatar = rand(0,100000). "_" .$avatarName;

                move_uploaded_file($avatarTmp,"uploads\avatars\\". $avatar);

            }else{
                $avatar = $_POST['old_avatar']; 
            }

            $query = "UPDATE users SET username = '$username' , full_name = '$full_name', user_gender = '$user_gender',
                        user_contact = '$contact_no', email = '$email' , password = '$password', profile_pic = '$avatar'  WHERE id=$id";
            $result = mysqli_query($con,$query);
    
            if($result == 1){ //msg if updated normally
                
                $_SESSION['success'] = 'Profile Updated Successfully';
                header("location: edit-profile.php");

            }else{ // msg if error occured
                
                $_SESSION['error'] = "Profile Update Failed";
                header("location: edit-profile.php");
                
            }

        }else{

            header("location: edit-profile.php");

        }
        

    }
}

    include 'includes/templates/footer.php';

}else{ //if user try directly to go to dashboard

        header("location: ../login.php");
        exit();
    }
   
 ob_end_flush(); //release the output

?>