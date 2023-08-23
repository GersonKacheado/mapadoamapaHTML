<?php
    if(!isset($_SESSION["UsuarioCpf"])) {
        echo "<script>location.href='public/login/index.php'</script>";
    }
    else{
        /* Acesso ao SGBD do saude_ap */

        class Database
        {
            protected static $db;
             function __construct()
            {

               include_once('pdo_all.php');    

            }

            public static function conexao()
            {
                if (!self::$db) {
                    new Database();
                }
                return self::$db;
            }
            protected function execute($sql)
            {
             $this->stmt = self::$db->prepare($sql);
             return $this->stmt->execute();
            }

        }

        /* configura��o de Data do Sistema */

        function data_portugues($data_noticia)
        {
            setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
            date_default_timezone_set('America/Sao_Paulo');
            @$var_DateTime = $data_noticia;
            return @utf8_encode(strftime("%A", time($var_DateTime)) . ' ' .
                strftime("%d de ", time($var_DateTime)) .
                strftime("%B", time($var_DateTime)) . ' ' .
                strftime("de %Y. ", time($var_DateTime)));
        }

        /**
         * isCpfValid
         *
         * Esta função testa se um cpf é valido ou nãoo.
         *
         * @param string $cpf Guarda o cpf como ele foi digitado pelo cliente
         * @param array $num Guarda apenas os números do cpf
         * @param boolean $isCpfValid Guarda o retorno da função
         * @param int $multiplica Auxilia no Calculo dos Dígitos verificadores
         * @param int $soma Auxilia no Calculo dos Dígitos verificadores
         * @param int $resto Auxilia no Calculo dos Dí­gitos verificadores
         * @param int $dg DÃ­gito verificador
         * @return  boolean                     "true" se o cpf é válido ou "false" caso o
         *                                               contrário....
         *
         * @author  Raoni Botelho Sporteman <raonibs@gmail.com>
         * @version 1.0 Debugada em 26/09/2011 no PHP 5.3.8
         */

        function isCpfValid($cpf)
        {

            //Etapa 1: Cria um array com apenas os digitos numéricos, isso permite receber o cpf em diferentes formatos como "000.000.000-00", "00000000000", "000 000 000 00" etc...
            $j = 0;
            for ($i = 0; $i < (strlen($cpf)); $i++) {
                if (is_numeric($cpf[$i])) {
                    $num[$j] = $cpf[$i];
                    $j++;
                }
            }

            if(!is_numeric($cpf)) {   // Verificando se é uma entrada de Numeros 28/05/2019 * Santos P. Tarciso *
                $isCpfValid = false;
            } //Etapa 2: Conta os dígitos, um cpf válido possui 11 dígitos numéricos.
            else if (count($num) != 11) {
                $isCpfValid = false;
            } //Etapa 3: Combinações como 00000000000 e 22222222222 embora nãoo sejam cpfs reais resultariam em cpfs válidos após o calculo dos dí­gitos verificares e por isso precisam ser filtradas nesta parte.
            else {
                for ($i = 0; $i < 10; $i++) {
                    if ($num[0] == $i && $num[1] == $i && $num[2] == $i && $num[3] == $i && $num[4] == $i && $num[5] == $i && $num[6] == $i && $num[7] == $i && $num[8] == $i) {
                        $isCpfValid = false;
                        break;
                    }
                }
            }
            //Etapa 4: Calcula e compara o primeiro dÃ­gito verificador.
            if (!isset($isCpfValid)) {
                $j = 10;
                for ($i = 0; $i < 9; $i++) {
                    $multiplica[$i] = $num[$i] * $j;
                    $j--;
                }
                $soma = array_sum($multiplica);
                $resto = $soma % 11;
                if ($resto < 2) {
                    $dg = 0;
                } else {
                    $dg = 11 - $resto;
                }
                if ($dg != $num[9]) {
                    $isCpfValid = false;
                }
            }
            //Etapa 5: Calcula e compara o segundo dígito verificador.
            if (!isset($isCpfValid)) {
                $j = 11;
                for ($i = 0; $i < 10; $i++) {
                    $multiplica[$i] = $num[$i] * $j;
                    $j--;
                }
                $soma = array_sum($multiplica);
                $resto = $soma % 11;
                if ($resto < 2) {
                    $dg = 0;
                } else {
                    $dg = 11 - $resto;
                }
                if ($dg != $num[10]) {
                    $isCpfValid = false;
                } else {
                    $isCpfValid = true;
                }
            }
            //Etapa 6: Retorna o Resultado em um valor booleano.
            return $isCpfValid;
        }



        function Menu($habilita)
        {
            $pdo = Database::conexao();
            $menu = $pdo->prepare("SELECT * FROM menu WHERE habilita = :HABILITA ORDER BY ordem");
            $menu->bindParam(":HABILITA", $habilita, PDO::PARAM_STR);
            $menu->execute();
            $r_menu = $menu->fetchAll(PDO::FETCH_OBJ);

            return $r_menu;
        }
/*
        function LoginCPF($login, $senha, $habilitado)
        {
            $pdo = Database::conexao();
            $i = $pdo->prepare("SELECT * FROM tbl_user u, tbl_funcao f 
                                WHERE u.login_user = :LOGIN 
                                AND u.senha = :SENHA
                                AND f.id_funcao = u.fk_funcao
                                AND u.habilitado = :HABILITA");
            $i->bindParam(":LOGIN", $login, PDO::PARAM_INT);
            $i->bindParam(":SENHA", $senha, PDO::PARAM_STR);
            $i->bindParam(":HABILITA", $habilitado, PDO::PARAM_STR);
            $i->execute();
            $achou = $i->rowCount();
            $r_i = $i->fetchAll(PDO::FETCH_OBJ);
            $retorno = [$achou, $r_i];
            return $retorno;
        }
*/        
}

    function SemImgDados(){
        echo "<img src='public/login/img/login/visitante.png' class='user-image' alt='User Image'>";
    }

/* semdados no banco */

    function SemDados(){
        echo "<img  src='img/conteudo/logo_sem_noticia.png' alt='Sem Dados..'>";
    }
    
?>

