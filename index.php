<?php
 
 ob_start(); //output buffering start

 include "includes/templates/header.php";
 
 ?>

<?php 

session_start();

if(isset($_SESSION['username']) && $_SESSION['userStatus'] == 0){

  include "includes/templates/navbar.php"; 

  require "admin/connection.php";

    //start get all classes from database
    $query = "SELECT classes.*, users.* 
                FROM classes
                  INNER JOIN users ON classes.coach_id = users.id;";
    $result = mysqli_query($con,$query);
    $count = mysqli_num_rows($result); 

    $do=isset($_GET['class'])? $_GET['class'] : 'Manage';

    if($do=='Manage'){

?>


      
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
			document.getElementById("classe-in-home").innerHTML=xmlhttp.responseText;
		}
	}
	xmlhttp.open("GET","search-home.php?q="+str,true);
	xmlhttp.send();
}

</script>


        <?php if(isset($_SESSION['msg'])){ echo $_SESSION['msg']; $_SESSION['msg'] = "";}?>

        <div class="content-wrapper">
          <div class="dashboard-stats">
            <div class="content">
              <h3 class="dashboard-head text-left mb-2 mt-lg-2 mt-4">Home <span>its all start here</span></h3>
                <!-- Search form -->
                <div class="mt-3">
                  <input class="form-control" type="text" placeholder="Search By Class Name" aria-label="Search" onkeyup="showHint(this.value)">
                </div>
                <div class="row" id="classe-in-home">
                  <?php 

                   while($rows = mysqli_fetch_array($result)){  ?>

                   
                  <div class="col-md-6">
                    <div class="card mt-3">
                      <div class="card-body">
                        <h4 class="card-title"><?php echo $rows['class_name'] ?></h4>
                        <p class="card-text"><?php echo $rows['description'] ?></p>
                        <a href="profile.php?do=show-profile&id=<?php echo $rows['coach_id'] ?>" class="card-text">with <?php echo $rows['full_name'] ?></a>
                        <div class="button-box">
                          <a href="index.php?class=<?php echo $rows['class_name'] ?>&class_id=<?php echo $rows['class_id'] ?>" class="see-sch btn btn-danger">Class Schedules</a>
                      </div>
                      </div>
                    </div>
                  </div>

                  
                  <?php } ?>
                </div>
            </div>  <!-- end of container -->
          </div>  <!-- end of dashboard-stats -->
        </div> <!-- end of content wrapper -->

        


