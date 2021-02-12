<?php
$q=$_GET["q"];//get the q parameter from URL
//echo $q;
require "connection.php";


$result = mysqli_query($con, "SELECT classes.*, users.* 
FROM classes
    INNER JOIN users ON classes.coach_id = users.id
    WHERE class_name like'%$q%'" ) ;

while($rows = mysqli_fetch_array($result)){

    echo '<div class="card mt-3" >
    <div class="card-body">
        <div class="row">
                <div class="col-8">
                    <h5 class="card-title">' .  $rows["class_name"] . '</h5>
                    <hr>
                    <p class="card-text"><i class="fas fa-info-circle"></i>' . $rows["description"] . '</p>
                    <hr>
                    <p class="card-text">';
                                            if($rows["user_gender"] == 1){
                                                echo '<i class="fas fa-male"></i> ';
                                            }else{
                                                echo '<i class="fas fa-female"></i> ';
                                            }
                    
                                        echo $rows['full_name'] ;
                echo  
                    '</p>
                    <hr>
                    <p class="card-text"><i class="far fa-calendar-alt"></i>' . $rows["time"] . '</p>
                    <hr>
                </div>
                <div class="col-4 text-right">
                    <a href="class-list.php?do=Edit&class_id=' . $rows["class_id"] . '" class="btn btn-primary btn-sm mb-sm-0 mr-1"><i class="fa fa-pencil"></i></a>
                    <a href="class-list.php?do=Delete&class_id=' . $rows["class_id"] . '" class="btn btn-danger btn-sm confirm"><i class="fas fa-trash-alt"></i></a>
                </div>
            </div>
        </div>
    </div>';
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