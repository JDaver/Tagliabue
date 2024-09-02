<?php
include_once 'connection.php';

session_start();
error_reporting(E_ALL);
ini_set('display_errors',true);

$stmt_id = $connection->query("SELECT id_scontrino FROM receipt ORDER BY id_scontrino DESC LIMIT 1");
if ($stmt_id->num_rows > 0) {
    // Output dei dati nelle celle della tabella
    while ($row = $stmt_id->fetch_assoc()) {
        $newReceipt = (int)$row['id_scontrino'] +1;
    }
}else{
    $newReceipt =1;
}
echo $newReceipt;
    $_SESSION['name']=$newReceipt;
if(isset($_SESSION['name'])){
header("Location: ../receipt.php");
exit();
}else{
header("Location: warning.php");
exit();
}

?>






