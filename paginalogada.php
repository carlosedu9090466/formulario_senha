<?php

    session_start();
    // senão não identificar a sessão. será direcionado para a index.php
    if(!isset($_SESSION['id_user']))
    {
        header("location: index.php");
        exit;
    }

?>

<h1>Seja Bem vindo a Página restrita!</h1>

<a href="sair.php">Sair</a>