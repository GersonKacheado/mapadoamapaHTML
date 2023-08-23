<?php
include_once("conn.php");
define("ID_USER", $_SESSION["UsuarioId"]);
define("GUICHE_USER", @$_SESSION["ID_GUICHE_USER"]);

class SELECIONARDADOS extends Database
{
    public $nome_assistido, $guiche, $nivel, $falarDados;

    function getNome(){
        return $this->nome_assistido;
    }
    function getGuiche(){
        return $this->guiche;
    }
    function getNivel(){
        return $this->nivel;
    }
    function getFalarNomeGuiche(){
        return $this->falarDados;
    }
    function __construct($guiche){

        $sql = "SELECT * FROM `tbl_guiche` WHERE `ippc` = '".$guiche."' ";
        self::execute($sql);
        while($resultado = $this->stmt->fetch(PDO::FETCH_OBJ)) {
            define("ID_GUICHE_USER", $resultado->idguiche);    
        }
    }

/*
*
*
nome que esta sendo falado...
*
*
*/

    function setListaAtendimentoChamado(){
        $sql = "SELECT * FROM `VIEW_DADOS_ATENDIMENTO` where finalizar_falar <> 1 ORDER BY `idatendimento` DESC LIMIT 0,1";
        self::execute($sql);
        while($resultado = $this->stmt->fetch(PDO::FETCH_OBJ)) {
            if ($resultado->nome_nivel=='normal') {
                $this->nivel = "NORMAL";
            }else{
                $this->nivel = "<button type='button' style='background-color:#98cf4b; color:green'>PRIORIDADE</button></td>";
            }
            $this->nome_assistido = $resultado->nome_assistido;
            $this->guiche = $resultado->guiche_numero;
            $this->falarDados = "Nome: .".strtolower($resultado->nome_assistido).".  Guichê: .".$resultado->guiche_numero;
        }
    }

    function setTipoDeficiencia(){
        $sql = "SELECT * FROM `tbl_tipo_deficiencia` where status_deficiencia = 1";
        self::execute($sql);
        while($resultado = $this->stmt->fetch(PDO::FETCH_OBJ)) {
           echo "<option value='".$resultado->dsc_deficiencia."'>".$resultado->dsc_deficiencia."</option>";    
        }
        
    }
    
    function setNivelAtendimento(){
        $sql = "SELECT * FROM `tbl_nivel_atendimento` where status_nivel = 1  ";
        self::execute($sql);
        while($resultado = $this->stmt->fetch(PDO::FETCH_OBJ)) {
            echo "<option value='".$resultado->idl_nivel_atendimento."'>".$resultado->nome_nivel."</option>";    
        }
    }

    function setSexoAtendimento(){
        $sql = "SELECT * FROM `tbl_sexo_atendimento` where status_sexo = 1  ";
        self::execute($sql);
        while($resultado = $this->stmt->fetch(PDO::FETCH_OBJ)) {
            echo "<option value='".$resultado->id_sexo_atendimento."'>".$resultado->nome_sexo."</option>";    
        }
    }

    function setListaAddAssistidoEditar(){
        $sql = "SELECT * FROM `VIEW_DADOS_FILA` ORDER BY `VIEW_DADOS_FILA`.`idfila` ASC ";
        self::execute($sql);
        while($resultado = $this->stmt->fetch(PDO::FETCH_OBJ)) {
            @$esperando++;
            if ($resultado->nome_nivel=='normal') {
                $nivel = "NORMAL";
                $cor='';
                $font = "";
            }else{$nivel = "<button type='button' class='btn btn-success'>PRIORIDADE</button></td>";$cor="#5F9EA0"; $font = "#fff";}

            echo "
                 <tr style='color:".$font."; background-color:".$cor.";'>   
                    <th>".$esperando."</th> 
                    <td>".$resultado->cpf."</td> 
                    <td>".$resultado->nome."</td> 
                    <td>
                        <select class='form-control' name='obsnucleos' id='obsnucleos'>";

             echo "     </select>
                    </td> 
                    <td>
                        <select class='form-control' name='obsacoes' id='obsacoes'>";

             echo "     </select>
                    </td> 
                    <td>
                        <select class='form-control' name='atendente' id='atendente'>";
   
             echo "     </select>
                    </td>
                    <td>
                        <a href='model/controller/editar_dados.php?
                            idfila=".$resultado->idfila.
                            "&obsnucleos=".$resultado->idnucleo.
                            "&obsacoes=".$resultado->id_acao.
                            "&atendente=".$resultado->id_atendentes.
                            "&cpf=".$resultado->cpf."'>

                            <button type='button' class='btn btn-success'>Editar</button>
                        </a>


                    </td>
                 </tr>
            ";    
        }
    }

