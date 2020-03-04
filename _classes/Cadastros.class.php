<?php
	class Cadastros extends DB{
        
        static function plano_cadastro_ativo($plano,$idEmpresa,$tabela,$qtd,$idCliente=false){
            if($plano==0){            
                
                if($tabela=="conta_clientes"){
                    $oqueTras="id_conta,id_cliente";
                    $byGroup=" AND status=0 GROUP BY id_cliente,id_conta";
                }else{
                    $oqueTras="id";
                    $byGroup="";
                }
                
                $verQtd=self::getConn()->prepare("SELECT ".$oqueTras." FROM ".$tabela." WHERE id_empresa=?".$byGroup);
                $verQtd->execute(array($idEmpresa));
                if($verQtd->rowCount()<$qtd){
                    return true;
                }else{
                    if($tabela=="conta_clientes"){
                        $passaFalse=true;
                        foreach($verQtd->fetchAll() as $trasCliente){                        
                            if($idCliente==$trasCliente['id_cliente']){
                                return true;
                                $passaFalse=false;
                                exit();
                            }
                        }
                        
                        if($passaFalse==true){ return false; }
                        
                    }else{
                        return false;
                    }
                }
            }else{
                return true;
            }            
        }
        
        static function selDadosUsuario($idDaSessao){
			$selDados=self::getConn()->prepare("SELECT * FROM usuarios WHERE `id`=? LIMIT 1");
			$selDados->execute(array($idDaSessao));
			$n['num']=$selDados->rowCount();
			$n['dados']=$selDados->fetch(PDO::FETCH_ASSOC);
			return $n;
		}
        
        static function salEndereco($cep,$endereco,$numero,$complemento,$bairro,$cidade,$estado,$plano,$dadosSalvar,$idDaSessao,$idEmpresa,$metodo,$cpfSalvar,$telSalvar){
            
            if(isset($dadosSalvar['codCartao'])){
                $assinatura=$dadosSalvar['codCartao'];
                $link="";
                $cod_barra="";
                $data_boleto="";
            }else{
                $assinatura=$dadosSalvar['codBoleto'];
                $link=$dadosSalvar['linkBoleto'];
                $cod_barra=$dadosSalvar['codBarraBoleto'];
                $data_boleto=$dadosSalvar['dataVencimento'];
            }
            
            $setEnd=self::getConn()->prepare("UPDATE usuarios SET cep=?, endereco=?, numero=?, complemento=?, bairro=?, cidade=?, estado=?, plano=?, cod_assinatura=? WHERE `id`=?");
            
            if($setEnd->execute(array($cep,$endereco,$numero,$complemento,$bairro,$cidade,$estado,$plano,$assinatura,$idDaSessao))){
                
                $verAss=self::getConn()->prepare("SELECT `id` FROM assinaturas WHERE id_usuario=? AND id_empresa=?");
                $verAss->execute(array($idDaSessao,$idEmpresa));
                if($verAss->rowCount()==0){
                    
                $setAss=self::getConn()->prepare("INSERT INTO assinaturas SET id_usuario=?, id_empresa=?, metodo_pagamento=?, chave_pagamento=?, plano=?, cpf=?, telefone=?, link_pagamento=?, codigo_barra=?, status_assinatura=?, data_vencimento=?, data_status=NOW(), data_assinatura=NOW()");
                return ($setAss->execute(array($idDaSessao,$idEmpresa,$metodo,$assinatura,$plano,$cpfSalvar,$telSalvar,$link,$cod_barra,"PENDING",$data_boleto)))?true:false;
                    
                }else{                    
                $upAss=self::getConn()->prepare("UPDATE assinaturas SET metodo_pagamento=?, chave_pagamento=?, plano=?, cpf=?, telefone=?, link_pagamento=?, codigo_barra=?, status_assinatura=?, data_vencimento=?, data_status=NOW() WHERE id_usuario=? AND id_empresa=?");
                return ($upAss->execute(array($metodo,$assinatura,$plano,$cpfSalvar,$telSalvar,$link,$cod_barra,"PENDING",$data_boleto,$idDaSessao,$idEmpresa)))?true:false;       
                }
                
            }else{
                return false;
            }
            
        }
        
        static function altAssinaturas($status,$chave){
            
            if($status=="ACTIVE"){
                $txtBoleto=", data_vencimento=?";
                $dataBoleto=date("Y-m-d",strtotime('+1 month', strtotime(date("Y-m-d"))));
                $arBoleto=array($status,$dataBoleto,$chave);
            }else{
                $txtBoleto="";
                $arBoleto=array($status,$chave);
            }
            
            $setEnd=self::getConn()->prepare("UPDATE assinaturas SET status_assinatura=?".$txtBoleto.", data_status=NOW() WHERE chave_pagamento=?");
            if($setEnd->execute($arBoleto)){
                $selId=self::getConn()->prepare("SELECT id_usuario,plano FROM assinaturas WHERE chave_pagamento=? LIMIT 1");
                $selId->execute(array($chave));
                if($selId->rowCount()>0){
                $idUsuario=$selId->fetch(PDO::FETCH_ASSOC);                    
                $planoAtivo=($status=="ACTIVE")?1:0;                
                    $altAtiva=self::getConn()->prepare("UPDATE usuarios SET plano_ativo=? WHERE `id`=? AND cod_assinatura=?");
                    return ($altAtiva->execute(array($planoAtivo,$idUsuario["id_usuario"],$chave)))?$idUsuario["plano"]:false;                    
                }else{
                    return false;
                }
                
            }else{
              return false;  
            }
            
        }
        
        static function clienteComConta($idEmpresa,$idCliente){
			$verificar=self::getConn()->prepare("SELECT `id` FROM conta_clientes WHERE id_empresa=? AND id_cliente=? AND idfechado=0 LIMIT 1");
			$verificar->execute(array($idEmpresa,$idCliente));
			return ($verificar->rowCount()>0)?true:false;
		}
	
		static function versetem($idEmpresa,$oqver,$noquever,$qualTabela="usuarios",$id=0){			
			if($qualTabela=="empresas" || $qualTabela=="usuarios" || $qualTabela=="ambientes"){
			$contTable="";
			$arrayTable=array($oqver);
			}elseif($qualTabela=="cmd_mesa"){
			$contTable=" AND id_empresa=? AND idfechado=0";
			$arrayTable=array($oqver,$idEmpresa);
			}else{
			$contTable=" AND id_empresa=?";
			$arrayTable=array($oqver,$idEmpresa);
			}
			
			$verificar=self::getConn()->prepare("SELECT `id` FROM ".$qualTabela." WHERE `".$noquever."`=?".$contTable);
			$verificar->execute($arrayTable);
			if($verificar->rowCount()>=1){
			$Aid = $verificar->fetch(PDO::FETCH_NUM);	
			return ($Aid[0]==$id)?false:true;
			}else{
			return false;
			}
		}
		
		static function verSenhaAtual($idDaSessao,$senha,$qualSenha="acesso"){
			$senha=sha1($senha);
			$compleSenha=($qualSenha=="acesso")?"senha":"senha_master";
			$verificar=self::getConn()->prepare("SELECT `id` FROM usuarios WHERE ".$compleSenha."=? AND id=?");
			$verificar->execute(array($senha,$idDaSessao));
			return ($verificar->rowCount()>0)?true:false;
		}
		
		static function verSenhaMaster($idEmpresa,$senha){
			$senha=sha1($senha);
			$verificar=self::getConn()->prepare("SELECT `id` FROM usuarios WHERE senha_master=? AND id_empresa=? AND nivel=1");
			$verificar->execute(array($senha,$idEmpresa));
			return ($verificar->rowCount()>0)?true:false;
		}
		
		static function altSenhas($idDaSessao,$senha,$qualSenha="acesso"){
			$senha=sha1($senha);
			$compleSenha=($qualSenha=="acesso")?"senha":"senha_master";
			$alt=self::getConn()->prepare("UPDATE usuarios SET ".$compleSenha."=? WHERE id=?");
			return ($alt->execute(array($senha,$idDaSessao)))?true:false;
		}
        
        static function altPgsAmb($idDaSessao,$pgs_amb){
			$alt=self::getConn()->prepare("UPDATE usuarios SET pgs_amb=? WHERE id=?");
			return ($alt->execute(array($pgs_amb,$idDaSessao)))?true:false;
		}
		
		static function insertCadastro($nomeUsuario,$email,$senha,$nome,$sobrenome,$nascimento,$genero,$chave,$nivel=1,$codStatus=0){
			$senha=sha1($senha);
			$senhaMaster=($nivel==1)?$senha:"";
            //$salAmb="frente_caixa,abrir_caixa,comanda_bar,contas_clientes,estoque,clientes,cadastros,administracao";
            $salAmb="";
			$cadastro=self::getConn()->prepare("INSERT INTO usuarios SET nome_usuario=?, `email`=?, senha=?, senha_master=?, nome=?, sobrenome=?, nascimento=?, sexo=?, nivel=?, pgs_amb=?, codStatus=?, cadastro=NOW(), chave_verifica=?, ultimo_acesso=NOW()");
			return ($cadastro->execute(array($nomeUsuario,$email,$senha,$senhaMaster,$nome,$sobrenome,$nascimento,$genero,$nivel,$salAmb,$codStatus,$chave)))?true:false;
		}
		
		static function updateCadastro($idUsuario,$nome,$sobrenome,$nascimento,$sexo,$nomeUsario,$email,$chave){
			$upCadastro=self::getConn()->prepare("UPDATE usuarios SET nome=?, sobrenome=?, nascimento=?, sexo=?, nome_usuario=?, `email`=?, chave_verifica=?, verfica_email=0 WHERE id=?");
			return ($upCadastro->execute(array($nome,$sobrenome,$nascimento,$sexo,$nomeUsario,$email,$chave,$idUsuario)))?true:false;
		}
		
		static function selectIdEmpresa($idOperador,$table){
			$selectId = self::getConn()->prepare("SELECT id_empresa FROM ".$table." WHERE `id`=? LIMIT 1");
			$selectId->execute(array($idOperador));
			$d['num'] = $selectId->rowCount();
			$d['dados'] = $selectId->fetch(PDO::FETCH_NUM);
			return $d;
		}
		
		static function verCadastro($tabArra,$palavra,$idEmpresa){
			$tab=($tabArra=="unidades")?"unidade_venda":$tabArra;		
			$ver = self::getConn()->prepare("SELECT `id` FROM ".$tab." WHERE ".$tab."=? AND id_empresa=?");
			$ver->execute(array($palavra,$idEmpresa));
			return ($ver->rowCount()>=1)?true:false;
		}
		
		static function insertCadArray($idEmpresa,$qualArray,$tabArray){
			
			if(Cadastros::verCadastro($tabArray,$qualArray,$idEmpresa)==false){
			
			$tab=($tabArray=="unidades")?"unidade_venda":$tabArray;			
			$cadArray=self::getConn()->prepare("INSERT INTO ".$tab." SET id_empresa=?, ".$tab."=?");
			return ($cadArray->execute(array($idEmpresa,$qualArray)))?true:false;
			}else{
				return false;
			}
		}
		
		static function insertCadEntrada($idEmpresa,$descEntrada,$valEntrada,$consEntrada){
			if(Cadastros::verCadastro("entradas",$descEntrada,$idEmpresa)==false){
			$cadEntrada=self::getConn()->prepare("INSERT INTO entradas SET id_empresa=?, entradas=?, valor_entrada=?, consuma=?");
			return ($cadEntrada->execute(array($idEmpresa,$descEntrada,$valEntrada,$consEntrada)))?true:false;
			}else{
				return false;
			}
		}
		
		static function deleteCadArray($delete,$tabArray){
			
			$tab=($tabArray=="unidades")?"unidade_venda":$tabArray;			
			$delArray=self::getConn()->prepare("DELETE FROM ".$tab." WHERE id=?");
			return ($delArray->execute(array($delete)))?true:false;
		}
		
		//BUSCA PRODUTO PRO TOPO
		static function buscaProdutoTopo($idEmpresa,$busca,$limit=5){
			$explode=explode(' ',$busca);
			$numP=count($explode);
			$buscar="";
			for($h=0;$h<$numP;$h++){				
				$buscar.="(codigo_interno LIKE :buscar$h OR marca LIKE :buscar$h OR descricao LIKE :buscar$h)";
				if($h<>$numP-1){ $buscar.=" AND ";}
			}			
			$buscando=self::getConn()->prepare("SELECT * FROM produtos WHERE $buscar AND id_empresa=$idEmpresa LIMIT $limit");
			for($h=0;$h<$numP;$h++){
		 	$buscando->bindValue(":buscar$h","%".$explode[$h]."%",PDO::PARAM_STR);
		 	}
			$buscando->execute();
			$b['num']= $buscando->rowCount();
			$b['dados']=$buscando->fetchAll();
			return $b;		
		}
		
		static function buscaArray($tabela,$busca,$idEmpresa,$limite=8){
			
			if($tabela=="busca_clientes"){
			$tabela="clientes";
			$oqBusca=true;
			}
			
			$explode = explode(" ",$busca);
			$numP = count($explode);
			$buscar = "";
			for($h=0;$h<$numP;$h++){
				if(isset($oqBusca)){
				$buscar .= "(`id` LIKE :buscar$h OR nome LIKE :buscar$h)";
				}else{
				$buscar .= "($tabela LIKE :buscar$h)";
				}
				if($h<>$numP-1){ $buscar .= " AND "; }
			}
			
			$buscaArray= self::getConn()->prepare("SELECT * FROM $tabela WHERE $buscar AND id_empresa=$idEmpresa ORDER BY `id` DESC LIMIT $limite");
			for($hi=0;$hi<$numP;$hi++){
			 $buscaArray->bindValue(":buscar$hi",'%'.$explode[$hi].'%',PDO::PARAM_STR);
		 	}
			$buscaArray->execute();
			$r['num'] = $buscaArray->rowCount();
			$r['dados'] = $buscaArray->fetchAll();
			return $r;
		}
		
		static function selectArray($idEmpresa,$tabela,$inicio=false,$maximo=false,$produtoCliente=false,$cmdBar=false){
			
			if($inicio!=false OR $maximo!=false){
			$pagina = " ORDER BY `id` DESC LIMIT ".$inicio.",".$maximo;
			}elseif($produtoCliente!=false){
				$pagina = " AND id=".$produtoCliente." ORDER BY `id` DESC LIMIT 1";
			}elseif($cmdBar!=false){
				$pagina = " ORDER BY `id`";
			}else{
				$pagina = " ORDER BY `id` DESC";
			}
			
			$selectArray=self::getConn()->prepare("SELECT * FROM ".$tabela." WHERE id_empresa=?".$pagina);
			$selectArray->execute(array($idEmpresa));
			$s['num'] = $selectArray->rowCount();
			$s['dados'] = ($produtoCliente==false)?$selectArray->fetchAll():$selectArray->fetch(PDO::FETCH_ASSOC);
			return $s;
		}
		
		static function countArray($idEmpresa,$tabela){
			$countArray=self::getConn()->prepare("SELECT `id` FROM ".$tabela." WHERE id_empresa=?");
			$countArray->execute(array($idEmpresa));
			return $countArray->rowCount();
		}
		
		static function altStatusEmpresa($status,$idEmpresa){
			$alt=self::getConn()->prepare("UPDATE empresas SET codStatus=? WHERE id=?");
			return ($alt->execute(array($status,$idEmpresa)))?true:false;
		}
		
		static function altStatusOpera($idOperador,$status,$tabela){
			$alt=self::getConn()->prepare("UPDATE ".$tabela." SET codStatus=? WHERE `id`=?");
			return ($alt->execute(array($status,$idOperador)))?true:false;
		}
		
		//ABRE PARTE CONTA DE CLIENTES
		
		static function buscaContaCliente($busca,$idEmpresa){
		$explode = explode(" ",$busca);
		$numP = count($explode);
		$buscar = "";
		for($h=0;$h<$numP;$h++){
			$buscar .= "(c.nome LIKE :buscado$h)";
			if($h<>$numP-1){ $buscar .=  " AND ";}
		}
		$setBusca=self::getConn()->prepare("SELECT l.id_cliente,c.id,c.id_empresa,SUM(l.quantidade*l.valor) AS total FROM conta_clientes l INNER JOIN clientes c ON c.id=l.id_cliente WHERE $buscar AND c.id_empresa='$idEmpresa' GROUP BY l.id_cliente ORDER BY id DESC LIMIT 10");
		
		for($hi=0;$hi<$numP;$hi++){
		 $setBusca->bindValue(":buscado$hi",'%'.$explode[$hi].'%',PDO::PARAM_STR);
		}
		$setBusca->execute();
		$r['num'] = $setBusca->rowCount();
		$r['dados'] = $setBusca->fetchAll();
		return $r;
		}
		
		//FECHA PARTE DE CONTA DE CLIENTES
		
		//ADICIONAR DESCONTAR
		static function descontarCMC($idEmpresa,$idCmd,$valCmd,$formaPagamento,$pagoCartao,$autoriza,$fechada_por,$dadosExtras,$sangria=false){
		$idComanda=explode('|',$idCmd);
		$serMesa=explode('|',$dadosExtras);
		if($serMesa[0]=='mesa'){
		$idComanda=(int)$idComanda[1];
		}else{
		$idComanda=($serMesa[0]=='comanda' AND strlen($idComanda[1])==1)?'0'.$idComanda[1]:$idComanda[1];
		}
		
		$verDescontar=self::getConn()->prepare("INSERT INTO descontar SET id_empresa=?, idCMC=?, qualTBL=?, garcon=?, valor=?, cadastro=NOW()");
		if($verDescontar->execute(array($idEmpresa,$idComanda,$serMesa[0],$fechada_por,$valCmd))){			
			$idDescontar=self::getConn()->prepare("SELECT `id` FROM descontar WHERE id_empresa=? AND idCMC=? AND qualTBL=? AND idfechado=0 ORDER BY `id` DESC LIMIT 1");
			$idDescontar->execute(array($idEmpresa,$idComanda,$serMesa[0]));
			
			if($idDescontar->rowCount()>0){			
			$idDesconto=$idDescontar->fetch(PDO::FETCH_NUM);
			
			if($serMesa[0]=="comanda"){
			
				$pegarIdCliente=self::getConn()->prepare("SELECT `id`,cmd_aberta_por,sexo,ultima_compra FROM clientes WHERE id_empresa=? AND comanda=? LIMIT 1");
				$pegarIdCliente->execute(array($idEmpresa,$idComanda));
				
				if($pegarIdCliente->rowCount()>0){
					$idCliente=$pegarIdCliente->fetch(PDO::FETCH_NUM);			
				$insertFechada=self::getConn()->prepare("INSERT INTO comandas_fechadas SET id_empresa=?, id_cliente=?, comanda=?, valor_entrada='', vale_pedagio='nao', valor_pedagio='0.00', cmd_aberta_por=?, forma_pagamento=?, valor_pago=?, pago_ou_cartao=?, autorizacao_cartao=?, sexo=?, data_aberta=?, cmd_fechada_por=?, id_descontar=?, cadastro=NOW()");
                    $retDesconto=($insertFechada->execute(array($idEmpresa,$idCliente[0],$idComanda,$idCliente[1],$formaPagamento,$valCmd,$pagoCartao,$autoriza,$idCliente[2],$idCliente[3],$fechada_por,$idDesconto[0])))?$idDesconto[0]:false;
				}else{
					return false;
				}
				
			}elseif($serMesa[0]=="mesa"){
				$insertFechada=self::getConn()->prepare("INSERT INTO mesas_fechadas SET id_empresa=?, cmd_mesa=?, forma_pagamento=?, valor_pago=?, pago_ou_cartao=?, autorizacao_cartao=?, tx_servico=0, cmd_fechada_por=?, id_descontar=?, cadastro=NOW()");
				$retDesconto=($insertFechada->execute(array($idEmpresa,$idComanda,$formaPagamento,$valCmd,$pagoCartao,$autoriza,$fechada_por,$idDesconto[0])))?$idDesconto[0]:false;
			}else{
				
				$pegarSexo=self::getConn()->prepare("SELECT sexo FROM clientes WHERE `id`=? AND id_empresa=? LIMIT 1");
				$pegarSexo->execute(array($idComanda,$idEmpresa));			
				if($pegarSexo->rowCount()>0){
					$sexoCliente=$pegarSexo->fetch(PDO::FETCH_NUM);
					$sexo=$sexoCliente[0];
				}else{
					$sexo='H';
				}
				$idConta=(isset($serMesa[2]))?$serMesa[2]:0;
				$insertFechada=self::getConn()->prepare("INSERT INTO conta_clientes_fechadas SET id_empresa=?, id_cliente=?, id_conta=?, forma_pagamento=?, valor_pago=?, pago_ou_cartao=?, autorizacao_cartao=?, sexo=?, conta_fechada_por=?, id_descontar=?, cadastro=NOW()");
				$retDesconto=($insertFechada->execute(array($idEmpresa,$idComanda,$idConta,$formaPagamento,$valCmd,$pagoCartao,$autoriza,$sexo,$fechada_por,$idDesconto[0])))?$idDesconto[0]:false;
			}
                
            if(isset($retDesconto) AND $retDesconto!=false){

            if($sangria==true){
                $qualPago=($formaPagamento==1)?"pago_dinheiro=pago_dinheiro+?":"pago_cartao=pago_cartao+?";
                $upSangria=self::getConn()->prepare("UPDATE abrir_fechar_caixa SET ".$qualPago." WHERE id_empresa=? AND funcionario=? AND status=0");
                if($upSangria->execute(array($valCmd,$idEmpresa,$fechada_por))){
                   $sangria=false; 
                }else{
                    return false;
                    exit();
                }
            }
             if($sangria==false){
                 return $retDesconto;
             }

            }else{
                return false;
            }
					
			}else{
			return false;			
			}
		}else{
		return false;
		}
		}
		
		//DELETAR DESCONTAR
		static function delDescontar($idDel,$idEmpresa){
			$selTipo=self::getConn()->prepare("SELECT qualTBL FROM descontar WHERE `id`=? AND id_empresa=? AND idfechado=0");
			$selTipo->execute(array($idDel,$idEmpresa));
			if($selTipo->rowCount()>0){
				$qualTBL=$selTipo->fetch(PDO::FETCH_NUM);
				$delDescontar=self::getConn()->prepare("DELETE FROM descontar WHERE `id`=? AND id_empresa=? AND idfechado=0");
				if($delDescontar->execute(array($idDel,$idEmpresa))){
					if($qualTBL[0]=="comanda"){
					$tbldel="comandas_fechadas";
					}elseif($qualTBL[0]=="mesa"){
					$tbldel="mesas_fechadas";
					}else{
					$tbldel="conta_clientes_fechadas";
					}
                    $dadosDel=self::getConn()->prepare("SELECT forma_pagamento,valor_pago FROM ".$tbldel." WHERE id_empresa=? AND id_descontar=? LIMIT 1");
                    $dadosDel->execute(array($idEmpresa,$idDel));
                    if($dadosDel->rowCount()>0){
                    $ddDel=$dadosDel->fetch(PDO::FETCH_ASSOC);    
					$delFechada=self::getConn()->prepare("DELETE FROM ".$tbldel." WHERE id_empresa=? AND id_descontar=?");
					$delFechada->execute(array($idEmpresa,$idDel));					
                    }else{
                    $ddDel['forma_pagamento']=0;
                    $ddDel['valor_pago']=0;
                    }
                    return $ddDel;
				}else{
					return false;
				}
			}else{
				return false;
			}
		}
		
		//TRAZER DESCONTAR COMANDA/MESA BAR
		static function trazerDescontar($idEmpresa,$comanda,$tabela,$idfechado=0,$funcionario=false){
            $comple=($funcionario!=false)?"garcon":"idCMC";
		$buscado = self::getConn()->prepare("SELECT * FROM descontar WHERE id_empresa=? AND ".$comple."=? AND qualTBL=? AND idfechado=? ORDER BY `id`");
		$buscado->execute(array($idEmpresa,$comanda,$tabela,$idfechado));
		$c['num'] = $buscado->rowCount();
		$c['dados'] = $buscado->fetchAll();
		return $c;
		}
        
		static function valorTotalDescontar($idEmpresa,$tabela,$sexo=false){
			if($sexo!=false){
				$qualCampo=($tabela=='comanda')?'c.comanda=d.idCMC':'c.id=d.idCMC';
				$valDescontar=self::getConn()->prepare("SELECT SUM(d.valor) AS total FROM descontar d INNER JOIN clientes c ON ".$qualCampo." WHERE d.id_empresa=? AND d.qualTBL=? AND d.idfechado=0 AND c.sexo=?");
				$arrayComp=array($idEmpresa,$tabela,$sexo);
			}else{
				$valDescontar= self::getConn()->prepare("SELECT SUM(valor) as total FROM descontar WHERE id_empresa=? AND qualTBL=? AND idfechado=0");
				$arrayComp=array($idEmpresa,$tabela);
			}
			
			$valDescontar->execute($arrayComp);
			$n=$valDescontar->fetch(PDO::FETCH_ASSOC);
			return $n['total'];
			
			/*
			if($sexo!=false){
				if($idfechado!=0){
				if($tabela=='comanda'){					
				$qualTbl='comandas_fechadas';
				$qualCampo='c.comanda=d.idCMC';
				}else{				
				$qualTbl='conta_clientes_fechadas';
				$qualCampo='c.id_cliente=d.idCMC';
				}
				$valDescontar=self::getConn()->prepare("SELECT SUM(d.valor) AS total FROM descontar d INNER JOIN ".$qualTbl." c ON ".$qualCampo." AND d.idfechado=c.id WHERE d.id_empresa=? AND d.qualTBL=? AND c.sexo=? AND d.status=0");
				}else{						
				$qualCampo=($tabela=='comanda')?'c.comanda=d.idCMC':'c.id=d.idCMC';
				$valDescontar=self::getConn()->prepare("SELECT SUM(d.valor) AS total FROM descontar d INNER JOIN clientes c ON ".$qualCampo." WHERE d.id_empresa=? AND d.qualTBL=? AND d.idfechado=0 AND c.sexo=? AND d.status=0");
				}
				$arrayComp=array($idEmpresa,$tabela,$sexo);
				
			}else{
				$stats='';
				if($idfechado!=0){
				$fechado='idfechado!=0';			
				if($status==0){$stats=' AND status=0';}
				}else{
				$fechado='idfechado=0';
				}
				$valDescontar= self::getConn()->prepare("SELECT SUM(valor) as total FROM descontar WHERE id_empresa=? AND qualTBL=?".$stats." AND ".$fechado);
				$arrayComp=array($idEmpresa,$tabela);
			}
			*/
			
		}
		
		
	}