<?php

namespace Controllers;

use Twig\Loader\FilesystemLoader;
use Twig\TwigFilter;

class Controller
{
    protected $model;
    protected $modelName = "\Models\Article";

    public function __construct()
    {
        $this->model = new $this->modelName();
    }

    public function index()
    {
        /**
         * 1. Récupération des articles
         */

        $articles = $this->model->findAll();
        
        /**
         * 2. Affichage
         */
        $pageTitle = "Accueil";
        
        $this->render('index', compact('pageTitle', 'articles'));
        
    }

    public function render($path, $variables = [])
    {
        
        $loader = new \Twig\Loader\FileSystemLoader([str_replace('public/index.php', '', $_SERVER['SCRIPT_FILENAME']) . '/views', str_replace('public/index.php', '', $_SERVER['SCRIPT_FILENAME']) . '/public']);
        $twig = new \Twig\Environment($loader, [
            'cache' => false
        ]);

        $twig->addFilter(new TwigFilter('timeago', function($datetime, $locale = 'en') {
            $time = time() - strtotime($datetime);

            $units = [
                "en" => [
                    31536000 => 'year',
                    2592000 => 'month',
                    604800 => 'week',
                    86400 => 'day',
                    3600 => 'hour',
                    60 => 'minute',
                    1 => 'second'
                ],
                "fr" => [
                    2592000 => 'mois',
                    604800 => 'semaine',
                    86400 => 'jour',
                    3600 => 'heure',
                    60 => 'minute',
                    1 => 'seconde'
                ],
                "pt" => [
                    2592000 => 'mês',
                    604800 => 'semana',
                    86400 => 'dia',
                    3600 => 'hora',
                    60 => 'minuto',
                    1 => 'segundo'
                ]
            ];

            foreach ($units[$locale] as $unit => $val) {
                if ($time < $unit) continue;
                $numberOfUnits = floor($time / $unit);

                if($locale == "en") {
                    return ($val == 'second')? 'a few seconds ago' : (($numberOfUnits>1) ? $numberOfUnits : (($val == 'hour') ? 'an' : 'a')) .' '.$val.(($numberOfUnits>1) ? 's' : '').' ago';
                } elseif ($locale == "fr") {
                    if($time > 5184000) {
                        setlocale(LC_TIME, ['fr', 'fra', 'fr_FR']);
                        return utf8_encode(strftime("%e %B %G", strtotime($datetime)));
                    } else {
                        return ($val == 'seconde')? 'à l\instant' : (($time > 2592000) ? "Il y a plus d'un mois" : "Il y a $numberOfUnits") .' '. (($val == 'mois') ? '' : $val) . (($val == 'mois') ? '' : (($numberOfUnits>1) ? 's' : ''));
                    }
                } elseif($locale == "pt") {
                    return ($val == 'second')? 'Agora mesmo' : 'há '. (($numberOfUnits>1) ? $numberOfUnits : (($val == 'hora') ? 'uma' : 'um')) .' '.$val.(($numberOfUnits>1) ? (($val == 'mês') ? 'es' : 's') : '');
                }
            }
        }));
        extract($variables);

        echo $twig->render("$path.twig", $variables);

        /*ob_start();

        require "../templates/$path.html.php";

        $pageContent = ob_get_clean();*/

        //require "../templates/layout.html.php";
    }

    public function redirect($file)
    {
        header("Location: $file");
        exit();
    }
}
