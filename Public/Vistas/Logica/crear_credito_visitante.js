$(document).ready(function() {
  $('#ok_crear').click(function(e) {
    e.preventDefault();
    function getUrlVars() {
      var hash;
      var myJson = {};

      myJson["monto"] =  document.getElementById("monto").value ;
      myJson["tasa_interes"] =  document.getElementById("tasa_interes").value ;
      myJson["email"] =  document.getElementById("email").value ;

      return JSON.stringify(myJson);
    }

    var test = getUrlVars();

    localStorage.setItem('gameStorage', test);
    console.log("ok");
    $.ajax({
      type: "POST",
      dataType: 'JSON',
      url: "/HellBank/api/Credito/create_visitante.php",
      data: test,
      ContentType: "application/json",

      success: function(response) {
        alert('Credito creado !');
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
  });});
