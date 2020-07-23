<?php

/**
 * CE FICHIER A POUR BUT D'AFFICHER LA PAGE D'ACCUEIL !
 * 
 * On va donc se connecter à la base de données, récupérer les articles du plus récent au plus ancien (SELECT * FROM articles ORDER BY created_at DESC)
 * puis on va boucler dessus pour afficher chacun d'entre eux
 */

require_once('../App/autoload.php');
require_once('../vendor/autoload.php');

$request = new Request($_SERVER['REQUEST_URI']);

//\App::debug($request);

$url = Router::parse($request->url);

\App::process($request, $url);