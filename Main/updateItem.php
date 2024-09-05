<?php
include_once "server/connection.php";
$ean = $_GET['ean'];
$result = $connection->query("SELECT * FROM articoli WHERE ean ='" . $ean . "'");
$result_array = $result->fetch_assoc();

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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style/style.css">
</head>

<body>

    <?php include_once "server/header.php" ?>

    <main class="mb">
        <h2 class="title">Articolo: <?php echo $ean; ?> </h2>
        <form action="server/update_script.php" method="post" class="form">
            <div class="flex">
                <div class="col">
                    <div class="col gap-sm">
                        <label for="descrizione">Descrizione</label>
                        <input class="form__input" id="descrizione" type="text" name="descrizione" value="<?php echo $result_array['descrizione']; ?>">
                    </div>
                    <div class="col gap-sm">
                        <label for="marca">Marca</label>
                        <input class="form__input" id="marca" type="text" name="marca" value="<?php echo $result_array['marca']; ?>">
                    </div>
                    <div class="col gap-sm">
                        <label for="stock">Stock</label>
                        <input class="form__input" id="stock" type="number" step="1" min="0" max="999" name="stock" value="<?php echo $stock; ?>" placeholder=" <?php echo $stock; ?>">
                    </div>
                </div>
                <div class="col">
                    <div class="col gap-sm">
                        <label for="prezzoVendita">Prezzo di Vendita</label>
                        <input class="form__input" id="prezzoVendita" type="number" step="0.01" min="0" max="999" name="prezzoVendita" value="<?php echo $result_array['prezzoVendita']; ?>" placeholder="<?php echo $result_array['prezzoVendita']; ?>">
                    </div>
                    <div class="col gap-sm">
                        <label for="prezzoAcquisto">Prezzo di Acquisto</label>
                        <input class="form__input" id="prezzoAcquisto" type="number" step="0.01" min="0" max="999" name="prezzoAcquisto" value="<?php echo $result_array['prezzoAcquisto']; ?>" placeholder="<?php echo $result_array['prezzoAcquisto']; ?>">
                    </div>
                    <div class="col gap-sm">
                        <label for="ean">Codice EAN</label>
                        <input class="form__input" disabled id="ean" type="text" name="ean" value="<?php echo $result_array['ean'] ?>">
                        <input type="hidden" name='ean' value="<?php echo $result_array['ean'] ?>">
                    </div>
                </div>
            </div>
            <div class="btns-wrapper gap-lg">
                <button class="back-btn"><a href="index.php">Torna alla Home</a></button>
                <button class="confirm-btn" type="submit" name="invio">Modifica</button>
            </div>
        </form>
    </main>
    <script src="" async defer></script>
</body>

</html>