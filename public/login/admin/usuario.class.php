<?php
	require_once 'pdo.class.php';

	class Usuario{	
		var $habilitado, $senha, $cpf;

		function logar($cpf, $senha, $habilitado){
			$this->habilitado   = $habilitado;
			$this->cpf      	= $cpf;
			$this->senha    	= md5(hash('sha512', $senha));

			$conn = Database::conexao();
			$busca = $conn->prepare("SELECT * FROM tbl_user u, tbl_funcao f
                                        WHERE  u.senha_user = :SENHA 
                                        AND u.cpf_user = :CPF
                                        AND u.habilitado = :HABILITA
                                        AND f.id_funcao = u.fk_funcao
                                     ");

			$busca->bindValue(":SENHA", $this->senha, PDO::PARAM_STR);
			$busca->bindValue(":CPF", $this->cpf, PDO::PARAM_STR);
			$busca->bindValue(":HABILITA", $this->habilitado, PDO::PARAM_STR);
			$busca->execute();
			$resulta_busca = $busca->fetchAll(PDO::FETCH_OBJ);
			return $resulta_busca;
		}

    }

?>