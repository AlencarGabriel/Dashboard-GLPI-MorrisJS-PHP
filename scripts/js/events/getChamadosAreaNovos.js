function getContentAreaNovos(timestamp)
{
    var 
    queryString = {'timestamp' : timestamp};  

    $.get('scripts/php/api/getChamadosAreaNovos.php', queryString, function(data)
    {
        var responseJSON = JSON.parse(data).chamados;
        var resonseTimeStamp = JSON.parse(data).timestamp;

        // console.log(responseJSON);

       // limpa o grafico
       ChartTicketsNSolucionadosAreaNovos.innerHTML = '';

        // Monta o gráfico de chamados não solucionados por área Novos
        Morris.Bar({
            element: 'ChartTicketsNSolucionadosAreaNovos',
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

        // for (var k in obj)
        // {
        //     var comment = "<p>" + obj[k].comment + "</p>";
        //     var timestamp = obj[k].timestamp;
        //     $('#response').append(comment);
        // } 
        // reconecta ao receber uma resposta do servidor
        getContentAreaNovos(resonseTimeStamp);
    });
}

$(document).ready(function()
{
    getContentAreaNovos();
});
