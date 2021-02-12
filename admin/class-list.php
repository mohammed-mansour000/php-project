<?php 

 ob_start(); //output buffering start

 session_start();

 $pageTitle='Class-List';

 if(isset($_SESSION['username']) && $_SESSION['userStatus'] == 1){

    include "includes/templates/header.php";

    require "connection.php";

    //start get all users from database
    //$query = "SELECT * FROM classes";
    $query = "SELECT classes.*, users.* 
                FROM classes
                    INNER JOIN users ON classes.coach_id = users.id;";
    $result = mysqli_query($con,$query);
    $count = mysqli_num_rows($result); 


?>

<?php include "includes/templates/navbar.php"; ?>

<?php

    $do=isset($_GET['do'])? $_GET['do'] : 'Manage';

if($do=='Manage'){  ?>

        
        
<script>

function showHint(str)
{
	if (str.length==0)	{ 
		//document.getElementById("table-users").innerHTML="";
		return;
	}
	xmlhttp=new XMLHttpRequest();	
	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200)   {
			document.getElementById("class-list").innerHTML=xmlhttp.responseText;
		}
	}
	xmlhttp.open("GET","search-classlist.php?q="+str,true);
	xmlhttp.send();
}

</script>

<div class="content-wrapper">
<div class="content">

    <?php  if($count > 0){ //check if there is any coach in the table ?>

        <?php if(isset($_SESSION['msg'])) echo $_SESSION['msg']; $_SESSION['msg'] = ''; ?>
        
    <h3 class="add-user-title mb-1 mt-lg-2 mt-4"><i class="fa fa-angle-right text-secondary"></i> Class List</h3>
    <!-- Search form -->
    <div class="mt-3">
                <input class="form-control" type="text" placeholder="Search By Class Name" aria-label="Search" onkeyup="showHint(this.value)">
            </div>
    <div class="row">
        <div  id="class-list" class="col-12 class-list">
            <?php 
            
            while($rows = mysqli_fetch_array($result)){

               /*  $stmt="SELECT classes.*, users.* 
                                        FROM classes
                                            INNER JOIN users ON classes.coach_id = users.id;";

                $result2 = mysqli_query($con,$stmt);

                $name= mysqli_fetch_array($result2); */

                ?>
                <div class="card mt-3" >
                <div class="card-body">
                    <div class="row">
                            <div class="col-8">
                                <h5 class="card-title"><?php echo $rows['class_name']?> </h5>
                                <hr>
                                <p class="card-text"><i class="fas fa-info-circle"></i> <?php echo $rows['description'] ?> </p>
                                <hr>
                                <p class="card-text"><?php
                                                        if($rows['user_gender'] == 1){
                                                            echo '<i class="fas fa-male"></i> ';
                                                        }else{
                                                            echo '<i class="fas fa-female"></i> ';
                                                        }
                                                        echo $rows['full_name'] ?>
                                </p>
                                <hr>
                                <p class="card-text"><i class="far fa-calendar-alt"></i> <?php echo $rows['time'] ?> </p>
                                <hr>
                            </div>
                            <div class="col-4 text-right">
                                <a href="class-list.php?do=Edit&class_id=<?php echo $rows['class_id'] ?>" class="btn btn-primary btn-sm mb-sm-0 mr-1"><i class="fa fa-pencil"></i></a>
                                <a href="class-list.php?do=Delete&class_id=<?php echo $rows['class_id'] ?>" class="btn btn-danger btn-sm confirm"><i class="fas fa-trash-alt"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
              <?php  
            }

            ?>
        </div>  <!-- end of col-12 -->
    </div>  <!-- end of row -->
    <?php }else{ ?>

            <div class="container text-center">
                <div class="no-coach">

                        Class List is Empty 
                        <a href="add-class.php">Add Class</a>

                </div>
            </div>

    <?php } ?>
</div>  <!-- end of content -->
</div>  <!-- end of content-wrapper-->

   <?php
   
}

