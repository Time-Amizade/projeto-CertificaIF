  var xhttp = new XMLHttpRequest();

    var url = BASEURL + "/controller/PerfilController.php?action=listJson "+ $id;
    xhttp.open('GET', url, true);
    xhttp.onload = function() {
        if(xhttp.status === 200){
            var listaDados = document.getElementById("listaDados");
            listaDados.innerHTML = "";
            try {
                var resultado = JSON.parse(xhttp.responseText);
                console.log(resultado);
            } catch (e) {
                console.error('Erro ao processar JSON:', e);
                console.error(xhttp.responseText);
            }

        }
    }





const canvas = document.getElementById("graficoPizza");
const ctx = canvas.getContext("2d");

// Total máximo (exemplo: 48 horas)
const totalMaximo = 48;

// Horas do aluno (pode vir do backend)
const horasValidadas = [5, 8, 3, 20]; // exemplo
const somaHoras = horasValidadas.reduce((acc, val) => acc + val, 0);

// Adiciona a fatia de "faltando validar"
const faltando = totalMaximo - somaHoras;
const valores = faltando > 0 ? [...horasValidadas, faltando] : horasValidadas;

// Gera cores aleatórias para as horas validadas
const coresAleatorias = horasValidadas.map(() => "#" + Math.floor(Math.random() * 16777215).toString(16)
);

// Cor fixa para "faltando"
const cores = faltando > 0 
  ? [...coresAleatorias, "#CCCCCC"] 
  : coresAleatorias;

// Labels
const labels = horasValidadas.map((h, i) => `Atividade ${i + 1} (${h}h)`);
if (faltando > 0) labels.push(`Horas a validar (${faltando}h)`);

// ====== DESENHA O GRÁFICO ======
let anguloInicial = 0;
valores.forEach((valor, i) => {
    const angulo = (valor / totalMaximo) * 2 * Math.PI;

    ctx.beginPath();
    ctx.moveTo(150, 150);
    ctx.arc(150, 150, 100, anguloInicial, anguloInicial + angulo);
    ctx.closePath();
    ctx.fillStyle = cores[i];
    ctx.fill();

    // Texto no meio da fatia
    const anguloMeio = anguloInicial + angulo / 2;
    const x = 150 + Math.cos(anguloMeio) * 60;
    const y = 150 + Math.sin(anguloMeio) * 60;

    ctx.fillStyle = "black";
    ctx.font = "12px Arial";
    ctx.textAlign = "center";
    ctx.textBaseline = "middle";

    const porcentagem = ((valor / totalMaximo) * 100).toFixed(1) + "%";
    ctx.fillText(porcentagem, x, y);

    anguloInicial += angulo;
});

// ====== LEGENDA ======
const legendaDiv = document.getElementById("legenda");
legendaDiv.innerHTML = ""; // limpa antes de recriar
labels.forEach((label, i) => {
    const item = document.createElement("div");
    item.style.display = "flex";
    item.style.alignItems = "center";
    item.style.marginBottom = "5px";

    const corBox = document.createElement("span");
    corBox.style.display = "inline-block";
    corBox.style.width = "15px";
    corBox.style.height = "15px";
    corBox.style.backgroundColor = cores[i];
    corBox.style.marginRight = "8px";

    const texto = document.createElement("span");
    texto.innerText = label;

    item.appendChild(corBox);
    item.appendChild(texto);
    legendaDiv.appendChild(item);
});