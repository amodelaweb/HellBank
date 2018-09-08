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

      myJson["id_tarjeta_credito"] =  document.getElementById("nump").innerHTML;
      myJson["id_ahorros"] =  document.getElementById("cuen").innerHTML;
      myJson["cupo_maximo"] =  document.getElementById("cupomax").value;
      myJson["sobre_cupo"] =  document.getElementById("sobre_cupo").value;
      myJson["tasa_interes"] =  document.getElementById("tasa_interes").value;
      myJson["cuota_manejo"] =  document.getElementById("cuota_manejo").value;
      myJson["estado"] =  "APROBADO";

      return JSON.stringify(myJson);
    }

    var test = getUrlVars();

    localStorage.setItem('gameStorage', test);
    console.log("ok");
    $.ajax({
      type: "POST",
      dataType: 'JSON',
      url: "/HellBank/api/Admin/Tarjeta_Credito/edit_tarjetas.php",
      data: test,
      ContentType: "application/json",
      headers: {
        "x-api-key": window.localStorage.accessToken ,
      },
      success: function(response) {
        alert('TARJETA APROBADA !!');
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

      myJson["id_tarjeta_credito"] =  document.getElementById("nump").innerHTML;
      myJson["id_ahorros"] =  document.getElementById("cuen").innerHTML;
      myJson["cupo_maximo"] =  document.getElementById("cupomax").value;
      myJson["sobre_cupo"] =  document.getElementById("sobre_cupo").value;
      myJson["tasa_interes"] =  document.getElementById("tasa_interes").value;
      myJson["cuota_manejo"] =  document.getElementById("cuota_manejo").value;
      myJson["estado"] =  "NO_APROBADO";

      return JSON.stringify(myJson);
    }

    var test = getUrlVars();

    localStorage.setItem('gameStorage', test);
    console.log("ok");
    $.ajax({
      type: "POST",
      dataType: 'JSON',
      url: "/HellBank/api/Admin/Tarjeta_Credito/edit_tarjetas.php",
      data: test,
      ContentType: "application/json",
      headers: {
        "x-api-key": window.localStorage.accessToken ,
      },
      success: function(response) {
        alert('TARJETA RECHAZADA');
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
        if (option.id==data.tarj) {
          document.getElementById("nump").innerHTML = option.id;
          document.getElementById("idDu").innerHTML = option.id_dueno;
          document.getElementById("cuen").innerHTML =  option.id_ahorros;
        }
        //$('#tarjetas').append($('<option/>').attr("value", option.id).text("ID tarjeta: " + option.id + ", Se pidio en la fecha " + option.fecha_creado));
      });

    },
    error: function(response) {
      console.log(response);
    }
  });
}
