<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifica Libro</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #D9B589;
            min-width: 200px;
            border: 1px solid #ddd;
            z-index: 1;
        }

        .dropdown-content a {
            padding: 12px 16px;
            display: block;
        }

        .dropdown-content a:hover {
            background-color: #D9B589;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

        .checkbox-label {
            display: block;
        }

        .checkbox-label input[type="checkbox"] {
            display: inline-block;
            margin-right: 5px;
        }

        /* Aggiunta di un'icona di freccia verso il basso */
        .dropdown-icon {
            display: inline-block;
            width: 16px;
            height: 16px;
            background-image: url('https://png.pngtree.com/png-vector/20190419/ourmid/pngtree-vector-down-arrow-icon-png-image_956681.jpg'); /* URL dell'icona di freccia verso il basso */
            background-size: cover;
            margin-left: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <h1>Modifica Libro</h1>

    <?php
    include 'connection.php'; // Includi il file per la connessione al database

    // Verifica se è stato fornito un ID di libro valido tramite URL
    if(isset($_GET['id']) && !empty($_GET['id'])) {
        $book_id = $_GET['id'];

        // Recupera i dati del libro dal database utilizzando l'ID del libro
        $book_sql = "SELECT * FROM Libro WHERE Codice = $book_id";
        $book_result = $conn->query($book_sql);

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
                    <div class="dropdown-icon"></div> <!-- Aggiunta dell'icona di freccia verso il basso -->
                    <div class="dropdown-content">
                        <?php
                        $autori_sql = "SELECT * FROM Autore";
                        $autori_result = $conn->query($autori_sql);
        
                        if ($autori_result->num_rows > 0) {
                            while($autore_row = $autori_result->fetch_assoc()) {
                                $checked = '';
                                // Verifica se l'autore è associato al libro
                                $autore_id = $autore_row['Codice'];
                                $autore_checked_sql = "SELECT * FROM Scrive WHERE CodiceLibro = $book_id AND CodiceAutore = $autore_id";
                                $autore_checked_result = $conn->query($autore_checked_sql);
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
            // Processa il modulo di modifica del libro
            if(isset($_POST['submit'])) {
                $titolo = $_POST['titolo'];
                $num_pagine = $_POST['num_pagine'];
                $genere = $_POST['genere'];
                $anno_pubblicazione = $_POST['anno_pubblicazione'];
                $autori_selezionati = $_POST['autori'];

                // Esegui l'aggiornamento dei dati del libro nel database
                $update_book_sql = "UPDATE Libro SET Titolo='$titolo', NumPagine='$num_pagine', Genere='$genere', AnnoPubbl='$anno_pubblicazione' WHERE Codice=$book_id";

                if ($conn->query($update_book_sql) === TRUE) {
                    // Elimina gli autori precedenti associati al libro
                    $delete_autori_sql = "DELETE FROM Scrive WHERE CodiceLibro=$book_id";
                    $conn->query($delete_autori_sql);

                    // Associa gli autori selezionati al libro
                    foreach($autori_selezionati as $autore_id) {
                        $insert_scrive_sql = "INSERT INTO Scrive (CodiceLibro, CodiceAutore) VALUES ('$book_id', '$autore_id')";
                        $conn->query($insert_scrive_sql);
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

    // Chiudi la connessione al database
    $conn->close();
    ?>
</body>
</html>
