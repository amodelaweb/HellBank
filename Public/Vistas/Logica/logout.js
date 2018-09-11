$(document).ready(function() {
  delete(window.localStorage.accessToken);
  delete(window.localStorage.rol);
  window.location.href = '../index.html';
} );
