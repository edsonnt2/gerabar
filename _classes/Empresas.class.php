<?php
	class Empresas extends DB{
        
        static function selectPlano($idUsuario){            
            $verAss=self::getConn()->prepare("SELECT * FROM assinaturas WHERE id_usuario=? LIMIT 1");
            $verAss->execute(array($idUsuario));
            $n['num']=$verAss->rowCount();
            $n['dados']=$verAss->fetch(PDO::FETCH_ASSOC);
            return $n;
        }
        
        static function upEmpresaPlano($idUsuario,$idEmpresa){
            $upId=self::getConn()->prepare("UPDATE assinaturas SET id_empresa=? WHERE id_usuario=?");
            return ($upId->execute(array($idEmpresa,$idUsuario)))?true:false;
        }

		static function insertEmpresa($idDono,$razao,$cep,$endereco,$numero,$comple,$bairro,$cidade,$estado,$tel,$cnpjCpf){
			$cadEmpresa=self::getConn()->prepare("INSERT INTO empresas SET id_dono=?, razao_social=?, nome_fantasia='', cep=?, endereco=?, numero=?, complemento=?, bairro=?, cidade=?, estado=?, telefone=?, loja='', cpf_ou_cnpj=?, cadastro=NOW()");
			return($cadEmpresa->execute(array($idDono,$razao,$cep,$endereco,$numero,$comple,$bairro,$cidade,$estado,$tel,$cnpjCpf)))?true:false;
		}

		static function updateEmpresa($idEmpresa,$idDono,$razao,$cep,$endereco,$numero,$comple,$bairro,$cidade,$estado,$tel,$cnpjCpf){
			$cadEmpresa=self::getConn()->prepare("UPDATE empresas SET razao_social=?, cep=?, endereco=?, numero=?, complemento=?, bairro=?, cidade=?, estado=?, telefone=?, cpf_ou_cnpj=? WHERE id=? AND id_dono=?");
			return ($cadEmpresa->execute(array($razao,$cep,$endereco,$numero,$comple,$bairro,$cidade,$estado,$tel,$cnpjCpf,$idEmpresa,$idDono)))?true:false;
		}

		static function updateAmbEmpresa($idEmpresa,$selAmb,$sangria=false){
            $qualAlt=($sangria==false)?'ambiente_trabalho':'sangria';
			$upAmb=self::getConn()->prepare("UPDATE empresas SET ".$qualAlt."=? WHERE id=?");
			return ($upAmb->execute(array($selAmb,$idEmpresa)))?true:false;
		}

		static function insertImgEmpresa($idEmpresa,$img1,$img2){
			$insertImg=self::getConn()->prepare("INSERT INTO img_empresa SET id_empresa=?, nome_img_1=?, nome_img_2=?");
			return ($insertImg->execute(array($idEmpresa,$img1,$img2)))?true:false;
		}

		static function updateImgEmpresa($idEmpresa,$img1,$img2){
			$upAmb=self::getConn()->prepare("UPDATE img_empresa SET nome_img_1=?, nome_img_2=? WHERE id_empresa=?");
			return ($upAmb->execute(array($img1,$img2,$idEmpresa)))?true:false;
		}

		static function selectImgEmpresa($idEmpresa){
			$selectImg=self::getConn()->prepare("SELECT * FROM img_empresa WHERE id_empresa=? ORDER BY `id` DESC LIMIT 1");
			$selectImg->execute(array($idEmpresa));
			$d['num'] = $selectImg->rowCount();
			$d['dados'] = $selectImg->fetch(PDO::FETCH_ASSOC);
			return $d;
		}
		
		static function selectEmpresa($idDono,$idEmpresa=false){
			if($idEmpresa!=false){
				$compTab="id";
				$varTab=$idEmpresa;
			}else{
				$compTab="id_dono";
				$varTab=$idDono;
			}
			$selectEmpresa=self::getConn()->prepare("SELECT * FROM empresas WHERE ".$compTab."=? ORDER BY `id` DESC LIMIT 1");
			$selectEmpresa->execute(array($varTab));
			$d['num'] = $selectEmpresa->rowCount();
			$d['dados'] = $selectEmpresa->fetch(PDO::FETCH_NUM);
			return $d;
		}
		
		static function statusEmpresa($idDono,$status){
			$selectEmpresa=self::getConn()->prepare("SELECT `id` FROM empresas WHERE id_dono=? AND codStatus=?");
			$selectEmpresa->execute(array($idDono,$status));
			return $selectEmpresa->rowCount();			
		}
		
		static function insertAmb($idEmpresa,$acesso,$ambiente,$senha){
			$senha=sha1($senha);
			$insertAmb=self::getConn()->prepare("INSERT INTO ambientes SET id_empresa=?, acesso_amb=?, nome_amb=?, senha_amb=?, pgs_amb='', cadastro=NOW()");
			return ($insertAmb->execute(array($idEmpresa,$acesso,$ambiente,$senha)))?true:false;
		}
		
		static function uptadeAmb($idEmpresa,$acesso,$ambiente,$senha){
			$senha=sha1($senha);
			$uptadeAmb=self::getConn()->prepare("UPDATE ambientes SET acesso_amb=?, nome_amb=?, senha_amb=? WHERE id_empresa=?");
			return ($uptadeAmb->execute(array($acesso,$ambiente,$senha,$idEmpresa)))?true:false;
		}
		
		static function uptadeAmbPg($idEmpresa,$idAmb,$pgsAmb,$identifica){
			$upAmbPg=self::getConn()->prepare("UPDATE ambientes SET pgs_amb=?, identificar=? WHERE id=? AND id_empresa=?");
			return ($upAmbPg->execute(array($pgsAmb,$identifica,$idAmb,$idEmpresa)))?true:false;
		}
		
		static function ultIdAmb($idEmpresa){
			$selUlt=self::getConn()->prepare("SELECT `id` FROM ambientes WHERE id_empresa=? ORDER BY `id` DESC LIMIT 1");
			$selUlt->execute(array($idEmpresa));
			$d['num'] = $selUlt->rowCount();
			$d['dados'] = $selUlt->fetch(PDO::FETCH_NUM);
			return $d;
		}
		
		static function selectAmb($idEmpresa){
			$selectAmb=self::getConn()->prepare("SELECT * FROM ambientes WHERE id_empresa=? ORDER BY `id`");
			$selectAmb->execute(array($idEmpresa));
			$s['num']=$selectAmb->rowCount();
			$s['dados']=$selectAmb->fetchAll();
			return $s;
		}
		
		static function deleteAmb($idEmpresa,$idDel){
			$delAmb=self::getConn()->prepare("DELETE FROM ambientes WHERE id=? AND id_empresa=?");
			return ($delAmb->execute(array($idDel,$idEmpresa)))?true:false;
		}
		
	}