    function setNucleoAtendimento(){
        $sql = "SELECT * FROM `tbl_nucleo` where status_nucleo = 1 ORDER by dsc_nucleo";
        self::execute($sql);
        while($resultado = $this->stmt->fetch(PDO::FETCH_OBJ)) {
            echo "
            <option value='".$resultado->idnucleo."'";
                if(isset($_GET['nucleo'])){
                    if($resultado->dsc_nucleo == $_GET['nucleo']) { echo(" SELECTED ");}
                }else {echo "<option value='".$resultado->idnucleo."'>".$resultado->dsc_nucleo."</option>";}
            echo ">".$resultado->dsc_nucleo."
            </option>";
        }
    }

    function setNucleoRegime(){
        $sql = "SELECT * FROM `tbl_regime` where status = 1 ORDER by descricao";
        self::execute($sql);
        while($resultado = $this->stmt->fetch(PDO::FETCH_OBJ)) {
            echo "
            <option value='".$resultado->id."'";
                if(isset($_GET['dsc_regime'])){
                    if($resultado->descricao == $_GET['dsc_regime']) { echo(" SELECTED ");}
                }else {echo "<option value='".$resultado->id."'>".$resultado->descricao."</option>";}
            echo ">".$resultado->descricao."
            </option>";
        }
    }



    function setAcaoAtendimento(){
        $sql = "SELECT * FROM `tbl_regime` where status = 1 ORDER by descricao ";
        self::execute($sql);
        while($resultado = $this->stmt->fetch(PDO::FETCH_OBJ)) {
            echo "
            <option value='".$resultado->id."'";
                if(isset($_GET['dsc_regime'])){
                    if($resultado->descricao == $_GET['dsc_regime']) { echo(" SELECTED ");}
                }else {echo "<option value='".$resultado->id."'>".$resultado->descricao."</option>";}
            echo ">".$resultado->descricao."
            </option>";        
        }
    }

    function setAtendenteAtendimento(){
        $sql = "SELECT * FROM `tbl_atendentes` where status_atendentes = 1 ORDER BY dsc_atendentes ";
        self::execute($sql);
        while($resultado = $this->stmt->fetch(PDO::FETCH_OBJ)) {
            echo "
            <option value='".$resultado->id_atendentes."'";
                if(isset($_GET['dsc_atendentes'])){
                    if($resultado->dsc_atendentes == $_GET['dsc_atendentes']) { echo(" SELECTED ");}
                }else {echo "<option value='".$resultado->id_atendentes."'>".$resultado->dsc_atendentes."</option>";}
            echo ">".$resultado->dsc_atendentes."
            </option>";   
            
        }
    }

    function setAtendenteObsEdit(){ 
        if(isset($_GET['idfila'])&& isset($_GET['idfila'])&& $_GET['resp']=='Tarcisoedit'){ 
            $sql = "SELECT * FROM `tbl_fila` WHERE idfila =".$_GET['idfila']." LIMIT 1";        
        }else{
            $sql = "SELECT * FROM `tbl_fila` LIMIT 1";        
        }
        self::execute($sql);
        $resultado = $this->stmt->fetch(PDO::FETCH_OBJ);
        echo "<textarea type='text' class='form-control' name='observacao' id='observacao'>".@$resultado->observacao."</textarea>";
    }
        

