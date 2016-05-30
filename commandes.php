<?php 
require 'inc/function.php';
auth_needed();

$j = substr($_SESSION['jour'], 3);
$index = "index".$j.".php";

require_once 'inc/conn.php';

if(isset($_SESSION['resId'])){
    header('Location: '.$index);
}else{
    $req = $pdo->prepare("INSERT INTO cd16_reservations SET user_id = ?, jour = ?, type = ?, bloc = ?, nbplaces = ?, nbplaces_half = ?, montant = ?, reserve_le = NOW()");
    $req->execute([$_SESSION['auth']->id,$_SESSION['jour'],$_SESSION['type'],$_SESSION['placeBloc'],$_SESSION['placeFullNb'],$_SESSION['placeHalfNb'],$_SESSION['priceTot']]);
    $reservationId = $pdo->lastInsertId();
    
    if($reservationId > 0){
         $_SESSION['resId']=$reservationId;
    }
}
?>
<?php require 'inc/header.php'; ?>
<div class="row">
    <div class="col-md-4 text-left">
        <a href="<?= $index ?>" class="btn btn-primary btn-lg" title="<retour" role="button"><span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span></a>
    </div>
    <div class="col-md-4">
        <p style="text-align: center"><h1>Ma commande</h1></p>
    </div>
</div>
<div class="row">
    <div class="col-md-6 text-center">
        <div class="panel panel-warning">
            <div class="panel-heading">Information</div>
            <div class="panel-body">
                <p><strong>Bonjour M<small>r</small>/M<small>me</small> <?= $_SESSION['auth']->lastname; ?></strong></p>
                <p>Votre réservation a bien été enregistrée.</p>
                <p></p>
                <!--<p>Etant donné la proximité de l'événement et afin d'éviter d'éventuels retards postaux,vos tickets seront tenus à votre disposition aux guichets du COUNTRY HALL le jour de la rencontre à partir de 12 heures contre présentation de ce document et paiement de la somme ci-dessus.</p>-->
                <p>Le montant de votre réservation devra être versé sur le compte:<br />
                <b>a.s.b.l. AFT - Bruxelles</b><br />
                <b>IBAN: BE84 0017 4289 2259 - BIC: GEBA BE BB</b><br />
                avec en référence: <b><?= $_SESSION['jour']; ?> -  <?= $reservationId; ?> - <?= $_SESSION['auth']->lastname; ?></b></p>
                <p>VEUILLEZ IMPRIMER CE DOCUMENT SVP<br />OU NOTER LE NUMERO DE RESERVATION</p>
                <p>MERCI DE VOTRE COMMANDE</p>
                <p class=" small text-primary"><b>Les places vous seront envoyées endéans les trois jours après votre paiement.</b></p>
                <p class=" small text-danger"><b>Il n'y a pas de mail de confirmation. Il faut aller voir MES RESERVATIONS</b></p>
            </div>
            <div class="panel-footer text-center">
                <a href="reservations.php"  class="btn btn-info btn-lg">Voir mes réservations</a>
            </div>
        </div>
    </div>
    <div class="col-md-6 text-left">
        <div class="panel panel-success">
            <div class="panel-heading">Commande : </div>
            <div class="panel-body">
                <table class="table">
                    <tr><th>N°</th><th><?= $reservationId; ?></th></tr>
                    <tr><th>Bloc</th><th><?= $_SESSION['placeBloc']; ?></th></tr>
                    <tr><th>Jour</th><th><?= $_SESSION['jour']; ?></th></tr>
                    <tr><th><?= $_SESSION['placeFullNb']; ?></th><td>place(s) adulte</td></tr>
                    <tr><th><?= $_SESSION['placeHalfNb']; ?></th><td>place(s) enfant</td></tr>
                    <tr><th>Abonnement 3 jours</th><th></th></tr>
                    <tr><th><?= $_SESSION['placeAbnFullNb']; ?></th><td>abonnement(s) adulte</td></tr>
                    <tr><th><?= $_SESSION['placeAbnHalfNb']; ?></th><td>abonnement(s) enfant</td></tr>
               </table>
            </div>
            <div class="panel-footer text-right">
                Pour un total de: <b><?= $_SESSION['priceTot']; ?> €</b>
            </div>
        </div>
    </div>

</div>
<?php require 'inc/footer.php';