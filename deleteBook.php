<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Book</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    
    <h1>Delete Book</h1>

    <?php
    include 'connection.php'; // Includi il file per la connessione al database

    // Verifica se è stato fornito un ID del libro da eliminare
    
    if(isset($_GET['id']) && !empty($_GET['id'])) {
        $id = $_GET['id'];
        // Esegui la query per ottenere i dettagli del libro da eliminare
        $sql = "SELECT * FROM Libro WHERE Codice = $id";
        $result = $conn->query($sql);

        if ($result->num_rows == 1) {
            // Ottieni i dettagli del libro
            $row = $result->fetch_assoc();
            $titolo = $row['Titolo'];

            // Conferma dell'utente prima di procedere con l'eliminazione
            echo "<p>Sei sicuro di voler eliminare il libro '$titolo'?</p>";
            echo "<form class='centered' method='post' style='gap: 15px'>
                    <input type='hidden' name='id' value='$id'>
                    <button type='submit' name='confirm'>Conferma</button>
                    <a href='booksList.php'><button type='button'>Annulla</button></a>
                </form>";

            // Gestione dell'eliminazione del libro dopo la conferma dell'utente
            if(isset($_POST['confirm'])) {
                // Elimina tutte le istanze di associazione tra il libro e gli autori nella tabella Scrive
                $delete_scrive_sql = "DELETE FROM Scrive WHERE CodiceLibro=$id";
                if ($conn->query($delete_scrive_sql) === TRUE) {
                    // Elimina il libro dalla tabella Libro
                    $delete_book_sql = "DELETE FROM Libro WHERE Codice=$id";
                    if ($conn->query($delete_book_sql) === TRUE) {
                        echo "<p>Libro eliminato con successo!</p>";
                    } else {
                        echo "Errore nell'eliminazione del libro: " . $conn->error;
                    }
                } else {
                    echo "Errore nell'eliminazione dell'associazione tra libro e autori: " . $conn->error;
                }
            }
        } else {
            echo "ID di libro non fornito.";
        }
                        
    } 
    ?>

    <?php
    // Chiudi la connessione al database
    $conn->close();
    ?>
</body>
</html>
