<?php

include_once("conn.php");
class SQL extends Database
{
	protected $msg, $sql, $tabela, $colunas, $values, $valuestbl, $id_dados, $id_values, $dados;

	function setTabela($tbl)
	{
		$this->tabela = $tbl;
	}
	function setColunas($clns)
	{
		$this->colunas = $clns;
	}
	function setValues($vls)
	{
		$this->values = $vls;
	}

	function setValuesTbl($vlstbl){
		$this->valuestbl = $vlstbl;
	}
	function setIdDados($id_dds){
		$this->id_dados = $id_dds;
	}
	function setIdValues($id_vls){
		$this->id_values = $id_vls;
	}
	function getDados(){
		return $this->dados;
	}
	function getMsg()
	{
		return $this->msg;
	}	
	function startPcd($pcd)
	{ 
		$sql = "CALL ".$pcd."";  
	 	if (self::execute($sql)) {$this->msg = true;}
 	}  

	function alterar()
	{
 	 	$this->sql = "UPDATE $this->tabela SET $this->valuestbl WHERE $this->id_dados = $this->id_values";	
		if (self::execute($this->sql)) {$this->msg =  true;
		}
	}
	function mulAlterarValor()
	{
		$this->sql = "UPDATE $this->tabela SET $this->valuestbl WHERE $this->id_dados IN ($this->id_values)";	
		if (self::execute($this->sql)) {$this->msg =  true;
		}
	}
	function insert()
	{
		$this->sql = "INSERT INTO $this->tabela ($this->colunas) VALUES ($this->values)";	
		if (self::execute($this->sql)) {$this->msg =  true;
		}
	}
	function delete()
	{
		$this->sql = "DELETE FROM $this->tabela WHERE $this->id_dados = $this->id_values";	
		if (self::execute($this->sql)) {$this->msg =  true;
		}
	}

	function selectUltimoDado(){

			$sql = "SELECT MAX($this->id_dados) as dados FROM $this->tabela";
			self::execute($sql);
			while($resultado = $this->stmt->fetch(PDO::FETCH_OBJ)) {
        		return $resultado->dados;
        		
    		}
		}


	function selectUltimoDoc(){

			$sql = "SELECT $this->values as dados FROM $this->tabela WHERE $this->id_dados";
			self::execute($sql);
			while($resultado = $this->stmt->fetch(PDO::FETCH_OBJ)) {
				return $resultado->dados;
				
			}
		}

	function selectUltimoUpDado($id){
			$sql = "SELECT MAX($this->id_dados) as dados FROM $this->tabela WHERE $id";
			self::execute($sql);
			while($resultado = $this->stmt->fetch(PDO::FETCH_OBJ)) {
        		$this->dados = $resultado->dados;
        		
    		}
		}

		function selectDadosUnico($id){
			echo $sql = "SELECT  lgn as dados FROM $this->tabela WHERE $id";
			self::execute($sql);
			while($resultado = $this->stmt->fetch(PDO::FETCH_OBJ)) {
        		$this->dados = $resultado->dados;
        		
    		}
		}
}


?>