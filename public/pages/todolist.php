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
        <li><a href="../logout.php">Déconnexion</a></li>
        <!-- <li><a href="index.php">Supprimer ce compte</a></li> -->
        <li>
          <!-- VÉRIFIE SI L'UTILISATEUR EST CONNECTÉ -->
          <p>Connecter en tant que <span>
              <?php
              session_start();
              if (isset($_SESSION["id"]) && isset($_SESSION["user_name"])) {
                echo (htmlspecialchars($_SESSION["user_name"]));
              } else {
                header("Location: index.php");
              }
              ?>
            </span></p>
        </li>
        <li><a href="index.php" title="MENU"><i class="fa-solid fa-house"></i></a></li>
      </ul>
    </nav>
  </header>

  <h2 class="title">Mes taches</h2>
  <!-- POUR POUVOIR CRÉER UNE TODO -->
  <form class="inputs" action="todolist.php" method="post" enctype="multipart/form-data">
    <input type="text" name="contenu" placeholder="Nouvel item" autocomplete="off">
    <input class="submit" type="submit" value="Submit">
  </form>
  <?php
  if (isset($_POST["contenu"])) {
    try {
      include("../connexion-base.php");
      $sql = "INSERT INTO `todolist` (`CONTENU`, `ID_UTILISATEUR`, `DATE`) VALUES (:contenu, :id, :date)";
      $statement = $base->prepare($sql);
      $statement->execute(array("contenu" => htmlspecialchars($_POST["contenu"]), "id" => $_SESSION["id"], "date" => date("Y-m-d H:i:s")));
      $statement->closeCursor();
      header("Location: todolist.php");
    } catch (Exception $e) {
      throw new InvalidArgumentException($e->getMessage());
    }
  }
  ?>

  <ul class="todoList">
    <!-- L'AFFICHAGE DE TOUT LES TODO DE L'UTILISATEUR CONNECTER -->
    <?php
    include("../connexion-base.php");
    $sql = "SELECT * FROM `todolist` WHERE ID_UTILISATEUR =" . $_SESSION["id"] . " ORDER BY DATE";
    $base->query($sql);
    $resultat = $base->query($sql);
    while ($e = $resultat->fetch()) {
      $date = new DateTime($e["DATE"]);
      echo '<li>
        <time datetime="' . $date->format("d-m-Y H:i:s") . '">' . $date->format("d-m-Y") . '</time>
        <h2 class="contents">' . $e["CONTENU"] . '</h2>
        <form action="todolist.php" method="post" enctype="multipart/form-data" class="inputs change">
          <input type="hidden" name="id_todo_change" value="' . $e["ID_TODOLIST"] . '">
          <input type="text" name="changeContents" placeholder="Renommer item" value="' . $e["CONTENU"] . '">
          <input class="submit" type="submit" value="Changer">
        </form>
        <div class="contentButtons">
          <button class="buttonsChange"><i class="fa-solid fa-pen"></i></button>
          <form action="todolist.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id_todo_delete" value="' . $e["ID_TODOLIST"] . '">
            <button><i class="fa-solid fa-trash"></i></button>
          </form>
        </div>
      </li>';
    }

    // POUR SUPPRIMER UNE TODO
    if (isset($_POST["id_todo_delete"])) {
      try {
        include("../connexion-base.php");
        $sql = "DELETE FROM `todolist` WHERE ID_TODOLIST = :id_todo_delete";
        $statement = $base->prepare($sql);
        $statement->execute(array("id_todo_delete" => $_POST["id_todo_delete"]));
        $statement->closeCursor();
        header("Location: todolist.php");
      } catch (Exception $e) {
        throw new InvalidArgumentException($e->getMessage());
      }
    }

    // POUR MODIFIER UNE TODO
    if (isset($_POST["changeContents"]) && isset($_POST["id_todo_change"])) {
      try {
        include("../connexion-base.php");
        $sql = "UPDATE `todolist` SET `CONTENU` = :changeContents, `DATE` =:date WHERE ID_TODOLIST = :id_todo_change";
        $statement = $base->prepare($sql);
        $statement->execute(array("changeContents" => htmlspecialchars($_POST["changeContents"]), "id_todo_change" => $_POST["id_todo_change"], "date" => date("Y-m-d H:i:s")));
        $statement->closeCursor();
        header("Location: todolist.php");
      } catch (Exception $e) {
        throw new InvalidArgumentException($e->getMessage());
      }
    }
    ?>
  </ul>
  <script type="module" src="../JS/change.js"></script>
</body>

</html>