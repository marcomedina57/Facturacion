class Principal{
    constructor(){

    }
    linkPrincipal(link){
        
        if (link == PATHNAME + "Principal/principal" || link == PATHNAME + "Principal/principal/");
        {
            document.getElementById('enlace1').classList.add('active');

        }
        if (link == PATHNAME + "Usuarios/usuarios" || link == PATHNAME + "Usuarios/usuarios/");
        {
            document.getElementById('enlace2').classList.add('active');
            document.getElementById('files').addEventListener('change',archivo, false);
            getUsers(1);
        }
        
     /*   switch(link)
        {
            case PATHNAME + "Principal/principal":
            document.getElementById("enlace1").classList.add('active');
            break;
        
            case PATHNAME + "Usuarios/usuarios":
            document.getElementById("enlace2").classList.add('active');
            break;
            */
            
        
    }
}