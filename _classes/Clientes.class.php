<?php
	class Clientes extends DB{		
		static function trasIdCliente($idEmpresa,$nome){			
			$verificar=self::getConn()->prepare("SELECT `id` FROM clientes WHERE id_empresa=? AND nome=? ORDER BY `id` DESC LIMIT 1");
			$verificar->execute(array($idEmpresa,$nome));
			if($verificar->rowCount()>=1){
			$tras=$verificar->fetch(PDO::FETCH_NUM);
			return $tras[0];
			}else{
			return false;
			}
		}

		static function insertClientes($idEmpresa,$nome,$nascimento,$sexo,$tipoPessoa,$cpf_cnpj,$rg_estadual,$tel,$email,$idOperador){
            
			$cadClientes=self::getConn()->prepare("INSERT INTO clientes SET id_empresa=?, nome=?, nascimento=?, sexo=?, comanda='', opc_entrada='', vale_pedagio='', valor_pedagio='', tipo_pessoa=?, cpf_ou_cnpj=?, rg_ou_estadual=?, telefone=?, email=?, id_operador=?, ultima_compra=NOW(), cadastro=NOW()");
			if($cadClientes->execute(array($idEmpresa,$nome,$nascimento,$sexo,$tipoPessoa,$cpf_cnpj,$rg_estadual,$tel,$email,$idOperador))){
				return true;
			}else{
				return false;
			}
		}
		
		//BUSCA CLIENTES CAIXA COMANDA
		static function buscaClienteCmd($idEmpresa,$busc,$limit=30){

		$busca = explode(' ',$busc);
		$numP=count($busca);
		$buscar = '';
		 for($hi=0;$hi<$numP;$hi++){
			 $buscar .= "(nome LIKE :busca$hi OR telefone LIKE :busca$hi OR email LIKE :busca$hi OR cpf_ou_cnpj LIKE :busca$hi OR rg_ou_estadual LIKE :busca$hi)";
			 if($hi<>$numP-1){ $buscar .= ' AND '; }
		 }
		 $buscado = self::getConn()->prepare("SELECT * FROM clientes WHERE $buscar AND id_empresa='$idEmpresa' ORDER BY `id` DESC LIMIT ".$limit);

		 for($hi=0;$hi<$numP;$hi++){
			 $bbusca = ($hi<count($busca))?$busca[$hi]:'';
			 $buscado->bindValue(":busca$hi",'%'.$bbusca.'%',PDO::PARAM_STR);
		 }
		 $buscado->execute();
		 $c['num'] = $buscado->rowCount();
		 $c['dados'] = $buscado->fetchAll();
		 return $c;
		}

		//BUSCA CLIENTES
		static function buscaCliente($idEmpresa,$codigo,$setNome,$setContato,$comanda){

		$nome = ($setNome<>"")? explode(' ',$setNome):array('');
		$contato = ($setContato<>"(__) _____-____" AND $setContato<>"(__) ____-____" AND $setContato<>"")? $setContato:'';
		$numP = count($nome);
		$buscar = "";
		 for($hi=0;$hi<$numP;$hi++){
			 $buscar .= "(nome LIKE :nome$hi)";
			 if($hi<>$numP-1){ $buscar .= ' AND '; }
		 }
		 $comple="";
		 if($codigo<>""){ $comple.=" AND `id` LIKE '%".$codigo."%'"; }		
		 if($contato<>""){ $comple.=" AND telefone LIKE '%".$contato."%'"; }
		 if($comanda<>""){ $comple.=" AND comanda LIKE '%".$comanda."%'"; }
		 $buscado = self::getConn()->prepare("SELECT * FROM clientes WHERE $buscar".$comple." AND id_empresa='$idEmpresa' ORDER BY `id` DESC LIMIT 12");

		 for($hi=0;$hi<$numP;$hi++){
			 $bnome = ($hi<count($nome))?$nome[$hi]:'';
			 $buscado->bindValue(":nome$hi",'%'.$bnome.'%',PDO::PARAM_STR);
		 }
		 $buscado->execute();
		 $c['num'] = $buscado->rowCount();
		 $c['dados'] = $buscado->fetchAll();
		 return $c;
		}

		//ALTERA CLIENTES
		static function alteraCliente($id,$nome,$nascimento,$sexo,$tipo_pessoa,$cpf_cnpj,$rg_estadual,$tel,$email){
			$upClientes=self::getConn()->prepare("UPDATE clientes SET nome=?, nascimento=?, sexo=?, tipo_pessoa=?, cpf_ou_cnpj=?, rg_ou_estadual=?, telefone=?, email=? WHERE id=?");
			if($upClientes->execute(array($nome,$nascimento,$sexo,$tipo_pessoa,$cpf_cnpj,$rg_estadual,$tel,$email,$id))){
				return true;
			}else{
				return false;
			}

		}
		
		
		//ABRE TUDO CONTAS DE CLIENTES		
		static function insertContaCliente($idCliente,$idEmpresa,$idProduto,$quantidade,$valorCompra,$valor,$nomeProduto,$codOpera,$dataCad=false,$preId=false,$transfere=false){
			$verConta1=self::getConn()->prepare("SELECT id_conta FROM conta_clientes WHERE id_cliente=? AND id_empresa=? AND status=0 ORDER BY id_conta DESC LIMIT 1");
			$verConta1->execute(array($idCliente,$idEmpresa));
			if($verConta1->rowCount()>0){
				$dd=$verConta1->fetch(PDO::FETCH_ASSOC);
				$id_conta=$dd['id_conta'];
			}else{				
				$status=self::getConn()->prepare('UPDATE clientes SET data_status_conta=NOW() WHERE id=? AND id_empresa=?');
				if($status->execute(array($idCliente,$idEmpresa))){
				
				$verConta=self::getConn()->prepare("SELECT id_conta FROM conta_clientes WHERE id_empresa=? ORDER BY id_conta DESC LIMIT 1");
				$verConta->execute(array($idEmpresa));
				if($verConta->rowCount()>0){
					$dd = $verConta->fetch(PDO::FETCH_ASSOC);
					$id_conta = $dd['id_conta']+1;
				}else{
				$id_conta = 1;
				}
				}
			}
			
			if(isset($id_conta)){
            $salvaData=($dataCad==false)?"NOW()":"'".$dataCad."'";
			$setConta = self::getConn()->prepare("INSERT INTO conta_clientes SET id_empresa=?, id_cliente=?, id_produto=?, nome_produto=?, quantidade=?, valor_compra=?, valor=?, codigo_operador=?, id_conta=?, data=".$salvaData);
			if($setConta->execute(array($idEmpresa,$idCliente,$idProduto,$nomeProduto,$quantidade,$valorCompra,$valor,$codOpera,$id_conta))){
			if($idProduto==0 || $transfere==true){
				$certoOK=true;
			}else{				
				$setAltera = self::getConn()->prepare("UPDATE produtos SET quantidade=quantidade-? WHERE id=? AND id_empresa=?");
				if($setAltera->execute(array($quantidade,$idProduto,$idEmpresa))){
				$certoOK=true;
				}
			}
			
			if(isset($certoOK) AND $certoOK==true){				
				if($preId==false){
				$trasId=self::getConn()->prepare("SELECT `id`,id_conta,data FROM conta_clientes WHERE id_cliente=? AND id_produto=? AND id_empresa=? AND status=0 ORDER BY id DESC LIMIT 1");
				$trasId->execute(array($idCliente,$idProduto,$idEmpresa));
				if($trasId->rowCount()>0){
					$dId=$trasId->fetch(PDO::FETCH_ASSOC);
					return $dId;
				}else{
					return false;
				}
				}else{
				return true;
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
		
		//PAGA CONTA CLIENTE
		static function pagaTudoConta($idCliente,$idconta,$idEmpresa,$formaPagamento,$valPago,$pagoCartao,$autoriza,$fechada_por,$quant=false,$idPago=false,$sangria=false){
			$tudoCerto=false;
			if($idPago!=false){
				$selDadosPago=self::getConn()->prepare("SELECT * FROM conta_clientes WHERE `id`=? AND id_empresa=?");
				$selDadosPago->execute(array($idPago,$idEmpresa));
				if($selDadosPago->rowCount()>0){
					$dadosPago=$selDadosPago->fetch(PDO::FETCH_ASSOC);
					$idconta=$dadosPago["id_conta"];
					if($dadosPago['quantidade']>$quant){
						$pagConta=self::getConn()->prepare("UPDATE conta_clientes SET quantidade=quantidade-? WHERE `id`=? AND id_empresa=?");
						if($pagConta->execute(array($quant,$idPago,$idEmpresa))){
						$tudoCerto=true;
						$salvaNovo=true;
						}
					}else{
						$pagConta=self::getConn()->prepare("UPDATE conta_clientes SET status=1 WHERE id=? AND id_empresa=?");
						if($pagConta->execute(array($idPago,$idEmpresa))){
							$tudoCerto=true;
						}
					}
				}
			}else{
				$pagConta=self::getConn()->prepare("UPDATE conta_clientes SET status=1 WHERE id_conta=? AND id_empresa=? AND status=0");
				if($pagConta->execute(array($idconta,$idEmpresa))){
					$tudoCerto=true;
				}
			}
				if($tudoCerto==true){
					$pegarSexo=self::getConn()->prepare("SELECT sexo FROM clientes WHERE id=? AND id_empresa=? LIMIT 1");
					$pegarSexo->execute(array($idCliente,$idEmpresa));			
					if($pegarSexo->rowCount()>0){
						$sexoCliente=$pegarSexo->fetch(PDO::FETCH_NUM);
						$sexo=$sexoCliente[0];
					}else{
						$sexo='H';
					}
				
					$insertContaFechada=self::getConn()->prepare("INSERT INTO conta_clientes_fechadas SET id_empresa=?, id_cliente=?, id_conta=?, forma_pagamento=?, valor_pago=?, pago_ou_cartao=?, autorizacao_cartao=?, sexo=?, conta_fechada_por=?, cadastro=NOW()");
					if($insertContaFechada->execute(array($idEmpresa,$idCliente,$idconta,$formaPagamento,$valPago,$pagoCartao,$autoriza,$sexo,$fechada_por))){		
                        if($sangria==true){
                        $qualPago=($formaPagamento==1)?"pago_dinheiro=pago_dinheiro+?":"pago_cartao=pago_cartao+?";
                        $upSangria=self::getConn()->prepare("UPDATE abrir_fechar_caixa SET ".$qualPago." WHERE id_empresa=? AND funcionario=? AND status=0");
                        if($upSangria->execute(array($valPago,$idEmpresa,$fechada_por))){
                           $sangria=false; 
                        }else{
                            return false;
                        }
                        }
                         if($sangria==false){   
                        
						if(isset($salvaNovo)){		
							$insertPago=self::getConn()->prepare("INSERT INTO conta_clientes SET id_empresa=?, id_cliente=?, id_produto=?, nome_produto=?, quantidade=?, valor=?, codigo_operador=?, id_conta=?, data=?, status=1");
							if($insertPago->execute(array($idEmpresa,$idCliente,$dadosPago["id_produto"],$dadosPago["nome_produto"],$quant,$dadosPago["valor"],$dadosPago["codigo_operador"],$idconta,$dadosPago["data"]))){
							$proxConta=true;
							}
						}else{
						$proxConta=true;
						}
						if(isset($proxConta)){							
							$idfechado=self::getConn()->prepare("SELECT `id` FROM conta_clientes_fechadas WHERE id_empresa=? AND id_cliente=? AND id_conta=? ORDER BY `id` DESC LIMIT 1");
							$idfechado->execute(array($idEmpresa,$idCliente,$idconta));
							$idFecha=$idfechado->fetch(PDO::FETCH_NUM);
							$upConta=self::getConn()->prepare("UPDATE conta_clientes SET idfechado=? WHERE id_conta=? AND id_cliente=? AND id_empresa=? AND status=1 AND idfechado=0");
							if($upConta->execute(array($idFecha[0],$idconta,$idCliente,$idEmpresa))){
								$upDescontar=self::getConn()->prepare("UPDATE descontar SET idfechado=? WHERE id_empresa=? AND idCMC=? AND qualTBL=? AND idfechado=0");
								if($upDescontar->execute(array($idFecha[0],$idEmpresa,$idCliente,'conta'))){
								return true;
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
					}else{
					return false;
					}				
			}else{
			return false;
			}			
		}
		
		//DELETE CONTA CLIENTES
		static function deleteContaCliente($idDel,$idProd,$quant,$idEmpresa){		
		$delConta=self::getConn()->prepare("DELETE FROM conta_clientes WHERE `id`=? AND id_empresa=?");
		if($delConta->execute(array($idDel,$idEmpresa))){		
		if($idProd<>0){
			$verProd=self::getConn()->prepare("SELECT `id` FROM produtos WHERE `id`=? AND id_empresa=?");
			$verProd->execute(array($idProd,$idEmpresa));
			if($verProd->rowCount()>0){			
				$altQuant=self::getConn()->prepare("UPDATE produtos SET quantidade=quantidade+? WHERE `id`=? AND id_empresa=?");
				if($altQuant->execute(array($quant,$idProd,$idEmpresa))){
				return true;
				}else{
				return false;
				}
			}else{
			return true;
			}
		}else{
		return true;
		}
		}else{
		return false;
		}		
		}
		
		static function selectConta($idCliente,$idEmpresa,$idfechado=0,$condicaoData=false,$agrupado=false){			
			if($agrupado==false){
			$contTras=($condicaoData!=false)?" AND (cast(data as date)>'$condicaoData')":"";
			$selConta=self::getConn()->prepare("SELECT *,(quantidade*valor) AS total FROM conta_clientes WHERE id_cliente=? AND id_empresa=? AND idfechado=?".$contTras." ORDER BY `id`");
			}else{
			$contTras=($condicaoData!=false)?" AND (cast(data as date)<='$condicaoData')":"";
			$selConta=self::getConn()->prepare("SELECT nome_produto,id_conta,MIN(codigo_operador) AS codigo_operador,MIN(valor) AS valor,MAX(data) AS data,MIN(quantidade) as testeQuant, SUM(quantidade) as quantidade,MAX(id) AS id, MIN(id_produto) AS id_produto,SUM(quantidade*valor) AS total FROM conta_clientes WHERE id_cliente=? AND id_empresa=? AND idfechado=?".$contTras." GROUP BY nome_produto ORDER BY id");
			}
			$selConta->execute(array($idCliente,$idEmpresa,$idfechado));
			$s['num'] = $selConta->rowCount();
			$s['dados'] = $selConta->fetchAll();
			return $s;
		}
		
		static function verContaAberto($idCliente,$idEmpresa){
			$selConta=self::getConn()->prepare("SELECT `id` FROM conta_clientes WHERE id_cliente=? AND id_empresa=? AND idfechado=0 ORDER BY `id` DESC LIMIT 1");		
			$selConta->execute(array($idCliente,$idEmpresa));
			return $selConta->rowCount();
		}
		
		//TRAZER APENAS AGRUPADOS
		static function countAgrupaConta($idCliente,$idEmpresa){
		$condicaoData = date('Y-m-d', strtotime("-1 days"));
		$selAgrupa=self::getConn()->prepare("SELECT nome_produto FROM conta_clientes WHERE id_cliente=? AND id_empresa=? AND idfechado=0 AND (cast(data as date)<='$condicaoData') GROUP BY nome_produto HAVING count(nome_produto)>1");
		$selAgrupa->execute(array($idCliente,$idEmpresa));
		return $selAgrupa->rowCount();		
		}
		
		//TRAZER VALOR TODAS CONTAS ABERTAS
		static function valorContaAberta($idEmpresa,$sexo=false){
			if($sexo!=false){			
			$selCmd=self::getConn()->prepare("SELECT SUM(c.quantidade*c.valor) AS total FROM conta_clientes c INNER JOIN clientes p ON p.id=c.id_cliente WHERE c.id_empresa=? AND c.status=0 AND p.sexo=?");
			$arrayComp=array($idEmpresa,$sexo);
			}else{
			$selCmd=self::getConn()->prepare("SELECT SUM(quantidade*valor) AS total FROM conta_clientes WHERE id_empresa=? AND status=0");
			$arrayComp=array($idEmpresa);	
			}
			$selCmd->execute($arrayComp);
			$n=$selCmd->fetch(PDO::FETCH_ASSOC);
			return $n['total'];
		}
		
		//LISTA CONTA CLIENTE
		static function listaConta($idEmpresa,$inicio=false,$maximo=false,$datainicio=false,$datafinal=false,$sexo=false){			
		
		$conLimit=($inicio==false AND $maximo==false)?"":" LIMIT ".$inicio.",".$maximo;		
		if($datainicio!=false AND $datafinal!=false){
			$dinicial=implode("-",array_reverse(explode("/",$datainicio)));
			$dfinal=implode("-",array_reverse(explode("/",$datafinal)));
			if($sexo!=false){
			$compleCmd=" AND (cast(c.data as date) BETWEEN ('$dinicial') AND ('$dfinal'))";
			}else{
			$compleCmd=" AND (cast(data as date) BETWEEN ('$dinicial') AND ('$dfinal'))";
			}
		}else{
			$compleCmd="";
		}
		
		if($sexo!=false){
		$compleCmd.=" AND p.sexo=?";
		$arrayComp=array($idEmpresa,$sexo);
		$trasDados = self::getConn()->prepare("SELECT c.id_conta,c.id_cliente,SUM(c.quantidade*c.valor) AS total,p.id,p.sexo FROM conta_clientes c INNER JOIN clientes p ON p.id=c.id_cliente WHERE c.id_empresa=? AND c.status=0".$compleCmd." GROUP BY c.id_cliente,c.id_conta ORDER BY c.id_conta DESC".$conLimit);		
		}else{			
		$trasDados = self::getConn()->prepare("SELECT id_conta,id_cliente,SUM(quantidade*valor) AS total FROM conta_clientes WHERE id_empresa=? AND status=0".$compleCmd." GROUP BY id_cliente,id_conta ORDER BY id_conta DESC".$conLimit);		
		$arrayComp=array($idEmpresa);}
		$trasDados->execute($arrayComp);
		$t['num'] = $trasDados->rowCount();
		$t['dados'] = $trasDados->fetchAll();
		return $t;		
		}
		
		//LISTA BUSCA CONTA CLIENTE
		static function buscaListaConta($busca,$idEmpresa,$sexo=false){
		if($sexo!=false){ $compleCmd=" AND p.sexo='$sexo'";}else{$compleCmd="";}
		$explode=explode(" ",$busca);
		$numP= count($explode);
		$buscar="";
		for($h=0;$h<$numP;$h++){
			$buscar.="(p.id LIKE :buscar$h OR p.nome LIKE :buscar$h OR p.cpf_ou_cnpj LIKE :buscar$h OR p.rg_ou_estadual LIKE :buscar$h OR p.telefone LIKE :buscar$h OR p.email LIKE :buscar$h OR c.id_conta LIKE :buscar$h)";
		}
		$buscando = self::getConn()->prepare("SELECT c.id_conta,c.id_cliente,SUM(c.quantidade*c.valor) AS total,p.id,p.sexo FROM conta_clientes c INNER JOIN clientes p ON p.id=c.id_cliente WHERE $buscar AND c.id_empresa=$idEmpresa AND c.status=0".$compleCmd." GROUP BY c.id_cliente,c.id_conta ORDER BY c.id_conta DESC LIMIT 30");
		for($h=0;$h<$numP;$h++){
		 $buscando->bindValue(":buscar$h","%".$explode[$h]."%",PDO::PARAM_STR);
		 }
		 $buscando->execute();
		 $n['num']=$buscando->rowCount();
		 $n['dados']=$buscando->fetchAll();
		 return $n;
		}
		
		//BUSCA COMANDA FECHADO
		static function buscaContaFechadas($busca,$id_empresa,$sexo=false){
			if($sexo!=false){$compleCmd=" AND c.sexo='$sexo'";}else{$compleCmd="";}
			$explode = explode(" ",$busca);
			$numP = count($explode);
			$buscar = "";
			for($h=0;$h<$numP;$h++){
				$buscar .= "(n.nome LIKE :buscar$h OR c.id_conta LIKE :buscar$h OR n.cpf_ou_cnpj LIKE :buscar$h OR n.rg_ou_estadual LIKE :buscar$h OR n.telefone LIKE :buscar$h OR n.email LIKE :buscar$h)";
				if($h<>$numP-1){$buscar.= " AND ";}
			}
			$buscando=self::getConn()->prepare("SELECT c.*,n.nome FROM conta_clientes_fechadas c INNER JOIN clientes n ON n.id=c.id_cliente WHERE $buscar AND c.id_empresa=$id_empresa".$compleCmd." ORDER BY c.cadastro DESC LIMIT 30");
			for($h=0;$h<$numP;$h++){
				 $buscando->bindValue(":buscar$h","%".$explode[$h]."%",PDO::PARAM_STR);
			 }
			 $buscando->execute();
			 $n['num']=$buscando->rowCount();
			 $n['dados']=$buscando->fetchAll();
			 return $n;
		}
		
		//TRAZER CONTAR TODAS CONTAS FECHADAS
		static function countContaFechadas($idEmpresa,$sexo=false,$datainicio=false,$datafinal=false,$recentes=false,$relatorioSexo=false){
			
			if($sexo!=false){$compleCmd=" AND sexo=?";$arrayComp=array($idEmpresa,$sexo);}else{$compleCmd="";$arrayComp=array($idEmpresa);}			
			if($relatorioSexo!=false){$compleCmd.=" AND status_sexo=1";}
			if($recentes==true){$compleCmd.=" AND status=1";}
			if($datainicio!=false AND $datafinal!=false){
			$dinicial=implode("-",array_reverse(explode("/",$datainicio)));
			$dfinal=implode("-",array_reverse(explode("/",$datafinal)));
			$compleCmd .=" AND (cast(cadastro as date) BETWEEN ('$dinicial') AND ('$dfinal'))";
			}
			$selCmd=self::getConn()->prepare("SELECT COUNT(id) AS count,SUM(valor_pago) AS total FROM conta_clientes_fechadas WHERE id_empresa=?".$compleCmd);
			$selCmd->execute($arrayComp);
			return $selCmd->fetch(PDO::FETCH_ASSOC);
		}
		
		//TRAZER CONTAS FECHADAS
		static function trazerContaFechadas($idEmpresa,$inicio,$maximo,$datainicio=false,$datafinal=false,$sexo=false){
			if($sexo!=false){$compleCmd=" AND sexo=?";$arrayComp=array($idEmpresa,$sexo);}else{$compleCmd="";$arrayComp=array($idEmpresa);}
			if($datainicio!=false AND $datafinal!=false){
				$dinicial=implode("-",array_reverse(explode("/",$datainicio)));
				$dfinal=implode("-",array_reverse(explode("/",$datafinal)));
				$compleCmd.=" AND (cast(cadastro as date) BETWEEN ('$dinicial') AND ('$dfinal'))";
			}
			$selCmd=self::getConn()->prepare("SELECT * FROM conta_clientes_fechadas WHERE id_empresa=?".$compleCmd." ORDER BY cadastro DESC LIMIT ".$inicio.",".$maximo);
			$selCmd->execute($arrayComp);
			$s['num'] = $selCmd->rowCount();
			$s['dados'] = $selCmd->fetchAll();
			return $s;
		}
		
		//TRAZER CONTAS EM ABERTO
		static function DataContaAbertoFechado($idEmpresa,$abertoFechado){
			$campo=($abertoFechado=="conta_clientes")?"data":"cadastro";
			$selCmd=self::getConn()->prepare("SELECT ".$campo." FROM ".$abertoFechado." WHERE id_empresa=? ORDER BY ".$campo." DESC LIMIT 1");
			$selCmd->execute(array($idEmpresa));
			$s['num'] = $selCmd->rowCount();
			$s['dados'] = $selCmd->fetch(PDO::FETCH_NUM);
			return $s;
		}
		
		//DELETAR CONTAS FECHADA
		static function deletarContaFechada($id_empresa,$idConta,$idCmdFechada){
			$delCmdFechada=self::getConn()->prepare("DELETE FROM conta_clientes_fechadas WHERE id=?");
			if($delCmdFechada->execute(array($idCmdFechada))){
				$delCmd=self::getConn()->prepare("DELETE FROM conta_clientes WHERE id_conta=? AND id_empresa=? AND idfechado=?");
				if($delCmd->execute(array($idConta,$id_empresa,$idCmdFechada))){
				return true;
				}else{
				return false;
				}
			}else{
			return false;
			}
		}
		
		//ZERAR CONTAS FECHADAS RECENTEMENTES
		static function zerarRecentes($idEmpresa,$sexo=false){			
			$qualZera=($sexo==false)?'status':'status_sexo';
			$zeraCmd=self::getConn()->prepare("UPDATE conta_clientes_fechadas SET ".$qualZera."=0 WHERE id_empresa=? AND ".$qualZera."=1");
			return ($zeraCmd->execute(array($idEmpresa)))?true:false;
		}
		
		//FECHA TUDO CONTAS DE CLIENTES

	}