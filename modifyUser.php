<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifica Utente</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="stylesheet/style.css">
</head>
<body>
    <?php
    include "navbar.php";
    include 'connection.php';

    if(isset($_GET['id']) && !empty($_GET['id'])) {
        $user_id = $_GET['id'];

        $user_sql = $conn->prepare("SELECT * FROM utente WHERE Codice = ?");
        $user_sql->bind_param("i", $user_id);
        $user_sql->execute();
        $user_result = $user_sql->get_result();

        if ($user_result->num_rows == 1) {
            $user_row = $user_result->fetch_assoc();
    ?>
            <div class="container">
                <h1>Modifica Utente</h1>
                <form method="post">
                    <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username:</label>
                        <input type="text" class="form-control" id="username" name="username" value="<?php echo $user_row['Username']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="nome" class="form-label">Nome:</label>
                        <input type="text" class="form-control" id="nome" name="nome" value="<?php echo $user_row['Nome']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="cognome" class="form-label">Cognome:</label>
                        <input type="text" class="form-control" id="cognome" name="cognome" value="<?php echo $user_row['Cognome']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="data_nascita" class="form-label">Data di Nascita:</label>
                        <input type="date" class="form-control" id="data_nascita" name="data_nascita" value="<?php echo $user_row['DataNascita']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email:</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?php echo $user_row['Email']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="tel" class="form-label">Telefono:</label>
                        <input type="tel" class="form-control" id="tel" name="tel" value="<?php echo $user_row['Tel']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Nuova Password:</label>
                        <input type="password" class="form-control" id="password" name="password">
                    </div>
                    <div class="mb-3">
                        <label for="confirm_password" class="form-label">Conferma Password:</label>
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password">
                    </div>
                    <button type="submit" class="btn btn-primary" name="submit">Salva Modifiche</button>
                </form>
            </div>
    <?php
            if(isset($_POST['submit'])) {
                $username = $_POST['username'];
                $nome = $_POST['nome'];
                $cognome = $_POST['cognome'];
                $data_nascita = $_POST['data_nascita'];
                $email = $_POST['email'];
                $tel = $_POST['tel'];
                $password = $_POST['password'];
                $confirm_password = $_POST['confirm_password'];

                if($password !== $confirm_password) {
                    echo "<div class='container mt-3'>
                            <div class='alert alert-danger' role='alert'>
                                Le password non corrispondono.
                            </div>
                          </div>";
                    exit;
                }

                $update_user_sql = "UPDATE utente SET Username=?, Nome=?, Cognome=?, DataNascita=?, Email=?, Tel=? ";
                if(!empty($password)) {
                    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                    $update_user_sql .= ", Password='$hashed_password'";
                }
                $update_user_sql .= " WHERE Codice=?";

                $stmt = $conn->prepare($update_user_sql);
                $stmt->bind_param("sssssii", $username, $nome, $cognome, $data_nascita, $email, $tel, $user_id);
                if ($stmt->execute() === TRUE) {
                    echo "<div class='container mt-3'>
                            <div class='alert alert-success' role='alert'>
                                Modifica utente effettuata con successo!
                            </div>
                          </div>";
                } else {
                    echo "Errore nella modifica dell'utente: " . $conn->error;
                }
            }
        } else {
            echo "Nessun utente trovato con l'ID specificato.";
        }
    } else {
        echo "ID utente non fornito.";
    }

    $conn->close();
    ?>
</body>
</html>
