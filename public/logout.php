<!-- SUPPRESSION LA SESSION (DECONEXION) -->
<?php
session_start();
session_unset();
header("Location: http://localhost/TodoList_2023/public/pages/index.php");
?>