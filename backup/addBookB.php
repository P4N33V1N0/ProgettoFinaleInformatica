<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aggiungi Libro</title>
    <link rel="stylesheet" href="stylesheet/style.css">
    <link rel="stylesheet" href="stylesheet/dropdown.css">

</head>
<body>
    <h1>Aggiungi Libro</h1>

    <?php
    include 'connection.php'; // Includi il file per la connessione al database

    // Verifica se è stato inviato il modulo
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $titolo = $_POST['titolo'];
        $num_pagine = $_POST['num_pagine'];
        $genere = $_POST['genere'];
        $anno_pubblicazione = $_POST['anno_pubblicazione'];

        // Esegui l'inserimento del libro nel database
        $insert_book_sql = "INSERT INTO Libro (Titolo, NumPagine, Genere, AnnoPubbl) VALUES ('$titolo', '$num_pagine', '$genere', '$anno_pubblicazione')";

        if ($conn->query($insert_book_sql) === TRUE) {
            $book_id = $conn->insert_id; // Ottieni l'ID del libro appena inserito

            // Verifica se sono stati selezionati degli autori
            if(isset($_POST['autori']) && is_array($_POST['autori'])) {
                $autori_selezionati = $_POST['autori'];

                // Per ogni autore selezionato, inserisci una riga nella tabella Scrive
                foreach($autori_selezionati as $autore_id) {
                    $insert_scrive_sql = "INSERT INTO Scrive (CodiceLibro, CodiceAutore) VALUES ('$book_id', '$autore_id')";
                    $conn->query($insert_scrive_sql);
                }
            }

            echo "<p>Libro aggiunto con successo!</p>";
        } else {
            echo "Errore: " . $insert_book_sql . "<br>" . $conn->error;
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

        <div class="dropdown">
            <label for="autori">Autori:</label>
            <div class="dropdown-icon"></div> <!-- Aggiunta dell'icona di freccia verso il basso -->
            <div class="dropdown-content">
                <?php
                // Ottieni la lista degli autori dal database
                $autori_sql = "SELECT * FROM Autore";
                $result = $conn->query($autori_sql);

                if ($result->num_rows > 0) {
                    // Output delle caselle di controllo per gli autori all'interno del menu a tendina
                    while($row = $result->fetch_assoc()) {
                        echo "<label class='checkbox-label'><input type='checkbox' name='autori[]' value='".$row["Codice"]."'>".$row["Nome"]." ".$row["Cognome"]."</label>";
                    }
                }
                ?>
            </div>
        </div><br><br>

        <input type="submit" value="Aggiungi Libro">
    </form>

    <?php
    // Chiudi la connessione al database
    $conn->close();
    ?>
</body>
</html>
