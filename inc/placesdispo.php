<?php

require '../inc/conn.php';
$result = array();

$bloc = $_GET['bloc'];
$jour = $_GET['jour'];


$req = $pdo->prepare("SELECT * FROM cd16_blocs_".$jour." WHERE name=? ");
$req->execute([$bloc]);
$places = $req->fetch();

$bloc_name = strtoupper (str_replace("_", " ", $places->name));

$result['bloc']= $bloc_name;
$result['nb']= $places->places;
$result['price']= $places->price;
$result['price_half']= $places->price_half;
$result['price_abn']= $places->price_abn;
$result['price_abn_half']= $places->price_abn_half;
$result['color']= $places->color;

echo json_encode($result);