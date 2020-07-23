<?php 

class Router 
{
    private $request;

    public function __construct(Request $request)
    {
        $this->request = self::parse($request->url);

    }

    public static function parse($url)
    {
        if(isset($url)) {
            $url = trim($url, '/');

            $exploded_url = explode('/', $url);
        }

        /** 
         * Remove array_slice function 
         * if there is no subdirectory
         * to the project folder
         * */
        //dd(array_slice($exploded_url, 1));

        return array_slice($exploded_url, 1);

        //return $exploded_url;
        
    }
}