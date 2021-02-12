<?php 

 ob_start(); //output buffering start

 session_start();

 $pageTitle='My Classes';

 if(isset($_SESSION['username']) && $_SESSION['userStatus'] == 0){

    include 'includes/templates/header.php';
    
    include "includes/templates/navbar.php"; 

    $do=isset($_GET['do'])? $_GET['do'] : 'Manage';


if($do=='Manage'){

    require "admin/connection.php";
    $id = $_SESSION['userID'];

    //query to join the three tables where user_id = $id 
    $query = "SELECT registered_class.*, classes.*, users.*      
                FROM registered_class 
                    JOIN classes
                        ON registered_class.class_id = classes.class_id 
                            JOIN users 
                                ON classes.coach_id = users.id
                                    WHERE registered_class.user_id = '$id'";

    $result = mysqli_query($con,$query);
    //$rows = mysqli_fetch_array($result);

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
			document.getElementById("myclasses").innerHTML=xmlhttp.responseText;
		}
	}
	xmlhttp.open("GET","search-myclasses.php?q="+str,true);
	xmlhttp.send();
}

</script>

<div class="content-wrapper">
    <div class="myclasses">
        <div class="content">
<!-- Search form -->
<div class="mt-3">
                  <input class="form-control" type="text" placeholder="Search By Class Name" aria-label="Search" onkeyup="showHint(this.value)">
                </div>
        <?php if(isset($_SESSION['msg'])) echo $_SESSION['msg']; $_SESSION['msg'] = ''; ?>

            <div class="row" id="myclasses">

                <?php 

                    while( $rows = mysqli_fetch_array($result) ){

                ?>

                <div class="col-md-6 mt-4">
                    <div class="list-group for-shadow">
                        <li class="list-group-item">
                            <a href="myclasses.php?do=Delete&regs_id=<?php echo $rows['register_id'] ?>">
                                <span class="btn btn-danger btn-sm float-right ml-2 confirm">
                                    <i class="fa fa-trash"></i>
                                </span> 
                            </a>
                            <a href="index.php?do=Join&class=<?php echo $rows['class_name'] ?>">
                                <span class="btn btn-primary btn-sm float-right">
                                    <i class="fa fa-edit"></i>
                                </span> 
                            </a>
                            <h4 class="card-title"><?php echo $rows['class_name']?> </h4>
                                                        <hr>
                            <p class=""><i class="fas fa-info-circle"></i> <?php echo $rows['description'] ?> </p>
                                                        <hr>
                            <p class=""><i class="far fa-calendar-alt"></i> <?php echo $rows['time'] ?> </p>
                                                        <hr>
                            <p><a href="profile.php?do=show-profile&id=<?php echo $rows['coach_id'] ?>"><i class="fas fa-swimmer"></i> <?php echo $rows['full_name'] ?></a></p>
                        </li>
                    </div>
                </div>  <!-- end of col-md-6 -->

                <?php } ?>

            </div>  <!-- end of row -->
        </div>  <!-- end of content -->
    </div>  <!-- end of  myclasses-->
</div>  <!-- end of content-wrapper -->
<?php

}

elseif($do=='Delete'){

//get the user id that you want to edit , from the GET( we take the numeric value )
$reg_id=isset($_GET['regs_id']) && is_numeric($_GET['regs_id']) ? intval($_GET['regs_id']) : 0;

require "admin/connection.php";

$query = "SELECT * FROM registered_class WHERE register_id = '$reg_id'";
$result = mysqli_query($con,$query);
$count = mysqli_num_rows($result);

    if($count > 0 ){ //check if class with the id exists 

        $query_del = "DELETE FROM registered_class WHERE register_id = '$reg_id'";
        $del = mysqli_query($con,$query_del);

        if(mysqli_affected_rows($con) > 0){

            $_SESSION['msg'] = "<script>alert('Class Droped')</script>";
            header('location: myclasses.php');
        
        }else{

            $_SESSION['msg'] = "<script>alert('Droping failed')</script>";
            header('location: myclasses.php');
        }

    }else{
        echo '<div class="content-wrapper">
                <div class="content">
                    no such class to delete
                </div>
            </div>';
    }


}

    include 'includes/templates/footer.php';

}else{ //if user try directly to go to dashboard

        header("location: login.php");
        exit();
    }
   
 ob_end_flush(); //release the output

?>