<?php 

  } elseif(isset($_GET['class_id'])){


    //get the class id that you want to show , from the GET( we take the numeric value )
    $class_id=isset($_GET['class_id']) && is_numeric($_GET['class_id']) ? intval($_GET['class_id']) : 0;
    $class_name = $_GET['class'];

    
    //now fetch all information from database of this user using id
    $query = "SELECT classes.*, users.full_name 
                FROM classes INNER JOIN users ON classes.coach_id = users.id 
                  WHERE classes.class_name = '$class_name'";
    $result = mysqli_query($con,$query);
    //$rows = mysqli_fetch_array($result);
    $count = mysqli_num_rows($result);

    if($count > 0 ){ //check if class with the class_id exists  ?>


<div class="content-wrapper">
        <div class="content">
          <h3 class="add-user-title mb-3 mt-lg-2 mt-4"><i class="fa fa-angle-right text-secondary"></i> Class Schedule</h3>
          <div class="table-responsive">
                <table class="coach-list-table text-center table table-bordered">
                    <thead>
                        <tr>
                            <th>Monday</th>
                            <th>Tuesday</th>
                            <th>Wednesday</th>
                            <th>Thursday</th>
                            <th>Friday</th>
                            <th>Saterday</th>
                        </tr>
                    </thead>
                <?php 
                    
                    while(   $rows = mysqli_fetch_array($result)   ){
                    
                        echo "<tr>";
                        
                            echo "<td>";
                              if(strpos($rows['time'], 'MW')!== false){
                                echo "<p>". $rows['time'] ."</p>";
                                echo "<p>". $rows['full_name'] ."</p>";
                              }
                            echo "</td>";
                            echo "<td>";
                              if(strpos($rows['time'], 'Tth')!== false){
                                echo "<p>". $rows['time'] ."</p>";
                                echo "<p>". $rows['full_name'] ."</p>";
                              }
                            echo "</td>";
                            echo "<td>";
                              if(strpos($rows['time'], 'MW')!== false){
                                echo "<p>". $rows['time'] ."</p>";
                                echo "<p>". $rows['full_name'] ."</p>";
                              }
                            echo "</td>";
                            echo "<td>";
                              if(strpos($rows['time'], 'Tth')!== false){
                                echo "<p>". $rows['time'] ."</p>";
                                echo "<p>". $rows['full_name'] ."</p>";
                              }
                            echo "</td>";
                            echo "<td>";
                              if(strpos($rows['time'], 'FS')!== false){
                                echo "<p>". $rows['time'] ."</p>";
                                echo "<p>". $rows['full_name'] ."</p>";
                              }
                            echo "</td>";
                            echo "<td>";
                              if(strpos($rows['time'], 'FS')!== false){
                                echo "<p>". $rows['time'] ."</p>";
                                echo "<p>". $rows['full_name'] ."</p>";
                              }
                            echo "</td>";
                           
                            
                        echo "</tr>";
                    }
                
                ?>
                </table>
            </div>  <!-- end of table-responsive -->
            <a href="index.php?do=Join&class=<?php echo $class_name ?>" class="btn btn-primary">Join</a>
        </div> <!-- end of content -->
</div> <!-- end of content-wrapper -->
    
  <?php
    
    }else{
      echo '<div class="content-wrapper">';
          echo "this class doesn't exist";
      echo '</div> ' ;
    
  }


 } elseif(isset($_GET['do']) && $_GET['do'] == "Join"){ //if the user want to join the class

    //get the class id that you want to show , from the GET( we take the numeric value )
    $class_id=isset($_GET['class_id']) && is_numeric($_GET['class_id']) ? intval($_GET['class_id']) : 0;
    
    $class_name = $_GET['class'];
    
    //now fetch all information from database of this user using id
    $query = "SELECT * FROM classes WHERE class_name = '$class_name'";
    $result = mysqli_query($con,$query);
    $rows = mysqli_fetch_array($result);
    $count = mysqli_num_rows($result);

    if($count > 0 ){ //check if class with the class_id exists  ?>



<div class="content-wrapper">
        <div class="content">

            
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

          <h3 class="add-user-title mb-3 mt-lg-2 mt-4"><i class="fa fa-angle-right text-secondary"></i><?php echo strtoupper($rows['class_name']) ?></h3>
          <form action="index.php?do=Insert&class=<?php echo $rows['class_name'] ?>" method="POST">
          <div class="card mt-3">
                    <div class="card-body">
                        <h4 class="card-title"><?php echo $rows['class_name'] ?></h4>
                        <p class="card-text"><?php echo $rows['description'] ?></p>

                        <?php 
                                
                                $stmt="SELECT classes.*, users.full_name 
                                         FROM classes INNER JOIN users ON classes.coach_id = users.id 
                                          WHERE classes.class_name = '$class_name'";
     
                                 $result2 = mysqli_query($con,$stmt);
     
                                 //$name= mysqli_fetch_array($result2);
                                 

                        ?>
                        <select class="form-control"  name="coach">

                                <option value="">--Please choose coach--</option>

                                <?php 

                                  while($name = mysqli_fetch_array($result2)){
                                    echo "<option value='" .$name['class_id'].  "'>" . $name['full_name'] . "---" .$name['time'] .  "</option>";
                                  }

                                ?>

                        </select>
                        
                    </div>
          </div>
                    <input type="submit" class="btn btn-dark mt-5" value="ADD">
          </form>
        </div> <!-- end of content -->
</div> <!-- end of content-wrapper -->

<?php

  }else{
    
    echo 
      '<div class="content-wrapper">
          <div class="content">
              no such class
          </div>
      </div>';

  }

}elseif(isset($_GET['do']) && $_GET['do'] == "Insert"){ //if the user want to insert the class


  $user_id    = $_SESSION['userID'];
  $class_id   = $_POST['coach'];

  $_SESSION['testErrors'] = array();
  $_SESSION['success'] = '';
        $_SESSION['error'] = '';

  $test_myTime = "SELECT registered_class.*, classes.time 
                    FROM  registered_class 
                      INNER JOIN classes ON classes.class_id =  registered_class.class_id";

  $result_myTime = mysqli_query($con, $test_myTime);


  $class_time = "SELECT * FROM classes WHERE class_id = $class_id";

  $result_classTime = mysqli_query($con, $class_time);

  $classTime = mysqli_fetch_array($result_classTime);


  while(  $myTime = mysqli_fetch_array($result_myTime) ){

    if($myTime['time'] == $classTime['time']){

      $_SESSION['testErrors'][] = '<strong>Time Conflict</strong> For The You';
    
    }
  }

  if(empty($class_id)){

    $_SESSION['testErrors'][] = 'Coach & Time Selection Cant Be <strong>Empty</strong>';

  }

  //if no error then insert the class
  if(empty($_SESSION['testErrors'])){
    
    $query = "INSERT INTO registered_class(user_id, class_id) VALUES($user_id, $class_id)";
    $result = mysqli_query($con, $query);

    if($result == 1){ //msg if inserted normally
                
      $_SESSION['success'] = 'Class Registered Successfully';
      header('location: index.php?do=Join&class=' .$classTime['class_name']);

    }else{ // msg if error occured
      
      $_SESSION['error'] = "Class Registration Failed";
      header('location: index.php?do=Join&class=' .$classTime['class_name']);
      
    }

    
  }else{

    header('location: index.php?do=Join&class=' .$classTime['class_name']);

  }


  

}


}else{

  header('location:login.php');

}

?>           
          
<?php include "includes/templates/footer.php";

 ob_end_flush(); //release the output 

?>