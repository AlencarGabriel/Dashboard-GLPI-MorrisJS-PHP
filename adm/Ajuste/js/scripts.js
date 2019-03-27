// Seta o DateTimePicker para o elemento
$(".form_datetime").datetimepicker({
	language:  'pt-BR',
	format: "yyyy-mm-dd hh:ii:ss",
	autoclose: true,
	todayBtn: true,
	pickerPosition: "bottom-left",
	initialDate: new Date()
});

$(function() {
	$('#frmAjustar').submit(function(e){

		//prevent Default functionality
		e.preventDefault();

		$.post('../../scripts/php/api/setAjustar.php', $(this).serialize())
		.done(function(data){
			var json = JSON.parse(data);
			var id = $('#tickets_id').val();
			
			console.log(json);

			$("#notification").addClass("invisible");
			$("#notification").removeClass("alert-success");
			$("#notification").removeClass("alert-danger");
			
			if (json.ajuste[0]){
				$("#notification > h4").html('Sucesso!');
				$("#notification > span").html('Ajuste efetuado com sucesso. Chamado: <a target="_blank" href="http://192.168.50.59/glpi/front/ticket.form.php?id=' + id +  '" class="alert-link">#' + id + '</a>');
				$("#notification").addClass("alert-success");
				$("#notification").removeClass("invisible");
				$('#frmAjustar').trigger("reset");
			}else{
				$("#notification > h4").html('Erro!');
				$("#notification > span").html('Mensagem: ' + json.ajuste[1]);
				$("#notification").addClass("alert-danger");
				$("#notification").removeClass("invisible");
			}	

		})
		.fail(function(data){
			console.log(data);
			alert(data);
		})
	});
});
