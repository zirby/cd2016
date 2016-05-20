<?php

session_start();
$j = substr($_SESSION['jour'], 3);
$index = "index".$j.".php";
unset($_SESSION['auth']);
setcookie('remember', NULL, -1);
$_SESSION['flash']['success'] = "Vous êtes maintenant déconnecté";
header('Location: '.$index);
