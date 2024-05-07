<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Elenco Libri</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <h1>Elenco Libri</h1>

    <?php
    include 'connection.php';

    // Query per selezionare tutti i libri
    $sql = "SELECT * FROM Libro";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Output dei dati di ogni libro
        echo "<table border='1'>
                <tr>
                    <th>ID</th>
                    <th>Titolo</th>
                    <th>Numero Pagine</th>
                    <th>Genere</th>
                    <th>Anno Pubblicazione</th>
                    <th>Azioni</th>
                </tr>";
        while($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>".$row["Codice"]."</td>
                    <td>".$row["Titolo"]."</td>
                    <td>".$row["NumPagine"]."</td>
                    <td>".$row["Genere"]."</td>
                    <td>".$row["AnnoPubbl"]."</td>
                    <td>
                        <a href='modifyBook.php?id=".$row["Codice"]."'><button class='action-btn'><i class='fas fa-edit'></i></button></a>
                        <form action='deleteBook.php' method='post' style='display: inline-block;'>
                            <input type='hidden' name='id' value='".$row["Codice"]."'>
                            <button type='submit' class='action-btn'><i class='fas fa-trash-alt'></i></button>
                        </form>
                    </td>
                </tr>";
        }
        echo "</table>";
    } else {
        echo "Nessun libro trovato.";
    }
    ?>

    <br><br>
    <a href="aggiungi_libro.php">Aggiungi Libro</a> <!-- Link per aggiungere un nuovo libro -->

    <?php
    // Chiudi la connessione al database
    $conn->close();
    ?>
</body>
</html>
