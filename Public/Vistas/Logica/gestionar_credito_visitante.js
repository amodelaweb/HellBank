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
      url: "/HellBank/api/Admin/Creditos/get_creditos_visitante_sin_aprobar.php",
      type: 'GET',
      dataType: 'json',
      headers: {
        "x-api-key": window.localStorage.accessToken,
      },
      success: function(response) {
        console.log(response);
        $tarjetas = response.creditos;
        $.each($tarjetas, function(i, option) {
          if (option.id==data.crei) {
            console.log(option.$email_vis);
            document.getElementById("numPro").innerHTML = option.id;
            document.getElementById("monto").innerHTML = option.monto;
            document.getElementById("email_vis").innerHTML =  option.email_vis;
          }
          //$('#tarjetas').append($('<option/>').attr("value", option.id).text("ID tarjeta: " + option.id + ", Se pidio en la fecha " + option.fecha_creado));
        });

      },
      error: function(response) {
        console.log(response);
      }
    });
}
