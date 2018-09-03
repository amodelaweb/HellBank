$(document).ready(function() {
  $('#pedir_tarjeta').click(function(e) {
    e.preventDefault();

    function getUrlVars() {
      var combo = document.getElementById("cuentas_usr");
      var hash;
      var myJson = {};
      myJson["cuenta_ahorros"] = combo.options[combo.selectedIndex].value;
      return JSON.stringify(myJson);
    }

    var test = getUrlVars();


  });
});
