document.addEventListener('DOMContentLoaded', function(){
    window.setInterval(function(){
        xhr.get('scripts/php/api/getChamadosArea.php', function(result){
            var responseJSON = JSON.parse(result).chamados;
            // console.log(responseJSON);

            // limpa o grafico
            var DIV_Chart_ChartTicketsNSolucionadosTecnico = document.getElementById('ChartTicketsNSolucionadosArea'); 
            ChartTicketsNSolucionadosArea.innerHTML = '';

             // Monta o gráfico de chamados a vencer
             Morris.Bar({
                element: 'ChartTicketsNSolucionadosArea',
                data: responseJSON,
                xkey: 'area',
                ykeys: ['total'],
                labels: ['Area', 'Chamados abertos'],
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

