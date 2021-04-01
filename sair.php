<?php
    session_start();

    unset($_SESSION['id_user']); // unset matar a sessão
    header("location: index.php");
?>