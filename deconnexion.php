<?php

//Fichier appelé pour détruire la session

session_name("gi2");
session_start();
session_destroy();
header('Location: login2.php');
exit;
?>