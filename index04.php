<?php
if(session_status() == PHP_SESSION_NONE){
    session_start();
}
require_once 'inc/conn.php';

unset($_SESSION['priceTot']);
unset($_SESSION['placeFullNb']);
unset($_SESSION['placeHalfNb']);
unset($_SESSION['placeAbnFullNb']);
unset($_SESSION['placeAbnHalfNb']);
unset($_SESSION['placeBloc']);
unset($_SESSION['type']);
unset($_SESSION['resId']);

$_SESSION['jour']="VEN04";

// faire doDispo 
$org = 'AFT'; // id de l'organisateur
$jour = 'ven';
$req = $pdo->prepare("SELECT * FROM cd16_blocs_".$jour );
$req->execute();

while($res = $req->fetch()){
    $Ubloc = strtoupper(str_replace("_", " ", $res->name));
    //$reqReserv = $pdo->prepare("SELECT SUM(r.nbplaces) as splaces, SUM(r.nbplaces_half) as splaces_half FROM cd16_reservations as r, cd16_users as u WHERE r.user_id= u.id AND r.bloc=? AND u.lastname=? AND r.jour=? GROUP BY r.bloc ");
    $reqReserv = $pdo->prepare("SELECT SUM(nbplaces) as splaces, SUM(nbplaces_half) as splaces_half FROM cd16_reservations WHERE (bloc=? AND jour =? AND supprime_le IS NULL) OR (bloc=? AND jour='ABN3J' AND supprime_le IS NULL)");
    //$reqReserv->execute(array($Ubloc, $org, $jourReserv));
    $reqReserv->execute(array($Ubloc, $_SESSION['jour'], $Ubloc));
    $resReserv = $reqReserv->fetch();
    // pour reservation countrytickets
    $somme = intval($resReserv->splaces) - intval($resReserv->splaces_half);
    //echo $Ubloc." = ".$res->max_org." & ".$somme."<br />";
    if($somme == 0){
        $reqUpdate=$pdo->prepare("UPDATE cd16_blocs_".$jour." SET places=max WHERE name=?" );
        $reqUpdate->execute(array($res->name));
    }else{
        $valeur = intval($res->max) - intval($somme);
        $reqUpdate=$pdo->prepare("UPDATE cd16_blocs_".$jour." SET places=? WHERE name=?" );
        $reqUpdate->execute(array($valeur, $res->name));
    }
}

