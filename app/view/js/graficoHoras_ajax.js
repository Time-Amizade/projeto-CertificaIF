function carregarDados(BASEURL) {
    var xhttp = new XMLHttpRequest();
    var resultado; // ← declarada aqui    

    var url = BASEURL + "/controller/PerfilController.php?action=listJson&id=" + ID_USUARIO;
    
    xhttp.open('GET', url, true);
    xhttp.onload = function() {
        if (xhttp.status === 200) {
            try {
                var resultado = JSON.parse(xhttp.responseText);
                var c = resultado;
                console.log("somente :",c);
                const canvas = document.getElementById("graficoPizza");
                const ctx = canvas.getContext("2d");

                const totalMaximo = resultado.curso.cargaHorariaAtivComplement;
                
                let titulosPorAtividade = {};
                let horasValidadas = {};
                
                resultado.comprovantes.forEach(function(comp) {
                    let idCurso = comp.cursoAtiv.id;
                    let horas = comp.comprovante.horas || 0;

                    // Soma incremental com limite
                    let atual = horasValidadas[idCurso] || 0;
                    let novaSoma = atual + horas;

                    // Se a soma parcial passar do totalMaximo, corta o excesso
                    horasValidadas[idCurso] = (novaSoma + totalHorasValidadas(horasValidadas) - atual) > totalMaximo
                        ? totalMaximo - totalHorasValidadas(horasValidadas)
                        : novaSoma;

                    const titulo = comp.comprovante.titulo || "Sem título";
                    if (!titulosPorAtividade[idCurso]) titulosPorAtividade[idCurso] = [];
                    titulosPorAtividade[idCurso].push(titulo);
                });

                // ======= FUNÇÃO AUXILIAR =======
                function totalHorasValidadas(obj) {
                    return Object.values(obj).reduce((a, b) => a + b, 0);
                }

                // Garante que a soma final não passe do total máximo
                let somaHoras = totalHorasValidadas(horasValidadas);
                if (somaHoras > totalMaximo) somaHoras = totalMaximo;

                const faltando = totalMaximo - somaHoras;

                const valores = Object.values(horasValidadas);

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

                const coresAleatorias = Object.values(horasValidadas).map((_, i) => paleta[i % paleta.length]);
                const cores = faltando > 0 
                ? [...coresAleatorias, "#CCCCCC"] 
                : coresAleatorias;

                // labels
                const labels = Object.values(horasValidadas).map((h, i) => `Atividade ${i + 1} (${h}h)`);
                const idsAtividades = Object.keys(horasValidadas);  

                if (faltando > 0) {
                    valores.push(faltando);
                    labels.push(`Horas a validar (${faltando}h)`);
                    idsAtividades.push(null);
                }

                // ===== CHART.JS =====
                const data = {
                    labels: labels,
                    datasets: [{
                        label: 'Horas',
                        data: valores,
                        backgroundColor: cores,
                        borderColor: "#fff",
                        borderWidth: 2,
                        hoverBorderColor: "#000",
                        hoverOffset: 20
                    }]
                };

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
                                        const idCurso = idsAtividades[index];
                                        const valor = context.parsed;
                                        const porcent = ((valor / totalMaximo) * 100).toFixed(1) + "%";

                                        let linhas = [`${context.label} — ${porcent}`];

                                        if (idCurso) {
                                            titulosPorAtividade[idCurso].forEach(titulo => {
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