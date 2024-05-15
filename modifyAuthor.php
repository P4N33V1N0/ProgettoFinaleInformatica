<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifica Autore</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="stylesheet/style.css">
</head>
<body>
    <?php
    include "navbar.php";
    include 'connection.php';

    if(isset($_GET['id']) && !empty($_GET['id'])) {
        $author_id = $_GET['id'];

        $author_sql = $conn->prepare("SELECT * FROM autore WHERE Codice = ?");
        $author_sql->bind_param("i",$author_id);
        $author_sql->execute();
        $author_result = $author_sql->get_result();

        if ($author_result->num_rows == 1) {
            $author_row = $author_result->fetch_assoc();
            ?>
            <div class="container">
                <h1>Modifica Autore</h1>
                <form method="post">
                    <input type="hidden" name="author_id" value="<?php echo $author_id; ?>">
                    <div class="mb-3">
                        <label for="nome" class="form-label">Nome:</label>
                        <input type="text" class="form-control" id="nome" name="nome" value="<?php echo $author_row['Nome']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="cognome" class="form-label">Cognome:</label>
                        <input type="text" class="form-control" id="cognome" name="cognome" value="<?php echo $author_row['Cognome']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="data_nascita" class="form-label">Data di Nascita:</label>
                        <input type="date" class="form-control" id="data_nascita" name="data_nascita" value="<?php echo $author_row['DataNascita']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="nazionalita" class="form-label">Nazionalità:</label>
                        <input type="text" class="form-control" id="nazionalita" name="nazionalita" value="<?php echo $author_row['Nazionalita']; ?>" required>
                    </div>
                    <button type="submit" name="submit">Salva Modifiche</button>
                </form>
            </div>
            <?php
            if(isset($_POST['submit'])) {
                $nome = $_POST['nome'];
                $cognome = $_POST['cognome'];
                $data_nascita = $_POST['data_nascita'];
                $nazionalita = $_POST['nazionalita'];

                $update_author_sql = $conn->prepare("UPDATE autore SET Nome=?, Cognome=?, DataNascita=?, Nazionalita=? WHERE Codice=?");
                $update_author_sql->bind_param("ssssi", $nome, $cognome, $data_nascita, $nazionalita, $author_id);
                if ($update_author_sql->execute() === TRUE) {
                    echo "<div class='container'><p>Autore modificato con successo!</p></div>";
                } else {
                    echo "Errore durante la modifica dell'autore: " . $conn->error;
                }
            }
        } else {
            echo "<div class='container'><p>Nessun autore trovato con l'ID specificato.</p></div>";
        }
    } else {
        echo "<div class='container'><p>ID autore non fornito.</p></div>";
    }

    $conn->close();
    ?>
</body>
</html>
