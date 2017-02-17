document.addEventListener('DOMContentLoaded', function(){
    window.setInterval(function(){
        xhr.get('scripts/php/api/getChamadosTecnicos.php', function(result){
            var responseJSON = JSON.parse(result).chamados;
            // console.log(responseJSON);

            // limpa o grafico
            var DIV_Chart_ChartTicketsNSolucionadosTecnico = document.getElementById('ChartTicketsNSolucionadosTecnico'); 
            ChartTicketsNSolucionadosTecnico.innerHTML = '';

             // Monta o gráfico de chamados a vencer
             Morris.Bar({
                element: 'ChartTicketsNSolucionadosTecnico',
                data: responseJSON,
                xkey: 'firstname',
                ykeys: ['total'],
                labels: ['Técnico', 'Chamados abertos'],
                xLabelAngle: 0,
                labelTop: true,
                gridTextSize:20,
                gridTextColor:"#000",
                gridTextWeight:"bold",
                axes:'x'
            });

         });
    }, 5000);

});     

