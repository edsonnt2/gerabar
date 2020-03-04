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
include("../_classes/Validar.class.php");
include("../_classes/Cadastros.class.php");
$idDaSessao = $_SESSION['Gerabar_uid'];
$table = $_SESSION['Gerabar_table'];
$planoAtivo=$_SESSION['Gerabar_plano'];

$idEmpre = Cadastros::selectIdEmpresa($idDaSessao,$table);
$id_empresa=($idEmpre['num']>0)?$idEmpre['dados'][0]:0;
$idOperador=($table=="usuarios")?0:$idDaSessao;
extract($_POST);
if(isset($cadastro) AND $cadastro=="clientes"){
	$nome=trim($nome);
	$email=trim($email);
	$nascimento=trim($nascimento);
	$cpf_cnpj=trim($cpf_cnpj);
	$rg_estadual=trim($rg_estadual);
	$sexo=trim($sexo);
	
	if($nome=="" OR strlen($nome)<4){
		echo "Nome está em branco ou pequeno demais !|cd_cliente_nome";
	}elseif($sexo==""){
		echo "Selecione o sexo !|cd_cliente_sexo";
	}elseif($email!="" AND !preg_match("/^[a-z0-9_\.\-]+@[a-z0-9_\.\-]*[a-z0-9_\-]+\.[a-z]{2,4}$/i",$email)){
		echo "O e-mail informado é inválido !|cd_cliente_email";
	}elseif($email!="" AND Cadastros::versetem($id_empresa,$email,'email','clientes')==true){
		echo "O e-mail informado já está cadastrado em nosso sistema !|cd_cliente_email";
	}else{
		if($nascimento!=""){
			$nasc = explode('/',$nascimento);
			if(checkdate($nasc[1],$nasc[0],$nasc[2])==false){
			echo "Data de nascimento está incorreta !|cd_cliente_data";
			exit();
			}elseif((date('Y')-110)>$nasc[2]){
			echo "Ano de nascimento está incorreto !|cd_cliente_data";
			exit();
			}elseif((date('Y')-18)<$nasc[2]){
			echo "Idade miníma é de 18 anos !|cd_cliente_data";
			exit();
			}else{
			$data = $nasc[2].'-'.$nasc[1].'-'.$nasc[0];
			}
		}else{
			$data = '0000-00-00';
		}		
		$tudoCerto=false;
		
		if($tipoPessoa=="pessoa_fisica"){
			if($cpf_cnpj!=""){
				$exs = explode('-',$cpf_cnpj);
				$exs2 = explode('.',$exs[0]);
				$cpf = $exs2[0].$exs2[1].$exs2[2];
				$digito = $exs[1];
			}else{
				$cpf = '123456789';
				$digito = '09';
			}
			if($cpf_cnpj!="" AND Validar::validar_cpf($cpf,$digito)==false){
				echo "O CPF informado é inválido !|cliente_0_11";
			}elseif($cpf_cnpj!="" AND Cadastros::versetem($id_empresa,$cpf_cnpj,'cpf_ou_cnpj','clientes')==true){
				echo "O CPF informado já está cadastrado em nosso sistema !|cliente_0_11";
			}elseif($rg_estadual!="" AND Cadastros::versetem($id_empresa,$rg_estadual,'rg_ou_estadual','clientes')==true){
				echo "O RG informado já está cadastrado em nosso sistema !|cliente_0_12";
			}else{$tudoCerto = true;}
		}else{
			if($cpf_cnpj!="" AND Validar::validar_cnpj($cpf_cnpj)==false){
				echo "O CNPJ informado é inválido !|cliente_0_13";
			}elseif($cpf_cnpj!="" AND Cadastros::versetem($id_empresa,$cpf_cnpj,'cpf_ou_cnpj','clientes')==true){
				echo "O CNPJ informado já está cadastrado em nosso sistema !|cliente_0_13";
			}else{$tudoCerto = true;}
		}
		if($tudoCerto==true){
			include("../_classes/Clientes.class.php");
            
            if(Cadastros::plano_cadastro_ativo($planoAtivo,$id_empresa,"clientes",20)==true){
                if(Clientes::insertClientes($id_empresa,strip_tags($nome),strip_tags($data),strip_tags($sexo),strip_tags($tipoPessoa),strip_tags($cpf_cnpj),strip_tags($rg_estadual),strip_tags($tel),strip_tags($email),$idOperador)){
                    $idClienteNovo=Clientes::trasIdCliente($id_empresa,strip_tags($nome));
                    if($idClienteNovo<>false){
                    include('../_classes/remove_caracteres.php');
                    echo $idClienteNovo."||".removeAcentos($nome,'-');
                    }else{
                    echo "Ocorreu um erro ao fazer o cadastro, por favor, tente mais tarde !|erro";
                    }				
                }else{
                    echo "Ocorreu um erro ao fazer o cadastro, por favor, tente mais tarde !|erro";
                }
            }else{
                echo "Limite de cadastros para o Plano Grátis atingido. Contrate um Plano Premium e continue cadastrando !|erro";
            }
            
		}
	}
    
}elseif(isset($cadastro) AND $cadastro=="produtos"){
	$marca=trim($marca);
	$descricao=trim($descricao);
	$unidade=trim($unidade);
	$categoria=trim($categoria);
	$fornecedores=trim($fornecedores);
	$quant=($quant==0)?$quant:(int)$quant;
	$codInterno=trim($codInterno);
	$valCompra=trim($valCompra);
	$margem=($margem==0)?0:(int)$margem;
	$valVarejo=trim($valVarejo);
	if($marca==""){
	echo "Marca está em branco !|cd_produto_marca";
	}elseif($descricao==""){
	echo "Descrição está em branco !|cd_produto_descricao";
	}elseif($unidade==""){
	echo "Selecione uma unidade de venda !|cd_produto_unidade";
	}elseif($categoria==""){
	echo "Categoria está em branco !|cd_produto_categoria";
	}elseif($fornecedores==""){
	echo "Fornecedores está em branco !|cd_produto_fornecedor";
	}elseif($quant==""){
	echo "Quantidade está em branco !|cd_produto_qtd";
	}elseif($codInterno==""){
	echo "Código interno está em branco !|cd_produto_codInterno";
	}elseif($valCompra=="" OR $valCompra=="0.00"){
	echo "Valor de compra está em branco !|cd_produto_valCompra";
	}elseif($margem==""){
	echo "Margem está em branco !|cd_produto_margem";
	}elseif($valVarejo=="" OR $valVarejo=="0.00"){
	echo "Valor de venda está em branco !|cd_produto_valVarejo";
	}else{
		if(Cadastros::versetem($id_empresa,$codInterno,'codigo_interno','produtos')==true){
		echo "Código interno já está cadastrado !|cd_produto_codInterno";
		}else{
		include("../_classes/Produtos.class.php");
           
          if(Cadastros::plano_cadastro_ativo($planoAtivo,$id_empresa,"produtos",30)==true){             if(Produtos::insertProdutos($id_empresa,strip_tags($marca),strip_tags($descricao),strip_tags($unidade),strip_tags($categoria),strip_tags($fornecedores),$quant,$codInterno,$valCompra,$margem,$valVarejo,$idOperador)){
            echo "Produto cadastrado com sucesso !|";
            }else{
            echo "Ocorreu um erro ao fazer o cadastro, por favor, tente mais tarde !|erro";
            }
              
          }else{
                echo "Limite de cadastros para o Plano Grátis atingido. Contrate um Plano Premium e continue cadastrando !|erro";
            }
		}
	}
}elseif(isset($abrirCaixa)){
    include("../_classes/AbrirFecharCaixa.class.php");
    $troco=trim($troco);
    $valLimit=trim($valLimit);
    if($table=="usuarios"){
    $funcionario="a";
    }elseif(isset($_SESSION['Gerabar_Ocodigo'])){
    $funcionario=$_SESSION['Gerabar_Ocodigo'];
    }else{
    $funcionario="isento";
    }
    $qualFechar=AbrirFecharCaixa::selAbrirCaixa($id_empresa,$funcionario);
    if($qualFechar['num']>0){
        echo "Já existe um caixa aberto nesse ambiente !|erro";
    }elseif($troco=="" || $troco=='0.00'){
        echo "Coloque o valor de troco para o caixa !|i_troco_cx";
    }else if($valLimit=="" || $valLimit=="0.00"){
        echo "Coloque o limite do caixa para a sangria !|i_limiti_cx";
    }else{
        $abriFecha=($qualAbrir=="i_reabrir_caixa")?true:false;
        if(AbrirFecharCaixa::insertAbrirCaixa($id_empresa,$troco,$valLimit,$funcionario,$abriFecha)){
        echo "Caixa aberto com sucesso !|";
        }else{
        echo "Ocorreu um erro ao tentar abrir o caixa, por favor, tente novamente !|erro";
        }
    }    
}elseif(isset($cadastro) AND $cadastro=="cad_comanda_cliente"){
		if($comanda==""){
		echo 'Comanda está em branco !|cmd_cad_cliente';
		}elseif(strlen($comanda)<2){
		echo 'Comanda é inválida !|cmd_cad_cliente';
		}elseif($pagarEntrada=="" && $contaEntrada>0){
		echo 'Pagar comanda na entrada sim ou não ?|pagar_cmd_cliente';
		}elseif($opcEntrada=="" && $contaEntrada>0){
		echo 'Escolha uma opção de entrada !|opc_cmd_cliente';
		}elseif($pedagio==""){
		echo 'Por favor, escolha uma opção de vale !|pedagio_cad_cliente';
		}else{
			include("../_classes/Comandas.class.php");
			$verComanda=Comandas::clienteCmd($id_empresa,$comanda);
			$passarPedagio=false;
			if($verComanda['num']>0){
			echo 'Essa comanda já está cadastrada !|cmd_cad_cliente';
			}elseif($pedagio=="sim"){
				if($valPedagio=="" || $valPedagio=="0,00"){
				echo 'Por favor, coloque o valor do vale !|val_pedagio_cad_cliente';
				}else{
				$passarPedagio=true;
				}
			}else{
				$passarPedagio=true;
			}			
			$pEntrada=($pagarEntrada=="sim")?1:0;
			if($passarPedagio==true){
				$valConsu=explode('-',$opcEntrada.'-0');
				if($table=="usuarios"){
				$aberta_por="a";
				}elseif(isset($_SESSION['Gerabar_Ocodigo'])){
				$aberta_por=$_SESSION['Gerabar_Ocodigo'];
				}else{
				$aberta_por="isento";
				}
				if(Comandas::insertCmdClientes($comanda,$valConsu[0],$pEntrada,(int)$valConsu[1],strip_tags($pedagio),strip_tags($valPedagio),(int)$idCliente,$aberta_por)){
				echo 'Comanda cadastrada com sucesso !|';
				}else{
				echo "Ocorreu um erro ao fazer o cadastro da comanda, por favor, tente mais tarde !|erro";
				}
			}
		}

}elseif(isset($_GET['frenteCaixa'])){
    extract($_GET);
    include("../_classes/FrenteCaixa.class.php");
    
    if(!isset($descontarFrente)){
    if(($frenteCaixa=="salva" || (isset($qualMuda) && $qualMuda!="i_val_unitario")) && (int)$idProduto!=0){
    $quantidade=(isset($qualMuda))?(int)$quantProd:1;        
        if($quantidade>0){        
        include("../_classes/Comandas.class.php");
        $consultaComanda=Comandas::consultaComandaBar($id_empresa,$codInterno);
            $quantCadastrada=$consultaComanda["dados"][1];
            if($consultaComanda["num"]==0){
            echo 'Produto não cadastrado no sistema !|erro';
            exit();
            }elseif($quantCadastrada==0){
            echo 'Produto em falta no estoque !|erro';
            exit();
            }elseif($quantCadastrada<$quantidade){
            echo 'tem apenas mais "'.$quantCadastrada.'" disponível no estoque !|i_quant_unitario';
            exit();
            }
        }
    }
    }
    
    if($table=="usuarios"){
    $funcionario="a";
    }elseif(isset($_SESSION['Gerabar_Ocodigo'])){
    $funcionario=$_SESSION['Gerabar_Ocodigo'];
    }else{
    $funcionario="isento";
    }
    
    if(isset($descontarFrente)){
        if(FrenteCaixa::insertDescontarFrente($id_empresa,$funcionario,$descontarFrente)){
        echo '|';
        }else{
        echo 'Ocorreu um erro inesperado ao salvar compra, por favor, tente novamente !';        
        }
        
    }elseif($frenteCaixa=="salva"){
        $retFrente=FrenteCaixa::insertFrente($id_empresa,$codInterno,strip_tags($nomeProduto),$valorCompra,$valorUnit,1,(int)$idProduto,$funcionario);
        
        if($retFrente!=false){
        echo $retFrente.'|';
        }else{
        echo 'Ocorreu um erro inesperado ao salvar compra, por favor, tente novamente !';    
        }
        
    }elseif($frenteCaixa=="atualiza"){
            if(FrenteCaixa::updateFrente($id_empresa,$valorUnit,(int)$quantProd,$idProduto,$funcionario)){
            echo '|';
            }else{
            echo 'Ocorreu um erro inesperado ao salvar compra, por favor, tente novamente !';    
            }
    }else{
        echo 'Ocorreu um erro inesperado ao salvar compra, por favor, tente novamente !';
    }
    
}elseif(isset($cadastro) AND $cadastro=="comanda_bar"){
			if($garcon==""){
			echo "Garçon / funcionário está em branco !|cd_garcon";
			}elseif($comanda==""){
			echo $cmdMesa." está em branco !|cd_comanda";
			}else{
				if($cmdMesa=="mesa"){
				$comanda = (int)$comanda;
				
				}else{
					if(strlen($comanda)==1){
					$comanda = '0'.$comanda;
					}
				}
			if(Cadastros::versetem($id_empresa,$garcon,'codigo','operadores')==false){
			echo "Garçon / funcionário não encontrado !|cd_garcon";
			}else{
				if($cmdMesa<>"mesa"){
				if(Cadastros::versetem($id_empresa,$comanda,'comanda','clientes')==false){
				echo "Esta comanda não está aberta !|cd_comanda";
				exit();
				}
				}
			include("../_classes/Comandas.class.php");
			$idproduto=array();
			$marca=array();
			$descricao=array();
			$valor=array();
            $valorCompra=array();
			$contar = count($produto);	
			for($i=0; $i<$contar; $i++){
				if($produto[$i]==""){
					echo "Produto está em branco ".$produto[$i]." !|cd_produto_cmd-".$i;
					exit();
				}
				
				if($txtDiverso[$i]=="diverso-true" && $salValDiverso=="0.00"){
					echo "Coloque o valor do produto diverso !|cd_valDiv_cmd_".$i;
					exit();
				}
				
				if($quantidade[$i]==""){
					echo "Quantidade está em branco !|cd_qtd_cmd_".$i;
					exit();
				}
					
				if($txtDiverso[$i]=="diverso-true"){
				$idproduto[$i]=0;
				$marca[$i]='(Diversos)';
				$descricao[$i]=$produto[$i];
				$valor[$i]=$salValDiverso[$i];
                $result=$salValDiverso[$i]/100;
			    $valorCompra[$i]=$salValDiverso[$i]-(50*$result);
				}else{
					
					$consultaComanda=Comandas::consultaComandaBar($id_empresa,$produto[$i]);
					$quantCadastrada=$consultaComanda["dados"][1];
					if($consultaComanda["num"]==0){
					echo "Produto não cadastrado no sistema !|cd_produto_cmd-".$i;
					exit();
					}elseif($quantCadastrada==0){
					echo 'Produto em falta no estoque !|cd_produto_cmd-'.$i;
					exit();
					}elseif($quantCadastrada<$quantidade[$i]){
					echo 'tem apenas "'.$quantCadastrada.'" disponível no estoque !|cd_qtd_cmd_'.$i;
					exit();
					}else{
					$idproduto[$i]=$consultaComanda["dados"][0];
					$marca[$i]=$consultaComanda["dados"][2];
					$descricao[$i]=$consultaComanda["dados"][3];
					$valor[$i]=$consultaComanda["dados"][4];
                    $valorCompra[$i]=$consultaComanda["dados"][5];
					}
				}
				
			}
			
			for($i=0; $i<$contar; $i++){
			$CodProduto=($idproduto[$i]==0)?0:$produto[$i];
			if(Comandas::insertComandaBar($id_empresa,$garcon,$comanda,strip_tags($CodProduto),(int)$quantidade[$i],(int)$idproduto[$i],strip_tags($marca[$i]),strip_tags($descricao[$i]),$valor[$i],$valorCompra[$i],$cmdMesa)==false){	
			echo "Ocorreu um erro ao fazer o cadastro, por favor, tente mais tarde !|erro";
			exit();
			}
			if($i==($contar-1)){$tudoOk=true;}
			}			
			if(isset($tudoOk)){
				if($cmdMesa=="mesa"){$comanda=($comanda<10)?'0'.$comanda:$comanda;}
				if($contar==1){					
				$nomeEnvia=($idproduto[0]==0)?$descricao[0]." ".$marca[0]:$marca[0]." ".$descricao[0];					
				echo $nomeEnvia." cadastrado na ".$cmdMesa." ".$comanda."|";
				}else{
				echo "Produtos cadastrados na ".$cmdMesa." ".$comanda." com sucesso !|";
				}
			}
			}
			}
}elseif(isset($descEntrada)){
	$contar = count($descEntrada);
	$para = ($contar-1);
	if($contar>1){ $uni = 'Cadastros feitos';}else{ $uni = 'Cadastro feito';}
	if(trim($descEntrada[0])==""){
	echo "Descrição está em branco !|cd_descEntrada_0";
	}else{
		for($i=0; $i<$contar; $i++){
			if(Cadastros::verCadastro("entradas",trim($descEntrada[$i]),$id_empresa)==true){
				echo 'Essa descrição de entrada já está cadastrada !|cd_descEntrada_'.$qualNum[$i];
				exit();
			}
		}
		for($i=0; $i<$contar; $i++){
			if(Cadastros::insertCadEntrada($id_empresa,strip_tags(trim($descEntrada[$i])),trim($valEntrada[$i]),$consuEntrada[$i])==false){
			echo "Ocorreu um erro ao fazer o cadastro, por favor, tente mais tarde !|erro";
			exit();
			}
			if($i==$para){
				echo $uni." com sucesso !|";
			}
		}
	}

}elseif(isset($cadastro) AND $cadastro=="array"){
	$contar = count($qualArray);
	$para = ($contar-1);
	if($contar>1){ $uni = 'Cadastros feitos';}else{ $uni = 'Cadastro feito';}
	if(trim($qualArray[0])==""){
	echo "Campo está em branco !|cd_".$tabArray."_array_0";
	}else{		
		for($i=0; $i<$contar; $i++){
			if(Cadastros::verCadastro($tabArray,strip_tags(trim($qualArray[$i])),$id_empresa)==true){
				echo '"'.$qualArray[$i].'" já está cadastro em '.$tabArray.' !|cd_'.$tabArray.'_array_'.$qualNum[$i];
				exit();
			}
		}
		for($i=0; $i<$contar; $i++){
			if(Cadastros::insertCadArray($id_empresa,strip_tags(trim($qualArray[$i])),strip_tags($tabArray))==false){
			echo "Ocorreu um erro ao fazer o cadastro, por favor, tente mais tarde !|erro";
			exit();
			}
			if($i==$para){
			if(isset($status) AND $status=="envia_empresa"){
				if(Cadastros::altStatusEmpresa(2,$id_empresa)){
				echo $uni." com sucesso !|";
				}else{
				echo "Ocorreu um erro ao alterar o status da empresa, por favor, tente mais tarde !|erro";
				}
			}else{
				echo $uni." com sucesso !|";
			}
			}
		}
	}

}elseif(isset($razao)){
	$razao=trim($razao);
	$cep=trim($cep);
	$endereco=trim($endereco);
	$complemento=trim($complemento);
	$bairro=trim($bairro);
	$estado=trim($estado);
	$tel=trim($tel);
	$cnpjCpf=trim($cnpjCpf);	
	$numero=($numero==0)?$numero:(int)$numero;
	
	if($razao==""){
	echo "Nome do negócio está em branco !|razao_empresa";
	}elseif($cnpjCpf==""){
	echo "CNPJ ou CPF está em branco !|cnpjCpf_empresa";
	}else{
		$passar = false;
		if(strlen($cnpjCpf)==14){		
			$exs = explode('-',$cnpjCpf);
			 $exs2 = explode('.',$exs[0]);
			 $cpf = $exs2[0].$exs2[1].$exs2[2];			
			if(Validar::validar_cpf($cpf,$exs[1])==false){
				echo "O CPF informado é inválido !|cnpjCpf_empresa";
			}elseif(Cadastros::versetem(0,$cnpjCpf,'cpf_ou_cnpj','empresas',$id_empresa)==true){
				echo "O CPF informado já está cadastrado em nosso sistema !|cnpjCpf_empresa";
			}else{
				$passar=true;
			}			
		}elseif(strlen($cnpjCpf)==18){			
			if(Validar::validar_cnpj($cnpjCpf)==false){
				echo "O CNPJ informado é inválido !|cnpjCpf_empresa";
			}elseif(Cadastros::versetem(0,$cnpjCpf,'cpf_ou_cnpj','empresas',$id_empresa)==true){
				echo "O CNPJ informado já está cadastrado em nosso sistema !|cnpjCpf_empresa";
			}else{
				$passar=true;
			}			
		}else{
			echo "Cnpj ou cpf inválido !|cnpjCpf_empresa";
		}        
		if($passar==true){
            if($tel==""){
            echo "Telefone está em branco !|tel_empresa";
            }elseif($cep==""){
            echo "Cep está em branco !|cep_empresa";
            }elseif($endereco==""){
            echo "Endereço está em branco !|endereco_empresa";
            }elseif($numero==""){
            echo "Número está em branco !|numero_empresa";
            }elseif($bairro==""){
            echo "Bairro está em branco !|bairro_empresa";
            }elseif($cidade==""){
            echo "Cidade está em branco !|cidade_empresa";
            }elseif($estado==""){
            echo "Estado está em branco !|estado_empresa";
            }else{
			include("../_classes/Empresas.class.php");
			if(isset($upInsert) AND strip_tags($upInsert)=="cadastrar"){
            if(Empresas::insertEmpresa($idDaSessao,strip_tags($razao),strip_tags($cep),strip_tags($endereco),strip_tags($numero),strip_tags($complemento),strip_tags($bairro),strip_tags($cidade),strip_tags($estado),strip_tags($tel),strip_tags($cnpjCpf))){
					$dadosEmpresa = Empresas::selectEmpresa($idDaSessao);
					if($dadosEmpresa['num']>=1){
						$cadEmpresa=DB::getConn()->prepare("UPDATE usuarios SET id_empresa=? WHERE id=?");
						if($cadEmpresa->execute(array($dadosEmpresa['dados'][0],$idDaSessao))){
                            $senhaUsuario=Cadastros::selDadosUsuario($idDaSessao);
                            include('../_classes/Operadores.class.php');
                            Operadores::insertOperador($dadosEmpresa['dados'][0],"Administrador",0,$senhaUsuario['dados']['senha'],1);
                            $verIdPlano=Empresas::selectPlano($idDaSessao);
                            if($verIdPlano['num']>0){
                                if(Empresas::upEmpresaPlano($idDaSessao,$dadosEmpresa['dados'][0])){
                                    echo "2|";
                                }else{
                                    echo "Ocorreu um erro ao salvar empresa nos planos, por favor, contate a equipe Gerabar !|erro";
                                }
                            }else{                                
						      echo "2|";
                            }                            
						}else{
						echo "Ocorreu um erro ao fazer o cadastro, por favor, tente mais tarde !|erro";
						}
					}else{
					echo "Ocorreu um erro ao fazer o cadastro, por favor, tente mais tarde !|erro";
					}
				}else{
					echo "Ocorreu um erro ao fazer o cadastro, por favor, tente mais tarde !|erro";
				}			
			}else{				if(Empresas::updateEmpresa($id_empresa,$idDaSessao,strip_tags($razao),strip_tags($cep),strip_tags($endereco),strip_tags($numero),strip_tags($complemento),strip_tags($bairro),strip_tags($cidade),strip_tags($estado),strip_tags($tel),strip_tags($cnpjCpf))){
					echo "Dados alterados com sucesso !|";
				}else{
					echo "Ocorreu um erro ao fazer o cadastro, por favor, tente mais tarde !|erro";
				}
			}
            }
		}	
	}
}elseif(isset($selAmb)){
	include("../_classes/Empresas.class.php");
	if($selAmb=="amb_baladas"){
	$ambId=1;
	}elseif($selAmb=="amb_bares"){
	$ambId=2;
	}else{
	$ambId=0;
	}
	if($ambId==0){
	echo "Ocorreu um erro ao salvar o ambiente, por favor, tente novamente !";
	}else{
          
		if(Empresas::updateAmbEmpresa($id_empresa,$ambId)){
			if($local=="proximo"){
			echo(Cadastros::altStatusEmpresa(2,$id_empresa))?"":"Ocorreu um erro ao ir para o próximo passo, por favor, tente mais tarde !";
			}else{
				echo "";
			}
		}else{
			echo "Ocorreu um erro ao salvar o ambiente, por favor, tente mais tarde !";
		}
        
	}
}elseif(isset($salvosAmb)){
	$conta=count($salvosAmb);
	$varAmb="";	
	$numVer=0;
	for($i=0; $i<$conta; $i++){
		if($salvosAmb[$i]=="identificar"){
		$numVer=1;	
		}elseif($i==$numVer){
		$varAmb=$salvosAmb[$i];
		}else{
		$varAmb.=",".$salvosAmb[$i];
		}
	}
    
    if($idAmb=="admin"){
        if(Cadastros::altPgsAmb($idDaSessao,strip_tags($varAmb))){
            echo "|";    
        }else{
            echo "Ocorreu um erro ao salvar as páginas do ambiente, por favor, tente novamente !|erro";   
        }
    }else{
        include('../_classes/Empresas.class.php');
        if(Empresas::uptadeAmbPg($id_empresa,(int)$idAmb,strip_tags($varAmb),$numVer)){
        echo "|";
        }else{
        echo "Ocorreu um erro ao salvar as páginas do ambiente, por favor, tente novamente !|erro";
        }
    }
    
	
}elseif(isset($acessoAmb)){
	include('../_classes/Empresas.class.php');
	$idEmpresa = Empresas::selectEmpresa($idDaSessao);
		include('../_classes/remove_caracteres.php');
		$nomeEmpre = removeAcentos($idEmpresa['dados'][2],'-'); 
		$novoNome ='';
		 for($j=0;$j<=strlen($nomeEmpre);$j++){
			if(substr($nomeEmpre,$j,1)=='-'){
				$novoNome.='';	
				}else{
				$novoNome.=substr($nomeEmpre,$j,1);
				}
			}
		$pAcesso= substr($novoNome,0,7)."_";
		$acessoAmb=trim($acessoAmb);
		$nomeAmb=trim($nomeAmb);
		$senhaAmb=trim($senhaAmb);
	if($acessoAmb==""){
		echo 'Nome de acesso está em branco !|i_acessoAmb';
	}elseif(Cadastros::versetem(0,strip_tags($pAcesso.$acessoAmb),'acesso_amb','ambientes')==true){
		echo "Nome de acesso já cadastrado !|i_acessoAmb";
	}elseif($nomeAmb==""){
		echo "Nome do novo ambiente está em branco !|i_nomeAmb";
	}elseif($senhaAmb==""){
		echo "Senha do novo ambiente está em branco !|i_senhaAmb";
	}elseif(strlen($senhaAmb)<6){
		echo "Senha pequena demais, a senha tem que conter pelo menos 6 caracteres !|i_senhaAmb";
	}elseif(!preg_match("/^(?=.*\d)(?=.*[a-z])(?!.*\s).*$/",$senhaAmb)){
	echo "Senha em branco ou pequena de mais !|i_senhaAmb";
	}else{
        
        if(Cadastros::plano_cadastro_ativo($planoAtivo,$id_empresa,"ambientes",2)==true){
        
		if(Empresas::insertAmb($id_empresa,strip_tags($pAcesso.$acessoAmb),strip_tags($nomeAmb),strip_tags($senhaAmb))){
			$idAmb=Empresas::ultIdAmb($id_empresa);
			if($idAmb['num']>0){
				echo $idAmb['dados'][0]."|";
			}else{
			echo "Ocorreu um erro ao salvar o login de ambiente, por favor, tente novamente !|erro";
			}
		}else{
			echo "Ocorreu um erro ao salvar o login de ambiente, por favor, tente novamente !|erro";
		}
        
        }else{
            echo "Limite de cadastros para o Plano Grátis atingido. Contrate um Plano Premium e continue cadastrando !|erro";
        }
        
	}
}elseif(isset($nomeOpe)){
	include('../_classes/Operadores.class.php');
	$nomeOpe=trim($nomeOpe);
	$codOpe=($codOpe==0)?$codOpe:(int)$codOpe;
	$senhaOpe=trim($senhaOpe);
	if($nomeOpe==""){
		echo 'Nome do operador está em branco !|i_nomeOpe';
	}elseif($codOpe==""){
		echo "Código está em branco !|i_codOpe";
	}elseif(Cadastros::versetem($id_empresa,$codOpe,'codigo','operadores')==true){
		echo "Código já cadastrado !|i_codOpe";
	}elseif($senhaOpe==""){
		echo "Senha do novo operador está em branco !|i_senhaOpe";
	}elseif(strlen($senhaOpe)<6){
		echo "Senha pequena demais, a senha tem que conter pelo menos 6 caracteres !|i_senhaOpe";
	}else{
        $senha=sha1(strip_tags($senhaOpe));        
		if(Operadores::insertOperador($id_empresa,strip_tags($nomeOpe),$codOpe,$senha)){
			$idOpe=Operadores::ultIdOpe($id_empresa);
			if($idOpe['num']>0){
				echo $idOpe['dados'][0]."|";
			}else{
			echo "Ocorreu um erro ao cadastrar o operador, por favor, tente novamente !|erro";
			}
		}else{
			echo "Ocorreu um erro ao cadastrar o operador, por favor, tente novamente !|erro";
		}
        
	}

}elseif(isset($qMesa)){	
	if($qMesa==""){
		echo 'Quantidade de mesa não pode ser igual a "'.$qMesa.'"|erro';
	}else{        
        if($planoAtivo==1 || $qMesa<=3){        
		include("../_classes/Mesas.class.php");
		if(Mesas::insertMesa($id_empresa,(int)$qMesa)){
		echo "Cadastro feito com sucesso !|";
		}else{
		echo "Ocorreu um erro ao cadastrar quantidade de mesas, por favor, tente novamente !|erro";
		}            
        }else{
            echo "O limite para o Plano Grátis é de 3 mesas. Contrate um Plano Premium e continue cadastrando !|erro";
        }
	}
}else{
echo "Ocorreu algum erro inesperado, por favor, tente novamente mais tarde !|erro";
}