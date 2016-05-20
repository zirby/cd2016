<?php
require 'inc/function.php';
session_start();
$j = substr($_SESSION['jour'], 3);
$index = "index".$j.".php";

?>

<?php require 'inc/header.php'; ?>
        <div class="row">
            <div class="col-md-4 text-left">
                <a href="<?= $index ?>" class="btn btn-primary btn-lg" title="<retour" role="button"><span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span></a>
            </div>
            <div class="col-md-4">
                <p style="text-align: center"><h1>Aide</h1></p>
            </div>
        </div>

<dl>
  <dt>Réservation</dt>
  <dd>Cliquez sur un bloc</dd>
  <dd>Indiquez le nombre de places ( palcez le curseur à droite du nombre, puis flêche gauche</dd>
  <dd>Sur la page "Confirmation", vérifiez et confirmez votre réservation</dd>
  <dt>Inscription</dt>
  <dd>Remplissez TOUS les champs</dd>
  <dd>Retenez votre e-mail et votre mot de passe, ils vous seront demandés en cas de connexion ultérieure</dd>
</dl>

<?php require 'inc/footer.php';