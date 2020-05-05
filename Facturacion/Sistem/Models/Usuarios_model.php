<?php
class Usuarios_model extends Conexion{

function __construct()
{
    parent::__construct();
}

function getRoles(){
    
    return $response = $this->db->select1("*", "roles", null, null);
    
}

public function registerUser($user){
   
    $where = " WHERE Email = :Email";
    $response = $this->db->select1("*", "usuarios", $where,  array('Email' => $user[4]));
    if (is_array($response)) {
        $response = $response['results'];
        echo count($response);
        if (0 == count($response)){
            $value = "(NID, Nombre, Apellido, Telefono, Email, Password, Usuario, Roles, Imagen) VALUES
            (:NID, :Nombre, :Apellido, :Telefono, :Email, :Password, :Usuario, :Roles, :Imagen)";
             $data = $this->db->insert("usuarios", $user, $value );
            if (is_bool($data))
            {
                return 0;
            }
            else 
            {
                return $data;
            }
            
         
        }   
        else {
            return 1;
        }     
    } else {
        return $response;
    }
    

}


    function getUsers($filter, $page, $model)
    {
        $where = " WHERE NID LIKE :NID OR Nombre LIKE :Nombre OR Apellido LIKE :Apellido ";
        $array = array(
            'NID' => '%'.$filter.'%',
            'Nombre' => '%'.$filter.'%',
            'Apellido' => '%' .$filter.'%'
        );
        $columns = "IdUsuario, NID, Nombre, Apellido, Email, Telefono, Usuario, Roles, Imagen";
        return $model->paginador($columns, "usuarios", "Users", $page,$where, $array);
     }

    function deleteUser($idUsuario, $email)
    {
        $where = " WHERE IdUsuario = :IdUsuario";
        $data = $this->db->delete("usuarios",$where,array('IdUsuario' => $idUsuario));
        if (is_bool($data))
        {
            $archivo = RQ."images/fotos/usuarios/".$email.".png";
            unlink($archivo);
            return 0;
        }
        else {
            return $data;
        }
    }

    function editUser($user, $idUsuario)
    {   echo 'Man who sold the world';
        print_r($user);
        $where = " WHERE Email = :Email";
        $response = $this->db->select1('*', 'usuarios', $where, array('Email' => $user[8]));
        if (is_array($response))
         
        {
         
             
            $response = $response['results'];
            
            $value = "NID = :0, Nombre = :1, Apellido = :2, Email = :3,
            Password = :4, Telefono = :5, Usuario = :6, Roles = :7, Imagen = :8";
            $where = " WHERE IdUsuario = " .$idUsuario;
            if(0 == count($response))
            {       $data = $this->db->update("usuarios", $user,$value,$where);
                if(is_bool($data))
                {   
                    return 0;
                }
                else 
                {   
                    return $data;
                }
            }
            else {
                if ($response[0]['IdUsuario'] == $idUsuario)
                {
                    $data = $this->db->update("usuarios", $user,$value,$where);
                    
                    if(is_bool($data))
                {
                    return 5;
                }
                else 
                {
                    return $data;
                }

                }else
                 {
                     return "El Email ya fue registrado";
                 }
            }
        }
        else {
            return $response;
        }
    }

    function getUser($idUsuario)
    {
        $where = " WHERE IdUsuario = :IdUsuario";
        $response = $this->db->select1("*", "usuarios", $where,  array('IdUsuario' => $idUsuario));
        if (is_array($response))
        {
            return $response = $response['results'];
        }
        else 
        {
            return $response;
        }
    }

}


?>