<?php
	class Produtos extends DB{
	
		static function insertProdutos($idEmpresa,$marca,$descricao,$unidade,$categoria,$fornecedores,$quant,$codInterno,$valCompra,$margem,$valVarejo,$idOperador){
			
			$cadProdutos=self::getConn()->prepare("INSERT INTO produtos SET id_empresa=?, marca=?, descricao=?, unidade_venda=?, categoria=?, fornecedor=?, quantidade=?, codigo_interno=?, valor_compra=?, margem=?, valor_varejo=?, id_registrador=?, cadastro=NOW()");
			if($cadProdutos->execute(array($idEmpresa,$marca,$descricao,$unidade,$categoria,$fornecedores,$quant,$codInterno,$valCompra,$margem,$valVarejo,$idOperador))){
				return true;
			}else{
				return false;
			}
		}
		
		//BUSCA ESTOQUE
		static function buscaEstoque($idEmpresa,$codigo,$nomeProduto,$BusCategoria,$quant,$BuscValor){
		
		$nome = ($nomeProduto<>"") ? explode(' ',$nomeProduto) : array('');
		$valor = ($BuscValor<>"0.00" AND $BuscValor<>"") ? $BuscValor:'';
		$numP = count($nome);
			 $buscar = "";
		 for($hi=0;$hi<$numP;$hi++){
			 $buscar .= "(descricao LIKE :nome$hi OR marca LIKE :nome$hi OR unidade_venda LIKE :nome$hi)";
			 if($hi<>$numP-1){ $buscar .=" AND "; }
		 }
		 
		 $comple="";
		 if($BusCategoria<>""){ $comple.=" AND categoria LIKE '%".$BusCategoria."%'";}		 
		 if($quant<>""){ $comple.=" AND quantidade LIKE '%".$quant."%'"; }
		 if($valor<>""){ $comple.=" AND valor_varejo LIKE '%".$valor."%'"; }
		 if($codigo<>""){ $comple.=" AND codigo_interno LIKE '%".$codigo."%'"; }
		 
		 $buscado = self::getConn()->prepare("SELECT * FROM produtos WHERE $buscar".$comple." AND id_empresa='$idEmpresa' ORDER BY `id` DESC LIMIT 12");
		 
		 for($hi=0;$hi<$numP;$hi++){
			  $bnome = ($hi<count($nome)) ? $nome[$hi] : '';
			 $buscado->bindValue(":nome$hi",'%'.$bnome.'%',PDO::PARAM_STR);
		 }
		 $buscado->execute();
		 $c['num'] = $buscado->rowCount();
		 $c['dados'] = $buscado->fetchAll();
		 return $c;
		}
		
		//ALTERA PRODUTOS
		static function alteraProduto($idproduto,$marca,$descricao,$unidade,$categoria,$fornecedor,$quant,$codInterno,$valCompra,$margem,$valVarejo){
		
			$upProdutos=self::getConn()->prepare("UPDATE produtos SET marca=?, descricao=?, unidade_venda=?, categoria=?, fornecedor=?, quantidade=?, codigo_interno=?, valor_compra=?, margem=?, valor_varejo=? WHERE id=?");
			if($upProdutos->execute(array($marca,$descricao,$unidade,$categoria,$fornecedor,$quant,$codInterno,$valCompra,$margem,$valVarejo,$idproduto))){
				return true;
			}else{
				return false;
			}
		
		}
		
	}