    function setListaAddAssistido(){
        $sql = "SELECT * FROM `VIEW_DADOS_FILA` ORDER BY `VIEW_DADOS_FILA`.`nome`, `VIEW_DADOS_FILA`.`idfila` ASC ";
        
        self::execute($sql);
        while($resultado = $this->stmt->fetch(PDO::FETCH_OBJ)) {
            @$esperando++;
            if ($resultado->nome_nivel=='normal') {
                $nivel = "NORMAL";
                $cor='';
                $font = "";
            }else{$nivel = "<button type='button' class='btn btn-success'>PRIORIDADE</button></td>";$cor="#5F9EA0"; $font = "#fff";}
            echo "
                 <tr style='color:".$font."; background-color:".$cor.";'>   
                    <th>".$esperando."</th> 
                    <td>".$resultado->cpf."</td> 
                    <td>".$resultado->nome."</td> 
                    <td>".$resultado->inicio."</td> 
                    <td>".$resultado->obsnucleos."</td> 
                    <td>".$resultado->obsacoes."</td> 
                    <td><a href='model/controller/inserir_dados.php?btnDadosInsert=true&insertDadosLinks=novoAtendemento&user=".ID_USER."&guiche=".ID_GUICHE_USER."&fila=".$resultado->idfila."'><button type='button' class='btn btn-success'>Chamar</button></a>
                    </td>
                 </tr>
            ";    
        }
    }

    function setListaViewAssistido(){
        @$contador = 0;
        if($_SESSION["UsuarioFuncao"]=="Admin"){
            $sql = "SELECT * FROM `VIEW_DADOS_FILA` ORDER BY nome";
        }else{
            $sql = "SELECT * FROM `VIEW_DADOS_FILA` ORDER BY idfila";
        }

        self::execute($sql);
        while($resultado = $this->stmt->fetch(PDO::FETCH_OBJ)) { 
            @$contador ++;
            if ($resultado->nome_nivel=='normal') {
                $nivel = "NORMAL";
                $cor='';
                $font = "";
            }else{$nivel = "<button type='button' class='btn btn-success'>PRIORIDADE</button></td>";$cor="#5F9EA0"; $font = "#fff";}
//            &dsc_nucleo=".$resultado->fk_nucleo."
        echo"   <tr style='color:".$font."; color:".$cor.";'>   
                <th><input type='checkbox' id='cahamada_atendimento_dia' name='cahamada_atendimento_dia'></th> 
                <th>".$contador.":" .$resultado->idfila."</th> 
                <td>";
                if($_SESSION["UsuarioFuncao"]=="Admin"){
                    echo "<a href='?op=recepcao&idfila=".$resultado->idfila."&resp=Tarcisoedit&nome=".$resultado->nome."&nucleo=".$resultado->dsc_nucleo."&dsc_regime=".$resultado->descricao."&dsc_atendentes=".$resultado->dsc_atendentes."'>".$resultado->nome."</a>";
                }else{
                    echo $resultado->nome;
                }
        echo"   </td>
                    <td>".$resultado->nome_nivel."</td> 
                    <td>".$resultado->dsc_fisica."</td> 
                    <td>".$resultado->inicio."</td> 
                    <td>".$resultado->pavilao."</td> 
                    <td>".$resultado->dsc_nucleo."</td> 
                    <td>".$resultado->descricao."</td> 
                    <td>".$resultado->dsc_atendentes."</td> 
                    <td>".$resultado->observacao."</td> 
                </tr>
            ";  
        }
    }   

    function setListaViewRecepcao(){
        $sql = "SELECT * FROM `VIEW_DADOS_FILA`";
        self::execute($sql);
        while($resultado = $this->stmt->fetch(PDO::FETCH_OBJ)) {
            if ($resultado->nome_nivel=='normal') {
                $nivel = "NORMAL";
                $cor='';
                $font = "";
            }else{$nivel = "<button type='button' class='btn btn-success'>PRIORIDADE</button></td>";$cor="#5F9EA0"; $font = "#fff";}
            echo "
                 <tr style='color:".$font."; background-color:".$cor.";'>   
                    <td>".$nivel."</td> 
                    <td class='h3'>".strtoupper($resultado->nome)."</td> 
                    <td>".$resultado->inicio."</td> 
                    
                </tr>
             ";    
        }
    }

