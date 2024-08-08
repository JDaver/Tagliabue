<?php
include_once "server/connection.php";
?>


<!DOCTYPE html>

<html>
    <head>
        <div style="display:none">
        <?php include_once "server/pagination.php"; 
        include_once "server/queryConfig.php";?>
        </div>
        <meta charset="utf-8">
        <title>Tagliabue</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="style/style.css">
    </head>


    <body>
    <?php include_once "server/header.php";?> 
        <div class="search-container">
            <form action="index.php" method="post" class="search-form">
                
                    <input type="text" name="ricerca" value="<?php echo $ricerca; ?>">
                        <label for="">Cerca un articolo </label>
                    <select name="type" id="type" >
                        <option value="ean"<?php if($type==='ean') echo 'selected';?>>Codice EAN</option>
                        <option value="descrizione" <?php if($type==='descrizione') echo 'selected';?> >Descrizione</option>
                        <option value="marca" <?php if($type==='marca') echo 'selected';?> >Marca</option>
                    </select>
                    <button type="submit" name="cerca">Cerca</button>
            </form>
            </div>


        <div id="response"></div>
            
        <div id="buttons"></div>
            
        <footer>
            <?php include_once "server/footerStock_query.php";
            
            ?>
        </footer>




        <script>
            
        
        sendPage(<?php echo $current_page.",'".$ricerca."'" ?>);
            
        
        
      
        function sendPage(data_value,searchString){
           var total_pages_default = <?php echo $total_pages_default ?>;

            //var valore = document.getElementById('last').getAttribute('data-value');
            console.log(valore,searchString);
            var xhr = new XMLHttpRequest();

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

        xhr.onload = function(){
            var table = '<h1>ELENCO ARTICOLI</h1><table class="styled-table"><thead><tr><th>Codice Ean </th><th>Descrizione </th><th>Stock </th><th>Marca </th><th>Prezzo di acquisto </th><th>Prezzo al cliente</th></tr></thead><tbody>';
            var json_response = this.responseText;
           
            

            if(json_response=="InternalError"){
                table+="<td>Nessun Record Trovato</td>"
            }else{
                var dates = JSON.parse(json_response);
                for(var i=0; i<dates.length;i++){

                
                table += '<tr>';
                table += '<td>' + dates[i].ean + '</td>';
                table += '<td>' + dates[i].descrizione + '</td>';
                table += '<td>' + dates[i].stock + '</td>';
                table += '<td>' + dates[i].marca + '</td>';
                table += '<td>' + dates[i].prezzoAcquisto + '  €</td>';
                table += '<td>' + dates[i].prezzoVendita + '  €</td>';
                table += "<td> <a href='updateItem.php?ean="+ dates[i].ean+"'><img src='images/mod_logo.png'  style='width: 20px; height: 15px;'></a></td>";
                table += "<td> <a href='deleteItem.php?item_to_delete="+dates[i].ean+"'><img src='images/red_cross.png'  style='width: 20px; height: 15px;'></a></td>";
                table += '</tr>';
            }

              //BUTTON 
              output_element = "<button  onclick='sendPage(1,\""+searchString+"\")'>Primo</button>";
                    
                    for(i=1;i<=total_pages_default;i++){
                       if(total_pages_default>10){
                           if((i>=data_value -4) && (i <=data_value + 4)){
                            output_element += "<button onclick='sendPage("+i+",\""+searchString+"\")'>" + i + "</button>";
                       }
                       }else{
                        output_element += "<button onclick='sendPage("+i+",\""+searchString+"\")'>" + i + "</button>";
                       }
                   }
                   output_element += "<button onclick='sendPage("+total_pages_default+",\""+searchString+"\")'>ultimo</button>";
            }            
            

            table += '</tbody></table>';
            document.getElementById('response').innerHTML = table;
            document.getElementById('buttons').innerHTML = output_element;
        }

       
        

        // Dati da inviare
        var valore = data_value||1;
        var dati = "val="+ valore;
        var ricerca = "ricerca="+searchString ;
        

        var parameters =[dati];
        
        if(searchString){
            
            var type = "type="+document.getElementById('type').value;
            parameters.push(ricerca,'cerca=1',type);
        }
        
        // Invio della richiesta con i dati
        xhr.send(parameters.join('&'));
        
        
        }
    </script>
    </body>
</html>

           
           
           