$(document).ready(function() {
  $('#ok_crear').click(function(e) {
    e.preventDefault();
    function getUrlVars() {
      var hash;
      var myJson = {};

      myJson["monto"] =  document.getElementById("monto").value ;
      myJson["tasa_interes"] =  document.getElementById("tasa_interes").value ;

      return JSON.stringify(myJson);
    }

    var test = getUrlVars();

    localStorage.setItem('gameStorage', test);
    console.log("ok");
    $.ajax({
      type: "POST",
      dataType: 'JSON',
      url: "/HellBank/api/Credito/create_cliente.php",
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
