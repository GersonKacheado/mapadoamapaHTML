<?php 
session_start();
if(!isset($_SESSION["UsuarioCpf"])){
  echo "<script>location.href='public/login/index.php'</script>";
  exit();
}

include_once("../SQL.php");
$procedimentos = new SQL;

if (base64_decode($_GET['finalizar'])=='finalizarAtendimento') {

	$idfila 				= base64_decode($_GET['idfila']);


	$procedimentos->startPcd("`pcd_finaliza_atendimento`($idfila)");
	$msg = "o atendimento ...";
	header("Location: ../../?op=atendimento&msg=".base64_encode($msg)."");
}

?>