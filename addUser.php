<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aggiungi Utente</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="stylesheet/style.css">
</head>
<body>
    <?php
    include "navbar.php";
    include 'connection.php';

    if(isset($_POST['submit'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];
        $nome = $_POST['nome'];
        $cognome = $_POST['cognome'];
        $data_nascita = $_POST['data_nascita'];
        $email = $_POST['email'];
        $tel = $_POST['tel'];

        if($password !== $confirm_password) {
            echo "<div class='container mt-3'>
                    <div class='alert alert-danger' role='alert'>
                        Le password non corrispondono.
                    </div>
                  </div>";
            exit;
        }

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $insert_user_sql = "INSERT INTO utente (Username, Password, Nome, Cognome, DataNascita, Email, Tel) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($insert_user_sql);
        $stmt->bind_param("sssssss", $username, $hashed_password, $nome, $cognome, $data_nascita, $email, $tel);
        if ($stmt->execute() === TRUE) {
            echo "<div class='container mt-3'>
                    <div class='alert alert-success' role='alert'>
                        Utente aggiunto con successo!
                    </div>
                  </div>";
        } else {
            echo "Errore durante l'aggiunta dell'utente: " . $conn->error;
        }

        $conn->close();
    }
    ?>
    <div>
        <h1>Aggiungi Utente</h1>
        <form method="post">
            <div class="mb-3">
                <label for="username" class="form-label">Username:</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password:</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="mb-3">
                <label for="confirm_password" class="form-label">Conferma Password:</label>
                <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
            </div>
            <div class="mb-3">
                <label for="nome" class="form-label">Nome:</label>
                <input type="text" class="form-control" id="nome" name="nome" required>
            </div>
            <div class="mb-3">
                <label for="cognome" class="form-label">Cognome:</label>
                <input type="text" class="form-control" id="cognome" name="cognome" required>
            </div>
            <div class="mb-3">
                <label for="data_nascita" class="form-label">Data di Nascita:</label>
                <input type="date" class="form-control" id="data_nascita" name="data_nascita" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="tel" class="form-label">Telefono:</label>
                <input type="tel" class="form-control" id="tel" name="tel" required>
            </div>
            <button type="submit" name="submit">Aggiungi Utente</button>
        </form>
    </div>
</body>
</html>
