<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifica Libro</title>
    <link rel="stylesheet" href="stylesheet/style.css">
    <link rel="stylesheet" href="stylesheet/dropdown.css">
</head>
<body>
    <h1>Modifica Libro</h1>

    <?php
    include 'connection.php';

    if(isset($_GET['id']) && !empty($_GET['id'])) {
        $book_id = $_GET['id'];

        $book_sql = $conn->prepare("SELECT * FROM Libro WHERE Codice = ?");
        $book_sql->bind_param("i",$book_id);
        $book_sql->execute();
        $book_result = $book_sql->get_result();

        if ($book_result->num_rows > 0) {
            $book_row = $book_result->fetch_assoc();
            ?>
            <form method="post">
                <input type="hidden" name="book_id" value="<?php echo $book_id; ?>">
                <label for="titolo">Titolo:</label>
                <input type="text" id="titolo" name="titolo" value="<?php echo $book_row['Titolo']; ?>" required><br><br>

                <label for="num_pagine">Numero Pagine:</label>
                <input type="number" id="num_pagine" name="num_pagine" value="<?php echo $book_row['NumPagine']; ?>" required><br><br>

                <label for="genere">Genere:</label>
                <input type="text" id="genere" name="genere" value="<?php echo $book_row['Genere']; ?>" required><br><br>

                <label for="anno_pubblicazione">Anno Pubblicazione:</label>
                <input type="number" id="anno_pubblicazione" name="anno_pubblicazione" value="<?php echo $book_row['AnnoPubbl']; ?>" required><br><br>

                <div class="dropdown">
                    <label for="autori">Autori:</label>
                    <div class="dropdown-icon"></div> 
                    <div class="dropdown-content">
                        <?php
                        $autori_sql = "SELECT * FROM Autore";
                        $autori_result = $conn->query($autori_sql);
        
                        if ($autori_result->num_rows > 0) {
                            while($autore_row = $autori_result->fetch_assoc()) {
                                $checked = '';
                                $autore_id = $autore_row['Codice'];
                                $autore_checked_sql = $conn->prepare("SELECT * FROM Scrive WHERE CodiceLibro = ? AND CodiceAutore = ?");
                                $autore_checked_sql->bind_param("ii",$book_id,$autore_id);
                                $autore_checked_sql->execute();
                                $autore_checked_result = $autore_checked_sql->get_result();
                                if ($autore_checked_result->num_rows > 0) {
                                    $checked = 'checked';
                                }
                                echo "<label class='checkbox-label'><input type='checkbox' name='autori[]' value='".$autore_row["Codice"]."' $checked>".$autore_row["Nome"]." ".$autore_row["Cognome"]."</label>";
                            }
                        }
                        ?>
                    </div>
                </div><br><br>

                <input type="submit" name="submit" value="Salva Modifiche">
            </form>
            <?php
            if(isset($_POST['submit'])) {
                $titolo = $_POST['titolo'];
                $num_pagine = $_POST['num_pagine'];
                $genere = $_POST['genere'];
                $anno_pubblicazione = $_POST['anno_pubblicazione'];
                $autori_selezionati = $_POST['autori'];

                $update_book_sql = $conn->prepare("UPDATE Libro SET Titolo=?, NumPagine=?, Genere=?, AnnoPubbl=? WHERE Codice=?");
                $update_book_sql->bind_param("sisii", $titolo,$num_pagine,$genere,$anno_pubblicazione,$book_id);
                if ($update_book_sql->execute() === TRUE) {
                    $delete_autori_sql = $conn->prepare("DELETE FROM Scrive WHERE CodiceLibro=?");
                    $delete_autori_sql->bind_param("i",$book_id);
                    $delete_autori_sql->execute();

                    foreach($autori_selezionati as $autore_id) {
                        $insert_scrive_sql = $conn->prepare("INSERT INTO Scrive (CodiceLibro, CodiceAutore) VALUES (?, ?)");
                        $insert_scrive_sql->bind_param("ii",$book_id,$autore_id);
                        $insert_scrive_sql->execute();
                    }

                    echo "<p>Libro modificato con successo!</p>";
                } else {
                    echo "Errore: " . $update_book_sql . "<br>" . $conn->error;
                }
            }
        } else {
            echo "Nessun libro trovato con l'ID specificato.";
        }
    } else {
        echo "ID di libro non fornito.";
    }

    $conn->close();
    ?>
</body>
</html>
