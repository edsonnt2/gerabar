<?php if(isset($_POST['inclui'])){ if(isset($_SESSION)==false){session_start(); }
	include('../_classes/DB.class.php');
    	function getUrl(){
		return 'http://localhost/myforadmin/';
		}
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
	$idDaSessao = $_SESSION['Gerabar_uid'];
	include('../_classes/Cadastros.class.php');
	include("../_classes/Empresas.class.php");
	$upInsert=($_POST['inclui']=='empresa')?"atualizar":"cadastrar";
	?>
    <script type="text/javascript">
	$(function(){
		$("#tel_empresa").mask("(99) 9999-9999?9");
		$("#cep_empresa").mask("99999-999");
	});
    </script>
	<?php
	}else{
	$upInsert=((isset($_GET['cad']) AND $_GET['cad']=="empresa") || $pgAtua=="configuracoes")?"atualizar":"cadastrar";
	}
	$DadosEmpresa = Empresas::selectEmpresa($idDaSessao);
	if($DadosEmpresa['num']>0){
	$razao=$DadosEmpresa['dados'][2];
	$nome_fantasia=$DadosEmpresa['dados'][3];
	$cep=$DadosEmpresa['dados'][4];
	$endereco=$DadosEmpresa['dados'][5];
	$numero=$DadosEmpresa['dados'][6];
	$comple=$DadosEmpresa['dados'][7];
	$bairro=$DadosEmpresa['dados'][8];
	$cidade=$DadosEmpresa['dados'][9];
	$estado=$DadosEmpresa['dados'][10];
	$tel=$DadosEmpresa['dados'][11];
	$loja=$DadosEmpresa['dados'][12];
	$cnpj_cpf=$DadosEmpresa['dados'][14];
	}else{
	$razao="";
	$nome_fantasia="";
	$cep="";
	$endereco="";
	$numero="";
	$comple="";
	$bairro="";
	$cidade="";
	$estado="";
	$tel="";
	$loja="";
	$cnpj_cpf="";
	}
?>
<div id="cont_dados_empresa">
<?php
if($upInsert=='atualizar'){
    echo '<h1 id="h1TopoUsuario">DADOS DA EMPRESA</h1>';
}
    ?>
<form method="post" action="">    
<div class="linha_empresa">    
    <div class="alinha_empresa">
        <span><label for="razao_empresa">Nome do seu Negócio:</label></span>
        <input type="text" id="razao_empresa" placeholder="Coloque aqui o nome do Negócio" autofocus="autofocus" value="<?php echo $razao; ?>" />
        <div class="d_aviso_erro" id="erro_razao_empresa"><div class="d_ponta-erro"></div><p></p></div><!--d_aviso_erro-->
    </div>
</div><!--fecha linha empresa-->    
<div class="linha_empresa">
    <div class="alinha_empresa">
        <span><label for="cnpjCpf_empresa">cnpj/cpf</label></span>
        <input type="text" id="cnpjCpf_empresa" onKeyPress="return SomenteNumero(event);" onBlur="return cpfcnpjEnter();" onFocus="return cpfcnpjExt();" placeholder="XX.XXX.XXX/XXXX-XX" maxlength="14" value="<?php echo $cnpj_cpf; ?>" />
        <div class="d_aviso_erro" id="erro_cnpjCpf_empresa"><div class="d_ponta-erro"></div><p></p></div><!--d_aviso_erro-->
    </div>    
    <div class="alinha_empresa">
        <span><label for="tel_empresa">telefone:</label></span>
        <input type="text" id="tel_empresa" placeholder="(XX) XXXXX-XXXX" value="<?php echo $tel; ?>" />
        <div class="d_aviso_erro" id="erro_tel_empresa"><div class="d_ponta-erro"></div><p></p></div><!--d_aviso_erro-->
    </div>
