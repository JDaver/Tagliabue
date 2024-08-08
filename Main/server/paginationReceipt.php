<?php 
include_once "connection.php";
include_once "queryConfig.php";

$sql_receipt = $connection->query($queryReceipt);

$current_page_rec = 0;
 if(isset($_POST['val'])){
    $current_page_rec = intval($_POST['val']);
   
}else{
    $current_page_rec=1;
    
}



$result_per_page=12;
$numrows_receipt=$sql_receipt->num_rows;
$receipt_per_page = ($current_page_rec -1) * $result_per_page;

 // query receipt
$total_pages_receipt = ceil($numrows_receipt/$result_per_page);
$receipt_query = $queryReceipt." LIMIT $receipt_per_page, $result_per_page"; 

$statement = $connection->query($receipt_query);


if($statement->num_rows>0){
    $array_statement = array();

    while($row = $statement->fetch_assoc()){
        $array_statement[]=$row;
    }

    $json_statement = json_encode($array_statement);
    echo $json_statement; 
}else{
    echo "InternalError";
}
?>