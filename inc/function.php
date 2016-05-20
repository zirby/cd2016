<?php
    require_once  'conn.php';

$blocs_max_04 = array(0, 0, 0, 89, 0, 0, 82, 115, 48, 104, 112, 0, 0, 0, 0, 0,
    0, 50, 0, 0, 0, 0,0, 52, 51, 17, 116, 0, 0, 0, 0, 0, 0, 10, 0,
    51, 0, 100, 0, 0);
$blocs_max_05 = array(131, 0, 0, 74, 0, 0, 82, 125, 48, 104, 92, 0, 0, 0, 0, 0,
    0, 50, 0, 0, 0, 0,0, 0, 0, 51, 0, 0, 0, 0, 0, 0, 0, 0, 0,
    0, 0, 0, 0, 0);
$blocs_max_06 = array(0, 0, 0, 89, 0, 0, 62, 125, 48, 104, 62, 0, 0, 0, 0, 0,
    0, 50, 0, 0, 0, 0,0, 98, 55, 0, 39, 0, 0, 0, 0, 0, 0, 0, 70,
    51, 0, 100 , 0, 0);
$blocs = array("BLOC_A", "BLOC_B", "BLOC_C", "BLOC_D", "BLOC_E", "BLOC_F", "BLOC_G", "BLOC_H", "BLOC_I",
    "BLOC_J", "BLOC_K", "BLOC_L", "BLOC_M", "BLOC_N", "BLOC_O", "BLOC_P", "BLOC_Q", "BLOC_R", "BLOC_S",
    "BLOC_T", "BLOC_U", "BLOC_V", "BLOC_X", "BLOC_A_SUP", "BLOC_B_SUP", "BLOC_C_SUP", "BLOC_D_SUP", "BLOC_E_SUP",
    "BLOC_G_SUP", "BLOC_H_SUP", "BLOC_I_SUP", "BLOC_J_SUP", "BLOC_K_SUP", "BLOC_L_SUP", "BLOC_M_SUP",
    "BLOC_N_SUP", "BLOC_O_SUP", "BLOC_P_SUP", "BLOC_E0", "BLOC_F0");

function debug($var) {
    echo '<pre>' . print_r($var, true) . '</pre>';
}

function str_random($length) {
    $alphabet = "0123456789azertyuiopqsdfghjklmwxcvbnAZERTYUIOPQSDFGHJKLMWXCVBN";
    return substr(str_shuffle(str_repeat($alphabet, $length)), 0, $length);
}

/*
 * Page nécessitant une authentification
 */

function auth_needed() {
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    if (!isset($_SESSION['auth'])) {
        $_SESSION['flash']['danger'] = "vous n'avez pas le droit d'accéder à cette page";
        header('Location: login.php');
        exit();
    }
}

function goodString($string) {
    $string = str_replace("é", "&eacute;", $string);
    $string = str_replace("è", "&egrave;", $string);

    return $string;
}

function getBlocMax($bloc, $j) {
    global $blocs, $blocs_max_04, $blocs_max_05, $blocs_max_06;
    
    $Ubloc = str_replace(" ", "_", $bloc);
    $iBloc = array_search($Ubloc, $blocs);
    switch ($j) {
        case "04":
            $blocMax = $blocs_max_04[$iBloc];
            break;
        case "05":
            $blocMax = $blocs_max_05[$iBloc];
            break;
        case "06":
            $blocMax = $blocs_max_06[$iBloc];
            break;
    }
    
    $blocName = strtolower($blocs[$iBloc]);
    
    return $blocMax . "-" . $blocName;
}

function doMax() {
    require 'conn.php';
    global $blocs, $blocs_max_04, $blocs_max_05, $blocs_max_06;
    $j = "04";
    for ($i = 0; $i <= 39; $i++) {
        $blocName = strtolower($blocs[$i]);
        $blocPlaces = getBlocMax(strtoupper($blocName), $j);
        $reqU = $pdo->prepare("UPDATE cd16_blocs_" . $j . " SET places=? WHERE name = ?");
        $reqU->execute([$blocPlaces,$blocName] );
    }
    $j = "05";
    for ($i = 0; $i <= 39; $i++) {
        $blocName = strtolower($blocs[$i]);
        $blocPlaces = getBlocMax(strtoupper($blocName), $j);
        $reqU = $pdo->prepare("UPDATE cd16_blocs_" . $j . " SET places=? WHERE name = ?");
        $reqU->execute([$blocPlaces,$blocName] );
    }
    $j = "06";
    for ($i = 0; $i <= 39; $i++) {
        $blocName = strtolower($blocs[$i]);
        $blocPlaces = getBlocMax(strtoupper($blocName), $j);
        $reqU = $pdo->prepare("UPDATE cd16_blocs_" . $j . " SET places=? WHERE name = ?");
        $reqU->execute([$blocPlaces,$blocName] );
    }
}

function doUpd($pl, $plH, $bl, $j) {

    $splaces = $pl;
    $splaces_half = $plH;
    
    $Ubloc = str_replace(" ", "_", $bl);
    $blocFull = getBlocMax($Ubloc, $j);
    $blocSplit = explode("-", $blocFull);

    //echo $blocSplit[1]."=".$blocSplit[0]."-". $splaces . "-" . $splaces_half . "<br />";

    require 'conn.php';
    $changeBloc = intval($blocSplit[0]) - intval($splaces) - intval($splaces_half);
    $reqU = $pdo->prepare("UPDATE cd16_blocs_" . $j . " SET places=? WHERE name = ?");
    $reqU->execute([$changeBloc, $blocSplit[1]]);
}

