<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="stylesheet/style.css">
</head>
<body>
    <?php
        include "navbar.php";
    ?> 
    <h1>Delete User</h1>

    <?php
    include 'connection.php'; 

    if(isset($_GET['id']) && !empty($_GET['id'])) {
        $id = $_GET['id'];
        $sql = $conn->prepare("SELECT * FROM utente WHERE Codice = ?");
        $sql->bind_param("i",$id);
        $sql->execute();
        $result = $sql->get_result();

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $username = $row['Username'];

            echo "<p>Sei sicuro di voler eliminare l'utente '$username'?</p>";
            echo "<form class='centered' method='post' style='gap: 15px'>
                    <input type='hidden' name='id' value='$id'>
                    <button type='submit' name='confirm'>Conferma</button>
                    <a href='usersList.php'><button type='button'>Annulla</button></a>
                </form>";

            if(isset($_POST['confirm'])) {
                $delete_sql = $conn->prepare("DELETE FROM utente WHERE Codice = ?");
                $delete_sql->bind_param("i", $id);
                if ($delete_sql->execute() === TRUE) {
                    echo "<p>Utente eliminato con successo!</p>";
                } else {
                    echo "Errore nell'eliminazione dell'utente: " . $conn->error;
                }
            }
        } else {
            echo "ID utente non fornito.";
        }
    } 

    $conn->close();
    ?>
</body>
</html>