    function setListaViewRecepcaoAtendido(){
        $sql = "SELECT * FROM `VIEW_DADOS_ATENDIMENTO` 
                ORDER by `idatendimento` DESC  LIMIT 0, 4";
        self::execute($sql);
        while($resultado = $this->stmt->fetch(PDO::FETCH_OBJ)) {
            if ($resultado->nome_nivel=='normal') {
                $nivel = "NORMAL";
                $cor='';
                $font = "";
            }else{$nivel = "<button type='button' class='btn btn-success'>PRIORIDADE</button></td>";$cor="#5F9EA0"; $font = "#fff";}
            echo "
                 <tr style='color:".$font."; background-color:".$cor.";'>   
                    <td>".$nivel."</td> 
                    <td>".strtoupper($resultado->nome_assistido)."</td> 
                    <td>".$resultado->guiche_numero."</td> 
                    
                </tr>
            ";    
        }
    }     


/* 
* 
*
        Programando os botoes ATENDER e FINALIZAR 
*
*
*/

    function setListaAtendimento(){
        $sql = "SELECT * FROM `VIEW_DADOS_ATENDIMENTO` where finalizar_atendimento <> 1";
        self::execute($sql);
        while($resultado = $this->stmt->fetch(PDO::FETCH_OBJ)) {
            @$atendimento++;
            echo "
                 <tr>   
                    <th>".$atendimento."</th> 
                    <td>".$resultado->cpf_assistido."</td> 
                    <td>".$resultado->nome_assistido."</td>
                    <td>".$resultado->nome_nivel."</td> 
                    <td>".$resultado->inicio."</td>
                    <td>".$resultado->fim."</td>
                    <td>".$resultado->guiche_numero."</td>
                    <td>".$resultado->obsnucleos."</td>
                    <td>".$resultado->obsacoes."</td>

                  <td id='btn_Finalizar'>
                        <a href='model/controller/procedimentos.php?
                        finalizar=".base64_encode('finalizarAtendimento').
                        "&idfila=".base64_encode($resultado->idfila_assistido).
                        "&'>
                            <button type='button' class='btn btn-danger'>Finalizar</button>
                        </a>
                    </td>

                ";
        }
    }

// Relatório - Geral
    function setListaAtendimentoFinalizadosGeral(&$contador, &$valores, &$titulo, &$html){
        $sql = "SELECT * FROM `VIEW_RELATORIO_CARRETA` ORDER BY nome";
        self::execute($sql);
        $titulo = "GERAL";
        $nome   = '';
        while($resultado = $this->stmt->fetch(PDO::FETCH_OBJ)) {
            @$contador ++;
            @$valores = @$contador; 
            
            if($resultado->fk_atendente == 1){
                @$cor ="#c00";
            }else{
                @$cor ="#000";
            }

            $html .= "
                <tr style='color:".@$cor."; background:#ccc;'>   
                    <th>".$contador."</th> 
                    <td>".$resultado->nome."</td> 
                    <td>".$resultado->pavilhao."</td>
                    <td>".date('d/m/Y H:m:s', strtotime($resultado->inicio))."</td>
                    <td>".$resultado->dsc_nucleo."</td> 
                    <td>".$resultado->dsc_atendentes."</td>
                    <td>".$resultado->nome_nivel."</td> 
                    <td>".$resultado->nome_sexo."</td>
                    <td>".$resultado->descricao."</td> 
                    <td>".$resultado->observacao."</td>
                    <td>".'1'."</td>
                </tr>
             ";  
        }
    }   
// Relatório - Geral PREVIO
    function setListaAtendimentoFinalizadosGeralPrevio(&$contador, &$valores, &$titulo, &$html){
        $sql = "SELECT * FROM `VIEW_RELATORIO_PREVIO` ORDER BY nome";
        self::execute($sql);
        $titulo = "GERAL";
        $nome   = '';
        while($resultado = $this->stmt->fetch(PDO::FETCH_OBJ)) {
            @$contador ++;
            @$valores = @$contador; 
            $html .= "
                <tr style='color: #000; background:#ccc;'>   
                    <th>".$contador."</th> 
                    <td>".$resultado->nome."</td> 
                    <td>".$resultado->pavilhao."</td>
                    <td>".date('d/m/Y H:m:s', strtotime($resultado->inicio))."</td>
                    <td>".$resultado->dsc_nucleo."</td> 
                    <td>".$resultado->dsc_atendentes."</td>
                    <td>".$resultado->nome_nivel."</td> 
                    <td>".$resultado->nome_sexo."</td>
                    <td>".$resultado->descricao."</td> 
                    <td>".$resultado->observacao."</td>
                    <td>".'1'."</td>
                </tr>
             ";  
        }
    }   

    
// Gráficos

// Atendentes individual

