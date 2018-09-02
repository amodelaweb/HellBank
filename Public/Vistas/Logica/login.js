$(document).ready(function() {
  $('#id_iniciar').click(function(e) {
    e.preventDefault();

    function getUrlVars() {
      var hash;
      var myJson = {};
      myJson["user_name"] =  document.getElementById("user_name").value ;
      myJson["password"] =  document.getElementById("pass_im").value ;

      return JSON.stringify(myJson);
    }

    var test = getUrlVars();

    localStorage.setItem('gameStorage', test);
    console.log("ok");
    $.ajax({

      type: "POST",
      dataType: 'JSON',
      url: "/HellBank/api/Usuarios/manage_auth.php",
      data: test,
      ContentType: "application/json",

      success: function(response, status, xhr) {
        alert('Sesion Iniciada !');
        window.localStorage.accessToken = response.access_token;
        window.localStorage.rol = response.rol;
        if (response.rol == "user"){
          console.log("soy_user");
          window.location.href = './PrincipalCliente.html';
        }else if (response.rol == "admin") {
          console.log("soy_admin");
          window.location.href = './PrincipalAdmin.html';
        }else{
            console.log("soy_nada");
        }

      },
      error: function(response) {
        alert('Usuario/Contraseña Erronea');
        console.log(response);
      }

    });
  });
});
