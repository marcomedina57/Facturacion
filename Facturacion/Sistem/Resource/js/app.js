/* CODIGO DE USUARIOS */
var dataUser = null;
var usuarios = new Usuarios();

var loginUser = () => {
    usuarios.loginUser();

}

var sessionClose = () => {
    usuarios.sessionClose()
    {

    }
}
var restablecerUser = () => {
    usuarios.restablecerUser();
}

var archivo = (evt) => {
    usuarios.archivo(evt, 'fotos');
}



$('#registerUser').click(function () {

    usuarios.registerUser();

});
$("#registerClose").click(function () {
    usuarios.restablecerUser();
});

$("#deleteUser").click(function () {
    usuarios.deleteUser(data_User);;
    data_User = null;
});

var getUsers = (page) => {
    let valor = document.getElementById('filtrarUser').value;
    usuarios.getUsers(valor, page);

}


var dataUser = (data) => {
    usuarios.editUser(data);

}

var deleteUser = (data) => {
    document.getElementById("userName").innerHTML = data.Email;
    data_User = data;
}
//Principal

var principal = new Principal();

$().ready(() => {

    let URLactual = window.location.pathname;

    usuarios.userData(URLactual);
    principal.linkPrincipal(URLactual);
    $("#validate").validate()
    // $(".sidenav").sidenav();
    // $('.modal').modal();
    //  $('select').formSelect();
    M.AutoInit();


});