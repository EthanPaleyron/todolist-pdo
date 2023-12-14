<!-- LA CONNEXION A LA BASE SQL -->
<?php
$base = new PDO('mysql:host=127.0.0.1;dbname=base_todolist', 'root', '');
$base->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>