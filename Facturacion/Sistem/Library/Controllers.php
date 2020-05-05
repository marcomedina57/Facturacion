<?php
class Controllers extends Anonymous{
    public function __construct()
    {   Session::star();
        $this->view  = new Views();
        $this->image = new Uploadimage();
        $this->page = new paginador();
        $this->loadClassmodels();
    }
    function loadClassmodels(){
        $model = get_class($this).'_model';
        $path = 'Models/' .$model.'.php';
        if(file_exists($path)){
            require $path;
            $this->model = new $model();
        }
    }
}

?>