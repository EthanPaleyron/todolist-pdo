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
    // VERIFIE SI L'UTILISATEUR EST CONECTER
    if (isset($_SESSION["id"]) && isset($_SESSION["user_name"])) {
        echo '<h2 class="title">Créer un nouveau compte</h2>';
    } else {
        echo '<h2 class="title">Créer un compte</h2>';
    }
    ?>

    <form class="inputs" action="create-account.php" method="post" enctype="multipart/form-data">
        <input type="text" name="user_name" placeholder="Nom d'utilisateur" autocomplete="off">
        <input id="password" type="password" name="password" placeholder="Mot de passe">
        <button class="eye" type="button"><i class="fa-solid fa-eye-slash"></i></button>
        <input class="submit" type="submit" value="Créer mon compte">
    </form>
    <?php
    if (isset($_POST["user_name"]) && isset($_POST["password"])) {
        try {
            include("../connexion-base.php");
            $sql = "INSERT INTO `utilisateurs` (`NOM_UTILISATEUR`, `MDP_UTILISATEUR`) VALUES (:user_name, :password)";
            // VERIFIES SI IL Y A PAS DE CARACTÈRE SPÉCIAL DANS LE NOM D'UTILISATEUR ET REGARDE SI IL Y A PLUS DE 8 CARATERE DANS LE PASSWORD
            if (!preg_match("/[ \[\]\(\)#~`\\£\$€µ<>%§]/", $_POST["user_name"]) && strlen($_POST["user_name"]) > 1 && strlen($_POST["password"]) >= 8) {
                $statement = $base->prepare($sql);
                // POUR HACHER LE MOTS DE PASSE DANS LA BASE DE DONNEE POUR PAS VOIR LE VRAI MOTS DE PASSE
                $passwordHash = password_hash($_POST["password"], PASSWORD_DEFAULT);
                $statement->execute(array("user_name" => htmlspecialchars($_POST["user_name"]), "password" => $passwordHash));
                // POUR RECUPERER LE DERNIER ID CREE & ENREGISTRER L'UTILISATEUR DANS LA SESSION
                $id = $base->lastInsertId();
                $statement->closeCursor();
                $_SESSION["id"] = $id;
                $_SESSION["user_name"] = $_POST["user_name"];
                header("Location: todolist.php");
            } else if (preg_match("/[ \[\]\(\)#~`\\£\$€µ<>%§]/", $_POST["user_name"]) || strlen($_POST["user_name"]) < 1) {
                echo "<p class='error'>Votre nom d'utilisateur ne doit pas contenir des caractere speciaux</p>";
            } else if (strlen($_POST["password"]) <= 8) {
                echo "<p class='error'>Votre mots de passe doit contenir minimum 8</p>";
            }
        } catch (Exception $e) {
            if ($e->getCode() === "23000") {
                echo "<p class='error'>Ce nom d'utilisateur est déjà pris</p>";
            } else {
                throw new InvalidArgumentException($e->getMessage());
            }
        }
    }
    ?>
    <div class="create_account_login">
        <?php
        if (isset($_SESSION["id"]) && isset($_SESSION["user_name"])) {
            echo "<a href='login.php'>Changer de compte</a>";
        } else {
            echo "<a href='login.php'>J’ai déjà un compte</a>";
        }
        ?>
    </div>
    <script type="module" src="../JS/password.js"></script>
</body>

</html>