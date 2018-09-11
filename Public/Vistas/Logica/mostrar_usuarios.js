$(document).ready(function() {
  if (window.localStorage.rol != "admin"){
    window.close();
    alert('ABANDONE ESTA PAGINA WEB !!!');
    alert('ABANDONE ESTA PAGINA WEB !!!');
    alert('ABANDONE ESTA PAGINA WEB !!!');
    alert('ABANDONE ESTA PAGINA WEB !!!');
    alert('ABANDONE ESTA PAGINA WEB !!!');
    alert('ABANDONE ESTA PAGINA WEB !!!');
    alert('ABANDONE ESTA PAGINA WEB !!!');
    alert('ABANDONE ESTA PAGINA WEB !!!');
    alert('ABANDONE ESTA PAGINA WEB !!!');
    window.location.href = 'http://www.burlingtonnews.net/hauntedtours-theweek.html';
    para.appendChild(t);

  }
});
function MostrarUsuarios() {

//-----------------------------------------------------------------------
  $.ajax({
    url: "/HellBank/api/Admin/Usuarios/get_all_users.php",
      type: 'GET',
      dataType: 'json',
      headers: {
        "x-api-key": window.localStorage.accessToken,
      },
      success: function(response) {
        console.log(response);
        $tarjetas = response.usuarios;
        $.each($tarjetas, function(i, option) {
          $("<tr><td>"  + option.nombre+ "</td><td>" + option.apellido+ "</td><td>" + option.id + "</td><td>" + option.rol +   "</td><td>" +  "<a href=" + "javascript:make_an_admin("+  option.id +");" + ">Make Admin !</a> "+    "</td><td>" +  "<a href=" + "javascript:make_an_user("+  option.id +");" + ">Make User !</a> " + "</td></tr>").appendTo("#usuarios")

          //$('#tarjetas').append($('<option/>').attr("value", option.id).text("ID tarjeta: " + option.id + ", Se pidio en la fecha " + option.fecha_creado));
        });
//-----------------------------------------------------------------------
      },
      error: function(response) {
        console.log(response);
      }
    });

  }

  function make_an_admin(p1) {

    function getUrlVars1() {
      var hash;
      var myJson = {};
      myJson["usr_id"] = p1 ;

      return JSON.stringify(myJson);
    }

    var test = getUrlVars1();


    $.ajax({
      type: "PUT",
      dataType: 'JSON',
      url: "/HellBank/api/Admin/Usuarios/make_admin.php",
      data: test,
      ContentType: "application/json",
      headers: {
        "x-api-key": window.localStorage.accessToken,
      },
      success: function(response) {
        alert('Usuario ahora es un admin !');
         location.reload();
        console.log(response);
      },
      error: function(response) {
        //console.log(response.responseJSON.error);
        alert("Error : " + response.responseJSON.error);
      }
    });


  }

  function make_an_user(p1) {

    function getUrlVars1() {
      var hash;
      var myJson = {};
      myJson["usr_id"] = p1 ;

      return JSON.stringify(myJson);
    }

    var test = getUrlVars1();


    $.ajax({
      type: "PUT",
      dataType: 'JSON',
      url: "/HellBank/api/Admin/Usuarios/make_user.php",
      data: test,
      ContentType: "application/json",
      headers: {
        "x-api-key": window.localStorage.accessToken ,
      },
      success: function(response) {
        alert('Usuario ahora es un usuario !');
         location.reload();
        console.log(response);
      },
      error: function(response) {
        //console.log(response.responseJSON.error);
        alert("Error : " + response.responseJSON.error);
      }
    });


  }
