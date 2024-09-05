<?php 
    $server = 'localhost';
    $admin = 'root';
    $password = '';
    $db = 'tagliabue';
    
    $connection  = mysqli_connect($server,$admin,$password,$db);

    if(!$connection){
        echo 'connection error '.mysqli_connect_error();
    } 

    ?>