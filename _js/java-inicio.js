function getUrl(){ return 'http://localhost/myforadmin/';}
var er=new RegExp(/^[A-Za-z0-9_\-\.]+@[A-Za-z0-9_\-\.]{2,}\.[A-Za-z0-9]{2,}(\.[A-Za-z0-9])?/);
var erS=new RegExp(/^(?=.*\d)(?=.*[a-z])(?!.*\s).*$/);
$(function(){
	
	$('#spanalert a').click(function(){
	$('#alert').fadeOut(200,function(){$('#alert-cima p').html(''); });	
	});
    
    $('#spannao a').click(function(){	
		$('#confirm').fadeOut(200,function(){
		$('#spansim').attr('class','');
		$('#spansim a').attr('id','').attr('class','');
		$('#confirm-cima').html('<p class="p_confDentro"></p>');
		});
	});	
	
	//FAZENDO LOGIN	
	
	$(window).resize(function() {          
		ResizeTopo();
	});		
	$(document).ready(function(){ 
	ResizeTopo();
	});
		
	function ResizeTopo(){
		if($(window).width()>773){
		$("#campologa").show();
		}else{		
		if($('#s_loga_resp a').attr('class')!="logaAberto"){
		$("#campologa").hide();
		$("#emailloga").val("");
		$("#senhaloga").val("");
		$('#s_loga_resp a').removeClass("logaAberto");
		}
		
		}	
	}
	
	$('#s_loga_resp').on('click','a',function(){
	$('.d_aviso_erro').hide().children('p').html("");
	if($(this).attr('class')=="logaAberto"){	
	$("#campologa").hide();
	$("#emailloga").val("");
	$("#senhaloga").val("");
	$(this).removeClass("logaAberto");
	}else{
	$(this).addClass("logaAberto");	
	$("#campologa").show();
	$("#emailloga").focus();	
	}
	});
	
	$('#fechaLoga').on('click','a',function(){
	$('.d_aviso_erro').hide().children('p').html("");
	$("#campologa").hide();
	$("#emailloga").val("");
	$("#senhaloga").val("");
	$('#s_loga_resp a').removeClass("logaAberto");
	});
	
	$("#entraloga,#logarlogaP").on("click",function(){
	$('.d_aviso_erro').hide().children('p').html("");
    var emailLoga,senhaLoga,lembrar,idloga=$(this).attr('id');
        if(idloga=='logarlogaP'){
            emailLoga=$("#usuariologaP");
            senhaLoga=$("#senhalogaP");
            lembrar="nao";
        }else{
            emailLoga=$("#emailloga");
            senhaLoga=$("#senhaloga");
            lembrar=(document.getElementById("conectado").checked==true)?"sim":"nao";            
        }
	if(emailLoga.val().trim()==""){
		$('#erro_'+emailLoga.attr('id')+' p').html("Usuário ou e-mail está em branco !");
		$('#erro_'+emailLoga.attr('id')).show();
		emailLoga.focus();
	}else if(senhaLoga.val().trim()==""){
		$('#erro_'+senhaLoga.attr('id')+' p').html("Senha está em branco !");
		$('#erro_'+senhaLoga.attr('id')).show();
		senhaLoga.focus();
	}else{	
		$('#carregador').show();
		$.post("_php/loginCadastro.php",{emailUsuario:emailLoga.val().trim(),senha:senhaLoga.val().trim(),lembrar:lembrar,ondeLogar:idloga},function(retorno){
		var retorn=retorno.split('|'),msg=retorn[0],qual=retorn[1],valida=retorn[2];		
		if(valida!=""){
			$('#carregador').hide();
			$('#erro_'+qual+' p').html(msg);
			$('#erro_'+qual).show();
			$("#"+qual).focus();
		}else{
		
			if(qual=="erro"){
				$('#carregador').hide();
				$('#alert-cima p').html(msg);				
				$('#alert').show();
				$('#spanalert a').focus();
			}else{
				window.location.href=msg;
			}
		}		
		});	
	}	
	return false;
	});
    
    $("body").on("click",".sair_logOut",function(){	
    if(window.history.pushState){	
        if($('#spansim a').attr('id')!="sim"){
            $(this).blur();
            $('#confirm-cima p').html('Tem certeza que deseja sair ?');
            $('#spansim a').attr('id','sim').addClass('sair_logOut');
            $('#confirm').show();
            $('#spansim a').focus();
        }else{
        $('#carregador').show();
        $.post("_php/loginCadastro.php",{sair:'logOut'},function(){	
        window.location.href=getUrl()+"?inicio=true";
        $('#spansim a').attr('id','').attr('class','');
        });
        }	
        return false;
    }

    });

	
	//PARTE RECUPERA SENHA
	$('#a_rememberKey').on('click',function(){
		$('.d_aviso_erro').hide().children('p').html("");	
		$('#carregador').show();
		$.get('_include/loading-interno.php',{carRecupera:true},function(data){
		$('#carregador').hide();
		$('#fundoRecupera').html(data).fadeIn(150);
		$('#recuperaEmail').focus();
		});		
	});
	
	$(document).keydown(function(e){
		if(e.which == 27){
            $('#fundoRecupera').fadeOut(150,function(){ $('#fundoRecupera').html(""); });
		}
	});
	
	$('#fundoRecupera').on('click','#fechaRecupera',function(){
		$('#fundoRecupera').fadeOut(150,function(){ $('#fundoRecupera').html(""); });	
	});
	
	$('body').on('click','.enviarRecu',function(){
	$('.d_aviso_erro').hide().children('p').html("");	
        var reenvia,emailRecupera;
	if($(this).attr('id')=="corReenvia"){
	$('.erroRecupera').html("").hide();	
	reenvia = 'sim';
	emailRecupera = $('#reenvia').html().trim();
	}else{
        reenvia = 'nao';
        emailRecupera = $('.recemail').val().trim();
	}
	if(emailRecupera==""){		
	$('#erro_'+$('.recemail').attr('id')+' p').html("E-mail está em branco !");
	$('#erro_'+$('.recemail').attr('id')).show();
	$('#'+$('.recemail').attr('id')).focus();
	}else if(er.test(emailRecupera)==false){
	$('#erro_'+$('.recemail').attr('id')+' p').html("Este e-mail é inválido !");
	$('#erro_'+$('.recemail').attr('id')).show();
	$('#'+$('.recemail').attr('id')).focus();
	}else{
	
		$('.carre-recu').show();
		$('.enviarRecu').attr('disabled',true);
		$.post("_php/recuperar.php",{recemail:emailRecupera},function(retorno){
			$('.carre-recu').hide();
			$('.enviarRecu').attr('disabled',false);
			var ret=retorno.split("|");	
			if(ret[1]!="erro"){
				if(ret[1]!=""){
					if(reenvia == "sim"){
					$('.erroRecupera').html(ret[0]).show();
					}else{
					$('#erro_'+$('.recemail').attr('id')+' p').html(ret[0]);
					$('#erro_'+$('.recemail').attr('id')).show();
					$("#"+$('.recemail').attr('id')).focus();
					}
				}else{
					if(reenvia == "sim"){
						$('#reenviado').fadeIn(100);				
					}else{
					$('.contRecupera').html('');
					$('.contRecupera').html('<div class="cont-reenvia"><p>Foi enviado um e-mail com o link para a recuperação de senha para o e-mail <span id="reenvia">'+emailRecupera+'</span>, verifique também sua caixa de spam, caso não tenha recebido o e-mail <a href="javascript:void(0);" id="corReenvia" class="enviarRecu">clique aqui</a> para reenviar o e-mail novamente.</p><p> OBS: O link enviado para o recuperação expirará em 24 horas.</p></div><div id="erro-reenviado" class="erroRecupera"></div><div id="reenviado">O e-mail para a recuperação de senha foi reenviado</div><span class="carre-recu" style="margin-left:20px;"></span>');
					}
				}
			}else{
				$('#alert-cima p').html(ret[0]);
				$('#alert').show();
				$('#spanalert a').focus();
			}	
		});	
	}
	return false;
	});
	
	$('#recupera-senha').on('click',function(){		
		$('.d_aviso_erro').hide().children('p').html("");			
		var novasenha=$('#novasenha'),repnovasenha=$('#repnovasenha');
		
		if(novasenha.val().trim()==""){
		$('#erro_'+novasenha.attr('id')+' p').html('Por favor, coloque sua nova senha !');
		$('#erro_'+novasenha.attr('id')).show();
		$("#"+novasenha.attr('id')).focus();
		}else if(novasenha.val().trim().length<6){
		$('#erro_'+novasenha.attr('id')+' p').html('Sua nova senha tem que ter no mínimo 6 caracteres !');
		$('#erro_'+novasenha.attr('id')).show();
		$("#"+novasenha.attr('id')).focus();
		}else if(erS.test(novasenha.val().trim())==false){
		$('#erro_'+novasenha.attr('id')+' p').html('Senha tem que conter letras e numéros !');
		$('#erro_'+novasenha.attr('id')).show();
		$("#"+novasenha.attr('id')).focus();
		}else if(repnovasenha.val().trim()==''){
		$('#erro_'+repnovasenha.attr('id')+' p').html('Por Favor, repita sua nova senha !');
		$('#erro_'+repnovasenha.attr('id')).show();
		$("#"+repnovasenha.attr('id')).focus();
		}else if(novasenha.val().trim()!=repnovasenha.val().trim()){
		$('#erro_'+repnovasenha.attr('id')+' p').html('As duas senhas não correspondem uma com a outra !');
		$('#erro_'+repnovasenha.attr('id')).show();
		$("#"+repnovasenha.attr('id')).focus();
		}else{
			$('.carre-recu').show();
			$('#recuForm').attr('disabled',true);
			$.post("_php/recuperar.php",{email:$('#email-altera').val().trim(),novaSenha:novasenha.val().trim(),repSenha:repnovasenha.val().trim(),confirmaConta:$('#confirma-conta').val()},function(recuRet){
			$('.carre-recu').hide();
			$('#recuForm').attr('disabled',false);
			var ret=recuRet.split("|");
			if(ret[1]!="erro"){
				if(ret[1]!=""){
					$('#erro_'+ret[1]+' p').html(ret[0]);
					$('#erro_'+ret[1]).show();
					$("#"+ret[1]).focus();
				}else{
				
				$('#cont-recupera').html('');
				$('#cont-recupera').html('<div class="cont-nome-recupera">Redefinição de senha feita com sucesso !</div><div class="cont-cont-recupera"><p style="font-size:14px; color:#444;" class="textRec">Sua senha foi redefinida com sucesso, <a href="'+getUrl()+'">clique aqui</a> para voltar ao inicio do Gerabar.</p></div>');
				}
			}else{
				$('#alert-cima p').html(ret[0]);
				$('#alert').show();
				$('#spanalert a').focus();
			}
			
			});
			
            }	
		return false;
		});
    
    //CADASTRO DE LOGIN DE AMBEINTE
    $('#contforminicial').on('keyup','#senhacad',function(){
        var divOlho=$(this).parent('div');
        if($(this).val().length>0){
            divOlho.children('.olho-amb').show();
        }else{
            divOlho.children('.olho-amb').hide();
            if(divOlho.attr('class')=='mostra-senha'){
            $('.olho-amb').attr('title','Mostrar Senha');
            divOlho.attr('class','');
            $(this).attr('type','password').focus();
            }
        }
    });    
    
    $('#contforminicial').on('click','.olho-amb',function(){
			var divOlho = $(this).parent('div');
			if(divOlho.attr('class')=='mostra-senha'){
			divOlho.children('input').attr('type','password').focus();
			divOlho.attr('class','');
			$(this).attr('title','Mostrar Senha');
			}else{
			divOlho.children('input').attr('type','text').focus();
			divOlho.attr('class','mostra-senha');
			$(this).attr('title','Esconder Senha');
			}		
		});
	
	//SALVA CADASTRO PARTE 1	
	$(".envia_cadastro").on("click",function(){
		$('.d_aviso_erro').hide().children('p').html("");
			var nome=$("#nomecad").val().trim(),
                nomeUso=$("#nomeUsuariocad").val().trim(),
                email=$("#emailcad").val().trim(),
                dia=$("#diacad").val().trim(),
                mes=$("#mescad").val().trim(),
                ano=$("#anocad").val().trim(),
                genero=$("input:radio[name=sexo]:checked").val(),
                senha=$('#senhacad').val().trim(),
                termos=(document.getElementById("i_termos").checked==true)?"sim":"nao",
                ondeCad=$(this).attr('id');
        if(nome=="" || nome.length<6){
			$('#erro_nomecad p').html("Nome em branco ou pequeno de mais !");
			$('#erro_nomecad').show();
			$('#nomecad').focus();
		}else if(nomeUso=="" || nomeUso.length<2){
			$('#erro_nomeUsuariocad p').html("Nome de usuário em branco ou pequeno de mais !");
			$('#erro_nomeUsuariocad').show();
			$('#nomeUsuariocad').focus();		
		}else if(nomeUso.length>30){
			$('#erro_nomeUsuariocad p').html("Nome de usuário grande demais !");
			$('#erro_nomeUsuariocad').show();
			$('#nomeUsuariocad').focus();		
		}else if(email=="" || er.test(email)==false){
			$('#erro_emailcad p').html("E-mail em branco ou inválido !");
			$('#erro_emailcad').show();
			$('#emailcad').focus();
		}else if(senha==""){
			$('#erro_senhacad p').html("Senha em branco !");
			$('#erro_senhacad').show();
			$('#senhacad').focus();
		}else if(senha.length<6){
			$('#erro_senhacad p').html("Senha pequena demais, precisa conter pelo menos 8 caracteres !");
			$('#erro_senhacad').show();
			$('#senhacad').focus();
		}else if(erS.test(senha)==false){
			$('#erro_senhacad p').html("Senha tem que conter letras e numéros !");
			$('#erro_senhacad').show();
			$('#senhacad').focus();
		}else if(dia=="" || mes=="" || ano==""){
			$('#erro_diacad p').html("Data de nascimento está incorreta !");
			$('#erro_diacad').show();
			$('#diacad').focus();
		}else if(genero===undefined){
			$('#erro_radio p').html("Selecione um gênero !");
			$('#erro_radio').show();
		}else if(termos=="nao"){
			$('#erro_i_termos p').html("Por favor, aceite os Termos e Política de Privacidade para continuar !");
			$('#erro_i_termos').show();
		}else{
				$('#carregador').show();
				$.post("_php/loginCadastro.php",{nome:nome,nomeUsuario:nomeUso,email:email,dia:dia,mes:mes,ano:ano,genero:genero,senha:senha,ondeCadastra:ondeCad},function(retorno){
				var ret=retorno.split('|'),msg=ret[0],diverro=ret[1];
				if(diverro=="erro"){
					$('#carregador').hide();
					$('#alert-cima p').html(msg);
					$('#alert').show();
					$('#spanalert a').focus();
				}else if(diverro!=""){
					$('#carregador').hide();
					$('#erro_'+diverro+' p').html(msg);
					$('#erro_'+diverro).show();
					if(diverro!="radio"){
					$("#"+diverro).focus();
					}
				}else{
					window.location.href=msg;
				}
			
				});		
		}		
		return false;	
	});
	
	//ENVIO DE CONTATO PARA EMAIL
	
	$("#i_anexo_cont").on("change", function(){
		$('.d_aviso_erro').hide().children('p').html("");
		$('.cor_erro').removeClass('cor_erro');
        
        var files = this.files ? this.files : [];
        if (!files.length || !window.FileReader) return false;
			$('#s_nome_anexo').html(files[0].name);
			$('#nome_anexo').show();
    });
	
	$('#x_span_anexo').on('click',function(){
		$('.d_aviso_erro').hide().children('p').html("");
		$('.cor_erro').removeClass('cor_erro');
		$('#i_anexo_cont').val("");
		$('#s_nome_anexo').html("");
		$('#nome_anexo').hide();
	});
	
	$('#subFormContato').on('submit',function(){
		$('.d_aviso_erro').hide().children('p').html("");
		$('.cor_erro').removeClass('cor_erro');
		var email=$('#i_email_cont'),assunto=$('#i_assunto_cont'),descricao=$('#i_descricao_cont');
		if(email.val()==""){
		$('#erro_i_email_cont p').html("E-mail está em branco !");
		$('#erro_i_email_cont').show();
		email.addClass('cor_erro').focus();	
		}else if(er.test(email.val())==false){
		$('#erro_i_email_cont p').html("Este e-mail é inválido !");
		$('#erro_i_email_cont').show();
		email.addClass('cor_erro').focus();	
		}else if(assunto.val()==""){
		$('#erro_i_assunto_cont p').html("Assunto está em branco !");
		$('#erro_i_assunto_cont').show();
		assunto.addClass('cor_erro').focus();
		}else if(descricao.val()==""){
		$('#erro_i_descricao_cont p').html("Descrição está em branco !");
		$('#erro_i_descricao_cont').show();
		descricao.addClass('cor_erro').focus();	
		}else{
			$('#carregador').show();
			$.ajax({
				url:"_php/envia_contato.php",
				type:"POST",
				dataType:"json",
				processData:false,
				contentType:false,
				cache:false,
				data:new FormData(this),
				success: function(ret){					
					$('#carregador').hide();
					if(ret.diverro!="erro"){
						if(ret.diverro!=""){
							$('#erro_'+ret.diverro+' p').html(ret.msg);
							$('#erro_'+ret.diverro).show();
							$("#"+ret.diverro).focus();
						}else{
							$('#dentroOk').html("Solicitação enviada com sucesso !").fadeIn(150);
							setTimeout(function(){$('#dentroOk').fadeOut(200,function(){$('#dentroOk').html("");});},1500);
							email.val("");
							assunto.val("");
							descricao.val("");
							$('#i_anexo_cont').val("");
							$('#s_nome_anexo').html("");
							$('#nome_anexo').hide();
						}
					}else{
						$('#alert-cima p').html(ret.msg);
						$('#alert').show();
						$('#spanalert a').focus();
					}
					
				}
				
			});
		
		}
		return false;
	
	});
    
    //PARTE PLANOS
    
    $('#u_plano_center .plano_1,#u_plano_center .plano_2,#u_plano_center .plano_3').on('click',function(){
    var sepPlano=$(this).attr('class').split(' '),planoAtiva;
    
    if(sepPlano[0]=='plano_1' || sepPlano[1]=='plano_1' || sepPlano[2]=='plano_1'){
     planoAtiva=1;   
    }else if(sepPlano[0]=='plano_2' || sepPlano[1]=='plano_2' || sepPlano[2]=='plano_2'){
        planoAtiva=2;
    }else if(sepPlano[0]=='plano_3' || sepPlano[1]=='plano_3' || sepPlano[2]=='plano_3'){
        planoAtiva=3;
    }else{
        planoAtiva=0;                        
    }

    if(planoAtiva!=0){
        $('.plano_ativo').removeClass('plano_ativo');        
        $('.s_plano_descri').addClass('margim_plano');
        $('div.plano_'+planoAtiva).addClass('plano_ativo');
        $('span.plano_'+planoAtiva+' p').addClass('plano_ativo');
        $('#u_plano_center').attr('class','plano_'+planoAtiva);        
        $('#s_continua_plano').show();
        $('#loginCadastroPlano').hide();        
    }else{
        $('#alert-cima p').html('Ocorreu um erro ao selecionar o plano !');
        $('#alert').show();
        $('#spanalert a').focus();
    }

});
    
    $('#s_continua_plano a').on('click',function(){
        var plano=$('#u_plano_center').attr('class'),scrollPlano=$(this).offset().top;
        if(plano===undefined){
            $('#alert-cima p').html('Selecione um dos planos para continuar !');
            $('#alert').show();
            $('#spanalert a').focus();
        }else{            
            $('#carregador').show();
            $.post("_php/ativar_plano.php",{salvaPlano:plano},function(retorno){                
                var ret=retorno.split('|'),msg=ret[0];
                $('#carregador').hide();
                if(msg!=""){                
                    window.location.href=getUrl()+'checkout.php';
                }else{
                    $('#s_continua_plano').hide();
                    $('#loginCadastroPlano').show();
                    $('html,body').animate({scrollTop:scrollPlano},320);
                    $('#nomecad').focus();                                        
                }
            });
            
        }
        
    });
    
    $('#a_loginCad_plano').on('click',function(){
        $('#contforminicial input').val("");
        $('#d_cont_login_plano input').val("");
        if($(this).attr('class')=="cad_plano"){
            $('#muda_txt_cadLoga1').html('Acesse sua conta para contratar seu novo plano.');
            $('#muda_txt_cadLoga2').html('Ainda não é um usúario do sistema Gerabar ?');
             $(this).html('Clique aqui e faça seu cadastro');
            
            $('#contforminicial').hide();
            $('#d_cont_login_plano').show();
            $('#usuariologaP').focus();
            $(this).attr('class','loga_plano');
        }else{
            $('#muda_txt_cadLoga1').html('Cadastre-se para contratar seu novo plano.');
            $('#muda_txt_cadLoga2').html('Já é um usúario do sistema Gerabar ?');
            $(this).html('Clique aqui e acesse sua conta');
            $('#d_cont_login_plano').hide();
            $('#contforminicial').show();            
            $('#nomecad').focus();
            $(this).attr('class','cad_plano');
        }
        
    });
    
    //FIM PLANOS
    
    //COMEÇO CHECKOUT
    $('#s_plano').on('blur',function(){
        var plano=$(this).val();
        $('.fechaPaga').hide();
        $('#u_forma_checkout li').removeClass('li_check_ativo');
        if(plano=='1'){
            $('#h_valor_total span').attr('class','79.9').html('R$ 79,90');
            $('#pg_parcela span').html('R$ 79,90');
            $('#tudo_plano_free').hide();
            $('#tudo_plano_premium').show();
            $("#li_boleto_hide").hide();
        }else if(plano=='2'){
            $('#h_valor_total span').attr('class','14.9').html('R$ 14,90');
            $('#pg_parcela span').html('R$ 14,90');
            $('#tudo_plano_free').hide();
            $('#tudo_plano_premium').show();
            $("#li_boleto_hide").show();
        }else{
            $('#h_valor_total span').attr('class','0').html('R$ 0,00');
            $('#pg_parcela span').html('R$ 0,00');
            $('#tudo_plano_free').show();
            $('#tudo_plano_premium').hide();
            $("#li_boleto_hide").hide();
        }
    });
    
    $('#concluirFree').on('click',function(){
        $('#carregador').show();
        $.get("_php/carrega-pagamento.php",{concluirFree:true},function(retorno){        
        $('#tudo_pagamento_check').hide();
        $('#d_tudo_compra_feita').html(retorno).show();
        $('#carregador').hide();
        });
    });
    
    var carregaIdDaSessao = function(){			
			$.ajax({
				url : "_php/carrega-pagamento.php",
				type : 'post',
				dataTyp : 'json',
				cache:false,
				timeout: 20000,
				data:{'pagSeguro':'carregaId'},
				success: function(data){
                    PagSeguroDirectPayment.setSessionId(data);
					$('#IdDaSessao').val('true');
				}
			});
		}
    
    $('#u_forma_checkout').on('click','a',function(){
		$('.d_aviso_erro').hide().children('p').html("");
		if($('#IdDaSessao').val()==""){
		carregaIdDaSessao();
		}
		$('#u_forma_checkout li').removeClass('li_check_ativo');
		$(this).parent('li').addClass('li_check_ativo');
		var qualPago = $(this).attr('id');
		$('.fechaPaga').hide();
		
		if(qualPago=='pg-cartao'){
		$('#d_cartao_checkout').show();
		$('#pg_nome').focus();
		}else if(qualPago=='pg-boleto'){
		$('#d_boleto_checkout').show();
		}else{
		$('#d_tudo_transf').show();
		}
		
    });
    
    //FORMATAÇÃO BOTÃO CODIGO CARTAO
		var timeCodOut = true,pairaCod;		
		$("#d_td_checkout").on('mouseover','#s_cod_cartao',function(){		
		pairaCod = setTimeout(function(){
			$('#d_ajuda_cod_cartao').show();
			timeCodOut=false;
			},300);		
		});
    
		$("#d_td_checkout").on('mouseout','#s_cod_cartao',function(){
		if(timeCodOut){
			clearTimeout(pairaCod);
			}else{
			$('#d_ajuda_cod_cartao').hide();
			timeCodOut=true;
			}
		});
    
    $("#d_td_checkout").on("keyup","#pg_numCartao",function(e){
			//$('.d_aviso_erro').hide().children('p').html("");
			var tecla=(window.event)?event.keyCode:e.which;
			if((tecla<33 || tecla>36) && (tecla<16 || tecla>18) && (tecla!=37 && tecla!=39 && tecla!=0 && tecla!=9 && tecla!=20 && tecla!=255)){
			// Obtendo apenas os 6 primeiros dígitos (bin)
			var cardBin = $(this).val().substring(0, 6);
			// Atualizar Brand apenas se tiver 6 ou mais dígitos preenchidos
			if (String(cardBin).length >= 6) {
                
				if($('#ul_bandeira_card li').is(':visible')==false){
					$('#ul_bandeira_card li#carrega_band').show();
				}				
			  PagSeguroDirectPayment.getBrand({
					cardBin: cardBin,
					success: function(response) {
						$('#ul_bandeira_card li#carrega_band').hide();						
						var bandeira = response.brand.name,cvvSize=response.brand.cvvSize;						
						if($('.band_sel').attr('id')!="li_"+bandeira){							
							$('#ul_bandeira_card li').removeClass('band_sel');
							$('#li_'+bandeira).addClass('band_sel');
							$('#pg_cvvCartao').attr('maxlength',cvvSize);
						}
					},
                    error: function(){
                        $('#ul_bandeira_card li#carrega_band').hide();
                    }
				});
			}else{
				if($('#erro_ul_bandeira_card p').html()==""){
				$('#ul_bandeira_card li').hide().removeClass('band_sel').css({'cursor':'default'});
				}
				$("#pg_parcela").trigger('change').attr('disabled',true);
			}
			}
		});
    
        $('#d_td_checkout').on('click','#ul_bandeira_card li',function(){
            if($(this).attr('class')!="band_sel"){
            $('.d_aviso_erro').hide().children('p').html("");
            $('#ul_bandeira_card li').removeClass('band_sel');
            $(this).addClass('band_sel');		
            if($(this).attr('id')=="li_amex"){
            $('#pg_cvvCartao').attr('maxlength','4');
            }else{
            $('#pg_cvvCartao').attr('maxlength','3');
            }
            }
        });
    
    $('#envia_pagarConta,#gerarBoleto').on('click',function(){
        $('.d_aviso_erro').hide().children('p').html("");
        var cep=$('#pcd_cep'),endereco=$('#pcd_endereco'),numero=$('#pcd_numero'),comple=$('#pcd_comple').val(),bairro=$('#pcd_bairro'),cidade=$('#pcd_cidade'),estado=$('#pcd_estado'),plano=$('#s_plano'),valTotal=$('#h_valor_total span');
        
        if(cep.val()==""){
		$('#erro_'+cep.attr('id')+' p').html("Cep está em branco !");
		$('#erro_'+cep.attr('id')).show();
		cep.focus();
		}else if(endereco.val()==""){
		$('#erro_'+endereco.attr('id')+' p').html("Endereço está em branco !");
		$('#erro_'+endereco.attr('id')).show();
		endereco.focus();
		}else if(numero.val()==""){
		$('#erro_'+numero.attr('id')+' p').html("Número está em branco !");
		$('#erro_'+numero.attr('id')).show();
		numero.focus();
		}else if(isNaN(numero.val())){
		$('#erro_'+numero.attr('id')+' p').html("Coloque apenas números !");
		$('#erro_'+numero.attr('id')).show();
		numero.focus();
		}else if(bairro.val()==""){
		$('#erro_'+bairro.attr('id')+' p').html("Bairro está em branco !");
		$('#erro_'+bairro.attr('id')).show();
		bairro.focus();
		}else if(cidade.val()==""){
		$('#erro_'+cidade.attr('id')+' p').html("Cidade está em branco !");
		$('#erro_'+cidade.attr('id')).show();
		cidade.focus();
		}else if(estado.val()==""){
		$('#erro_'+estado.attr('id')+' p').html("Estado está em branco !");
		$('#erro_'+estado.attr('id')).show();
		estado.focus();
		}else if(plano.val()==''){
        $('#alert-cima p').html('Por favor, selecione um plano para continuar !');
        $('#alert').show();
        $('#spanalert a').focus();    
        }else if($(this).attr('id')=="gerarBoleto" && plano.val()!="2"){
        $('#alert-cima p').html('Boleto disponível apenas para o Plano Premium Mensal');
        $('#alert').show();
        $('#spanalert a').focus();    
        }else{
            
            if($(this).attr('id')=="envia_pagarConta"){
            
                var nomeTitular = $('#pg_nome'),
                dataDia = $('#pg_diaNasc'),
                dataMes = $('#pg_mesNasc'),
                dataAno = $('#pg_anoNasc'),
                cpfTitular = $('#pg_cpf'),
                telTitular = $('#pg_tel'),		
                numeroCartao = $('#pg_numCartao'),
                bandCartao = $('.band_sel').attr('id'),
                validadeMes = $('#pg_mesVal'),
                validadeAno = $('#pg_anoVal'),
                cvvCartao = $('#pg_cvvCartao');

                if(nomeTitular.val()=="" || nomeTitular.val().length<5){
                $('#erro_'+nomeTitular.attr('id')+' p').html("Coloque o nome do titular como impresso no cartão !");
                $('#erro_'+nomeTitular.attr('id')).show();
                nomeTitular.focus();
                }else if(dataDia.val()==""){
                $('#erro_pg_nascimento p').html("Selecione o dia de nascimento do titular cartão !");
                $('#erro_pg_nascimento').show();		
                dataDia.focus();
                }else if(dataMes.val()==""){
                $('#erro_pg_nascimento p').html("Selecione o mês de nascimento do titular cartão !");
                $('#erro_pg_nascimento').show();
                dataMes.focus();	
                }else if(dataAno.val()==""){
                $('#erro_pg_nascimento p').html("Selecione o ano de nascimento do titular cartão !");
                $('#erro_pg_nascimento').show();
                dataAno.focus();	
                }else if(cpfTitular.val()==""){
                $('#erro_'+cpfTitular.attr('id')+' p').html("Coloque o CPF do titular do cartão !");
                $('#erro_'+cpfTitular.attr('id')).show();
                cpfTitular.focus();
                }else if(telTitular.val()==""){
                $('#erro_'+telTitular.attr('id')+' p').html("Coloque o telefone do titular do cartão !");
                $('#erro_'+telTitular.attr('id')).show();
                telTitular.focus();
                }else if(numeroCartao.val()=="" || numeroCartao.val().length<4){
                $('#erro_'+numeroCartao.attr('id')+' p').html("Número do cartão em branco ou incorreto !");
                $('#erro_'+numeroCartao.attr('id')).show();
                numeroCartao.focus();
                }else if(isNaN(numeroCartao.val())){
                $('#erro_'+numeroCartao.attr('id')+' p').html("Coloque apenas números !");
                $('#erro_'+numeroCartao.attr('id')).show();
                numeroCartao.focus();
                }else if(bandCartao===undefined){
                $('#ul_bandeira_card li').css({'cursor':'pointer'}).show();		
                $('#ul_bandeira_card li#carrega_band').hide();
                $('#erro_ul_bandeira_card p').html("Selecione a bandeira do cartão !");
                $('#erro_ul_bandeira_card').show();
                }else if(validadeMes.val()==""){		
                $('#erro_validade p').html("Selecione o mês de validade !");
                $('#erro_validade').show();
                validadeMes.focus();
                }else if(validadeAno.val()==""){
                $('#erro_validade p').html("Selecione o ano de validade !");
                $('#erro_validade').show();
                validadeAno.focus();
                }else if(cvvCartao.val()=="" || cvvCartao.val().length<3){
                $('#erro_'+cvvCartao.attr('id')+' p').html("Coloque o código de segurança do cartão !");
                $('#erro_'+cvvCartao.attr('id')).show();
                cvvCartao.focus();
                }else if(isNaN(cvvCartao.val())){
                $('#erro_'+cvvCartao.attr('id')+' p').html("Coloque apenas números !");
                $('#erro_'+cvvCartao.attr('id')).show();
                cvvCartao.focus();
                }else{
                    //TUDO CARTAO CERTO
                    
                    $('#carregador').show();
                    PagSeguroDirectPayment.createCardToken({
					cardNumber: numeroCartao.val(),
					cvv: cvvCartao.val(),
					expirationMonth: validadeMes.val(),
					expirationYear: validadeAno.val(),
					success: function(response){
                        $('#carregador').hide();
                        var novoNumCartao=numeroCartao.val().substring(0,4)+' '+numeroCartao.val().substring(4,8)+' '+numeroCartao.val().substring(8,12)+' '+numeroCartao.val().substring(12,16),plano,salComple=(comple=="")?'':' - '+comple;
						$('#tokenPagSeguro').val(response.card.token);
                            if($('#s_plano').val()=='1'){
                                plano='Plano Premium Anual - R$ 79,90';
                            }else if($('#s_plano').val()=='2'){
                                plano='Plano Premium Mensal - R$ 14,90';
                            }else{
                                plano='Plano Gratís - R$ 0,00';
                            }
                        $('#valorPlanoContrato').html(plano);
                        $('.pTop').html(endereco.val()+', '+numero.val()+salComple+' - '+bairro.val());
                        $('.pBottom').html('CEP: '+cep.val()+' - '+cidade.val()+' - '+estado.val());
                        
						$('#d_nome_t').html(nomeTitular.val());
						$('#d_data_nasc_t').html(dataDia.val()+'/'+dataMes.val()+'/'+dataAno.val());
						$('#d_cpf_t').html(cpfTitular.val());
						$('#d_tel_t').html(telTitular.val());
						$('#d_num_t').html(novoNumCartao);
						$('#d_band_t').html($('.band_sel').html());
						$('#d_data_val_t').html(validadeMes.val()+'/'+validadeAno.val());
						$('#d_cvv_t').html(cvvCartao.val());                        
						$('#d_parc_t').html('1x de '+valTotal.html());
                        
						//ABRIR PAGÍNA DE COMFIRMAÇÃO DE DADOS
						$('#confi_check').show();						
						$('#tudo_confirma_check').show();
						$('#tudo_pagamento_check').hide();
                    
                    },error: function(response){
					$('#carregador').hide();
					if(response.error==true){
					$('#erro_pg_numCartao p').html("Número de cartão inválido !");
					$('#erro_pg_numCartao').show();
					$('#tokenPagSeguro').val("");
					numeroCartao.focus();
					}
					
					}
                    });
                    
                }
                
            }else if($(this).attr('id')=="gerarBoleto"){
                
                //TUDO PARTE DO BOLETO
                var cpfBoleto=$('#cpf_boleto'),telBoleto=$('#tel_boleto');
                if(cpfBoleto.val()==""){
                $('#erro_'+cpfBoleto.attr('id')+' p').html("CPF está em branco !");
                $('#erro_'+cpfBoleto.attr('id')).show();
                cpfBoleto.focus();
                }else if(telBoleto.val()==""){
                $('#erro_'+telBoleto.attr('id')+' p').html("Telefone está em branco !");
                $('#erro_'+telBoleto.attr('id')).show();
                telBoleto.focus();
                }else{
                    
                $('#dentroCarrega').html("Processando...");
                $('#carregador').show();
                    
                $.ajax({
				url : '_php/carrega-pagamento.php',
				type : 'post',
				dataTyp:"json",
				cache:false,
				timeout: 20000,
				data:{
					'pagSeguro':'salvaDados',
					'method':'boleto',
                    'cep':cep.val(),
                    'endereco':endereco.val(),
                    'numero':numero.val(),
                    'complemento':comple,
                    'bairro':bairro.val(),
                    'cidade':cidade.val(),
                    'estado':estado.val(),
                    'plano':plano.val(),
					'cpfTitular':cpfBoleto.val(),
					'telTitular':telBoleto.val(),					
					'valorTotal':valTotal.attr('class')
				},
				success: function(data){
					$('#carregador').hide();
                    $('#dentroCarrega').html("Carregando...");
					var dados=data.split("|"),msg=dados[0],diverro=dados[1];
                    
                    if(diverro==""){
                        
                        $('#confi_check').hide();
						$('#d_tudo_compra_feita').html(msg).show();
						$('#tudo_confirma_check').hide();
                        $('#tudo_pagamento_check').hide();
                        window.open(dados[2],"_blank");
                        
                    }else if(diverro=="erro"){
                        $('#alert-cima p').html(msg);
                        $('#alert').show();
                        $('#spanalert a').focus();
                    }else{  
                        
                        $('#erro_'+diverro+' p').html(msg);
                        $('#erro_'+diverro).show();
                        $('#'+diverro).focus();
                    }
				}
				}); 
                    
                }
                
                
            }else{            
                $('#alert-cima p').html('Ocorreu um erro ao finalizar Contrato, por favor, tente novamente !');
                $('#alert').show();
                $('#spanalert a').focus();
            }
            
        }
        
        return false;
        
    });
    
    
    $('#d_td_checkout').on('click','#voltar_cartao',function(){
		$('#confi_check').hide();
        $('#tudo_confirma_check').hide();						
        $('#tudo_pagamento_check').show();		
        $('#valorPlanoContrato').html("");
        $('.pTop').html("");
        $('.pBottom').html("");
		$('.s_conf2').html("");
        $('#tokenPagSeguro').val("");
    });
    
    $('#d_td_checkout').on('click','#finalizar_compra',function(){
		$('.d_aviso_erro').hide().children('p').html("");
        $('#dentroCarrega').html("Processando...");
        $('#carregador').show();
        PagSeguroDirectPayment.onSenderHashReady(function(response){
            if(response.status == 'error') {
                $('#alert-cima p').html(response.message);
                $('#alert').show();
                $('#spanalert a').focus(); 
                return false;
            }
            var identificador = response.senderHash,
            cep=$('#pcd_cep').val(),
            endereco=$('#pcd_endereco').val(),
            numero=$('#pcd_numero').val(),
            comple=$('#pcd_comple').val(),
            bairro=$('#pcd_bairro').val(),
            cidade=$('#pcd_cidade').val(),
            estado=$('#pcd_estado').val(),
            plano=$('#s_plano').val(),
            nomeTitular = $('#pg_nome').val(),
            dataDia = $('#pg_diaNasc').val(),
            dataMes = $('#pg_mesNasc').val(),
            dataAno = $('#pg_anoNasc').val(),
            cpfTitular = $('#pg_cpf').val(),
            telTitular = $('#pg_tel').val(),
            numeroCartao = $('#pg_numCartao').val(),
            bandCartao = $('.band_sel').attr('id'),
            validadeMes = $('#pg_mesVal').val(),
            validadeAno = $('#pg_anoVal').val(),
            cvvCartao = $('#pg_cvvCartao').val(),
            valTotal=$('#h_valor_total span').attr('class'),
            tokenPaga=$('#tokenPagSeguro').val();
        
			$.ajax({
				url : '_php/carrega-pagamento.php',
				type : 'post',
				dataTyp:"json",
				cache:false,
				timeout: 20000,
				data:{
					'pagSeguro':'salvaDados',
					'method':'creditCard',
                    'cep':cep,
                    'endereco':endereco,
                    'numero':numero,
                    'complemento':comple,
                    'bairro':bairro,
                    'cidade':cidade,
                    'estado':estado,
                    'plano':plano,
					'nomeTitular':nomeTitular,
					'dataDia':dataDia,
					'dataMes':dataMes,
					'dataAno':dataAno,
					'cpfTitular':cpfTitular,
					'telTitular':telTitular,
					'numeroCartao':numeroCartao,
					'qualCartao':bandCartao,
					'validaMes':validadeMes,
					'validaAno':validadeAno,
					'cvvCartao':cvvCartao,
					'valorTotal':valTotal,
					'tokenPaga':tokenPaga,
					'identificador':identificador
				},
				success: function(data){
					$('#carregador').hide();
                    $('#dentroCarrega').html("Carregando...");
					var dados=data.split("|"),msg=dados[0],diverro=dados[1];
                    
                    if(diverro==""){
                        $('#confi_check').hide();
						$('#d_tudo_compra_feita').html(msg).show();
						$('#tudo_confirma_check').hide();
                        $('#tudo_pagamento_check').hide();
                    }else if(diverro=="erro"){
                        $('#alert-cima p').html(dados[0]);
                        $('#alert').show();
                        $('#spanalert a').focus();                        
                    }else{                        
                        $('#confi_check').hide();
                        $('#tudo_confirma_check').hide();						
                        $('#tudo_pagamento_check').show();
                        $('#valorPlanoContrato').html("");
                        $('.pTop').html("");
                        $('.pBottom').html("");
                        $('.s_conf2').html("");
                        $('#tokenPagSeguro').val("");                        
                        $('#erro_'+diverro+' p').html(msg);
                        $('#erro_'+diverro).show();
                        $('#'+diverro).focus();
                    }
				}
				});
				return false;
		});
        
            }); 
    
    
    //FIM CHECKOUT

});

