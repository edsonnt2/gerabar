<?php
	class Categorias extends DB{
	
		static function selectCategorias($idEmpresa){
			
			$selCategorias=self::getConn()->prepare("SELECT * FROM categorias WHERE id_empresa=?");
			$selCategorias->execute(array($idEmpresa));
			$s['num'] = $selCategorias->rowCount();
			$s['dados'] = $selCategorias->fetchAll();
			return $s;
		}
	
	}