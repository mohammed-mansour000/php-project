<?php 

ob_start(); //output buffering start

session_start();

?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Fitness Club</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.2 -->
    <!-- <link href="bootstrap.min.css" rel="stylesheet" type="text/css" />  --> 
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <!-- FontAwesome 4.3.0 -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Ionicons 2.0.0 -->
    <link href="http://code.ionicframework.com/ionicons/2.0.0/css/ionicons.min.css" rel="stylesheet" type="text/css" />    
    <!-- Theme style -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Acme&family=Cairo&display=swap" rel="stylesheet">
    <link href="admin/layout/css/style.css" rel="stylesheet" type="text/css" />
    
    
   

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
<div class="row">
  <div class="col-12">
    
<form class="login-form" action="admin/server.php" method="POST">
    <div class="login-head">
      <h3 class="h1 text-center">SIGN UP</h3>
    </div>  
    <div class="login-body">
    <?php

    //the form errors
    if(!empty($_SESSION['testErrors'])){
        foreach($_SESSION['testErrors'] as $msg){
            echo "<div class='alert alert-danger'>";
                echo $msg;
                echo "<button type='button' class='close' data-dismiss='alert' aria-label='Close'>";
                    echo "<span aria-hidden='true'>&times;</span>";
                echo "</button>";
            echo "</div>";
            $_SESSION['testErrors'] = '';
      }
    }

    //the insertion error
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
      <div class="form-group has-success has-feedback">
        <input type="text" id="inputSuccess" class="form-control" name="username" placeholder="Username"/>
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>
      <div class="form-group has-error has-feedback">
        <input type="password" id="disabledTextInput" class="form-control" name="password" placeholder="Password"/>
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="form-group has-error has-feedback">
        <input type="password" id="disabledTextInput" class="form-control" name="confirm-password" placeholder="Confirm Password"/>
        <span class="glyphicon glyphicon-ok-sign form-control-feedback"></span>
      </div>
      <div class="form-group has-success has-feedback">
        <input type="text" id="disabledTextInput" class="form-control" name="email" placeholder="Email"/>
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <input type="submit" class="btn btn-primary btn-block" placeholder="signup" name="signup" />
      <p class="go-sign-up">Already Have Account? <span><a href="login.php"> Click Here</a></span></p>
    </div>
</form>
  </div>
</div>


<script src="admin/layout/js/jQuery-2.1.3.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>


<?php  ob_end_flush(); //release the output ?>