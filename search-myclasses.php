<?php

session_start();

$q=$_GET["q"];//get the q parameter from URL
//echo $q;
require "admin/connection.php";

$id = $_SESSION['userID'];

$query = "SELECT registered_class.*, classes.*, users.*      
FROM registered_class 
    JOIN classes
        ON registered_class.class_id = classes.class_id 
            JOIN users 
                ON classes.coach_id = users.id
                    WHERE registered_class.user_id = '$id' 
                        AND class_name like'%$q%'";

$result = mysqli_query($con,$query);

$count = mysqli_num_rows($result); 

if($count > 0){

    while( $rows = mysqli_fetch_array($result) ){

    echo '
        <div class="col-md-6 mt-4">
            <div class="list-group for-shadow">
                <li class="list-group-item">
                    <a href="myclasses.php?do=Delete&regs_id=' . $rows['register_id'] .'">
                        <span class="btn btn-danger btn-sm float-right ml-2 confirm">
                            <i class="fa fa-trash"></i>
                        </span> 
                    </a>
                    <a href="index.php?do=Join&class=' . $rows["class_name"] . '">
                        <span class="btn btn-primary btn-sm float-right">
                            <i class="fa fa-edit"></i>
                        </span> 
                    </a>
                    <h4 class="card-title">' . $rows['class_name'] .  '</h4>
                                                <hr>
                    <p class=""><i class="fas fa-info-circle"></i>' . $rows['description'] . '</p>
                                                <hr>
                    <p class=""><i class="far fa-calendar-alt"></i>' . $rows['time'] . ' </p>
                                                <hr>
                    <p><a href="profile.php?do=show-profile&id=' . $rows['coach_id'] . '"><i class="fas fa-swimmer"></i> ' . $rows['full_name'] . '</a></p>
                </li>
            </div>
        </div>  <!-- end of col-md-6 -->';
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