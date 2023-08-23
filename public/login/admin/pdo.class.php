<?php
	class Database{
	    protected static $db;
	    private function __construct(){
	        # Informações sobre o banco de dados:
        	include_once('../../../model/pdo_all.php');    
	        $db_driver = "mysql";

	        # Informações sobre o sistema:
	        $sistema_titulo = "Logar";
	        $sistema_email = "bentessantostarciso@gmail.com";
	        try{
	            self::$db = new PDO("$db_driver:host=$db_host; dbname=$db_nome", $db_usuario, $db_senha);
	            self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	            self::$db->exec('SET NAMES utf8');
	        }catch (PDOException $e){
	            mail($sistema_email, "PDOException em $sistema_titulo", $e->getMessage());
	            die("Connection Error: " . $e->getMessage());
	        }
	    }
	    public static function conexao(){
	        if (!self::$db){
	            new Database();
	        }
	        return self::$db;
	    }

        function ConsultaSelect($query)
        {
            $pdo = Database::conexao();
            $funcao = $pdo->prepare($query);
            $funcao->execute();
            $r_funcao = $funcao->fetchAll(PDO::FETCH_OBJ);

            return $r_funcao;
        }

        function MostraGeral($geral)
        {
            echo "Geral";
        }
}
