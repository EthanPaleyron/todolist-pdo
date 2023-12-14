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
            <ul>
                <li><a href="index.php" title="MENU"><i class="fa-solid fa-house"></i></a></li>
            </ul>
        </nav>
    </header>
    <?php
    session_start();
    if (isset($_SESSION["id"]) && isset($_SESSION["user_name"])) {
        echo '<h2 class="title">Changer de compte</h2>';
    } else {
        echo '<h2 class="title">Connexion</h2>';
    }
    ?>
    <form class="inputs" action="login.php" method="post" enctype="multipart/form-data">
        <input type="text" name="user_name" placeholder="Ton nom d'utilisateur" autocomplete="off">
        <input id="password" type="password" name="password" placeholder="Ton mot de passe">
        <button class="eye" type="button"><i class="fa-solid fa-eye-slash"></i></button>
        <input class="submit" type="submit" value="Connexion">
    </form>
    <?php
    if (isset($_POST["user_name"]) && isset($_POST["password"])) {
        include("../connexion-base.php");
        $sql = "SELECT * FROM utilisateurs WHERE NOM_UTILISATEUR = :user_name;";
        $resultat = $base->prepare($sql);
        $resultat->execute(array("user_name" => htmlspecialchars($_POST["user_name"])));
        // ENREGISTRER L'UTILISATEUR DANS LA SESSION
        if ($donnee = $resultat->fetch()) {
            // QUI PERMETS DE VERIFIER SI LE MOTS DE PASSE EST CORECTS PAR RAPPORT AU MOTS DE PASSE QUI EST HACHER EN BASE DE DONNEE 
            if (password_verify($_POST["password"], $donnee["MDP_UTILISATEUR"])) {
                $_SESSION["id"] = $donnee["ID_UTILISATEUR"];
                $_SESSION["user_name"] = $_POST["user_name"];
                header("Location: todolist.php");
            } else {
                echo "<p class='error'>Nom d'utilisateur incorect!</p>";
            }
        } else {
            echo "<p class='error'>Mots de passe incorect!</p>";
        }
        $resultat->closeCursor();
    }
    ?>
    <div class="create_account_login">
        <?php
        if (isset($_SESSION["id"]) && isset($_SESSION["user_name"])) {
            echo "<a href='create-account.php'>Créer un nouveau compte</a>";
        } else {
            echo "<a href='create-account.php'>Je n'ai pas de compte</a>";
        }
        ?>
    </div>
    <script type="module" src="../JS/password.js"></script>
</body>

</html>