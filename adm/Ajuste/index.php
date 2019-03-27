<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>GLPI - Ajuste de Tempo Focado</title>

	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/style.css" rel="stylesheet">
	<link href="css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">	

</head>
<body>

	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="page-header">
					<h1>
						GLPI <small>Ajuste de Tempo Focado</small>
					</h1>
				</div>
				<div id="notification" class="invisible alert alert-dismissable">

					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">
						×
					</button>
					
					<h4></h4> 
					<span></span>
				</div>
				<form role="form" name="frmAjustar" id="frmAjustar" action="" method="POST">
					<div class="form-group col-xs-2 col-md-2">

						<label for="tickets_id" class="control-label">
							ID do Chamado
						</label>
						<div class="input-group">
							<div class="input-group-addon">#</div>
							<input type="numeric" class="form-control" id="tickets_id" name="tickets_id">
						</div>
					</div>
					
					<div class="form-group col-xs-4 col-md-4">

						<label for="date">
							Data da Inclusão
						</label>
						<div class="input-group date form_datetime">
							<input class="form-control" size="16" type="text" value="" name="date" id="date" readonly>
							<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
							<span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
						</div>
						<!-- <input type="hidden" id="date" name="date" value="" /> Se nao funcionar, testar com o atributo data-link-field -->
					</div>   

					<div class="form-group col-xs-4 col-md-4">

						<label for="new_status">
							Ajustar para Status:
						</label>
						<!-- <div class="form-group"> -->
						<select class="form-control" name="new_status" id="new_status">
							<option value="3">Chamado em Atendimento</option>
							<option value="4">Pendente</option>
						</select> 
						<!-- </div> -->
					</div>  

					<div class="form-group col-xs-2 col-md-2">
						<label for="ticket_datetime">
							&nbsp;
						</label>
						<div class="input-group">
							<button type="submit" class="btn btn-success">
								Ajustar
							</button>
						</div>
					</div>
				</form>
			</div>
		</div>

		<hr>

		<div class="row">
			<div class="col-md-6">
				<table class="table table-striped">
					<thead>
						<tr>
							<th>Coluna</th>
							<th>Valor</th>					
						</tr>	
					</thead>

					<tbody>
						<tr>
							<th scope="row">AAA</th>
							<td>BBB</td>
						</tr>					
					</tbody>
				</table>
			</div>
		</div>
	</div>

	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script type="text/javascript" src="js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
	<script type="text/javascript" src="js/bootstrap-datetimepicker.pt-BR.js" charset="UTF-8"></script>
	<script src="js/scripts.js"></script>
</body>
</html>