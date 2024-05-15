<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista Utenti</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="stylesheet/style.css">
</head>
<body>
    <?php
    include "navbar.php";
    include 'connection.php';

    $users_sql = "SELECT * FROM utente";
    $users_result = $conn->query($users_sql);

    if ($users_result->num_rows > 0) {
        echo "<div>
                <h1>Lista Utenti</h1>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Username</th>
                            <th>Nome</th>
                            <th>Cognome</th>
                            <th>Data di Nascita</th>
                            <th>Email</th>
                            <th>Telefono</th>
                            <th>Azioni</th>
                        </tr>
                    </thead>
                    <tbody>";
        while($row = $users_result->fetch_assoc()) {
            echo "<tr>
                    <td>".$row["Codice"]."</td>
                    <td>".$row["Username"]."</td>
                    <td>".$row["Nome"]."</td>
                    <td>".$row["Cognome"]."</td>
                    <td>".$row["DataNascita"]."</td>
                    <td>".$row["Email"]."</td>
                    <td>".$row["Tel"]."</td>
                    <td>
                        <a href='modifyUser.php?id=".$row["Codice"]."'><button class='action-btn'><i class='fas fa-edit'></i></button></a>
                        <a href='deleteUser.php?id=".$row["Codice"]."'><button class='action-btn'><i class='fas fa-trash-alt'></i></button></a>
                    </td>
                </tr>";
        }
        echo "</tbody>
            </table>
          </div>";
    } else {
        echo "<div class='container mt-3'>
                <p>Nessun utente presente nel database.</p>
              </div>";
    }

    $conn->close();
    ?>
</body>
</html>
