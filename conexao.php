<?php 
echo "<meta charset='utf-8'>";
set_time_limit(0);

class Conexao{
public $dbname;
public $tb;

public function __construct($dbname='', $tb=''){
	$this->dbname = $dbname;
	$this->tb = $tb;
}

private function getConexao() {
	$servidor = "localhost";
	$porta = 5432;
	$banco = "postgres";
	$usuario = "postgres";
	$senha = "etsbsb";

	$conn = pg_connect("host=$servidor port=$porta dbname=$banco user=$usuario password=$senha");
	return $conn;
}

public function buscarBanco(){
	$conn = $this->getConexao();

	if($conn){

		$sql = "SELECT schema_name FROM information_schema.schemata";

	    $res = pg_query($conn, $sql);
	    
	    echo '<option value="" selected="">Selecione o Banco</option>';

		while($row = pg_fetch_array($res)){
			echo '<option>' .$row['schema_name']. '</option>';
		}

	}
    pg_close($conn);
}




public function buscarTabelas($dbname){

	$conn = $this->getConexao();

    $schema = $dbname;

	if($conn){

		$sql = "SELECT table_name FROM information_schema.tables WHERE table_schema = '$schema'";

	    $res = pg_query($conn, $sql);
	    
	    echo '<option value="" selected="">Selecione a Tabela</option>';

		while($row = pg_fetch_array($res)){
			echo '<option>' .$row['table_name']. '</option>';
		}

	}
     //pg_close($conn);
}

public function buscarCampos($dbname, $tb){

	$conn = $this->getConexao();

	if($conn){
		$sql = "SELECT column_name FROM information_schema.columns WHERE table_name ='$tb'";
	    $res = pg_query($conn, $sql);
	    echo '<option value="" selected="">Selecione o(s) Campo(s)</option>';
		while($row = pg_fetch_array($res)){
			echo '<option>' .$row['column_name']. '</option>';
		}
	}
	
}

public function buscarDados($banco, $tabela, $campos){
	
	$conn = $this->getConexao();

	if($conn){
		$sql = "SELECT * FROM $banco.$tabela";
		echo '<table id="table_id" class="table display table-striped table-bordered table-condensed table-hover"><thead class="">';
		foreach (json_decode($campos) as $key => $campo) {
			echo '<td>'. $campo .'</td>';
		}
		echo '</thead>';

	    $res = pg_query($conn, $sql);

		while($row = pg_fetch_array($res)){
			echo '<tr>';
			foreach (json_decode($campos) as $key => $value) {
				echo '<td>'.$row[$value].'</td>';
			}
			echo '</tr>';

		}
		echo '</table>';

	}

	pg_close($conn);
}

public function download($banco, $tabela, $campos){
	$campos = explode(',', $campos);
	$conn = $this->getConexao();

	if($conn){
		$sql = "SELECT * FROM $banco.$tabela";
	    $res = pg_query($conn, $sql);

		$arquivo = '$tabela.xls';

		header ('Cache-Control: no-cache, must-revalidate');
		header ('Pragma: no-cache');
		header('Content-Type: application/x-msexcel');
		header ("Content-Disposition: attachment; filename=\"{$arquivo}\"");
		echo '<table id="table_id" class="display table-striped table-bordered table-condensed table-hover"><thead class="">';
		foreach ($campos as $key => $campo) {
			echo '<td>'. $campo .'</td>';
		}
		echo '</thead>';

		while($row = pg_fetch_array($res)){
			echo '<tr>';
			foreach ($campos as $key => $value) {
			// print_r($row);
			// print_r($campos);
			// print_r($value);
			// exit();
				echo '<td>'.$row[$value].'</td>';
			}
			echo '</tr>';

		}
		echo '</table>';

	}
	pg_close($conn);
}


}
?>