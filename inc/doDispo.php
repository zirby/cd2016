<?php

$jour = $_GET['jour'];

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

