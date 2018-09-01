$(document).ready(function(){
    $('#create').click(function(e){
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

        $.ajax({
            type:"POST",
            url: "api/Usuarios/create.php",
            data: test,
            ContentType:"application/json",

            success:function(){
                alert('Creado Exitosamente');
            },
            error:function(){
                alert('Error Creando Usuario');
            }

        });
    });
});
