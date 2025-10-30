function carregarDados(BASEURL) {
    const xhttp = new XMLHttpRequest();
    const url = `${BASEURL}/controller/PerfilController.php?action=listJson&id=${ID_USUARIO}`;
    
    xhttp.open('GET', url, true);
    xhttp.onload = function() {
        if (xhttp.status !== 200) {
            console.error("Erro ao carregar os dados:", xhttp.status);
            return;
        }
        try {
            const resultado = JSON.parse(xhttp.responseText);
            const canvas = document.getElementById("graficoPizza");
            const ctx = canvas.getContext("2d");
            const totalMaximo = resultado.curso.cargaHorariaAtivComplement;

            // ===== PROCESSAMENTO DOS DADOS =====
            const compPPC = {};
            let totalHorasValidadas = 0;
            let totalHorasExcedentes = 0;

            // Mapeamento de cores para PPC
            const ppcCores = {};
            const coresBase = ['#4CAF50', '#2196F3', '#FFC107', '#FF5722', '#9C27B0', '#E91E63', '#00BCD4', '#8BC34A'];
            let corIndex = 0;

            resultado.comprovantes.forEach(comp => {
                const codigo = comp.cursoAtiv.codigo;
                const horasCertificado = comp.comprovante.horas;
                if (!compPPC[codigo]) {
                    compPPC[codigo] = {
                        max: comp.cursoAtiv.cargaHorariaMax,
                        horasValidadas: 0,
                        horasExcedentes: 0,
                        certificadosValidos: [],
                        certificadosExcedentes: []
                    };
                    ppcCores[codigo] = coresBase[corIndex % coresBase.length];
                    corIndex++;
                }
                const grupo = compPPC[codigo];
                const horasDisponiveisPPC = grupo.max - grupo.horasValidadas;
                const horasDisponiveisTotal = totalMaximo - totalHorasValidadas;
                
                console.log(totalHorasExcedentes);
                if (horasDisponiveisPPC > 0 && horasDisponiveisTotal > 0) {
                    const horasParaValidar = Math.min(horasCertificado, horasDisponiveisPPC, horasDisponiveisTotal);
                    if (horasParaValidar > 0) {
                        grupo.horasValidadas += horasParaValidar;
                        totalHorasValidadas += horasParaValidar;
                        grupo.certificadosValidos.push({
                            titulo: comp.comprovante.titulo,
                            horas: horasParaValidar
                        });
                    }

                    const horasExcedentes = horasCertificado - horasParaValidar;
                    if (horasExcedentes > 0) {
                        grupo.horasExcedentes += horasExcedentes;
                        grupo.certificadosExcedentes.push({
                            titulo: comp.comprovante.titulo,
                            horas: horasExcedentes
                        });
                    }
                } else {
                    grupo.horasExcedentes += horasCertificado;
                    grupo.certificadosExcedentes.push({
                        titulo: comp.comprovante.titulo,
                        horas: horasCertificado
                    });
                }
                totalHorasExcedentes += grupo.horasExcedentes;
            });

            // ===== PREPARAÇÃO DOS DADOS PARA O GRÁFICO =====
            const datasets = [];
            const labels = [];
            const tooltipData = [];

            // Dataset 1: Horas Validadas
            const dadosValidadas = [];
            const coresValidadas = [];

            // Adiciona horas validadas por PPC
            Object.entries(compPPC).forEach(([codigo, grupo]) => {
                if (grupo.horasValidadas > 0) {
                    const cor = ppcCores[codigo]; // Usa a cor do PPC armazenada
                    dadosValidadas.push(grupo.horasValidadas);
                    labels.push(`PPC CÓD: ${codigo}`);
                    coresValidadas.push(cor);
                    
                    tooltipData.push({
                        tipo: 'validada',
                        codigo: codigo,
                        horas: grupo.horasValidadas,
                        certificados: grupo.certificadosValidos,
                        cor: cor
                    });
                }
            });

            const horasFaltando = Math.max(0, totalMaximo - totalHorasValidadas);
            if (horasFaltando > 0) {
                dadosValidadas.push(horasFaltando);
                labels.push('Horas Restantes');
                coresValidadas.push('#dddddd');
                
                tooltipData.push({
                    tipo: 'faltante',
                    horas: horasFaltando,
                    certificados: ['A completar com novas atividades.']
                });
            }

            datasets.push({
                label: 'Horas Validadas',
                data: dadosValidadas,
                backgroundColor: coresValidadas,
                borderColor: "#fff",
                borderWidth: 2,
                hoverOffset: 20
            });

            // Dataset 2: Horas Excedentes
            const dadosExcedentes = [];
            const coresExcedentes = [];

            Object.entries(compPPC).forEach(([codigo, grupo]) => {
                if (grupo.horasExcedentes > 0) {
                    // Usa a mesma cor do PPC correspondente
                    const cor = ppcCores[codigo];
                    dadosExcedentes.push(grupo.horasExcedentes);
                    coresExcedentes.push(cor);
                    
                    tooltipData.push({
                        tipo: 'excedente',
                        codigo: codigo,
                        horas: grupo.horasExcedentes,
                        certificados: grupo.certificadosExcedentes,
                        cor: cor
                    });
                }
            });

            if (dadosExcedentes.length > 0) {
                datasets.push({
                    label: 'Horas Excedentes',
                    data: dadosExcedentes,
                    backgroundColor: coresExcedentes,
                    borderColor: "#fff",
                    borderWidth: 2,
                    hoverOffset: 20
                });
            }

            // ===== CONFIGURAÇÃO DO CHART.JS =====
            const data = {
                labels: labels,
                datasets: datasets
            };

            // Plugin para texto no centro
            const centerTextPlugin = {
                id: 'centerText',
                beforeDraw(chart) {
                    if (chart.config.type === 'doughnut') {
                        const { ctx, width, height } = chart;
                        ctx.save();
                        
                        const porcentagem = (((totalHorasValidadas + totalHorasExcedentes) / totalMaximo) * 100).toFixed(1);
                        
                        // Calcula o centro do canvas
                        const centerX = width / 2;
                        const centerY = height / 2;
                        
                        // Texto principal (porcentagem)
                        ctx.textAlign = 'center';
                        ctx.textBaseline = 'middle';
                        ctx.font = 'bold 24px Arial';
                        ctx.fillStyle = '#333';
                        ctx.fillText(`${porcentagem}%`, centerX, centerY - 15);
                        
                        // Texto secundário (horas)
                        ctx.font = '16px Arial';
                        ctx.fillStyle = '#666';
                        if(horasFaltando > 0)
                            ctx.fillText(`${totalHorasValidadas}h/${totalMaximo}h`, centerX, centerY + 15);
                        else
                            ctx.fillText(`CONCLUÍDO`, centerX, centerY + 15);
                        ctx.restore();
                    }
                }
            };

            const config = {
                type: 'doughnut',
                data: data,
                plugins: [centerTextPlugin],
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    aspectRatio: 1,
                    layout: {
                        padding: {
                            top: 20,
                            bottom: 30,
                            left: 20,
                            right: 20
                        }
                    },
                    plugins: {
                        legend: { 
                            position: 'bottom',
                            onClick: null
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const index = context.dataIndex;
                                    const datasetIndex = context.datasetIndex;
                                    
                                    let tooltipIndex = index;
                                    if (datasetIndex === 1) {
                                        tooltipIndex = index + (datasets[0].data.length || 0);
                                    }
                                    
                                    const tooltipItem = tooltipData[tooltipIndex];
                                    const valor = context.parsed;
                                    
                                    if (!tooltipItem) return context.label;

                                    const porcent = ((valor / totalMaximo) * 100).toFixed(1) + "%";
                                    let linhas = [];

                                    if (tooltipItem.tipo === 'validada') {
                                        linhas.push(`PPC ${tooltipItem.codigo} - ${valor}h (${porcent})`);
                                        tooltipItem.certificados.forEach(cert => {
                                            linhas.push(`• ${cert.titulo} (${cert.horas}h)`);
                                        });
                                    } else if (tooltipItem.tipo === 'excedente') {
                                        linhas.push(`PPC ${tooltipItem.codigo} - ${valor}h (${porcent})`);
                                        tooltipItem.certificados.forEach(cert => {
                                            linhas.push(`• ${cert.titulo} (${cert.horas}h)`);
                                        });
                                    } else if (tooltipItem.tipo === 'faltante') {
                                        linhas.push(`Horas restantes: ${valor}h (${porcent})`);
                                        linhas.push('A completar com novas atividades.');
                                    }

                                    return linhas;
                                }
                            }
                        },
                        title: {
                            display: true,
                            text: 'Horas de Atividades Complementares',
                            font: {
                                size: 20,
                                weight: 'bold'
                            },
                            padding: {
                                top: 10,
                                bottom: 30
                            }
                        }
                    }
                }
            };
            graficoPizzaInstance = new Chart(ctx, config);
        } catch (e) {
            console.error('Erro ao processar JSON:', e);
            console.error(xhttp.responseText);
        }
    };
    
    xhttp.onerror = function() {
        console.error("Erro de rede ou URL inválida.");
    };
    xhttp.send();
}

carregarDados('/projeto-CertificaIF/app');