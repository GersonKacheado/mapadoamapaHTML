<?php
session_start();
if(!isset($_SESSION["UsuarioCpf"])){
  echo "<script>location.href='public/login/index.php'</script>";
  exit();
}
include_once("../SQL.php");

$procedimentos 		= new SQL;
$validarForm 		= @$_POST['EditarDadosForm'];
$idfila 			= @$_POST['idfila'];

if (isset($_POST['btnDadosEdit']) && $validarForm=='AssistidosCarreta') {

 	$idfila 						= @$_POST['idfila'];
	$fk_nucleo 						= @$_POST['obsnucleos'];
	$fk_regime 						= @$_POST['regime'];
	$fk_atendente 					= @$_POST['atendente'];
	$chamdo_para_atendimento 		= @$_POST['chamdo_para_atendimento'];
 	$observacao						= @$_POST['observacao'];


//	$procedimentos->startPcd("`pcd_finaliza_atendimento`($idfila,$obsnucleos,$obsacoes,$atendente,$chamdo_para_atendimento,$observacao)");

$procedimentos->setTabela("`tbl_fila`");
$procedimentos->setValuesTbl("`observacao` = '".$observacao."'");

$procedimentos->setValuesTbl("`fk_nucleo` = '".$fk_nucleo."', `fk_regime` = '".$fk_regime."', `fk_atendente` = '".$fk_atendente."', `chamdo_para_atendimento` = '".$chamdo_para_atendimento."', `observacao` = '".$observacao."'");

$procedimentos->setIdDados("`idfila`");
$procedimentos->setIdValues("$idfila");
$procedimentos->alterar();


	$msg = "Registro Editado :". $idfila;
 	header("Location: ../../?op=recepcao&msg=".base64_encode($msg)."");
}

?>