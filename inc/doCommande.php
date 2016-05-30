<?php
require '../inc/function.php';

$priceTot=$_POST['priceTot'];
$placeFullNb=$_POST['placeFullNb'];
$placeHalfNb=$_POST['placeHalfNb'];
$placeAbnFullNb=$_POST['placeAbnFullNb'];
$placeAbnHalfNb=$_POST['placeAbnHalfNb'];
$placeBloc=$_POST['placeBloc'];
$placeType=$_POST['placeType'];


$placeBlocReq = strtolower(str_replace(" ", "_", $placeBloc));

$priceTot = $priceTot.".00";
//decBloc($placeNb, $placeBlocReq);

session_start();


$_SESSION['priceTot']=$priceTot;
$_SESSION['type']=$placeType;
$_SESSION['placeFullNb']=$placeFullNb;
$_SESSION['placeHalfNb']=$placeHalfNb;
$_SESSION['placeAbnFullNb']=$placeAbnFullNb;
$_SESSION['placeAbnHalfNb']=$placeAbnHalfNb;

$_SESSION['placeBloc']=$placeBloc;

//var_dump($_SESSION);
//die();
echo json_encode(array('success'=>true));

