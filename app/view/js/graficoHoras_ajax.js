function carregarDados(BASEURL) {
    var xhttp = new XMLHttpRequest();
    var resultado; // ← declarada aqui    

    var url = BASEURL + "/controller/PerfilController.php?action=listJson&id=" + ID_USUARIO;
    
    xhttp.open('GET', url, true);
    xhttp.onload = function() {
        if (xhttp.status === 200) {
            try {
                var resultado = JSON.parse(xhttp.responseText);
                const canvas = document.getElementById("graficoPizza");
                const ctx = canvas.getContext("2d");
        
                const totalMaximo = resultado.curso.cargaHorariaAtivComplement;
                console.log(resultado.comprovantes)

                compPPC = {}

                resultado.comprovantes.forEach(function(comp){
                   if(!compPPC[comp.cursoAtiv.codigo]){
                        compPPC[comp.cursoAtiv.codigo] = {
                            'max': comp.cursoAtiv.cargaHorariaMax,
                            'horas': 0,
                            'certificados': [],
                            'excedentes': 0
                        }
                    }

                    // Adicionando o certificado à lista
                    compPPC[comp.cursoAtiv.codigo]['certificados'].push({
                        'titulo': comp.comprovante.titulo,
                        'horas': comp.comprovante.horas
                    });

                    // Verificando se a quantidade de horas não ultrapassou o máximo
                    if(compPPC[comp.cursoAtiv.codigo]['horas'] + comp.comprovante.horas <= compPPC[comp.cursoAtiv.codigo]['max']){
                        compPPC[comp.cursoAtiv.codigo]['horas'] += comp.comprovante.horas;
                    } else {
                        compPPC[comp.cursoAtiv.codigo]['horas'] = compPPC[comp.cursoAtiv.codigo]['max'];
                        compPPC[comp.cursoAtiv.codigo]['excedentes'] += comp.comprovante.horas - (compPPC[comp.cursoAtiv.codigo]['max'] - compPPC[comp.cursoAtiv.codigo]['horas']);
                    }
                });
                
                let totalConsiderado = 0

                let valores = { 'excedentes': [], 'validadas': [] };
                let labels = { 'excedentes': [], 'validadas': [] };
                const idsAtividades = [];
                const titulosPorAtividade = {};

                const cores = [];
                
                const coresBase = [
                    '#4CAF50', '#2196F3', '#FFC107', '#FF5722', '#9C27B0', '#E91E63', '#00BCD4', '#8BC34A'
                ];
                
                let corIndex = 0;

                for (let codigo in compPPC) {
                    let grupo = compPPC[codigo];

                    // Inicializamos as variáveis para as horas válidas e excedentes desta atividade
                    let horasValidas = 0;
                    let horasExcedentes = 0;

                    // Caso o total de horas válidas somadas ainda não tenha ultrapassado o total máximo
                    if (totalConsiderado < totalMaximo) {
                        // Calcular as horas válidas dentro do limite
                        let horasRestantes = totalMaximo - totalConsiderado;
                        horasValidas = Math.min(grupo.horas, horasRestantes); // Pode adicionar até o totalMaximo
                        totalConsiderado += horasValidas;
                    }

                    // Caso o total de horas válidas já tenha ultrapassado o total máximo
                    if (totalConsiderado >= totalMaximo) {
                        // As horas excedentes são a diferença entre as horas da atividade e o máximo
                        horasExcedentes = grupo.horas - (totalMaximo - (totalConsiderado - horasValidas));
                        valores['excedentes'].push(horasExcedentes);
                        labels['excedentes'].push(`Atividade ${codigo}`);
                    }

                    // Adiciona as horas válidas caso o total máximo não tenha sido ultrapassado
                    if (horasValidas > 0) {
                        valores['validadas'].push(horasValidas);
                        labels['validadas'].push(`Atividade ${codigo}`);
                    }

                    // Preenche o título das atividades para os tooltips
                    idsAtividades.push(codigo);
                    titulosPorAtividade[codigo] = grupo.certificados.map(c => `• ${c.titulo} (${c.horas}h)`);

                    // Adiciona uma cor para cada fatia
                    cores.push(coresBase[corIndex % coresBase.length]);
                    corIndex++;
                }
                console.log(valores)

                faltando = totalMaximo - totalConsiderado
                faltando = Math.max(0, faltando)

                console.log('Teste', compPPC)

                if (faltando > 0) {
                    labels.push('Horas Restantes');
                    valores.push(faltando);
                    idsAtividades.push(null);  // null para tooltip especial
                    titulosPorAtividade[null] = ['A completar com novas atividades.'];
                    cores.push('#dddddd');
                }

                // ===== CHART.JS =====
                const data = {
                    labels: [...labels['validadas'], ...labels['excedentes']], // Concatenando as labels
                    datasets: [
                        {
                            label: 'Horas Validadas',
                            data: valores['validadas'],
                            backgroundColor: cores,
                            borderColor: "#fff",
                            borderWidth: 2,
                            hoverOffset: 20
                        },
                        {
                            label: 'Horas Excedentes',
                            data: valores['excedentes'],
                            backgroundColor: '#FF5722', // Cor para os excedentes
                            borderColor: "#fff",
                            borderWidth: 2,
                            hoverOffset: 20
                        }
                    ]
                };
                // if(somaExcesso > 0){
                //     const labelsExcesso = Object.keys(horasExcedentes).map(id => `Excesso Atividade ${id} (${horasExcedentes[id].toFixed(1)}h)`);
    
                //     const valoresExcesso = Object.values(horasExcedentes);
                //     console.log(valoresExcesso, labelsExcesso);
                //     data.datasets.push({
                //         label: 'Horas Excedentes',
                //         data: valoresExcesso,
                //         backgroundColor: cores,
                //         borderColor: "#fff",
                //         borderWidth: 2,
                //         hoverOffset: 20
                //     })
                // }

                const config = {
                    type: 'doughnut', // Tipo de gráfico (pizza)
                    data: data,
                    options: {
                        responsive: true,
                        plugins: {
                            legend: { position: 'top' },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        const index = context.dataIndex;
                                        const idCursoAtivAtiv = idsAtividades[index];
                                        const valor = context.parsed;
                                        const porcent = ((valor / totalMaximo) * 100).toFixed(1) + "%";

                                        let linhas = [`${context.label} — ${porcent}`];
                                        
                                        // Adiciona os títulos de cada atividade para detalhamento no tooltip
                                        if (idCursoAtivAtiv) {
                                            titulosPorAtividade[idCursoAtivAtiv].forEach(titulo => {
                                                linhas.push(titulo);
                                            });
                                        } else {
                                            linhas.push('Horas restantes');
                                        }

                                        return linhas;
                                    }
                                }
                            },
                            title: {
                                display: true,
                                text: 'Horas Validadas vs Faltando'
                            }
                        }
                    }
                };
                const graficoPizza = new Chart(ctx, config);
            } catch (e) {
                console.error('Erro ao processar JSON:', e);
                console.error(xhttp.responseText);
            }
        } else {
            console.error("Erro ao carregar os dados:", xhttp.status);
        }
        
    };
    xhttp.onerror = function() {
        console.error("Erro de rede ou URL inválida.");
    };
    xhttp.send();


}





carregarDados('/projeto-CertificaIF/app');