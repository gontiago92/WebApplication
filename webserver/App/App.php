<?php

class App {

    static $url;
    static $controller;
    static $task;
    static $params;

    public function __construct()
    {

    }

    public static function process(Request $request, $url)
    {
    

        self::$url = array_slice($url, 1);
        self::$controller = $request->controller;
        self::$task = $request->task;
        self::$params = $request->params;

        if(isset(self::$url['0'])) {

            if (class_exists("\Controllers\\" . self::$url['0'] . "Controller")) {
                self::$controller = ucfirst(self::$url['0']) . 'Controller';
                unset(self::$url['0']);
            }
        }

        self::$controller = '\Controllers\\' . self::$controller;

        

        if(isset(self::$url['1'])) {
            if(method_exists(self::$controller, self::$url[1])) {
                self::$task = self::$url['1'];
                unset(self::$url[1]);
            }
        }
            
        self::$params = array_slice(self::$url, 0);

        call_user_func_array([new self::$controller, self::$task], self::$params);


        /*self::$controller = new self::$controller();
        self::$controller->index();
        /*
        if(isset($_GET['controller']) && !empty($_GET['controller'])) 
        {
            self::$controller = $_GET['controller'];
        }

        var_dump(self::$controller);

        self::$controller = '\Controllers\\' . self::$controller;

        self::$controller = new self::$controller();
        self::$controller->index();*/
    }

    public static function debug($var)
    {
        echo "<pre>" . print_r($var, true) . "</pre>";
    }

}