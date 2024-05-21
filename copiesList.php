<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Elenco Copie Libri</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="stylesheet/style.css">
</head>
<body>
    <?php
    include "navbar.php";
    include 'connection.php'; 

    $copies_sql = "SELECT copialibro.*, libro.Titolo 
                    FROM copialibro 
                    LEFT JOIN libro ON copialibro.CodiceLibro = libro.Codice";
    $copies_result = $conn->query($copies_sql);

    if ($copies_result->num_rows > 0) {
        echo "<h1>Elenco Copie Libri</h1>";
        echo "<table class='custom-table1'>
                <tr>
                    <th>ID Copia</th>
                    <th>Titolo Libro</th>
                    <th>Condizioni</th>
                    <th>Numero Pagine</th>
                    <th>Azioni</th>
                </tr>";
        while($row = $copies_result->fetch_assoc()) {
            echo "<tr>
                    <td>".$row["Codice"]."</td>
                    <td>".$row["Titolo"]."</td>
                    <td>".$row["Condizioni"]."</td>
                    <td>".$row["numPagine"]."</td>
                    <td>
                        <a href='modifyCopy.php?id=".$row["Codice"]."'><button class='action-btn'><i class='fas fa-edit'></i></button></a>
                        <a href='deleteCopy.php?id=".$row["Codice"]."'><button class='action-btn'><i class='fas fa-trash-alt'></i></button></a>
                    </td>
                </tr>";
        }
        echo "</table>";
    } else {
        echo "<p>Nessuna copia libro presente nel database.</p>";
    }

    $conn->close();
    ?>
</body>
</html>
