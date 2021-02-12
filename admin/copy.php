<?php 

 ob_start(); //output buffering start

 session_start();

 $pageTitle='Categories';

 if(isset($_SESSION['Username'])){

    include "init.php";

    $do=isset($_GET['do'])? $_GET['do'] : 'Manage';

    if($do=='Manage'){



    }

    elseif($do=='Add'){



    }

    elseif($do=='Insert'){ 

        

    }

    elseif($do=='Edit'){ 



    }

    elseif($do == 'Update'){



    }

    elseif( $do == 'Delete'){



    }

    elseif($do == 'Activate'){



    }


    include $tpl . 'footer.php';

}else{ //if user try directly to go to dashboard

        header("location: index.php");
        exit();
    }
   
 ob_end_flush(); //release the output

?>