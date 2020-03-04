<?php
	class AbrirFecharCaixa extends DB{
        
		static function insertAbrirCaixa($idEmpresa,$troco,$valLimit,$funcionario,$reabrir=false){            
            if($reabrir==true){
                $reabrir=self::getConn()->prepare("SELECT * FROM abrir_fechar_caixa WHERE id_empresa=? AND funcionario=? AND status=1 ORDER BY `id` DESC LIMIT 1");
                $reabrir->execute(array($idEmpresa,$funcionario));
                if($reabrir->rowCount()>0){
                    $dataReabri=$reabrir->fetch(PDO::FETCH_ASSOC);
                        $idFechado=$dataReabri['id_fechado'];
                        if($dataReabri['troco']!=0) $troco=$dataReabri['troco'];
                        $altTroco=self::getConn()->prepare("UPDATE abrir_fechar_caixa SET troco=0 WHERE id_empresa=? AND funcionario=? AND status=1 AND id_fechado=?");
                        $altTroco->execute(array($idEmpresa,$funcionario,$idFechado));
                }else{
                    $idFechado=0;
                }                
            }else{
            $idFechado=0;
            }            
            $insertCx=self::getConn()->prepare("INSERT INTO abrir_fechar_caixa SET id_empresa=?, troco=?, limite_caixa=?, funcionario=?, id_fechado=?, cadastro=NOW()");
            return ($insertCx->execute(array($idEmpresa,$troco,$valLimit,$funcionario,$idFechado)))?true:false;
        }
        
        static function selAbrirCaixa($idEmpresa,$funcionario,$status=0){
            if($funcionario==false){
            $txtFunc="";
            $arra=array($idEmpresa,$status);
            }else{
            $txtFunc=" AND funcionario=?";
            $arra=array($idEmpresa,$funcionario,$status);
            }
            $selCx=self::getConn()->prepare("SELECT * FROM abrir_fechar_caixa WHERE id_empresa=?".$txtFunc." AND status=? LIMIT 1");
            $selCx->execute($arra);
            $n['num']=$selCx->rowCount();
            $n['dados']=$selCx->fetch(PDO::FETCH_ASSOC);
            return $n;
        }
        
        static function upValCaixa($idEmpresa,$formaPagamento,$valorCx,$funcionario){
            $tipoPaga=($formaPagamento=1)?"pago_dinheiro=pago_dinheiro+?":"pago_cartao=pago_cartao+?";
            
            $upCx=self::getConn()->prepare("UPDATE abrir_fechar_caixa SET ".$tipoPaga." WHERE id_empresa=? AND funcionario=? AND  status=0");
            if($upCx->prepare(array($valorCx,$idEmpresa,$funcionario))){
                
                $selCx=self::getConn()->prepare("SELECT * FROM abrir_fechar_caixa WHERE id_empresa=? AND funcionario=? AND status=0 ORBER BY `id` DESC LIMIT 1");
                $selCx->execute(array($idEmpresa,$funcionario));
                if($selCx->rowCount()>0){                 
                    return $selCx->fetch(PDO::FETCH_ASSOC);
                }else{
                    return false;
                }
                
            }else{
                return false;
            }
            
        }
        
        static function altStatus($idEmpresa,$funcionario){
            $alt=self::getConn()->prepare("UPDATE abrir_fechar_caixa SET status=1,data_fechado=NOW() WHERE id_empresa=? AND funcionario=? AND status=0");
            if($alt->execute(array($idEmpresa,$funcionario))){
                $reabrir=self::getConn()->prepare("SELECT * FROM abrir_fechar_caixa WHERE id_empresa=? AND funcionario=? AND status=1 ORDER BY `id` DESC LIMIT 1");
                $reabrir->execute(array($idEmpresa,$funcionario));
                if($reabrir->rowCount()>0){
                    $dataReabri=$reabrir->fetch(PDO::FETCH_ASSOC);
                   if($dataReabri['id_fechado']==0){
                    $altId=self::getConn()->prepare("UPDATE abrir_fechar_caixa SET id_fechado=? WHERE id_empresa=? AND funcionario=? AND status=1 AND id_fechado=0");
                    return($altId->execute(array($dataReabri['id'],$idEmpresa,$funcionario)))?true:false;
                   }else{
                       return true;
                   }
                }else{
                    return false;
                }
            }else{
                return false;
            }
        }
        
        static function reabrirCaixa($idEmpresa,$funcionario){
            $reabrir=self::getConn()->prepare("SELECT * FROM abrir_fechar_caixa WHERE id_empresa=? AND funcionario=? AND status=1 ORDER BY `id` DESC LIMIT 1");
            $reabrir->execute(array($idEmpresa,$funcionario));
            $r['num']=$reabrir->rowCount();
            $r['dados']=$reabrir->fetch(PDO::FETCH_ASSOC);
            return $r;
        }
        
        static function dadosCaixa($idEmpresa,$status=0,$datainicio=false,$datafinal=false,$inicio=false,$maximo=false,$recente=false){
            $conLimit=($inicio==false AND $maximo==false)?"":" LIMIT ".$inicio.",".$maximo;
            $group="";
            if($datainicio!=false AND $datafinal!=false){
			$dinicial=implode("-",array_reverse(explode("/",$datainicio)));
			$dfinal=implode("-",array_reverse(explode("/",$datafinal)));
			$group.=" AND (cast(cadastro as date) BETWEEN ('$dinicial') AND ('$dfinal'))";
			}
            if($recente==true)$group.=" AND status_recente=1";
            if($status==1)$group.=" GROUP BY id_fechado";
            $dadosCaixa=self::getConn()->prepare("SELECT * FROM abrir_fechar_caixa WHERE id_empresa=? AND status=?".$group.$conLimit);
            $dadosCaixa->execute(array($idEmpresa,$status));
            $d['num']=$dadosCaixa->rowCount();
            $d['dados']=$dadosCaixa->fetchAll();
            return $d;
        }
        
        static function valorCaixa($idEmpresa,$status=0,$funcFechado=false,$recente=false){
            if($funcFechado!=false){
                $comple=($status==0)?" AND funcionario=? GROUP BY funcionario":" AND id_fechado=? GROUP BY id_fechado";
                $array=array($idEmpresa,$status,$funcFechado);
            }else{
                $comple="";
                $array=array($idEmpresa,$status);
            }
            $recen=($recente==true)?" AND status_recente=1":"";
            $valCaixa=self::getConn()->prepare("SELECT SUM(pago_dinheiro+pago_cartao) as totalPago,SUM(troco) as totalTroco FROM abrir_fechar_caixa WHERE id_empresa=? AND status=?".$recen.$comple);
            $valCaixa->execute($array);
            if($valCaixa->rowCount()>0){
            return $valCaixa->fetch(PDO::FETCH_ASSOC);
            }else{
            $r['totalPago']=0;
            $r['totalTroco']=0;            
            return $r;
            }
        }
        
        //TRAZER ULTIMO CADASTRO FECHADAS
		static function DataCaixaFechado($idEmpresa,$status=0){
            $dataMostra=($status==0)?"cadastro":"data_fechado";
			$selCmd=self::getConn()->prepare("SELECT ".$dataMostra." FROM abrir_fechar_caixa WHERE id_empresa=? AND status=? ORDER BY cadastro DESC LIMIT 1");
			$selCmd->execute(array($idEmpresa,$status));
			$s['num'] = $selCmd->rowCount();
			$s['dados'] = $selCmd->fetch(PDO::FETCH_NUM);
			return $s;
		}
        
        //BUSCA CAIXAS FECHADA
		static function buscarCaixas($busca,$id_empresa,$status=0){
            
            $explode = explode(" ",$busca);
            $numP = count($explode);
            $buscar = "";
            for($h=0;$h<$numP;$h++){
                $buscar .= "(o.nome_operador LIKE :buscar$h OR o.codigo LIKE :buscar$h)";
                if($h<>$numP-1){$buscar.= " AND ";}
            }
            $buscando=self::getConn()->prepare("SELECT c.* FROM abrir_fechar_caixa c INNER JOIN operadores o ON o.codigo=c.funcionario AND c.id_empresa=o.id_empresa WHERE $buscar AND c.id_empresa=$id_empresa AND status=$status GROUP BY c.id_fechado ORDER BY c.id DESC LIMIT 30");					
            for($h=0;$h<$numP;$h++){
                 $buscando->bindValue(":buscar$h","%".$explode[$h]."%",PDO::PARAM_STR);
             }
             $buscando->execute();
             $n['num']=$buscando->rowCount();
             $n['dados']=$buscando->fetchAll();
             return $n;
		}
        
        static function selectCaixa($idEmpresa,$funcFechado,$status=0){
                $comple=($status==0)?"funcionario":"id_fechado";
            $selCaixa=self::getConn()->prepare("SELECT * FROM abrir_fechar_caixa WHERE id_empresa=? AND ".$comple."=? AND status=? ORDER BY `id`");
            $selCaixa->execute(array($idEmpresa,$funcFechado,$status));
            $s['num']=$selCaixa->rowCount();
            $s['dados']=$selCaixa->fetchAll();
            return $s;
        }
        
        static function descontarValor($idEmpresa,$funcionario,$formaPagamento,$valorPago){
            $comple=($formaPagamento==1)?"pago_dinheiro=pago_dinheiro-?":"pago_cartao=pago_cartao-?";
            $selCaixa=self::getConn()->prepare("UPDATE abrir_fechar_caixa SET ".$comple." WHERE id_empresa=? AND funcionario=? AND status=0");
            return ($selCaixa->execute(array($valorPago,$idEmpresa,$funcionario)))?true:false;
        }
        
        //ZERAR CAIXAS FECHADAS RECENTEMENTES
		static function zerarRecentes($idEmpresa){			
			$zeraCmd=self::getConn()->prepare("UPDATE abrir_fechar_caixa SET status_recente=0 WHERE id_empresa=? AND status=1 AND status_recente=1");
			return ($zeraCmd->execute(array($idEmpresa)))?true:false;
		}
        
        //DELETAR MESA FECHADA
		static function deletarCaixa($id_empresa,$idCmdFechada){
			$delCmdFechada=self::getConn()->prepare("DELETE FROM abrir_fechar_caixa WHERE id=?");
			return($delCmdFechada->execute(array($idCmdFechada)))?true:false;
		}
        
	}