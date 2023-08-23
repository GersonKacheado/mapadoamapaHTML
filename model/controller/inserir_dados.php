<?php


session_start();
if(!isset($_SESSION["UsuarioCpf"])){
	echo "<script>location.href='public/login/index.php'</script>";
	exit();
  	}
 include_once("../SQL.php");
 
 $inserirDados 	= new SQL;
 $validarForm 	= @$_POST['insertDadosForm'];
 $validarLinks 	= @$_GET['insertDadosLinks'];
 if (isset($_POST['btnDadosInsert']) && $validarForm=='Assistidos') {
	 

	$fk_nivelAtendimento 		= strtoupper($_POST['nivel_atendimento']);
	$fk_sexoAtendimento 		= strtoupper($_POST['sexo_atendimento']);
	$fk_regime 					= strtoupper($_POST['regime']);
	$fk_nucleo 					= strtoupper($_POST['obsnucleos']);
	$fk_atendente 				= strtoupper($_POST['atendente']);
	$chamdo_para_atendimento	= 0; 
 	$nome 						= strtoupper($_POST['nome']);
	$dsc_fisica 				= strtoupper($_POST['dsc_fisica']);
	$pavilhao 					= strtoupper($_POST['endereco']);
    $observacao					= strtoupper($_POST['observacao']);


	$inserirDados->setTabela("`tbl_fila`");
	$inserirDados->setColunas("`idfila`, `fk_nivel_atendimento`, `fk_sexo_atendimento`, `fk_regime`, `fk_nucleo`, `fk_atendente`, `chamdo_para_atendimento`, `nome`, `dsc_fisica`,`endereco`, `observacao`");

	$inserirDados->setValues("null, '".$fk_nivelAtendimento."', '".$fk_sexoAtendimento."', '".$fk_regime."', '".$fk_nucleo."', '".$fk_atendente."', '".$chamdo_para_atendimento."', '".$nome."', '".$dsc_fisica."', '".$pavilhao."', '".$observacao."'");

	$inserirDados->insert();

	if ($inserirDados->getMsg()) {
		$msg = 'Adicionado a lista de espera';
	}else{
		$msg = 'Erro: ao Adicionado a lista';
	}
	header("Location: ../../?op=recepcao&msg=".base64_encode($msg)."");
}


if (isset($_GET['btnDadosInsert']) && $validarLinks=='novoAtendemento') {
	
	$fkUser 	= $_GET['user'];
	$fkFila 	= $_GET['fila'];
	$fkGuiche = $_GET['guiche'];

	$inserirDados->setTabela("`tbl_atendimento`");
	$inserirDados->setColunas("`idatendimento`, `fk_user`, `fk_fila`, `fk_guiche`, `parou_falar`, `status_atendido`");
	$inserirDados->setValues("null, '".$fkUser."', '".$fkFila."', '".$fkGuiche."', 0, 0");
	$inserirDados->insert();
	if ($inserirDados->getMsg()) {
		$msg = 'Chamando para atendimento';
		
	}else{
		$msg = 'Chamando para atendimento';
		
	}
	header("Location: ../../?op=finaliza&msg=".base64_encode($msg)."");
}

?>