elseif($do=='Edit'){  ?>

<?php  

    //get the user id that you want to edit , from the GET( we take the numeric value )
    $class_id=isset($_GET['class_id']) && is_numeric($_GET['class_id']) ? intval($_GET['class_id']) : 0;
    
    //now fetch all information from database of this user using id
    $query = "SELECT classes.*, users.* 
                FROM classes INNER JOIN users ON classes.coach_id = users.id 
                    WHERE classes.class_id = '$class_id'";
    $result = mysqli_query($con,$query);
    $rows = mysqli_fetch_array($result);
    $count = mysqli_num_rows($result);

    if($count > 0 ){ //check if class with the id exists ?>

  
<div class="content-wrapper">
        <div class="content">
            <h3 class="add-user-title mb-3 mt-lg-2 mt-4"><i class="fa fa-angle-right text-secondary"></i> Edit Class</h3>
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

                <form class="" action="<?php echo "?do=Update&class_id=".$rows['class_id'] ?>" method="POST" enctype="multipart/form-data">
                        
                    <!-- start Class Name field -->
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label label-left">Class Name</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="name" placeholder="Enter Class Name" value="<?php echo $rows['class_name'] ?>">
                        </div>                        
                    </div>
                    <!-- end Class Name field -->

                     <!-- start Description field -->

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label label-left">Description</label>
                        <div class="col-sm-10">
                            <input type="text" name="description" class="form-control"  placeholder="Description About Class" value="<?php echo $rows['description'] ?>">
                        </div>
                    </div>

                    <!-- end Description field -->


  


                    <!-- start Coach Selection -->

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label label-left">Coach Selection</label>
                        <div class="col-sm-10">
                            <select class="form-control"  name="coach">
                                <option value="">--Please choose coach--</option>
                            <?php 
                                
                                
                                $query2 = "SELECT * FROM users WHERE userStatus = 2";
                                $result2 = mysqli_query($con,$query2);
                                
                                while($coaches = mysqli_fetch_array($result2)){ ?>
                                    <option value="<?php echo $coaches['id'] ?>" <?php if($rows['full_name'] == $coaches['full_name']){echo "selected";} ?>><?php echo $coaches['full_name'] ?></option>
                               
                               <?php }

                            ?>

                            </select>
                        </div>
                    </div>

                    <!-- end Coach Selection -->

                     <!-- start Time Selection -->

                     <div class="form-group row">
                        <label class="col-sm-2 col-form-label label-left">Time Selection</label>
                        <div class="col-sm-10">
                            <select class="form-control"  name="time">
                                <option value="">--Please choose time--</option>
                                <option value="MW 08:00-9:15" <?php if($rows['time']=="MW 08:00-9:15"){echo "selected";} ?>>MW 08:00-9:15</option>
                                <option value="MW 09:30-10:45" <?php if($rows['time']=="MW 09:30-10:45"){echo "selected";} ?>>MW 09:30-10:45</option>
                                <option value="MW 14:00-15:15" <?php if($rows['time']=="MW 14:00-15:15"){echo "selected";} ?>>MW 14:00-15:15</option>
                                <option value="MW 15:30-16:45" <?php if($rows['time']=="MW 15:30-16:45"){echo "selected";} ?>>MW 15:30-16:45</option>
                                <option value="Tth 08:00-9:15" <?php if($rows['time']=="Tth 08:00-9:15"){echo "selected";} ?>>Tth 08:00-9:15</option>
                                <option value="Tth 09:30-10:45" <?php if($rows['time']=="Tth 09:30-10:45"){echo "selected";} ?>>Tth 09:30-10:45</option>
                                <option value="Tth 14:00-15:15" <?php if($rows['time']=="Tth 14:00-15:15"){echo "selected";} ?>>Tth 14:00-15:15</option>
                                <option value="Tth 15:30-16:45" <?php if($rows['time']=="Tth 15:30-16:45"){echo "selected";} ?>>Tth 15:30-16:45</option>
                                <option value="FS 08:00-9:15" <?php if($rows['time']=="FS 08:00-9:15"){echo "selected";} ?>>FS 08:00-9:15</option>
                                <option value="FS 09:30-10:45" <?php if($rows['time']=="FS 09:30-10:45"){echo "selected";} ?>>FS 09:30-10:45</option>
                                <option value="FS 14:00-15:15" <?php if($rows['time']=="FS 14:00-15:15"){echo "selected";} ?>>FS 14:00-15:15</option>
                                <option value="FS 15:30-16:45" <?php if($rows['time']=="FS 15:30-16:45"){echo "selected";} ?>>FS 15:30-16:45</option>
                            </select>
                        </div>
                    </div>

                    <!-- end Time Selection -->


                    <!-- start Insert Class field -->

                    <div class="form-group row">
                        <div class="offset-md-2 col-sm-10 mt-3">
                            <input type="submit" name="update_class" value="Update" class="btn btn-dark">
                        </div>
                    </div>

                    <!-- end Insert Class field -->
                </form>
            </div>
        </div> <!-- end of row -->
    </div> <!-- end of contianer -->
</div>  <!-- end of content-wrapper -->



<?php

    }else{
            echo '<div class="content-wrapper">';
                echo "this class doesn't exist";
            echo '</div> ' ;
          
        }
}

