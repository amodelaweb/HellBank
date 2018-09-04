$(document).ready(function() {

  $('#ok_crear').click(function(e) {
    e.preventDefault();

    function getUrlVars() {
      var combo2 = document.getElementById("moneda");
      var combo3 = document.getElementById("tipo_d");
      var hash;
      var myJson = {};

      myJson["producto_destino"] = document.getElementById("destino").value;
      myJson["monto"] = document.getElementById("monto").value;
      myJson["tipo_moneda"] = combo2.options[combo2.selectedIndex].value ;
      myJson["tipo_destino"] = combo3.options[combo3.selectedIndex].value ;
      myJson["email"] = document.getElementById("correo").value;

      return JSON.stringify(myJson);
    }

    var test = getUrlVars();

    localStorage.setItem('gameStorage', test);
    console.log("ok");
    $.ajax({
      type: "POST",
      dataType: 'JSON',
      url: "/HellBank/api/Transferencias/consignacion_visitante.php",
      data: test,
      ContentType: "application/json",
      success: function(response) {
        alert('Consignacion exitosa !');
        console.log(response);
      },
      error: function(response) {
        //console.log(response.responseJSON.error);
        alert("Error : " + response.responseJSON.error);
        if( response.responseJSON.error == 'no_existe_visitante'){
          window.location.href = './CrearVisitante.html';
        }
      }
    });
  });

});
