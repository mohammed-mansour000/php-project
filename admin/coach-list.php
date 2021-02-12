<?php 

 ob_start(); //output buffering start

 session_start();


 if(isset($_SESSION['username']) && $_SESSION['userStatus'] == 1){

    include "includes/templates/header.php";

    require "connection.php";

    //start get all users from database
    $query = "SELECT * FROM users WHERE userStatus = 2";
    $result = mysqli_query($con,$query);
    $count = mysqli_num_rows($result); 


?>

<?php include "includes/templates/navbar.php"; ?>

<?php 

    // now we will check from GET if GET = edit or GET = delete or its normal GET

    $do='';

    if(isset($_GET['do'])){

        $do=$_GET['do'];

    }
    else{

        $do='Manage';
        
    }
   
    if($do == "Manage"){
?>

<script>

function showHint(str)
{
	if (str.length==0)	{ 
		//document.getElementById("table-coach").innerHTML="";
		return;
	}
	xmlhttp=new XMLHttpRequest();	
	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200)   {
			document.getElementById("table-coach").innerHTML=xmlhttp.responseText;
		}
	}
	xmlhttp.open("GET","search-coach.php?q="+str,true);
	xmlhttp.send();
}

</script>


<div class="content-wrapper">
    <div class="content">

    <?php if(isset($_SESSION['msg'])) echo $_SESSION['msg']; $_SESSION['msg'] = '';  //print delete message ?> 

    <?php  if($count > 0){ //check if there is any coach in the table ?>

        <h3 class="user-table-title mb-3 mt-lg-2 mt-4">
                Coach List 
        </h3>
        
            <!-- Search form -->
            <div class="mb-3">
                <input class="form-control" type="text" placeholder="Search By Username" aria-label="Search" onkeyup="showHint(this.value)">
            </div>

            <div class="table-responsive">
                <table id="table-coach" class="coach-list-table text-center table table-bordered">
                    <thead>
                        <tr>
                            <th>#ID</th>
                            <th>Avatar</th>
                            <th>Username</th>
                            <th>Fullname</th>
                            <th>Email</th>
                            <th>Coach Gender</th>
                            <th>Contact</th>
                            <th>Date</th>
                            <th>Control</th>
                        </tr>
                    </thead>
                <?php 
                    
                    while(   $rows = mysqli_fetch_array($result)   ){
                    
                        echo "<tr>";
                            echo "<td>" . $rows['id'] . "</td>";
                            echo "<td>";
                                if(empty($rows['profile_pic'])){
                                    echo '<img src ="uploads/default-avatars/kindpng_223941.png">';
                                }else{
                                    echo '<img src ="uploads/avatars/' . $rows['profile_pic'] . '">';
                                }
                            echo "</td>";
                            echo "<td>";
                                echo "<a href='profile.php?do=show-profile&id=" . $rows['id'] . "'>";
                                    echo $rows['username'];
                                echo "</a>";
                            echo "</td>";
                            echo "<td>" . $rows['full_name'] . "</td>";
                            echo "<td>";
                                echo "<a href='mailto:" . $rows['email'] . "'> ";
                                    echo $rows['email']; 
                                echo "</a>";
                            echo "</td>";
                            echo "<td>";
                                if($rows['user_gender'] == 1){
                                    echo "Male";
                                }else{
                                    echo "Female";
                                } 
                            echo "</td>";
                            echo "<td>" . $rows['user_contact'] . "</td>";
                            echo "<td>" . $rows['date'] . "</td>";
                            echo "<td>" ;
                               echo '<a href="coach-list.php?do=Edit&id=' .$rows['id']. '" class="btn btn-success">
                                <i class="fa fa-edit"></i> Edit</a> 
                                <a href="coach-list.php?do=Delete&id=' .$rows['id']. '" class="btn btn-danger confirm"> 
                                <i class="fas fa-trash-alt"></i> Delete</a>';
                            echo "</td>";
                        echo "</tr>";
                    }
                
                ?>
                </table>
            </div>  <!-- end of table-responsive -->

                

            <a href='add-coach.php' class="btn btn-primary"><i class="fa fa-plus"></i> New Coach</a>
            <?php }else{ ?>

                    <div class="container text-center">
                        <div class="no-coach">

                                Coach Table is Empty 
                                <a href="add-coach.php">Add Coach</a>

                        </div>
                    </div>

            <?php } ?>
    </div>  <!-- end of content -->
</div>  <!-- end of content-wrapper -->