</div><!--fecha linha empresa-->
<div class="linha_empresa">
    <div class="alinha_empresa">
        <span><label for="cep_empresa">cep:</label></span>
        <div id="d_acerta_cep">
        <input type="text" id="cep_empresa" onBlur="return BuscaCep(this.value,'cep_empresa','endereco_empresa','numero_empresa','bairro_empresa','cidade_empresa','estado_empresa');" placeholder="XXXXX-XXX" value="<?php echo $cep; ?>" />
        <span id="carrega_cep"></span>
        </div>
        <div class="d_aviso_erro" id="erro_cep_empresa" style="margin-top: 38px;"><div class="d_ponta-erro"></div><p></p></div><!--d_aviso_erro-->
        <a href="http://www.buscacep.correios.com.br/sistemas/buscacep/" target="_blank" class="naocep">Não sei meu CEP</a>
    </div>    
</div><!--fecha linha empresa-->
<div id="d_busca_cep_empresa"<?php if($cep!="") echo ' style="display:block;"'; ?>>     
<div class="linha_empresa">
    <div class="alinha_empresa">
        <span><label for="endereco_empresa">endereço:</label></span>
        <input type="text" id="endereco_empresa" placeholder="Coloque o endereço do seu Negócio" value="<?php echo $endereco; ?>" />
        <div class="d_aviso_erro" id="erro_endereco_empresa"><div class="d_ponta-erro"></div><p></p></div><!--d_aviso_erro-->
    </div>
</div><!--fecha linha empresa-->
<div class="linha_empresa">
    <div class="alinha_empresa">
        <span><label for="numero_empresa">Número:</label></span>
        <input type="text" id="numero_empresa" placeholder="Número do Negócio" onKeyPress="return SomenteNumero(event);" maxlength="10" value="<?php echo $numero; ?>" />
        <div class="d_aviso_erro" id="erro_numero_empresa"><div class="d_ponta-erro"></div><p></p></div><!--d_aviso_erro-->
    </div>
    <div class="alinha_empresa">
        <span><label for="comple_empresa" class="naoObrigatorio">complemento:</label></span>
        <input type="text" id="comple_empresa" placeholder="Complemento opcional" value="<?php echo $comple; ?>" />
    </div>
</div><!--fecha linha empresa-->
<div class="linha_empresa">    
    <div class="alinha_empresa">
        <span><label for="bairro_empresa">bairro:</label></span>
        <input type="text" id="bairro_empresa" placeholder="Bairro do Negócio" value="<?php echo $bairro; ?>" />
        <div class="d_aviso_erro" id="erro_bairro_empresa"><div class="d_ponta-erro"></div><p></p></div><!--d_aviso_erro-->
    </div>    
    <div class="alinha_empresa">
        <span><label for="cidade_empresa">cidade:</label></span>
        <input type="text" id="cidade_empresa" placeholder="Cidade do Negócio" value="<?php echo $cidade; ?>" />
        <div class="d_aviso_erro" id="erro_cidade_empresa"><div class="d_ponta-erro"></div><p></p></div><!--d_aviso_erro-->
    </div>    
    <div class="alinha_empresa">
        <span><label for="estado_empresa">estado:</label></span>        
        <select id="estado_empresa">
            <option value="">UF</option>
            <?php               $esta=array('','AC','AL','AM','AP','BA','CE','DF','ES','GO','MA','MG','MS','MT','PA','PB','PE','PI','PR','RJ','RN','RO','RR','RS','SC','SE','SP','TO');
               for($m=1;$m<=27;$m++){
               if($estado==$esta[$m]){
               echo'<option selected="selected" value="',$esta[$m],'">',$esta[$m],'</option>';
               }else{
               echo'<option value="',$esta[$m],'">',$esta[$m],'</option>';
               }}
            ?>            
        </select>
        <div class="d_aviso_erro" id="erro_estado_empresa"><div class="d_ponta-erro"></div><p></p></div><!--d_aviso_erro-->
    </div>    
</div><!--fecha linha empresa-->
</div><!--d_busca_cep_empresa-->
<div class="linha_empresa">
    <div class="alinha_empresa">
    	<button type="submit" class="<?php echo $upInsert; ?>" id="cadastra_empresa" ><?php echo ($upInsert=="atualizar")?$upInsert:"próximo passo"; ?></button>
    </div>
</div><!--fecha linha empresa-->
</form>
</div><!--fecha cont_dados_empresa-->