<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

<nav class="navbar navbar-expand-lg ">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php"><i class="fa-solid fa-house"></i></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Libri
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="addBook.php">Aggiungi Libro</a></li>
                    <li><a class="dropdown-item" href="booksList.php">Visualizza lista libri</a></li>
                </ul>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Copie Libri
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="addCopies.php">Aggiungi Copia Libro</a></li>
                    <li><a class="dropdown-item" href="copiesList.php">Visualizza Copie Libro</a></li>
                </ul>
            </li>

            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Autori
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="addAuthor.php">Aggiungi Autore</a></li>
                    <li><a class="dropdown-item" href="authorsList.php">Lista Autori</a></li>
                </ul>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Utenti                
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="addUser.php">Aggiungi Utente</a></li>
                    <li><a class="dropdown-item" href="usersList.php">Visualizza Elenco Utenti</a></li>
                </ul>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Prenotazioni
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="addReservation.php">Nuova Prenotazione</a></li>
                    <li><a class="dropdown-item" href="activeReservationsList.php">Elenco Prenotazioni Attive</a></li>
                    <li><a class="dropdown-item" href="reservationsList.php">Elenco Prenotazioni Concluse</a></li>
                </ul>
            </li>
        </ul>
        </div>
    </div>
</nav>