$(document).ready(function() {
  $('#gestt').click(function(e) {
    e.preventDefault();
      var b = document.getElementById('tarj').value,
      url = 'http://localhost/HellBank/Public/Vistas/TarjetasCreditoAdmin.html?tarj=' + encodeURIComponent(b);
      document.location.href = url;
    });

    $('#gestc').click(function(e) {
      e.preventDefault();
        var b = document.getElementById('crec').value,
        url = 'http://localhost/HellBank/Public/Vistas/CreditoClienteAdmin.html?crec=' + encodeURIComponent(b);
        document.location.href = url;
      });

      $('#gesti').click(function(e) {
        e.preventDefault();
          var b = document.getElementById('crei').value,
          url = 'http://localhost/HellBank/Public/Vistas/CreditoVisAdmin.html?crei=' + encodeURIComponent(b);
          document.location.href = url;
        });


  });
