<?php
include_once "server/connection.php";
?>


<!DOCTYPE html>

<html>

<head>
    <div style="display:none">
        <?php include_once "server/pagination.php";
        include_once "server/queryConfig.php"; ?>
    </div>
    <meta charset="utf-8">
    <title>Tagliabue</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style/style.css">
    <script src="index.js" defer></script>
</head>


<body>
    <div class="header__wrapper">
        <?php include_once "server/header.php"; ?>
        <form action="index.php" method="post" class="search-form">
            <div class="search">
                <div class="row mr-auto">
                    <label class="select__label" for="type">Filtra per</label>
                    <select class="select" name="type" id="type">
                        <option value="ean" <?php if ($type === 'ean') echo 'selected'; ?>>Codice EAN</option>
                        <option value="descrizione" <?php if ($type === 'descrizione') echo 'selected'; ?>>Descrizione</option>
                        <option value="marca" <?php if ($type === 'marca') echo 'selected'; ?>>Marca</option>
                    </select>
                </div>
                <div class="col gap-sm">
                    <label class="select__label" for="type">Cerca un articolo</label>
                    <input class="header__input" type="text" name="ricerca" value="<?php echo $ricerca; ?>">
                </div>
            </div>
            <button class="search__btn" type="submit" name="cerca">Cerca</button>
        </form>
    </div>


    <div class="tab__wrapper">
        <ul class="tab">
            <li class="tab__btn active">ARTICOLI</li>
            <li class="tab__btn">IN ESAURIMENTO</li>
        </ul>
    </div>
    <main class="mb">
        <div class="content">
            <div id="response"></div>
            <div class="btns-wrapper"></div>
        </div>
        <div class="content hidden">
            <?php include_once "server/tableStock_query.php"; ?>
        </div>
    </main>

    <script>
        sendPage(<?php echo $current_page . ",'" . $ricerca . "'" ?>);

        function sendPage(data_value, searchString) {
            const numero_pagina = data_value || 1;
            let total_pages_default = <?php echo $total_pages_default ?>;

            //console.log(valore, searchString);
            let xhr = new XMLHttpRequest();

            xhr.open('POST', 'server/pagination.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        // Richiesta completata con successo, puoi gestire la risposta qui
                        console.log('Dati trasmessi con successo!');

                    } else {
                        // Si è verificato un errore durante la richiesta
                        console.error('Errore durante la trasmissione dei dati:', xhr.status);
                    }
                }
            };

            xhr.onload = function() {
                let table = '<table class="table"><thead><tr><th>Codice Ean </th><th>Descrizione </th><th>Stock </th><th>Marca </th><th>Prezzo di acquisto </th><th>Prezzo al cliente</th><th></th><th></th></tr></thead><tbody>';
                const json_response = this.responseText;

                if (json_response == "InternalError") {
                    table += "<td>Nessun Record Trovato</td>"
                } else {
                    const dates = JSON.parse(json_response);
                    for (let i = 0; i < dates.length; i++) {
                        table += '<tr>';
                        table += '<td>' + dates[i].ean + '</td>';
                        table += '<td>' + dates[i].descrizione + '</td>';
                        table += '<td>' + dates[i].stock + '</td>';
                        table += '<td>' + dates[i].marca + '</td>';
                        table += '<td>' + dates[i].prezzoAcquisto + '  €</td>';
                        table += '<td>' + dates[i].prezzoVendita + '  €</td>';
                        table += "<td> <a href='updateItem.php?ean=" + dates[i].ean + "'><img class='table__icon' src='images/mod_logo.png'></a></td>";
                        table += "<td> <a href='deleteItem.php?item_to_delete=" + dates[i].ean + "'><img class='table__icon' src='images/red_cross.png'></a></td>";
                        table += '</tr>';
                    }

                    //BUTTON 
                    outputBTN = "<button class='page-btn' onclick='sendPage(1,\"" + searchString + "\")'>Primo</button>";

                    for (i = 1; i <= total_pages_default; i++) {
                        if (total_pages_default > 10) {
                            if ((i >= data_value - 2) && (i <= data_value + 2)) {
                                outputBTN += "<button class='page-btn' onclick='sendPage(" + i + ",\"" + searchString + "\")'>" + i + "</button>";
                            }
                        } else {
                            outputBTN += "<button class='page-btn' onclick='sendPage(" + i + ",\"" + searchString + "\")'>" + i + "</button>";
                        }
                    }
                    outputBTN += "<button class='page-btn' onclick='sendPage(" + total_pages_default + ",\"" + searchString + "\")'>Ultimo</button>";
                }

                table += '</tbody></table>';
                document.getElementById('response').innerHTML = table;
                document.querySelector('.btns-wrapper').innerHTML = outputBTN;
            }


            // Dati da inviare
            let dati = "val=" + numero_pagina;
            let ricerca = "ricerca=" + searchString;


            const parameters = [dati];

            if (searchString) {

                let type = "type=" + document.getElementById('type').value;
                parameters.push(ricerca, 'cerca=1', type);
            }

            // Invio della richiesta con i dati
            xhr.send(parameters.join('&'));
        }
    </script>
</body>

</html>