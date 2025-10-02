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
                    horasValidadas[idCurso] = (horasValidadas[idCurso] || 0) + horas;

                    const titulo = comp.comprovante.titulo || "Sem título";

                    if (!titulosPorAtividade[idCurso]) {
                        titulosPorAtividade[idCurso] = [];
                    }
                    titulosPorAtividade[idCurso].push(titulo);
                });

                // soma das horas validadas calculada manualmente
                const somaHoras = Object.values(horasValidadas).reduce((a, b) => a + b, 0);

                const faltando = totalMaximo - somaHoras;

                // valores para desenhar
                const valores = faltando > 0 
                ? [...Object.values(horasValidadas), faltando] 
                : Object.values(horasValidadas);

                // cores
                const paleta = [
                    "#4CAF50", // verde
                    "#2196F3", // azul
                    "#FFC107", // amarelo
                    "#F44336", // vermelho
                    "#9C27B0", // roxo
                    "#FF9800", // laranja
                    "#00BCD4", // ciano
                    "#795548"  // marrom
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
                    idsAtividades.push(null); // null para a fatia “faltando”
                }

                // ====== DESENHA O GRÁFICO ======
                // ==== Primeira Versão ====
                // let anguloInicial = 0;

                // valores.forEach((valor, i) => {
                //     const angulo = (valor / totalMaximo) * 2 * Math.PI;

                //     ctx.beginPath();
                //     ctx.moveTo(150, 150);
                //     ctx.arc(150, 150, 100, anguloInicial, anguloInicial + angulo);
                //     ctx.closePath();
                //     ctx.fillStyle = cores[i];
                //     ctx.fill();

                //     // Texto no meio da fatia
                //     const anguloMeio = anguloInicial + angulo / 2;
                //     const x = 150 + Math.cos(anguloMeio) * 60;
                //     const y = 150 + Math.sin(anguloMeio) * 60;

                //     ctx.fillStyle = "black";
                //     ctx.font = "12px Arial";
                //     ctx.textAlign = "center";
                //     ctx.textBaseline = "middle";

                //     const porcentagem = totalMaximo > 0 ? ((valor / totalMaximo) * 100).toFixed(1) + "%" : "0%";
                //     ctx.fillText(porcentagem, x, y);

                //     anguloInicial += angulo;
                // });


                // ===== CHART.JS =====

                const data = {
                    labels: labels,
                    datasets: [{
                        label: 'Horas',
                        data: valores,
                        backgroundColor: cores,
                        borderColor: "#fff",
                        borderWidth: 2
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

                                        // Array para o tooltip: primeira linha = label + porcentagem
                                        let linhas = [`${context.label} — ${porcent}`];

                                        if (idCurso) {
                                            // Adiciona cada título em uma linha separada
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

                // ====== LEGENDA PARA A 1° VERSÃO   ======
                // const legendaDiv = document.getElementById("legenda");
                // legendaDiv.innerHTML = ""; // limpa antes de recriar
                // labels.forEach((label, i) => {
                //     const item = document.createElement("div");
                //     item.style.display = "flex";
                //     item.style.alignItems = "center";
                //     item.style.marginBottom = "5px";

                //     const corBox = document.createElement("span");
                //     corBox.style.display = "inline-block";
                //     corBox.style.width = "15px";
                //     corBox.style.height = "15px";
                //     corBox.style.backgroundColor = cores[i];
                //     corBox.style.marginRight = "8px";

                //     const texto = document.createElement("span");
                //     texto.innerText = label;

                //     item.appendChild(corBox);
                //     item.appendChild(texto);
                //     legendaDiv.appendChild(item);
                // });
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