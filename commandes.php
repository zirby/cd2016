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


<div class="col-lg-12">
<table class="table">
    <thead>
        <th>N°</th>
        <th>Jour</th>
        <th>Type</th>
        <th>Bloc</th>
        <th>Pl.Adulte</th>
        <th>Pl.Enfant</th>
        <th style="text-align: right;">Montant</th>
    </thead>
    <tbody>
        <td style="text-align: left;"><?= $reservationId; ?></td>
        <td style="text-align: left;"><?= $_SESSION['jour']; ?></td>
        <td style="text-align: left;"><?= $_SESSION['type']; ?></td>
        <td style="text-align: left;"><?= $_SESSION['placeBloc']; ?></td>
        <td style="text-align: left;"><?= $_SESSION['placeFullNb']; ?></td>
        <td style="text-align: left;"><?= $_SESSION['placeHalfNb']; ?></td>
        <td style="text-align: right;"><?= $_SESSION['priceTot']; ?> €</td>
       
    </tbody>
</table>

</div>
<div id="divPaiement4" class="col-lg-12">
    <p><strong>Bonjour M<small>r</small>/M<small>me</small> <?= $_SESSION['auth']->lastname; ?></strong></p>
    <p>Votre réservation a bien été enregistrée.</p>
    <p></p>
    <p>Etant donné la proximité de l'événement et afin d'éviter d'éventuels retards postaux,vos tickets seront tenus à votre disposition aux guichets du COUNTRY HALL le jour de la rencontre à partir de 12 heures contre présentation de ce document et paiement de la somme ci-dessus.</p>
     <!--<p>Le montant de votre réservation devra être versé sur le compte:<br />
   <b>a.s.b.l. AFT - Bruxelles</b><br />
    <b>IBAN: BE84 0017 4289 2259 - BIC: GEBA BE BB</b><br />
    avec en référence: <b><?= $_SESSION['jour']; ?> -  <?= $reservationId; ?> - <?= $_SESSION['auth']->lastname; ?></b></p>-->

</div>
<!--<div id="divPaiement" class="col-lg-12">
    <div class="alert alert-danger" role="alert">
        <p><strong>Celui-ci doit impérativement nous parvenir endéans les 3 jours, faute de quoi votre réservation sera AUTOMATIQUEMENT annulée.</strong></p>
    </div>
</div>-->
<div id="divPaiement3" class="col-lg-12">
    <p>VEUILLEZ IMPRIMER CE DOCUMENT SVP<br />
    OU NOTER LE NUMERO DE RESERVATION</p>
    <a href="reservations.php"  class="btn btn-info btn-lg">Voir mes réservations</a>
    <p></p>
    <!--<p>Les tickets seront alors expédiés à votre adresse endéans les 8 jours.</p>-->
    <p>MERCI DE VOTRE COMMANDE</p></div>

<?php require 'inc/footer.php';