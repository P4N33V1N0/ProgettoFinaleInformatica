<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Elenco Libri</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="stylesheet/style.css">
</head>
<body>
    <h1>Elenco Libri</h1>

    <?php
    include 'connection.php'; 

    $books_sql = "SELECT Libro.*, GROUP_CONCAT(Autore.Nome, ' ', Autore.Cognome SEPARATOR ', ') AS Autori FROM Libro
                    LEFT JOIN Scrive ON Libro.Codice = Scrive.CodiceLibro
                    LEFT JOIN Autore ON Scrive.CodiceAutore = Autore.Codice
                    GROUP BY Libro.Codice";
    $books_result = $conn->query($books_sql);

    if ($books_result->num_rows > 0) {
        echo "<table class='custom-table1'>
                <tr>
                    <th>Titolo</th>
                    <th>Autori</th>
                    <th>Numero Pagine</th>
                    <th>Genere</th>
                    <th>Anno Pubblicazione</th>
                    <th>Azioni</th>
                </tr>";
        while($row = $books_result->fetch_assoc()) {
            echo "<tr>
                    <td>".$row["Titolo"]."</td>
                    <td>".$row["Autori"]."</td>
                    <td>".$row["NumPagine"]."</td>
                    <td>".$row["Genere"]."</td>
                    <td>".$row["AnnoPubbl"]."</td>
                    <td >
                        <a href='modifyBook.php?id=".$row["Codice"]."'><button class='action-btn'><i class='fas fa-edit'></i></button></a>
                        <a href='deleteBook.php?id=".$row["Codice"]."'><button class='action-btn'><i class='fas fa-trash-alt'></i></button></a>
                    </td>
                </tr>";
        }
        echo "</table>";
    } else {
        echo "Nessun libro presente nel database.";
    }

    $conn->close();
    ?>
</body>
</html>
