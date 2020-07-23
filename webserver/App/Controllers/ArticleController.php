<?php

namespace Controllers;

class ArticleController extends Controller
{  

    protected $modelName = \Models\Article::class;
    
    public function show($id = null)
    {
        /**
         * 1. Récupération du param "id" et vérification de celui-ci
         */
        // On part du principe qu'on ne possède pas de param "id"
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
        
        /**
         * 4. Récupération des commentaires de l'article en question
         * Pareil, toujours une requête préparée pour sécuriser la donnée filée par l'utilisateur (cet enfoiré en puissance !)
         */
        
        $commentModel = new \Models\Comment();
        
        $commentaires = $commentModel->findAllByArticle($article_id);
        
        
        /**
         * 5. On affiche 
         */
        $pageTitle = $article['title'];
        
        $this->render('articles/show', compact('pageTitle', 'article', 'commentaires', 'article_id'));
    }

    public function delete($id = null)
    {

        /**
         * 1. On vérifie que le GET possède bien un paramètre "id" (delete.php?id=202) et que c'est bien un nombre
         */
        if (empty($id) || !ctype_digit($id)) {
            die("Ho ?! Tu n'as pas précisé l'id de l'article !");
        }

        $article = $this->model->find($id);

        if (!$article) {
            die("L'article $id n'existe pas, vous ne pouvez donc pas le supprimer !");
        }

        /**
         * 4. Réelle suppression de l'article
         */

        $this->model->delete($id);

        /**
         * 5. Redirection vers la page d'accueil
         */
        $this->redirect('/');

    }
}