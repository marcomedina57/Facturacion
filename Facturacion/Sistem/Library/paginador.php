<?php
class paginador extends Conexion{
    public function __construct()
    {
        parent::__construct();
    }

    public function paginador($columns,$table,$method,$page,$where,$array)
    {   $_pagi_enlace = null;
        //Cantidad de resultados por pagina
        $_pagi_cuantos = 1;
        //Cantida de enalces que se mostraran como maximo en la barra de navegacion
        $_pagi_nav_num_enlaces = 3;
        //Decidimos si queremos que se muestren los errores de mysql
        $_pagi_mostrar_errores = false;
        //Definimos que ira en el enlace a la pagina anterior
        $_pagi_nav_anterior = "&laquo; Anterior ";
        //Definimos que ira en el enlace a la pagina siguinete
        $_pagi_nav_siguiente = "Siguiente &raquo; ";
        //Consulta a la base de datos y la tabla
        
        if(!isset($_pagi_nav_primera)){
            $_pagi_nav_primera = "&laquo; Primero";
        }
        if(!isset($_pagi_nav_ultima))
        {
            $_pagi_nav_ultima = "Ultimo &raquo; ";
        }
        if(empty($page)){
            // Es la pagina actual, por defecto es la primera
            $_pagi_actual = 1;
        }else{
            $_pagi_actual = $page;
        }
        $response = $this->db->select1($columns,$table,null,null);
        if(is_array($response))
        {
            $_pagi_result = $response['results'];
        }
        else {
            return $response;
        }
        $_pagi_totalReg = count($_pagi_result);


        //Calcular el numero de paginas
        $_pagi_totalPags = ceil($_pagi_totalReg / $_pagi_cuantos);
    
        $_pagi_navegacion_temporal = array();

        if($_pagi_actual != 1) 
        {
            $_pagi_url = 1; //Sera el numero de pagina al que enlazamos
            $_pagi_navegacion_temporal[] = "<a id='paginas1'href='#' onclick='"."get".$method."
            (".$_pagi_url.")'>$_pagi_nav_primera</a>";
        
            $_pagi_url = $_pagi_actual - 1; //Numero de pagina al que enlazaremos
            $_pagi_navegacion_temporal[] = "<a id='paginas1'href='#' onclick='"."get".$method."
            (".$_pagi_url.")'>$_pagi_nav_anterior</a>";
        }

        //la variable $_pagi_nav_num_enlaces sirve apra definir cuantos enlaces con numero de pagina
        // se mostraran como maximo
        if(!isset($_pagi_nav_num_enlaces))
        {
            //Si no se definicio la variable, se asume que se mostraran todos los numeros de pagina de los enlaces
            $_pagi_nav_desde = 1;
            $_pagi_nav_hasta = $_pagi_totalPags;
        }
        else {
            //Calculamos el intervalo para restar y sumar a partir de la pagina actual
            $_pagi_nav_intervalo = ceil($_pagi_nav_num_enlaces/2) - 1;
            //Calculamos desde que numero de pagina se msotrara
            $_pagi_nav_desde = $_pagi_actual - $_pagi_nav_intervalo;
            //Calculamos hasta que numero de pagina se mostrara
            $_pagi_nav_hasta = $_pagi_actual + $_pagi_nav_intervalo;
            //Si $_pagi_nav_desde es un numero negativo
            if($_pagi_nav_desde < 1){
                //Le sumamos la cantidad sobrante al final para mantener el numero de enlaces
                // que mostrar
                $_pagi_nav_hasta -= ($_pagi_nav_desde - 1);
                //$_pagi_nav_hasta 
                //Establecemos $_pagi_nav_desde como 1;
                $_pagi_nav_desde = 1;
                 }
                if ($_pagi_nav_hasta > $_pagi_totalPags)
                {   
                    $_pagi_nav_desde -= ($_pagi_nav_hasta - $_pagi_totalPags);
                    
                    $_pagi_nav_hasta = $_pagi_totalPags;
                
                if ($_pagi_nav_desde < 1)
                {
                    $_pagi_nav_desde = 1;
                }
                }
   
            
            
            for ($_pagi_i = $_pagi_nav_desde; $_pagi_i<=$_pagi_nav_hasta;$_pagi_i++)
            {
                
                //DEsde pagina 1 hasta ultima pagina($_pagi_totalPags)
                if($_pagi_i == $_pagi_actual)
                {
                    // Si el numero de pagina es la actual, se escribe sin enlace y en negrita
                    $_pagi_navegacion_temporal[] = "<span id='paginas2'>$_pagi_i</span>";

                }
                else 
                {
                    $_pagi_navegacion_temporal[] = "<a id='paginas1' href='#' onclick='"."get".$method."
                    (".$_pagi_i.")'>".$_pagi_i."</a>";
                }
            }
            if ($_pagi_actual < $_pagi_totalPags)
            {
                //Si no estamos en la ultima pagina. Ponemos el enlace "Siguiente"
                $_pagi_url = $_pagi_actual + 1; //Sera el numero dep agina al que enlazaremos
                $_pagi_navegacion_temporal[] = "<a id='paginas1' href='#' onclick='"."get".$method."
                (".$_pagi_url.")'>$_pagi_nav_siguiente</a>";

                // Si no estamos en la ultima pagina. POnemso el enlace "Ultima"
                $_pagi_url = $_pagi_totalPags;
                $_pagi_navegacion_temporal[] = "<a class= 'waves-effect' href='#'
                onclick='"."get".$method."(".$_pagi_url.")'>$_pagi_nav_ultima</a>";
            }
            // Obtencion de los registros

            $_pagi_navegacion = implode($_pagi_navegacion_temporal);
            //Recordemos que el conteo comienza  en cero
            
            $_pagi_inicial = ($_pagi_actual-1) * $_pagi_cuantos;
            $response = $this->db->select2($columns,$table,$_pagi_inicial,$_pagi_cuantos,$where,$array);
            
            if(is_array($response))
            {
                $_pagi_result2 = $response['results'];
            }
            else {
                return $response;
            }


                //Numero del primer registro de la pagina actual
            $_pagi_desde = $_pagi_inicial + 1;

                //Numero del ultimo registro 
            $_pagi_hasta = $_pagi_inicial + $_pagi_cuantos;
            if ($_pagi_hasta > $_pagi_totalReg)
            {
                //Si entramos en la ultima pagina 
                //El ultimo registro de la pagina actual sera igual al numero de registros
                $_pagi_hasta = $_pagi_totalReg;
            }
            $_pagi_info = " del <b>$_pagi_desde</b> al <b>$_pagi_hasta</b> de <b>$_pagi_totalReg</b>";
            return array(
                "results" => $_pagi_result2,
                "pagi_navegacion" => $_pagi_navegacion,
                "pagi_info" => $_pagi_info
            );
        }


    }
    

}


?>