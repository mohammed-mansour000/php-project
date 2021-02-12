<?php

require "connection.php"; 

session_start();

//declare array error containing input errors
$errors = array();

//for login 
if(isset($_POST['login'])){  
    
    
    $username = $_POST['username']; //take input value
    $password = $_POST['password']; //take input value

    $query = "SELECT * FROM users where username='$username' and password='$password'";
    $result = mysqli_query($con,$query);
    $row = mysqli_num_rows($result); // if username and password is valid row will be added 
    $rows = mysqli_fetch_array($result);
    
    if($row>0){
        if($rows['userStatus'] == 1){
            header("location: dashboard.php");
            $_SESSION['username'] = $username;
            $_SESSION['userStatus'] = 1;
            $_SESSION['userID'] = $rows['id'];
            $_SESSION['msg'] = "<script>alert('you logined successfully')</script>";
        }else{
            header("location: ../index.php");
            $_SESSION['username'] = $username;
            $_SESSION['userStatus'] = 0;
            $_SESSION['userID'] = $rows['id'];
            $_SESSION['msg'] = "<script>alert('you logined successfully')</script>";
        }
    }else{
        header("location: ../login.php");
        $_SESSION['msg'] = "Invalid Username or Password";
        
    }
}
    

/* for signup */
if(isset($_POST['signup'])){

    //prepare sessions
    $_SESSION['testErrors'] = array();

    //get all the input fields
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm-password'];
    $email = $_POST['email'];
    $confirm_password = $_POST['confirm-password'];

    //fill the errors if error found
    if(empty($username)){

        $_SESSION['testErrors'][]='Username Cant Be <strong>Empty</strong>';

    }

    if(empty($email)){

        $_SESSION['testErrors'][]='Email Cant Be <strong>Empty</strong>';

    }

    if(empty($password) && empty($confirm_password)){

        $_SESSION['testErrors'][]='Password Cant Be <strong>Empty</strong>';

    }

    if($password != $confirm_password){
        $_SESSION['testErrors'][]="Password doesn't  <strong>Match</strong>";
    }

    //if no error then insert the user
    if(empty($_SESSION['testErrors'])){

        $query = "INSERT INTO users(username,password,email,userStatus,date) 
                VALUES('$username', '$password', '$email' ,0 , now())";
        $result = mysqli_query($con,$query);

        if($result == 1){ //msg if inserted normally
            $query2 = "SELECT * FROM users where username='$username' and password='$password'";
            $result2=mysqli_query($con,$query2);
            $rows = mysqli_fetch_array($result2);
            $_SESSION['msg'] = "<script>alert('you logined successfully')</script>";
            $_SESSION['userStatus'] = 0;
            $_SESSION['userID'] = $rows['id'];
            $_SESSION['username'] = $username;
            header("location: ../index.php");

        }else{ // msg if error occured
            
            //echo "Error: " . $query . "<br>" . mysqli_error($con);
            $_SESSION['error'] = "SignUp Failed";
            header("location: ../signup.php");
            
        }

    }else{

        header('location: ../signup.php');

    }
    
}


// for add user    
/* if(isset($_POST['add_user'])){  
    
    
    $username = $_POST['username']; //take input value
    $password = $_POST['password']; //take input value
    $email = $_POST['email']; //take input value
    $confirm_password = $_POST['confirm-password']; //take input value

    if($password != $confirm_password){
        $errors[] = "password doesn't match";
        $errors[] = "passwoasdfaawrfw";
    }

    if(empty($errors)){

    
        $query = "INSERT INTO users(username,password,email,userStatus,date) 
        VALUES('$username', '$password', '$email' ,0 , now())";
        $result = mysqli_query($con,$query);

        if($result == 1){
            header("location:add-user.php");
            $_SESSION['msg'] = "<script>alert('user inserted successfully')</script>";
        }else{
            header("location:add-user.php");
            $_SESSION['msg'] = "user insertion failed";
            
        }
    } *//* else{
        foreach($errors as $error){
            $_SESSION['msg'] = array();
             array_push($_SESSION['msg'] , $error);
        }
        header("location:add-user.php");
    } *//* else{
        header("location:add-user.php");
    }
} */