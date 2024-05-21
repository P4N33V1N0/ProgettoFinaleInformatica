<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista Prenotazioni Attive</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="stylesheet/style.css">
</head>
<body>
    <?php
        include "navbar.php";
    ?> 
    <h1>Lista Prenotazioni Attive</h1>

    <?php
    include 'connection.php'; 

    // Query per ottenere le prenotazioni attive
    $query = "SELECT prestito.*, utente.Nome AS NomeUtente, utente.Cognome AS CognomeUtente, copialibro.CodiceLibro AS TitoloLibro
              FROM prestito
              INNER JOIN utente ON prestito.CodUtente = utente.Codice
              INNER JOIN copialibro ON prestito.CodCopiaLibro = copialibro.Codice
              WHERE DataRestituzione IS NULL";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        echo "<table>
                <tr>
                    <th>ID Prenotazione</th>
                    <th>Utente</th>
                    <th>Libro</th>
                    <th>Data Inizio</th>
                    <th>Data Scadenza</th>
                    <th>Azioni</th>
                </tr>";
        while($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>".$row["Codice"]."</td>
                    <td>".$row["NomeUtente"]." ".$row["CognomeUtente"]."</td>
                    <td>".$row["TitoloLibro"]."</td>
                    <td>".$row["DataInizio"]."</td>
                    <td>".$row["DataScadenza"]."</td>
                    <td>
                        <a href='concludeReservation.php?reservation_id=".$row["Codice"]."'><button class='action-btn'><i class='fas fa-edit'></i></button></a>
                        <a href='deleteReservation.php?reservation_id=".$row["Codice"]."'><button class='action-btn'><i class='fas fa-trash-alt'></i></button></a>
                    </td>
                </tr>";
        }
        echo "</table>";
    } else {
        echo "Nessuna prenotazione attiva trovata.";
    }

    $conn->close();
    ?>
</body>
</html>
