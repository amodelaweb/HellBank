$(document).ready(function() {
  $('#ok_crear').click(function(e) {
    e.preventDefault();

    function getUrlVars() {
      var hash;
      var myJson = {};
      myJson["saldo"] =  document.getElementById("monto").value ;

      return JSON.stringify(myJson);
    }

    var test = getUrlVars();

    localStorage.setItem('gameStorage', test);
    console.log("ok");
    $.ajax({
      type: "POST",
      dataType: 'JSON',
      url: "/HellBank/api/Cuentas_Ahorro/create.php",
      data: test,
      ContentType: "application/json",
      headers: {
        "x-api-key": window.localStorage.accessToken ,
      },
      success: function(response) {
        alert('Cuenta de ahorros creada !');
        console.log(response);
      },
      error: function(response) {
        //console.log(response.responseJSON.error);
        alert("Error : " + response.responseJSON.error);
      }
    });
  });
  if (window.localStorage.rol != "user"){
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

  }else{
    console.log("Yei !!");
  }
});