//JAVA BUSCA ENDEREÇO
	function BuscaCep(cep,setCep,setEnd,setN,setBairro,setCity,uf){
		$('.d_aviso_erro').hide().children('p').html("");
		if(cep=="_____-___" || cep==""){return false;}
        var endereco = $('#'+setEnd),numero = $('#'+setN),bairro = $('#'+setBairro),cidade = $('#'+setCity),estado = $('#'+uf),estados = document.getElementById(uf);
        endereco.attr('disabled',true).val('carregando...');
        bairro.attr('disabled',true).val('carregando...');
        cidade.attr('disabled',true).val('carregando...');
        estado.attr('disabled',true);
        
        $.post('_php/cep.php',{cep:cep},function(retcep){
            endereco.attr('disabled',false).val('');
            bairro.attr('disabled',false).val('');
            cidade.attr('disabled',false).val('');
            estado.attr('disabled',false);
			
			if(retcep==false){
				$('#erro_'+setCep+' p').html('Cep não encontrado, por favor, coloque outro cep !');
				$('#erro_'+setCep).show();
			}else{
				var r=retcep.split('|');
				endereco.val(unescape(r[0].replace(/\+/g," ")));
				bairro.val(unescape(r[1].replace(/\+/g," ")));
                cidade.val(unescape(r[2].replace(/\+/g," ")));
                var e = estados.options.length;
                    while (e--){
                        if (estados.options[e].getAttribute("value") == r[3]){
                            break;
                        }
                    }
                estados.selectedIndex = e;
				numero.focus();				
			}
        });
    }

