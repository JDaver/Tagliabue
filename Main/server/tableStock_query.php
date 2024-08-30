<?php
include_once "connection.php";
include_once "queryConfig.php";
?>
<table class="table">
    <thead>
        <tr>
            <th>Codice Ean </th>
            <th>Descrizione </th>
            <th>Stock </th>
            <th></th>
        </tr>
    </thead>

    <tbody>
        <?php

        if ($sql_stock->num_rows > 0) {

            while ($row = $sql_stock->fetch_assoc()) {
                if ($row['stock'] < 4) {
                    echo "<tr>";
                    echo "<td>" . $row["ean"] . "</td>";
                    echo "<td>" . $row["descrizione"] . "</td>";
                    echo "<td>" . $row["stock"] . "</td>";
                    echo "<td><img src='./images/red.png' class='table__icon''></a></td>";
                    echo "</tr>";
                } elseif (($row['stock'] > 4) && ($row['stock']) < 8) {
                    echo "<tr>";
                    echo "<td>" . $row["ean"] . "</td>";
                    echo "<td>" . ucfirst($row["descrizione"]) . "</td>";
                    echo "<td>" . $row["stock"] . "</td>";
                    echo "<td><img src='./images/yellow.png'  class='table__icon''></a></td>";
                    echo "</tr>";
                } else {
                    echo "<tr>";
                    echo "<td>" . $row["ean"] . "</td>";
                    echo "<td>" . ucfirst($row["descrizione"]) . "</td>";
                    echo "<td>" . $row["stock"] . "</td>";
                    echo "<td><img src='./images/green.png'  class='table__icon''></a></td>";
                    echo "</tr>";
                }
            }
        } else {
            echo "<tr><td colspan='4'>non ci sono articoli a basso stock</td></tr>";
        }
        ?>
    </tbody>
</table>