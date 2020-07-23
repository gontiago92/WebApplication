<?php
session_start();
require_once 'App/utils.php';

if(isset($_POST['submit'])) {
    $errors = array();
    require_once 'inc/db.php';

    if(empty($_POST['username']) || empty($_POST['email']) || empty($_POST['password']) || empty($_POST['password_confirm'])) {
        $errors['empty'] = "Tous les champs doivent être remplis";
    }

    if (!preg_match('/^[a-zA-Z0-9]+$/', $_POST['username'])) {
        $errors['username'] = "Votre pseudo n'est pas valide (alphanumérique)";
    } else {
        $req = $pdo->prepare("SELECT id FROM users WHERE username = ?");
        $req->execute(array($_POST['username']));
        $user = $req->fetch();
        if($user) {
            $errors['username'] = "Ce pseudo est déjà pris";
        }
    }

    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Votre email n'est pas valide";
    } else {
        $req = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $req->execute([$_POST['email']]);
        $user = $req->fetch();
        if($user) {
            $errors['email'] = "Cet email est déjà utilisé pour un autre compte";
        }
    }

    if ($_POST['password'] != $_POST['password_confirm']) {
        $errors['password'] = "Vos mots de passes ne correspondent pas";
    }

    if(empty($errors)) {
        require_once 'inc/db.php';
        $req = $pdo->prepare("INSERT INTO users SET firstname = ?, lastname = ?, username = ?, email = ?, password = ?, confirmation_token = ?");
        $encrypted_password = password_hash($_POST['password'], PASSWORD_BCRYPT);
        $token = str_random(60);
        $req->execute([$_POST['firstname'], $_POST['lastname'], $_POST['username'], $_POST['email'], $encrypted_password, $token]);
        $user_id = $pdo->lastInsertId();
       // mail($_POST['email'], 'Confirmation de votre compte', "Afin de valider votre compte, merci de cliquer sur ce lien:\n\n http://home.dev/Orcus/confirm.php?id=$user_id&token=$token");
        $to      = $_POST['email'];
        $subject = 'Confirmation de votre compte';
        $message = "Afin de valider votre compte, merci de cliquer sur ce lien:\n\n http://localhost/projects/Orcus/confirm.php?id=$user_id&token=$token";
        $headers = 'From: orcuswebmaster@gmail.com' . "\r\n" .
                   'Reply-To: orcuswebmaster@gmail.com' . "\r\n" .
                   'X-Mailer: PHP/' . phpversion();

        mail($to, $subject, $message, $headers);
        $_SESSION['flash']['success'] = 'Un email de confirmation vous a été envoyé pour valider votre compte';
        header('Location: login.php');
        exit();
    }
}

?>
<?php require 'inc/header.php'; ?>
    <h1>S'inscrire</h1>

<?php if(!empty($errors)): ?>
    <div class="alert alert-danger">
        <a class="close" href="">&times;</a>
        <p>Vous n'avez pas rempli votre formulaire correctement:</p>
        <ul>
            <?php foreach($errors as $error): ?>
                <li><?= $error; ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

    <form action="" method="post" name="form">

      <div class="form-group">
        <div class="col-md-6">
          <label>Nom</label>
          <input type="text" name="lastname" class="form-control" required/>
        </div>
        <div class="col-md-6" style="margin-bottom: 10px;">
          <label>Prénom</label>
          <input type="text" name="firstname" class="form-control" required/>
        </div>
      </div>

        <div id="pseudo" class="form-group">
            <label>Pseudo</label>
            <input id="username_input" type="text" name="username" class="form-control" required/>
            <div id="feedback"></div>
        </div>

        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required/>
        </div>

        <!--<div class="form-group">
            <label class=" control-label">Sexe</label>
            <div class="radio">
              <label>
                  <input type="radio" name="gender" value="homme" checked>
                  Homme
              </label>
            </div>
            <div class="radio">
              <label>
                  <input type="radio" name="gender" value="femme">
                  Femme
              </label>
            </div>
        </div>-->

        <div class="form-group">
            <label>Mot de passe</label>
            <input type="password" name="password" class="form-control" required/>
        </div>

        <div class="form-group">
            <label>Confirmez votre mot de passe</label>
            <input type="password" name="password_confirm" class="form-control" required/>
        </div>

        <button id="registerbtn" type="submit" name="submit" class="btn btn-primary">M'inscrire</button>

    </form>
<?php require 'inc/footer.php'; ?>
