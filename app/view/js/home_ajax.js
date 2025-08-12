function carregarUsuarios(BASEURL) {
    //Requisição AJAX para buscar os usuários 
    // cadastrados em formato JSON
    var xhttp = new XMLHttpRequest();

    var url = BASEURL + "/controller/CadastroController.php?action=listJson";
    xhttp.open('GET', url, true);
    xhttp.onload = function() {
        if(xhttp.status === 200){
            var listaDados = document.getElementById("listaDados");
            listaDados.innerHTML = "";
            var resultado = JSON.parse(xhttp.responseText);
            var tipoUser = resultado.tipo
            var dados = resultado.dados
            if(tipoUser === 'ADMINISTRADOR'){
                dados.forEach(function (user) {
                    let card = `
                        <div class="col-md-4 mb-3">
                            <div class="card shadow-sm border-0">
                                <div class="card-body">
                                    <h5 class="card-title">${user.nome}</h5>
                                    <p><strong>CPF:</strong> ${user.cpf}</p>
                                    <p><strong>Email:</strong> ${user.email}</p>
                                    <p><strong>Status:</strong> ${user.status}</p>
                                    <p><strong>Curso:</strong> ${user.Cursoid.nome}</p>
                                    <div class="d-flex justify-content-between">
                                        <button class="btn btn-success btn-sm" onclick="aceitarUsuario('${user.id}')">Aceitar</button>
                                        <button class="btn btn-danger btn-sm" onclick="recusarUsuario('${user.id}')">Recusar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                    listaDados.innerHTML += card;
                });
            }else if(tipoUser === 'COORDENADOR'){
                listaDados.innerHTML += 'WHO';
                listaDados.innerHTML += 'Dados: ' + dados;
            }else{
                
            }
            
        }else{
            console.error("Erro ao carregar os usuários:", xhttp.status);
        }
    }

    xhttp.send();
}

carregarUsuarios('/projeto-CertificaIF/app');