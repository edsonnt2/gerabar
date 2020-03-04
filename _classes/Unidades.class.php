<?php
	class Unidades extends DB{
	
		static function countUnidades($idEmpresa){			
			$countUnidades=self::getConn()->prepare("SELECT `id` FROM unidade_venda WHERE id_empresa=?");
			$countUnidades->execute(array($idEmpresa));
			return $countUnidades->rowCount();
		}
	
	}