<!doctype html>
<html lang="fr">

<head>
    <link rel="stylesheet" href="../CSS/style.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TO-DO List</title>
    <script src="https://kit.fontawesome.com/2621df78fc.js" crossorigin="anonymous"></script>
</head>

<body>
    <header>
        <nav>
            <a href="index.php">
                <h1>TO-DO List</h1>
            </a>
            <ul class="list_nav">
                <?php
                session_start();
                // VÉRIFIE SI L'UTILISATEUR EST CONNECTÉ
                if (isset($_SESSION["id"]) && isset($_SESSION["user_name"])) {
                    echo '<li><a href="../logout.php">Déconnexion</a></li>
                    <li><a href="login.php">Changer de compte</a></li>
                    <li><a href="create-account.php">Créer un nouveau compte</a></li>';
                }
                ?>
            </ul>
        </nav>
    </header>
    <h2 class="title">Bienvenue!</h2>
    <ul class="conexion">
        <?php
        if (isset($_SESSION["id"]) && isset($_SESSION["user_name"])) {
            echo '<li><a href="todolist.php">Revenir sur ma Todolist</a></li>';
        } else {
            echo '<li><a href="create-account.php">Créer un compte</a></li>
                <li><a href="login.php">Connexion</a></li>';
        }
        ?>
    </ul>
</body>

</html>