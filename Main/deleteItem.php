<?php
include_once "server/connection.php";
$ean = $_GET['item_to_delete'];
$query_delete = "DELETE FROM articoli WHERE ean = '" . $ean . "'";
$query_select = "SELECT * FROM articoli WHERE ean ='" . $ean . "'";
$query_check = "SELECT * FROM receipt_articolo WHERE ean ='" . $ean . "'";

$result = $connection->query($query_select);
$result_arr = $result->fetch_assoc();

$result_check = $connection->query($query_check);


?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Eliminazione articolo</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style/style.css">
</head>

<body>
    <?php include_once "server/header.php"; ?>
    <main class="mb">
        <h1 class="title">Sei sicuro di voler eliminare il seguente articolo? <br> Operazione Irreversibile </h1>
        <div class="form">
            <?php

            if ($result_check->num_rows == 0) {
                echo "<form action='' method='post'>";
                echo "<div class='subtitle'><button class='confirm-btn' type='submit' name='true'> Conferma </button></div>";
                echo "</form>";

                if (isset($_POST['true'])) {
                    if ($connection->query($query_delete)) {
                        echo "<script>
                        alert('Articolo eliminato definitivamente!');
                        window.location.href = 'index.php';
                        </script>";
                    }
                }
            } else {
                echo "<h2 class='subtitle'>Attenzione! L'articolo risulta collegato ad uno o piu` scontrini, Impossibile eliminare il record </h2>";
            }
            ?>
        </div>
        <table class="table">
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
                    echo "<td>" . $result_arr['ean'] . "</td>";
                    echo "<td>" . $result_arr['descrizione'] . "</td>";
                    echo "<td>" . $result_arr['stock'] . "</td>";
                    echo "<td>" . $result_arr['marca'] . "</td>";
                    ?>
                </tr>
            </tbody>
        </table>
        <div class="btns-wrapper">
            <button class="back-btn"><a href="index.php">Torna alla Home</a></button>
        </div>
    </main>





    <script src="" async defer>
    </script>
</body>

</html>