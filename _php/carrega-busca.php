<?php
if(!isset($_SESSION)){session_start();}
include('../_classes/DB.class.php');
function getUrl(){ return 'http://localhost/myforadmin/';}
		if(!isset($_SESSION['Gerabar_uid']) || is_null($_SESSION['Gerabar_uid']) || empty($_SESSION['Gerabar_uid'])){
		include('../_classes/Login.class.php');
		$objLogin=new Login;
			if(!$objLogin->logado()){
			?>
			<script type="text/javascript">
            	$(function(){ red:window.location.href="<?php echo getUrl(); ?>"; });
            </script>
			<?php
			exit();
			}
		}
include("../_classes/Cadastros.class.php");
include("../_classes/formata_texto.php");
$idDaSessao = $_SESSION['Gerabar_uid'];
$table = $_SESSION['Gerabar_table'];
$idEmpre = Cadastros::selectIdEmpresa($idDaSessao,$table);
if($idEmpre['num']>0){
$id_empresa = $idEmpre['dados'][0];
}else{
$id_empresa = 0;
}
extract($_POST);
if(isset($_GET["busca_frente_caixa"])){
include("../_classes/remove_caracteres.php");
$buscaProd=Cadastros::buscaProdutoTopo($id_empresa,$_GET["busca_frente_caixa"],10);
if($buscaProd['num']>0){
	$n=0;
	foreach($buscaProd['dados'] as $asBuscaProd){
		echo '<li'; if($n==0){ echo ' class="bAtivo"'; $n++; } echo '>
                '.$asBuscaProd['codigo_interno'].' - <span class="'.$asBuscaProd['codigo_interno'].'|'.$asBuscaProd['id'].'|'.number_format($asBuscaProd['valor_varejo'],2,',','.').'|'.$asBuscaProd['valor_compra'].'">'.limitiCaract($asBuscaProd['marca'].' '.$asBuscaProd['descricao'],30,false,false).'</span>
            </li>';		
	}
}
    
}elseif(isset($_GET["qualCad"])){ 
				extract($_GET);
                
				if($qualCad=="mesas-fechadas" || $qualCad=="mesas-abertas"){
				include("../_classes/Mesas.class.php");
				}elseif($qualCad=="vendas-fechadas" || $qualCad=="vendas-abertas"){
				include("../_classes/FrenteCaixa.class.php");	
				}elseif($qualCad=="caixas-fechados" || $qualCad=="caixas-abertos"){
				include("../_classes/AbrirFecharCaixa.class.php");	
                $status=($qualCad=="caixas-abertos")?0:1;
				}elseif($qualCad=="contas-fechadas" || $qualCad=="contas-abertas"){
				include("../_classes/Clientes.class.php");	
				}else{
				include("../_classes/Comandas.class.php");
				}
				
				$dataInicial=false;
				$dataFinal=false;
				$entSex="";
				
				if($qualCad!="mesas-abertas" && $qualCad!="mesas-fechadas" && $qualCad!="vendas-fechadas" && $qualCad!="vendas-abertas" && $qualCad!="caixas-fechados" && $qualCad!="caixas-abertos"){
					if($sexo!="todas"){$entSex="&sexo=".$sexo; $enSexo=$sexo;}else{ $enSexo=false;}
					if($qualCad!="contas-fechadas" AND $qualCad!="contas-abertas" AND $entrada!="todas"){$entSex.="&entrada=".$entrada; $enEntra=$entrada;}else{ $enEntra=false;}
				}
				
				if($qualvai=="busca"){
				$linkData=$entSex."";
				}elseif($qualvai=="data"){
					if($var1!="" AND $var2!=""){
					$dataInicial=$var1;
					$dataFinal=$var2;
					}else{						
						if($qualCad=="contas-abertas"){
						$trasData=Clientes::DataContaAbertoFechado($id_empresa,"conta_clientes");
						$qtMes=90;
						}elseif($qualCad=="contas-fechadas"){
						$trasData=Clientes::DataContaAbertoFechado($id_empresa,"conta_clientes_fechadas");
						$qtMes=30;
						}elseif($qualCad=="mesas-fechadas"){
						$trasData=Mesas::DataMesaFechado($id_empresa);
						$qtMes=30;
						}elseif($qualCad=="vendas-fechadas"){
						$trasData=FrenteCaixa::DataCaixaFechado($id_empresa);
						$qtMes=30;
						}elseif($qualCad=="vendas-abertas"){
						$trasData=FrenteCaixa::DataCaixaFechado($id_empresa,"frente_caixa");
						$qtMes=1;
						}elseif($qualCad=="caixas-abertos" || $qualCad=="caixas-fechados"){
                        $trasData=AbrirFecharCaixa::DataCaixaFechado($id_empresa,$status);
						$qtMes=30;
						}elseif($qualCad=="mesas-abertas"){
                        $trasData=Mesas::DataMesaFechado($id_empresa,"cmd_mesa");
						$qtMes=1;    
                        }else{
							if($qualCad=="comandas-abertas"){
							$ondeData="clientes";
							$qtMes=1;
							}else{
							$ondeData="comandas_fechadas";
							$qtMes=30;
							}
							$trasData=Comandas::DataAbertoFechado($id_empresa,$ondeData);
						}
						
						$dataFinal=date('d/m/Y',strtotime($trasData['dados'][0]));
						$valData=explode('/',$dataFinal);
						$dataInicial = date('d/m/Y',mktime(0,0,0,$valData[1],$valData[0]-$qtMes,$valData[2]));
						
					}
					$linkData=$entSex."&dataInicial=".$dataInicial."&dataFinal=".$dataFinal;
				}else{
				$linkData=$entSex."&tudo=true";
				}
				if($qualvai=="busca"){
					if($qualCad=="contas-abertas"){
					$trasDadosForm=Clientes::buscaListaConta($var1,$id_empresa,$enSexo);
					}elseif($qualCad=="contas-fechadas"){
					$cmdFechadas=Clientes::buscaContaFechadas($var1,$id_empresa,$enSexo);
					}elseif($qualCad=="comandas-abertas"){
					$cmdAbertas=Comandas::buscaCmdAberta($var1,$id_empresa,$enSexo,$enEntra);
					}elseif($qualCad=="mesas-fechadas"){
					$cmdFechadas=mesas::buscaMesaFechadas($var1,$id_empresa);
					}elseif($qualCad=="vendas-fechadas"){
					$cmdFechadas=FrenteCaixa::buscaCaixaFechadas($var1,$id_empresa);
                    $acres='../';
					}elseif($qualCad=="vendas-abertas"){
					$cmdAbertas=FrenteCaixa::buscaCaixaFechadas($var1,$id_empresa,false);
                    $acres='../';
					}elseif(isset($status)){
                    $cmdFechadas=AbrirFecharCaixa::buscarCaixas($var1,$id_empresa,$status);
                    $acres='../';
					}elseif($qualCad=="mesas-abertas"){
					$cmdAbertas=Mesas::selMesaPagar($id_empresa,$var1);
					}else{
					$cmdFechadas=Comandas::buscaCmdFechadas($var1,$id_empresa,$enSexo,$enEntra);
					}
					$count=0;
					$pgs=0;
				}else{
				$pagina = 1;
				$maximo = 30;
				$inicio = $pagina - 1;
				$inicio = $maximo * $inicio;
				$menos = $pagina - 1;
				$mais = $pagina + 1;
					if($qualCad=="contas-abertas"){
						$count=Clientes::listaConta($id_empresa,false,false,$dataInicial,$dataFinal,$enSexo);	
						$pgs = ceil($count['num']/$maximo);
						$trasDadosForm = Clientes::listaConta($id_empresa,$inicio,$maximo,$dataInicial,$dataFinal,$enSexo);
						$count=$count["num"];
					}elseif($qualCad=="contas-fechadas"){
						$count=Clientes::countContaFechadas($id_empresa,$enSexo,$dataInicial,$dataFinal);
						$pgs = ceil($count["count"]/$maximo);
						$cmdFechadas=Clientes::trazerContaFechadas($id_empresa,$inicio,$maximo,$dataInicial,$dataFinal,$enSexo);
						$count=$count["count"];
					}elseif($qualCad=="mesas-fechadas"){
						$count=Mesas::countMesasFechadas($id_empresa,$dataInicial,$dataFinal);
						$pgs = ceil($count['count']/$maximo);
						$cmdFechadas=Mesas::trazerMesasFechadas($id_empresa,$inicio,$maximo,$dataInicial,$dataFinal);
						$count=$count["count"];
					}elseif($qualCad=="vendas-fechadas"){
						$count=FrenteCaixa::countCaixasFechados($id_empresa,$dataInicial,$dataFinal);
						$pgs = ceil($count['count']/$maximo);
						$cmdFechadas=FrenteCaixa::trazerCaixasFechadas($id_empresa,$inicio,$maximo,$dataInicial,$dataFinal);
						$count=$count["count"];
                        $acres='../';
					}elseif($qualCad=="vendas-abertas"){
						$count=FrenteCaixa::selFrenteAberta($id_empresa,true,$dataInicial,$dataFinal);
						$pgs = ceil($count['num']/$maximo);
						$cmdAbertas=FrenteCaixa::selFrenteAberta($id_empresa,true,$dataInicial,$dataFinal,$inicio,$maximo,true);
						$count=$count["num"];
                        $acres='../';
					}elseif(isset($status)){
                        $count=AbrirFecharCaixa::dadosCaixa($id_empresa,$status,$dataInicial,$dataFinal);
						$pgs = ceil($count['num']/$maximo);
                        $cmdFechadas=AbrirFecharCaixa::dadosCaixa($id_empresa,$status,$dataInicial,$dataFinal,$inicio,$maximo);
						$count=$count["num"];
                        $acres='../';
					}elseif($qualCad=="mesas-abertas"){                        
						$count=Mesas::selMesaAberta($id_empresa,$dataInicial,$dataFinal);
						$pgs = ceil($count['num']/$maximo);
						$cmdAbertas=Mesas::selMesaAberta($id_empresa,$dataInicial,$dataFinal,$inicio,$maximo);
						$count=$count["num"];
					}elseif($qualCad=="comandas-abertas"){
						$count=Comandas::countCmdAberta($id_empresa,$enSexo,$dataInicial,$dataFinal,$enEntra);
						$pgs = ceil($count/$maximo);
						$cmdAbertas=Comandas::trazerCmdAberta($id_empresa,$inicio,$maximo,$dataInicial,$dataFinal,$enSexo,$enEntra);
					}else{
						$count=Comandas::countCmdFechadas($id_empresa,false,$enSexo,false,$dataInicial,$dataFinal,$enEntra);
						$pgs = ceil($count["count"]/$maximo);
						$cmdFechadas=Comandas::trazerCmdFechadas($id_empresa,$inicio,$maximo,$dataInicial,$dataFinal,$enSexo,$enEntra);
						$count=$count["count"];
					}
				}		
				echo '<span style="display:none;" id="trasContBusca">'.$count.'</span>';
				
				
				if($qualCad=="contas-abertas"){
				
					if($trasDadosForm['num']>0){
						$user_id_empresa=$id_empresa;
						// Cria uma função que retorna o timestamp de uma data no formato DD/MM/AAAA
						function geraTimestamp($data) {
						$partes = explode('/', $data);
						return mktime(0, 0, 0, $partes[1], $partes[0], $partes[2]);
						}
						include("../_classes/remove_caracteres.php");
						include("../_include/lista-conta.php");				
					}else{
						echo '<div class="tudo_cmd_vazio"><h1>';
							if($qualvai=="busca"){
							echo 'Nada foi encontrado em sua busca !';
							}else{
							echo 'Nada foi encontrado !';
							}					
						echo '</h1></div>';
					  }
				
				}elseif($qualCad=="comandas-abertas" || $qualCad=="vendas-abertas" || $qualCad=="mesas-abertas"){
				if($cmdAbertas['num']>0){
				$idEmpresa=$id_empresa;
                $pgOndefiltra=$qualCad;
				include("../_include/lista-comandas-abertas.php"); 
				}else{
				echo '<div class="tudo_cmd_vazio"><h1>';
					if($qualvai=="busca"){
					echo 'Nada foi encontrado em sua busca !';
					}else{
					echo 'Página não encontrada !';
					}					
				echo '</h1></div>';
				 }
				 
				}else{					
				  if($cmdFechadas['num']>0){
				  include('../_include/lista-comandas-fechadas.php');	
				  }else{
					echo '<div class="tudo_cmd_vazio"><h1>';
						if($qualvai=="busca"){
						echo 'Nada foi encontrado em sua busca !';
						}else{
						echo 'Nada foi encontrado !';
						}					
					echo '</h1></div>';
				  }				
		}
				
}elseif(isset($qualBusca)){
	
	if($qualBusca=="unidades"){
		$selTabela = 'unidade_venda';		
	}else{
		$selTabela=$qualBusca;
	}
	
	if(isset($busca) AND $busca!=""){
		$buscado = Cadastros::buscaArray($selTabela,$busca,$id_empresa);
		if($buscado['num']>0){
			$num = 1;
			foreach($buscado['dados'] as $AsBusca){
			echo '<li>
					<label>
					<input type="checkbox" class="check-del" id="loop-'.$num.'" value="'.$AsBusca['id'].'" />
					<span class="s_lista_del">';					
					if($selTabela=="entradas"){
					echo $AsBusca[$selTabela].' - R$ '.number_format($AsBusca['valor_entrada'],2,',','.');			
					echo ($AsBusca['consuma']==1)?' consuma':'';
					}else{					
					echo $AsBusca[$selTabela];
					}					
					echo '</span>
					</label>
					<span class="s_excluir_del">[<a href="javascript:void(0);" class="'.$AsBusca['id'].'">excluir</a>]</span>
				</li>';
				$num+=1;
			}
		}else{
		echo '<li class="nadaDel"><span>nada foi encontrado em sua busca !</span></li>';
		}
	}else{
		
		if(isset($delet)){		
			if(Cadastros::deleteCadArray($delet,$selTabela)==false){
				echo '<li class="nadaDel"><span>Ocorreu um erro ao tentar deletar !</span></li>';
				exit();
			}
		}elseif(isset($arraDel) && !empty($arraDel)){
			$conta = count($arraDel);
			
			for($i=0; $i<$conta; $i++){
				if(Cadastros::deleteCadArray($arraDel[$i],$selTabela)==false){
				echo '<li class="nadaDel"><span>Ocorreu um erro ao tentar deletar !</span></li>';
				exit();
				}
			}
			
		}
		
		$count = Cadastros::countArray($id_empresa,$selTabela);	
		if($count>0){
		
			$maximo = 8;
			$inicio = (int)$pagina - 1;
			$inicio = $maximo * $inicio;
			
		$carDel = Cadastros::selectArray($id_empresa,$selTabela,$inicio,$maximo);
		if($carDel['num']>0){
		$num = 1;
		foreach($carDel['dados'] as $asCarDel){
			echo '<li>
					<label>
					<input type="checkbox" class="check-del" id="loop-'.$num.'" value="'.$asCarDel['id'].'" />
					<span class="s_lista_del">';					
					if($selTabela=="entradas"){
					echo $asCarDel[$selTabela].' - R$ '.number_format($asCarDel['valor_entrada'],2,',','.');			
					echo ($asCarDel['consuma']==1)?' consuma':'';
					}else{					
					echo $asCarDel[$selTabela];
					}					
					echo '</span>
					</label>
					<span class="s_excluir_del">[<a href="javascript:void(0);" class="'.$asCarDel['id'].'">excluir</a>]</span>
				</li>';
				$num+=1;
			}
		
		}else{
			echo '<li class="nadaDel"><span>Página não encontrada !</span></li>';
		}
		
		}else{
			echo '<li class="nadaDel"><span>não tem '.$qualBusca.' cadastras !</span></li>';
		}
	}
}elseif(isset($codigo) OR isset($deletar) OR isset($pagEstoque)){

	if(isset($pagEstoque) OR isset($deletar) OR ($codigo=="" AND $nome=="" AND $categoria=="" AND $quant=="" AND ($valor=="" OR $valor=="0.00"))){
		
		if($qualPg=="estoque"){
		$qualAbre = 'produtos';
		}else{
		$qualAbre = 'clientes';
		}
		
		if(isset($deletar) AND !empty($deletar)){
			$conta = count($deletar);            
            if($qualAbre=="clientes"){
                for($i=0; $i<$conta; $i++){                    
                    if(Cadastros::clienteComConta($id_empresa,$deletar[$i])==true){
                        echo 'Cliente com código '.$deletar[$i].' não pode ser excluído !</br> Está com conta aberta em seu nome.|error';
                        exit();
                    }
                }
            }
			for($i=0; $i<$conta; $i++){
                if(Cadastros::deleteCadArray($deletar[$i],$qualAbre)==false){
                echo 'Ocorreu um erro ao tentar deletar !|error';
                exit();
                }
			}	
		}
		
		$count = Cadastros::countArray($id_empresa,$qualAbre);	
		if($count>0){
		
			$maximo = 12;
			$inicio = (int)$pagina - 1;
			$inicio = $maximo * $inicio;
			
			$prodCliente = Cadastros::selectArray($id_empresa,$qualAbre,$inicio,$maximo);
			if($prodCliente['num']>0){
				$num=0;
				
			if($qualPg=="estoque"){
				
				foreach($prodCliente['dados'] as $asProdutos){
				$num+=1;
				echo '<li class="'.$asProdutos['id'].'">
            	<div class="alinha_estoque_0"><div class="ali_borda"><input type="checkbox" id="lop-'.$num.'" value="'.$asProdutos['id'].'" /></div></div>
                <div class="alinha_estoque_1"><div class="ali_borda"><p>'.$asProdutos['codigo_interno'].'</p></div></div>
                <div class="alinha_estoque_2"><div class="ali_borda"><p>'.limitiCaract($asProdutos['marca'].' '.$asProdutos['descricao'].' ('.$asProdutos['unidade_venda'].')',52).'</p></div></div>
				<div class="alinha_estoque_3"><div class="ali_borda"><p>'.limitiCaract($asProdutos['categoria'],44).'</p></div></div>
                <div class="alinha_estoque_4"><div class="ali_borda"><p>'.$asProdutos['quantidade'].'</p></div></div>
                <div class="alinha_estoque_5"><div class="ali_borda"><p>r$ '.number_format($asProdutos['valor_varejo'],2,',','.').'</p></div></div>
                <div class="alinha_estoque_6"><div class="ali_borda"><p><span>[ <a href="javascript:void(0);" class="editaEstCli">editar</a> ]</span> <span>[ <a href="javascript:void(0);" class="deletarEstoque">excluir</a> ]</span></p></div></div>
            	</li>';				
				}
			
			}else{
			
				foreach($prodCliente['dados'] as $asClientes){
				$num+=1;
				echo '<li class="'.$asClientes['id'].'">
            	<div class="alinha_clientes_0"><input type="checkbox" id="lop-'.$num.'" value="'.$asClientes['id'].'" /></div>
                <div class="alinha_clientes_1"><p>'.$asClientes['id'].'</p></div>
				<div class="alinha_clientes_2"><p>'.limitiCaract($asClientes['nome'],50).'</p></div>
                <div class="alinha_clientes_3">
					<p class="p_fone p_tel">'; if($asClientes['telefone']<>""){ echo $asClientes['telefone']; } echo '</p>
				</div>
				<div class="alinha_clientes_4">';
				if($asClientes['comanda']<>""){
				echo '<p class="num_cmd_cliente"><a href="'.getUrl().'caixa.php?cad=comanda-cliente&fecharcomanda='.$asClientes['comanda'].'">'.$asClientes['comanda'].'</a></p>';
				}else{
				echo '<p>sem comanda</p>';
				}
				echo '</div>
                <div class="alinha_clientes_5"><p>[ <a href="javascript:void(0);" class="editaEstCli">editar</a> ] [ <a href="javascript:void(0);" class="deletarClientes">excluir</a> ]</p></div>
            </li>';
				}
			
			}
			
			}else{
			echo '<li class="msgErroBusca">página não encotrada !</li>';
			}
				
			}else{
			echo '<li id="msgErroBusca">não tem mais '.$qualAbre.' cadastrado !</li>';
			}
	}else{
		$num=0;
		if($qualPg=="estoque"){
		
		include("../_classes/Produtos.class.php");
		$buscado = Produtos::buscaEstoque($id_empresa,$codigo,$nome,$categoria,$quant,$valor);
		if($buscado['num']>0){

			foreach($buscado['dados'] as $AsBusca){
			$num+=1;
			echo '<li class="'.$AsBusca['id'].'">
            	<div class="alinha_estoque_0"><div class="ali_borda"><input type="checkbox" id="lop-'.$num.'" value="'.$AsBusca['id'].'" /></div></div>
                <div class="alinha_estoque_1"><div class="ali_borda"><p>'.$AsBusca['codigo_interno'].'</p></div></div>
                <div class="alinha_estoque_2"><div class="ali_borda"><p>'.limitiCaract($AsBusca['marca'].' '.$AsBusca['descricao'].' ('.$AsBusca['unidade_venda'].')',52).'</p></div></div>
                <div class="alinha_estoque_3"><div class="ali_borda"><p>'.limitiCaract($AsBusca['categoria'],44).'</p></div></div>
                <div class="alinha_estoque_4"><div class="ali_borda"><p>'.$AsBusca['quantidade'].'</p></div></div>
                <div class="alinha_estoque_5"><div class="ali_borda"><p>r$ '.number_format($AsBusca['valor_varejo'],2,',','.').'</p></div></div>
                <div class="alinha_estoque_6"><div class="ali_borda"><p><span>[ <a href="javascript:void(0);" class="editaEstCli">editar</a> ]</span> <span>[ <a href="javascript:void(0);" class="deletarEstoque">excluir</a> ]</span></p></div></div>
            	</li>';
			}
		}else{
		echo '<li id="msgErroBusca">nada foi encontrado em sua busca !</li>';
		}
		
		}else{
		include("../_classes/Clientes.class.php");
		
		$buscado = Clientes::buscaCliente($id_empresa,$codigo,$nome,$categoria,$quant);
		if($buscado['num']>0){
			foreach($buscado['dados'] as $asClientes){
				$num+=1;
				echo '<li class="'.$asClientes['id'].'">
            	<div class="alinha_clientes_0"><input type="checkbox" id="lop-'.$num.'" value="'.$asClientes['id'].'" /></div>
                <div class="alinha_clientes_1"><p>'.$asClientes['id'].'</p></div>
				<div class="alinha_clientes_2"><p>'.limitiCaract($asClientes['nome'],50).'</p></div>
                <div class="alinha_clientes_3"><p class="p_fone p_tel">'.$asClientes['telefone'].'</p></div>
				<div class="alinha_clientes_4">';
				if($asClientes['comanda']<>""){
				echo '<p class="num_cmd_cliente"><a href="'.getUrl().'caixa.php?cad=comanda-cliente&fecharcomanda='.$asClientes['comanda'].'">'.$asClientes['comanda'].'</a></p>';
				}else{
				echo '<p>sem comanda</p>';
				}
				echo '</div>
				<div class="alinha_clientes_5">
					<p>
						<span>[ <a href="javascript:void(0);" class="editaEstCli">editar</a> ]</span> 
						<span>[ <a href="javascript:void(0);" class="deletarClientes">excluir</a> ]</span>
					</p>
				</div>
            </li>';
			}
		}else{
		echo '<li id="msgErroBusca">nada foi encontrado em sua busca !</li>';
		}
		
		}
	}
	
}elseif(isset($_GET["busca_geral_topo"])){
extract($_GET);
$liberarPg=explode(',',$liberarPg);
if(count($liberarPg)==0){$liberarPg=array(0);}
include("../_classes/remove_caracteres.php");
$buscaProd=Cadastros::buscaProdutoTopo($id_empresa,$busca_geral_topo);
if($buscaProd['num']>0){
	foreach($buscaProd['dados'] as $asBuscaProd){
		echo '<li class="li_produto_busc">
		<div>
		<h1>'.$asBuscaProd['codigo_interno'].' - '.limitiCaract($asBuscaProd['marca'].' '.$asBuscaProd['descricao'],30,false,false).'</h1><h2>R$ '.number_format($asBuscaProd['valor_varejo'],2,',','.').'</h2>
		</div>';
		if(in_array(1,$liberarPg) || in_array("comanda_bar",$liberarPg)){
		echo '<span><a href="'.getUrl().'comanda-bar.php?cad=lancar-comanda&idproduto='.$asBuscaProd['codigo_interno'].'" class="lanca-comanda" id="'.$asBuscaProd['codigo_interno'].'-codinterno">lançar em comanda</a></span>';
		}else{
		echo '<span></span>';
		}
		echo '</li>';
	}
}

include("../_classes/Clientes.class.php");
$buscCliente=Clientes::buscaClienteCmd($id_empresa,$busca_geral_topo,5);
if($buscCliente['num']>0){
	foreach($buscCliente['dados'] as $asBuscCliente){
		echo '<li class="li_cliente_busc">
		<div><h1>'.limitiCaract($asBuscCliente['nome'],32,false,false).'</h1><h2 class="'.$asBuscCliente['id'].'">';
		if($asBuscCliente['comanda']==""){
		echo '<span>sem comanda</span>';
		}else{		
			if(in_array(1,$liberarPg) || in_array("comanda_bar",$liberarPg)){
			echo '<a href="'.getUrl().'comanda-bar.php?cad=lancar-comanda&idcomanda='.$asBuscCliente['comanda'].'" title="comanda" class="lanca-comanda" id="'.$asBuscCliente['comanda'].'-cmdcliente">Comanda: '.$asBuscCliente['comanda'].'</a>';
			}else{
			echo '<span>Comanda: '.$asBuscCliente['comanda'].'</span>';	
			}
		}
		echo '</h2></div>';
		if(in_array(1,$liberarPg) || in_array("abrir_caixa",$liberarPg)){
		echo '<span '; if(in_array(1,$liberarPg) || in_array("contas_clientes",$liberarPg)){ echo 'class="s_busc_pri"'; } echo '>';	
		if($asBuscCliente['comanda']!=""){
		echo '<a href="javascript:void(0);" class="a_cmd_aberto" id="'.$asBuscCliente['comanda'].'-cmdFechaTopo">fechar comanda</a>';
		}else{
		echo '<a href="javascript:void(0);" class="a_abrir_cmd">abrir nova comanda</a>';
		}
		echo '</span>';
		}else{
		if(!in_array("contas_clientes",$liberarPg)){echo '<span></span>';}
		}
		if(in_array(1,$liberarPg) || in_array("contas_clientes",$liberarPg)){			
		$contaAberta=(Clientes::verContaAberto($asBuscCliente['id'],$id_empresa)>0)?true:false;
		echo '<span class="s_acrescenta_conta'; if($contaAberta==true){ echo ' a_conta_aberta'; } echo '">
			<a href="'.getUrl().'contas-clientes.php?cad=contas-abertas&cliente='.removeAcentos($asBuscCliente['nome'],'-').'&cod='.$asBuscCliente['id'].'" class="'.$asBuscCliente['id'].'|'.$asBuscCliente['nome'].'">'; echo ($contaAberta==true)?'ir para conta do cliente':'abrir nova conta'; echo '</a>
			</span>';
		}else{echo '<span></span>';}		
		echo '</li>';
	}
}

}elseif(isset($_GET["busca_cliente_caixa"])){
include("../_classes/Clientes.class.php");
$buscCliente=Clientes::buscaClienteCmd($id_empresa,$_GET["busca_cliente_caixa"]);

if($buscCliente['num']>0){

	foreach($buscCliente['dados'] as $asBuscCliente){
	echo '<li class="'.$asBuscCliente['id'].'">
			<div class="li_nome_busc">'.limitiCaract($asBuscCliente['nome'],34,false,false).'</div>
			<div class="li_cpf_busc">'.$asBuscCliente['cpf_ou_cnpj'].'</div>
			<div class="li_rg_busc">'.$asBuscCliente['rg_ou_estadual'].'</div>
			<div class="li_telefone_busc">'.$asBuscCliente['telefone'].'</div>';
			
			if($asBuscCliente['comanda']!=""){
			echo '<div class="li_acao_busc"><a href="javascript:void(0);" class="a_cmd_aberto" id="'.$asBuscCliente['comanda'].'-cmdFecha">fechar comanda</a></div>';
			}else{
			echo '<div class="li_acao_busc"><a href="javascript:void(0);" class="a_abrir_cmd">abrir nova comanda</a></div>';
			}
		echo '
			<div class="li_edit_busc">
				<a href="javascript:void(0);" title="Editar cadastro" class="editaEstCli"><!--editar--></a>
			</div>
		</li>';
	}

}else{
echo "";
}
}elseif(isset($_GET["verficaCmd"])){
if($_GET["verficaCmd"]=="busca_comanda_mesa"){
		include('../_classes/Mesas.class.php');
		$comanda = (int)$_GET["comanda"];
		$buscCmd=Mesas::selMesaPagar($id_empresa,$comanda);
		if($buscCmd['num']==0){
		echo 'Comanda mesa não está aberta !|erro|';
		}else{
		echo '|';
		}
}else{
	$comanda = (strlen($_GET["comanda"])==1)?'0'.$_GET["comanda"]:$_GET["comanda"];
	if(Cadastros::versetem($id_empresa,$comanda,'comanda','clientes')==false){
	echo 'Comanda não está aberta !|erro|';
	}else{
	echo '|';
	}
}
}elseif(isset($_GET["busca_cmd_bar"])){
extract($_GET);
$inclu='../';
include("../_include/lista-comanda.php");	
	
}elseif(isset($_GET["qualCarrega"])){
	extract($_GET);
	if(isset($buscCmdBar) && ($buscCmdBar=="cd_comanda" || $buscCmdBar=="cd_consulta_cmd")){
		include("../_classes/Comandas.class.php");
		$recBusc=Comandas::buscaCmdAberta($busca,$id_empresa);
		$nn=1;
		if($recBusc['num']>0){
			foreach($recBusc['dados'] as $asRecBusc){			
			echo '
			<li '; if($nn==1){ echo 'class="bAtivo"';} $nn++; echo '><span class="'.$asRecBusc['comanda'].'">'.$asRecBusc['comanda'].' - '.$asRecBusc['nome'].'</span></li>';		
			 }
		 }else{
				echo '<li class="emfalta"><h2>não cadastrado ou em falta !</h2></li>';	
		 }
	}elseif(isset($buscCmdBar) && $buscCmdBar=="buscaTransferi"){		
		include("../_classes/Clientes.class.php");
		$recBusc=Clientes::buscaClienteCmd($id_empresa,$busca,30);
		$nn=1;
		if($recBusc['num']>0){
			foreach($recBusc['dados'] as $asRecBusc){
			echo '
			<li '; if($nn==1){ echo 'class="bAtivo"';} $nn++; echo '><span class="'.$asRecBusc['id'].'">'.$asRecBusc['nome'].'</span></li>';		
			 }
		 }else{
				echo '<li class="emfalta"><h2>não cadastrado ou em falta !</h2></li>';	
		 }
	}else{
	
	if($qualCarrega=="cd_produto_cmd"){
		$campo = 'id_cmd';
		$selTab = 'produtos';
		$nn=1;
	}elseif($qualCarrega=="conta_produtos"){
		$campo = 'id';
		$selTab = 'produtos';
	}else{
		$campo1 = explode("_",$qualCarrega);
		$campo = end($campo1);
		if($campo=="marca"){
		$selTab = 'marcas';
		}elseif($campo=="unidade"){
		$selTab = 'unidade_venda';
		}elseif($campo=="categoria"){
		$selTab = 'categorias';
		}elseif($campo=="fornecedor"){
		$selTab = 'fornecedores';
		}else{
		$selTab='';
		}
	}
	
	if(isset($busca)){
		$explode = explode(" ",$busca);
		$numP = count($explode);
		$buscar = "";
		for($h=0;$h<$numP;$h++){
			if($campo=='id' || $campo=='id_cmd'){
			$buscar .= "(codigo_interno LIKE :buscar$h OR marca LIKE :buscar$h OR descricao LIKE :buscar$h)";			
			$comple = "AND quantidade>0";
			}else{
			$buscar .= "($selTab LIKE :buscar$h)";
			$comple = "";
			}
			if($h<>$numP-1){ $buscar .= " AND "; }
		}
		$buscando = DB::getConn()->prepare("SELECT * FROM $selTab WHERE $buscar AND id_empresa=$id_empresa $comple");
		
		for($hi=0;$hi<$numP;$hi++){
			 $buscando->bindValue(":buscar$hi",'%'.$explode[$hi].'%',PDO::PARAM_STR);
		 }
		 $buscando->execute();
		 $numeBuscado = $buscando->rowCount();
		 if($numeBuscado>0){
			 while($resBusc=$buscando->fetch(PDO::FETCH_ASSOC)){
				if($campo=='id_cmd'){
						echo '
						<li '; if($nn==1){ echo 'class="bAtivo"';} $nn++; echo '><span class="'.$resBusc['codigo_interno'].'">'.$resBusc['codigo_interno'].' - '.$resBusc['marca'].' '.$resBusc['descricao'].'</span></li>';
				}elseif($campo=='id'){
						echo '<li><span class="'.$resBusc['id'].'|'.number_format($resBusc['valor_varejo'],2,',','.').'|'.$resBusc['valor_varejo'].'|'.$resBusc['quantidade'].'|'.$resBusc['valor_compra'].'">'.$resBusc['marca'].' '.$resBusc['descricao'].'</span></li>';
				}else{
					echo '<li><span class="'.$campo.'">'.$resBusc[$selTab].'</span></li>';
				}
			 }
		 }else{
			if($campo=='id_cmd'){
				echo '<li class="emfalta"><h2>não cadastrado ou em falta !</h2></li>';
			}		
		 }
	}
	}
}else{
echo "<h2>Ocorreu algum erro inesperado, por favor, tente novamente mais tarde !</h2>";
}