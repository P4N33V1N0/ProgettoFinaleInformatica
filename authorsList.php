<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista Autori</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="stylesheet/style.css">
</head>
<body>
    <?php
    include "navbar.php";
    include 'connection.php'; 

    $authors_sql = "SELECT * FROM autore";
    $authors_result = $conn->query($authors_sql);

    if ($authors_result->num_rows > 0) {
        echo "<div class='container'>";
        echo "<h1>Lista Autori</h1>";
        echo "<table >";
        echo "<thead><tr><th>Codice</th><th>Nome</th><th>Cognome</th><th>Data di Nascita</th><th>Nazionalità</th><th>Azioni</th></tr></thead>";
        echo "<tbody>";
        while($row = $authors_result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>".$row["Codice"]."</td>";
            echo "<td>".$row["Nome"]."</td>";
            echo "<td>".$row["Cognome"]."</td>";
            echo "<td>".$row["DataNascita"]."</td>";
            echo "<td>".$row["Nazionalita"]."</td>";
            echo "<td><a href='modifyAuthor.php?id=".$row["Codice"]."'><button class='action-btn'><i class='fas fa-edit'></i></button></td>";
            echo "</tr>";
        }
        echo "</tbody></table></div>";
    } else {
        echo "<p>Nessun autore presente nel database.</p>";
    }

    $conn->close();
    ?>
</body>
</html>
