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
        <link rel="stylesheet" href="style/style.css">
    </head>
    <body>
    <?php include_once "server/header.php";?> 

    <div>
        <form action="receipt_list.php" method="post">
            <label for="">Data Acquisto</label>
            <input type="date" name="data" value="<?php echo $data?>">
            
            <label for="">Ordina per</label>
            <select name="ordine" id="ordine">
                <option value="DESC" <?php if($ordine=='DESC') echo 'selected';?>>Totale Crescente</option>
                <option value="ASC" <?php if($ordine=='ASC') echo 'selected';?>>Totale Decrescente</option>
                <option value="" style="display: none;" <?php if($ordine=='') echo 'selected';?>></option>
            </select>

           <input type="submit" name="set" value="Applica">
           <input type="submit" name="default" value="default">
            
        </form>
    </div>


        <div id="response">
        </div>
        <div id ="buttons">

        </div>
        
        <script>
        sendPage(<?php echo $current_page_rec.",'".$data."','".$ordine."'"; ?>);
            
        
        function sendPage(page_value,date_value,order_value){
            var total_pages_receipt = <?php echo $total_pages_receipt?>;
                
    
                //var valore = document.getElementById('last').getAttribute('data-value');
                
            var xhr = new XMLHttpRequest();
    
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
    
            xhr.onload = function(){
                var table = '<h1>Elenco scontrini</h1><table class="styled-table"><thead><tr><th>id scontrino</th><th>totale fattura </th><th>data fattura</th><th></th></thead><tbody>';
                var json_response = this.responseText;
                
                
    
                if(json_response=="InternalError"){
                    table+="<td>Nessun Record Trovato</td>"
                }else{
                    var dates = JSON.parse(json_response);
                    for(var i=0; i<dates.length;i++){
    
                    
                    table += '<tr>';
                    table += '<td>' + dates[i].id_scontrino + '</td>';
                    table += '<td>' + dates[i].tot_fattura + '  €</td>';
                    table += '<td>' + dates[i].data_fattura + '</td>';
                    table += "<td><a href='single_receipt.php?id_scontrino="+ dates[i].id_scontrino+"'><img src='images/search.png' style='width: 20px; height: 15px'</a></td>";
                    table += '</tr>';
                    }
                    
                   //BUTTON 
                    output_element = "<button  onclick='sendPage(1,\""+date_value+"\",\""+order_value+"\")'>Primo</button>";
                    
                 for(i=1;i<=total_pages_receipt;i++){
                    if(total_pages_receipt>10){
                        if((i>=page_value -4) && (i <=page_value + 4)){
                         output_element += "<button onclick='sendPage("+i+",\""+date_value+"\",\""+order_value+"\")'>" + i + "</button>";
                    }
                    }else{
                    output_element += "<button onclick='sendPage("+i+",\""+date_value+"\",\""+order_value+"\")'>" + i + "</button>";
                    }
                }
                output_element += "<button  onclick='sendPage("+total_pages_receipt+",\""+date_value+"\",\""+order_value+"\")'>ultimo</button>";
            }
                          
                
    
                table += '</tbody></table>';
                document.getElementById('response').innerHTML = table;
                document.getElementById('buttons').innerHTML = output_element;
            }
    
           
            
    
            // Dati da inviare
            var page_preparing = page_value||1;

            var page = "val="+ page_preparing;
            var data_aggiornata = "data="+date_value;
            var order = "ordine="+order_value;
    
            var parameters =[page,data_aggiornata,order];
            
        
            console.log(parameters);
            // Invio della richiesta con i dati
            xhr.send(parameters.join('&'));
            
            
            }
        
        </script>
    </body>
</html>