<?php
session_start();

require_once '../inc/conn.php';


    $req = $pdo->prepare("INSERT INTO cd16_reservations SET user_id = ?, jour = ?, zone = ?, bloc = ?, nbplaces = ?, montant = ?, reserve_le = NOW()");
    $req->execute([$_SESSION['auth']->id,$_SESSION['jour'],$_SESSION['placeZone'],$_SESSION['placeBloc'],$_SESSION['placeNb'],$_SESSION['priceTot']]);
    $reservationId = $pdo->lastInsertId();
    if($reservationId > 0){
        $_SESSION['resId'] = $reservationId;
        $amount = intval($_SESSION['priceTot'])*100;
        $chaine = "AMOUNT=".strval($amount)."TotoestGrand02m15CURRENCY=EURTotoestGrand02m15LANGUAGE=fr_FRTotoestGrand02m15ORDERID=".$reservationId."TotoestGrand02m15PSPID=countryticketsTotoestGrand02m15";
        $sha1 = strtoupper(sha1($chaine));
        $_SESSION['sha1']= $sha1;
        echo json_encode(array('msg'=>$sha1, 'orderid'=>$reservationId,'chaine'=>$chaine ));
    }else{
        echo json_encode(array('msg'=>0));
    }
    

