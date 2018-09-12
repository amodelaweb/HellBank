$(document).ready(function() {
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

    function selectImages() {
      var imagen = "img.png";
      var path = "./img/";
      var res = path + imagen;
      return res;
    }

    function getHoraActual() {
      var fecha = new Date();
      var hora = fecha.getHours();
      var minutos = fecha.getMinutes();
      if (hora < 10) {
        hora = "0" + hora.toString();
      }
      if (minutos < 10) {
        minutos = "0" + minutos.toString();
      }
      var respuesta = hora + ":" + minutos;

      return respuesta;
    }

    function AgregarMensaje(nombreClase, usuario, parrafo2) {
      var division = document.createElement("div");
      division.setAttribute("class", "mensaje");
      var imagen = document.createElement("img");
      imagen.setAttribute("src", selectImages());
      imagen.setAttribute("alt", "avatar");
      imagen.setAttribute("style", "width:100%;");
      var titulo = document.createElement("h5");
      var texto = document.createTextNode(usuario);
      titulo.appendChild(texto);
      var parrafo = document.createElement("p");
      var texto2 = document.createTextNode(parrafo2);
      parrafo.appendChild(texto2);
      var hora = document.createElement("span");
      var texto3 = document.createTextNode(getHoraActual());
      hora.appendChild(texto3);
      hora.setAttribute("class", "hora-derecha");
      division.appendChild(imagen);
      division.appendChild(titulo);
      division.appendChild(parrafo);
      division.appendChild(hora);
      var caja = document.getElementById(nombreClase);
      var primer_nodo = caja.firstChild;

      caja.insertBefore(division, primer_nodo);
    }


    $.ajax({
      url: "/HellBank/api/Mensajes/get_messages.php",
      type: 'GET',
      dataType: 'json',
      headers: {
        "x-api-key": window.localStorage.accessToken,
      },
      success: function(response) {
        $mensajes = response.mensajes;
        $.each($mensajes, function(i, option) {
          AgregarMensaje("caja_scroll", "HellBank ! ", option.contenido);
        });

      },
      error: function(response) {
        console.log(response);
      }
    });

  }
});
