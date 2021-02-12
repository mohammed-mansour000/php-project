<?php
$q=$_GET["q"];//get the q parameter from URL
//echo $q;
require "connection.php";


$result = mysqli_query($con, "select * from users where username like'%$q%' and userStatus = 0 " ) ;
echo '<table class="user-list-table text-center table table-bordered ">';
        echo'<thead >
                <tr>
                    <th>#ID</th>
                    <th>Avatar</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Control</th>
                </tr>
            </thead>';
            while(   $rows = mysqli_fetch_array($result)  ){
                    
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
                    echo "<td>";
                        echo "<a href='mailto:" . $rows['email'] . "'> ";
                            echo $rows['email']; 
                        echo "</a>";
                    echo "</td>";
                    echo "<td>" ;
                       echo '<a href="user-list.php?do=Edit&userid=' .$rows['id']. '" class="btn btn-success">
                        <i class="fa fa-edit"></i> Edit</a> 
                        <a href="user-list.php?do=Delete&userid=' .$rows['id']. '" class="btn btn-danger confirm"> 
                        <i class="fas fa-trash-alt"></i> Delete</a>';
                    echo "</td>";
                echo "</tr>";
            }

echo '</table>';

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