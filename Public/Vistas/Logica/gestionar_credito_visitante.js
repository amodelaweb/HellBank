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

  $('#aprobar_but').click(function(e) {
    e.preventDefault();

    function getUrlVars() {
      var hash;
      var myJson = {};

      myJson["id_credito"] =  document.getElementById("numPro").innerHTML;
      myJson["tasa_interes"] = 0;
      myJson["interes_mora"] =  0;
      myJson["estado"] =  "APROBADO";

      return JSON.stringify(myJson);
    }

    var test = getUrlVars();

    localStorage.setItem('gameStorage', test);
    console.log("ok");
    $.ajax({
      type: "POST",
      dataType: 'JSON',
      url: "/HellBank/api/Admin/Creditos/edit_credito.php",
      data: test,
      ContentType: "application/json",
      headers: {
        "x-api-key": window.localStorage.accessToken ,
      },
      success: function(response) {
        alert('CREDITO APROBADO !!');
        console.log(response);
      },
      error: function(response) {
        console.log(response);
        alert("Error : " + response.responseJSON.error);
      }
    });
  });

  $('#rechazar_but').click(function(e) {
    e.preventDefault();

    function getUrlVars() {
      var hash;
      var myJson = {};

      myJson["id_credito"] =  document.getElementById("numPro").innerHTML;
      myJson["tasa_interes"] =  0;
      myJson["interes_mora"] =  0;
      myJson["estado"] =  "NO_APROBADO";

      return JSON.stringify(myJson);
    }

    var test = getUrlVars();

    localStorage.setItem('gameStorage', test);
    console.log("ok");
    $.ajax({
      type: "POST",
      dataType: 'JSON',
      url: "/HellBank/api/Admin/Creditos/edit_credito.php",
      data: test,
      ContentType: "application/json",
      headers: {
        "x-api-key": window.localStorage.accessToken ,
      },
      success: function(response) {
        alert('CREDITO RECHAZADO !');
        console.log(response);
      },
      error: function(response) {
        //console.log(response.responseJSON.error);
        alert("Error : " + response.responseJSON.error);
      }
    });
  });


});

var data;
window.onload = function () {
  var url = document.location.href,
  params = url.split('?')[1].split('&'),
  data = {}, tmp;
  for (var i = 0, l = params.length; i < l; i++) {
    tmp = params[i].split('=');
    data[tmp[0]] = tmp[1];
  }
  //console.log(data.crec);
  //document.getElementById('numPro').innerHTML = data.crec;
  var l =data.crec;

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
        if (option.id==data.crei) {
          console.log(option.$email_vis);
          document.getElementById("numPro").innerHTML = option.id;
          document.getElementById("monto").innerHTML = option.monto;
          document.getElementById("email_vis").innerHTML =  option.email_vis;
        }
        //$('#tarjetas').append($('<option/>').attr("value", option.id).text("ID tarjeta: " + option.id + ", Se pidio en la fecha " + option.fecha_creado));
      });

    },
    error: function(response) {
      console.log(response);
    }
  });
}
