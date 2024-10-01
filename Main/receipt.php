<?php

include_once 'server/connection.php';
$messagedisplay = '';
$risultati_array = array();
session_start();
error_reporting(E_ALL);
ini_set('display_errors', true);

//Aggiunta di elementi al carrello
if (!isset($_SESSION['name'])) {

    header('Location: server/warning.php');
}

if (!isset($_SESSION['carrello'])) {
    $_SESSION['carrello'] = array();
}

if (isset($_POST['insItem'])) {
    $ean = $_POST['eanItem'];
    $numero = $_POST['numero'];


    $result = $connection->query("SELECT descrizione,prezzoVendita FROM articoli WHERE ean = '$ean'");
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $descrizione = $row['descrizione'];
        $prezzo = $row['prezzoVendita'];

        if (!isset($_SESSION['carrello'][$ean])) {
            $_SESSION['carrello'][$ean] = array(
                'ean' => $ean,
                'descrizione' => $descrizione,
                'prezzo' => $prezzo,
                'quantita' => $numero
            );
        } else {
            $_SESSION['carrello'][$ean]['quantita'] = (int)$numero;
        }
    } else {
        $messagedisplay =  "articolo non presente nel database";
    }
}


//funzione che restituisce il totale del carrello
function totale_carrello()
{
    $_SESSION['valore_scontrino'] = 0.00;
    global $_SESSION;

    foreach ($_SESSION['carrello'] as $index) {
        $value = $index['prezzo'];
        $quantiy = $index['quantita'];
        $_SESSION['valore_scontrino'] += (float)$value * (int)$quantiy;
    }
    return $_SESSION['valore_scontrino'];
}





//salvataggio dello scontrino sul database


if (isset($_POST['conclusion'])) {
    if (empty($_SESSION['carrello'])) {
        $messagedisplay = "Carrello vuoto, inserisci prima degli articoli";
    } else {
        $query_nuovo_scontrino = "INSERT INTO receipt (id_scontrino,tot_fattura,data_fattura) VALUES (" . $_SESSION['name'] . "," . totale_carrello() . ",NOW())";
        if ($connection->query($query_nuovo_scontrino)) {
            $messagedisplay = "<h3>Scontrino emesso Correttamente</h3>";
            //compilazione della tabella di join
            $query_nuovo_jointab = "INSERT INTO receipt_articolo (quantita_articolo,id_scontrino,ean) VALUES (?,?,?)";
            foreach ($_SESSION['carrello'] as $index) {

                $stmt_jointab = $connection->prepare($query_nuovo_jointab);
                $stmt_jointab->bind_param('iis', $index['quantita'], $_SESSION['name'], $index['ean']);
                $stmt_jointab->execute();
                $stmt_jointab->close();
            }
            foreach ($_SESSION['carrello'] as $index) {
                $query_verifica_stock = "SELECT stock from articoli WHERE ean = '" . $index['ean'] . "'";
                $result_verifica_stock = $connection->query($query_verifica_stock);
                if ($result_verifica_stock->num_rows > 0) {
                    $row = $result_verifica_stock->fetch_assoc();
                    $numero_stock = $row['stock'];
                }



                if ($numero_stock >= $index['quantita']) {
                    $query_mod_stock = "UPDATE articoli SET stock = stock - " . $index['quantita'] . " WHERE ean = '" . $index['ean'] . "'";
                } else {
                    $query_mod_stock = "UPDATE articoli SET stock = 0 WHERE ean = '" . $index['ean'] . "'";
                }
                $connection->query($query_mod_stock);
            }

            session_destroy();
            echo "<script>
        alert('Scontrino Emesso Correttamente!');
        window.location.href = 'index.php';
        </script>";
        } else {
            echo "<h3>Errore nell'emissione dello scontrino, perfavore riprovare!</h3>";
        }
    }
}

if (isset($_POST['delete'])) {
    session_destroy();
    header("location: server/receiptSession.php");
}
?>


<!DOCTYPE html>

<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Emissione scontrino</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style/style.css">
    <script src="index.js" defer></script>
</head>

<body>

    <?php include_once "server/header.php"; ?>

    <main class="mb">
        <div class="flex">
            <div class="col">
                <form action="receipt.php" method="post" class="form">
                    <div class="col gap-sm">
                        <label for="eanItem">Scannerizza l'articolo </label>
                        <input class="form__input" id="eanItem" type="text" name="eanItem">
                    </div>
                    <div class="col gap-sm">
                        <label for="numero">Inserisci la quantita</label>
                        <input class="form__input" type="number" id="numero" name="numero" min="1" max="100" value="1">
                    </div>
                    <div class="btns-wrapper gap-sm">
                        <button class="add-btn" type="submit" name="insItem">Aggiungi</button>
                        <button class="confirm-btn" type="submit" name="conclusion">Conferma</button>
                        <button class="delete-btn" type="submit" name="delete">Elimina</button>
                    </div>
                </form>
            </div>
            <div class="col scan-item">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Descrizione </th>
                            <th>Prezzo </th>
                            <th>Quantita`</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (!empty($_SESSION['carrello'])) {
                            foreach ($_SESSION['carrello'] as $value) {
                                echo "<tr>";
                                echo "<td>" . $value["descrizione"] . "</td>";
                                echo "<td>" . $value["prezzo"] . " €</td>";
                                echo "<td>" . $value["quantita"] . "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='4'>Ancora nessun articolo</td></tr>";
                        }
                        ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Subtotale Carrello </th>
                            <td colspan="4"><?php echo totale_carrello(); ?> €</td>
                        </tr>
                    </tfoot>
                </table>
                <div class="title receipt">
                    <?php echo "<h1>N. Scontrino: " . $_SESSION['name'] . "</h1>"; ?>
                </div>
            </div>
        </div>
    </main>
    <div>
        <h2><?php echo $messagedisplay; ?></h2>
    </div>
</body>

</html>