function doDispo($jour) {
    $j = substr($jour, 3);
    if($j=="3J" or $j == "3j") $j= "04";
    require 'conn.php';
    $req = $pdo->prepare("SELECT bloc, SUM(nbplaces) as splaces, SUM(nbplaces_half) as splaces_half FROM cd16_reservations WHERE (jour =? AND supprime_le IS NULL) OR (jour='ABN3J' AND supprime_le IS NULL) GROUP BY bloc ");
    $req->execute([$jour]);
    if ($req->rowCount() > 0){
        //echo $j;
        while ($row = $req->fetch()) {
             doUpd($row -> splaces, $row->splaces_half, $row->bloc, $j);
        }
    }
    return TRUE;
}

function doResmail($resId) {
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }


    $req = $pdo->prepare("SELECT * FROM cd16_reservations WHERE id = ?");
    $req->execute([$resId]);
    $reservation = $req->fetch();



    if ($reservation->jour == "ABN3J") {
        $jour = "3 JOURS";
        $type = " d'un abonnement 3 jours";
    } else {
        $jour = substr($reservation->jour, 3) . " MARS 2016";
        $type = "";
    }



    $destinataire = $_SESSION['auth']->email;
    //$destinataire = "christian.zirbes@icloud.com";
    // Pour les champs $expediteur / $copie / $destinataire, séparer par une virgule s'il y a plusieurs adresses
    $expediteur = 'info@countrytickets.eu';

    $objet = 'Reservation - Coupe Davis 2016'; // Objet du message

    $headers = 'MIME-Version: 1.0' . "\n"; // Version MIME
    $headers .= 'Content-type: text/html; charset=ISO-8859-1' . "\n"; // l'en-tete Content-type pour le format HTML
    $headers .= 'Reply-To: ' . $expediteur . "\n"; // Mail de reponse
    $headers .= 'From: <' . $expediteur . '>' . "\n"; // Expediteur
    $headers .= 'Delivered-to: ' . $destinataire . "\n"; // Destinataire

    $body = '<html>';
    $body .= '<body>';
    $body .= '<div style="text-align: center; ">';
    $body .= '<div><h1>Countrytickets.eu<br />Billetterie du Country Hall de Li&egrave;ge</h1></div>';
    $body .= '<div><h1>R&eacute;servation:' . $reservation->jour . ' - ' . $reservation->id . '</h1></div>';
    $body .= '<div style="text-decoration: underline">';
    $body .= '<p><h3>COUPE DAVIS : BELGIQUE - CROATIE</h3></p>';
    $body .= '<p><h2>' . $jour . ' - Country Hall de LIEGE</h2></p>';
    $body .= '</div>';
    $body .= '</div>'; // fin div center
    $body .= '<div>Madame, Monsieur<br />';
    $body .= '<p>Nous avons bien re&ccedil;u votre commande' . $type . ' de <strong>' . $reservation->nbplaces . '</strong> place(s) adulte(s) et <strong>' . $reservation->nbplaces_half . '</strong> place(s) enfant(s)';
    $body .= 'pour le <strong>' . $reservation->bloc . '</strong></p>';
    $body .= '<p>Le montant de cette commande est de <strong>' . $reservation->montant . ',00 &euro;</strong></p>';
    $body .= '<p>que vous voudrez bien verser sur le compte <strong>IBAN: BE84 0017 4289 2259 - BIC:GEBABEBB - a.s.b.l. AFT Bruxelles</strong></p>';
    $body .= '<p>avec la r&eacute;f&eacute;rence: <strong>' . $reservation->jour . ' - ' . $reservation->id . ' - ' . $_SESSION['auth']->lastname . '</strong></p>';
    $body .= '<p>avant le <strong>' . date('d/m/Y', strtotime($reservation->reserve_le . ' + 3 days')) . '</strong></p>';
    $body .= '</div>'; // fin div madame monsieur
    $body .= '<div>ATTENTION ! Pass&eacute;, cette date, sans paiement de votre part, votre r&eacute;servation sera AUTOMATIQUEMENT annul&eacute;e.</div>';
    $body .= '<div>Les tickets seront envoy&eacute;s &agrave; l\'adresse ci-dessous end&eacute;ans une vingtaine de jours apr&egrave;s r&eacute;ception de votre paiement.</div>';
    $body .= '<div>Merci pour votre commande.</div>';
    $body .= '<div>';
    $body .= '<h3>' . $_SESSION['auth']->lastname . ' ' . $_SESSION['auth']->firstname . '<br />';
    $body .= goodString($_SESSION['auth']->address) . '<br /> ' . $_SESSION['auth']->code . ' ' . $_SESSION['auth']->localite . '</h3>';
    $body .= '</div>'; // fin din adresse
    $body .= '</body>';
    $body .= '</html>';
    //echo $body;

    if (mail($destinataire, $objet, $body, $headers)) { // Envoi du message
        return true;
        
    } else { // Non envoyé
    
        return false;
    }
}
