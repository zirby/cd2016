<?php
require 'inc/function.php';
session_start();
$j = substr($_SESSION['jour'], 3);
$index = "index".$j.".php";

if(!empty($_POST)){
    
    $errors = array();
    require 'inc/conn.php';
    
    if(empty($_POST['lastname'])){$errors['lastname']="Entrez votre nom";}
    if(empty($_POST['firstname'])){$errors['firstname']="Entrez votre prénom";}
    if(empty($_POST['inputAdr'])){$errors['inputAdr']="Entrez votre adresse";}
    if(empty($_POST['inputZip'])){$errors['inputZip']="Entrez votre code postal";}
    if(empty($_POST['inputLocal'])){$errors['inputLocal']="Entrez votre localité";}
    if(empty($_POST['inputPhone'])){$errors['inputPhone']="Entrez votre n° de téléphone";}
    if (empty($errors)){
        
        $req = $pdo->prepare("UPDATE cd16_users SET firstname = ?,lastname = ?,address = ?,code = ?,localite = ?,country=?,telephone = ? WHERE id=?");
        $req->execute([$_POST['firstname'],$_POST['lastname'],$_POST['inputAdr'],$_POST['inputZip'],$_POST['inputLocal'],$_POST['inputPays'],$_POST['inputPhone'], $_SESSION['auth']->id]);

        $reqS = $pdo->prepare("SELECT * FROM cd16_users WHERE id = ?");
        $reqS->execute([$_SESSION['auth']->id]);
        $user = $reqS->fetch();
        $_SESSION['auth'] = $user;
        
        header('Location: confirmation.php');
        exit();

    }
}
?>
<?php require 'inc/header.php'; ?>
<form action="" method="POST" class="form-horizontal">
  <fieldset>
    <legend>
        <div class="row">
            <div class="col-md-4 text-left">
                <a href="confirmation.php" class="btn btn-primary btn-lg" title="<retour"  role="button"><span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span></a>
            </div>
            <div class="col-md-4">
                <p style="text-align: center"><h1>Mon compte</h1></p>
            </div>
        </div>
    </legend>
     <?php if(!empty($errors)):?>
        <div class="alert alert-danger">
            <ul>
            <?php  foreach($errors as $error): ?>
                <li><?= $error; ?></li>
            <?php  endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    <div class="col-md-6 col-md-offset-3">
      <div class="form-group">
        <label for="lastname" class="col-lg-3 control-label">Nom<sup style="color:red;">*</sup></label>
        <div class="col-lg-9">
          <input type="text" class="form-control" style="text-transform: uppercase" name="lastname" id="lastname" value="<?= $_SESSION['auth']->lastname; ?>">
        </div>
      </div>
      <div class="form-group">
        <label for="firstname" class="col-lg-3 control-label">Prénom<sup style="color:red;">*</sup></label>
        <div class="col-lg-9">
          <input type="text" class="form-control" name="firstname" id="firstname"  value="<?= $_SESSION['auth']->firstname; ?>">
          <span id="helpFirstName"></span>
        </div>
      </div>

    <div class="form-group">
        <label for="inputAdr" class="col-lg-3 control-label">Adresse<sup style="color:red;">*</sup></label>
        <div class="col-lg-9">
          <input type="text" class="form-control" name="inputAdr" id="inputAdr"  value="<?= $_SESSION['auth']->address; ?>">
          <span id="helpAdr"></span>
        </div>
      </div>
      <div class="form-group">
        <label for="inputZip" class="col-lg-3 control-label">Code<sup style="color:red;">*</sup></label>
        <div class="col-lg-9">
          <input type="text" class="form-control" name="inputZip" id="inputZip"  value="<?= $_SESSION['auth']->code; ?>">
          <span id="helpZip"></span>
        </div>
      </div>
      <div class="form-group">
        <label for="inputLocal" class="col-lg-3 control-label">Localité<sup style="color:red;">*</sup></label>
        <div class="col-lg-9">
          <input type="text" class="form-control" name="inputLocal" id="inputLocal"  value="<?= $_SESSION['auth']->localite; ?>">
          <span id="helpLocal"></span>
        </div>
      </div>
      <div class="form-group">
        <label for="inputPays" class="col-lg-3 control-label">Pays<sup style="color:red;">*</sup></label>
        <div class="col-lg-9">
          <input type="text" class="form-control" name="inputPays" id="inputPays"  value="<?= $_SESSION['auth']->country; ?>">
          <span id="helpPays"></span>
        </div>
      </div>
      <div class="form-group">
        <label for="inputPhone" class="col-lg-3 control-label">Téléphone<sup style="color:red;">*</sup></label>
        <div class="col-lg-9">
          <input type="text" class="form-control" name="inputPhone" id="inputPhone"  value="<?= $_SESSION['auth']->telephone; ?>">
          <span id="helpPhone"></span>
        </div>
      </div>
    <div class="form-group">
      <div class="col-lg-9 col-lg-offset-2">
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
    </div>

    </div>


</form>

<?php require 'inc/footer.php';