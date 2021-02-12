<?php 

 ob_start(); //output buffering start

 session_start();

 $pageTitle='Classes';

 if(isset($_SESSION['username']) && $_SESSION['userStatus'] == 1){

    include 'includes/templates/header.php';   ?>

    <?php include "includes/templates/navbar.php" ?>


<?php

    $do=isset($_GET['do'])? $_GET['do'] : 'Manage';

if($do=='Manage'){  ?>

    
<div class="content-wrapper">
        <div class="content">
            <h3 class="add-user-title mb-3 mt-lg-2 mt-4"><i class="fa fa-angle-right text-secondary"></i> Add Class</h3>
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

                <form class="" action="<?php echo "?do=Insert"?>" method="POST" enctype="multipart/form-data">
                        
                    <!-- start Class Name field -->
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label label-left">Class Name</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="name" placeholder="Enter Class Name" >
                        </div>                        
                    </div>
                    <!-- end Class Name field -->

                     <!-- start Description field -->

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label label-left">Description</label>
                        <div class="col-sm-10">
                            <input type="text" name="description" class="form-control"  placeholder="Description About Class">
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
                                
                                require "connection.php";
                                $query = "SELECT * FROM users WHERE userStatus = 2";
                                $result = mysqli_query($con,$query);
                                
                                while($users = mysqli_fetch_array($result)){
                                    echo "<option value='" .$users['id'].  "'>" . $users['full_name'] . "</option>";
                                }

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
                                <option value="MW 08:00-9:15">MW 08:00-9:15</option>
                                <option value="MW 09:30-10:45">MW 09:30-10:45</option>
                                <option value="MW 14:00-15:15">MW 14:00-15:15</option>
                                <option value="MW 15:30-16:45">MW 15:30-16:45</option>
                                <option value="Tth 08:00-9:15">Tth 08:00-9:15</option>
                                <option value="Tth 09:30-10:45">Tth 09:30-10:45</option>
                                <option value="Tth 14:00-15:15">Tth 14:00-15:15</option>
                                <option value="Tth 15:30-16:45">Tth 15:30-16:45</option>
                                <option value="FS 08:00-9:15">FS 08:00-9:15</option>
                                <option value="FS 09:30-10:45">FS 09:30-10:45</option>
                                <option value="FS 14:00-15:15">FS 14:00-15:15</option>
                                <option value="FS 15:30-16:45">FS 15:30-16:45</option>
                            </select>
                        </div>
                    </div>

                    <!-- end Time Selection -->


                    <!-- start Insert Class field -->

                    <div class="form-group row">
                        <div class="offset-md-2 col-sm-10 mt-3">
                            <input type="submit" name="update_user" value="Add" class="btn btn-dark">
                        </div>
                    </div>

                    <!-- end Insert Class field -->
                </form>
            </div>
        </div> <!-- end of row -->
    </div> <!-- end of contianer -->
</div>  <!-- end of content-wrapper -->
    
<?php

}


elseif($do=='Insert'){ 

        
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
        $query_check_coach = "SELECT * FROM classes where coach_id = '$coach_id'";
        $result_time = mysqli_query($con,$query_check_coach);
        //$check_coach_time = mysqli_fetch_array($result_time);

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



            $query = "INSERT INTO classes(class_name, description, coach_id,time) VALUES('$name', '$description', '$coach_id','$time')";
            $result = mysqli_query($con,$query);

            if($result == 1){ //msg if inserted normally
                
                $_SESSION['success'] = 'Class Inserted Successfully';
                header("location:add-class.php");

            }else{ // msg if error occured
                
                $_SESSION['error'] = "Class Insertion Failed";
                header("location:add-class.php");
                
            }

        }else{

            header("location: add-class.php");

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