<?php
    ini_set('display_errors',1);
    ini_set('display_startup_erros',1);
    error_reporting(E_ALL);
    if(!isset($_SESSION)) session_start();
    if(!isset($_SESSION["UsuarioCpf"])) {
        echo "<script>location.href='public/login/index.php'</script>";
        exit();
    }
    require_once("view/topo.php"); // inclusao de arquivo php
    require_once("view/menu.php"); // inclusao de arquivo php
?>
    <div class="content-wrapper" id="conteudo">
        <section class="content">
            <div class="box">
                <div class="box-body">
                  <?php
                    isset($_GET['op'])?$op=strtolower($_GET['op']):$op='home';
                    if($op === 'logout'){
                        if (isset($_SESSION)) session_destroy();
                        if(isset($_GET)) unset($_GET);
                            echo "<script>location.href='public/login/index.php'</script>";
                     }else{
// INICIO DA Area das Entradas das opções do Menu ##   
                        require("view/$op.php");  // inclusao da pagina de Abertura após LOGAR
// FIM DA Area das Entradas das opções do Menu ##                        
                     }
                     if($op =='home') {
                  ?>
                </div>
                  <?php }?>
            </div>
        </section>
    </div>
<?php require_once("view/base.php");?>


