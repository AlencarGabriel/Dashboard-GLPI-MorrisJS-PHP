function getContent(timestamp)
{
	var 
	qtd_n_solucionado = document.getElementById('qtd_n_solucionado');
	qtd_novos 	 	  = document.getElementById('qtd_novos');
	qtd_outros 	 	  = document.getElementById('qtd_outros');
	qtd_vencidos 	  = document.getElementById('qtd_vencidos');
	qtd_n_atribuidos  = document.getElementById('qtd_n_atribuidos');
	queryString = {'timestamp' : timestamp};  

	$.get('scripts/php/api/getChamados.php', queryString, function(data)
	{
		var responseJSON = JSON.parse(data).chamados;
		var resonseTimeStamp = JSON.parse(data).timestamp;

 		// console.log(responseJSON);

 		qtd_n_solucionado.innerHTML = responseJSON["N_Solucionados"];
 		qtd_novos.innerHTML 		= responseJSON["Novos"];
 		qtd_outros.innerHTML 		= responseJSON["Outros"];
 		qtd_vencidos.innerHTML 		= responseJSON["Vencidos"];
 		qtd_n_atribuidos.innerHTML  = responseJSON["N_Atribuidos"];  


 		// cria um array com os dias de vencimento
 		Days = [responseJSON["Venc_umdia"], 
 		responseJSON["Venc_doisdia"],
 		responseJSON["Venc_tresdia"],
 		responseJSON["Venc_quatrodia"],
 		responseJSON["Venc_cincodia"],
 		responseJSON["Venc_seisdia"],
 		responseJSON["Venc_setedia"],
 		responseJSON["Venc_oitodia"],
 		responseJSON["Venc_novedia"],
 		responseJSON["Venc_dezdia"]];   

 		// limpa o grafico
 		ChartTicketsVencimento.innerHTML = '';

 		// Monta o gráfico de chamados a vencer
 		var Chart = Morris.Bar({
 			element: 'ChartTicketsVencimento',
 			data: [
 			{y: '1d',   a: Days[0]},
 			{y: '2d',  a: Days[1]},
 			{y: '3d',  a: Days[2]},
 			{y: '4d',  a: Days[3]},
 			{y: '5d',  a: Days[4]},
 			{y: '6d',  a: Days[5]},
 			{y: '7d',  a: Days[6]},
 			{y: '8d',  a: Days[7]},
 			{y: '9d',  a: Days[8]},
 			{y: '10d', a: Days[9]}
 			],
 			xkey: 'y',
 			ykeys: ['a'],
 			labels: ['Dias a vencer', 'Chamados abertos'],
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
        getContent(resonseTimeStamp);
    });
}

$(document).ready(function()
{
	getContent();
});
