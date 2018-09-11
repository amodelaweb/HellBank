$(document).ready(function() {
  var tok = window.localStorage.accessToken ;
  if (typeof tok !== 'undefined') {
    console.log(tok);
    if (window.localStorage.rol == "user"){
      window.location.href = './Vistas/PrincipalCliente.html';
    }else if (window.localStorage.rol == "admin") {
      window.location.href = './Vistas/PrincipalAdmin.html';
    }
  }else{
    window.location.href = './Vistas/Login.html';
  }
} );
