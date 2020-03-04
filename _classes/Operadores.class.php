<?php
	class Operadores extends DB{
	
		static function insertOperador($idEmpresa,$nomeOpe,$codigoOpe,$senhaOpe,$admin=0){
			$insertOpe=self::getConn()->prepare("INSERT INTO operadores SET id_empresa=?, nome_operador=?, codigo=?, senha=?, admin=?, cadastro=NOW(), ultimo_acesso=NOW()");
			if($insertOpe->execute(array($idEmpresa,$nomeOpe,$codigoOpe,$senhaOpe,$admin))){
				return true;
			}else{
				return false;
			}
		}
		
		static function ultIdOpe($idEmpresa){		
			$selUlt=self::getConn()->prepare("SELECT `id` FROM operadores WHERE id_empresa=? ORDER BY `id` DESC LIMIT 1");		
			$selUlt->execute(array($idEmpresa));
			$d['num'] = $selUlt->rowCount();
			$d['dados'] = $selUlt->fetch(PDO::FETCH_NUM);
			return $d;
		}
		
		static function delOperador($idDel,$idEmpresa){
			$delOperador=self::getConn()->prepare("DELETE FROM operadores WHERE id=? AND id_empresa=?");
			if($delOperador->execute(array($idDel,$idEmpresa))){
			return true;
			}else{
			return false;
			}
		}
		static function selOperador($idEmpresa){
			$selOpe=self::getConn()->prepare("SELECT * FROM operadores WHERE id_empresa=?");
			$selOpe->execute(array($idEmpresa));
			$s['num']=$selOpe->rowCount();
			$s['dados']=$selOpe->fetchAll();
			return $s;			
		}
		
		static function selUmOperador($idEmpresa,$codigo){
			$selOpe=self::getConn()->prepare("SELECT * FROM operadores WHERE id_empresa=? AND codigo=? LIMIT 1");
			$selOpe->execute(array($idEmpresa,$codigo));
			$s['num']=$selOpe->rowCount();
			$s['dados']=$selOpe->fetch(PDO::FETCH_ASSOC);
			return $s;			
		}
		
	}