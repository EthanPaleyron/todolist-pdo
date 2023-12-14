<!-- SUPPRESSION LA SESSION (DECONEXION) -->
<?php
session_start();
session_unset();
header("Location: pages/index.php");
?>