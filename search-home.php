<?php
$q=$_GET["q"];//get the q parameter from URL
//echo $q;
require "admin/connection.php";


$query = "SELECT classes.*, users.* 
                FROM classes
                  INNER JOIN users ON classes.coach_id = users.id 
                    WHERE class_name like'%$q%'";

$result = mysqli_query($con,$query);

$count = mysqli_num_rows($result); 

if($count > 0){

while($rows = mysqli_fetch_array($result)){  

   echo '                
   <div class="col-md-6">
      <div class="card mt-3">
        <div class="card-body">
          <h4 class="card-title">' . $rows["class_name"] . '</h4>
          <p class="card-text">' . $rows["description"] . '</p>
          <a href="profile.php?do=show-profile&id=' . $rows["coach_id"] . '>" class="card-text">with'  . $rows["full_name"] . '</a>
          <div class="button-box">
            <a href="index.php?class=' . $rows["class_name"] . '&class_id=' . $rows["class_id"] . '" class="see-sch btn btn-danger">Class Schedules</a>
        </div>
        </div>
      </div>
    </div>';
    }
}else{
    echo '<div class="container text-center mt-5"><div class="h1">No Such Class</div></div>';
}
// echo "<TABLE border=4>";
//  while($row = mysqli_fetch_array($r) ) {
//       echo "<TR><td>".$row['fname']."</td>";
// 	  echo "<td>".$row['lname']."</td>";
// 	  echo "<td>".$row['salary']."</td> </TR>";
// 	  //echo $q;
//  }  	
// echo"<TABLE>";
 mysqli_close($con);
 
?>