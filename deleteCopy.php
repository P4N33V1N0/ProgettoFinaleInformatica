<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Elimina Copia Libro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="stylesheet/style.css">
</head>
<body>
    <?php
    include "navbar.php";
    include 'connection.php'; 

    if(isset($_GET['id']) && !empty($_GET['id'])) {
        $copy_id = $_GET['id'];

        $copy_sql = $conn->prepare("SELECT copialibro.*, libro.Titolo FROM copialibro INNER JOIN libro ON copialibro.CodiceLibro = libro.Codice WHERE copialibro.Codice = ?");
        $copy_sql->bind_param("i", $copy_id);
        $copy_sql->execute();
        $copy_result = $copy_sql->get_result();

        if ($copy_result->num_rows == 1) {
            $copy_row = $copy_result->fetch_assoc();
    ?>
            <h1>Elimina Copia Libro</h1>
            <p>Sei sicuro di voler eliminare questa copia del libro?</p>
            <p>Titolo del libro: <?php echo $copy_row['Titolo']; ?></p>
            <p>Condizioni: <?php echo $copy_row['Condizioni']; ?></p>
            <p>Numero Pagine: <?php echo $copy_row['numPagine']; ?></p>
            
            <form class='centered' method='post' style='gap: 15px'>
                <input type='hidden' name='id' value='<?php echo $copy_id; ?>'>
                <button type='submit' name='confirm'>Conferma</button>
                <a href='booksList.php'><button type='button'>Annulla</button></a>
            </form>;

            <?php
            if(isset($_POST['confirm'])) {
                $delete_copy_sql = $conn->prepare("DELETE FROM copialibro WHERE Codice = ?");
                $delete_copy_sql->bind_param("i", $copy_id);
                if ($delete_copy_sql->execute() === TRUE) {
                    echo "<p>Copia libro eliminata con successo!</p>";
                } else {
                    echo "<p>Errore nell'eliminazione della copia libro: " . $conn->error . "</p>";
                }
            }
        } else {
            echo "<p>Nessuna copia libro trovata con l'ID specificato.</p>";
        }
    } else {
        echo "<p>ID copia libro non fornito.</p>";
    }

    $conn->close();
    ?>
</body>
</html>
