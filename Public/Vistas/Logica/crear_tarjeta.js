$(document).ready(function() {
  $('#pedir_tarjeta').click(function(e) {
    e.preventDefault();
    console.log("lol");
    function getUrlVars() {
      var hash;
      var myJson = {};

      myJson["id_dueno"] =  document.getElementById("id_cuenta").value ;
      myJson["id_ahorros"] =  document.getElementById("id_cuenta").value ;
      myJson["cupo_maximo"] =  document.getElementById("id_cuenta").value ;
      myJson["sobre_cupo"] =  document.getElementById("id_cuenta").value ;
      myJson["cuota_manejo"] =  document.getElementById("id_cuenta").value ;
      myJson["tasa_interes"] =  document.getElementById("id_cuenta").value ;
      return JSON.stringify(myJson);
    }
    var test = getUrlVars();

    localStorage.setItem('gameStorage', test);
    console.log("ok");
    $.ajax({
      type: "POST",
      dataType: 'JSON',
      url: "/HellBank/api/Tarjeta_Credito/create.php",

      data: test,
      ContentType: "application/json",
      headers: {
        "x-api-key": window.localStorage.accessToken ,
      },
      success: function(response) {
        alert('Credito creado !');
        console.log(response);
      },
      error: function(response) {
        //console.log(response.responseJSON.error);
        alert("Error : " + response.responseJSON.error);
      }
    });
  });
});
