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
            console.log(option.$email_vis);
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
