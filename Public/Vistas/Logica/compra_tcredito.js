$(document).ready(function() {

  $('#ok_crear').click(function(e) {
    e.preventDefault();

    function getUrlVars() {
      var combo = document.getElementById("cuentas_usr");
      var combo2 = document.getElementById("n_cuotas");
      var combo3 = document.getElementById("moneda");

      var hash;
      var myJson = {};

      myJson["id_tcredito"] = combo.options[combo.selectedIndex].value;
      myJson["cuotas"] = combo2.options[combo2.selectedIndex].value ;
      myJson["monto"] = document.getElementById("monto").value;
      myJson["tipo_moneda"] = combo3.options[combo3.selectedIndex].value ;

      return JSON.stringify(myJson);
    }

    var test = getUrlVars();

    localStorage.setItem('gameStorage', test);
    console.log("ok");
    $.ajax({
      type: "POST",
      dataType: 'JSON',
      url: "/HellBank/api/Transferencias/compra_tarjeta.php",
      data: test,
      ContentType: "application/json",
      headers: {
        "x-api-key": window.localStorage.accessToken,
      },
      success: function(response) {
        alert('Compra exitosa !');
        console.log(response);
      },
      error: function(response) {
        //console.log(response.responseJSON.error);
        alert("Error : " + response.responseJSON.error);
      }
    });
  });
  if (window.localStorage.rol != "user") {
    window.close();
    var para = document.createElement("P");
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

  } else {
    console.log("Yei !!");

    $.ajax({
      url: "/HellBank/api/Tarjeta_Credito/get_all.php",
      type: 'GET',
      dataType: 'json',
      headers: {
        "x-api-key": window.localStorage.accessToken,
      },
      success: function(response) {
        $cuentas = response.tarjeta_credito;
        $.each($cuentas, function(i, option) {
          $('#cuentas_usr').append($('<option/>').attr("value", option.id).text("ID : " + option.id + " - CUPO : " + option.cupo_maximo + " - GASTADO : " + option.gastado));
        });

      },
      error: function(response) {
        console.log(response);
      }
    });
  }
});
