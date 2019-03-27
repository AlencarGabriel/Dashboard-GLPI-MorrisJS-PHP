function getContentTecnico(timestamp)
{
    var 
    queryString = {'timestamp' : timestamp};  

    $.get('scripts/php/api/getChamadosTecnicos.php', queryString, function(data)
    {
        var responseJSON = JSON.parse(data).chamados;
        var resonseTimeStamp = JSON.parse(data).timestamp;

        // console.log(responseJSON);

        // limpa o grafico
        ChartTicketsNSolucionadosTecnico.innerHTML = '';

        // Monta o gráfico de chamados a vencer
        // Morris.Bar({
        //     element: 'ChartTicketsNSolucionadosTecnico',
        //     data: responseJSON,
        //     xkey: 'firstname',
        //     ykeys: ['total'],
        //     labels: ['Técnico', 'Chamados abertos'],
        //     xLabelAngle: 0,
        //     labelTop: true,
        //     gridTextSize:20,
        //     gridTextColor:"#000",
        //     gridTextWeight:"bold",
        //     axes:'x'
        // });

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

        // for (var k in obj)
        // {
        //     var comment = "<p>" + obj[k].comment + "</p>";
        //     var timestamp = obj[k].timestamp;
        //     $('#response').append(comment);
        // } 
        // reconecta ao receber uma resposta do servidor
        getContentTecnico(resonseTimeStamp);
    });
}

$(document).ready(function()
{
    getContentTecnico();
});