elseif($do == 'Update'){

    //get the class id that you want to edit , from the GET( we take the numeric value )
    $class_id = '';

    if(isset($_GET['class_id']) && is_numeric($_GET['class_id'])){
        $class_id = intval($_GET['class_id']);
     }else{
         $class_id = 0;
     }

    if($_SERVER['REQUEST_METHOD']=='POST'){

        //prepare sessions
        $_SESSION['testErrors'] = array();
        $_SESSION['success'] = '';
        $_SESSION['error'] = '';


        //check if all fields is correct
        $name           = $_POST['name'];
        $description    = $_POST['description'];
        $coach_id       = $_POST['coach'];
        $time           = $_POST['time'];

        //now check if coach is already added on the same time or not
        $query_check_coach = "SELECT * FROM classes where coach_id = '$coach_id' and class_id != '$class_id' ";
        $result_time = mysqli_query($con,$query_check_coach);
       

        while(  $check_coach_time = mysqli_fetch_array($result_time) ){
            if($check_coach_time['time'] == $time){ //fill session error if the time conflicts
                $_SESSION['testErrors'][]='<strong>Time Conflict</strong> For The Coach';
            }
        }

        //fill the $errors if error found (in the form)
        if(empty($name)){

            $_SESSION['testErrors'][]='Name of Class Cant Be <strong>Empty</strong>';

        }

        if(empty($description)){

            $_SESSION['testErrors'][]='Description Cant Be <strong>Empty</strong>';

        }

        if(empty($coach_id)){

            $_SESSION['testErrors'][]='Coach Selection Cant Be <strong>Empty</strong>';

        }

        if(empty($time)){

            $_SESSION['testErrors'][]='Time Selection Cant Be <strong>Empty</strong>';

        }


        //if no error then insert the user
        if(empty($_SESSION['testErrors'])){



            $query = "UPDATE classes SET class_name = '$name', description = '$description',
                        time = '$time', coach_id = '$coach_id' 
                            WHERE class_id = '$class_id'";
                            
            $result = mysqli_query($con,$query);
            //$num = mysqli_affected_rows($con);
            if($result == 1){ //msg if inserted normally
                
                $_SESSION['success'] = 'Class Updated Successfully';
                header("location: class-list.php?do=Edit&class_id=". $class_id);

            }else{ // msg if error occured
                
                $_SESSION['error'] = "Class Update Failed";
                header("location: class-list.php?do=Edit&class_id=". $class_id);
                
            }

        }else{

            header("location: class-list.php?do=Edit&class_id=". $class_id);

        }

    

    }
}

elseif( $do == 'Delete'){

    //get the user id that you want to edit , from the GET( we take the numeric value )
    $class_id = '';

    if(isset($_GET['class_id']) && is_numeric($_GET['class_id'])){
        $class_id = intval($_GET['class_id']);
     }else{
         $class_id = 0;
     }

     //now fetch all information from database of this class using id
     $query = "SELECT * FROM classes WHERE class_id = '$class_id'";
     $result = mysqli_query($con,$query);
     $count = mysqli_num_rows($result);
 
     if($count > 0 ){ //check if user with the id exists
 
         $query = "DELETE FROM classes WHERE class_id = '$class_id'";
         $result = mysqli_query($con,$query);
         if($result == 1){
 
             $_SESSION['msg'] = "<script>alert('Class Deleted')</script>";
             header('location: class-list.php');
         
         }else{
 
             $_SESSION['msg'] = "<script>alert('Deletion Failed')</script>";
             header('location: class-list.php');
         }
 
    }else{
    
        echo '<div class="content-wrapper">';
            echo "this class doesn't exist";
        echo '</div> ' ;
    
    }
    
    

}



      include "includes/templates/footer.php";

}else{ //if user try directly to go to dashboard

        header("location: ../login.php");
        exit();
    }

   
 ob_end_flush(); //release the output

?>