<?php
	class Recuperar extends DB{
		
		static function statusVerifica($email,$chave){
			$salDados=self::getConn()->prepare("SELECT verifica_email FROM usuarios WHERE email=? AND chave_verifica=?");
			$salDados->execute(array($email,$chave));
			$d['num']=$salDados->rowCount();
			$d['dados']=$salDados->fetch(PDO::FETCH_NUM);
			return $d;
		}
		
		static function salvaVerifica($email,$chave){
			$upChave=self::getConn()->prepare("UPDATE usuarios SET verifica_email=? WHERE email=? AND chave_verifica=?");
			return ($upChave->execute(array(1,$email,$chave)))?true:false;
		}
	
		static function dadosEmail($recemail){			
			$verificar=self::getConn()->prepare("SELECT nome,sobrenome FROM usuarios WHERE email=? LIMIT 1");
			$verificar->execute(array($recemail));
			$r['num']=$verificar->rowCount();
			$r['dados']=$verificar->fetch(PDO::FETCH_ASSOC);	
			return $r;
		}
		
		static function dadosRecupera($email,$chave=false){		
			if($chave==false){
			$cont="";
			$arr=array($email);
			}else{
			$cont=" AND chave=?";
			$arr=array($email,$chave);			
			}
			$selDados=self::getConn()->prepare("SELECT * FROM recuperar_senha WHERE email=?".$cont." LIMIT 1");
			$selDados->execute($arr);
			$d['num']=$selDados->rowCount();
			$d['dados']=$selDados->fetch(PDO::FETCH_ASSOC);
			return $d;
		}
		
		static function salvarChave($email,$chave){
			$salDados=self::getConn()->prepare("INSERT INTO recuperar_senha SET email=?,chave=?");
			return ($salDados->execute(array($email,$chave)))?true:false;
		}
		
		static function updateChave($email,$chave){
			$upDados=self::getConn()->prepare("UPDATE recuperar_senha SET chave=? WHERE email=?");
			return ($upDados->execute(array($chave,$email)))?true:false;
		}
		
		static function altSenhas($email,$senha,$chave){
			$senha=sha1($senha);			
			$confirma=self::getConn()->prepare("SELECT `id` FROM recuperar_senha WHERE email=? AND chave=?");
			$confirma->execute(array($email,$chave));
			if($confirma->rowCount()>0){				
				$delChave = self::getConn()->prepare("DELETE FROM recuperar_senha WHERE email=? AND chave=?");
				$delChave->execute(array($email,$chave));				
				$alt=self::getConn()->prepare("UPDATE usuarios SET senha=? WHERE email=?");
				return ($alt->execute(array($senha,$email)))?true:false;
			}else{
			return false;
			}
		}
	}
	
	
	
	
	
	