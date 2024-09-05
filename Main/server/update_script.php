<?php
include_once "connection.php";

if(isset($_POST['invio'])){
    $ean = $_POST['ean'];
    $descrizione = $_POST['descrizione'];
    $marca = $_POST['marca'];
    $stock = $_POST['stock'];
    $prezzoVendita =$_POST['prezzoVendita'];
    $prezzoAcquisto = $_POST['prezzoAcquisto'];

    $query = "UPDATE articoli SET descrizione = '$descrizione', marca = '$marca', stock = $stock, prezzoVendita = '$prezzoVendita',prezzoAcquisto = '$prezzoAcquisto' WHERE ean ='$ean'";
    $connection->query($query);
    if($connection->query($query)){
        echo "<script>
        alert('Articolo modificato con successo');
        window.location.href = '../index.php';
        </script>";
    }else{
        echo "<script>
        alert('Errore nella modifica: \n Parametri non applicati.');
        window.location.href = './updateitem.php';
        </script>";
    }
    
}
?>