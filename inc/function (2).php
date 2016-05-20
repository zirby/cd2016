<?php

function debug($var){
    echo '<pre>'. print_r($var, true) . '</pre>';
}

function str_random($length){
    $alphabet = "0123456789azertyuiopqsdfghjklmwxcvbnAZERTYUIOPQSDFGHJKLMWXCVBN";
    return substr(str_shuffle(str_repeat($alphabet, $length)), 0, $length);
}
/*
 * Page nécessitant une authentification
 */
function auth_needed(){
    if(session_status() == PHP_SESSION_NONE){
    session_start();
    }
    if (!isset($_SESSION['auth'])){
    $_SESSION['flash']['danger']= "vous n'avez pas le droit d'accéder à cette page";
    header('Location: login.php');
    exit();
    }
}

function reconnect_cookie(){
    if(session_status() == PHP_SESSION_NONE){
        session_start();
    }
    if(isset($_COOKIE['remember']) && !isset($_SESSION['auth'])){
        require_once '../inc/conn.php';
        if(!isset($pdo)){
            global $pdo;
        }
        
        $remember_token = $_COOKIE['remember'];
        $parts =  explode("==", $remember_token);
        $user_id = $parts[0];
        $req = $pdo->prepare("SELECT * FROM cd16_users WHERE id=?");
        $req->execute([$user_id]);
        $user = $req->fetch();
        if($user){
            $expected = $user->id . '==' . $remember_token . sha1($user->id . 'totoestgrand');
            if ($expected == $remember_token){
                session_start();
                $_SESSION['auth'] = $user;
                setcookie('remember', $remember_token, time() + 60*60*24*6);
            }else{
                setcookie('remember', null, -1);
            }
        }else{
            setcookie('remember', NULL, -1);
        }
    }
}

function goodString ($string){
    $string = str_replace("é", "&eacute;", $string);
    $string = str_replace("è", "&egrave;", $string);
    
    return $string;
    
}

function doDispo($jour){
        $blocs_max = array(249, 121, 127, 256,78,102,117, 130, 48, 130, 116, 115, 121, 109, 121, 115,
       146, 146, 76, 93, 200, 92, 103, 141, 179, 121, 118, 160, 122, 178, 114, 123, 122, 119,
       179, 142, 105, 102, 78);
       $blocs = array("BLOC_A","BLOC_B","BLOC_C","BLOC_D" ,"BLOC_E" ,"BLOC_F" ,"BLOC_G" ,"BLOC_H" ,"BLOC_I" ,
       "BLOC_J" ,"BLOC_K" ,"BLOC_L" ,"BLOC_M" ,"BLOC_N" ,"BLOC_O" ,"BLOC_P" ,"BLOC_Q" ,"BLOC_R" ,"BLOC_S" ,
       "BLOC_T" ,"BLOC_U" ,"BLOC_V","BLOC_A_SUP" ,"BLOC_B_SUP" ,"BLOC_C_SUP" ,"BLOC_D_SUP" ,"BLOC_E_SUP" ,
       "BLOC_G_SUP" ,"BLOC_H_SUP" ,"BLOC_I_SUP" ,"BLOC_J_SUP" ,"BLOC_K_SUP" ,"BLOC_L_SUP" ,"BLOC_M_SUP" ,
       "BLOC_N_SUP" ,"BLOC_O_SUP" ,"BLOC_P_SUP" ,"BLOC_E0" ,"BLOC_F0" );

           require_once 'conn.php';
           // verifier les dates limites de reserver_le et mettre supprimer_le

           // attention ajouter condition reserver_le et non supprimer_le
           $req = $pdo->prepare("SELECT bloc, SUM(nbplaces) as splaces FROM cd16_reservations WHERE jour =? GROUP BY bloc ");
           $req->execute([$jour]);

           $j = substr($jour, 3);

           while($row = $req->fetch()) {
               $Ubloc = str_replace(" ", "_", $row->bloc);
               $Lbloc = strtolower($Ubloc);

               $splaces = $row->splaces;
               $iBloc =  array_search($Ubloc, $blocs);
               $blocmax =  $blocs_max[$iBloc];
               $changeBloc = intval($blocmax) - intval($splaces);
               $reqU = $pdo->prepare("UPDATE cd16_blocs_".$j." SET places=? WHERE name = ?");
               $reqU->execute([$changeBloc,$Lbloc] );
               //echo $jour."------".$j."------".$iBloc."------".$blocmax."<br />";
               //echo $Lbloc."------".$changeBloc."<br />";

          }
          return TRUE;
}

