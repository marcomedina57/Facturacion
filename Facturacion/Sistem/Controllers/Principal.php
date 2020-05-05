<?php
class Principal extends Controllers
{
    function __construct(){
        parent::__construct();
    }
    public function principal(){
        if (null != Session::getSession("User")) {
            $this->view->render($this, "Principal");
        } else {
            header("Location:". URL);
        }
        
       
    }

}


?>