?>
<?php require 'inc/header.php'; ?>
<h2>Réservation Coupe Davis 2016 - <span style="color: red">Vendredi 04 mars</span></h2>
<div id="jour" hidden="true"><?= $jour ?></div>
<div class="col-md-7">
<img src="img/Salle_600.jpg" alt="la salle" class="img-rounded displayed" usemap="#map-cd2016_600"/>
<map name="map-cd2016_600" id="map-cd2016_600">
<area id="bloc_a" alt="" title="" href="#" shape="rect" coords="155,266,209,345" />
<area id="bloc_b" alt="" title="" href="#" shape="rect" coords="158,223,207,260" />
<area id="bloc_c" alt="" title="" href="#" shape="rect" coords="160,181,205,218" />
<area id="bloc_d" alt="" title="" href="#" shape="rect" coords="156,91,209,175" />
<area id="bloc_e" alt="" title="" href="#" shape="rect" coords="218,180,245,221" />
<area id="bloc_f" alt="" title="" href="#" shape="rect" coords="217,265,244,324" />
<area id="bloc_g" alt="" title="" href="#" shape="rect" coords="153,61,228,85" />
<area id="bloc_h" alt="" title="" href="#" shape="rect" coords="229,60,304,84" />
<area id="bloc_i" alt="" title="" href="#" shape="rect" coords="307,60,382,84" />
<area id="bloc_j" alt="" title="" href="#" shape="rect" coords="383,59,458,83" />
<area id="bloc_k" alt="" title="" href="#" shape="rect" coords="458,60,533,84" />
<area id="bloc_l" alt="" title="" href="#" shape="rect" coords="479,90,533,138" />
<area id="bloc_m" alt="" title="" href="#" shape="rect" coords="478,142,532,190" />
<area id="bloc_n" alt="" title="" href="#" shape="rect" coords="478,196,532,244" />
<area id="bloc_o" alt="" title="" href="#" shape="rect" coords="478,246,532,294" />
<area id="bloc_p" alt="" title="" href="#" shape="rect" coords="478,299,532,347" />
<area id="bloc_q" alt="" title="" href="#" shape="rect" coords="442,123,472,213" />
<area id="bloc_r" alt="" title="" href="#" shape="rect" coords="442,225,472,315" />
<area id="bloc_s" alt="" title="" href="#" shape="rect" coords="463,356,526,381" />
<area id="bloc_t" alt="" title="" href="#" shape="rect" coords="388,369,437,400" />
<area id="bloc_u" alt="" title="" href="#" shape="rect" coords="300,368,387,399" />
<area id="bloc_v" alt="" title="" href="#" shape="rect" coords="253,367,302,398" />
<area id="bloc_x" alt="" title="" href="#" shape="rect" coords="160,357,220,381" />
<area id="bloc_a_sup" alt="" title="" href="#" shape="rect" coords="94,312,130,374" />
<area id="bloc_b_sup" alt="" title="" href="#" shape="rect" coords="94,245,130,307" />
<area id="bloc_c_sup" alt="" title="" href="#" shape="rect" coords="94,178,130,240" />
<area id="bloc_d_sup" alt="" title="" href="#" shape="rect" coords="94,109,130,171" />
<area id="bloc_e_sup" alt="" title="" href="#" shape="rect" coords="93,43,129,105" />
<area id="bloc_g_sup" alt="" title="" href="#" shape="rect" coords="135,13,214,43" />
<area id="bloc_h_sup" alt="" title="" href="#" shape="rect" coords="219,15,298,45" />
<area id="bloc_i_sup" alt="" title="" href="#" shape="rect" coords="305,14,384,44" />
<area id="bloc_j_sup" alt="" title="" href="#" shape="rect" coords="388,15,467,45" />
<area id="bloc_k_sup" alt="" title="" href="#" shape="rect" coords="473,15,552,45" />
<area id="bloc_l_sup" alt="" title="" href="#" shape="rect" coords="560,42,592,103" />
<area id="bloc_m_sup" alt="" title="" href="#" shape="rect" coords="561,109,593,170" />
<area id="bloc_n_sup" alt="" title="" href="#" shape="rect" coords="560,177,592,238" />
<area id="bloc_o_sup" alt="" title="" href="#" shape="rect" coords="558,242,590,303" />
<area id="bloc_p_sup" alt="" title="" href="#" shape="rect" coords="558,315,590,376" />
<area id="bloc_e0" alt="" title="" href="#" shape="rect" coords="217,118,244,177" />
<area id="bloc_f0" alt="" title="" href="#" shape="rect" coords="217,222,244,263" />
</map>
     
</div>
<div class="col-md-5">

    <div class="row">
        <div class="col-md-12 text-left">1. CLIQUEZ SUR UN BLOC</div>
    </div>
    <div class="row">
        <div class="col-md-7 text-left"  data-toggle="tooltip" data-placement="top" title="le nombre de places peu changer en + ou en -"><h5>Places disponibles*</h5></div>
        <div class="col-md-5" id="pBloc"></div>
    </div>
    <div class="row">
        <div class="col-md-12 text-left">2. INDIQUEZ LE NOMBRE DE PLACES</div>
    </div>
    <div class="row">
        <div class="col-md-6 text-left"><h5>Adultes</h5></div>
        <div class="col-md-4" id="pPriceAd"></div>
        <div class="col-md-2"><input id="inputPlaces" type="text" class="form-control" value="0"></div>
    </div>
    <div class="row">
        <div class="col-md-6 text-left"><h5>Enfants</h5></div>
        <div class="col-md-4" id="pPriceEn"></div>
        <div class="col-md-2"><input id="inputPlacesHalf" type="text" class="form-control" value="0"></div>
    </div>
    <div class="row">
        <div class="col-md-6 text-left"   data-toggle="tooltip" data-placement="top" title="les places sont garantie dans le boc"><h5>Abonnement Adulte*</h5></div>
        <div class="col-md-4" id="pPriceAbAd"></div>
        <div class="col-md-2"><input id="inputPlacesAbn" type="text" class="form-control" value="0"></div>
    </div>
    <div class="row">
        <div class="col-md-6 text-left" data-toggle="tooltip" data-placement="top" title="les places sont garantie dans le boc"><h5>Abonnement Enfant*</h5></div>
        <div class="col-md-4" id="pPriceAbEn"></div>
        <div class="col-md-2"><input id="inputPlacesAbnHalf" type="text" class="form-control" value="0"></div>
    </div>

    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="input-group">
                <span class="input-group-addon" style="padding-left: 45px">Total:</span>
                <input id="inputTotal" type="text" class="form-control" value="0" readonly="true">
                <span class="input-group-addon">.00 €</span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12" id="salleHelp"></div>
    </div>
    <div class="row">
        <div class="col-md-12"><button id="btnReserver" type="button" class="btn btn-primary btn-lg">Réserver</button></div>
        
    </div>

</div>



<?php require 'inc/footer.php';