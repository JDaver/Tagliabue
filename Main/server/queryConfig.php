<?php
include_once "connection.php";



$sql_stock = $connection->query("SELECT * FROM articoli where stock<10 ORDER BY stock ASC");



$ricerca = "";
$type = "ean";





//main query
$defaultQuery="SELECT * FROM articoli";
if(isset($_POST['cerca'])){
    $type=$_POST['type'];
    if(!empty($_POST['ricerca'])){
        $ricerca = $_POST['ricerca'];
        $defaultQuery = "SELECT * FROM articoli WHERE $type LIKE '%$ricerca%'";
    }
}




    //receipt query
    
if(empty($_POST['data'])){
    $data = date('Y-m-d');
}else{
    $data=$_POST['data'];
}

$queryReceipt="SELECT * FROM receipt  WHERE data_fattura <= '". $data."' ORDER BY data_fattura DESC";

$ordine = $ordine ?? '';
if(!empty($_POST['ordine'])){
    $ordine = $_POST['ordine'];
    $queryReceipt = "SELECT * FROM receipt  WHERE data_fattura <= '". $data ."' ORDER BY tot_fattura ". $ordine ;
}else{
    
    $queryReceipt="SELECT * FROM receipt  WHERE data_fattura <= '". $data."' ORDER BY data_fattura DESC";
}

if(isset($_POST['default'])){
    $ordine = '';
    $queryReceipt="SELECT * FROM receipt ORDER BY data_fattura DESC";
    $data=date('Y-m-d');
    }
?>