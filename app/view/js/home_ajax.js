function carregarDados(BASEURL) {
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
                var dados = resultado.dados
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
                                        <a href="` + BASEURL + `/controller/UsuarioController.php?action=confirm&id=${user.id}" class="btn btn-primary">Aceitar usuário</a>
                                        <a href="` + BASEURL + `/controller/UsuarioController.php?action=refuse&id=${user.id}" class="btn btn-primary">Recusar usuário</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                    listaDados.innerHTML += card;
                });
                
            }else if(tipoUser === 'COORDENADOR'){
                var dados = resultado.dados
                dados.forEach(function (user) {
                    let card = `
                        <div class="col-md-4 mb-3">
                            <div class="card shadow-sm border-0">
                                <div class="card-body">
                                    <h5 class="card-title">${user.nome}</h5>
                                    <p><strong>Código de Matrícula:</strong> ${user.codigoMatricula}</p>
                                    <p><strong>Email:</strong> ${user.email}</p>
                                    <p><strong>Status:</strong> ${user.status}</p>
                                    <p><strong>CPF:</strong> ${user.cpf}</p>
                                    <div class="d-flex justify-content-between">
                                        <a href="` + BASEURL + `/controller/UsuarioController.php?action=confirm&id=${user.id}" class="btn btn-primary">Aceitar usuário</a>
                                        <a href="` + BASEURL + `/controller/UsuarioController.php?action=refuse&id=${user.id}" class="btn btn-primary">Recusar usuário</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                    listaDados.innerHTML += card;
                });
                if (resultado.comprovantes){
                    dados = resultado.comprovantes
                    dados.forEach(function(dado) {
                        let card = `
                            <div class="col-md-3 mb-3">
                                <div class="card shadow-sm border-0">
                                    <div class="card-body">
                                        <h5 class="card-title">${dado.comprovante.titulo}</h5>
                                        <p><strong>Horas validadas:</strong> ${dado.comprovante.horas} horas</p>
                                        <p><strong>Status:</strong> ${dado.comprovante.status}</p>
                                        <p><strong>Código da atividade:</strong> ${dado.cursoAtiv.codigo}</p>
                                        <a href="` + BASEURL + `/../arquivos/${dado.comprovante.arquivo}" target="_blank">
                                            Visualizar arquivo
                                        </a>
                                    </div>
                                </div>
                            </div>
                        `;
                        listaDados.innerHTML += card;
                    });
                }
            }else if(tipoUser === 'ALUNO'){
                var dados = resultado.comprovantes
                dados.forEach(function(dado) {
                    let card = `
                        <div class="col-md-3 mb-3">
                            <div class="card shadow-sm border-0">
                                <div class="card-body">
                                    <h5 class="card-title">${dado.comprovante.titulo}</h5>
                                    <p><strong>Horas validadas:</strong> ${dado.comprovante.horas} horas</p>
                                    <p><strong>Status:</strong> ${dado.comprovante.status}</p>
                                    <p><strong>Código da atividade:</strong> ${dado.cursoAtiv.codigo}</p>
                                    <a href="` + BASEURL + `/../arquivos/${dado.comprovante.arquivo}" target="_blank">
                                        Visualizar arquivo
                                    </a>
                                </div>
                            </div>
                        </div>
                    `;
                    listaDados.innerHTML += card;
                });
            }         
        }else{
            console.error("Erro ao carregar os usuários:", xhttp.status);
        }
    }

    xhttp.send();
}

carregarDados('/projeto-CertificaIF/app');