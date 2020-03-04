<?php
	class FrenteCaixa extends DB{
	
		static function insertFrente($idEmpresa,$codInterno,$nomeProduto,$valorCompra,$valorUnit,$quantProduto,$idProduto,$funcionario,$desconto=false){
            $insertCx=self::getConn()->prepare("INSERT INTO frente_caixa SET id_empresa=?, codigo_interno=?, nome_produto=?, valor_compra=?, valor=?, quantidade=?, id_produto=?, funcionario=?, cadastro=NOW()");
			if($insertCx->execute(array($idEmpresa,$codInterno,$nomeProduto,$valorCompra,$valorUnit,$quantProduto,$idProduto,$funcionario))){
                
            $selFrente=self::getConn()->prepare("SELECT `id` FROM frente_caixa WHERE id_empresa=? AND funcionario=? AND id_fechada=0 ORDER BY `id` DESC LIMIT 1");
            $selFrente->execute(array($idEmpresa,$funcionario));
            $idFrente=$selFrente->fetch(PDO::FETCH_NUM);
                
                if($idProduto==0){
				return $idFrente[0];
                }else{				
                    $setAltera = self::getConn()->prepare("UPDATE produtos SET quantidade=quantidade-? WHERE id=? AND id_empresa=?");
                    return ($setAltera->execute(array($quantProduto,$idProduto,$idEmpresa)))?$idFrente[0]:false;
                }
            }else{
                return false;
                
            }   
                
		}
        
        static function updateFrente($idEmpresa,$valor,$quant,$idProduto,$funcionario){
            $qualTbl="";
            if($idProduto==0){
            $qualTbl=" valor_compra=?, valor=?,";
            $result = $valor/100;
			$valorCompra = $valor-(50*$result);
            $arra=array($valorCompra,$valor,$quant,$idProduto,$funcionario,$idEmpresa);
            }else{
            $arra=array($quant,$idProduto,$funcionario,$idEmpresa);    
            }
            
            $upCx=self::getConn()->prepare("UPDATE frente_caixa SET".$qualTbl." quantidade=quantidade+? WHERE id_produto=? AND funcionario=? AND id_empresa=? AND id_fechada=0 ORDER BY `id` DESC LIMIT 1");
			if($upCx->execute($arra)){
                if($idProduto==0){
				return true;
                }else{				
                    $setAltera = self::getConn()->prepare("UPDATE produtos SET quantidade=quantidade-? WHERE id=? AND id_empresa=?");
                    return ($setAltera->execute(array($quant,$idProduto,$idEmpresa)))?true:false;
                }
            }else{
                return false;
                
            }
		}
        
        static function selectFrente($idEmpresa,$funcionario,$ultimo=false){
            
            $limit=($ultimo==true)?" DESC LIMIT 1":"";            
            $selFrente=self::getConn()->prepare("SELECT * FROM frente_caixa WHERE id_empresa=? AND funcionario=? AND id_fechada=0 ORDER BY `id`".$limit);
            $selFrente->execute(array($idEmpresa,$funcionario));
            $s['num']=$selFrente->rowCount();
            $s['dados']=($ultimo==true)?$selFrente->fetch(PDO::FETCH_ASSOC):$selFrente->fetchAll();
            return $s;
        }
        
        
        static function deleteFrente($idEmpresa,$idDel,$funcionario,$quantidade,$idProduto){
            $delCx=self::getConn()->prepare("DELETE FROM frente_caixa WHERE id=? AND funcionario=? AND id_empresa=? AND id_fechada=0");
			if($delCx->execute(array($idDel,$funcionario,$idEmpresa))){
                if($idProduto==0){
				return true;
                }else{				
                    $setAltera = self::getConn()->prepare("UPDATE produtos SET quantidade=quantidade+? WHERE id=? AND id_empresa=?");
                    return ($setAltera->execute(array($quantidade,$idProduto,$idEmpresa)))?true:false;
                }
            }else{
                return false;                
            }
		}
        
        static function insertDescontarFrente($idEmpresa,$funcionario,$valor){
        $tabela="frente_caixa";
        $verDesc=self::getConn()->prepare("SELECT `id` FROM descontar WHERE id_empresa=? AND qualTBL=? AND garcon=? AND idfechado=0 ORDER BY `id` DESC LIMIT 1");
        $verDesc->execute(array($idEmpresa,$tabela,$funcionario));
        
            if($verDesc->rowCount()==0){
            $insertDescontar=self::getConn()->prepare("INSERT INTO descontar SET id_empresa=?, idCMC=0, qualTBL=?, garcon=?, valor=?, cadastro=NOW()");
            return ($insertDescontar->execute(array($idEmpresa,$tabela,$funcionario,$valor)))?true:false;
            }else{
            $upDescontar=self::getConn()->prepare("UPDATE descontar SET valor=?, cadastro=NOW() WHERE id_empresa=? AND qualTBL=? AND garcon=? AND idfechado=0");
            return ($upDescontar->execute(array($valor,$idEmpresa,$tabela,$funcionario)))?true:false;    
            }            
        }
        
        static function selDescontarFrente($idEmpresa,$funcionario){
            $tabela="frente_caixa";
            $verDesc=self::getConn()->prepare("SELECT * FROM descontar WHERE id_empresa=? AND qualTBL=? AND garcon=? AND idfechado=0 LIMIT 1");
            $verDesc->execute(array($idEmpresa,$tabela,$funcionario));
            $n['num']=$verDesc->rowCount();
            $n['dados']=$verDesc->fetch(PDO::FETCH_ASSOC);
            return $n;
        }
        
        static function deleteDescontar($idEmpresa,$funcionario){
            $delDesconto=self::getConn()->prepare("DELETE FROM descontar WHERE id_empresa=? AND qualTBL=? AND garcon=? AND idfechado=0");
			return ($delDesconto->execute(array($idEmpresa,'frente_caixa',$funcionario)))?true:false;
		}
        
        static function pagaFrente($idEmpresa,$formaPagamento,$valorPago,$dinheiroCartao,$autorizaCartao,$funcionario,$sangria=false){
            
            $insertFrete=self::getConn()->prepare("INSERT INTO frente_caixa_fechada SET id_empresa=?, forma_pagamento=?, valor_pago=?, pago_ou_cartao=?, autorizacao_cartao=?, frente_fechada_por=?, cadastro=NOW()");
			if($insertFrete->execute(array($idEmpresa,$formaPagamento,$valorPago,$dinheiroCartao,$autorizaCartao,$funcionario))){
                
                $selId=self::getConn()->prepare("SELECT `id` FROM frente_caixa_fechada WHERE id_empresa=? AND frente_fechada_por=? ORDER BY `id` DESC LIMIT 1");
                $selId->execute(array($idEmpresa,$funcionario));
                if($selId->rowCount()>0){
                    
                if($sangria==true){
                $qualPago=($formaPagamento==1)?"pago_dinheiro=pago_dinheiro+?":"pago_cartao=pago_cartao+?";
                $upSangria=self::getConn()->prepare("UPDATE abrir_fechar_caixa SET ".$qualPago." WHERE id_empresa=? AND funcionario=? AND status=0");
                if($upSangria->execute(array($valorPago,$idEmpresa,$funcionario))){
                   $sangria=false; 
                }else{
                    return false;
                }
                }
                    
                if($sangria==false){
                    $idFechado=$selId->fetch(PDO::FETCH_NUM);    
                    $upCx=self::getConn()->prepare("UPDATE frente_caixa SET id_fechada=? WHERE id_empresa=? AND funcionario=? AND id_fechada=0");
                    if($upCx->execute(array($idFechado[0],$idEmpresa,$funcionario))){
                    $upDesconto=self::getConn()->prepare("UPDATE descontar SET idfechado=? WHERE id_empresa=? AND qualTBL=? AND garcon=? AND idfechado=0");
                    return ($upDesconto->execute(array($idFechado[0],$idEmpresa,'frente_caixa',$funcionario)))?true:false;                
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
        
        static function transferirFrente($idEmpresa,$funcionario,$idCliente){
			$delFrente=self::getConn()->prepare("DELETE FROM frente_caixa WHERE id_empresa=? AND funcionario=? AND id_fechada=0");
			if($delFrente->execute(array($idEmpresa,$funcionario))){
                $upDescontar=self::getConn()->prepare("UPDATE descontar SET idCMC=?, qualTBL=? WHERE id_empresa=? AND qualTBL=? AND garcon=? AND idfechado=0");
                return ($upDescontar->execute(array($idCliente,"conta",$idEmpresa,"frente_caixa",$funcionario)))?true:false;
			}else{
			return false;
			}
		}
        
        static function selFrenteAberta($idEmpresa,$contar=true,$datainicio=false,$datafinal=false,$inicio=false,$maximo=false,$carTudo=false){
            $conLimit=($inicio==false AND $maximo==false)?"":" LIMIT ".$inicio.",".$maximo;
            $group="";
            if($datainicio!=false AND $datafinal!=false){
			$dinicial=implode("-",array_reverse(explode("/",$datainicio)));
			$dfinal=implode("-",array_reverse(explode("/",$datafinal)));
			$group.=" AND (cast(cadastro as date) BETWEEN ('$dinicial') AND ('$dfinal'))";
			}
            $group.=($contar==true)?" GROUP BY funcionario":"";
            $selAbertas=self::getConn()->prepare("SELECT *,SUM(valor*quantidade) as total FROM frente_caixa WHERE id_empresa=? AND id_fechada=0".$group.$conLimit);
            $selAbertas->execute(array($idEmpresa));
            $n['num']=$selAbertas->rowCount();
			$n['dados']=($datainicio==false AND $datafinal==false AND $carTudo==false)?$selAbertas->fetch(PDO::FETCH_ASSOC):$selAbertas->fetchAll();
			return $n;
        }
        
        //TRAZER TODAS FRENTES DE CAIXA FECHADAS
		static function countCaixasFechados($idEmpresa,$datainicio=false,$datafinal=false,$recentes=false){
			$compleCmd=($recentes==true)?" AND status=1":"";			
			if($datainicio!=false AND $datafinal!=false){
			$dinicial=implode("-",array_reverse(explode("/",$datainicio)));
			$dfinal=implode("-",array_reverse(explode("/",$datafinal)));
			$compleCmd .=" AND (cast(cadastro as date) BETWEEN ('$dinicial') AND ('$dfinal'))";
			}
			$selCmd=self::getConn()->prepare("SELECT COUNT(id) AS count,SUM(valor_pago) AS total FROM frente_caixa_fechada WHERE id_empresa=?".$compleCmd);
			$selCmd->execute(array($idEmpresa));
			return $selCmd->fetch(PDO::FETCH_ASSOC);
		}
        
        //TRAZER CAIXAS FECHADAS
		static function DataCaixaFechado($idEmpresa,$aberto="frente_caixa_fechada"){
			$selCmd=self::getConn()->prepare("SELECT cadastro FROM ".$aberto." WHERE id_empresa=? ORDER BY cadastro DESC LIMIT 1");
			$selCmd->execute(array($idEmpresa));
			$s['num'] = $selCmd->rowCount();
			$s['dados'] = $selCmd->fetch(PDO::FETCH_NUM);
			return $s;
		}
        
        //BUSCA CAIXAS FECHADA
		static function buscaCaixaFechadas($busca,$id_empresa,$fechado=true){
            
            if($fechado==true){
            $tbl="frente_caixa_fechada";
            $campo="frente_fechada_por";
            $campo1="";
            $campo2="";
            $group="";
            }else{
            $tbl="frente_caixa";
            $campo="funcionario";
            $campo1=", SUM(f.valor*f.quantidade) AS total";
            $campo2="AND f.id_fechada=0 ";
            $group="GROUP BY funcionario ";
            }
            
            $explode = explode(" ",$busca);
            $numP = count($explode);
            $buscar = "";
            for($h=0;$h<$numP;$h++){
                $buscar .= "(o.nome_operador LIKE :buscar$h OR o.codigo LIKE :buscar$h)";
                if($h<>$numP-1){$buscar.= " AND ";}
            }
            $buscando=self::getConn()->prepare("SELECT f.*".$campo1." FROM ".$tbl." f INNER JOIN operadores o ON o.codigo=f.".$campo." AND f.id_empresa=o.id_empresa WHERE $buscar AND f.id_empresa=$id_empresa ".$campo2.$group."ORDER BY f.cadastro DESC LIMIT 30");					
            for($h=0;$h<$numP;$h++){
                 $buscando->bindValue(":buscar$h","%".$explode[$h]."%",PDO::PARAM_STR);
             }
             $buscando->execute();
             $n['num']=$buscando->rowCount();
             $n['dados']=$buscando->fetchAll();
             return $n;
		}
        
        //TRAZER CAIXAS FECHADAS COM COMANDA
		static function trazerCaixasFechadas($idEmpresa,$inicio,$maximo,$datainicio=false,$datafinal=false){
			
			if($datainicio!=false AND $datafinal!=false){
				$dinicial=implode("-",array_reverse(explode("/",$datainicio)));
				$dfinal=implode("-",array_reverse(explode("/",$datafinal)));
				$compleCmd=" AND (cast(cadastro as date) BETWEEN ('$dinicial') AND ('$dfinal'))";
			}else{
			$compleCmd="";
			}
			
			$selCmd=self::getConn()->prepare("SELECT * FROM frente_caixa_fechada WHERE id_empresa=?".$compleCmd." ORDER BY cadastro DESC LIMIT ".$inicio.",".$maximo);
			$selCmd->execute(array($idEmpresa));
			$s['num'] = $selCmd->rowCount();
			$s['dados'] = $selCmd->fetchAll();
			return $s;
		}
        
        //TRAZER CAIXA PAGAR
		static function selCaixaPagar($idEmpresa,$funcionario,$idfechado=0){
			$selMesa=self::getConn()->prepare("SELECT * FROM frente_caixa WHERE id_empresa=? AND funcionario=? AND id_fechada=? ORDER BY `id` DESC");
			$selMesa->execute(array($idEmpresa,$funcionario,$idfechado));
			$s['num']=$selMesa->rowCount();
			$s['dados']=$selMesa->fetchAll();
			return $s;
		}
        
        //DELETAR MESA FECHADA
		static function deletarCaixaFechado($id_empresa,$idCmdFechada){
			$delCmdFechada=self::getConn()->prepare("DELETE FROM frente_caixa_fechada WHERE id=?");
			if($delCmdFechada->execute(array($idCmdFechada))){
				$delCmd=self::getConn()->prepare("DELETE FROM frente_caixa WHERE id_empresa=? AND id_fechada=?");
				if($delCmd->execute(array($id_empresa,$idCmdFechada))){
				return true;
				}else{
				return false;
				}
			}else{
			return false;
			}
		}
        
        //ZERAR CAIXAS FECHADAS RECENTEMENTES
		static function zerarRecentes($idEmpresa){			
			$zeraCmd=self::getConn()->prepare("UPDATE frente_caixa_fechada SET status=0 WHERE id_empresa=? AND status=1");
			return ($zeraCmd->execute(array($idEmpresa)))?true:false;
		}
        
		
	}