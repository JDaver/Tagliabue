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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style/style.css">
</head>

<body>

    <?php include_once "server/header.php"; ?>
    <h2 class="title">Aggiungi Nuovo Articolo</h2>
    <main class="mb">
        <form action="createItem.php" method="post" class="form">
            <div class="flex">
                <div class="col">
                    <div class="col gap-sm">
                        <label for="descrizione">Nome dell'articolo</label>
                        <input class="form__input" id="descrizione" type="text" name="descrizione">
                    </div>
                    <div class="col gap-sm">
                        <label for="stock">Quantità in stock</label>
                        <input class="form__input" id="stock" type="number" step="1" min="0" max="999" name="stock">
                    </div>
                    <div class="col gap-sm">
                        <label for="marca">Marca</label>
                        <input class="form__input" id="marca" type="text" name="marca">
                    </div>
                </div>
                <div class="col">
                    <div class="col gap-sm">
                        <label for="prezzoAcquisto">Prezzo d'acquisto</label>
                        <input class="form__input" id="prezzoAcquisto" type="number" name="prezzoAcquisto" step="0.01" min="0.00" max="9999.99">
                    </div>
                    <div class="col gap-sm">
                        <label for="prezzoVendita">Prezzo di vendita</label>
                        <input class="form__input" id="prezzoVendita" type="number" name="prezzoVendita" step="0.01" min="0.00" max="9999.99">
                    </div>
                    <div class="col gap-sm">
                        <label for="ean">Codice EAN</label>
                        <input class="form__input" id="ean" type="text" name="ean">
                    </div>
                </div>
            </div>
            <div class="btns-wrapper">
                <button class="confirm-btn" type="submit" name="create_item_submit">Aggiungi</button>
            </div>
        </form>
    </main>

    <div>

        <?php
        include_once 'server/create.php';
        ?>
    </div>

    <script src="" async defer></script>
</body>

</html>