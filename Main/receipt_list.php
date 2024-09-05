<?php
include_once "server/connection.php";








?>

<!DOCTYPE html>

<html>

<head>
    <div style="display:none">
        <?php include_once "server/paginationReceipt.php";
        include_once "server/queryConfig.php"; ?>
    </div>
    <meta charset="utf-8">
    <title>Elenco Scontrini</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style/style.css">
</head>

<body>
    <?php include_once "server/header.php"; ?>

    <div class="container">
        <form action="receipt_list.php" method="post" class="form">
            <div class="flex">
                <div class="col">
                    <div class="row space-between">
                        <label for="ordine">Ordina per</label>
                        <select class="order-select" name="ordine" id="ordine">
                            <option value="DESC" <?php if ($ordine == 'DESC') echo 'selected'; ?>>Totale Decrescente</option>
                            <option value="ASC" <?php if ($ordine == 'ASC') echo 'selected'; ?>>Totale Crescente</option>
                            <option value="" style="display: none;" <?php if ($ordine == '') echo 'selected'; ?>></option>
                        </select>
                    </div>
                    <div class="row space-between">
                        <label for="data">Data Acquisto</label>
                        <input class="form__input" id="data" type="date" name="data" value="<?php echo $data ?>">
                    </div>
                </div>
                <div class="col end">
                    <div class="row space-between">
                        <input class="confirm-btn form__input" type="submit" name="set" value="Applica">
                        <input class="delete-btn form__input" type="submit" name="default" value="Reset">
                    </div>
                </div>
            </div>
        </form>
    </div>

    <main class="mb">
        <h1 class="title">Elenco scontrini</h1>
        <div id="response">

        </div>
        <div class="btns-wrapper">

        </div>
    </main>

    <script>
        sendPage(<?php echo $current_page_rec . ",'" . $data . "','" . $ordine . "'"; ?>);


        function sendPage(page_value, date_value, order_value) {
            let total_pages_receipt = <?php echo $total_pages_receipt ?>;


            let xhr = new XMLHttpRequest();

            xhr.open('POST', 'server/paginationReceipt.php', true);
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
            }

            xhr.onload = function() {
                let table = '<table class="table receiptList"><thead><tr><th>id scontrino</th><th>totale fattura </th><th>data fattura</th><th></th></thead><tbody>';
                const json_response = this.responseText;



                if (json_response == "InternalError") {
                    table += "<td>Nessun Record Trovato</td>"
                } else {
                    let dates = JSON.parse(json_response);
                    for (let i = 0; i < dates.length; i++) {


                        table += '<tr>';
                        table += '<td>' + dates[i].id_scontrino + '</td>';
                        table += '<td>' + dates[i].tot_fattura + '  €</td>';
                        table += '<td>' + dates[i].data_fattura + '</td>';
                        table += "<td><a href='single_receipt.php?id_scontrino=" + dates[i].id_scontrino + "'><img class='table__icon' src='images/search.png' style='width: 20px; height: 15px'</a></td>";
                        table += '</tr>';
                    }

                    //BUTTON 
                    output_element = "<button class='page-btn' onclick='sendPage(1,\"" + date_value + "\",\"" + order_value + "\")'>Primo</button>";

                    for (i = 1; i <= total_pages_receipt; i++) {
                        if (total_pages_receipt > 10) {
                            if ((i >= page_value - 4) && (i <= page_value + 4)) {
                                output_element += "<button class='page-btn' onclick='sendPage(" + i + ",\"" + date_value + "\",\"" + order_value + "\")'>" + i + "</button>";
                            }
                        } else {
                            output_element += "<button class='page-btn' onclick='sendPage(" + i + ",\"" + date_value + "\",\"" + order_value + "\")'>" + i + "</button>";
                        }
                    }
                    output_element += "<button class='page-btn' onclick='sendPage(" + total_pages_receipt + ",\"" + date_value + "\",\"" + order_value + "\")'>ultimo</button>";
                }



                table += '</tbody></table>';
                document.getElementById('response').innerHTML = table;
                document.querySelector('.btns-wrapper').innerHTML = output_element;
            }




            // Dati da inviare
            let page_preparing = page_value || 1;

            let page = "val=" + page_preparing;
            let data_aggiornata = "data=" + date_value;
            let order = "ordine=" + order_value;

            const parameters = [page, data_aggiornata, order];


            console.log(parameters);
            // Invio della richiesta con i dati
            xhr.send(parameters.join('&'));


        }
    </script>
</body>

</html>