<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aggiungi Prenotazione</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="stylesheet/style.css">
    <script>
        function calculateDueDate() {
            var startDate = new Date(document.getElementById("data_inizio").value);
            startDate.setMonth(startDate.getMonth() + 1);
            var dueDateField = document.getElementById("data_scadenza");
            dueDateField.value = startDate.toISOString().slice(0, 10);
        }
    </script>
</head>
<body onload="calculateDueDate()">
    <?php
        include 'navbar.php';
    ?>
    <div class="container">
        <h1>Aggiungi Prenotazione</h1>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $utente_id = $_POST['utente'];
            $copia_libro_id = $_POST['copia_libro'];
            $data_inizio = $_POST['data_inizio'];
            $data_scadenza = $_POST['data_scadenza'];

            // Esegui la logica per verificare se la copia del libro è disponibile
            include 'connection.php'; 

            $availability_check_sql = $conn->prepare("SELECT DataRestituzione FROM prestito WHERE CodCopiaLibro = ? ORDER BY DataRestituzione DESC LIMIT 1");
            $availability_check_sql->bind_param("i", $copia_libro_id);
            $availability_check_sql->execute();
            $availability_result = $availability_check_sql->get_result();

            if ($availability_result->num_rows > 0) {
                $last_return_date = $availability_result->fetch_assoc()['DataRestituzione'];
                if ($last_return_date !== null) {
                    // La copia del libro è stata restituita
                    // Esegui la logica per aggiungere la prenotazione al database
                    $insert_sql = $conn->prepare("INSERT INTO prestito (DataInizio, DataScadenza, CodUtente, CodCopiaLibro) VALUES (?, ?, ?, ?)");
                    $insert_sql->bind_param("ssii", $data_inizio, $data_scadenza, $utente_id, $copia_libro_id);
                    
                    if ($insert_sql->execute() === TRUE) {
                        echo "<p class='success'>Prenotazione aggiunta con successo!</p>";
                    } else {
                        echo "<p class='error'>Errore durante l'aggiunta della prenotazione: " . $conn->error . "</p>";
                    }

                    $insert_sql->close();
                } else {
                    echo "<p class='warning'>La copia del libro non è disponibile per la prenotazione in quanto è già stata prenotata.</p>";
                }
            } else {
                // Non ci sono prestiti precedenti per questa copia del libro
                // Esegui la logica per aggiungere la prenotazione al database
                $insert_sql = $conn->prepare("INSERT INTO prestito (DataInizio, DataScadenza, CodUtente, CodCopiaLibro) VALUES (?, ?, ?, ?)");
                $insert_sql->bind_param("ssii", $data_inizio, $data_scadenza, $utente_id, $copia_libro_id);
                
                if ($insert_sql->execute() === TRUE) {
                    echo "<p class='success'>Prenotazione aggiunta con successo!</p>";
                } else {
                    echo "<p class='error'>Errore durante l'aggiunta della prenotazione: " . $conn->error . "</p>";
                }

                $insert_sql->close();
            }

            $availability_check_sql->close();
            $conn->close();
        }
        ?>

        <form method="post">
            <label for="utente">Utente:</label>
            <select name="utente" id="utente">
                <?php
                    include 'connection.php'; 
                    $utenti_sql = "SELECT * FROM utente";
                    $utenti_result = $conn->query($utenti_sql);
                    if ($utenti_result->num_rows > 0) {
                        while($utente_row = $utenti_result->fetch_assoc()) {
                            echo "<option value='".$utente_row['Codice']."'>".$utente_row['Nome']." ".$utente_row['Cognome']."</option>";
                        }
                    }
                    $conn->close();
                ?>
            </select><br><br>

            <label for="copia_libro">Copia del Libro:</label>
            <select name="copia_libro" id="copia_libro">
                <?php
                    include 'connection.php'; 
                    $copie_sql = "SELECT copialibro.*, libro.Titolo 
                    FROM copialibro 
                    INNER JOIN libro ON copialibro.CodiceLibro = libro.Codice 
                    WHERE copialibro.Codice NOT IN (SELECT CodCopiaLibro FROM prestito WHERE DataRestituzione IS NULL)                    
                    ";
                    $copie_result = $conn->query($copie_sql);
                    if ($copie_result->num_rows > 0) {
                        while($copia_row = $copie_result->fetch_assoc()) {
                            echo "<option value='".$copia_row['Codice']."'>".$copia_row['Codice']." - ".$copia_row['Titolo']."</option>";
                        }
                    }
                    $conn->close();
                ?>
            </select><br><br>

            <label for="data_inizio">Data Inizio:</label>
            <input type="date" id="data_inizio" name="data_inizio" value="<?php echo date('Y-m-d'); ?>" onchange="calculateDueDate()" required><br><br>

            <label for="data_scadenza">Data Scadenza:</label>
            <input type="date" id="data_scadenza" name="data_scadenza" required><br><br>

            <input type="submit" name="submit" value="Aggiungi Prenotazione">
        </form>
    </div>
</body>
</html>
