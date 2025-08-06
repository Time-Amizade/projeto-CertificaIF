document.addEventListener("DOMContentLoaded", function() {
    carregarUsuarios("/projeto-CertificaIF/app");
});

function carregarUsuarios(BASEURL) {
    //Requisição AJAX para buscar os usuários 
    // cadastrados em formato JSON
    var xhttp = new XMLHttpRequest();

    var url = BASEURL + "/controller/UsuarioController.php?action=listJson";
    xhttp.open('GET', url);

    xhttp.onload = function() {
        if(xhttp.status === 200){
            var listaDados = document.getElementById("listaDados");
            listaDados.innerHTML = "";
            var json = xhttp.responseText;
            var dados = JSON.parse(json);
            for(var i=0; i<dados.length; i++) {
                //Criar elemento HTML
                var item = document.createElement("li");
                item.innerHTML = dados[i];
                
                listaDados.appendChild(item);
            }
            alert(json);
        }else{
            console.error("Erro ao carregar os usuários:", xhttp.status);
        }
    }

    xhttp.send();
}