    function setAtendenteGrafico(&$i, &$cor, &$nomes, &$regimes, &$nucleos, $idfiltro, &$membro){
        $sql = "SELECT * FROM VIEW_RELATORIO_CARRETA WHERE chamado_para_atendimento = 1 AND fk_atendente=".$idfiltro." ORDER by nome";
        self::execute($sql);
        $cor[0]     = '#ff3300';
        $cor[1]     = '#ff0000';
        $cor[2]     = '#ff33ff';
        $cor[3]     = '#0000ff';
        $cor[4]     = '#006600';
        $cor[5]     = '#660000';
        $cor[6]     = '#000066';
        $cor[7]     = '#ff3355';
        while($resultado = $this->stmt->fetch(PDO::FETCH_OBJ)) {
            $nomes[$i]      = $resultado->nome;
            $regimes[$i]    = $resultado->descricao;
            $nucleos[$i]    = $resultado->dsc_nucleo;
            $membro         = $resultado->dsc_atendentes;
            $i++;
        }        
    }

// Regime

    function setRegimeGrafico(&$indiceacao, &$valoracao, &$acao){
        $sql = "SELECT a.descricao, COUNT(*) as total FROM VIEW_RELATORIO_CARRETA f inner join tbl_regime a On f.fk_regime = a.id GROUP by a.descricao ORDER by a.descricao";
        self::execute($sql);
        while($resultado = $this->stmt->fetch(PDO::FETCH_OBJ)) {
            $valoracao[$indiceacao] = $resultado->total;
            $acao[$indiceacao]      = $resultado->descricao;
            $indiceacao++;
        }        

    }  

    function setRegimeGraficoPrevio(&$indiceacao, &$valoracao, &$acao){
        $sql = "SELECT a.descricao, COUNT(*) as total FROM VIEW_RELATORIO_PREVIO f inner join tbl_regime a On f.fk_regime = a.id GROUP by a.descricao ORDER by a.descricao";
        self::execute($sql);
        while($resultado = $this->stmt->fetch(PDO::FETCH_OBJ)) {
            $valoracao[$indiceacao] = $resultado->total;
            $acao[$indiceacao]      = $resultado->descricao;
            $indiceacao++;
        }        

    }      

// Núcleos


    function setNucleoGrafico(&$indicenucleo, &$valornucleo, &$nucleo){
        $sql = "SELECT n.dsc_nucleo, COUNT(*) as total FROM VIEW_RELATORIO_CARRETA f inner join tbl_nucleo n On f.fk_nucleo = n.idnucleo GROUP by n.dsc_nucleo";
        self::execute($sql);
        while($resultado = $this->stmt->fetch(PDO::FETCH_OBJ)) {
            $valornucleo[$indicenucleo] = $resultado->total;
            $nucleo[$indicenucleo]      = $resultado->dsc_nucleo;
            $indicenucleo++;
        }        

    }  

