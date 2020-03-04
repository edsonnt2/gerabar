<?php
	class Marcas extends DB{
	
		static function selectMarcas($idEmpresa){
			
			$selMarcas=self::getConn()->prepare("SELECT * FROM marcas WHERE id_empresa=?");
			$selMarcas->execute(array($idEmpresa));
			$s['num'] = $selMarcas->rowCount();
			$s['dados'] = $selMarcas->fetchAll();
			return $s;
		}
	
	}