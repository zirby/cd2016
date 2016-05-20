<?php 
require 'inc/function.php';
auth_needed();
    require_once 'inc/conn.php';
    
    $req = $pdo->prepare("SELECT * FROM cd16_reservations WHERE user_id = ? AND supprime_le IS NULL");
    $req->execute([$_SESSION['auth']->id]);
$j = substr($_SESSION['jour'], 3);
$index = "index".$j.".php";

?>

<?php require 'inc/header.php'; ?>
        <div class="row">
            <div class="col-md-4 text-left">
                <a href="<?= $index ?>" class="btn btn-primary btn-lg" title="<retour" role="button"><span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span></a>
            </div>
            <div class="col-md-4">
                <p style="text-align: center"><h1>Mes réservations</h1></p>
            </div>
        </div>
<div class="col-md-12">
    <table class="table">
        <thead>
            <th>N° reservation</th>
            <th>Jour</th>
            <th>Type</th>
            <th>Bloc</th>
            <th>Pl.Adulte</th>
            <th>Pl.Enfant</th>
            <th style="text-align: right;">Montant</th>
            <th style="text-align: right;">Réservé le</th>
            <th style="text-align: right;">Payé le</th>
            <th style="text-align: right;">Envoyé le</th>
        </thead>
        <tbody>
            <?php while($res = $req->fetch()): ?>
            <tr>
                <td style="text-align: left;"><?= $res->id; ?></td>
                <td style="text-align: left;"><?= $res->jour; ?></td>
                <td style="text-align: left;"><?= $res->type; ?></td>
                <td style="text-align: left;"><?= $res->bloc; ?></td>
                <td style="text-align: left;"><?= $res->nbplaces; ?></td>
                <td style="text-align: left;"><?= $res->nbplaces_half; ?></td>
                <td style="text-align: right;"><?= $res->montant; ?> €</td>
                <td style="text-align: right;"><?= $res->reserve_le; ?></td>
                <td style="text-align: right;"><?= $res->paye_le; ?></td>
                <td style="text-align: right;"><?= $res->envoye_le; ?></td>
             </tr>
             <?php endwhile; ?>
        </tbody>
    </table>
</div>
<p class=" small text-primary"><b>A partir du 28/02, le montant des commandes est à payer au guichet le jour de la rencontre.</b></p>

<?php require 'inc/footer.php'; ?>
