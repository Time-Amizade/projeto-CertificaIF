function carregarDados(BASEURL) {
    //Requisição AJAX para buscar os usuários 
    // cadastrados em formato JSON
    var xhttp = new XMLHttpRequest();

    var url = BASEURL + "/controller/HomeController.php?action=listJson";
    xhttp.open('GET', url, true);
    xhttp.onload = function() {
        if(xhttp.status === 200){
            var listaDados = document.getElementById("listaDados");
            listaDados.innerHTML = "";
            try {
                var resultado = JSON.parse(xhttp.responseText);
            } catch (e) {
                console.error('Erro ao processar JSON:', e);
                console.error(xhttp.responseText);
            }
            var tipoUser = resultado.tipo
            if(tipoUser === 'ADMINISTRADOR'){
                var dados = resultado.dados
                dadosAdmin(BASEURL, dados);
            }else if(tipoUser === 'COORDENADOR'){
                var dados = resultado.dados;
                var dados2 = resultado.comprovantes;
                dadosCoord(BASEURL, dados, dados2, listaDados);
            }else if(tipoUser === 'ALUNO'){
                var dados = resultado.comprovantes
                dadosAluno(BASEURL, dados, listaDados);
            }         
        }else{
            console.error("Erro ao carregar os usuários:", xhttp.status);
        }
    }
    xhttp.send();
}

function dadosAdmin(BASEURL, dados){
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
}

function dadosCoord(BASEURL, dados, dados2, listaDados){
    var containerAlunos = document.createElement("div");
    containerAlunos.id = "containerAlunos";
    containerAlunos.classList.add("row");

    var containerComprovantes = document.createElement("div");
    containerComprovantes.id = "containerComprovantes";
    containerComprovantes.classList.add("row");

    listaDados.innerHTML += "<h3>Alunos</h3>";
    // Renderizar alunos
    if(dados.length > 0){
        dados.forEach(function (user) {
            let cardAluno = `
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
            containerAlunos.innerHTML += cardAluno;
            listaDados.appendChild(containerAlunos);
        });
    }else{
        containerAlunos.innerHTML += '<h5><p>Não há nenhuma solicitação de cadastro no momento!</p></h5>';
        listaDados.appendChild(containerAlunos);
    }
    
    listaDados.innerHTML += "<h3>Comprovantes</h3>";
    // Renderizar comprovantes (se existirem)
    if (dados2.length > 0){
        dados2.forEach(function(dado) {
            let cardComp = `
                <div class="col-md-3 mb-3">
                    <div class="card shadow border-0 rounded-3">
                        <div class="card-body">
                            <h5 class="card-title">${dado.comprovante.titulo}</h5>
                            <p><strong>Aluno:</strong> ${dado.aluno.nome}</p>
                            <p><strong>Horas validadas:</strong> ${dado.comprovante.horas} horas</p>
                            <div class="d-flex justify-content-between">
                                <a href="` + BASEURL + `/controller/ComprovanteController.php?action=evaluate&id=${dado.comprovante.id}" class="btn btn-primary">Avaliar</a>
                                <a href="#" onclick="recusarComprovante(${dado.comprovante.id})" class="btn btn-danger">Recusar</a>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            containerComprovantes.innerHTML += cardComp;
            listaDados.appendChild(containerComprovantes);
        });
    }else{
        containerComprovantes.innerHTML += '<h5><p>Não há nenhum certificado para avaliação no momento!</p></h5>';
        listaDados.appendChild(containerComprovantes);
    }
}

function dadosAluno(BASEURL, dados, listaDados){
    dados.forEach(function(dado){
        let card = `
            <div class="col-md-3 mb-3">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="card-title">${dado.comprovante.titulo}</h5>
                        <p><strong>Horas validadas:</strong> ${dado.comprovante.horas} horas</p>
                        <p><strong>Status:</strong> ${dado.comprovante.status}</p>
                        `; 
                        if(dado.comprovante.comentario != null){
                            card += `<p><strong>Comentário:</strong> ${dado.comprovante.comentario}</p>`
                        }
                        card += `
                        <p><strong>Código da atividade:</strong> ${dado.cursoAtiv.codigo}</p>
                        <a href="` + BASEURL + `/../arquivos/${dado.comprovante.arquivo}" target="_blank">
                            Visualizar arquivo
                        </a>
                        `; 
                        if(dado.comprovante.status == 'PENDENTE'){
                            card += `<a href="` + BASEURL + `/controller/ComprovanteController.php?action=cancel&id=${dado.comprovante.id}" class=" btn btn-danger">
                                Cancelar envio
                            </a>`
                            
                        }
                        card += `
                    </div>
                </div>
            </div>
        `;
        listaDados.innerHTML += card;
    });
}



function recusarComprovante(id) {
    let comentario = prompt("Digite o motivo da recusa:");

    if (comentario === null || comentario.trim() === "") {
        alert("É obrigatório informar um comentário para recusar.");
        return;
    }

    window.location.href = BASEURL + "/controller/ComprovanteController.php?action=refuse&id=" + id + "&comentario=" + encodeURIComponent(comentario);
}

carregarDados('/projeto-CertificaIF/app');