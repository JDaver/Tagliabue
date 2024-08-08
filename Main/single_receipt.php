<?php  
    include_once "server/connection.php";
    $id_scontrino = $_GET['id_scontrino'];
//costruzione della query

$query= "SELECT receipt_articolo.quantita_articolo,articoli.ean,articoli.descrizione,articoli.prezzoVendita,receipt.data_fattura,receipt.tot_fattura
FROM articoli
INNER JOIN receipt_articolo ON receipt_articolo.ean = articoli.ean
INNER JOIN receipt ON receipt.id_scontrino = receipt_articolo.id_scontrino WHERE receipt_articolo.id_scontrino = ". $id_scontrino;

$result_innerjoin=$connection->query($query)


    
?>
 <?php include_once "server/header.php";?> 
<!DOCTYPE html>

<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Scontrino numero <?php echo $id_scontrino;?></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="style/style.css">
    </head>
    <body>
        <div>
            <h2>Articoli presenti nello scontrino numero <?php echo $id_scontrino;?>: </h2>
        </div>

        <div>
            <table class="styled-table">
                <thead> 
                    <tr>
                        <th>Quantita` articolo</th>  
                        <th>Codice EAN articolo</th> 
                        <th>Descrizione</th>
                        <th>Prezzo</th>
                        <th>Data emissione</th>
                    </tr>
                </thead>
                <tbody>
                        <?php 
                        if($result_innerjoin->num_rows>0){
                            
                            while($row=$result_innerjoin->fetch_assoc()){
                                $totale = $row['tot_fattura'];
                                echo "<tr>";
                                echo "<th>".$row['quantita_articolo']."</th>";
                                echo "<th>".$row['ean']."</th>";
                                echo "<th>".$row['descrizione']."</th>";
                                echo "<th>".$row['prezzoVendita']."</th>";
                                echo "<th>".$row['data_fattura']."</th>";
                                echo "<tr>";
                            }
                        }
                        
                        ?>
                

                </tbody>
                <tfoot>
                
                    <tr>
                        
                        <td colspan="3">Totale dello scontrino    <?php echo $totale?> $</td>
                    </tr>
        </tfoot>
            </table>
        </div>
        
      
        
        <script src="" async defer></script>
    </body>
</html>


