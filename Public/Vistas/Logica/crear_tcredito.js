$(document).ready(function() {

  $('#ok_crear').click(function(e) {
    e.preventDefault();

    function getUrlVars() {
      var combo = document.getElementById("cuentas_usr");
      var hash;
      var myJson = {};
      myJson["cuenta_ahorros"] = combo.options[combo.selectedIndex].value;
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
        "x-api-key": window.localStorage.accessToken,
      },
      success: function(response) {
        alert('Tarjeta de credito creada !');
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
      url: "/HellBank/api/Cuentas_Ahorro/get_all.php",
      type: 'GET',
      dataType: 'json',
      headers: {
        "x-api-key": window.localStorage.accessToken,
      },
      success: function(response) {
        $cuentas = response.cuentas_ahorro;
        $.each($cuentas, function(i, option) {
          $('#cuentas_usr').append($('<option/>').attr("value", option.id).text("ID : " + option.id + " - SALDO : " + option.saldo));
        });

      },
      error: function(response) {
        console.log(response);
      }
    });
  }
});
