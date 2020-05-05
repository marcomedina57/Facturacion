<?php
 class Index_model extends Conexion{

    function __construct()
    {
        parent::__construct();
    }

    function userLogin($email, $password)
    {
        $where = " WHERE Email = :Email";
        $param = array('Email' => $email);
        $response = $this->db->select1('*','usuarios',$where, $param);
            if (is_array($response)) {
                if (0 != count($response['results'])){ 
                $response = $response['results'][0];
                if (password_verify($password, $response['Password'])) {
                    $data = array(
                        "IdUsuario" =>   $response['IdUsuario'],
                        "Nombre"    =>   $response['Nombre'],
                        "Apellido"  =>   $response['Apellido'],
                        "Roles"     =>   $response['Roles'],
                        "Image"     =>   $response['Imagen']
                    );
                    Session::setSession("User", $data);
                    return $data;
                }
                else {
                    $data = array(
                        "IdUsuario" => 0
                    );
                    return $data;
                }
            }
                 else {
                 return "El email no está registrado"; 
                }
            }
                 else {
                return $response;
                }   
        
        

    }

}


?>