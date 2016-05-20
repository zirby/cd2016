<?php 
require 'inc/function.php';
auth_needed();

$j = substr($_SESSION['jour'], 3);
$index = "index".$j.".php";


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
    <form action="commandes.php" method="POST">
        <button type="submit" id="btnPrePayer" name="btnPrePayer"  class="btn btn-primary btn-lg">Confirmer</a>
    </form>
</div>



<?php require 'inc/footer.php';