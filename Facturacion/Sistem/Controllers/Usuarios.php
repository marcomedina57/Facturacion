<?php
class Usuarios extends Controllers
 {
    function __construct(){
        parent::__construct();
       
    }

    public function getUsers()
    {   $count = 0;
        $dataFilter = null;
        $data = $this->model->getUsers($_POST['filter'], $_POST['page'], $this->page);
        if (is_array($data))
        {   
            $array = $data['results'];
            foreach($array as $key => $value)
            {   $dataUser =  json_encode($array[$count]);
                $dataFilter .= "<tr>" . 
                "<td>".$value['NID']."</td>".
                "<td>".$value['Nombre']."</td>".
                "<td>".$value['Usuario']."</td>".
                "<td>".$value['Roles']."</td>".
                "<td>".
                "<a  href = '#modal1' onclick = 'dataUser(".$dataUser.")'
                class = 'modal-trigger btn btn-danger'>Edit</a> | " .

                "<a  href = '#modal2' onclick = 'deleteUser(".$dataUser.")'
                class = 'modal-trigger btn btn-danger'>Eliminar</a> | " .
                "</td>". 
                "</tr>"; 
                $count ++;
            }
            
            $paginador = "</p> <p>Resultados" .$data['pagi_info']."</p><p>".$data['pagi_navegacion']
            ."</p> ";
            echo json_encode( array(
                "dataFilter" => $dataFilter,
                "paginador" => $paginador
            ));
        }else
        {
            echo $data;
        }

    }
    public function editUser()
    {
        $archivo = null;
        $tipo    = null;
        $imagen =  null;
        if (isset($_FILES['file']))
        {
            $tipo = $_FILES['file']['type'];
            $archivo = $_FILES['file']['tmp_name'];
            $imagen = $this->image->cargar_imagen($tipo,$archivo,$_POST['email'],"usuarios");
       }
        else {
            if (isset($_POST['imagen']))
            {
                
                $archivo = $_POST['imagen'];
                $imagen = $this->image->cargar_imagen($tipo,$archivo,$_POST['email'],"usuarios");
                if ($_POST['imagen'] != $_POST['email'].".png")
                {
                    $archivo = RQ."images/fotos/usuarios/".$archivo;
                        unlink($archivo);
                        $archivo = null;
                }
            }
        }
        $response = $this->model->getUser($_POST['idUsuario']);
        if (is_array($response))
        {   
            $array = array(
                $_POST['nid'], $_POST['nombre'],$_POST['apellido'],$_POST['email'],
                $response[0]['Password'],$_POST['telefono'], $_POST['usuario'], $_POST['role'], $imagen
            );
            echo 'diablito show';
            print_r($this->userClass($array));
            echo 'fin';
            echo $this->model->editUser($array,$_POST['idUsuario']);
        
        }
        else {
            echo $response;
        }
    }

    public function deleteUser()
    {
        echo $this->model->deleteUser($_POST['idUsuario'],$_POST['email']);
        
    }

    public function destroySession(){
        Session::destroy();
        header("Location:" .URL);
    }

    public function usuarios(){
        if (null != Session::getSession("User")) {
            $this->view->render($this, "usuarios");
        } else {
            header("Location:". URL);
        }
        
       
    }
 function getRoles(){
    $data = $this->model->getRoles();
    if (is_array($data)){
        echo json_encode($data);
    }
    else {
        echo $data;
    }
  } 

 public function registerUser()
    {
        $user = Session::getSession('User');
      /*  $archivo = null;
        $tipo    = null;
    if (isset($_FILES['file'])){
        $tipo = $_FILES['file']['type'];
        $archivo = $_FILES['file']['tmp_name'];
        
    }
    $imagen = $this->image->cargar_imagen($tipo, $archivo, $_POST['email'],"usuarios");
        
    $array = array(
        $_POST['nid'],
        $_POST['nombre'],
        $_POST['apellido'],
        $_POST['telefono'],
        $_POST['email'],
        password_hash($_POST['password'], PASSWORD_DEFAULT),
        $_POST['usuario'],
        $_POST['role'],
        $imagen
    );

    $data = $this->model->registerUser($array);

    if ($data == 1){
        echo "El email ya esta registrado.. ";
    }
    else {
        echo $data;
     }

    }
    */
 }

?>