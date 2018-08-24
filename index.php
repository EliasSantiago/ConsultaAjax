<!doctype html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Elias Fonseca">

    <title>Consultas</title>

	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
  
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

	<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>



    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <link rel="stylesheet" type="text/css" href="assets/style.css">


    </head>

  <body>
  	<!--
    <nav class="navbar navbar-expand-md navbar-dark bg-dark">
      <a class="navbar-brand" href="#"></a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarsExampleDefault">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item active">
            <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Botão</a>
          </li>
          <li class="nav-item">
            <a class="nav-link disabled" href="#">Botão</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="https://example.com" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Dropdown</a>
            <div class="dropdown-menu" aria-labelledby="dropdown01">
              <a class="dropdown-item" href="#">A</a>
              <a class="dropdown-item" href="#">B</a>
              <a class="dropdown-item" href="#">C</a>
            </div>
          </li>
        </ul>
        <form class="form-inline my-2 my-lg-0">
          <input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search">
          <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Pesquisar</button>
        </form>
      </div>
    </nav>
-->

    <div role="main" class="container">
      <div class="container">
      <div class="row">
      	<div col-md-12>
        	<h2 class="titulo">Selecione os Critérios</h2>
      	</div>
      </div>
      </div>


<div class="container">
	<div class="row">
			<div class="col-6">
	  			<div class="form-group">
	  				<select class="form-control banco" id="banco"></select>
	  			</div>

	  			<div class="form-group">
	  				<select class="form-control tabelas" id="tabelas"></select>
	  			</div>	
			</div>

			<div class="col-6">
				<div class="form-group">
					<select multiple="" class="form-control campos" id="campos"></select>
				</div>
			</div>

		    <div class="col-12">
				<div class="card">
					<div class="card-header dados">
						<titulo id="txtTitulo">Dados Carregados</titulo>
	      				<button id="download" type="button" class="btn btn-success">
	      					<i class="fa"></i>Download
	      				</button>

	      				<form action="downloadDados.php" method="POST" id="download-form">
	      					<input name="campos" type="hidden" id="download-campos">
	      					<input name="dbName" type="hidden" id="download-banco">
	      					<input name="tabela" type="hidden" id="download-tabela">
	      				</form>


					</div>

					<div class="card-body dadosCarregados" id="dadosCarregados">

					</div>
				</div>
			</div>
	</div>
</div>



    </div><!-- /.container -->

  </body>
</html>


<script>
	//Buscar banco
		$.ajax({
			url: 'busca_banco.php',
			type: 'POST',
			beforeSend: function(){
				$("#banco").html("Carregando...");
			},
			success: function(data){
				$("#banco").html(data);
			},
			error: function(data){
				$("#banco").html("Algum erro ocorreu aqui!");
			}
		});


	//Buscar tabelas do banco selecionado
	$("#banco").on("change", function(){
		var nomeBanco = $("#banco").val();

		$.ajax({
			url: 'busca_tabelas.php',
			type: 'POST',
			data: {banco:nomeBanco},
			beforeSend: function(){
				$("#tabelas").html("Carregando...");
			},
			success: function(data){
				$("#tabelas").html(data);
			},
			error: function(data){
				$("#tabelas").html("Algum erro ocorreu aqui!");
			}
		});
	});



//Buscar campos da tabela selecionada
$("#tabelas").on("change", function(){
	var nomeTabela = $("#tabelas").val();
	var dbNome     = $("#banco").val();

	$.ajax({
		url: 'busca_campos.php',
		type: 'POST',
		data: {'tabela':nomeTabela, 'dbname':dbNome},
		beforeSend: function(){
			$("#campos").html("Carregando...");
		},
		success: function(data){
			$("#campos").html(data);
		},
		error: function(data){
			$("#campos").html("Algum erro ocorreu aqui!");
		}
	});
});



//Buscar dados dos campos selecionados
$("#download" ).hide();
$("#txtTitulo" ).hide();

$("#campos").on("change", function(){
	var dbNome = $("#banco").val();
	var nomeTabela = $("#tabelas").val();
	var campos = $("#campos").val();

	$.ajax({
		url: 'buscaDados.php',
		type: 'POST',
		data: {'dbName':dbNome, 'tabela':nomeTabela, 'campos':campos},
		beforeSend: function(){
			$("#dadosCarregados").html("Carregando...");
		},
		success: function(data){
			$("#dadosCarregados").html(data);
			$('#table_id').DataTable();
		},
		error: function(data){
			$("#dadosCarregados").html("Algum erro ocorreu aqui!");
		}
	});

	$("#download" ).show();
	$("#txtTitulo" ).show();
});

/*
$('.card-header').on('click', '#download', function(event){

	var dbNome = $(".banco").val();
	var nomeTabela = $(".tabelas").val();
	var campos = $(".campos").val();
	$.ajax({
			url: 'downloadDados.php',
			type: 'POST',
			data: {'dbName':dbNome, 'tabela':nomeTabela, 'campos':campos},
			beforeSend: function(){
				$(".dadosCarregados").html("Carregando...");
			},
			success: function(data){
				$(".dadosCarregados").html(data);
			}
	});

});
*/



$('.card-header').on('click', '#download', function(event){
	var dbNome = $("#banco").val();
	var nomeTabela = $("#tabelas").val();
	var campos = $("#campos").val();

	$("#download-campos").val(campos);
	$("#download-tabela").val(nomeTabela);
	$("#download-banco").val(dbNome);
	$("#download-form").submit();
});


jQuery(document).ready( function () {
	$('#table_id').DataTable();
});

</script>