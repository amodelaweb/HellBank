function MostrarMovimientos() {

//-----------------------------------------------------------------------
  $.ajax({
    url: "/HellBank/api/Consignaciones/get_all_ahorros.php",
      type: 'GET',
      dataType: 'json',
      headers: {
        "x-api-key": window.localStorage.accessToken,
      },
      success: function(response) {
        console.log(response);
        $tarjetas = response.consignaciones;
        $.each($tarjetas, function(i, option) {
          $("<tr><td>"  + option.id_origen+ "</td><td>" + option.id_destino+ "</td><td>" + option.monto+ "</td><td>" + option.fecha + "</td></tr>").appendTo("#consignaciones")

          //$('#tarjetas').append($('<option/>').attr("value", option.id).text("ID tarjeta: " + option.id + ", Se pidio en la fecha " + option.fecha_creado));
        });
//-----------------------------------------------------------------------
      },
      error: function(response) {
        console.log(response);
      }
    });

    $.ajax({
      url: "/HellBank/api/Compras_Tarjeta/get_all.php",
        type: 'GET',
        dataType: 'json',
        headers: {
          "x-api-key": window.localStorage.accessToken,
        },
        success: function(response) {
          console.log(response);
          $tarjetas = response.compras_t;
          $.each($tarjetas, function(i, option) {

            $("<tr><td>" + option.cuotas + "</td><td>" + option.id_producto+ "</td><td>" + option.monto+ "</td><td>" + option.fecha + "</td></tr>").appendTo("#compras_tar")

            //$('#tarjetas').append($('<option/>').attr("value", option.id).text("ID tarjeta: " + option.id + ", Se pidio en la fecha " + option.fecha_creado));
          });

        },
        error: function(response) {
          console.log(response);
        }
      });
//-----------------------------------------------------------------------
      $.ajax({
        url: "/HellBank/api/Retiros/get_all.php",
          type: 'GET',
          dataType: 'json',
          headers: {
            "x-api-key": window.localStorage.accessToken,
          },
          success: function(response) {
            console.log(response);
            $tarjetas = response.retiros;
            $.each($tarjetas, function(i, option) {
              $("<tr><td>"+  option.id_producto+ "</td><td>" + option.monto+ "</td><td>" + option.fecha + "</td></tr>").appendTo("#retiros")

              //$('#tarjetas').append($('<option/>').attr("value", option.id).text("ID tarjeta: " + option.id + ", Se pidio en la fecha " + option.fecha_creado));
            });

          },
          error: function(response) {
            console.log(response);
          }
        });
//-----------------------------------------------------------------------
        $.ajax({
          url: "/HellBank/api/Transacciones_Externas/get_all_ahorros.php",
            type: 'GET',
            dataType: 'json',
            headers: {
              "x-api-key": window.localStorage.accessToken,
            },
            success: function(response) {
              console.log(response);
              $tarjetas = response.transacciones_ext;
              $.each($tarjetas, function(i, option) {
                  // cells
                  $("<tr><td>" +  option.banco_destino + "</td><td>" + option.banco_origen+ "</td><td>" + option.fecha  + "</td><td>" + option.id_destino + "</td><td>" + option.id_origen + "</td><td>" + option.monto + "</td></tr>").appendTo("#transacciones")

              //  $('#tarjetas').append($('<option/>').attr("value", option.id).text("ID tarjeta: " + option.id + ", Se pidio en la fecha " + option.fecha_creado));
              });

            },
            error: function(response) {
              console.log(response);
            }
          });

  }
