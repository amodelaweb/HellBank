
  function correr() {
    if (window.localStorage.rol != "admin"){
      window.close();
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
            $('#tarj').append($('<option/>').attr("value", option.id).text("ID tarjeta: " + option.id + ", Se pidio en la fecha " + option.fecha_creado));
          });

        },
        error: function(response) {
          console.log(response);
        }
      });

      $.ajax({

        url: "/HellBank/api/Admin/Creditos/get_creditos_cliente_sin_aprobar.php",
        type: 'GET',
        dataType: 'json',
        headers: {
          "x-api-key": window.localStorage.accessToken,
        },
        success: function(response) {
          console.log(response);
          $creditos = response.creditos;
          $.each($creditos, function(i, option) {
            $('#crec').append($('<option/>').attr("value", option.id).text("ID credito: " + option.id + ", Se pidio en la fecha " + option.fecha_creado));
          });

        },
        error: function(response) {
          console.log(response);
        }
      });

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
            $('#crei').append($('<option/>').attr("value", option.id).text("ID credito: " + option.id + ", Se pidio en la fecha " + option.fecha_creado));
          });

        },
        error: function(response) {
          console.log(response);
        }
      });
    }
  }