<?php } else if($do == "Edit"){ ?>

<?php  

    //get the user id that you want to edit , from the GET( we take the numeric value )
    $coachid=isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : 0;
    
    //now fetch all information from database of this user using id
    $query = "SELECT * FROM users WHERE id = '$coachid'";
    $result = mysqli_query($con,$query);
    $rows = mysqli_fetch_array($result);
    $count = mysqli_num_rows($result);

    if($count > 0 ){ //check if user with the id exists

?>

<div class="content-wrapper">
        <div class="content">
        <h3 class="add-user-title mb-3 mt-lg-2 mt-4"><i class="fa fa-angle-right text-secondary"></i> Edit Coach</h3>
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

            <form class="form-horizontal" action="<?php echo "?do=Update&id=". $coachid ?>" method="POST" enctype="multipart/form-data">

                <!------------------------------------------------------------------------>
                <!-- you cant upload images without ( enctype="multipart/form-data" ) in the form -->
                <!------------------------------------------------------------------------>

                <!-- start firstname field -->

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label label-left">Username</label>
                    <div class="col-sm-10">
                        <input type="text" name="username" class="form-control" value="<?php echo $rows['username'] ?>"  placeholder="Username">
                    </div>
                </div>

                <!-- end firstname field -->

                <!-- start old avatar -->

                <input type="hidden"  name="old_avatar" value="<?php echo $rows['profile_pic']?>">

                <!-- end old avatar -->

                <!-- start fullname field -->

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label label-left">Fullname</label>
                    <div class="col-sm-10">
                        <input type="text" name="full_name" class="form-control" value="<?php echo $rows['full_name'] ?>" placeholder="Fullname">
                    </div>
                </div>

                <!-- end fullname field -->

                <!-- start Email field -->

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label label-left">Email</label>
                    <div class="col-sm-10">
                        <input type="email" name="email"  class="form-control" value="<?php echo $rows['email'] ?>" placeholder="Email Must Be Valid">
                    </div>
                </div>

                <!-- end Email field -->

                <!-- start Password field -->

                <div class="form-group row">
                    <label class="col-sm-2 ccol-form-label label-left">Password</label>
                    <div class="col-sm-10">
                        <input type="password" name="password" class="form-control password" value="<?php echo $rows['password'] ?>" autocomplete="new-password" placeholder="Password Must Be Hard">
                    </div>
                </div>

                <!-- end Password field -->

                <!-- start confirm-password field -->

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label label-left">Confirm Password</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control"  name="confirm-password" value="<?php echo $rows['password'] ?>" placeholder="Confirm Password">
                    </div>
                </div>

                <!-- end confirm-password field -->

                <!-- start contact field -->

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label label-left">Coach Contact No.</label>
                    <div class="col-sm-10">
                        <input type="number" name="coach_contact"  class="form-control" value="<?php echo $rows['user_contact'] ?>" placeholder="Enter Contact No.">
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

                <!-- start gender -->

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label label-left">Coach Gender</label>
                    <div class="col-sm-10">
                        <select class="form-control"  name="coach_gender">
                            <option value="">--Please choose an option--</option>
                            <option value="1" <?php if($rows['user_gender']==1) echo "selected" ?>>Male</option>
                            <option value="2" <?php if($rows['user_gender']==2) echo "selected" ?>>Female</option>
                        </select>
                    </div>
                </div>

                <!-- end gender -->

                <!-- start Save button -->

                <div class="form-group row">
                    <div class="offset-md-2 col-sm-10 mt-3">
                        <input type="submit" value="Update Coach" class="btn btn-primary">
                    </div>
                </div>

                <!-- end Save button -->

            </form>
            </div>
        </div> <!-- end of row -->
    </div> <!-- end of content -->
</div> <!-- end of content-wrapper -->

<?php }else{
            echo '<div class="content-wrapper">';
                echo "this user doesn't exist";
            echo '</div> ' ;
          
        }

} 

else if($do == "Update"){

    //get the user id that you want to edit , from the GET( we take the numeric value )
    $coachid=isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : 0;
        
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
        $contact_no = $_POST['coach_contact'];
        $coach_gender = $_POST['coach_gender'];


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

        if(empty($coach_gender)){

            $_SESSION['testErrors'][]='Coach Gender Cant Be <strong>Empty</strong>';

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

            $query = "UPDATE users SET username = '$username' , full_name = '$full_name', user_gender = '$coach_gender',
                        user_contact = '$contact_no', email = '$email' , password = '$password', profile_pic = '$avatar'  WHERE id=$coachid";
            $result = mysqli_query($con,$query);
    
            if($result == 1){ //msg if updated normally
                
                $_SESSION['success'] = 'Coach Updated Successfully';
                header("location: coach-list.php?do=Edit&id=". $coachid);

            }else{ // msg if error occured
                
                $_SESSION['error'] = "Coach Insertion Failed";
                header("location: coach-list.php?do=Edit&id=". $coachid);
                
            }

        }else{

            header("location: coach-list.php?do=Edit&id=". $coachid);

        }
    }

}else if($do == "Delete"){

    //get the user id that you want to delete , from the GET( we take the numeric value )
    $coachid=isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : 0;

    //now fetch all information from database of this user using id
    $query = "SELECT * FROM users WHERE id = '$coachid'";
    $result = mysqli_query($con,$query);
    $count = mysqli_num_rows($result);

    if($count > 0 ){ //check if user with the id exists

        $query = "DELETE FROM users WHERE id = '$coachid'";
        $result = mysqli_query($con,$query);
        if($result == 1){

            $_SESSION['msg'] = "<script>alert('user deleted')</script>";
            header('location: coach-list.php');
        
        }else{

            $_SESSION['msg'] = "<script>alert('deletion failed')</script>";
            header('location: coach-list.php');
        }

}else{

    echo '<div class="content-wrapper">';
        echo "this user doesn't exist";
    echo '</div> ' ;

}

}else{

    header('location: coach-list.php');

}

?>

<?php    include 'includes/templates/footer.php';

}else{ //if user try directly to go to dashboard

        header("location: login.php");
        exit();
    }
   
 ob_end_flush(); //release the output

?>