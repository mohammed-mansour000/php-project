<?php
 
 ob_start(); //output buffering start

 include "includes/templates/header.php";
 include "includes/functions/function.php";
 
 ?>

<?php 

session_start();

if(isset($_SESSION['username']) && $_SESSION['userStatus'] == 1){

 if(isset($_SESSION['msg'])){ echo $_SESSION['msg']; $_SESSION['msg'] = "";}

 require "connection.php";


?>

        <?php include "includes/templates/navbar.php"; ?>

        <div class="content-wrapper">
          <div class="dashboard-stats">
            <div class="content text-center">
              <h3 class="dashboard-head text-left mb-3 mt-lg-2 mt-4">Dashboard <span>Control panel</span></h3>
                <div class="row">
                   <div class="col-md-3 col-xs-6">
                      <div class="stat st-members">
                          <div class="info text-left-sm text-center">
                            <span><a href="user-list.php"><?php echo countItem('id', 'users', "0") ?></a></span>  
                            <p>Total Users</p>
                          </div>
                          <a href="user-list.php"><i class="fas fa-user-friends"></i></a> 
                      </div>
                   </div>
                   <div class="col-md-3 col-xs-6">
                      <div class="stat st-coach">
                          <div class="info text-left-sm text-center">
                            <span><a href="coach-list.php"><?php echo countItem('id', 'users', 2) ?></a></span>  
                            <p>Total Coaches</p>
                          </div>
                          <a href="coach-list.php"><i class="fas fa-swimmer"></i></a> 
                      </div>
                   </div>
                   <div class="col-md-3 col-xs-6">
                    <div class="stat st-shop">
                          <div class="info text-left-sm text-center">
                            <span><a href="class-list.php"><?php echo countItem('class_id', 'classes') ?></a></span>  
                            <p>Total Classes</p>
                          </div>
                          <a href="class-list.php"><i class="fas fa-clipboard-list"></i></a>
                    </div>
                   </div>
                   <div class="col-md-3 col-xs-6">
                      <div class="stat st-schedule">
                          <div class="info text-left-sm text-center">
                            <span><a href="#"><?php echo countItem('id', 'users') ?></a></span>  
                            <p>Total Members</p>
                          </div>
                          <i class="fa fa-users"></i>     
                      </div>
                   </div>
                </div>
            </div>  <!-- end of container -->
          </div>  <!-- end of dashboard-stats -->

          <div class="latest">
            <div class="content">
              <div class="row">
                <div class="col-md-6">
                  <div class="list-group">
                    <li class="list-group-item "><i class="fas fa-users"></i> Latest Registered Users</li>
                    <?php 

                      $numUsers = 5; //number of latest users 

                      $query = "SELECT * FROM users ORDER BY id DESC LIMIT $numUsers ";

                      $result = mysqli_query($con, $query);

                      while(  $Latest_item = mysqli_fetch_array($result) ) { ?>

                    <li class="list-group-item ">
                      <a href="profile.php?do=show-profile&id=<?php echo $Latest_item['id'] ?>">
                        <?php echo $Latest_item['username']; ?>
                      </a>
                      <a href="user-list.php?do=Edit&userid=<?php echo $Latest_item['id'] ?>">
                        <span class="btn btn-primary btn-sm float-right">
                          <i class="fa fa-edit"></i>
                        </span> 
                      </a>
                    </li>   
                    
                    
                    <?php }?>
                    
                  </div>
                </div>  <!-- end of col-md-6 -->
                <div class="col-md-6 mt-lg-0 mt-4">
                  <div class="list-group">
                    <li class="list-group-item "><i class="fas fa-users"></i> Latest Registered Coaches</li>
                    <?php 

                      $numUCoaches = 5; //number of latest users 

                      $query = "SELECT * FROM users WHERE userStatus = 2 ORDER BY id DESC LIMIT $numUCoaches";

                      $result = mysqli_query($con, $query);

                      while(  $Latest_item = mysqli_fetch_array($result) ) { ?>

                    <li class="list-group-item ">
                      <a href="profile.php?do=show-profile&id=<?php echo $Latest_item['id'] ?>">
                        <?php echo $Latest_item['username']; ?>
                      </a>
                      <a href="coach-list.php?do=Edit&id=<?php echo $Latest_item['id'] ?>">
                        <span class="btn btn-primary btn-sm float-right">
                          <i class="fa fa-edit"></i>
                        </span> 
                      </a>
                    </li>   
                    
                    
                    <?php }?>
                    
                  </div>
                </div>  <!-- end of col-md-6 -->
              </div>  <!-- end of row -->
            </div>  <!-- end of content -->
          </div>  <!-- end of latest -->
        </div> <!-- end of content wrapper -->

       


<?php 

}else{

  header('location: ../login.php');

}

?>           
          
<?php include "includes/templates/footer.php";

 ob_end_flush(); //release the output 

?>