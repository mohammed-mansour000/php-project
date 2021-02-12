<?php 

 ob_start(); //output buffering start

 session_start();

 $pageTitle='Profile';

 if(isset($_SESSION['username']) && $_SESSION['userStatus'] == 1){

    include 'includes/templates/header.php';
    
    include "includes/templates/navbar.php"; ?>

<?php 

$do=isset($_GET['do'])? $_GET['do'] : 'myProfile';

//if $do = myprofile it shows my profile that i can edit 

if($do=='myProfile'){   ?>


<?php 

    require "connection.php";
    $id = $_SESSION['userID'];
    $query = "SELECT * FROM users WHERE id = '$id'";
    $result = mysqli_query($con,$query);
    $rows = mysqli_fetch_array($result);

    if(empty($rows['profile_pic'])){
        $prof = "uploads/default-avatars/kindpng_223941.png";
    }else{
        $prof = "uploads/avatars/" . $rows['profile_pic'] . "";
    }

?>

<div class="content-wrapper">
    <div class="profile-page">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="profile-img">
                        <img src=<?php echo $prof ?> class="img-fluid img-thumbnail" alt="">
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="profile-details">
                        <div class="profile-head text-center text-md-left mb-lg-0 mt-lg-0 mb-5 mt-5">
                            <h2><?php echo $rows['username'] ?></h2>
                            <p><?php echo $rows['full_name'] ?></p>
                        </div>
                        <div class="profile-body">
                            <h5><?php echo $rows['username'] ?>'s Informations</h5>
                            <ul class="list-group">
                                <li class="list-group-item">
                                    <i class="fas fa-phone"></i> <span>Phone :</span>
                                    <?php echo $rows['user_contact'] ?>
                                </li>
                                <li class="list-group-item">
                                    <i class="fas fa-envelope"></i> <span>Email :</span> 
                                    <?php echo $rows['email'] ?>
                                </li>
                                <li class="list-group-item">
                                    <i class="fas fa-user-tie"></i> <span>Fullname :</span> 
                                    <?php echo $rows['full_name'] ?>
                                </li>
                                <li class="list-group-item">
                                    <i class="fas fa-user"></i> <span>Username :</span> 
                                    <?php echo $rows['username'] ?>
                                </li>
                                <li class="list-group-item"> 
                                    <?php 
                                        if($rows['user_gender'] == 1){
                                            echo '<i class="fas fa-male"></i> <span>Gender :</span> Male';
                                        }else{
                                            echo '<i class="fas fa-female"></i> <span>Gender :</span> Female';
                                        }
                                    ?>
                                 </li>
                                 <li class="list-group-item">
                                    <a href="edit-profile.php" class="btn btn-primary btn-block"><i class="fas fa-user-edit text-white"></i> Edit Profile</a>
                                 </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>  <!-- end of container -->
    </div>  <!-- end of profile-page -->
</div>  <!-- end of content wrapper -->

<?php 

}elseif($do == 'show-profile'){

    //get the user id that you want to delete , from the GET( we take the numeric value )
    $id=isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : 0;

    require "connection.php";
    $query = "SELECT * FROM users WHERE id = '$id'";
    $result = mysqli_query($con,$query);
    $rows = mysqli_fetch_array($result);

    if(empty($rows['profile_pic'])){
        $prof = "uploads/default-avatars/kindpng_223941.png";
    }else{
        $prof = "uploads/avatars/" . $rows['profile_pic'] . "";
    }

?>
 <div class="content-wrapper">
    <div class="profile-page">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="profile-img">
                        <img src=<?php echo $prof ?> class="img-fluid img-thumbnail" alt="">
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="profile-details">
                        <div class="profile-head text-center text-md-left mb-lg-0 mt-lg-0 mb-5 mt-5">
                            <h2><?php echo $rows['username'] ?></h2>
                            <p><?php echo $rows['full_name'] ?></p>
                        </div>
                        <div class="profile-body">
                            <h5><?php echo $rows['username'] ?>'s Informations</h5>
                            <ul class="list-group">
                                <li class="list-group-item">
                                    <a href="tel:<?php echo $rows['user_contact'] ?>">
                                        <i class="fas fa-phone"></i> <span>Phone :</span>
                                        <?php echo $rows['user_contact'] ?>
                                    </a>
                                </li>
                                <li class="list-group-item">
                                    <a href="mailto:<?php echo $rows['email'] ?>">
                                        <i class="fas fa-envelope"></i> <span>Email :</span> 
                                        <?php echo $rows['email'] ?>
                                    </a>
                                </li>
                                <li class="list-group-item">
                                    <i class="fas fa-user-tie"></i> <span>Fullname :</span> 
                                    <?php echo $rows['full_name'] ?>
                                </li>
                                <li class="list-group-item">
                                    <i class="fas fa-user"></i> <span>Username :</span> 
                                    <?php echo $rows['username'] ?>
                                </li>
                                <li class="list-group-item"> 
                                    <?php 
                                        if($rows['user_gender'] == 1){
                                            echo '<i class="fas fa-male"></i> <span>Gender :</span> Male';
                                        }else{
                                            echo '<i class="fas fa-female"></i> <span>Gender :</span> Female';
                                        }
                                    ?>
                                 </li>
                                 <!-- <li class="list-group-item">
                                    <a href="edit-profile.php" class="btn btn-primary btn-block"><i class="fas fa-user-edit text-white"></i> Edit Profile</a>
                                 </li> -->
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>  <!-- end of container -->
    </div>  <!-- end of profile-page -->
</div>  <!-- end of content wrapper -->

<?php 

}

?>


<?php

    include 'includes/templates/footer.php';

}else{ //if user try directly to go to dashboard

        header("location: ../login.php");
        exit();
    }
   
 ob_end_flush(); //release the output

?>