    function setNucleoGraficoPrevio(&$indicenucleo, &$valornucleo, &$nucleo){
        $sql = "SELECT n.dsc_nucleo, COUNT(*) as total FROM VIEW_RELATORIO_PREVIO f inner join tbl_nucleo n On f.fk_nucleo = n.idnucleo GROUP by n.dsc_nucleo";
        self::execute($sql);
        while($resultado = $this->stmt->fetch(PDO::FETCH_OBJ)) {
            $valornucleo[$indicenucleo] = $resultado->total;
            $nucleo[$indicenucleo]      = $resultado->dsc_nucleo;
            $indicenucleo++;
        }        

    }  



// Atendimentos por membros

    function setDefGrafico(&$indicedef, &$valordef, &$def){
        $sql = "SELECT a.dsc_atendentes, COUNT(*) as total FROM VIEW_RELATORIO_CARRETA f inner join tbl_atendentes a On f.fk_atendente = a.id_atendentes GROUP by a.dsc_atendentes";
        self::execute($sql);
        while($resultado = $this->stmt->fetch(PDO::FETCH_OBJ)) {
            $valordef[$indicedef] = $resultado->total;
            $def[$indicedef]      = $resultado->dsc_atendentes;
            $indicedef++;
        }        

    }  

    function setDefGraficoPrevio(&$indicedef, &$valordef, &$def){
        $sql = "SELECT a.dsc_atendentes, COUNT(*) as total FROM VIEW_RELATORIO_PREVIO f inner join tbl_atendentes a On f.fk_atendente = a.id_atendentes GROUP by a.dsc_atendentes";
        self::execute($sql);
        while($resultado = $this->stmt->fetch(PDO::FETCH_OBJ)) {
            $valordef[$indicedef] = $resultado->total;
            $def[$indicedef]      = $resultado->dsc_atendentes;
            $indicedef++;
        }        

    }  



// Atendimentos por Tipo

    function setTipoGrafico(&$indicetipo, &$valortipo, &$tipo){
        $sql = "SELECT a.nome_nivel, COUNT(*) as total FROM VIEW_RELATORIO_CARRETA f inner join tbl_nivel_atendimento a On f.fk_nivel_atendimento = a.idl_nivel_atendimento GROUP by a.nome_nivel";
        self::execute($sql);
        while($resultado = $this->stmt->fetch(PDO::FETCH_OBJ)) {
            $valortipo[$indicetipo] = $resultado->total;
            $tipo[$indicetipo]      = $resultado->nome_nivel;
            $indicetipo++;
        }        
        
    }  

    function setTipoGraficoPrevio(&$indicetipo, &$valortipo, &$tipo){
        $sql = "SELECT a.nome_nivel, COUNT(*) as total FROM VIEW_RELATORIO_PREVIO f inner join tbl_nivel_atendimento a On f.fk_nivel_atendimento = a.idl_nivel_atendimento GROUP by a.nome_nivel";
        self::execute($sql);
        while($resultado = $this->stmt->fetch(PDO::FETCH_OBJ)) {
            $valortipo[$indicetipo] = $resultado->total;
            $tipo[$indicetipo]      = $resultado->nome_nivel;
            $indicetipo++;
        }        
        
    }  

    // Sexo

    function setSexoGrafico(&$indicesexo, &$valorsexo, &$sexo){
        $sql = "SELECT a.nome_sexo, COUNT(*) as total FROM VIEW_RELATORIO_CARRETA a GROUP by a.nome_sexo ";
        self::execute($sql);
        while($resultado = $this->stmt->fetch(PDO::FETCH_OBJ)) {
            $valorsexo[$indicesexo] = $resultado->total;
            $sexo[$indicesexo]      = $resultado->nome_sexo;
            $indicesexo++;
        }        
        
    }  

