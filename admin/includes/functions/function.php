<?php

//function to get number of a item from a table
function countItem($item,$table,$userStatus = NULL){

global $con;

$query = "SELECT $item FROM $table";

if($userStatus != NULL){

    $query = "SELECT $item FROM $table WHERE userStatus = $userStatus";

}


$result = mysqli_query($con, $query);

$count = mysqli_num_rows($result);
 
return $count;

}

//get latest record function
//get the latest items from database [ user , coach , class ]
//$select = field to select 
//$table = table to choose from
//$order = order them according to $order 
//$limit = number of record to get

function getLatest($select, $table, $order, $limit=5) {

    global $con;

    $query = "SELECT $select FROM $table ORDER BY $order DESC LIMIT $limit ";

    $result = mysqli_query($con,$query);
    
    if (!$result) {
        printf("Error: %s\n", mysqli_error($con));
        exit();
    }
    $rows =  mysqli_fetch_array($result);

    return $rows;

}
