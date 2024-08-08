<?php
    include_once "server/connection.php"
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="style/style.css">
    </head>
    <body>

    <?php include_once "server/header.php";?> 
        <h2 class="titleReceipt">Aggiungi Articolo al database</h2>

        <div class="formContainer">
        <form action="createItem.php" method="post" class="search-container">

            

            <label for="">Inserisci il nome dell'articolo</label>
            <input type="text" name="descrizione"> <br><br>

            <label for="">Inserisci la quantita' in stock dell'articolo</label>
            <input type="number" step="1" min="0" max="999" name="stock"> <br><br>

            <label for="">Inserisci la marca dell'articolo</label>
            <input type="text" name="marca"> <br><br>
            

            <label for="prezzo">Prezzo di acquisto del prodotto:</label>
            <input type="number" name="prezzoAcquisto" step="0.01" min="0.00" max="9999.99"> <br> <br>

            <label for="prezzo">Prezzo di vendita:</label>
            <input type="number" name="prezzoVendita" step="0.01" min="0.00" max="9999.99"> <br><br>

            <label for="">Inserisci il codice ean</label>
            <input type="text" name="ean">  <br><br>

            
            <button type="submit" name="create_item_submit" >Aggiungi l'articolo</button>

        </form>
        </div>

        <div>
            
            <?php
                include_once 'server/create.php';
            ?>
        </div>
        
        <script src="" async defer></script>
    </body>
</html>