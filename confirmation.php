<?php 
require 'inc/function.php';
auth_needed();

$j = substr($_SESSION['jour'], 3);
$index = "index".$j.".php";
//var_dump($_SESSION['auth']);
//die();

?>
<?php require 'inc/header.php'; ?>
<div class="row">
    <div class="col-md-4 text-left">
        <a href="<?= $index ?>" class="btn btn-primary btn-lg" title="<retour"  role="button"><span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span></a>
    </div>
    <div class="col-md-4">
        <p style="text-align: center"><h1>Confirmation</h1></p>
    </div>
</div>

<div class="row">
    <div class="col-md-6 text-left">
        <div class="panel panel-info">
            <div class="panel-heading">Envoyer à : </div>
            <div class="panel-body">
                <?= $_SESSION['auth']->firstname; ?>  <b><?= $_SESSION['auth']->lastname; ?></b><br>
                <?= $_SESSION['auth']->address; ?><br>
                <?= $_SESSION['auth']->code; ?> <?= $_SESSION['auth']->localite; ?><br>
                <?= $_SESSION['auth']->country; ?><br><br>
            </div>
            <div class="panel-footer text-right">
                <a href="account.php" role="button" class="btn btn-info">Modifier</a>
            </div>
        </div>
    </div>
    <div class="col-md-6 text-left">
        <div class="panel panel-success">
            <div class="panel-heading">Commande : </div>
            <div class="panel-body">
                <table class="table">
                    <tr><th><?= $_SESSION['jour']; ?></th><th><?= $_SESSION['placeBloc']; ?></th></tr>
                    <tr><th><?= $_SESSION['placeFullNb']; ?></th><td>place(s) adulte</td></tr>
                    <tr><th><?= $_SESSION['placeHalfNb']; ?></th><td>place(s) enfant</td></tr>
                    <tr><th><?= $_SESSION['placeFullNb']; ?></th><td>abonnement(s) adulte</td></tr>
                    <tr><th><?= $_SESSION['placeHalfNb']; ?></th><td>abonnement(s) enfant</td></tr>
               </table>
            </div>
            <div class="panel-footer text-right">
                Pour un total de: <b><?= $_SESSION['priceTot']; ?> €</b>
            </div>
        </div>

        <h4></h4>
        
    </div>
<!--
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
        <td style="text-align: left;"></td>
        <td style="text-align: left;"><?= $_SESSION['jour']; ?></td>
        <td style="text-align: left;"><?= $_SESSION['type']; ?></td>
        <td style="text-align: left;"><?= $_SESSION['placeBloc']; ?></td>
        <td style="text-align: left;"><?= $_SESSION['placeFullNb']; ?></td>
        <td style="text-align: left;"><?= $_SESSION['placeHalfNb']; ?></td>
        <td style="text-align: right;"><?= $_SESSION['priceTot']; ?> €</td>
       
    </tbody>
</table>
</div>
-->
</div>


<form action="commandes.php" method="POST">
        <button type="submit" id="btnPrePayer" name="btnPrePayer"  class="btn btn-primary btn-lg">Confirmer</a>
</form>




<?php require 'inc/footer.php';