<?php
	class Mesas extends DB{
		
		static function insertMesa($idEmpresa,$qMesa){		
			$insMesa=self::getConn()->prepare("UPDATE empresas SET cmd_mesa=? WHERE id=?");
			if($insMesa->execute(array($qMesa,$idEmpresa))){
			return true;
			}else{
			return false;
			}
		}
				
		static function selMesaAberta($idEmpresa,$datainicio=false,$datafinal=false,$inicio=false,$maximo=false){
            $compleCmd="";
			if($datainicio!=false AND $datafinal!=false){
			$dinicial=implode("-",array_reverse(explode("/",$datainicio)));
			$dfinal=implode("-",array_reverse(explode("/",$datafinal)));
			$compleCmd.=" AND (cast(cadastro as date) BETWEEN ('$dinicial') AND ('$dfinal'))";
			}
            $limit=($inicio!=false && $maximo!=false)?" LIMIT ".$inicio.",".$maximo:"";
            
			$selMesa=self::getConn()->prepare("SELECT *, SUM(quantidade*valor) AS total FROM cmd_mesa WHERE id_empresa=? AND idfechado=0 ".$compleCmd."GROUP BY cmd_mesa ORDER BY cmd_mesa".$limit);
			$selMesa->execute(array($idEmpresa));
			$s['num']=$selMesa->rowCount();
			$s['dados']=$selMesa->fetchAll();
			return $s;
		}
		
		//VALOR TOTAL MESAS EM ABERTO		
		static function valMesaAberta($idEmpresa){
			$valMesa=self::getConn()->prepare("SELECT SUM(quantidade*valor) AS total FROM cmd_mesa WHERE id_empresa=? AND idfechado=0");
			$valMesa->execute(array($idEmpresa));			
			$s=$valMesa->fetch(PDO::FETCH_ASSOC);
			return $s['total'];
		}
		
		//TRAZER COMANDA MESA BAR
		static function selMesaPagar($idEmpresa,$cmd_mesa,$idfechado=0,$group=false){
            if($group==true){                
            $agrupar=" GROUP BY cmd_mesa ORDER BY cmd_mesa";
            $sum=", SUM(valor*quantidade) AS total";
            }else{
            $agrupar=" ORDER BY `id` DESC";
            $sum="";
            }
			$selMesa=self::getConn()->prepare("SELECT *".$sum." FROM cmd_mesa WHERE id_empresa=? AND cmd_mesa=? AND idfechado=?".$agrupar);
			$selMesa->execute(array($idEmpresa,$cmd_mesa,$idfechado));
			$s['num']=$selMesa->rowCount();
			$s['dados']=$selMesa->fetchAll();
			return $s;
		}
		
		static function insertCmdMesa($idEmpresa,$garcon,$cmdMesa,$produto,$quantidade,$idproduto,$marca,$descricao,$valor){		
		$cadCmdMesa=self::getConn()->prepare("INSERT INTO cmd_mesa SET id_empresa=?, garcon=?, cmd_mesa=?, id_produto=?, cd_produto=?, marca=?, descricao=?, quantidade=?, valor=?, cadastro=NOW()");
		if($cadCmdMesa->execute(array($idEmpresa,$garcon,$cmdMesa,$idproduto,$produto,$marca,$descricao,$quantidade,$valor))){
				$baixaProduto=self::getConn()->prepare("UPDATE produtos SET quantidade=quantidade-? WHERE id_empresa=? AND codigo_interno=?");
				if($baixaProduto->execute(array($quantidade,$idEmpresa,$produto))){
				return true;
				}
			}else{
				return false;
			}
		}
		
		//PAGAR CONTA COMANDA MESA
		static function pagaTudoContaMesa($idEmpresa,$idCmd,$valCmd,$formaPagamento,$pagoCartao,$autoriza,$fechada_por,$dadosExtras,$sangria=false){
		$idComanda=explode('|',$idCmd);
		$serMesa=explode('|',$dadosExtras);
		$cont=1;
			for($i=1;$i<count($idComanda);$i++){
			$pagarComanda=self::getConn()->prepare("UPDATE cmd_mesa SET status=1 WHERE cmd_mesa=? AND id_empresa=? AND idfechado=0");
				if($pagarComanda->execute(array((int)$idComanda[$i],$idEmpresa))){
				$pago_junto=($i==(count($idComanda)-1))?0:1;
				$insertCmdFechada=self::getConn()->prepare("INSERT INTO mesas_fechadas SET id_empresa=?, cmd_mesa=?, forma_pagamento=?, valor_pago=?, pago_ou_cartao=?, autorizacao_cartao=?, tx_servico=?, pago_junto=?, cmd_fechada_por=?, cadastro=NOW()");
					if($insertCmdFechada->execute(array($idEmpresa,(int)$idComanda[$i],$formaPagamento,$valCmd[$i],$pagoCartao,$autoriza,$serMesa[$i],$pago_junto,$fechada_por))){
					$idfechado=self::getConn()->prepare("SELECT `id` FROM mesas_fechadas WHERE id_empresa=? AND cmd_mesa=? ORDER BY `id` DESC LIMIT 1");
					$idfechado->execute(array($idEmpresa,(int)$idComanda[$i]));
                        
                    if($sangria==true){
                        $qualPago=($formaPagamento==1)?"pago_dinheiro=pago_dinheiro+?":"pago_cartao=pago_cartao+?";
                        $upSangria=self::getConn()->prepare("UPDATE abrir_fechar_caixa SET ".$qualPago." WHERE id_empresa=? AND funcionario=? AND status=0");
                        if($upSangria->execute(array($valCmd[$i],$idEmpresa,$fechada_por))){
                           $sangria=false; 
                        }else{
                            return false;
                            exit();
                        }
                    }
                     if($sangria==false){   
					$idFecha=$idfechado->fetch(PDO::FETCH_NUM);
						$upComanda=self::getConn()->prepare("UPDATE cmd_mesa SET idfechado=? WHERE cmd_mesa=? AND id_empresa=? AND status=1 AND idfechado=0");
						if($upComanda->execute(array($idFecha[0],(int)$idComanda[$i],$idEmpresa))){
							$upDescontar=self::getConn()->prepare("UPDATE descontar SET idfechado=? WHERE id_empresa=? AND idCMC=? AND qualTBL=? AND idfechado=0");
							if($upDescontar->execute(array($idFecha[0],$idEmpresa,(int)$idComanda[$i],'mesa'))){
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
			}
			if($cont==count($idComanda)){
			return true;
			}else{
			return false;
			}
		}
		
		//TRAZER MESAS FECHADAS
		static function DataMesaFechado($idEmpresa,$tbl="mesas_fechadas"){
			$selCmd=self::getConn()->prepare("SELECT cadastro FROM ".$tbl." WHERE id_empresa=? ORDER BY cadastro DESC LIMIT 1");
			$selCmd->execute(array($idEmpresa));
			$s['num'] = $selCmd->rowCount();
			$s['dados'] = $selCmd->fetch(PDO::FETCH_NUM);
			return $s;
		}
		
		//TRAZER TODAS MESAS FECHADAS
		static function countMesasFechadas($idEmpresa,$datainicio=false,$datafinal=false,$recentes=false){			
			$compleCmd=($recentes==true)?" AND status=1":"";
			if($datainicio!=false AND $datafinal!=false){
			$dinicial=implode("-",array_reverse(explode("/",$datainicio)));
			$dfinal=implode("-",array_reverse(explode("/",$datafinal)));
			$compleCmd .=" AND (cast(cadastro as date) BETWEEN ('$dinicial') AND ('$dfinal'))";
			}
			$selCmd=self::getConn()->prepare("SELECT COUNT(id) AS count,SUM(valor_pago) AS total FROM mesas_fechadas WHERE id_empresa=?".$compleCmd);
			$selCmd->execute(array($idEmpresa));
			return $selCmd->fetch(PDO::FETCH_ASSOC);
		}
		
		//TRAZER MESAS FECHADAS COM COMANDA
		static function trazerMesasFechadas($idEmpresa,$inicio,$maximo,$datainicio=false,$datafinal=false){
			
			if($datainicio!=false AND $datafinal!=false){
				$dinicial=implode("-",array_reverse(explode("/",$datainicio)));
				$dfinal=implode("-",array_reverse(explode("/",$datafinal)));
				$compleCmd=" AND (cast(cadastro as date) BETWEEN ('$dinicial') AND ('$dfinal'))";
			}else{
			$compleCmd="";
			}
			
			$selCmd=self::getConn()->prepare("SELECT * FROM mesas_fechadas WHERE id_empresa=?".$compleCmd." ORDER BY cadastro DESC LIMIT ".$inicio.",".$maximo);
			$selCmd->execute(array($idEmpresa));
			$s['num'] = $selCmd->rowCount();
			$s['dados'] = $selCmd->fetchAll();
			return $s;
		}
		
		//BUSCA MESA FECHADA
		static function buscaMesaFechadas($busca,$id_empresa){
            $explode = explode(" ",$busca);
            $numP = count($explode);
            $buscar = "";
            for($h=0;$h<$numP;$h++){
                $buscar .= "(cmd_mesa LIKE :buscar$h)";
                if($h<>$numP-1){$buscar.= " AND ";}
            }
            $buscando=self::getConn()->prepare("SELECT * FROM mesas_fechadas WHERE $buscar AND id_empresa=$id_empresa ORDER BY cadastro DESC LIMIT 30");					
            for($h=0;$h<$numP;$h++){
                 $buscando->bindValue(":buscar$h","%".$explode[$h]."%",PDO::PARAM_STR);
             }
             $buscando->execute();
             $n['num']=$buscando->rowCount();
             $n['dados']=$buscando->fetchAll();
             return $n;
		}
		
		//DELETAR MESA FECHADA
		static function deletarMesaFechada($id_empresa,$idComanda,$idCmdFechada){
			$delCmdFechada=self::getConn()->prepare("DELETE FROM mesas_fechadas WHERE id=?");
			if($delCmdFechada->execute(array($idCmdFechada))){
				$delCmd=self::getConn()->prepare("DELETE FROM cmd_mesa WHERE cmd_mesa=? AND id_empresa=? AND idfechado=?");
				if($delCmd->execute(array($idComanda,$id_empresa,$idCmdFechada))){
				return true;
				}else{
				return false;
				}
			}else{
			return false;
			}
		}
		
		//ZERAR MESAS FECHADAS RECENTEMENTES
		static function zerarRecentes($idEmpresa){			
			$zeraCmd=self::getConn()->prepare("UPDATE mesas_fechadas SET status=0 WHERE id_empresa=? AND status=1");
			return ($zeraCmd->execute(array($idEmpresa)))?true:false;
		}
		
	}