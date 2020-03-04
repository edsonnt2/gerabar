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
include("../_classes/Cadastros.class.php");
$idDaSessao = $_SESSION['Gerabar_uid'];
$table = $_SESSION['Gerabar_table'];
$planoAtivo=$_SESSION['Gerabar_plano'];
$idEmpre = Cadastros::selectIdEmpresa($idDaSessao,$table);
$id_empresa=($idEmpre['num']>0)?$idEmpre['dados'][0]:0;

extract($_GET);
	
if(isset($rementeCmd) AND isset($qualPg)){
	if($qualPg=="comandas"){
	include("../_classes/Comandas.class.php");
	$sexo=($rementeCmd=="zeraCmdRecente")?false:true;
	echo (Comandas::zerarRecentes($id_empresa,$sexo)==true)?"|":"Ocorreu um erro ao tentar zerar relatório, por favor, tente novamente mais tarde !|erro";	
	}elseif($qualPg=="contas"){
	include("../_classes/Clientes.class.php");
	$sexo=($rementeCmd=="zeraCmdRecente")?false:true;
	echo (Clientes::zerarRecentes($id_empresa,$sexo)==true)?"|":"Ocorreu um erro ao tentar zerar relatório, por favor, tente novamente mais tarde !|erro";	
	}elseif($qualPg=="mesas"){
	include("../_classes/Mesas.class.php");
	echo (Mesas::zerarRecentes($id_empresa)==true)?"|":"Ocorreu um erro ao tentar zerar relatório, por favor, tente novamente mais tarde !|erro";	
	}elseif($qualPg=="vendas"){
	include("../_classes/FrenteCaixa.class.php");
	echo (FrenteCaixa::zerarRecentes($id_empresa)==true)?"|":"Ocorreu um erro ao tentar zerar relatório, por favor, tente novamente mais tarde !|erro";	
	}elseif($qualPg=="caixas"){
	include("../_classes/AbrirFecharCaixa.class.php");
	echo (AbrirFecharCaixa::zerarRecentes($id_empresa)==true)?"|":"Ocorreu um erro ao tentar zerar relatório, por favor, tente novamente mais tarde !|erro";	
	}

}elseif(isset($_POST["senhaMaster"])){
	extract($_POST);
	if($senhaMaster==""){
	echo "Senha master está em branco !|senha_master";
	}else{
		if(Cadastros::verSenhaMaster($id_empresa,strip_tags($senhaMaster))==true){
		echo "|";
		}else{
		echo "Senha master incorreta !|senha_master";
		}
	}

}elseif(isset($buscaTransfere)){
		$clientes = Cadastros::selectArray($id_empresa,'clientes',0,30);
			if($clientes['num']>0){
				echo '
				<input type="text" placeholder="Busque por nome, cpf, rg, e-mail ou telefone..." id="i_subBuscaTxt" autocomplete="off" />
				<button id="i_subBuscaEnvia" class="buscaTransferi"></button>
				<ul id="subbusca_buscaTransferi">';
				$n=1;
				foreach($clientes['dados'] as $AsClientes){
					echo '<li '; if($n==1){ echo 'class="bAtivo"';} $n++; echo '><span class="'.$AsClientes['id'].'">'.$AsClientes['nome'].'</span></li>';
				}
				echo '</ul>';
			}else{
				echo '<h1 class="faltaNaBusca">Nenhum cliente foi encontrado !</h1>';
			}
			
}elseif(isset($idproduto) AND isset($clienteProduto)){
    
if($clienteProduto=="clientes"){
    $tabelaCP="clientes";
    $qtdC=21;
}else{
    $tabelaCP="produtos";
    $qtdC=31;
}
if(Cadastros::plano_cadastro_ativo($planoAtivo,$id_empresa,$tabelaCP,$qtdC)==true){
    
$contar=count($idproduto);

echo '<div id="dentro_fundo_preto">
        <div id="topo_fundo_preto">
            <h2>alterar '.$clienteProduto.'</h2>
            <div>
				<button type="submit" id="enviaEdita_tudo" class="atualiza_'.$clienteProduto.'">salvar todos</button>
                <span id="x_fecha_fundo2"><a href="javascript:void(0);" title="Fechar" id="fecha_editaEstCli"></a></span>
            </div>
        </div><!--fecha topo fundo preto 2-->        
        	<ul id="centro_fundo_preto">';

	if($clienteProduto=="clientes"){
			for($i=0;$i<$contar;$i++){
			$clientes = Cadastros::selectArray($id_empresa,$clienteProduto,false,false,$idproduto[$i]);
			
			if($clientes['num']>0){
			?>
			<script type="text/javascript">
			$(function(){
				$(".i_cliente_data").mask("99/99/9999");
				$(".i_cliente_cpf").mask("999.999.999-99");
				$(".i_cliente_rg").mask("99.999.999-9");
				$(".i_cliente_cnpj").mask("99.999.999/9999-99");
				$(".for_tel").mask("(99) 99999-999?9");
			});
			</script>
			
			<?php
				echo '<span style="display:none" id="qual_amb">'; echo (isset($ambCaixa) AND $ambCaixa==1)?'1':'0'; echo '</span>';
				$trasCliente=$clientes['dados'];			
			echo '<li id="'.$trasCliente['id'].'" class="conta-li">
					<h2>editar cliente de cógido '.$trasCliente['id'].'</h2>
					
					<form method="post" action="">
					
					<div class="d_linha_separa">
						<h2>dados pessoais</h2>
					</div>
					
					<div class="d_alinha_edita">
					
						<div class="d_left_edita">
							<span><label for="cliente_'.$i.'_1">nome:</label></span>
							<input type="text" id="cliente_'.$i.'_1" class="i_cliente_nome" value="'.$trasCliente['nome'].'" />
							<div class="d_aviso_erro" id="erro_cliente_'.$i.'_1"><div class="d_ponta-erro"></div><p></p></div><!--d_aviso_erro-->
						</div><!--fecha d_left_edita-->
						
						<div class="d_left_edita">
							<span><label for="cliente_'.$i.'_3">data de nascimento:</label></span>
							<input type="text" id="cliente_'.$i.'_3" class="i_cliente_data" value="'; if($trasCliente['nascimento']!="0000-00-00"){ echo date('d/m/Y',strtotime($trasCliente['nascimento'])); } echo '" placeholder="XX/XX/XXXX" />
							<div class="d_aviso_erro" id="erro_cliente_'.$i.'_3"><div class="d_ponta-erro"></div><p></p></div><!--d_aviso_erro-->
						</div><!--fecha d_left_edita-->
						
						<div class="d_left_edita">
							<span><label for="cliente_'.$i.'_4">sexo:</label></span>
							<select id="cliente_'.$i.'_4" class="i_cliente_sexo">';
									if($trasCliente['sexo']=="M"){$sexoM=' selected="selected"';$sexoH='';}elseif($trasCliente['sexo']=="H"){$sexoM='';$sexoH=' selected="selected"';}else{$sexoM='';$sexoH='';}
									echo '<option value="">selecione</option>
									<option value="H"'.$sexoH.'>HOMEM</option>
									<option value="M"'.$sexoM.'>MULHER</option>
								</select>
							<div class="d_aviso_erro" id="erro_cliente_'.$i.'_4"><div class="d_ponta-erro"></div><p></p></div><!--d_aviso_erro-->
						</div><!--fecha d_left_edita-->
					
					</div><!--fecha d_alinha_edita-->
					
					<div class="div_tipo_pessoa" id="'.$i.'_num">
					
							<div class="form_tipo_pessoa">
								<h2>tipo pessoa:</h2> 
								<ul id="ul_qual_pessoa_'.$i.'">
									<li style="border:0;"><span>Física</span></li>
									<li style="display:none;" class="ult_pessoa"><span>Jurídica</span></li>
									<span class="muda_pessoa muda_'.$i.'"></span>
								</ul>
							</div>
						
							<div id="'.$i.'-pessoa_fisica" class="pessoa_ativo" '; 
							if($trasCliente['tipo_pessoa']=='pessoa_juridica'){ 
								echo 'style="display:none;"';
								$cpf = '';
								$rg = '';
								$cnpj = $trasCliente['cpf_ou_cnpj'];
								$estadual = $trasCliente['rg_ou_estadual'];
							}else{
								$cpf = $trasCliente['cpf_ou_cnpj'];
								$rg = $trasCliente['rg_ou_estadual'];
								$cnpj='';
								$estadual='';
							} echo '>
								
								<div class="d_alinha_edita">
					
									<div class="d_left_edita">
										<span><label for="cliente_'.$i.'_11">cpf:</label></span>
										<input type="text" id="cliente_'.$i.'_11" class="i_cliente_cpf" value="'.$cpf.'" placeholder="XXX.XXX.XXX-XX" />
										<div class="d_aviso_erro" id="erro_cliente_'.$i.'_11"><div class="d_ponta-erro"></div><p></p></div><!--d_aviso_erro-->
									</div><!--fecha d_left_edita-->
									
									<div class="d_left_edita">
										<span><label for="cliente_'.$i.'_12">rg:</label></span>
										<input type="text" id="cliente_'.$i.'_12" class="i_cliente_rg" value="'.$rg.'" placeholder="XX.XXX.XXX-X" />
										<div class="d_aviso_erro" id="erro_cliente_'.$i.'_12"><div class="d_ponta-erro"></div><p></p></div><!--d_aviso_erro-->
									</div><!--fecha d_left_edita-->
														
								</div><!--fecha d_alinha_edita-->
							
							</div><!--fecha pessoa física-->
							
							<div id="'.$i.'-pessoa_juridica" '; if($trasCliente['tipo_pessoa']<>'pessoa_juridica'){ echo 'style="display:none;"';} echo '>
							
								<div class="d_alinha_edita">
					
									<div class="d_left_edita">
										<span><label for="cliente_'.$i.'_13">cnpj:</label></span>
										<input type="text" id="cliente_'.$i.'_13" class="i_cliente_cnpj" value="'.$cnpj.'" placeholder="XX.XXX.XXX/XXXX-XX" />
										<div class="d_aviso_erro" id="erro_cliente_'.$i.'_13"><div class="d_ponta-erro"></div><p></p></div><!--d_aviso_erro-->
									</div><!--fecha d_left_edita-->
									
									<div class="d_left_edita">
										<span><label for="cliente_'.$i.'_14">inscrição estadual:</label></span>
										<input type="text" id="cliente_'.$i.'_14" class="i_cliente_estadual" value="'.$estadual.'" />
										<div class="d_aviso_erro" id="erro_cliente_'.$i.'_14"><div class="d_ponta-erro"></div><p></p></div><!--d_aviso_erro-->
									</div><!--fecha d_left_edita-->
														
								</div><!--fecha d_alinha_edita-->
							
							</div><!--fecha pessoa jurídica-->
						
						</div><!-- fecha div tipo pessoa-->
					
					<div class="d_linha_separa"><h2>contatos</h2></div>
					
					<div class="d_alinha_eidta">
					
						<div class="d_left_edita">
							<span><label for="cliente_'.$i.'_15">telefone:</label></span>
							<input type="text" id="cliente_'.$i.'_15" class="i_cliente_tel for_tel" value="'.$trasCliente['telefone'].'" placeholder="(XX) XXXX-XXXX" />
						</div><!--fecha d_left_edita-->
						
						<div class="d_left_edita">
							<span><label for="cliente_'.$i.'_18">email:</label></span>
							<input type="text" id="cliente_'.$i.'_18" class="i_cliente_email" value="'.$trasCliente['email'].'" placeholder="EX: NOME@EMAIL.COM" />
							<div class="d_aviso_erro" id="erro_cliente_'.$i.'_18"><div class="d_ponta-erro"></div><p></p></div><!--d_aviso_erro-->
						</div><!--fecha d_left_edita-->
						
					</div><!--fecha d_alinha_edita-->
					
					<div class="d_alinha_edita">
					
						<div class="d_left_edita">
							<button type="submit" id="'.$i.'_enviaEdita" class="i_edita_envia atualiza_clientes">salvar</button>
						</div><!--fecha d_left_edita-->
					
					</div><!--fecha d_alinha_edita-->
					
					</form>
					
				</li>';
			
				}}
				
	}else{

	for($i=0;$i<$contar;$i++){
	$produtos = Cadastros::selectArray($id_empresa,'produtos',false,false,$idproduto[$i]);
	if($produtos['num']>0){	
			?>
			<script type="text/javascript">
			
			$(function(){                
				$('input.for-valor').priceFormat({
				prefix: '',
				centsSeparator: ',',
				thousandsSeparator: '.'
				});
				
				$('input.i_edita_margem').priceFormat({
				prefix: '',
				centsSeparator: '',
				thousandsSeparator: '.',
				centsLimit: 0
				});
					
			});
			</script>
			<?php
		$trasProduto=$produtos['dados'];
		echo '<li id="'.$trasProduto['id'].'" class="conta-li">
			<h2>editar produto de cógido '.$trasProduto['id'].'</h2>
			<form method="post" action="">
			<div class="d_alinha_edita">
				<div class="d_left_edita for-marca">
					<span><label for="cd_produto_'.$i.'_1_marca">marca:</label></span>';
							$marca = Cadastros::selectArray($id_empresa,'marcas');
							if($marca['num']>0){
								echo '<div class="d_alinha_submenu">
									<input type="text" id="cd_produto_'.$i.'_1_marca" class="i_edita_marca" value="'.$trasProduto['marca'].'" autocomplete="off" />
									<div class="bt_submenu"><span class="'.$i.'_1_marca"></span></div>
									<ul id="submenu_'.$i.'_1_marca">';
								foreach($marca['dados'] as $AsMarca){
									echo '<li><span class="'.$i.'_1_marca">'.$AsMarca['marcas'].'</span></li>';
								}
								echo '</ul>
								<ul id="busca_cd_produto_'.$i.'_1_marca"></ul>
								
								</div><!--d_alinha_submenu-->';
							}else{
								echo '<input type="text" id="cd_produto_'.$i.'_1_marca" class="i_edita_marca" value="'.$trasProduto['marca'].'" />';
							}
						echo '
						<div class="d_aviso_erro" id="erro_cd_produto_'.$i.'_1_marca"><div class="d_ponta-erro"></div><p></p></div><!--d_aviso_erro-->
				</div><!--fecha d_left_edita-->
				<div class="d_left_edita">
					<span><label for="cd_produto_'.$i.'_2_descricao">descrição:</label></span>
					<input type="text" id="cd_produto_'.$i.'_2_descricao" class="i_edita_descricao" value="'.$trasProduto['descricao'].'" />
					<div class="d_aviso_erro" id="erro_cd_produto_'.$i.'_2_descricao"><div class="d_ponta-erro"></div><p></p></div><!--d_aviso_erro-->
				</div><!--fecha d_left_edita-->
				<div class="d_left_edita for-unidade">
					<span><label for="cd_produto_'.$i.'_3_unidade">unidade de venda:</label></span>';
					$unidade = Cadastros::selectArray($id_empresa,'unidade_venda');
							if($unidade['num']>0){
								echo '<div class="d_alinha_submenu">
									<input type="text" id="cd_produto_'.$i.'_3_unidade" class="i_edita_unid" value="'.$trasProduto['unidade_venda'].'" autocomplete="off" />
									<div class="bt_submenu"><span class="'.$i.'_3_unidade"></span></div>
									<ul id="submenu_'.$i.'_3_unidade">';
								foreach($unidade['dados'] as $AsUnidade){
									echo '<li><span class="'.$i.'_3_unidade">'.$AsUnidade['unidade_venda'].'</span></li>';
								}
								echo '</ul>
								<ul id="busca_cd_produto_'.$i.'_3_unidade"></ul>
								
								</div><!--d_alinha_submenu-->';
							}else{
								echo '<input type="text" id="cd_produto_'.$i.'_3_unidade" class="i_edita_unid" value="'.$trasProduto['unidade_venda'].'" />';
							}
					echo '
					<div class="d_aviso_erro" id="erro_cd_produto_'.$i.'_3_unidade"><div class="d_ponta-erro"></div><p></p></div><!--d_aviso_erro-->
				</div><!--fecha d_left_edita-->		
			</div><!--fecha d_alinha_edita-->		
			<div class="d_alinha_edita">		
				<div class="d_left_edita for-categoria">
					<span><label for="cd_produto_'.$i.'_4_categoria">categoria:</label></span>';				
						$categoria = Cadastros::selectArray($id_empresa,'categorias');
							if($categoria['num']>0){
								echo '<div class="d_alinha_submenu">
									<input type="text" id="cd_produto_'.$i.'_4_categoria" class="i_edita_categoria" value="'.$trasProduto['categoria'].'" autocomplete="off" />
									<div class="bt_submenu"><span class="'.$i.'_4_categoria"></span></div>
									<ul id="submenu_'.$i.'_4_categoria">';
								foreach($categoria['dados'] as $AsCategoria){
									echo '<li><span class="'.$i.'_4_categoria">'.$AsCategoria['categorias'].'</span></li>';
								}
								echo '</ul>
								<ul id="busca_cd_produto_'.$i.'_4_categoria"></ul>							
								</div><!--d_alinha_submenu-->';
							}else{
								echo '<input type="text" id="cd_produto_'.$i.'_4_categoria" class="i_edita_categoria" value="'.$trasProduto['categoria'].'" />';
							}					
					echo '<div class="d_aviso_erro" id="erro_cd_produto_'.$i.'_4_categoria"><div class="d_ponta-erro"></div><p></p></div><!--d_aviso_erro-->
				</div><!--fecha d_left_edita-->			
				<div class="d_left_edita for-fornecedor">
					<span><label for="cd_produto_'.$i.'_5_fornecedor">fornecedor:</label></span>';
					$fornecedor = Cadastros::selectArray($id_empresa,'fornecedores');
							if($fornecedor['num']>0){
								echo '<div class="d_alinha_submenu">
									<input type="text" id="cd_produto_'.$i.'_5_fornecedor" class="i_edita_fornece" value="'.$trasProduto['fornecedor'].'" autocomplete="off" />
									<div class="bt_submenu"><span class="'.$i.'_5_fornecedor"></span></div>
									<ul id="submenu_'.$i.'_5_fornecedor">';
								foreach($fornecedor['dados'] as $AsFornecedor){
									echo '<li><span class="'.$i.'_5_fornecedor">'.$AsFornecedor['fornecedores'].'</span></li>';
								}
								echo '</ul>
								<ul id="busca_cd_produto_'.$i.'_5_fornecedor"></ul>							
								</div><!--d_alinha_submenu-->';
							}else{
								echo '<input type="text" id="cd_produto_'.$i.'_5_fornecedor" class="i_edita_fornece" value="'.$trasProduto['fornecedor'].'" />';
							}
					  echo '<div class="d_aviso_erro" id="erro_cd_produto_'.$i.'_5_fornecedor"><div class="d_ponta-erro"></div><p></p></div><!--d_aviso_erro-->
				</div><!--fecha d_left_edita-->
				<div class="d_left_edita">
					<span><label for="cd_produto_'.$i.'_6_qtd">quantidade:</label></span>
					<input type="text" id="cd_produto_'.$i.'_6_qtd" class="i_edita_qtd" value="'.$trasProduto['quantidade'].'" onKeyPress="return SomenteNumero(event);" maxlength="11" />
					<div class="d_aviso_erro" id="erro_cd_produto_'.$i.'_6_qtd"><div class="d_ponta-erro"></div><p></p></div><!--d_aviso_erro-->
				</div><!--fecha d_left_edita-->
				<div class="d_left_edita">
					<span><label for="cd_produto_'.$i.'_7_codInterno">código interno:</label></span>
					<input type="text" id="cd_produto_'.$i.'_7_codInterno" class="i_edita_codInterno" value="'.$trasProduto['codigo_interno'].'" onKeyUp="return SemEspaco(this);" />
					<div class="d_aviso_erro" id="erro_cd_produto_'.$i.'_7_codInterno"><div class="d_ponta-erro"></div><p></p></div><!--d_aviso_erro-->
				</div><!--fecha d_left_edita-->
			</div><!--fecha d_alinha_edita-->
			<div class="d_linha_separa"></div>
			<div class="d_alinha_edita">
				<div class="d_left_edita">
					<span><label for="cd_produto_'.$i.'_8_valCompra">valor compra:</label></span>
					<input type="text" id="cd_produto_'.$i.'_8_valCompra" class="carrega_valor i_edita_valCompra for-valor" value="'.number_format($trasProduto['valor_compra'],2,',','.').'" autocomplete="off" />
					<input type="hidden" id="salva_cd_produto_'.$i.'_8_valCompra" value="" />
					<div class="d_aviso_erro" id="erro_cd_produto_'.$i.'_8_valCompra"><div class="d_ponta-erro"></div><p></p></div><!--d_aviso_erro-->
				</div><!--fecha d_left_edita-->
				<div class="d_left_edita">
					<span><label for="cd_produto_'.$i.'_8_valCompra-margem">margem:</label></span>
					 <div class="d_ajusta_porcento">
						<input type="text" id="cd_produto_'.$i.'_8_valCompra-margem" class="carrega_margem i_edita_margem" value="'.$trasProduto['margem'].'" maxlength="3" autocomplete="off" />
						<div id="s_porcento">%</div>
						</div>
						<div class="d_aviso_erro" id="erro_cd_produto_'.$i.'_8_valCompra-margem"><div class="d_ponta-erro"></div><p></p></div><!--d_aviso_erro-->
				</div><!--fecha d_left_edita-->
				<div class="d_left_edita">
					<span><label for="cd_produto_'.$i.'_8_valCompra_valVarejo">valor de venda:</label></span>
					<input type="text" id="cd_produto_'.$i.'_8_valCompra_valVarejo" class="i_edita_valVarejo for-valor" value="'.number_format($trasProduto['valor_varejo'],2,',','.').'" autocomplete="off" />
					<div class="d_aviso_erro" id="erro_cd_produto_'.$i.'_8_valCompra_valVarejo"><div class="d_ponta-erro"></div><p></p></div><!--d_aviso_erro-->
				</div><!--fecha d_left_edita-->
			</div><!--fecha d_alinha_edita-->
			<div class="d_alinha_edita">
				<div class="d_left_edita">
					<button type="submit" id="'.$i.'_enviaEdita" class="i_edita_envia atualiza_estoque">salvar</button>
				</div><!--fecha d_left_edita-->
			</div><!--fecha d_alinha_edita-->
			</form>
		</li>';	
		}}
	}

    echo '</ul><!--fecha centro fundo preto 2-->        
     </div><!--fecha dentro fundo preto 2-->';
    
}
	 
}else{
echo "Ocorreu algum erro inesperado, por favor, tente novamente mais tarde !|erro";
}