//COMEÇO NUMBER FORMAT
function number_format(number, decimals, dec_point, thousands_sep) {
	// Strip all characters but numerical ones.
	number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
	var n = !isFinite(+number) ? 0 : +number,
		prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
		sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
		dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
		s = '',
		toFixedFix = function (n, prec) {
			var k = Math.pow(10, prec);
			return '' + Math.round(n * k) / k;
		};
	// Fix for IE parseFloat(0.55).toFixed(0) = 0;
	s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
	if (s[0].length > 3) {
		s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
	}
	if ((s[1] || '').length < prec) {
		s[1] = s[1] || '';
		s[1] += new Array(prec - s[1].length + 1).join('0');
	}
	return s.join(dec);
}


//JAVA VALIDA SÓ NÚMEROS PARA FORMULARIOS
function SomenteNumero(e){	
	var tecla=(window.event)?event.keyCode:e.which;
	if(tecla>47 && tecla<58){
        return true;
	}else{
		if(tecla==8 || tecla==0 || tecla==13){
            return true;
		}else{
            return false;
		}
	}
}

//SEM ESPAÇO
function SemEspaco(valor){	
	var espaco=$(valor).val().split(" "),str=$(valor).val();		
	for(var n=1; espaco.length>n; n++){
	str=str.replace(" ","");
	}	
	$(valor).val(str);
}