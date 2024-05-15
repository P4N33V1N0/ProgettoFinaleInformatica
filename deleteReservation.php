<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Elimina Prenotazione</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="stylesheet/style.css">
</head>
<body>
    <?php
        include "navbar.php"; // Include la barra di navigazione
        include "connection.php"; // Include il file di connessione al database

        // Controlla se è stato inviato un ID di prenotazione
        if(isset($_GET['reservation_id']) && !empty($_GET['reservation_id'])) {
            $id = $_GET['reservation_id'];

            // Elimina la prenotazione dal database
            $delete_sql = $conn->prepare("DELETE FROM prestito WHERE Codice = ?");
            $delete_sql->bind_param("i", $id);

            // Mostra il messaggio di conferma solo dopo il click sul tasto di conferma
            if(isset($_POST['confirm'])) {
                if ($delete_sql->execute() === TRUE) {
                    echo "<p>Prenotazione eliminata con successo!</p>";
                } else {
                    echo "Errore durante l'eliminazione della prenotazione: " . $conn->error;
                }
            } else {
                echo "<p>Sei sicuro di voler eliminare questa prenotazione?</p>";
                echo "<form class='centered' method='post' style='gap: 15px'>
                        <button name='confirm' type='submit'>Conferma</button>
                      </form>";
            }

            $delete_sql->close();
        } else {
            echo "ID di prenotazione non fornito.";
        }

        $conn->close(); // Chiudi la connessione al database
    ?>
</body>
</html>
