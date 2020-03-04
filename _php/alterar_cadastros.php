<?php
if(!isset($_SESSION)){session_start();}
include("../_classes/DB.class.php");
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
include("../_classes/Clientes.class.php");
include("../_classes/Comandas.class.php");
include("../_classes/Cadastros.class.php");
include('../_classes/AbrirFecharCaixa.class.php');
$idDaSessao = $_SESSION['Gerabar_uid'];
$table = $_SESSION['Gerabar_table'];
$planoAtivo=$_SESSION['Gerabar_plano'];
if($table=="usuarios"){
$funcionario="a";
}elseif(isset($_SESSION['Gerabar_Ocodigo'])){
$funcionario=$_SESSION['Gerabar_Ocodigo'];
}else{
$funcionario="isento";
}
$idEmpre = Cadastros::selectIdEmpresa($idDaSessao,$table);
$id_empresa=($idEmpre['num']>0)?$idEmpre['dados'][0]:0;
extract($_POST);
if(isset($_GET['ativar_sangria'])){
    include("../_classes/Empresas.class.php");
    $sangria=(int)$_GET['ativar_sangria'];
    if($sangria==1 || $sangria==0){
        $selCxAberto=AbrirFecharCaixa::selAbrirCaixa($id_empresa,false);
        if($selCxAberto['num']>0 && $sangria==0){
        echo 'Não é possível desativar sangria agora, ainda tem caixas em aberto !|erro';    
        }else{
        if(Empresas::updateAmbEmpresa($id_empresa,$sangria,true)){
        echo '|';
        }else{
        echo 'Ocorreu um erro ao tentar alterar a sangria de caixa, por favor, tente novamente !|erro';
        }
        }
    }else{
    echo 'Ocorreu um erro ao tentar alterar a sangria de caixa, por favor, tente novamente !|erro';
    }
}elseif(isset($_GET['fechar_caixa'])){
    if(AbrirFecharCaixa::altStatus($id_empresa,$funcionario)){
    echo 'Caixa fechado com sucesso !|';
    }else{
    echo 'Ocorreu um erro ao tentar fazer o fechamento do caixa, por favor, tente novamente !|erro'; 
    }
}elseif(isset($idFrente)){
    include("../_classes/FrenteCaixa.class.php");
    if($idFrente=="cancelar_operacao"){
        $trasFrente=FrenteCaixa::selectFrente($id_empresa,$funcionario);
        if($trasFrente['num']>0){
            foreach($trasFrente['dados'] as $asFrente){                
                if(FrenteCaixa::deleteFrente($id_empresa,$asFrente['id'],$funcionario,$asFrente['quantidade'],$asFrente['id_produto'])==false){
                echo 'Ocorreu um erro ao remover um dos produtos !|erro';
                exit();
                $erroFrente=true;
                }
            }
            if(!isset($erroFrente)){                
                if(FrenteCaixa::deleteDescontar($id_empresa,$funcionario)){
                echo "Operação Cancelada !|";
                }else{
                echo 'Ocorreu um erro ao remover o desconto !|erro';    
                }
            }
        }else{
        echo 'Ocorreu um erro ao cancelar operação !|erro';    
        }
    }else{
        if(FrenteCaixa::deleteFrente($id_empresa,(int)$idFrente,$funcionario,(int)$quantProd,(int)$idProduto)){
        echo "Produto removido !|";
        }else{
        echo 'Ocorreu um erro ao tentar remover o produto !|erro';
        }
    }
}elseif(isset($idDelAmb)){
	if(Cadastros::versetem($id_empresa,$idDelAmb,'id','ambientes')){
	include('../_classes/Empresas.class.php');	
	if(Empresas::deleteAmb($id_empresa,(int)$idDelAmb)){
	echo "|";
	}else{
	echo "Ocorreu um erro ao tentar excluir o ambiente !|erro";
	}
	}else{
	echo "Ocorreu um erro ao tentar excluir o ambiente !|erro";
	}
}elseif(isset($idDelOpe)){
	if(Cadastros::versetem($id_empresa,$idDelOpe,'id','operadores')){
		include('../_classes/Operadores.class.php');
		if(Operadores::delOperador((int)$idDelOpe,$id_empresa)){
		echo "|";
		}else{
		echo "Ocorreu um erro ao tentar excluir o operador !|erro";
		}
	}else{
		echo "Ocorreu um erro ao tentar excluir o operador !|erro";	
	}
}elseif(isset($delProdCmd)){
	if(isset($idDesconto) AND $idDesconto=="descontarId"){
        $delDesconto=Cadastros::delDescontar((int)$delProdCmd,$id_empresa);
        if($delDesconto!=false){
        $selCxAberto=AbrirFecharCaixa::selAbrirCaixa($id_empresa,$funcionario);
        $forDesconta=($selCxAberto['num']==0)?0:$delDesconto['forma_pagamento'];
        echo '||'.$forDesconta.'|'.$delDesconto['valor_pago'];
		}else{
		echo "Ocorreu um erro ao tentar excluir o desconto da comanda, por favor, tente mais tarde ou chame um técnico !|erro";
		}
	}else{
        if($qualCmdMesa=="vendas-abertas"){
            include("../_classes/FrenteCaixa.class.php");
            if(FrenteCaixa::deleteFrente($id_empresa,(int)$delProdCmd,$idfuncionario,(int)$quantCmd,(int)$idProduto)){
            echo "|";
            }else{
            echo 'Ocorreu um erro ao tentar remover o produto !|erro';
            }
        }else{
            $qualVai=($qualCmdMesa=="busca_comanda_mesa" || $qualCmdMesa=="mesas-abertas")?"mesa":"";
            if(Comandas::delProdCmd((int)$delProdCmd,(int)$idProduto,(int)$quantCmd,$qualVai,$id_empresa)==true){
            echo "|";
            }else{
            echo "Ocorreu um erro ao tentar excluir produto da comanda, por favor, tente mais tarde ou chame um técnico !|erro";
            }
        }
	}
}elseif(isset($idComanda) || isset($senhaAtual)){
	if(isset($idComanda)){
		if(isset($formaPagamento)){
            $selCxAberto=AbrirFecharCaixa::selAbrirCaixa($id_empresa,$funcionario);
            $sangria=($selCxAberto['num']>0)?true:false;            
            function limitCaixa($idEmpresa,$idFuncionario){
                $selLimit=AbrirFecharCaixa::selAbrirCaixa($idEmpresa,$idFuncionario);
                if($selLimit['num']>0){
                    if($selLimit['dados']['pago_dinheiro']>=$selLimit['dados']['limite_caixa']){
                        AbrirFecharCaixa::altStatus($idEmpresa,$idFuncionario);
                        return true;
                    }else{
                        return false;
                    }
                }else{
                    return false;
                }
            }
            if($idComanda=="frente_caixa"){
               include('../_classes/FrenteCaixa.class.php');
                if(FrenteCaixa::pagaFrente($id_empresa,(int)$formaPagamento,$valCmd,strip_tags($pagoCartao),strip_tags($autorizaCartao),$funcionario,$sangria)){
                    if(limitCaixa($id_empresa,$funcionario)==true){
                    echo "Limite do caixa atingido !|limiteCaixa";
                    }else{
				    echo "|";
                    }
				}else{
				echo "Ocorreu um erro ao fazer o pagamento, por favor, tente novamente !|erro";
				}
            }elseif(isset($dadosExtras) AND $dadosExtras<>""){
				$quantId=explode('|',$dadosExtras);
				if($quantId[0]=="pagarMesa"){
					include('../_classes/Mesas.class.php');
					if(Mesas::pagaTudoContaMesa($id_empresa,$idComanda,$valCmd,(int)$formaPagamento,strip_tags($pagoCartao),strip_tags($autorizaCartao),$funcionario,$dadosExtras,$sangria)){
					if(limitCaixa($id_empresa,$funcionario)==true){
                    echo "Limite do caixa atingido !|limiteCaixa";
                    }else{
				    echo "|";
                    }
					}else{
					echo "Ocorreu um erro ao fazer o pagamento da conta, por favor, tente mais tarde !|erro";
					}
				}else{
					if($quantId[1]=="descontar"){
						$idCertoDesconto=Cadastros::descontarCMC($id_empresa,$idComanda,$valCmd,(int)$formaPagamento,strip_tags($pagoCartao),strip_tags($autorizaCartao),$funcionario,$dadosExtras,$sangria);
						if($idCertoDesconto!=false){
                        if(limitCaixa($id_empresa,$funcionario)==true){
                        echo $idCertoDesconto.'|limiteCaixa|'.$funcionario;
                        }else{
                        echo $idCertoDesconto.'||'.$funcionario;
                        }
						}else{
						echo "Ocorreu um erro ao fazer o pagamento do desconto, por favor, tente mais tarde !|erro";
						}
					}else{				
						if($quantId[1]==""){
						$idconta=$quantId[0];
						$quantConta=false;
						$idPagoConta=false;
						}else{
						$idconta=0;
						$quantConta=$quantId[1];
						$idPagoConta=$quantId[0];
						}
						if(Clientes::pagaTudoConta((int)$idComanda,$idconta,$id_empresa,(int)$formaPagamento,$valCmd,strip_tags($pagoCartao),strip_tags($autorizaCartao),$funcionario,$quantConta,$idPagoConta,$sangria)){
						if(limitCaixa($id_empresa,$funcionario)==true){
                        echo "Limite do caixa atingido !|limiteCaixa";
                        }else{
                        echo "|";
                        }
						}else{
						echo "Ocorreu um erro ao fazer o pagamento da conta, por favor, tente mais tarde !|erro";
						}
					}
				}
			}else{
				if(Comandas::pagaTudoCmd($id_empresa,$idComanda,$valCmd,(int)$formaPagamento,strip_tags($pagoCartao),strip_tags($autorizaCartao),$funcionario,$sangria)){
                    if(limitCaixa($id_empresa,$funcionario)==true){
                    echo "Limite do caixa atingido !|limiteCaixa";
                    }else{
                    echo "|";
                    }
				}else{
				echo "Ocorreu um erro ao fazer o pagamento da comanda, por favor, tente mais tarde !|erro";
				}
			}
		}else{
			if(isset($qualPgFecha)){
				if($qualPgFecha=="pg_contaFecha"){
					if(Clientes::deletarContaFechada($id_empresa,(int)$idComanda,(int)$idCmdFechada)){
					echo "Conta deletada com sucesso !|";
					}else{
					echo "Ocorreu um erro ao deletar a conta, por favor, tente mais tarde !|erro";
					}				
				}elseif($qualPgFecha=="pg_mesaFecha"){
					include('../_classes/Mesas.class.php');
					if(Mesas::deletarMesaFechada($id_empresa,(int)$idComanda,(int)$idCmdFechada)){
					echo "Mesa deletada com sucesso !|";
					}else{
					echo "Ocorreu um erro ao deletar a mesa, por favor, tente mais tarde !|erro";
					}				
				}elseif($qualPgFecha=="pg_vendaFecha"){
					include('../_classes/FrenteCaixa.class.php');
					if(FrenteCaixa::deletarCaixaFechado($id_empresa,(int)$idCmdFechada)){
					echo "Venda deletado com sucesso !|";
					}else{
					echo "Ocorreu um erro ao deletar a venda, por favor, tente mais tarde !|erro";
					}				
				}elseif($qualPgFecha=="pg_caixaFecha"){
					if(AbrirFecharCaixa::deletarCaixa($id_empresa,(int)$idCmdFechada)){
					echo "Caixa deletado com sucesso !|";
					}else{
					echo "Ocorreu um erro ao deletar a caixa, por favor, tente mais tarde !|erro";
					}				
				}else{
					if(Comandas::deletarCmdFechada($id_empresa,(int)$idComanda,(int)$idCmdFechada)){
					echo "Comanda deletada com sucesso !|";
					}else{
					echo "Ocorreu um erro ao deletar a comanda, por favor, tente mais tarde !|erro";
					}
				}
			}
		}
	}else{
		if($senhaAtual==""){
		echo "Senha atual está em branco !|alt_senha_atual";
		}elseif(Cadastros::verSenhaAtual($idDaSessao,$senhaAtual,$qualSenha)==false){
		echo "Senha atual incorreta !|alt_senha_atual";
		}elseif($novaSenha==""){
		echo "Nova senha está em branco !|alt_nova_senha";
		}elseif(strlen($novaSenha)<6){
		echo "Senha colocada é muito pequena !|alt_nova_senha";
		}elseif(!preg_match("/^(?=.*\d)(?=.*[a-z])(?!.*\s).*$/",$novaSenha)){
		echo "Senha em branco ou pequena de mais !|alt_nova_senha";
		}elseif($repSenha==""){
		echo "Por favor, repita sua senha !|alt_repetNova_senha";
		}elseif($novaSenha!=$repSenha){
		echo "As duas senhas estão diferentes !|alt_repetNova_senha";
		}else{
			if(Cadastros::altSenhas($idDaSessao,strip_tags($novaSenha),strip_tags($qualSenha))){
			echo "Senha alterada com sucesso !|";
			}else{
			echo "Ocorreu um erro ao deletar comanda, por favor, tente mais tarde !|erro";
			}
		}
	}
}elseif(isset($qualCadDeletar)){
    if(isset($idDelSelect) && !empty($idDelSelect)){
        if($qualCadDeletar=="pg_mesaFecha"){ 
            include('../_classes/Mesas.class.php'); 
        }elseif($qualCadDeletar=="pg_vendaFecha"){
            include('../_classes/FrenteCaixa.class.php'); 
        }
        for($i=0;$i<count($idDelSelect);$i++){
            if($qualCadDeletar=="pg_contaFecha"){
                if(Clientes::deletarContaFechada($id_empresa,(int)$idCmdDel[$i],(int)$idDelSelect[$i])==false){
                echo "Ocorreu um erro ao deletar a conta, por favor, tente mais tarde !|erro";
                $paraDel=true;
                exit();
                }				
            }elseif($qualCadDeletar=="pg_mesaFecha"){
                if(Mesas::deletarMesaFechada($id_empresa,(int)$idCmdDel[$i],(int)$idDelSelect[$i])==false){
                echo "Ocorreu um erro ao deletar a mesa, por favor, tente mais tarde !|erro";
                $paraDel=true;
                exit();
                }				
            }elseif($qualCadDeletar=="pg_vendaFecha"){
                if(FrenteCaixa::deletarCaixaFechado($id_empresa,(int)$idDelSelect[$i])==false){
                echo "Ocorreu um erro ao deletar o venda, por favor, tente mais tarde !|erro";
                $paraDel=true;
                exit();
                }
            }elseif($qualCadDeletar=="pg_caixaFecha"){
					if(AbrirFecharCaixa::deletarCaixa($id_empresa,(int)$idDelSelect[$i])==false){
                echo "Ocorreu um erro ao deletar o caixa, por favor, tente mais tarde !|erro";
                $paraDel=true;
                exit();
                }
                }else{
                if(Comandas::deletarCmdFechada($id_empresa,(int)$idCmdDel[$i],(int)$idDelSelect[$i])==false){
                echo "Ocorreu um erro ao deletar a comanda, por favor, tente mais tarde !|erro";
                $paraDel=true;
                exit();
                }
            }
        }
        if(isset($paraDel)==false){
            if($qualCadDeletar=="pg_contaFecha"){
                echo "Conta deletada com sucesso !|";                        
            }elseif($qualCadDeletar=="pg_mesaFecha"){
                echo "Mesa deletada com sucesso !|";
            }elseif($qualCadDeletar=="pg_vendaFecha"){
                echo "Venda deletada com sucesso !|";
            }elseif($qualCadDeletar=="pg_caixaFecha"){
                echo "Caixa deletada com sucesso !|";
            }else{
                echo "Comanda deletada com sucesso !|";
            }
        }
    }else{
    echo "Ocorreu um erro ao tentar deletar, por favor, tente novamente !|erro";    
    }
}elseif(isset($transferirConta)){	
    if(Cadastros::plano_cadastro_ativo($planoAtivo,$id_empresa,"conta_clientes",20,(int)$idCliente)==true){
    if($transferirConta!="compra"){
        $comanda=$transferirConta;	
        if(strlen($comanda)==1){
        $comanda = '0'.$comanda;
        }	
        $buscCmd=Comandas::trazesCmdBar($id_empresa,$comanda);
    }else{
        include("../_classes/FrenteCaixa.class.php");
        $buscCmd=FrenteCaixa::selectFrente($id_empresa,$funcionario);    
    }
	if($buscCmd['num']>0){
		$n=0;
		foreach($buscCmd['dados'] as $asCmdBar){
            if($transferirConta!="compra"){
            $nomeProduto=($asCmdBar['id_produto']==0)?$asCmdBar['descricao']:$asCmdBar['marca'].' '.$asCmdBar['descricao']; 
            $garcon=$asCmdBar['garcon'];
            }else{
            $nomeProduto=$asCmdBar['nome_produto']; 
            $garcon=$asCmdBar['funcionario'];
            } if(Clientes::insertContaCliente((int)$idCliente,$id_empresa,$asCmdBar['id_produto'],$asCmdBar['quantidade'],$asCmdBar['valor_compra'],$asCmdBar['valor'],$nomeProduto,$garcon,$asCmdBar['cadastro'],true,true)){
			$n++;
			if($n==$buscCmd['num']){$certoTrans=true;}
			}else{
			echo "Ocorreu um erro ao transferir para a conta, por favor, tente mais tarde !|erro";
			exit();
			}
		}
	}else{
		$certoTrans=true;
		//echo "Comanda sem produto não pode ser transferida !|erro";
	}
	if(isset($certoTrans)){
    if($transferirConta!="compra"){
		$cmdBusCliente=Comandas::clienteCmd($id_empresa,$comanda);		
		if($cmdBusCliente['num']>0){
			if($cmdBusCliente['dados'][6]==0 AND $cmdBusCliente['dados'][1]!="" AND $cmdBusCliente['dados'][1]!="0.00" AND $cmdBusCliente['dados'][1]!="0"){
				if(Clientes::insertContaCliente((int)$idCliente,$id_empresa,0,1,$cmdBusCliente['dados'][1],"VALOR DE ENTRADA",$cmdBusCliente['dados'][7],$cmdBusCliente['dados'][5],true)){
				$certoFinal=true;	
				}else{
				echo "Ocorreu um erro ao transferir para a conta, por favor, tente mais tarde !|erro";
				}				
			}else{
			$certoFinal=true;
			}		
		}else{
			$certoFinal=true;
		}		
    }else{
        $certoFinal=true;
    }
		if(isset($certoFinal)){
            if($transferirConta!="compra"){
                if(Comandas::transferirCmd($id_empresa,$comanda,(int)$idCliente)){
                echo "Transferência feita com sucesso !|";
                }else{
                echo "Ocorreu um erro ao transferir a comanda, por favor, tente mais tarde !|erro";
                }
            }else{
                if(FrenteCaixa::transferirFrente($id_empresa,$funcionario,(int)$idCliente)){
                echo "Transferência feita com sucesso !|";
                }else{
                echo "Ocorreu um erro ao transferir a compra, por favor, tente mais tarde !|erro";
                }
            }
		}		
	}else{
        echo "Ocorreu um erro ao transferir para a conta, por favor, tente mais tarde !|erro";
    }
}else{
    echo "Limite de transferências para o Plano Grátis atingido. Contrate um Plano Premium e continue transferindo !|erro";
}
}elseif(isset($qualPg) AND $qualPg=='estoque'){
if(isset($id) AND !empty($id)){
	include('../_classes/Produtos.class.php');
	$count = $contar;
	$i=0;
	$erro=false;
	for($e=$Qnum;$e<$count;$e++){
		if($erro==false){			
			$marca1=trim($marca[$i]);
			$descricao1=trim($descricao[$i]);
			$unidade1=trim($unidade[$i]);
			$categoria1=trim($categoria[$i]);
			$fornecedor1=trim($fornecedor[$i]);
			$quant1=($quant[$i]==0)?0:(int)$quant[$i];
			$codInterno1=trim($codInterno[$i]);
			$valCompra1=trim($valCompra[$i]);
			$margem1=(int)$margem[$i];
			$valVarejo1=trim($valVarejo[$i]);
			if($marca1==""){
			echo "Marca está em branco !|cd_produto_".$e."_1_marca";
			exit();
			}elseif($descricao1==""){
			echo "Descrição está em branco !|cd_produto_".$e."_2_descricao";
			exit();
			}elseif($unidade1==""){
			echo "Selecione uma unidade de venda !|cd_produto_".$e."_3_unidade";
			exit();
			}elseif($categoria1==""){
			echo "Categoria está em branco !|cd_produto_".$e."_4_categoria";
			exit();
			}elseif($fornecedor1==""){
			echo "Fornecedores está em branco !|cd_produto_".$e."_5_fornecedor";
			exit();
			}elseif($quant1==""){
			echo "Quantidade está em branco !|cd_produto_".$e."_6_qtd";
			exit();			
			}elseif($codInterno1==""){
			echo "Código interno está em branco !|cd_produto_".$e."_7_codInterno";
			exit();
			}elseif(Cadastros::versetem($id_empresa,$codInterno1,'codigo_interno','produtos',(int)$id[$i])==true){
			echo "Código interno já está cadastrado !|cd_produto_".$e."_7_codInterno";
			exit();
			}elseif($valCompra1=="" || $valCompra1=="0,00"){
			echo "Valor de compra está em branco !|cd_produto_".$e."_8_valCompra";
			exit();
			}elseif($margem1==""){
			echo "Margem está em branco !|cd_produto_".$e."_8_valCompra-margem";
			exit();
			}elseif($valVarejo1=="" || $valVarejo1=="0,00"){
			echo "Valor de venda está em branco !|cd_produto_".$e."_8_valCompra_valVarejo";
			exit();
			}else{
                
if(Produtos::alteraProduto((int)$id[$i],strip_tags($marca1),strip_tags($descricao1),strip_tags($unidade1),strip_tags($categoria1),strip_tags($fornecedor1),$quant1,$codInterno1,$valCompra1,$margem1,$valVarejo1)==false){
					$erro=true;
				}
				$i++;
			}
		}
	}
	if($erro==false){
		if($count>1){
		echo "Alterações feitas com sucesso !|";
		}else{
		echo "Alteração feita com sucesso !|";
		}
	}else{
	echo "Ocorreu um erro ao fazer o cadastro, por favor, tente mais tarde !|erro";
	}	
}else{
echo "Ocorreu um erro ao fazer o cadastro, por favor, tente mais tarde !|erro";
}
}elseif(isset($tipo_pessoa)){
if(isset($id) AND !empty($id)){
	$count = count($id);
	include("../_classes/Validar.class.php");	
	$erro=false;
	for($i=0;$i<$count;$i++){
		if($erro==false){
		$nome1=trim($nome[$i]);
		$sexo1=trim($sexo[$i]);
		$email1=trim($email[$i]);
		$nascimento1=trim($nascimento[$i]);
		$cpf_cnpj1=trim($cpf_cnpj[$i]);
		$rg_estadual1=trim($rg_estadual[$i]);
		$tipo_pessoa1=trim($tipo_pessoa[$i]);
		$tel1=trim($tel[$i]);
		if($nome1=="" OR strlen($nome1)<5){
			echo "Nome está em branco ou pequeno demais !|cliente_".$number[$i]."_1";
			exit();
		}elseif($sexo1==""){
			echo "Selecione o sexo !|cliente_".$number[$i]."_4";
			exit();
		}elseif($email1!="" AND !preg_match("/^[a-z0-9_\.\-]+@[a-z0-9_\.\-]*[a-z0-9_\-]+\.[a-z]{2,4}$/i",$email1)){
			echo "O e-mail informado é inválido !|cliente_".$number[$i]."_18";
			exit();
		}elseif($email1!="" AND Cadastros::versetem($id_empresa,$email1,'email','clientes',(int)$id[$i])==true){
			echo "O e-mail informado já está cadastrado em nosso sistema !|cliente_".$number[$i]."_18";
			exit();
		}		
		if($nascimento1!=""){
			$nasc = explode('/',$nascimento1);
			if(checkdate($nasc[1],$nasc[0],$nasc[2])==false){
			echo "Data de nascimento está incorreta !|cliente_".$number[$i]."_3";
			exit();
			}elseif((date('Y')-110)>$nasc[2]){
			echo "Ano de nascimento está incorreto !|cliente_".$number[$i]."_3";
			exit();
			}elseif((date('Y')-18)<$nasc[2]){
			echo "Idade mínima é de 18 anos !|cliente_".$number[$i]."_3";
			exit();
			}else{
			$data = $nasc[2].'-'.$nasc[1].'-'.$nasc[0];
			}
		}else{
			$data = '0000-00-00';
		}		
		if($tipo_pessoa1=="pessoa_fisica"){
			if($cpf_cnpj1!=""){
				$exs = explode('-',$cpf_cnpj1);
				$exs2 = explode('.',$exs[0]);
				$cpf = $exs2[0].$exs2[1].$exs2[2];
				$digito = $exs[1];
			}else{
				$cpf = '123456789';
				$digito = '09';
			}			
			if($cpf_cnpj1!="" AND Validar::validar_cpf($cpf,$digito)==false){
				echo "O CPF informado é inválido !|cliente_".$number[$i]."_11";
				exit();
			}elseif($cpf_cnpj1!="" AND Cadastros::versetem($id_empresa,$cpf_cnpj1,'cpf_ou_cnpj','clientes',$id[$i])==true){
				echo "O CPF informado já está cadastrado em nosso sistema !|cliente_".$number[$i]."_11";
				exit();
			}elseif($rg_estadual1!="" AND Cadastros::versetem($id_empresa,$rg_estadual1,'rg_ou_estadual','clientes',$id[$i])==true){
				echo "O RG informado já está cadastrado em nosso sistema !|cliente_".$number[$i]."_12";
				exit();
			}		
		}else{
			if($cpf_cnpj1!="" AND Validar::validar_cnpj($cpf_cnpj1)==false){
				echo "O CNPJ informado é inválido !|cliente_".$number[$i]."_13";
				exit();
			}elseif($cpf_cnpj1!="" AND Cadastros::versetem($id_empresa,$cpf_cnpj1,'cpf_ou_cnpj','clientes',$id[$i])==true){
				echo "O CNPJ informado já está cadastrado em nosso sistema !|cliente_".$number[$i]."_13";
				exit();
			}
		}			if(Clientes::alteraCliente((int)$id[$i],strip_tags($nome1),strip_tags($data),strip_tags($sexo1),strip_tags($tipo_pessoa1),strip_tags($cpf_cnpj1),strip_tags($rg_estadual1),strip_tags($tel1),strip_tags($email1))==false){
				$erro=true;
			}
		}
	}
	if($erro==false){
		if($count>1){
		echo "Alterações feitas com sucesso !|";
		}else{
		echo "Alteração feita com sucesso !|";
		}
	}else{
	echo "Ocorreu um erro ao fazer o cadastro, por favor, tente mais tarde !|erro";
	}	
}else{
echo "Ocorreu um erro ao fazer o cadastro, por favor, tente mais tarde !|erro";
}
}elseif(isset($nomeUser)){
	if($nome=="" || strlen($nome)<4){
	echo "Nome em branco ou pequeno de mais !|usuario_nome";
	}elseif($sobrenome=="" || strlen($sobrenome)<4){
	echo "Sobrenome em branco ou pequeno de mais !|usuario_sobrenome";
	}elseif($nasc==""){
	echo "Data de nascimento está em branco !|usuario_nascimento";
	}else{
		$data=explode('/',$nasc);
		if(checkdate($data[1],$data[0],$data[2])==false){
		echo "Data de nascimento está incorreta !|usuario_nascimento";
		exit();
		}elseif((date('Y')-110)>$data[2]){
		echo "Ano de nascimento está incorreto !|usuario_nascimento";
		exit();
		}elseif((date('Y')-18)<$data[2]){
		echo "Idade mínima é de 18 anos !|usuario_nascimento";
		exit();
		}elseif($sexo==""){
		echo "Sexo não selecionado !|usuario_sexo";
		}elseif($nomeUser=="" || strlen($nomeUser)<2){
		echo "Nome de Usuário em branco ou pequeno de mais !|usuario_nomeUser";
		}elseif(Cadastros::versetem(0,$nomeUser,'nome_usuario','usuarios',$idDaSessao)==true){
		echo "Nome de Usuário já está cadastrado em nosso sistema !|usuario_nomeUser";
		}elseif($email=="" || !preg_match("/^[a-z0-9_\.\-]+@[a-z0-9_\.\-]*[a-z0-9_\-]+\.[a-z]{2,4}$/i",$email)){
		echo "E-mail em branco ou inválido !|usuario_email";
		}elseif(Cadastros::versetem(0,$email,'email','usuarios',$idDaSessao)==true){
		echo "Este e-mail já está cadastrado em nosso sistema !|usuario_email";
		}else{
			$dataNasc = $data[2].'-'.$data[1].'-'.$data[0];
			$chave = sha1(uniqid( mt_rand(),true));if(Cadastros::updateCadastro($idDaSessao,strip_tags($nome),strip_tags($sobrenome),strip_tags($dataNasc),strip_tags($sexo),strip_tags($nomeUser),strip_tags($email),$chave)){
				echo "Atualização feita com sucesso !|";
				$msgCima='Seu dados foram alterados com sucesso no <a href="'.getUrl().'" target="_blank">Gerabar.com.br</a>, agora precisamos validar sua conta novamente verificando seu e-mail.';
				include('envia_verifica.php');
			}else{
				echo "Ocorreu um erro ao tentar atualizar os dados, por favor, tente mais tarde !|erro";
			}
		}
	}
}elseif(isset($idRemove)){
	if(isset($idDesconto) AND $idDesconto=="liDesc"){        
        $delDesconto=Cadastros::delDescontar((int)$idRemove,$id_empresa);
		if($delDesconto!=false){
        $selCxAberto=AbrirFecharCaixa::selAbrirCaixa($id_empresa,$funcionario);
        $forDesconta=($selCxAberto['num']==0)?0:$delDesconto['forma_pagamento'];
        echo '||'.$forDesconta.'|'.$delDesconto['valor_pago'];
		}else{
		echo "Ocorreu um erro ao tentar excluir o desconto da comanda, por favor, tente mais tarde ou chame um técnico !|erro";
		}
	}else{
		if(Clientes::deleteContaCliente((int)$idRemove,(int)$idProd,$quant,$id_empresa)){
		echo "|";
		}else{
		echo "Ocorreu um erro ao deletar o produto da conta, por favor, tente mais tarde !|erro";
		}
	}
}elseif(isset($descontarCx)){
    if($formaPago==1 || $formaPago==2){
        if(AbrirFecharCaixa::descontarValor($id_empresa,$funcionario,$formaPago,$valPago)){
        echo 'Valor descontando com sucesso !|';
        }else{
        echo "Ocorreu um erro ao descontar valor do caixa, por favor, tente mais tarde !|erro";
        }
    }else{
        echo "Ocorreu um erro ao descontar valor do caixa, por favor, tente mais tarde !|erro";
    }
}else{
echo "Ocorreu algum erro inesperado, por favor, tente novamente mais tarde !|erro";
}