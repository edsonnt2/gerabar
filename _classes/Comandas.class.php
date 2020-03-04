<?php
	class Comandas extends DB{	
	
		//DELETAR PRODUTO DA COMANDA E DA MESA
		static function delProdCmd($idDelCmd,$idProd,$quantidade,$mesa=false,$idEmpresa){
			$BbdCmd=($mesa=="mesa")?'cmd_mesa':'comandas';
			$delProd=self::getConn()->prepare("DELETE FROM ".$BbdCmd." WHERE id=? AND id_empresa=?");
			if($delProd->execute(array($idDelCmd,$idEmpresa))){
				$aumentaProduto=self::getConn()->prepare("UPDATE produtos SET quantidade=quantidade+? WHERE id=? AND id_empresa=?");
				$aumentaProduto->execute(array($quantidade,$idProd,$idEmpresa));
				return true;
			}else{
				return false;
			}
		}
		
		//CADASTRAR COMANDA E MESA	
		static function insertComandaBar($idEmpresa,$garcon,$comanda,$produto,$quantidade,$idproduto,$marca,$descricao,$valor,$valorCompra,$mesa=false){
			if($mesa=="mesa"){
			$BidCmd='idmesa';
			$BnCmd='cmd_mesa';
			$BbdCmd='cmd_mesa';
			}else{
			$BidCmd='idcomanda';
			$BnCmd='comanda';
			$BbdCmd='comandas';
			}
		$idcmd1=self::getConn()->prepare("SELECT ".$BidCmd." FROM ".$BbdCmd." WHERE ".$BnCmd."=? AND idfechado=0 AND id_empresa=? LIMIT 1");
		$idcmd1->execute(array($comanda,$idEmpresa));
		if($idcmd1->rowCount()>0){
			$trascmd = $idcmd1->fetch(PDO::FETCH_NUM);
			$idcomanda= $trascmd[0];
		}else{
		$idcmd2=self::getConn()->prepare("SELECT ".$BidCmd." FROM ".$BbdCmd." WHERE id_empresa=? ORDER BY `id` DESC LIMIT 1");
		$idcmd2->execute(array($idEmpresa));
			if($idcmd2->rowCount()>0){
				$trascmd = $idcmd2->fetch(PDO::FETCH_NUM);
				$idcomanda = $trascmd[0]+1;
			}else{
				$idcomanda=1;
			}
		}
		$cadComandaBar=self::getConn()->prepare("INSERT INTO ".$BbdCmd." SET id_empresa=?, garcon=?, ".$BnCmd."=?, id_produto=?, produto=?, marca=?, descricao=?, quantidade=?, valor_compra=?, valor=?, ".$BidCmd."=?, cadastro=NOW()");
		if($cadComandaBar->execute(array($idEmpresa,$garcon,$comanda,$idproduto,$produto,$marca,$descricao,$quantidade,$valorCompra,$valor,$idcomanda))){
				if($idproduto==0){
				return true;
				}else{
				$baixaProduto=self::getConn()->prepare("UPDATE produtos SET quantidade=quantidade-? WHERE id_empresa=? AND codigo_interno=?");
				if($baixaProduto->execute(array($quantidade,$idEmpresa,$produto))){
				return true;
				}
				}
			}else{
				return false;
			}
		}
		
		static function consultaComandaBar($idEmpresa,$produto){		
			$selectComanda = self::getConn()->prepare("SELECT `id`,quantidade,marca,descricao,valor_varejo,valor_compra FROM produtos WHERE id_empresa=? AND codigo_interno=? LIMIT 1");
			$selectComanda->execute(array($idEmpresa,$produto));
			$c['num'] = $selectComanda->rowCount();
 		    $c['dados'] = $selectComanda->fetch(PDO::FETCH_NUM);
			return $c;
		}
		
		static function updateComandaBar($idEmpresa,$quantidade,$comanda,$produto){		
			$updateComandaBar=self::getConn()->prepare("UPDATE comandas SET quantidade=? WHERE id_empresa=? AND comanda=? AND produto=?");
			if($updateComandaBar->execute(array($quantidade,$idEmpresa,$comanda,$produto))){
			return true;
			}else{
			return false;
			}
		}
		
		//BUSCA CLIENTE PARA BAR		
		static function clienteCmd($idEmpresa,$comanda){
			$selectProd=self::getConn()->prepare("SELECT nome,opc_entrada,consuma,vale_pedagio,valor_pedagio,ultima_compra,pagar_entrada,cmd_aberta_por,`id` FROM clientes WHERE id_empresa=? AND comanda=? LIMIT 1");
			$selectProd->execute(array($idEmpresa,$comanda));
			$c['num'] = $selectProd->rowCount();
			$c['dados'] = $selectProd->fetch(PDO::FETCH_NUM);
			return $c;
		}
		
		static function insertCmdClientes($comanda,$opc_entrada,$pagarEntrada,$consuma,$vale_pedagio,$val_pedagio,$idCliente,$aberta_por){
			$cadCmd=self::getConn()->prepare("UPDATE clientes SET comanda=?, opc_entrada=?, pagar_entrada=?, consuma=?, vale_pedagio=?, valor_pedagio=?, cmd_aberta_por=?, ultima_compra=NOW() WHERE id=?");
			if($cadCmd->execute(array($comanda,$opc_entrada,$pagarEntrada,$consuma,$vale_pedagio,$val_pedagio,$aberta_por,$idCliente))){
				return true;
			}else{
				return false;
			}
		}
        
		static function transferirCmd($idEmpresa,$idCmd,$idCliente){
			$pagaCmd=self::getConn()->prepare("DELETE FROM comandas WHERE comanda=? AND id_empresa=? AND idfechado=0");
			if($pagaCmd->execute(array($idCmd,$idEmpresa))){
				$apagaCmdCliente=self::getConn()->prepare("UPDATE clientes SET comanda=?, opc_entrada=?, consuma=0, vale_pedagio=?, valor_pedagio=?, cmd_aberta_por=? WHERE id_empresa=? AND comanda=? LIMIT 1");
				if($apagaCmdCliente->execute(array("","","","",0,$idEmpresa,$idCmd))){					
					$upDescontar=self::getConn()->prepare("UPDATE descontar SET idCMC=?, qualTBL=? WHERE id_empresa=? AND idCMC=? AND qualTBL=? AND idfechado=0");
					return ($upDescontar->execute(array($idCliente,"conta",$idEmpresa,$idCmd,"comanda")))?true:false;
				}else{
				return false;
				}
			}else{
			return false;
			}
		}
		
		//PAGAR CONTA CLIENTE DA COMANDA
		static function pagaTudoCmd($idEmpresa,$idCmd,$valCmd,$formaPagamento,$pagoCartao,$autoriza,$fechada_por,$sangria=false){
			$idComanda=explode('|',$idCmd);
			$cont=1;
			for($i=1;$i<count($idComanda);$i++){			
			$pagarComanda=self::getConn()->prepare("UPDATE comandas SET status=1 WHERE comanda=? AND id_empresa=? AND idfechado=0");
			if($pagarComanda->execute(array($idComanda[$i],$idEmpresa))){
			
			$pegarIdCliente=self::getConn()->prepare("SELECT id,consuma,opc_entrada,vale_pedagio,valor_pedagio,sexo,ultima_compra,pagar_entrada,cmd_aberta_por FROM clientes WHERE id_empresa=? AND comanda=? LIMIT 1");
			$pegarIdCliente->execute(array($idEmpresa,$idComanda[$i]));
			
			if($pegarIdCliente->rowCount()>0){
				$idCliente=$pegarIdCliente->fetch(PDO::FETCH_NUM);
				
				$apagaCmdCliente=self::getConn()->prepare("UPDATE clientes SET comanda=?, opc_entrada=?, consuma=0, vale_pedagio=?, valor_pedagio=?, cmd_aberta_por=? WHERE id=?");
				if($apagaCmdCliente->execute(array("","","","",0,$idCliente[0]))){					
					if($idCliente[7]==1){
						$valPago=$valCmd[$i]+$idCliente[2];
						if($formaPagamento==1){
						$pagoCartao+=$idCliente[2];
						}
					}else{
						$valPago=$valCmd[$i];
					}
					$pago_junto=($i==(count($idComanda)-1))?0:1;
					$insertCmdFechada=self::getConn()->prepare("INSERT INTO comandas_fechadas SET id_empresa=?, id_cliente=?, comanda=?, consuma=?, valor_entrada=?, vale_pedagio=?, valor_pedagio=?, cmd_aberta_por=?, forma_pagamento=?, valor_pago=?, pago_ou_cartao=?, autorizacao_cartao=?, sexo=?, pago_junto=?, data_aberta=?, cmd_fechada_por=?, cadastro=NOW()");
					if($insertCmdFechada->execute(array($idEmpresa,$idCliente[0],$idComanda[$i],$idCliente[1],$idCliente[2],$idCliente[3],$idCliente[4],$idCliente[8],$formaPagamento,$valPago,$pagoCartao,$autoriza,$idCliente[5],$pago_junto,$idCliente[6],$fechada_por))){
                        if($sangria==true){
                        $qualPago=($formaPagamento==1)?"pago_dinheiro=pago_dinheiro+?":"pago_cartao=pago_cartao+?";
                        $upSangria=self::getConn()->prepare("UPDATE abrir_fechar_caixa SET ".$qualPago." WHERE id_empresa=? AND funcionario=? AND status=0");
                        if($upSangria->execute(array($valPago,$idEmpresa,$fechada_por))){
                           $sangria=false; 
                        }else{
                            return false;
                            exit();
                        }
                        }
                         if($sangria==false){
						$idfechado=self::getConn()->prepare("SELECT `id` FROM comandas_fechadas WHERE id_empresa=? AND id_cliente=? AND comanda=? ORDER BY `id` DESC LIMIT 1");
						$idfechado->execute(array($idEmpresa,$idCliente[0],$idComanda[$i]));
						$idFecha=$idfechado->fetch(PDO::FETCH_NUM);
						$upComanda=self::getConn()->prepare("UPDATE comandas SET idfechado=? WHERE comanda=? AND id_empresa=? AND status=1 AND idfechado=0");
						if($upComanda->execute(array($idFecha[0],$idComanda[$i],$idEmpresa))){							
							$upDescontar=self::getConn()->prepare("UPDATE descontar SET idfechado=? WHERE id_empresa=? AND idCMC=? AND qualTBL=? AND idfechado=0");
							if($upDescontar->execute(array($idFecha[0],$idEmpresa,$idComanda[$i],'comanda'))){
							$cont++;
							}else{
							return false;
							exit();
							}
						}else{
						return false;
						exit();
						}
                        
                    }
					
					}else{
					return false;
					exit();
					}
				
				}else{
				return false;
				exit();
				}
				
			}else{
			return false;
			exit();
			}
			}
			}
			
			return ($cont==count($idComanda))?true:false;
			
		}
		
		//VALOR TOTAL DAS COMANDAS ABERTAS
		static function valorTotalCmd($idEmpresa,$sexo=false){
			if($sexo!=false){
			$compl=" AND sexo=?";
			$arCompl=array($idEmpresa,$sexo);
			}else{
			$compl="";
			$arCompl=array($idEmpresa);
			}
			$selCmd=self::getConn()->prepare("SELECT id,comanda,consuma,opc_entrada,vale_pedagio,valor_pedagio FROM clientes WHERE id_empresa=?".$compl." AND comanda!=''");
			$selCmd->execute($arCompl);
			$totalCmdTd=0;
			if($selCmd->rowCount()>0){				
				$trasCmd = self::getConn()->prepare("SELECT idcomanda,SUM(valor*quantidade) AS total FROM comandas WHERE comanda=? AND id_empresa=? AND status=0 AND idfechado=0 GROUP BY idcomanda");
				foreach($selCmd->fetchAll() as $dadosCmd){				
				$trasCmd->execute(array($dadosCmd['comanda'],$idEmpresa));				
				if($trasCmd->rowCount()>0){					
					$AsTrasCmd = $trasCmd->fetch(PDO::FETCH_ASSOC);					
					$totalCmd=$AsTrasCmd['total'];				
				}else{$totalCmd=0;}				
				if($dadosCmd['vale_pedagio']=="sim"){$totalCmd=$totalCmd-$dadosCmd['valor_pedagio'];}				
				$entrada=($dadosCmd['opc_entrada']=="")?0:$dadosCmd['opc_entrada'];				
				if($dadosCmd['consuma']==0){$totalCmd=$totalCmd+$entrada;}
				if($totalCmd<$entrada){$totalCmd = $entrada;}
				$totalCmdTd=$totalCmdTd+$totalCmd;
				}
			}			
			return $totalCmdTd;
		}
		
		//TRAZER COMANDAS EM ABERTO
		static function DataAbertoFechado($idEmpresa,$abertoFechado){
			$campo=($abertoFechado=='clientes')?"ultima_compra":"cadastro";
			$selCmd=self::getConn()->prepare("SELECT ".$campo." FROM ".$abertoFechado." WHERE id_empresa=? AND comanda!='' ORDER BY ".$campo." DESC LIMIT 1");
			$selCmd->execute(array($idEmpresa));
			$s['num'] = $selCmd->rowCount();
			$s['dados'] = $selCmd->fetch(PDO::FETCH_NUM);
			return $s;
		}
		
		//BUSCA COMANDA ABERTO
		static function buscaCmdAberta($busca,$id_empresa,$sexo=false,$entrada=false){
					$comp=($sexo!=false)?" AND sexo='$sexo'":"";
					if($entrada!=false){
						$comp.=($entrada=="free")?" AND opc_entrada='0.00'":" AND opc_entrada!='0.00'";
					}
					$explode = explode(" ",$busca);
					$numP = count($explode);
					$buscar = "";
					for($h=0;$h<$numP;$h++){						
						$buscar .= "(nome LIKE :buscar$h OR comanda LIKE :buscar$h OR cpf_ou_cnpj LIKE :buscar$h OR rg_ou_estadual LIKE :buscar$h OR telefone LIKE :buscar$h OR email LIKE :buscar$h)";
						if($h<>$numP-1){$buscar.= " AND ";}
					}
					$buscando = self::getConn()->prepare("SELECT * FROM clientes WHERE $buscar AND comanda!='' AND id_empresa=$id_empresa".$comp." ORDER BY ultima_compra DESC LIMIT 30");
					for($h=0;$h<$numP;$h++){
						 $buscando->bindValue(":buscar$h","%".$explode[$h]."%",PDO::PARAM_STR);
					 }
					 $buscando->execute();
					 $n['num']=$buscando->rowCount();
					 $n['dados']=$buscando->fetchAll();					
					 return $n;
		}
		
		//CONTAR COMANDAS EM ABERTO
		static function countCmdAberta($idEmpresa,$sexo=false,$datainicio=false,$datafinal=false,$entrada=false){
			if($sexo!=false){$compl=" AND sexo=?";$arCompl=array($idEmpresa,$sexo);}else{$compl="";$arCompl=array($idEmpresa);}
			if($entrada!=false){if($entrada=="free"){$compl.=" AND opc_entrada='0.00'";}else{$compl.=" AND opc_entrada!='0.00'";}}
			if($datainicio!=false AND $datafinal!=false){
			$dinicial=implode("-",array_reverse(explode("/",$datainicio)));
			$dfinal=implode("-",array_reverse(explode("/",$datafinal)));
			$complData=" AND (cast(ultima_compra as date) BETWEEN ('$dinicial') AND ('$dfinal')) ORDER BY ultima_compra DESC";
			}else{
			$complData="";
			}
			
			$selCmd=self::getConn()->prepare("SELECT `id` FROM clientes WHERE id_empresa=?".$compl." AND comanda!=''".$complData);
			$selCmd->execute($arCompl);
			return $selCmd->rowCount();		
		}
		
		//TRAZER COMANDAS EM ABERTO
		static function trazerCmdAberta($idEmpresa,$inicio,$maximo,$datainicio=false,$datafinal=false,$sexo=false,$entrada=false){
			if($sexo!=false){$compl=" AND sexo=?";$arCompl=array($idEmpresa,$sexo);}else{$compl="";$arCompl=array($idEmpresa);}
			if($entrada!=false){if($entrada=="free"){$compl.=" AND opc_entrada='0.00'";}else{$compl.=" AND opc_entrada!='0.00'";}}
			if($datainicio!=false AND $datafinal!=false){
				$dinicial=implode("-",array_reverse(explode("/",$datainicio)));
				$dfinal=implode("-",array_reverse(explode("/",$datafinal)));
				$complData=" AND (cast(ultima_compra as date) BETWEEN ('$dinicial') AND ('$dfinal'))";
			}else{
			$complData="";
			}
			$selCmd=self::getConn()->prepare("SELECT * FROM clientes WHERE id_empresa=? AND comanda!=''".$compl.$complData." ORDER BY ultima_compra DESC LIMIT ".$inicio.",".$maximo);
			$selCmd->execute($arCompl);
			$s['num'] = $selCmd->rowCount();
			$s['dados'] = $selCmd->fetchAll();
			return $s;
		}
		
		//TRAZER COMANDAS FECHADAS
		static function trazerCmdFechadas($idEmpresa,$inicio,$maximo,$datainicio=false,$datafinal=false,$sexo=false,$entrada=false){
			if($sexo!=false){$compleCmd=" AND sexo=?";$arrayComp=array($idEmpresa,$sexo);}else{$compleCmd="";$arrayComp=array($idEmpresa);}
			if($entrada!=false){ if($entrada=="free"){$compleCmd.=" AND valor_entrada='0.00'";}else{$compleCmd.=" AND valor_entrada!='0.00'";}}			
			if($datainicio!=false AND $datafinal!=false){
				$dinicial=implode("-",array_reverse(explode("/",$datainicio)));
				$dfinal=implode("-",array_reverse(explode("/",$datafinal)));
				$compleCmd.=" AND (cast(cadastro as date) BETWEEN ('$dinicial') AND ('$dfinal'))";
			}
			$selCmd=self::getConn()->prepare("SELECT * FROM comandas_fechadas WHERE id_empresa=?".$compleCmd." ORDER BY cadastro DESC LIMIT ".$inicio.",".$maximo);
			$selCmd->execute($arrayComp);
			$s['num'] = $selCmd->rowCount();
			$s['dados'] = $selCmd->fetchAll();
			return $s;
		}
		
		//TRAZER TODAS COMANDAS FECHADAS
		static function countCmdFechadas($idEmpresa,$recentes=false,$sexo=false,$ativaRelatorio=false,$datainicio=false,$datafinal=false,$entrada=false){
			if($sexo!=false){$compleCmd=" AND sexo=?";$arrayComp=array($idEmpresa,$sexo);}else{$compleCmd="";$arrayComp=array($idEmpresa);}			
			if($ativaRelatorio!=false){$compleCmd.=" AND status_sexo=1";}
			if($entrada!=false){ if($entrada=="free"){$compleCmd.=" AND valor_entrada='0.00'";}else{$compleCmd.=" AND valor_entrada!='0.00'";}}
			if($recentes==true){$compleCmd.=" AND status=1";}
			if($datainicio!=false AND $datafinal!=false){
			$dinicial=implode("-",array_reverse(explode("/",$datainicio)));
			$dfinal=implode("-",array_reverse(explode("/",$datafinal)));
			$compleCmd .=" AND (cast(cadastro as date) BETWEEN ('$dinicial') AND ('$dfinal'))";
			}
			$selCmd=self::getConn()->prepare("SELECT COUNT(id) AS count,SUM(valor_pago) AS total FROM comandas_fechadas WHERE id_empresa=?".$compleCmd);
			$selCmd->execute($arrayComp);
			return $selCmd->fetch(PDO::FETCH_ASSOC);
		}
		
		//BUSCA COMANDA FECHADO
		static function buscaCmdFechadas($busca,$id_empresa,$sexo=false,$entrada=false){
					$compleCmd=($sexo!=false)?" AND c.sexo='$sexo'":"";
					if($entrada!=false){ if($entrada=="free"){$compleCmd.=" AND c.valor_entrada='0.00'";}else{$compleCmd.=" AND c.valor_entrada!='0.00'";}}				
					$explode = explode(" ",$busca);
					$numP = count($explode);
					$buscar = "";
					for($h=0;$h<$numP;$h++){
						$buscar .= "(n.nome LIKE :buscar$h OR c.comanda LIKE :buscar$h OR n.cpf_ou_cnpj LIKE :buscar$h OR n.rg_ou_estadual LIKE :buscar$h OR n.telefone LIKE :buscar$h OR n.email LIKE :buscar$h)";
						if($h<>$numP-1){$buscar.= " AND ";}
					}
					$buscando=self::getConn()->prepare("SELECT c.*,n.nome FROM comandas_fechadas c INNER JOIN clientes n ON n.id=c.id_cliente WHERE $buscar AND c.id_empresa=$id_empresa".$compleCmd." ORDER BY c.cadastro DESC LIMIT 30");					
					for($h=0;$h<$numP;$h++){
						 $buscando->bindValue(":buscar$h","%".$explode[$h]."%",PDO::PARAM_STR);
					 }
					 $buscando->execute();
					 $n['num']=$buscando->rowCount();
					 $n['dados']=$buscando->fetchAll();
					 return $n;
		}
		
		//ZERAR COMANDAS FECHADAS RECENTEMENTES
		static function zerarRecentes($idEmpresa,$sexo=false){			
			$qualZera=($sexo==false)?'status':'status_sexo';
			$zeraCmd=self::getConn()->prepare("UPDATE comandas_fechadas SET ".$qualZera."=0 WHERE id_empresa=? AND ".$qualZera."=1");
			return ($zeraCmd->execute(array($idEmpresa)))?true:false;
		}
		
		//TRAZER COMANDA BAR
		static function trazesCmdBar($idEmpresa,$comanda,$idfechado=0){
		$buscado = self::getConn()->prepare("SELECT * FROM comandas WHERE comanda=? AND id_empresa=? AND idfechado=? ORDER BY `id` DESC");
		$buscado->execute(array($comanda,$idEmpresa,$idfechado));
		$c['num'] = $buscado->rowCount();
		$c['dados'] = $buscado->fetchAll();
		return $c;
		}
		
		//BUSCA PRODUTO PARA BAR
		static function produtosCmd($idEmpresa,$produto){
			$selectProd=self::getConn()->prepare("SELECT * FROM produtos WHERE id_empresa=? AND codigo_interno=? LIMIT 1");
			$selectProd->execute(array($idEmpresa,$produto));
			return $selectProd->fetch(PDO::FETCH_ASSOC);
		}
		
		//DELETAR COMANDA FECHADA
		static function deletarCmdFechada($id_empresa,$idComanda,$idCmdFechada){
			$delCmdFechada=self::getConn()->prepare("DELETE FROM comandas_fechadas WHERE id=?");
			if($delCmdFechada->execute(array($idCmdFechada))){
				$delCmd=self::getConn()->prepare("DELETE FROM comandas WHERE comanda=? AND id_empresa=? AND idfechado=?");
				return ($delCmd->execute(array($idComanda,$id_empresa,$idCmdFechada)))?true:false;
			}else{
			return false;
			}
		}
		
	}