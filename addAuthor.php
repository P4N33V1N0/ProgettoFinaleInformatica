<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aggiungi Autore</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="stylesheet/style.css">
</head>
<body>
    <?php
    include "navbar.php";
    include 'connection.php'; 

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nome = $_POST['nome'];
        $cognome = $_POST['cognome'];
        $data_nascita = $_POST['data_nascita'];
        $nazionalita = $_POST['nazionalita'];

        $insert_author_sql = $conn->prepare("INSERT INTO autore (Nome, Cognome, DataNascita, Nazionalita) VALUES (?, ?, ?, ?)");
        $insert_author_sql->bind_param("ssss", $nome, $cognome, $data_nascita, $nazionalita);
        
        if ($insert_author_sql->execute() === TRUE) {
            echo "<p>Autore aggiunto con successo!</p>";
        } else {
            echo "<p>Errore durante l'aggiunta dell'autore: " . $conn->error . "</p>";
        }
    }
    ?>

    <div class="container">
        <h1>Aggiungi Autore</h1>
        <form method="post">
            <div class="mb-3">
                <label for="nome" class="form-label">Nome</label>
                <input type="text" class="form-control" id="nome" name="nome" required>
            </div>
            <div class="mb-3">
                <label for="cognome" class="form-label">Cognome</label>
                <input type="text" class="form-control" id="cognome" name="cognome" required>
            </div>
            <div class="mb-3">
                <label for="data_nascita" class="form-label">Data di nascita</label>
                <input type="date" class="form-control" id="data_nascita" name="data_nascita" required>
            </div>
            <div class="mb-3">
                <label for="nazionalita" class="form-label">Nazionalità</label>
                <input type="text" class="form-control" id="nazionalita" name="nazionalita" required>
            </div>
            <button type="submit" class="btn btn-primary">Aggiungi Autore</button>
        </form>
    </div>

    <?php
    $conn->close();
    ?>
</body>
</html>
