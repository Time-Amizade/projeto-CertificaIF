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

                    compPPC[comp.cursoAtiv.codigo]['certificados'].push({
                        'titulo': comp.comprovante.titulo,
                        'horas': comp.comprovante.horas
                    });

                    if(compPPC[comp.cursoAtiv.codigo]['horas'] + comp.comprovante.horas <= compPPC[comp.cursoAtiv.codigo]['max']){
                        compPPC[comp.cursoAtiv.codigo]['horas'] += comp.comprovante.horas;
                    } else {
                        compPPC[comp.cursoAtiv.codigo]['horas'] = compPPC[comp.cursoAtiv.codigo]['max'];
                        compPPC[comp.cursoAtiv.codigo]['excedentes'] += comp.comprovante.horas - (compPPC[comp.cursoAtiv.codigo]['max'] - compPPC[comp.cursoAtiv.codigo]['horas']);
                    }
                });
                
                let totalConsiderado = 0

                let valores = { 'excedentes': {}, 'validadas': {} };
                let labels = { 'excedentes': {}, 'validadas': {} };
                const idsAtividades = [];
                const titulosPorAtividade = {};

                const cores = [];
                
                const coresBase = [
                    '#4CAF50', '#2196F3', '#FFC107', '#FF5722', '#9C27B0', '#E91E63', '#00BCD4', '#8BC34A'
                ];
                
                let corIndex = 0;

                for (let codigo in compPPC) {
                    let grupo = compPPC[codigo];
                    
                    let horasValidas = 0;
                    let horasExcedentes = 0;

                    if (totalConsiderado < totalMaximo) {
                        let horasRestantes = totalMaximo - totalConsiderado;
                        horasValidas = Math.min(grupo.horas, horasRestantes);
                        totalConsiderado += horasValidas;
                    }

                    if (totalConsiderado >= totalMaximo){  
                        horasExcedentes = grupo.horas - (totalMaximo - (totalConsiderado - horasValidas));
                        valores['excedentes']['exc'] = horasExcedentes;
                    }

                    if(grupo.excedentes > 0){
                        valores['excedentes'][codigo] = grupo.excedentes;
                    }
                    
                    // Adiciona as horas válidas caso o total máximo não tenha sido ultrapassado
                    if (horasValidas > 0) {
                        valores['validadas'][codigo] = horasValidas;
                        labels['validadas'][codigo] = `Atividade ${codigo}`;
                        cores.push(coresBase[corIndex % coresBase.length]);
                    }

                    // Preenche o título das atividades para os tooltips
                    idsAtividades.push(codigo);
                    titulosPorAtividade[codigo] = grupo.certificados.map(c => `• ${c.titulo} (${c.horas}h)`);

                    corIndex++;
                }
                console.log('Valores:', valores)
                console.log('Labels:', labels)

                faltando = totalMaximo - totalConsiderado
                faltando = Math.max(0, faltando)


                if (faltando > 0) {
                    labels.push('Horas Restantes');
                    valores.push(faltando);
                    idsAtividades.push(null);  // null para tooltip especial
                    titulosPorAtividade[null] = ['A completar com novas atividades.'];
                    cores.push('#dddddd');
                }

                // ===== CHART.JS =====
                const data = {
                    labels: [...Object.values(labels['validadas']), ...Object.values(labels['excedentes'])], // Concatenando as labels
                    datasets: [
                        {
                            label: 'Horas Validadas',
                            data: Object.values(valores['validadas']),
                            backgroundColor: cores,
                            borderColor: "#fff",
                            borderWidth: 2,
                            hoverOffset: 20
                        },
                        {
                            label: 'Horas Excedentes',
                            data: Object.values(valores['excedentes']),
                            backgroundColor: '#FF5722', // Cor para os excedentes
                            borderColor: "#fff",
                            borderWidth: 2,
                            hoverOffset: 20
                        }
                    ]
                };
                
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

                                        // Exibindo o valor total de horas na fatia
                                        const horasTotais = valor; // Total de horas desta fatia (validadas ou excedentes)
                                        linhas.push(`Total: ${horasTotais}h`);
                                        
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