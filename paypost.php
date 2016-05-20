<?php
//echo $_GET['orderID'];
session_start();

if ($_GET['STATUS'] == 5){
    // ici je update la réservation
    require_once 'inc/conn.php';
    $req = $pdo->prepare("UPDATE cd16_reservations SET paye_le = NOW() WHERE id= ? ");
    $rs = $req->execute([$_GET['orderID']]);
    header('Location: reservations.php');
}

