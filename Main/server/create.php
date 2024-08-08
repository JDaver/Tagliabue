<?php
include_once 'connection.php';

if(isset($_POST['create_item_submit'])){

    if(empty($_POST['descrizione'])||empty($_POST['ean'])||empty($_POST['marca'])){
        echo "<script>
        alert('Riempi tutti i campi!');
        window.location.href = './createItem.php';
        </script>";
    }else{



    
    $descrizione = $_POST['descrizione'];
    $ean = $_POST['ean'];
    $stock = $_POST['stock'];
    $marca = $_POST['marca'];
    $prezzoAcquisto = $_POST['prezzoAcquisto'];
    $prezzoVendita = $_POST['prezzoVendita'];

    //controllo preliminare 

    if($stock==0){
        echo "<script>
        alert('Articolo Inserito: Hai assegnato un valore di stock 0');
        </script>";
    }
    $checkEAN=$connection->query("SELECT ean FROM articoli WHERE ean LIKE '".$ean."'");
    if($checkEAN->num_rows>0){
        echo "<script>
        alert('Attenzione! codice EAN gia` presente nel Database.');
        window.location.href = './createItem.php';
        </script>";
    }

        $insertQuery="INSERT INTO articoli (descrizione,prezzoAcquisto,prezzoVendita,stock,ean,marca) VALUES('$descrizione','$prezzoAcquisto','$prezzoVendita','$stock','$ean','$marca');";
        //$connection->query($insertQuery);
        if(mysqli_query($connection,$insertQuery)){
            echo "<script>
        alert('Articolo inserito correttamente nel databse');
        window.location.href = './index.php';
        </script>";
        }else{
            echo "Errore nell'inserimento, Riprovare...";
        }
    }

}
   

?>