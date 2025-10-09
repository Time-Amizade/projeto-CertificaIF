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
                
                let titulosPorAtividade = {};
                let horasValidas = {};
                let limitesPorNorma = {}
                let horasExcedentes = {};
                let somaHoras = 0;

                resultado.comprovantes.forEach(function(comp){
                    const idCursoAtiv = comp.cursoAtiv.id;
                    const titulo = comp.comprovante.titulo || "Sem título";
                    const horas = comp.comprovante.horas || 0;

                    const faltando = totalMaximo - somaHoras;

                    if(!limitesPorNorma[idCursoAtiv]) limitesPorNorma[idCursoAtiv] = comp.cursoAtiv.cargaHorariaMax
                    
                    let horasValidasNesteComp = 0;
                    let horasExcedentesNesteComp = 0;

                    if (faltando > 0) {
                        // Se ainda falta, a hora é dividida:
                        // A parte que cabe no limite geral
                        
                        horasValidasNesteComp = Math.min(horas, faltando);
                        
                        // O restante (se houver) vai para o excesso
                        horasExcedentesNesteComp = horas - horasValidasNesteComp;
                        
                    } else {
                        // Se o limite já foi atingido, 100% vai para o excesso
                        horasExcedentesNesteComp = horas;
                    }

                    if (horasValidasNesteComp > 0) {
                        if (!horasValidas[idCursoAtiv]) horasValidas[idCursoAtiv] = 0;
                        horasValidas[idCursoAtiv] += horasValidasNesteComp;
                        somaHoras += horasValidasNesteComp; // Atualiza o contador principal
                    }
                    
                    // Horas Excedentes
                    if (horasExcedentesNesteComp > 0) {
                        if (!horasExcedentes[idCursoAtiv]) horasExcedentes[idCursoAtiv] = 0;
                        horasExcedentes[idCursoAtiv] += horasExcedentesNesteComp;
                    }
                    
                    // 3. Acumula títulos (pode continuar na mesma lógica, agrupando todos)
                    if (!titulosPorAtividade[idCursoAtiv]) titulosPorAtividade[idCursoAtiv] = [];
                    titulosPorAtividade[idCursoAtiv].push(titulo);
                });

                const somaExcesso = Object.values(horasExcedentes).reduce((a, b) => a + b, 0);
                const faltando = totalMaximo - somaHoras; // Se houver excesso, este valor será 0.
                
                const valores = Object.values(horasValidas);
                const idsAtividades = Object.keys(horasValidas);  

                // cores
                const paleta = [
                    "#4CAF50",
                    "#2196F3",
                    "#FFC107",
                    "#F44336",
                    "#9C27B0",
                    "#FF9800",
                    "#00BCD4",
                    "#795548"
                ];

                const coresAleatorias = Object.values(horasValidas).map((_, i) => paleta[i % paleta.length]);
                const cores = faltando > 0 
                ? [...coresAleatorias, "#CCCCCC"] 
                : coresAleatorias;

                // labels
                const labels = Object.values(horasValidas).map((h, i) => `Atividade ${i + 1} (${h}h)`);

                if (faltando > 0) {
                    valores.push(faltando);
                    labels.push(`Horas a validar (${faltando}h)`);
                    idsAtividades.push(null);
                }
                
                const somaTotalReal = somaHoras + somaExcesso; 
                // A porcentagem deve usar a soma real (que pode ser > totalMaximo)
                const porcentagem = ((somaTotalReal / totalMaximo) * 100).toFixed(1);
                const centerText = {
                    id: 'centerText',
                    beforeDraw: function(chart) {
                        if (chart.config.type !== 'doughnut' && chart.config.type !== 'pie') {
                            return;
                        }
                        
                        const width = chart.width,
                            height = chart.height,
                            ctx = chart.ctx;

                        ctx.restore();
                        const fontSize = (height / 200).toFixed(2);
                        ctx.font = `bold ${fontSize}em sans-serif`;
                        ctx.textBaseline = "middle";

                        const text = `${porcentagem}%`;
                        
                        // CORREÇÃO DA CENTRALIZAÇÃO HORIZONTAL:
                        // Usa o centro do CHART.AREA (região de plotagem), que é mais preciso.
                        const centerX = (chart.chartArea.left + chart.chartArea.right) / 2;
                        
                        // CORREÇÃO DA CENTRALIZAÇÃO VERTICAL:
                        const centerY = (chart.chartArea.top + chart.chartArea.bottom) / 2;

                        const textX = Math.round(centerX - (ctx.measureText(text).width / 2));
                        const textY = centerY; // Ponto central para a porcentagem
                        
                        ctx.fillStyle = '#ffff';
                        ctx.fillText(text, textX, textY - 10); // Ajuste vertical (-10)
                        
                        // Texto secundário (Total Validado)
                        ctx.font = `0.8em sans-serif`;
                        const subText = 'Total Validado';
                        const subTextX = Math.round(centerX - (ctx.measureText(subText).width / 2));
                        ctx.fillStyle = '#666666';
                        ctx.fillText(subText, subTextX, textY + 15); // Abaixo do texto principal (+15)
                        
                        ctx.save();
                    }
                };


                // ===== CHART.JS =====
                const data = {
                    labels: labels,
                    datasets: [{
                        label: 'Horas Contabilizadas',
                        data: valores,
                        backgroundColor: cores,
                        borderColor: "#fff",
                        borderWidth: 2,
                        hoverOffset: 20
                    }]
                };

                if(somaExcesso > 0){
                    const labelsExcesso = Object.keys(horasExcedentes).map(id => `Excesso Atividade ${id} (${horasExcedentes[id].toFixed(1)}h)`);
    
                    const valoresExcesso = Object.values(horasExcedentes);
                    console.log(valoresExcesso, labelsExcesso);
                    data.datasets.push({
                        label: 'Horas Excedentes',
                        data: valoresExcesso,
                        backgroundColor: cores,
                        borderColor: "#fff",
                        borderWidth: 2,
                        hoverOffset: 20
                    })
                }

                const config = {
                    type: 'doughnut',
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
                    },
                    plugins: [centerText]
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