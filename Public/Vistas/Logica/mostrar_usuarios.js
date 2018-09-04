function MostrarUsuarios() {

//-----------------------------------------------------------------------
  $.ajax({
    url: "/HellBank/api/Admin/Usuarios/get_all_users.php",
      type: 'GET',
      dataType: 'json',
      headers: {
        "x-api-key": window.localStorage.accessToken,
      },
      success: function(response) {
        console.log(response);
        $tarjetas = response.usuarios;
        $.each($tarjetas, function(i, option) {
          $("<tr><td>"  + option.nombre+ "</td><td>" + option.apellido+ "</td><td>" + option.id + "</td><td>" + option.rol + "</td></tr>").appendTo("#usuarios")

          //$('#tarjetas').append($('<option/>').attr("value", option.id).text("ID tarjeta: " + option.id + ", Se pidio en la fecha " + option.fecha_creado));
        });
//-----------------------------------------------------------------------
      },
      error: function(response) {
        console.log(response);
      }
    });

  }
