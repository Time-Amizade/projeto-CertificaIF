function carregarUsuarios(BASEURL) {
    //Requisição AJAX para buscar os usuários 
    // cadastrados em formato JSON
    var xhttp = new XMLHttpRequest();

    var url = BASEURL + "/controller/UsuarioController.php?action=listJson";
    xhttp.open('GET', url, true);
    xhttp.onload = function() {
        if(xhttp.status === 200){
            var listaDados = document.getElementById("listaDados");
            listaDados.innerHTML = "";
            var json = xhttp.responseText;
            var dados = JSON.parse(json);
            listaDados.innerHTML = dados[0]['nome'];
            console.log(dados);
        }else{
            console.error("Erro ao carregar os usuários:", xhttp.status);
        }
    }

    xhttp.send();
}

carregarUsuarios('/projeto-CertificaIF/app');