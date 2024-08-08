<?php
include_once "connection.php";
include "queryConfig.php";



$sql_default = $connection->query($defaultQuery);

$current_page = 0;
 if(isset($_POST['val'])){
    $current_page = intval($_POST['val']);
   
}else{
    $current_page=1;
    
}



$result_per_page=12;
$numrows_articoli=$sql_default->num_rows;
$items_per_page = ($current_page -1) * $result_per_page;



// query per gli articoli default
$total_pages_default = ceil($numrows_articoli/$result_per_page);
$main_query= $defaultQuery." LIMIT $items_per_page, $result_per_page";




$statement = $connection->query($main_query);


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