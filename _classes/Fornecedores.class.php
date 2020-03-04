<?php
	class Fornecedores extends DB{
	
		static function selectFornecedores($idEmpresa){
			
			$selFornecedores=self::getConn()->prepare("SELECT * FROM fornecedores WHERE id_empresa=?");
			$selFornecedores->execute(array($idEmpresa));
			$s['num'] = $selFornecedores->rowCount();
			$s['dados'] = $selFornecedores->fetchAll();
			return $s;
		}
	
	}