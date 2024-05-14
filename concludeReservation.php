<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Concludi Prenotazione</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="stylesheet/style.css">
</head>
<body>
    <?php
    include 'navbar.php';
    ?>
    <div class="container">
        <h1>Concludi Prenotazione</h1>

        <?php
        // Verifica se l'ID della prenotazione è stato passato correttamente come parametro GET
        if(isset($_GET['reservation_id']) && !empty($_GET['reservation_id'])) {
            $reservation_id = $_GET['reservation_id'];

            // Esegui la logica per concludere la prenotazione nel database
            include 'connection.php'; 

            $update_sql = $conn->prepare("UPDATE prestito SET DataRestituzione = CURRENT_DATE() WHERE Codice = ?");
            $update_sql->bind_param("i", $reservation_id);
            
            if ($update_sql->execute() === TRUE) {
                echo "<p class='success'>Prenotazione conclusa con successo!</p>";
            } else {
                echo "<p class='error'>Errore durante la conclusione della prenotazione: " . $conn->error . "</p>";
            }

            $update_sql->close();
            $conn->close();
        } else {
            echo "<p class='warning'>ID di prenotazione non fornito.</p>";
        }
        ?>
    </div>
</body>
</html>