function doResmail($resId) {
    if(session_status() == PHP_SESSION_NONE){
        session_start();
    }


require 'conn.php';
    
    $req = $pdo->prepare("SELECT * FROM cd16_reservations WHERE id = ?");
    $req->execute([$resId]);
    $reservation = $req->fetch();
    
    $jour = substr($reservation->jour, 3);
    
    

$destinataire = $_SESSION['auth']->email;
//$destinataire = "christian.zirbes@icloud.com";
// Pour les champs $expediteur / $copie / $destinataire, séparer par une virgule s'il y a plusieurs adresses
$expediteur = 'reservation@countrytickets.eu';

$objet = 'Reservation - Coupe Davis 2016'; // Objet du message

$headers  = 'MIME-Version: 1.0' . "\n"; // Version MIME
$headers .= 'Content-type: text/html; charset=ISO-8859-1'."\n"; // l'en-tete Content-type pour le format HTML
$headers .= 'Reply-To: '.$expediteur."\n"; // Mail de reponse
$headers .= 'From: <'.$expediteur.'>'."\n"; // Expediteur
$headers .= 'Delivered-to: '.$destinataire."\n"; // Destinataire
	
    $body = '<html>';
    $body .= '<body>';
    $body .= '<div style="text-align: center; ">';
    $body .= '<div><h1>Countrytickets.eu<br />Billetterie du Country Hall de Li&egrave;ge</h1></div>';
    $body .= '<div><h1>R&eacute;servation:'.$reservation->jour.' - '.$reservation->id.'</h1></div>';
    $body .= '<div style="text-decoration: underline">';
    $body .= '<p><h3>COUPE DAVIS : BELGIQUE - CROATIE</h3></p>';
    $body .= '<p><h2>'.$jour.' MARS 2016 - Country Hall de LIEGE</h2></p>';
    $body .= '</div>';
    $body .= '</div>';// fin div center
    $body .= '<div>Madame, Monsieur<br />';
    $body .= '<p>Nous avons bien re&ccedil;u votre commande de <strong>'.$reservation->nbplaces.'</strong> place(s) pour le <strong>'.$reservation->bloc.'</p>';
    $body .= '<p>Le montant de cette commande est de <strong>'.$reservation->montant.',00 &euro;</strong></p>';
    $body .= '<p>que vous voudrez bien verser sur le compte <strong>IBAN: BE84 0017 4289 2259 - BIC:GEBABEBB - a.s.b.l. AFT Bruxelles</strong></p>';
    $body .= '<p>avec la r&eacute;f&eacute;rence: <strong>'.$reservation->jour.' - '.$reservation->id.' - '.$_SESSION['auth']->lastname.'</strong></p>';
    $body .= '<p>avant le <strong>'.date('d/m/Y', strtotime($reservation->reserve_le. ' + 3 days')).'</strong></p>';
    $body .= '<p>ATTENTION ! Pass&eacute; cette date, sans paiement de votre part, votre r&eacute;servation sera AUTOMATIQUEMENT annul&eacute;e. </p><p></p>';
    $body .= '</div>'; // fin div madame monsieur
    $body .= '<div>Les tickets seront envoy&eacute;s &agrave; l\'adresse ci-dessous d&egrave;s r&eacute;ception de votre paiement.</div>';
    $body .= '<div>';
    $body .= "<h3>".$_SESSION['auth']->lastname." ".$_SESSION['auth']->firstname."<br />";
    $body .= goodString($_SESSION['auth']->address)."<br /> ".$_SESSION['auth']->code." ".$_SESSION['auth']->localite."</h3>";
    $body .= '</div>'; // fin din adresse
    $body .= '</body>';
    $body .= '</html>';
    //echo $body;
    		
    if (mail($destinataire, $objet, $body, $headers)) // Envoi du message
    {
       return TRUE;
    }
    else // Non envoyé
    {
       return false;
    }   
}