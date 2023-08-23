<?php
	require_once 'usuario.class.php';

	$usuario 	= new Usuario();
	$cpf		= strtolower($_POST['cpf']);
  	$senha		= strtolower($_POST['senha']);
  	$habilitado	= 'S';

  	$logado = $usuario->logar($cpf, $senha, $habilitado);

	if(!$logado){
	   	header("Location: logout.php");
	   	exit();
	}

	foreach($logado as $linhas) {
		session_start();
        $_SESSION["UsuarioId"] 			= $linhas->iduser;
        $_SESSION["UsuarioCpf"] 		= $linhas->cpf_user;
        $_SESSION["UsuarioNome"] 		= $linhas->nome_user;
        $_SESSION["UsuarioFoto"] 		= $linhas->cpf_user.".png";
        $_SESSION["UsuarioHabilita"] 	= $linhas->habilitado;
        $_SESSION["UsuarioFuncao"] 		= $linhas->dsc_funcao;
        $_SESSION["UsuarioFuncao_user"] = $linhas->dsc_funcao_user;
        $_SESSION["ID_GUICHE_USER"]		= $_SERVER['REMOTE_ADDR'];

 	 	header("Location:../../../index.php");
	}
?>

