<?php

function countItem($item,$table){

global $conn;

$stmt2= $conn->prepare("SELECT COUNT($item) FROM $table");

$stmt2->execute();

return $stmt2->fetchColumn();

}