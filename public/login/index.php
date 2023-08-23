<?php 
    if(!isset($_SESSION["UsuarioLogin"])){
        $_SESSION["UsuarioLogin"] = 'visitante';
        $_SESSION["UsuarioFoto"]  = 'img/login/'.$_SESSION["UsuarioLogin"].'.png';
    }
    $usuario    = $_SESSION["UsuarioLogin"];
    $foto       = $_SESSION["UsuarioFoto"];
    include_once("topo.php");
	include_once("menu.php");
    include_once("banner.php");
  	include_once("base.php");
?>
