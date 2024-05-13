<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifica Copia Libro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="stylesheet/style.css">
</head>
<body>
    <?php
    include "navbar.php";
    include 'connection.php'; 

    if(isset($_GET['id']) && !empty($_GET['id'])) {
        $copy_id = $_GET['id'];

        $copy_sql = $conn->prepare("SELECT * FROM copialibro WHERE Codice = ?");
        $copy_sql->bind_param("i", $copy_id);
        $copy_sql->execute();
        $copy_result = $copy_sql->get_result();

        if ($copy_result->num_rows == 1) {
            $copy_row = $copy_result->fetch_assoc();
    ?>
            <h1>Modifica Copia Libro</h1>
            <form method="post">
                <input type="hidden" name="copy_id" value="<?php echo $copy_id; ?>">
                <label for="condizioni">Condizioni:</label>
                <input type="text" id="condizioni" name="condizioni" value="<?php echo $copy_row['Condizioni']; ?>" required><br><br>

                <label for="num_pagine">Numero Pagine:</label>
                <input type="number" id="num_pagine" name="num_pagine" value="<?php echo $copy_row['numPagine']; ?>" required><br><br>

                <input type="submit" name="submit" value="Salva Modifiche">
            </form>

            <?php
            if(isset($_POST['submit'])) {
                $condizioni = $_POST['condizioni'];
                $num_pagine = $_POST['num_pagine'];

                $update_copy_sql = $conn->prepare("UPDATE copialibro SET Condizioni=?, numPagine=? WHERE Codice=?");
                $update_copy_sql->bind_param("sii", $condizioni, $num_pagine, $copy_id);
                if ($update_copy_sql->execute() === TRUE) {
                    echo "<p>Copia libro modificata con successo!</p>";
                } else {
                    echo "Errore nella modifica della copia libro: " . $conn->error;
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
