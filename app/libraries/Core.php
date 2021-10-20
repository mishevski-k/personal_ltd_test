<?php
    // Core app Class
    class Core {
        protected $currentController = 'AdminController';
        protected $currentMethod = 'index';
        protected $params = [];

        public function __construct() {
            $url = $this->getUrl();
            
            if(empty($url)) {
                $url = ['admin'];
            }
            
                //Looking for controller with first value from url
            if(file_exists('../app/controllers/' . ucwords($url[0] . 'Controller') . '.php')) {
                $this->currentController = ucwords($url[0] . 'Controller');
                unset($url[0]);
            }

            //Require the controller 
            require_once '../app/controllers/' . $this->currentController . '.php';
            $this->currentController = new $this->currentController;

            //Looking for method with second value from url
            if(isset($url[1])) {
                if(method_exists($this->currentController, $url[1])) {
                    $this->currentMethod = $url[1];
                    unset($url[1]);
                }
            }

            //Get params
            $this->params = $url ? array_values($url) : []; 
            //Call a callback with array of params
            call_user_func_array([$this->currentController, $this->currentMethod], $this->params);

            unset($url);
            
        }   

        public function getUrl() {
            if(isset($_GET['url'])) {
                $url = rtrim($_GET['url'], '/');
                // Allows you to filter variables as string/number
                $url = filter_var($url, FILTER_SANITIZE_URL);
                //Breaking url into an array
                $url = explode('/', $url);
                return $url;
            }
        }
    }
?>