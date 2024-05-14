<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Elenco Prenotazioni Passate</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="stylesheet/style.css">
</head>
<body>
    <?php
        include "navbar.php"; // Include la barra di navigazione
        include "connection.php"; // Include il file di connessione al database

        // Query per selezionare le prenotazioni Passate
        $old_reservations_sql = "SELECT * FROM prestito WHERE DataRestituzione IS NOT NULL";
        $old_reservations_result = $conn->query($old_reservations_sql);

        if ($old_reservations_result->num_rows > 0) {
            echo "<h1>Elenco Prenotazioni Passate</h1>";
            echo "<table class='custom-table1'>
                    <tr>
                        <th>ID</th>
                        <th>Data Inizio</th>
                        <th>Data Scadenza</th>
                        <th>Data Restituzione</th>
                        <th>Utente</th>
                        <th>Copia Libro</th>
                        <th>Azioni</th>
                    </tr>";
            // Mostra le prenotazioni Passate in una tabella
            while($row = $old_reservations_result->fetch_assoc()) {
                echo "<tr>
                        <td>".$row["Codice"]."</td>
                        <td>".$row["DataInizio"]."</td>
                        <td>".$row["DataScadenza"]."</td>
                        <td>".$row["DataRestituzione"]."</td>
                        <td>".$row["CodUtente"]."</td>
                        <td>".$row["CodCopiaLibro"]."</td>
                        <td>
                            <a href='deleteReservation.php?reservation_id=".$row["Codice"]."'><button class='action-btn'>Elimina</button></a>
                        </td>
                    </tr>";
            }
            echo "</table>";
        } else {
            echo "Nessuna prenotazione vecchia presente nel database.";
        }

        $conn->close(); // Chiudi la connessione al database
    ?>
</body>
</html>
