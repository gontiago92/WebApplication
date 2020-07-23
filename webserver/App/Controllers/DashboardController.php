<?php

namespace Controllers;

/**
 * Class DashboardController
 *
 * @package \App\Controllers
 */
class DashboardController extends Controller
{

    public function index()
    {
        $pageTitle = "Todos os posts";

        $articles = $this->model->findAll();

        //echo "<pre>" . print_r($articles, true) . "</pre>";

        $this->render('dashboard/index', compact('pageTitle', 'articles'));

    }

    public function edit($id = null)
    {

        $article_id = null;
        
        // Mais si il y'en a un et que c'est un nombre entier, alors c'est cool
        if (isset($id) && ctype_digit($id)) {
            $article_id = $id;
        }

        // On peut désormais décider : erreur ou pas ?!
        if (!$article_id) {
            die("Vous devez préciser un paramètre `id` dans l'URL !");
        }
        
        
        /**
         * 3. Récupération de l'article en question
         * On va ici utiliser une requête préparée car elle inclue une variable qui provient de l'utilisateur : Ne faites
         * jamais confiance à ce connard d'utilisateur ! :D
         */
        
        $article = $this->model->find($article_id);

        if (!$article) {
            die("Cet article ne semble pas exister dans notre base de données !");
        }


        if (isset($_POST["title"]))
        {
            if ($this->model->edit($id, $_POST["title"], $_POST["introduction"], $_POST["content"]))
            {
                $this->redirect('/dashboard/index');
            }
        }

        $pageTitle = "Editar post";

        $this->render('dashboard/edit', compact('pageTitle', 'article', 'article_id'));

    }

}
