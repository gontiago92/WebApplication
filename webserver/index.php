<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="images/favicon.ico">

    <title>Mon Site</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="stylesheet" href="public/assets/fontawesome/css/all.css">
    <link rel="stylesheet" href="public/css/application.css">
    <link rel="stylesheet" href="public/css/webserver.css">
</head>

<body>

<header id="titlebar">
    <div id="drag-region">
        <div id="window-title"><span>CarMan</span></div>
        <div id="window-controls">
            <div class="button" id="min-button"><i class="fas fa-window-minimize"></i></div>
            <div class="button" id="max-button"><i class="far fa-window-maximize"></i></div>
            <div class="button" id="restore-button"><i class="far fa-window-restore"></i></div>
            <div class="button" id="close-button"><i class="fas fa-times"></i></div>
        </div>
    </div>
</header>

<div id="app">

<div id="mainpage" class="container py-4">

    <div id="messages" class="alert" style="display: none; position: relative;"></div>

    <div class="jumbotron">
        <h1>Formulaire de contact</h1>
    </div>

    <form id="sendmail" action="traitement-email.php" method="POST">

        <div class="form-group">
            <label for="name">Votre nom</label>
            <input type="text" name="name" class="form-control" id="name">
        </div>

        <div class="form-group">
            <label for="exampleInputEmail1">Votre adresse email</label>
            <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="_replyto">
            <small id="emailHelp" class="form-text text-muted">Message pour l'utilisateur</small>
        </div>

        <div class="form-group">
            <label for="message">Votre adresse email</label>
            <textarea name="message" id="message" cols="30" rows="5" style="resize:none" class="form-control"></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Envoyer</button>

    </form>

</div><!-- end of container -->

</div>


    <script src="public/js/app.js"></script>
    <script>
        Application.init()

        document.querySelector('#sendmail').addEventListener('submit', e => {
            Application.sendmail(e);
        });
    </script>
  </body>
</html>
