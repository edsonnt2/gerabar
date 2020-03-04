<?php if(isset($_POST['inclui'])){ if(!isset($btProx)){	if(isset($_SESSION)==false){session_start(); }
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
		$idDaSessao = $_SESSION['Gerabar_uid'];
		include('../_classes/Empresas.class.php');
		}
		function img_empresa($imag){return ($imag<>'' AND file_exists('../_uploads/_negocios/'.$imag)) ? $imag : 'sem-imagem.jpg';	}
		}
		if(!isset($btProx)){
		if(isset($_POST['inclui']) || isset($_GET['cad'])){
		$idEmpresa = Empresas::selectEmpresa($idDaSessao);
		}		
		$idEmpre = $idEmpresa['dados'][0];
		}
		$imgEmpresa = Empresas::selectImgEmpresa($idEmpre);
		$imgEmpre = ($imgEmpresa['num']>0)?$imgEmpresa['dados']['nome_img_1']:'';
	 ?>
     
     <script type="text/javascript">
	 //ENVIA IMAGEM AJAX
	 	//UPLOAD ABAIXO
		$(function(){
		var btUpload=$('.envia_img a');
		new AjaxUpload(btUpload,{
			// Arquivo que fará o upload
			action: '_php/upload_img.php',
			//Nome da caixa de entrada do arquivo
			name: 'uploadfoto',
			onSubmit: function(file, ext){
				$('.d_aviso_erro').hide().children('p').html("");
				if (! (ext && /^(jpg|png|jpeg|gif)$/.test(ext))){ 
                    // verificar a extensão de arquivo válido
					$('#erro_car_img p').html("Somente JPG, PNG ou GIF são permitidas");
					$('#erro_car_img').show();
					return false;
				}
				$('#carrega-img').show();
			},
			onComplete: function(file, response){
				//Adicionar arquivo carregado na lista
				$('#carrega-img').hide();
				var ret=response.split('|'),msg=ret[0],diverro=ret[1];
				if(diverro=="erro"){
					$('#erro_erro_car_img p').html(msg);
					$('#erro_erro_car_img').show();
				}else{
					$('#logo_gerabar').attr('src',getUrl()+'_uploads/_negocios/'+msg);
					$('#img_logo_alt').attr('src',getUrl()+'_uploads/_negocios/'+msg);					
				}
				
			}
		});
		});
		//FIM UPLOAD
		
     </script>		

<div id="cont_img_empresa">

	<div class="topo_img_empresa"><h2 <?php if(!isset($btProx) || $btProx==false){ echo 'style="background:#fff;"';} ?>>Adicionar imagem de Logotipo</h2></div>
    

	<div id="tudo_img_primeiro" <?php if(isset($btProx) AND $btProx==true){ echo 'style="margin:0px 0 10px 0px;"';} ?>>  
    	<div id="img_nova"><div id="carrega-img"></div><img src="<?php echo getUrl(); ?>_uploads/_negocios/<?php echo img_empresa($imgEmpre); ?>" id="img_logo_alt" alt="logotipo da nova empresa" /></div>
       
       <div id="botao_escolhe_primeiro" class="envia_img"><a href="javascript:void(0);">enviar imagem</a></div><!--fecha botão escolhe primeiro-->
        <span id="info_tamanho_primeiro"><p>*imagem com altura de 130px e largura de 330px ou proporcional</p></span>
        
        <div class="d_aviso_erro" id="erro_car_img" style=" margin-top:130px;"><div class="d_ponta-erro"></div><p></p></div><!--d_aviso_erro-->
       
    </div><!--fecha tudo_img_primeiro-->
   
</div><!--fecha cont_img_empresa-->