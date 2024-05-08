<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestione Biblioteca</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="stylesheet/style.css">
    <style>
        .link-group {
            margin-bottom: 20px;
        }
        .link-group h3 {
            margin-bottom: 10px;
        }
        .link-group ul {
            list-style-type: none;
            padding: 0;
        }
        .link-group li {
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
    <?php
        include "navbar.php";
    ?> 
    <h1>Gestione Biblioteca</h1>
    <div class="card-container">
        <div class="card">
            <h3>Gestione libri</h3>
            <ul>
                <li><a href="addBook.php">Aggiungi libro</a></li>
                <li><a href="booksList.php">Visualizza lista libri</a></li>
            </ul>
        </div>
        
        <div class="card">
            <h3>Gestione Copie Libri</h3>
            <ul>
                <li><a href="addCopy.php">Aggiungi Copia Libro</a></li>
                <li><a href="modifyCopy.php">Modifica Copia Libro</a></li>
                <li><a href="copiesList.php">Visualizza Copie Libro</a></li>
            </ul>
        </div>

        <div class="card">
            <h3>Gestione Autori</h3>
            <ul>
                <li><a href="addAuthor.php">Aggiungi Autore</a></li>
                <li><a href="modifyAuthor.php">Modifica Autore</a></li>
                <li><a href="authorsList.php">Lista Autori</a></li>
            </ul>
        </div>

        <div class="card">
            <h3>Gestione Utenti</h3>
            <ul>
                <li><a href="addUser.php">Aggiungi Utente</a></li>
                <li><a href="modifyUser.php">Modifica Utente</a></li>
                <li><a href="usersList.php">Visualizza Elenco Utenti</a></li>
            </ul>
        </div>

        <div class="card"> 
            <h3>Gestione Prenotazioni</h3>
            <ul>
                <li><a href="addReservation.php">Nuova Prenotazione</a></li>
                <li><a href="modifyReservation.php">Modifica Prenotazione</a></li>
                <li><a href="reservationsList.php">Elenco Prenotazioni</a></li>
            </ul>
        </div>
    </div>
</body>
</html>