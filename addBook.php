<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aggiungi Libro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="stylesheet/style.css">
    <link rel="stylesheet" href="stylesheet/dropdown.css">
</head>
<body>
    <?php
        include "navbar.php";
    ?> 
    <h1>Aggiungi Libro</h1>

    <?php
    include 'connection.php'; 

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $titolo = $_POST['titolo'];
        $genere = $_POST['genere'];
        $anno_pubblicazione = $_POST['anno_pubblicazione'];

        $insert_book_sql = $conn->prepare("INSERT INTO Libro (Titolo, Genere, AnnoPubbl) VALUES (?, ?, ?)");
        $insert_book_sql->bind_param("sss", $titolo, $genere, $anno_pubblicazione);
        if ($insert_book_sql->execute() === TRUE) {
            $book_id = $conn->insert_id; 

            if(isset($_POST['autori']) && is_array($_POST['autori'])) {
                $autori_selezionati = $_POST['autori'];

                foreach($autori_selezionati as $autore_id) {
                    $insert_scrive_sql = $conn->prepare("INSERT INTO Scrive (CodiceLibro, CodiceAutore) VALUES (?, ?)");
                    $insert_scrive_sql->bind_param("ii", $book_id, $autore_id);
                    $insert_scrive_sql->execute();
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

        <label for="genere">Genere:</label>
        <input type="text" id="genere" name="genere" required><br><br>

        <label for="anno_pubblicazione">Anno Pubblicazione:</label>
        <input type="number" id="anno_pubblicazione" name="anno_pubblicazione" required><br><br>

        <div class="dropdown">
            <label for="autori">Autori:</label>
            <div class="dropdown-icon"></div> 
            <div class="dropdown-content">
                <?php

                $autori_sql = "SELECT * FROM Autore";
                $result = $conn->query($autori_sql);

                if ($result->num_rows > 0) {
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
    $conn->close();
    ?>
</body>
</html>
