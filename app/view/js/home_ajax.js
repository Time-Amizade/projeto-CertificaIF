function carregarUsuarios(BASEURL) {
    //Requisição AJAX para buscar os usuários 
    // cadastrados em formato JSON

    var xhttp = new XMLHttpRequest();

    var url = BASEURL + "/controller/UsuarioController.php?action=listJson";
    xhttp.open('GET', url);

    xhttp.onload = function() {
        var listaUsuarios = document.getElementById("listaUsuarios");
        listaUsuarios.innerHTML = "";
        
        var json = xhttp.responseText;
        var usuarios = JSON.parse(json);

        for(var i=0; i<usuarios.length; i++) {
            //Criar elemento HTML
            var item = document.createElement("li");
            item.innerHTML = usuarios[i].nome;

            listaUsuarios.appendChild(item);
        }

        //alert(json);
    }

    xhttp.send();
}