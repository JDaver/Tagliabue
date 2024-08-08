<?php
include_once "server/connection.php";
$ean = $_GET['ean'];
$result = $connection->query("SELECT * FROM articoli WHERE ean ='".$ean."'");
$result_array= $result->fetch_assoc();

$stock = (int)$result_array['stock'];
?>

<!DOCTYPE html>

<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Modifica Articolo</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="style/style.css">
    </head>
    <body>

    <?php include_once "server/header.php"?>
        <h2 class="titleReceipt">Modifica l'articolo: <?php echo $ean; ?> </h2>

        <div class="formContainer">

        
        <form action="server/update_script.php" method="post" class="search-container">
        <input type="hidden" name="ean" value="<?php echo $result_array['ean'] ?>">

        <label for="">Descrizione</label>
        <input type="text" name="descrizione" value="<?php echo $result_array['descrizione']; ?>">

        <label for="">stock</label>
        <input type="number" step="1" min="0" max="999" name="stock" value="<?php echo $stock;?>" placeholder=" <?php echo $stock; ?>">

        <label for="">Prezzo di Vendita</label>
        <input type="number" step="0.01" min="0" max="999" name="prezzoVendita"  value="<?php echo $result_array['prezzoVendita']; ?>" placeholder="<?php echo $result_array['prezzoVendita']; ?>">

        <label for="">prezzo di acquisto</label>
        <input type="number" step="0.01" min="0" max="999" name="prezzoAcquisto" value="<?php echo $result_array['prezzoAcquisto']; ?>" placeholder="<?php echo $result_array['prezzoAcquisto']; ?>">

        <label for="">Marca</label>
        <input type="text" name="marca" value="<?php echo $result_array['marca']; ?>">

        <button type="submit" name="invio">Modifica l'articolo</button>
        
        </form>
        <div class="search-container">
        <button ><a href="index.php">Torna alla Home</a></button>

        </div>
        
        </div>
        <script src="" async defer></script>
    </body>
</html>