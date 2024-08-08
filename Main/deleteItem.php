<?php
include_once "server/connection.php";
$ean = $_GET['item_to_delete'];
$query_delete = "DELETE FROM articoli WHERE ean = '".$ean."'";
$query_select="SELECT * FROM articoli WHERE ean ='".$ean."'";
$query_check="SELECT * FROM receipt_articolo WHERE ean ='".$ean."'";

$result = $connection->query($query_select);
$result_arr = $result->fetch_assoc();

$result_check=$connection->query($query_check);


?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Eliminazione articolo</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="style/style.css">
    </head>
    <body>
       <?php include_once "server/header.php"; ?>
        <div class="titleReceipt">
        <h1>Sei sicuro di voler eliminare il seguente articolo? </h1> <br>
        <h2>  Operazione Irreversibile</h2>
        </div>
       
       <table class="styled-table">
            <thead>
                <tr>
                    <th>Codice Ean </th>
                    <th>Descrizione </th>
                    <th>Stock </th>
                    <th>Marca </th>
                </tr>
            </thead>

            <tbody>
                <tr>
                <?php
                  echo "<td>".$result_arr['ean']."</td>";
                  echo "<td>".$result_arr['descrizione']."</td>";
                  echo "<td>".$result_arr['stock']."</td>";
                  echo "<td>".$result_arr['marca']."</td>";
                ?>
                </tr>
            </tbody>
       </table> 
       

       <div class="search-container">
        <?php
        
        if($result_check->num_rows==0){
            echo "<form action='' method='post'>";
            echo "<button type='submit' name='true'> Conferma </button>";
            echo "</form>";
           
            if(isset($_POST['true'])){
                if($connection->query($query_delete)){
                    echo "<script>
                    alert('Articolo eliminato definitivamente!');
                    window.location.href = 'index.php';
                    </script>";
                }
                
            }
        }else{
            echo "   <h2>Attenzione! L'articolo risulta collegato ad uno o piu` scontrini, Impossibile eliminare il record </h2>";
            }
        ?>
       
       <br><br> <button><a href="index.php">Torna alla Home</a></button>
        </div>
    
        
        <script src="" async defer>
        </script>
    </body>
</html>