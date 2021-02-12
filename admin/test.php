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
    <link href="style.css" rel="stylesheet" type="text/css" />
    
    
   

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
  </head>
<body class="skin-purple">
<div class="wrapper">
  <header class="main-header">
    <!-- Logo -->
    <a href="dashboard.php" class="logo"><b>Fitness</b>Club</a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top" role="navigation">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
       
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              
              <img src="../images/" class="user-image" alt="User Image">
              <span class="hidden-xs">Ram Sign</span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
                       
              <li class="user-header">
                
                <img src="../images/" class="img-circle" alt="User Image">
                <p>
                   <!-- logged in user information -->

                   - Fitness Club 
                  <small>Member since Nov. 2020</small>
                </p>
              
              </li>
              <!-- Menu Body -->
             
              <li class="user-footer">
                <div class="pull-left">
                  <a href="profile.php" class="btn btn-default btn-flat">Profile</a>
                </div>
                <div class="pull-right">
                  <a href="#" onclick= "logout();" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header><aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar" style="height: auto;">
      <!-- Sidebar user panel -->
    <!--   <div class="user-panel">
        <div class="pull-center image">
          <img src="../dist/img/fitness-club-two.png" class="img-circle" alt="User Image">
        </div>
      
      </div> -->
       <img src="../dist/img/fitness-club-two.png" class="img-circle" alt="User Image" style="padding: 34px;">
      <!-- search form -->
      <!--<form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search..."/>
          <span class="input-group-btn">
            <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
          </span>
        </div>
      </form>-->
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu">
        <!-- <li class="header">MAIN NAVIGATION</li> -->
        <li class="active treeview">
          <a href="#">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span> <i class="fa fa-angle-left pull-right"></i>
          </a>
         <!--  <ul class="treeview-menu">
            <li class="active"><a href="index.html"><i class="fa fa-circle-o"></i> Dashboard v1</a></li>
            <li><a href="index2.html"><i class="fa fa-circle-o"></i> Dashboard v2</a></li>
          </ul> -->
        </li>
       <!--  <li class="treeview">
          <a href="#">
            <i class="fa fa-files-o"></i>
            <span>Layout Options</span>
            <span class="label label-primary pull-right">4</span>
          </a>
          <ul class="treeview-menu">
            <li><a href="pages/layout/top-nav.html"><i class="fa fa-circle-o"></i> Top Navigation</a></li>
            <li><a href="pages/layout/boxed.html"><i class="fa fa-circle-o"></i> Boxed</a></li>
            <li><a href="pages/layout/fixed.html"><i class="fa fa-circle-o"></i> Fixed</a></li>
            <li><a href="pages/layout/collapsed-sidebar.html"><i class="fa fa-circle-o"></i> Collapsed Sidebar</a></li>
          </ul>
        </li> -->
        <!-- <li>
          <a href="pages/widgets.html">
            <i class="fa fa-th"></i> <span>Widgets</span> <small class="label pull-right bg-green">new</small>
          </a>
        </li> -->
        <li class="treeview">
          <a href="#">
            <i class="fa fa-pie-chart"></i>
            <span>User</span>
            <i class="fa fa-angle-left pull-right"></i>
          </a>
          <ul class="treeview-menu">
            <li><a href="user-list.php"><i class="fa fa-circle-o"></i> User List</a></li>
            <li><a href="add-user.php"><i class="fa fa-circle-o"></i> Add User</a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-laptop"></i>
            <span>Packages</span>
            <i class="fa fa-angle-left pull-right"></i>
          </a>
          <ul class="treeview-menu">
            <li><a href="package-list.php"><i class="fa fa-circle-o"></i> Packages List</a></li>
            <li><a href="add-package.php"><i class="fa fa-circle-o"></i>Add Packages</a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-edit"></i> <span>Time Slots</span>
            <i class="fa fa-angle-left pull-right"></i>
          </a>
          <ul class="treeview-menu">
            <li><a href="timeslote-list.php"><i class="fa fa-circle-o"></i> Time Slots List</a></li>
            <li><a href="add-timeslote.php"><i class="fa fa-circle-o"></i> Add Time Slots</a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-table"></i> <span>Trainer</span>
            <i class="fa fa-angle-left pull-right"></i>
          </a>
          <ul class="treeview-menu">
            <li><a href="trainer-list.php"><i class="fa fa-circle-o"></i>Trainer List</a></li>
            <li><a href="add-trainer.php"><i class="fa fa-circle-o"></i>Add Trainer</a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-folder"></i> <span>Reports</span>
            <i class="fa fa-angle-left pull-right"></i>
          </a>
          <ul class="treeview-menu">
            <!-- <li><a href="user-invoice.php"><i class="fa fa-circle-o"></i> Invoice</a></li> -->
            <li><a href="report-list.php"><i class="fa fa-circle-o"></i> Report</a></li>
          </ul>
        </li>
     
        <li class="treeview">
          <a href="#">
            <i class="fa fa-share"></i> <span>Admin</span>
            <i class="fa fa-angle-left pull-right"></i>
          </a>
          <ul class="treeview-menu">
            <li><a href="profile.php"><i class="fa fa-circle-o"></i>Admin Profile</a></li>
          </ul>
        </li>
        <!-- <li><a href="documentation/index.html"><i class="fa fa-book"></i> Documentation</a></li> -->
        <!--<li class="header">LABELS</li>
        <li><a href="#"><i class="fa fa-circle-o text-danger"></i> Important</a></li>
        <li><a href="#"><i class="fa fa-circle-o text-warning"></i> Warning</a></li>
        <li><a href="#"><i class="fa fa-circle-o text-info"></i> Information</a></li>-->
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>




  <div class="content-wrapper">

    <div class="row">
      <div class="col-md-4 text-center alert alert-danger">lasjflakjflak</div>
      <div class="col-md-4 text-center alert alert-dark">lasjflakjflak</div>
      <div class="col-md-4 text-center alert alert-info">lasjflakjflak</div>
    </div>
    <div class="container">
      <div class="row">
        <div class="col-md-4 text-center alert alert-danger">lasjflakjflak</div>
        <div class="col-md-4 text-center alert alert-dark">lasjflakjflak</div>
        <div class="col-md-4 text-center alert alert-info">lasjflakjflak</div>
      </div>
    </div>
    
  </div>

</div> <!-- end of wrapper -->
<!-- jQuery 2.1.3 -->
<script src="jQuery-2.1.3.min.js"></script>
<!-- <script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ=" crossorigin="anonymous"></script>

<script src="http://code.jquery.com/ui/1.11.2/jquery-ui.min.js" type="text/javascript"></script> -->
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> -->

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<!-- <script src="http://code.jquery.com/ui/1.11.2/jquery-ui.min.js" type="text/javascript"></script>
<script src="jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="dashboard.js" type="text/javascript"></script>
<script src="dashboard2.js " type="text/javascript"></script> -->
<script src="app.js" type="text/javascript"></script> 
  </body>
</html>   