$(document).ready(function() {
$('#gurdar_b').click(function(e) {
  e.preventDefault();

  function getUrlVars1() {
    var hash;
    var myJson = {};
    myJson["fila"] =  "interes_aumento" ;
    myJson["valor"] =  document.getElementById("interes_aumento").value  ;
    return JSON.stringify(myJson);
  }

  function getUrlVars2() {
    var hash;
    var myJson = {};
    myJson["fila"] =  "interes_inter_banco";
    myJson["valor"] =  document.getElementById("interes_inter_banco").value ;
    return JSON.stringify(myJson);
  }

  function getUrlVars3() {
    var hash;
    var myJson = {};
    myJson["fila"] = "cuota_manejo_default";
    myJson["valor"] = document.getElementById("cuota_manejo_default").value ;
    return JSON.stringify(myJson);
  }

  var test = getUrlVars1();
  var test2 = getUrlVars2();
  var test3 = getUrlVars3();

  localStorage.setItem('gameStorage', test);
  console.log("ok");
  $.ajax({
    type: "PUT",
    dataType: 'JSON',
    url: "/HellBank/api/Admin/Sistema/change_system_var.php",
    data: test,
    ContentType: "application/json",
    headers: {
      "x-api-key": window.localStorage.accessToken ,
    },
    success: function(response) {
      alert('Actualizado interes entre bancos !');
      console.log(response);
    },
    error: function(response) {
      //console.log(response.responseJSON.error);
      alert("Error : " + response.responseJSON.error);
    }
  });

  $.ajax({
    type: "PUT",
    dataType: 'JSON',
    url: "/HellBank/api/Admin/Sistema/change_system_var.php",
    data: test2,
    ContentType: "application/json",
    headers: {
      "x-api-key": window.localStorage.accessToken ,
    },
    success: function(response) {
      alert('Actualizado interes visitantes !');
      console.log(response);
    },
    error: function(response) {
      //console.log(response.responseJSON.error);
      alert("Error : " + response.responseJSON.error);
    }
  });


  $.ajax({
    type: "PUT",
    dataType: 'JSON',
    url: "/HellBank/api/Admin/Sistema/change_system_var.php",
    data: test3,
    ContentType: "application/json",
    headers: {
      "x-api-key": window.localStorage.accessToken ,
    },
    success: function(response) {
      alert('Actualizado interes ahorros !');
      console.log(response);
    },
    error: function(response) {
      //console.log(response.responseJSON.error);
      alert("Error : " + response.responseJSON.error);
    }
  });


});
});
  function correr() {
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

    }else{

      $.ajax({
        url: "/HellBank/api/Admin/Tarjeta_Credito/get_tarjetas_credito_sin_aprobar.php",
        type: 'GET',
        dataType: 'json',
        headers: {
          "x-api-key": window.localStorage.accessToken,
        },
        success: function(response) {
          console.log(response);
          $tarjetas = response.tarjeta_credito;
          $.each($tarjetas, function(i, option) {
            $('#tarj').append($('<option/>').attr("value", option.id).text("ID tarjeta: " + option.id + ", Se pidio en la fecha " + option.fecha_creado));
          });

        },
        error: function(response) {
          console.log(response);
        }
      });

      $.ajax({

        url: "/HellBank/api/Admin/Creditos/get_creditos_cliente_sin_aprobar.php",
        type: 'GET',
        dataType: 'json',
        headers: {
          "x-api-key": window.localStorage.accessToken,
        },
        success: function(response) {
          console.log(response);
          $creditos = response.creditos;
          $.each($creditos, function(i, option) {
            $('#crec').append($('<option/>').attr("value", option.id).text("ID credito: " + option.id + ", Se pidio en la fecha " + option.fecha_creado));
          });

        },
        error: function(response) {
          console.log(response);
        }
      });

      $.ajax({
        url: "/HellBank/api/Admin/Creditos/get_creditos_visitante_sin_aprobar.php",
        type: 'GET',
        dataType: 'json',
        headers: {
          "x-api-key": window.localStorage.accessToken,
        },
        success: function(response) {
          console.log(response);
          $tarjetas = response.creditos;
          $.each($tarjetas, function(i, option) {
            $('#crei').append($('<option/>').attr("value", option.id).text("ID credito: " + option.id + ", Se pidio en la fecha " + option.fecha_creado));
          });

        },
        error: function(response) {
          console.log(response);
        }
      });
    }
  }
