function getContent(timestamp)
{
	var
	queryString = {'timestamp' : timestamp}; 

	function getChamados(response){
		var 
		qtd_n_solucionado = document.getElementById('qtd_n_solucionado');
		qtd_novos 	 	  = document.getElementById('qtd_novos');
		qtd_outros 	 	  = document.getElementById('qtd_outros');
		qtd_vencidos 	  = document.getElementById('qtd_vencidos');
		qtd_n_atribuidos  = document.getElementById('qtd_n_atribuidos');
		responseJSON 	  = response.chamados_analitico;

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


 	} 

 	function getChamadosArea(response){
 		var
 		responseJSON = response.chamados_area;

		// limpa o grafico
		ChartTicketsNSolucionadosArea.innerHTML = '';

        // Monta o gráfico de chamados não solucionados por área
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
    }

    function getChamadosAreaNovos(response){
    	var
 		responseJSON = response.chamados_area_novos;

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
    }

    function getChamadosTecnicos(response){
    	var
 		responseJSON = response.chamados_tecnicos;

    	// limpa o grafico
    	ChartTicketsNSolucionadosTecnico.innerHTML = '';

    	Morris.Bar({
    		element: 'ChartTicketsNSolucionadosTecnico',
    		data: responseJSON,
    		xkey: 'firstname',
    		ykeys: ['total', 'solucionados'],
    		labels: ['Técnico', 'Chamados abertos'],
    		xLabelAngle: 0,
    		labelTop: true,
    		gridTextSize:20,
    		gridTextColor:"#000",
    		gridTextWeight:"bold",
    		axes:'x'
    	});
    }

    $.get('scripts/php/api/getAllData.php', queryString, function(data)
    {
    	var responseJSON = JSON.parse(data).chamados;
    	var resonseTimeStamp = JSON.parse(data).timestamp;

		 getChamados(responseJSON[0]); // Obter informações de chamados
		 getChamadosArea(responseJSON[1]); // Obter informações de chamados por area
		 getChamadosAreaNovos(responseJSON[2]); // Obter informações de chamados por area novos
		 getChamadosTecnicos(responseJSON[3]); // Obter informações de chamados por tecnicos		

        // reconecta ao receber uma resposta do servidor
        getContent(resonseTimeStamp);
    });
}

$(document).ready(function()
{
	getContent();
});
