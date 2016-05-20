<?php
if(session_status() == PHP_SESSION_NONE){
    session_start();
}

unset($_SESSION['priceTot']);
unset($_SESSION['placeNb']);
unset($_SESSION['placeBloc']);
unset($_SESSION['placeZone']);

require_once 'inc/doDispo.php';
?>
<?php require 'inc/header.php'; ?>
<h1>Réservation Coupe Davis 2016</h1>

<div class="col-md-9">
    <img src="img/cd2016_800_2.jpg" alt="la salle" class="img-rounded displayed" usemap="#map-cd2016_800"/>
    <map name="map-cd2016_800" id="map-cd2016_800">
        <area id="bloc_d" alt="" title="" href="#" shape="rect" coords="205,121,280,234" />
        <area id="bloc_c" alt="" title="" href="#" shape="rect" coords="213,242,275,291"   />
        <area id="bloc_b" alt="" title="" href="#" shape="rect" coords="212,299,274,348"      />
        <area id="bloc_a" alt="" title="" href="#" shape="rect" coords="207,356,279,458"      />
        <area id="bloc_x" alt="" title="" href="#" shape="rect" coords="212,474,294,507"      />
        <area id="bloc_e_sup" alt="" title="" href="#" shape="rect" coords="123,55,172,142"      />
        <area id="bloc_d_sup" alt="" title="" href="#" shape="rect" coords="123,144,172,231"      />
        <area id="bloc_c_sup" alt="" title="" href="#" shape="rect" coords="123,234,172,321"      />
        <area id="bloc_b_sup" alt="" title="" href="#" shape="rect" coords="126,324,175,411"      />
        <area id="bloc_a_sup" alt="" title="" href="#" shape="rect" coords="124,415,173,502"      />
        <area id="bloc_e0" alt="" title="" href="#" shape="rect" coords="289,160,327,233"      />
        <area id="bloc_f" alt="" title="" href="#" shape="rect" coords="288,354,326,427"      />
        <area id="bloc_e" alt="" title="" href="#" shape="rect" coords="290,239,325,292"      />
        <area id="bloc_f0" alt="" title="" href="#" shape="rect" coords="288,298,323,351"      />
        <area id="bloc_g" alt="" title="" href="#" shape="rect" coords="206,81,304,110"      />
        <area id="bloc_h" alt="" title="" href="#" shape="rect" coords="308,81,406,110"      />
        <area id="bloc_i" alt="" title="" href="#" shape="rect" coords="407,80,505,109"      />
        <area id="bloc_j" alt="" title="" href="#" shape="rect" coords="513,83,611,112"      />
        <area id="bloc_k" alt="" title="" href="#" shape="rect" coords="612,82,710,111"      />
        <area id="bloc_g_sup" alt="" title="" href="#" shape="rect" coords="179,19,286,57"      />
        <area id="bloc_h_sup" alt="" title="" href="#" shape="rect" coords="291,20,398,58"      />
        <area id="bloc_i_sup" alt="" title="" href="#" shape="rect" coords="403,18,510,56"      />
        <area id="bloc_j_sup" alt="" title="" href="#" shape="rect" coords="515,20,622,58"      />
        <area id="bloc_k_sup" alt="" title="" href="#" shape="rect" coords="628,20,735,58"      />
        <area id="bloc_l_sup" alt="" title="" href="#" shape="rect" coords="741,56,792,139"      />
        <area id="bloc_m_sup" alt="" title="" href="#" shape="rect" coords="741,145,792,228"      />
        <area id="bloc_n_sup" alt="" title="" href="#" shape="rect" coords="740,238,791,321"      />
        <area id="bloc_o_sup" alt="" title="" href="#" shape="rect" coords="739,326,790,409"      />
        <area id="bloc_p_sup" alt="" title="" href="#" shape="rect" coords="741,417,792,500"      />
        <area id="bloc_l" alt="" title="" href="#" shape="rect" coords="639,121,708,184"      />
        <area id="bloc_m" alt="" title="" href="#" shape="rect" coords="638,190,707,253"      />
        <area id="bloc_n" alt="" title="" href="#" shape="rect" coords="638,259,707,322"      />
        <area id="bloc_o" alt="" title="" href="#" shape="rect" coords="637,331,706,394"      />
        <area id="bloc_p" alt="" title="" href="#" shape="rect" coords="636,399,705,462"      />
        <area id="bloc_q" alt="" title="" href="#" shape="rect" coords="588,165,630,281"      />
        <area id="bloc_r" alt="" title="" href="#" shape="rect" coords="587,301,629,417"      />
        <area id="bloc_v" alt="" title="" href="#" shape="rect" coords="341,490,397,532"      />
        <area id="bloc_t" alt="" title="" href="#" shape="rect" coords="519,490,575,532"      />
        <area id="bloc_s" alt="" title="" href="#" shape="rect" coords="620,475,704,509"      />
        <area id="bloc_u" alt="" title="" href="#" shape="rect" coords="399,488,519,535"      />
        </map>

     
</div>
<div class="col-md-3">
    <div class="row">
        <div class="col-md-2"><img src="img/image_1_50.jpg" alt=""></div>
        <div class="col-md-10"><p style="font-size: 1em;"> cliquez sur un bloc pour connaître les places disponibles</p></div>
    </div>
    <div class="row">
        <div class="alert alert-success" role="alert">
            <p><strong>Places disponibles*</strong></p>
            <p id="pZone"></p>
            <p id="pBloc"></p>
        </div>
    </div>
    <div class="row">
        <div class="alert alert-warning" role="alert">
            <p style="font-size: 0.75em;"><strong>* !</strong>
            Le nombre de places disponibles peut varier, en plus ou en moins, fréquemment.</p>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-2"><img src="img/image_2_50.jpg" alt=""></div>
        <div class="col-md-10"><p style="font-size: 1em;"> indiquez le nombre de place</p></div>
    </div>
    <div style="height: 10px;"></div>

    <div class="row">
        <div class="input-group">
            <span class="input-group-addon">Nb. de places:</span>
            <input id="inputPlaces" type="text" class="form-control" value="0">
        </div>
        <div style="height: 10px;"></div>
        <div class="input-group">
            <span class="input-group-addon" style="padding-left: 35px">Coût total:</span>
            <input id="inputTotal" type="text" class="form-control" value="0" readonly="true">
            <span class="input-group-addon">.00 €</span>
        </div>
        <div style="height: 20px;"></div>
        <p id="salleHelp" style="font-size: 1em;"></p>
        <div style="height: 20px;"></div>
        <button id="btnReserver" type="button" class="btn btn-primary btn-lg">Réserver</button>
    </div>
   
</div>




<?php require 'inc/footer.php';