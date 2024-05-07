<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aggiungi Libro</title>
</head>
<body>
    <h1>Aggiungi Libro</h1>

    <?php
    include 'connection.php';

    // Inserimento del libro nel database dopo l'invio del modulo
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $titolo = $_POST['titolo'];
        $num_pagine = $_POST['num_pagine'];
        $genere = $_POST['genere'];
        $anno_pubblicazione = $_POST['anno_pubblicazione'];

        $sql = "INSERT INTO Libro (Titolo, NumPagine, Genere, AnnoPubbl) VALUES ('$titolo', '$num_pagine', '$genere', '$anno_pubblicazione')";

        if ($conn->query($sql) === TRUE) {
            echo "<p>Libro aggiunto con successo!</p>";
        } else {
            echo "Errore: " . $sql . "<br>" . $conn->error;
        }
    }
    ?>

    <form method="post">
        <label for="titolo">Titolo:</label>
        <input type="text" id="titolo" name="titolo" required><br><br>

        <label for="num_pagine">Numero Pagine:</label>
        <input type="number" id="num_pagine" name="num_pagine" required><br><br>

        <label for="genere">Genere:</label>
        <input type="text" id="genere" name="genere" required><br><br>

        <label for="anno_pubblicazione">Anno Pubblicazione:</label>
        <input type="number" id="anno_pubblicazione" name="anno_pubblicazione" required><br><br>

        <input type="submit" value="Aggiungi Libro">
    </form>

    <?php
    // Chiudi la connessione al database
    $conn->close();
    ?>
</body>
</html>
