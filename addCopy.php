<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aggiungi Copia Libro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="stylesheet/style.css">
</head>
<body>
    <?php
        include "navbar.php";
    ?> 
    <h1>Aggiungi Copia Libro</h1>

    <?php
    include 'connection.php'; 

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $condizioni = $_POST['condizioni'];
        $numPagine = $_POST['numPagine'];
        $codiceLibro = $_POST['codiceLibro'];

        $insert_copialibro_sql = $conn->prepare("INSERT INTO copialibro (Condizioni, numPagine, CodiceLibro) VALUES (?, ?, ?)");
        $insert_copialibro_sql->bind_param("sii", $condizioni, $numPagine, $codiceLibro);
        if ($insert_copialibro_sql->execute() === TRUE) {
            echo "<p>Copia libro aggiunta con successo!</p>";
        } else {
            echo "Errore: " . $insert_copialibro_sql . "<br>" . $conn->error;
        }
    }
    ?>

    <form method="post">
        <label for="codiceLibro">Seleziona Libro:</label>
        <select id="codiceLibro" name="codiceLibro" required>
            <?php
            $libri_sql = "SELECT Libro.Codice, Libro.Titolo, GROUP_CONCAT(Autore.Nome, ' ', Autore.Cognome SEPARATOR ', ') AS Autori 
                            FROM Libro
                            LEFT JOIN Scrive ON Libro.Codice = Scrive.CodiceLibro
                            LEFT JOIN Autore ON Scrive.CodiceAutore = Autore.Codice
                            GROUP BY Libro.Codice";
            $libri_result = $conn->query($libri_sql);

            if ($libri_result->num_rows > 0) {
                while($row = $libri_result->fetch_assoc()) {
                    echo "<option value='".$row["Codice"]."'>".$row["Titolo"]." di ".$row["Autori"]."</option>";
                }
            }
            ?>
        </select><br><br>

        <label for="condizioni">Condizioni:</label>
        <input type="text" id="condizioni" name="condizioni" required><br><br>

        <label for="numPagine">Numero Pagine:</label>
        <input type="number" id="numPagine" name="numPagine" required><br><br>

        <input type="submit" value="Aggiungi Copia Libro">
    </form>

    <?php
    $conn->close();
    ?>
</body>
</html>