    function setSexoGraficoPrevio(&$indicesexo, &$valorsexo, &$sexo){
        $sql = "SELECT a.nome_sexo, COUNT(*) as total FROM VIEW_RELATORIO_PREVIO a GROUP by a.nome_sexo ";
        self::execute($sql);
        while($resultado = $this->stmt->fetch(PDO::FETCH_OBJ)) {
            $valorsexo[$indicesexo] = $resultado->total;
            $sexo[$indicesexo]      = $resultado->nome_sexo;
            $indicesexo++;
        }        
        
    }  

    // Assistdi por Membro
    
    function setAmGrafico(){
        $sql = "SELECT a.dsc_atendentes, COUNT(*) as total  FROM VIEW_RELATORIO_CARRETA f inner join tbl_atendentes a On f.fk_atendente = a.id_atendentes  
        GROUP by a.dsc_atendentes ORDER BY a.dsc_atendentes";
        self::execute($sql);
        while($resultado = $this->stmt->fetch(PDO::FETCH_OBJ)) {
            @$total = $total + $resultado->total; 
            @$linhas++;
            echo "
                <tr>
                    <td scope='row'>".$linhas."</td>
                    <td>".$resultado->dsc_atendentes."</td>
                    <td>".$resultado->total."</td>
                </tr>";
            }
            @$html .= "<tr><td colspan='2'>Total</td><td>".@$total."</td></tr>";
            echo $html;
    }  
    function setAmGraficoPrevio(){
        $sql = "SELECT a.dsc_atendentes, COUNT(*) as total  FROM VIEW_RELATORIO_PREVIO f inner join tbl_atendentes a On f.fk_atendente = a.id_atendentes  
        GROUP by a.dsc_atendentes";
        self::execute($sql);
        while($resultado = $this->stmt->fetch(PDO::FETCH_OBJ)) {
            @$total = $total + $resultado->total; 
            @$linhas++;
            echo "
                <tr>
                    <td scope='row'>".$linhas."</td>
                    <td>".$resultado->dsc_atendentes."</td>
                    <td>".$resultado->total."</td>
                </tr>";
            }
            @$html .= "<tr><td colspan='2'>Total</td><td>".@$total."</td></tr>";
            echo $html;
    }  
    function setListaViewBuscar($busca){
        @$contador = 0;
        $busca_nome = '%'.$busca.'%';
        $sql = "SELECT * FROM `VIEW_DADOS_BUSCA` WHERE nome LIKE '".$busca_nome."' ORDER BY nome";
        self::execute($sql);
        while($resultado = $this->stmt->fetch(PDO::FETCH_OBJ)) { 
            @$contador ++;
            if ($resultado->nome_nivel=='normal') {
                $nivel = "NORMAL";
                $cor='';
                $font = "";
            }else{$nivel = "<button type='button' class='btn btn-success'>PRIORIDADE</button></td>";$cor="#5F9EA0"; $font = "#fff";}

                echo"<tr style='color:".$font."; color:".$cor.";'>   
                        <th><input type='checkbox' id='cahamada_atendimento_dia' name='cahamada_atendimento_dia'></th> 
                        <th>".$contador.":" .$resultado->idfila."</th> 
                        <td>";
                            if($_SESSION["UsuarioFuncao"]=="Admin"){
                                echo "<a href='?op=recepcao&idfila=".$resultado->idfila."&resp=Tarcisoedit&nome=".$resultado->nome."&nucleo=".$resultado->dsc_nucleo."&dsc_regime=".$resultado->descricao."&dsc_atendentes=".$resultado->dsc_atendentes."'>".$resultado->nome."</a>";
                            }else{
                                echo $resultado->nome;
                            }
                echo"   </td>
                        <td>".$resultado->nome_nivel."</td> 
                        <td>".$resultado->dsc_fisica."</td> 
                        <td>".$resultado->inicio."</td> 
                        <td>".$resultado->pavilhao."</td> 
                        <td>".$resultado->dsc_nucleo."</td> 
                        <td>".$resultado->descricao."</td> 
                        <td>".$resultado->dsc_atendentes."</td> 
                        <td>".$resultado->observacao."</td> 
                    </tr>
                    ";  
        }    
    }


}  
?>

