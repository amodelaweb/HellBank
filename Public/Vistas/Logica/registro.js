$(document).ready(function(){
  $('#botonform').click(function(e){
    e.preventDefault();

    var url = $('form').serialize();

    function getUrlVars(url) {
      var hash;
      var myJson = {};
      var hashes = url.slice(url.indexOf('?') + 1).split('&');
      for (var i = 0; i < hashes.length; i++) {
        hash = hashes[i].split('=');
        myJson[hash[0]] = hash[1];
      }
      return JSON.stringify(myJson);
    }

    var test = getUrlVars(url);

    localStorage.setItem('gameStorage', test);
    console.log("ok");
    $.ajax({
      type:"POST",
      dataType: 'JSON',
      url: "/HellBank/api/Usuarios/create.php",
      data: test,
      ContentType:"application/json",

      success:function(response){
        alert('Creado Exitosamente');
        console.log(response);
        window.location.href = './Login.html';
      },
      error:function(response){
        alert('Error Creando Usuario ' + response.responseJSON.error);
        console.log(response);
      }

    });
  });
});
