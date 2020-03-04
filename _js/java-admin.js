var erS=new RegExp(/^(?=.*\d)(?=.*[a-z])(?!.*\s).*$/);
//JAVA BUSCA ENDEREÇO
	function BuscaCep(cep,setCep,setEnd,setN,setBairro,setCity,uf){
		$('.d_aviso_erro').hide().children('p').html("");
        var endereco = $('#'+setEnd),numero = $('#'+setN),bairro = $('#'+setBairro),cidade = $('#'+setCity),estado = $('#'+uf),estados = document.getElementById(uf);
        $('#d_busca_cep_empresa').hide();
        $('#carrega_cep').show();
        $.post('_php/cep.php',{cep:cep},function(retcep){
            $('#carrega_cep').hide();
            $('#d_busca_cep_empresa').show();
            endereco.val('');
            bairro.val('');
            cidade.val('');
			
			if(retcep==false){
				$('#erro_'+setCep+' p').html('Cep não encontrado !');
				$('#erro_'+setCep).show();
                endereco.focus();
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
		
	//JAVA CADASTROS
	//JAVA CADASTRO DE EMPRESA		
	$(function(){
        
    $("#tel_empresa").mask("(99) 9999-9999?9");
    $("#cep_empresa").mask("99999-999");
    
    $('body').on('keyup','#cep_empresa',function(e){
        var tecla=(window.event)?event.keyCode:e.which;
		if(tecla==13){
            if($(this).val().trim()!=""){
                $(this).blur();
            }
		}
    });
	
        //CARREGA TOKEN PAGAMENTO
    $('#u_menu_pamaento').on('click','a',function(){
		$('.d_aviso_erro').hide().children('p').html("");
		if($('#IdDaSessao').val()==""){
		carregaIdDaSessao();
		}
		$('#u_menu_pamaento li a').removeClass('cima_menu');
		$(this).addClass('cima_menu');
		var qualPago = $(this).attr('id');
		$('.fechaPaga').hide();
		
		if(qualPago=='pg-cartao'){
		$('#d_tudo_cartao').show();
		$('#pg_nome').focus();
		}else if(qualPago=='pg-boleto'){
		$('#d_tudo_boleto').show();
		}else{
		$('#d_tudo_transf').show();
		}
		
		});
        
        });

	
	
	function cpfcnpjExt(){
		var cnpjCpf = $('#cnpjCpf_empresa');
		cnpjCpf.val(cnpjCpf.val().replace(/[^0-9]+/g,""));
	}
	
	function cpfcnpjEnter(){
		$('.d_aviso_erro').hide().children('p').html("");
		var cnpjCpf = $('#cnpjCpf_empresa').val().replace(/[^0-9]+/g,"");
		if(cnpjCpf.length==11){
		$('#cnpjCpf_empresa').val(cnpjCpf.substring(0,3)+'.'+cnpjCpf.substring(3,6)+'.'+cnpjCpf.substring(6,9)+'-'+cnpjCpf.substring(9));
		}else if(cnpjCpf.length==14){
		$('#cnpjCpf_empresa').val(cnpjCpf.substring(0,2)+'.'+cnpjCpf.substring(2,5)+'.'+cnpjCpf.substring(5,8)+'/'+cnpjCpf.substring(8,12)+'-'+cnpjCpf.substring(12));
		}else{
			if(cnpjCpf!=""){
			$('#erro_cnpjCpf_empresa p').html('CNPJ ou CPF incorreto !');
			$('#erro_cnpjCpf_empresa').show();
			$('#cnpjCpf_empresa').focus();
			}
		}
	}
	
	function delAmbOpe(idAmbOpe){
			
			$('#carregador').show();
			var selId=idAmbOpe.split('_'),idDel=selId[1],varia,txtOpAmb,liOpeAmb;
			if(selId[0]=='DelliOpe'){
			varia={idDelOpe:idDel};
            txtOpAmb="Operador";
            liOpeAmb='#liOpe_';
			}else{
			varia={idDelAmb:idDel};
            txtOpAmb="Ambiente";
            liOpeAmb='#liAmb_';
			}
			
			$.post("_php/alterar_cadastros.php",varia,function(retorno){		
			var retu=retorno.split('|'),msg=retu[0],erro=retu[1];		
			$('#carregador').hide();
				if(erro==""){
					$(liOpeAmb+idDel).remove();
					$('#dentroOk').html(txtOpAmb+" deletado com sucesso !").fadeIn(150);
					setTimeout(function(){$('#dentroOk').fadeOut(150,function(){$('#dentroOk').html("");});},800);
				}else{
				$('#alert-cima p').html(msg);
				$('#alert').show();
				$('#spanalert a').focus();
				}
				$('#spansim a').attr('id','').attr('class','');
				$('#spansim').removeClass('sim');
			});
		}
	
	$(function(){		
	//CADASTRA DADOS DA EMPRESA		
	$('#troca_cadastros').on('keypress','#cnpjCpf_empresa',function(e){
		var tecla=(window.event)?event.keyCode:e.which;
		if(tecla==13){
		cpfcnpjEnter();
		}
	});
	
	$('#troca_cadastros').on('click','#cadastra_empresa',function(){
		$('.d_aviso_erro').hide().children('p').html("");
		var razao=$('#razao_empresa').val().trim(),cnpjCpf=$('#cnpjCpf_empresa').val().trim(),tel=$('#tel_empresa').val().trim(),cep=$('#cep_empresa').val().trim(),endereco = $('#endereco_empresa').val().trim(),numero = $('#numero_empresa').val().trim(),complemento = $('#comple_empresa').val().trim(),bairro = $('#bairro_empresa').val().trim(),cidade = $('#cidade_empresa').val().trim(),estado = $('#estado_empresa').val().trim(),upInsert=$(this).attr('class');
		if(razao==""){
		$('#erro_razao_empresa p').html("Nome do negócio está em branco !");
		$('#erro_razao_empresa').show();
		$('#razao_empresa').focus();
		}else if(cnpjCpf==""){
		$('#erro_cnpjCpf_empresa p').html("CNPJ ou CPF está em branco !");
		$('#erro_cnpjCpf_empresa').show();
		$('#cnpjCpf_empresa').focus();
		}else if(tel==""){
		$('#erro_tel_empresa p').html("Telefone está em branco !");
		$('#erro_tel_empresa').show();
		$('#tel_empresa').focus();
		}else if(cep==""){
		$('#erro_cep_empresa p').html("Cep está em branco !");
		$('#erro_cep_empresa').show();
		$('#cep_empresa').focus();
		}else if(endereco==""){
		$('#erro_endereco_empresa p').html("Endereço está em branco !");
		$('#erro_endereco_empresa').show();
		$('#endereco_empresa').focus();
		}else if(numero==""){
		$('#erro_numero_empresa p').html("Número está em branco !");
		$('#erro_numero_empresa').show();
		$('#numero_empresa').focus();
		}else if(isNaN(numero)){
		$('#erro_numero_empresa p').html("Coloque apenas números !");
		$('#erro_numero_empresa').show();
		$('#numero_empresa').focus();
		}else if(bairro==""){
		$('#erro_bairro_empresa p').html("Bairro está em branco !");
		$('#erro_bairro_empresa').show();
		$('#bairro_empresa').focus();
		}else if(cidade==""){
		$('#erro_cidade_empresa p').html("Cidade está em branco !");
		$('#erro_cidade_empresa').show();
		$('#cidade_empresa').focus();
		}else if(estado==""){
		$('#erro_estado_empresa p').html("Estado está em branco !");
		$('#erro_estado_empresa').show();
		$('#estado_empresa').focus();
		}else{
			$('#carregador').show();
			$.post('_php/cadastrar_dados.php',{upInsert:upInsert,razao:razao,cep:cep,endereco:endereco,numero:numero,complemento:complemento,bairro:bairro,cidade:cidade,estado:estado,tel:tel,cnpjCpf:cnpjCpf},function(retorno){		
			$('#carregador').hide();
			var ret=retorno.split('|'),msg=ret[0],diverro=ret[1];				
				if(diverro!="erro"){
					if(diverro!=""){
						$('#erro_'+diverro+' p').html(msg);
						$('#erro_'+diverro).show();
						$('#'+diverro).focus();
					}else{
                        
                        if(upInsert=="cadastrar"){
						window.history.pushState(null,'Gerabar - Gerenciador Online',getUrl()+'?passos='+msg);
						$('#troca_cadastros').html('');
						$('#loadingOne').show();
						$('.separa_passos span').removeClass('passso_ativo');
						$('#passo_2').addClass('passso_ativo');
						$('.separa_passos').removeClass('bt_respansivo');
						$('.separa_passos').addClass('bt_respansivo');
						$('#separa_two').removeClass('bt_respansivo');
						$.post('_include/cadastro_confAmb.php',{inclui:true},function(pagina){
							$('#loadingOne').hide();
							$('#troca_cadastros').html(pagina);
							$('#i_acessoAmb').focus();
						});
						}else{
							$('#dentroOk').html(msg).fadeIn(150);
							setTimeout(function(){$('#dentroOk').fadeOut(150,function(){$('#dentroOk').html("");});},800);
						}						
					}
				}else{
					$('#alert-cima p').html(msg);
					$('#alert').show();
					$('#spanalert a').focus();
				}
			});
		}
		return false;
	});	
	
	//###TUDO CADASTRO DE AMBIENTES###	
		//SELECIONAR AMBIENTE
		$('#troca_cadastros').on('click','#ul_amb a',function(){
			$('#ul_amb a').removeClass('select_li_amb');
			$(this).addClass('select_li_amb');		
		});
		
		$('#troca_cadastros').on('click','#envia_amb',function(){
			$('.d_aviso_erro').hide().children('p').html("");
			var selAmb=$('a.select_li_amb').attr('id');			
			if(selAmb===undefined){
				$('#alert-cima p').html('Por favor, selecione o ambiente com o qual irá trabalhar.');
				$('#alert').show();
				$('#spanalert a').focus();
			}else{
			$('#carregador').show();
			$.post('_php/cadastrar_dados.php',{selAmb:selAmb,local:$(".alinha_empresa").attr('id')},function(retAmb){			
				$('#carregador').hide();
				if(retAmb==""){					
					if($(".alinha_empresa").attr('id')=="proximo"){
					window.history.pushState(null,'Gerabar - Gerenciador Online',getUrl()+'?passos=3');
					$('.separa_passos span').removeClass('passso_ativo');
					$('#passo_3').addClass('passso_ativo');
					$('#troca_cadastros').html("");
					$('#loadingOne').show();
					$.post('_include/cadastro_confAmb.php',{inclui:true},function(pagina){
						$('#loadingOne').hide();
						$('#troca_cadastros').html(pagina);
					});
					}else{
					$('#dentroOk').html("Atualização feita com sucesso !").fadeIn(150);
					setTimeout(function(){$('#dentroOk').fadeOut(150,function(){$('#dentroOk').html("");});},800);
					}				
				}else{
					$('#alert-cima p').html(retAmb);
					$('#alert').show();
					$('#spanalert a').focus();
				}
			});
			}
			return false;
		});
		
		//CADASTRO DE LOGIN DE AMBEINTE
		$('#troca_cadastros').on('keyup','.amb-tira-espaco',function(){
		if($(this).attr('id')=='i_senhaAmb' || $(this).attr('id')=='i_senhaOpe'){
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
		}else{		
		var espaco=$(this).val().split(" "),str=$(this).val();		
		for(var n=1; espaco.length>n; n++){
		str=str.replace(" ","");
		}	
		$(this).val(str);
		}
		});
		
		$('#troca_cadastros').on('click','.olho-amb',function(){
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
		
		
		$('#troca_cadastros').on('click','#i_enviaAmb',function(){
            
		$('.d_aviso_erro').hide().children('p').html("");
		var acessoAmb=$('#i_acessoAmb'),nomeAmb=$('#i_nomeAmb'),senhaAmb=$('#i_senhaAmb');
		if(acessoAmb.val().trim()==""){
		$('#erro_'+acessoAmb.attr('id')+' p').html("Nome de acesso está em branco !");
		$('#erro_'+acessoAmb.attr('id')).show();
		acessoAmb.focus();
		}else if(nomeAmb.val().trim()==""){
		$('#erro_'+nomeAmb.attr('id')+' p').html("Nome do novo ambiente está em branco !");
		$('#erro_'+nomeAmb.attr('id')).show();
		nomeAmb.focus();
		}else if(senhaAmb.val().trim()==""){
		$('#erro_'+senhaAmb.attr('id')+' p').html("Senha do novo ambiente está em branco !");
		$('#erro_'+senhaAmb.attr('id')).show();
		senhaAmb.focus();
		}else if(senhaAmb.val().trim().length<6){
		$('#erro_'+senhaAmb.attr('id')+' p').html("Senha pequena demais, a senha tem que conter pelo menos 6 caracteres !");
		$('#erro_'+senhaAmb.attr('id')).show();
		senhaAmb.focus();
		}else if(erS.test(senhaAmb.val().trim())==false){
		$('#erro_'+senhaAmb.attr('id')+' p').html("Senha tem que conter letras e numéros !");
		$('#erro_'+senhaAmb.attr('id')).show();
		senhaAmb.focus();
		}else{
			$('#carregador').show();
			$.post('_php/cadastrar_dados.php',{pAcesso:$('.p_numAmb').html(),acessoAmb:acessoAmb.val(),nomeAmb:nomeAmb.val(),senhaAmb:senhaAmb.val()},function(retorno){
			$('#carregador').hide();
			var ret=retorno.split('|'),msg=ret[0],diverro=ret[1];
			if(diverro!=""){
				if(diverro=="erro"){
					$('#alert-cima p').html(msg);
					$('#alert').show();
					$('#spanalert a').focus();			
				}else{
					$('#erro_'+diverro+' p').html(msg);
					$('#erro_'+diverro).show();
					$('#'+diverro).focus();
				}			
			}else{
				$('#dentroOk').html("Ambiente salvo com sucesso !").fadeIn(150);
				setTimeout(function(){$('#dentroOk').fadeOut(150,function(){$('#dentroOk').html("");});},800);
				$('.li_amb_login ul').removeClass('ulAmbAberta').hide();
				$('.openExitAmb').removeClass('amb_ativo').attr('title','Mostrar Páginas');
                
                $('#l_ambAcima').before('<li class="li_amb_login" id="liAmb_'+msg+'"><div class="d_td_cmd"><span>'+$('.p_numAmb').html()+acessoAmb.val()+'</span><span class="s_amb_up">'+nomeAmb.val()+'</span><span>********</span><span class="s_acao_amb"><a href="javascript:void(0);" class="openExitAmb amb_ativo" id="ambOpen_'+msg+'" title="Esconder Páginas"></a><a href="javascript:void(0);" class="deleteAmb imgDelAmb" title="Excluir Login"></a></span></div><ul id="ulAmb_'+msg+'" class="ulAmbAberta"><li class="li_pgs_amb addAfter"><p>selecione as páginas para o ambiente '+nomeAmb.val()+':</p></li><li><label class="for_label_amb"><input type="checkbox" id="td_icheck_'+msg+'" class="i_checkTudo" /><p class="sel_tudo_amb">selecionar todas</p></label><a href="javascript:void(0);" class="a_salvaPgAmb">salvar páginas</a></li></ul></li>');                
                var nn,arTxt={
                    0:['identificar','ativar identificação do operador'],
                    1:['frente_caixa','frente de caixa'],
                    2:['abrir_caixa','opções de caixa'],
                    3:['comanda_bar','comanda bar'],
                    4:['contas_clientes','contas de clientes'],
                    5:['estoque','estoque'],
                    6:['clientes','clientes'],
                    7:['cadastros','cadastros'],
                    8:['administracao','administração']
                };
                for(var i=0;9>i;i++){
                    nn=i+1;
                    $('.addAfter').after('<li class="altAfter"><label><input type="checkbox" value="'+arTxt[i][0]+'" id="num_'+nn+'_'+msg+'" class="icheck_'+msg+'" /><p>'+arTxt[i][1]+'</p></label><span title="Salvo no ambiente" class="salvoAmb"></span></li>');
                    $('.addAfter').removeClass('addAfter');
                    if(i==8){
                    $('.altAfter').removeClass('altAfter');
                    }else{
                    $('.altAfter').attr('class','addAfter');
                    }
                }
                
				$('#d_acertaSenha .olho-amb').hide();
				if($('#d_acertaSenha').attr('class')=='mostra-senha'){
				$('#d_acertaSenha .olho-amb').attr('title','Mostrar Senha'); 
				$('#d_acertaSenha').attr('class','');
				senhaAmb.attr('type','password');
				}
				nomeAmb.val(""); senhaAmb.val(""); acessoAmb.val(""); acessoAmb.focus();
			}
			});
		}
		return false;
		});
		
		$('body').on('click','.deleteAmb',function(){
			if($('#spansim').attr('class')!="sim"){
			$('#confirm-cima p').html('Tem certeza que deseja excluir o ambiente ?');
			$('#spansim a').attr('id','Del'+$(this).parents('li').attr('id')).addClass('deleteAmb');
			$('#spansim').addClass('sim');
			$('#confirm').show();
			$('#spansim a').focus();
			}else{
			$('#confirm-cima p').html('');
			$('#confirm').hide();
			delAmbOpe($(this).attr('id'));
			return false;
			}
		});
		
		
		$('#troca_cadastros').on('click','.openExitAmb',function(){
			$('.d_aviso_erro').hide().children('p').html("");
			var idVar=$(this).attr('id').split('_'),idAmb=idVar[1];
			$('.openExitAmb').removeClass('amb_ativo').attr('title','Mostrar Páginas');
			if($('#ulAmb_'+idAmb).attr('class')=="ulAmbAberta"){
				$('#ulAmb_'+idAmb).slideUp(200).removeClass('ulAmbAberta');
			}else{				
				$(this).addClass('amb_ativo').attr('title','Esconder Páginas');
				$('.li_amb_login ul').removeClass('ulAmbAberta').slideUp(200);
				$('#ulAmb_'+idAmb).slideDown(400).addClass('ulAmbAberta');
			}		
		});
		
		$('#troca_cadastros').on('click','.for_label_amb',function(){			
			var d=$(this).parents('ul.ulAmbAberta').attr('id').split('_');
			if($(this).children('input').is(':checked')){
			$('.icheck_'+d[1]).prop("checked",true);
			}else{
			$('.icheck_'+d[1]).prop("checked",false);
			}
		});
		
		$("#troca_cadastros").on('click','ul.ulAmbAberta input[type=checkbox]',function(){		
		if($(this).attr('class')!="i_checkTudo"){$('#td_'+$(this).attr('class')).prop("checked",false);}		
		});
        
		$("#troca_cadastros").on('click','.a_salvaPgAmb',function(){
			var selId=$(this).parents('ul.ulAmbAberta').attr('id').split('_'),
                temAdmin=(selId[1]=="admin")?0:1,
                lengLi=parseInt($(this).parents('ul.ulAmbAberta').children('li').length)-temAdmin,
                salvos=[];
			for(var i=2-temAdmin;i<lengLi;i++){
				if($("#num_"+i+"_"+selId[1]).is(':checked')){
					salvos.push($("#num_"+i+"_"+selId[1]).val());
				}
			}
			if(salvos==""){
				salvos.push("");
			}
			$('#carregador').show();
			$.post("_php/cadastrar_dados.php",{idAmb:selId[1],salvosAmb:salvos},function(rel){
				$("#carregador").hide();
				var das=rel.split('|'),msg=das[0],erro=das[1];
				if(erro==""){
					$('ul.ulAmbAberta span').hide();
					for(var i=1;i<lengLi;i++){
						if($("#num_"+i+"_"+selId[1]).is(':checked')){
							$("#num_"+i+"_"+selId[1]).parents('li').children('span').show();
						}
					}
					$('#dentroOk').html("Páginas salvas com sucesso !").fadeIn(150);
					setTimeout(function(){$('#dentroOk').fadeOut(150,function(){$('#dentroOk').html("");});},800);
				}else{
				$('#alert-cima p').html(msg);
				$('#alert').show();
				$('#spanalert a').focus();
				}
			
			});
			
		});
		
		//CONFIGURACOES GERAIS        
        $('#troca_cadastros').on('click','.d_toggle label',function(){
            var ativar,toggle=$(this);
            ativar=(toggle.attr('id')=='l_toggle_desativado')?1:0;
            $('.d_toggle .carregador_toggle').show();
            $.get('_php/alterar_cadastros.php',{ativar_sangria:ativar},function(retorno){
            $('.d_toggle .carregador_toggle').hide();
            var ret=retorno.split('|'),msg=ret[0],erro=ret[1];
                if(erro=='erro'){
                    $('#alert-cima p').html(msg);
                    $('#alert').show();
                    $('#spanalert a').focus();
                }else{
                    if(ativar==1){
                        toggle.attr('id','l_toggle_ativado');
                         toggle.addClass('label_ativo');
                        $('#li_abrir_fecha_caixa').parent('li').show();
                        }else{
                        toggle.attr('id','l_toggle_desativado');
                         toggle.removeClass('label_ativo'); 
                        $('#li_abrir_fecha_caixa').parent('li').hide();
                        }
                }
            });
            return false;
        });
        
		$('#troca_cadastros').on('click','#atualizar_usuario',function(){
		$('.d_aviso_erro').hide().children('p').html("");
		var nome=$('#usuario_nome'),sobrenome=$('#usuario_sobrenome'),nascimento=$('#usuario_nascimento'),sexo=$('#usuario_sexo'),nomeUser=$('#usuario_nomeUser'),email=$('#usuario_email');		
		if(nome.val()=="" || nome.val().length<4){
			$('#erro_'+nome.attr('id')+' p').html("Nome em branco ou pequeno de mais !");
			$('#erro_'+nome.attr('id')).show();
			nome.focus();
		}else if(sobrenome.val()=="" || sobrenome.val().length<4){
			$('#erro_'+sobrenome.attr('id')+' p').html("Sobrenome em branco ou pequeno de mais !");
			$('#erro_'+sobrenome.attr('id')).show();
			sobrenome.focus();
		}else if(nascimento.val()==""){
			$('#erro_'+nascimento.attr('id')+' p').html("Data de nascimento está em braco !");
			$('#erro_'+nascimento.attr('id')).show();
			nascimento.focus();
		}else if(sexo.val()==""){
			$('#erro_'+sexo.attr('id')+' p').html("Sexo não selecionado !");
			$('#erro_'+sexo.attr('id')).show();
			sexo.focus();
		}else if(nomeUser.val()=="" || nomeUser.val().length<2){
			$('#erro_'+nomeUser.attr('id')+' p').html("Nome de usuário em branco ou pequeno de mais !");
			$('#erro_'+nomeUser.attr('id')).show();
			nomeUser.focus();
		}else if(email.val()=="" || er.test(email.val())==false){
			$('#erro_'+email.attr('id')+' p').html("E-mail em branco ou inválido !");
			$('#erro_'+email.attr('id')).show();
			email.focus();
		}else{
			$('#carregador').show();
				$.post("_php/alterar_cadastros.php",{nome:nome.val(),sobrenome:sobrenome.val(),nasc:nascimento.val(),sexo:sexo.val(),nomeUser:nomeUser.val(),email:email.val()},function(retorno){
				$('#carregador').hide();
				var ret=retorno.split('|'),msg=ret[0],diverro=ret[1];
					if(diverro!=""){
						if(diverro=="erro"){
							$('#alert-cima p').html(msg);
							$('#alert').show();
							$('#spanalert a').focus();			
						}else{
							$('#erro_'+diverro+' p').html(msg);
							$('#erro_'+diverro).show();
							$('#'+diverro).focus();
						}
					}else{
						$('#dentroOk').html(msg).fadeIn(150);
						setTimeout(function(){$('#dentroOk').fadeOut(150,function(){$('#dentroOk').html("");});},800);
					}
				});
		}
		return false;
		});
		
		//CADASTRO DE OPERARIOS (FUNCIONARIOS)		
		$('#troca_cadastros').on('click','#i_enviaOpe',function(){
		$('.d_aviso_erro').hide().children('p').html("");
		var nomeOpe=$('#i_nomeOpe'),codOpe=$('#i_codOpe'),senhaOpe=$('#i_senhaOpe');		
        
		if(nomeOpe.val()==""){
		$('#erro_'+nomeOpe.attr('id')+' p').html("Nome do operador está em branco !");
		$('#erro_'+nomeOpe.attr('id')).show();
		nomeOpe.focus();
        }else if(codOpe.val()==""){
		$('#erro_'+codOpe.attr('id')+' p').html("Cógido está em branco !");
		$('#erro_'+codOpe.attr('id')).show();
		codOpe.focus();
		}else if(isNaN(codOpe.val())){
		$('#erro_'+codOpe.attr('id')+' p').html("Coloque apenas números !");
		$('#erro_'+codOpe.attr('id')).show();
		codOpe.focus();
		}else if(senhaOpe.val()==""){
		$('#erro_'+senhaOpe.attr('id')+' p').html("Senha do novo operador está em branco !");
		$('#erro_'+senhaOpe.attr('id')).show();
		senhaOpe.focus();
		}else if(senhaOpe.val().length<6){
		$('#erro_'+senhaOpe.attr('id')+' p').html("Senha pequena demais, a senha tem que conter pelo menos 6 caracteres !");
		$('#erro_'+senhaOpe.attr('id')).show();
		senhaOpe.focus();
		}else{
			$('#carregador').show();
			$.post('_php/cadastrar_dados.php',{nomeOpe:nomeOpe.val(),codOpe:codOpe.val(),senhaOpe:senhaOpe.val()},function(retorno){
			$('#carregador').hide();
			var ret=retorno.split('|'),msg=ret[0],diverro=ret[1];
			if(diverro!=""){
				if(diverro=="erro"){
					$('#alert-cima p').html(msg);
					$('#alert').show();
					$('#spanalert a').focus();			
				}else{
					$('#erro_'+diverro+' p').html(msg);
					$('#erro_'+diverro).show();
					$('#'+diverro).focus();
				}			
			}else{
				$('#dentroOk').html("Operador salvo com sucesso !").fadeIn(150);
				setTimeout(function(){$('#dentroOk').fadeOut(150,function(){$('#dentroOk').html("");});},800);
				$('#l_opeAcima').before('<li class="li_amb_login" id="liOpe_'+msg+'"><div class="d_td_cmd"><span>'+nomeOpe.val()+'</span><span class="s_amb_up">'+codOpe.val()+'</span><span>********</span><span class="s_acao_amb"><a href="javascript:void(0);" class="editOpe" id="editOpe_'+msg+'" title="Editar Operador"></a><a href="javascript:void(0);" class="deleteOpe imgDelOpe" title="Excluir Operador"></a></span></div></li>');
				$('#d_acertaSenhaOp .olho-amb').hide();
				if($('#d_acertaSenhaOp').attr('class')=='mostra-senha'){
				$('#d_acertaSenhaOp .olho-amb').attr('title','Mostrar Senha'); 
				$('#d_acertaSenhaOp').attr('class','');
				senhaOpe.attr('type','password');
				}
				nomeOpe.val(""); codOpe.val(""); senhaOpe.val(""); nomeOpe.focus();
			}
			});
		}
		return false;
		
		});
		
		$('body').on('click','.deleteOpe',function(){
			if($('#spansim').attr('class')!="sim"){
			$('#confirm-cima p').html('Tem certeza que deseja excluir o operador ?');
			$('#spansim a').attr('id','Del'+$(this).parents('li').attr('id')).addClass('deleteOpe');
			$('#spansim').addClass('sim');
			$('#confirm').show();
			$('#spansim a').focus();
			}else{
			$('#confirm-cima p').html('');
			$('#confirm').hide();			
			delAmbOpe($(this).attr('id'));
			return false;
			}
		});
		
		$("#troca_cadastros").on('click','#envia_ambOpe',function(){
				window.history.pushState(null,'Gerabar - Gerenciador Online',getUrl()+'?passos=3');
				$('.separa_passos span').removeClass('passso_ativo');
				$('.separa_passos').removeClass('bt_respansivo');
				$('.separa_passos').addClass('bt_respansivo');
				$('#separa_three').removeClass('bt_respansivo');
				$('#passo_3').addClass('passso_ativo');
				$('#troca_cadastros').html("");
				$('#loadingOne').show();
				$.post('_include/cadastro_pronto.php',{status:"altera"},function(pagina){
					$('#loadingOne').hide();
					$('#troca_cadastros').html(pagina);
				});
			return false;
		});
		
		//PÁGINAS DE CADASTROS DE CLIENTES/PRODUTOS E ETC..
		
		//window.history.pushState(“object or string”, “Title”, “/new-url”);
		
		$('#menu_cadastro a').on('click',function(){
				var cad = $(this).attr('class');
				if(cad=="submenu"){
					if($('#'+$(this).attr('id')+'_cadastro').attr('class')=='submenu_cadastro'){			
						if($(this).children('span').attr('class')=="fecha"){
						$('#'+$(this).attr('id')+'_cadastro').removeClass('submenu_cadastro').slideDown(200);
						}else{
						$('#'+$(this).attr('id')+'_cadastro').slideUp(200).removeClass('submenu_cadastro');
						$(this).children('span').removeClass('fecha').addClass('abre');
						}
					}else{
						if($(this).children('span').attr('class')=="abre"){
							$('.submenu span').removeClass('fecha').addClass('abre');
							$('#menu_cadastro li ul').slideUp(200).removeClass('submenu_cadastro');
							$('#'+$(this).attr('id')+'_cadastro').slideDown(200);
							$(this).children('span').removeClass('abre').addClass('fecha');
						}else{
							$('#'+$(this).attr('id')+'_cadastro').slideUp(200).removeClass('submenu_cadastro');
							$(this).children('span').removeClass('fecha').addClass('abre');
						}
					}
				}else{
					if(window.history.pushState){
					$('#menu_cadastro li').removeClass('cadastro_ativo');
					$(this).parent('li').addClass('cadastro_ativo');
					var tipo;
					if($(this).children('span').attr('class')===undefined){
					$('.submenu span').removeClass('fecha').addClass('abre');
					$('#menu_cadastro li ul').slideUp(200).removeClass('submenu_cadastro');
					tipo = 'cad';
					}else{
					tipo = $(this).children('span').attr('class');
					$(this).parent('li').parent('ul').hide().addClass('submenu_cadastro');
					}
					window.history.pushState(null,'Gerabar - '+cad,$(this).attr('href'));
					if($("#menu_cadastro").attr('class')=="pgCadastro"){
					$('#h_cadastros').html('cadastro de '+cad);
					}
					$('#troca_cadastros').html('');
					$('#loadingOne').show();
					if(cad=="logotipo"){
					cad="imglogo";
					}else if(cad=="ambiente-funcionario"){
					cad="confAmb";
					}
					$.post('_include/cadastro_'+cad+'.php',{inclui:cad,tipo:tipo},function(pagina){
						$('#loadingOne').hide();
						$('#troca_cadastros').html(pagina);
						if(cad=="produtos"){
						$('#cd_produto_marca').focus();
						}else if(cad=="clientes"){
						$('#cd_cliente_nome').focus();
						}else if(cad=="entrada"){
						$('#cd_descEntrada_0').focus();
						}else if(cad=="unidades"){
						$('#cd_unidades_array_0').focus();
						}
					});
					return false;
					}
				}
		});
		
		//CADASTRO PRODUTOS
		$('#troca_cadastros').on('click','#envia_produtos',function(){
			$('.d_aviso_erro').hide().children('p').html("");
			var marca = $('#cd_produto_marca'),descricao = $('#cd_produto_descricao'),
			unidade = $('#cd_produto_unidade'),categoria = $('#cd_produto_categoria'),fornecedores = $('#cd_produto_fornecedor'),
			quant = $('#cd_produto_qtd'),codInterno = $('#cd_produto_codInterno'),valCompra = $('#cd_produto_valCompra'),
			margem = $('#cd_produto_valCompra-margem'),valVarejo = $('#cd_produto_valCompra_valVarejo');
			
			if(marca.val()==""){
			$('#erro_'+marca.attr('id')+' p').html("Marca está em branco !");
			$('#erro_'+marca.attr('id')).show();
			marca.focus();
			}else if(descricao.val()==""){
			$('#erro_'+descricao.attr('id')+' p').html("Descrição está em branco !");
			$('#erro_'+descricao.attr('id')).show();
			descricao.focus();
			}else if(unidade.val()==""){
			$('#erro_'+unidade.attr('id')+' p').html("Selecione uma unidade de venda !");
			$('#erro_'+unidade.attr('id')).show();
			unidade.focus();
			}else if(categoria.val()==""){
			$('#erro_'+categoria.attr('id')+' p').html("Categoria está em branco !");
			$('#erro_'+categoria.attr('id')).show();
			categoria.focus();
			}else if(fornecedores.val()==""){
			$('#erro_'+fornecedores.attr('id')+' p').html("Fornecedores está em branco !");
			$('#erro_'+fornecedores.attr('id')).show();
			fornecedores.focus();
			}else if(quant.val()==""){
			$('#erro_'+quant.attr('id')+' p').html("Quantidade está em branco !");
			$('#erro_'+quant.attr('id')).show();
			quant.focus();
			}else if(isNaN(quant.val())){
			$('#erro_'+quant.attr('id')+' p').html("Coloque apenas números !");
			$('#erro_'+quant.attr('id')).show();
			quant.focus();
			}else if(codInterno.val()==""){
			$('#erro_'+codInterno.attr('id')+' p').html("Código interno está em branco !");
			$('#erro_'+codInterno.attr('id')).show();
			codInterno.focus();
			}else if(valCompra.val()=="" || valCompra.val()=="0,00"){
			$('#erro_'+valCompra.attr('id')+' p').html("Valor de compra está em branco !");
			$('#erro_'+valCompra.attr('id')).show();
			valCompra.focus();
			}else if(margem.val()==""){
			$('#erro_'+margem.attr('id')+' p').html("Margem está em branco !");
			$('#erro_'+margem.attr('id')).show();
			margem.focus();
			}else if(isNaN(margem.val())){
			$('#erro_'+margem.attr('id')+' p').html("Coloque apenas números !");
			$('#erro_'+margem.attr('id')).show();
			margem.focus();
			}else if(valVarejo.val()=="" || valVarejo.val()=="0,00"){
			$('#erro_'+valVarejo.attr('id')+' p').html("Valor de venda está em branco !");
			$('#erro_'+valVarejo.attr('id')).show();
			valVarejo.focus();
			}else{

			var valorCompra = valCompra.val().replace(/[.]/g,"").replace(",","."),
			valorVarejo = valVarejo.val().replace(/[.]/g,"").replace(",",".");
			$('#carregador').show();
			$.post('_php/cadastrar_dados.php',{cadastro:'produtos',marca:marca.val(),descricao:descricao.val(),unidade:unidade.val(),categoria:categoria.val(),fornecedores:fornecedores.val(),quant:quant.val(),codInterno:codInterno.val(),valCompra:valorCompra,margem:margem.val(),valVarejo:valorVarejo},function(dados){
				$('#carregador').hide();
				var ret=dados.split('|'),msg=ret[0],diverro=ret[1];				
				if(diverro!="erro"){
					if(diverro!=""){
						$('#erro_'+diverro+' p').html(msg);
						$('#erro_'+diverro).show();
						$("#"+diverro).focus();
					}else{
						$('#dentroOk').html(msg).fadeIn(150);
						setTimeout(function(){$('#dentroOk').fadeOut(200,function(){$('#dentroOk').html("");});},1500);
						$('#troca_cadastros').html('');
						$('#loadingOne').show();
						$.post('_include/cadastro_produtos.php',{inclui:true},function(pagina){
							$('#loadingOne').hide();
							$('#troca_cadastros').html(pagina);
							$('#cd_produto_marca').focus();
						});
					}
				}else{
					$('#alert-cima p').html(msg);
					$('#alert').show();
					$('#spanalert a').focus();
				}			
			});			
			}
			return false;		
		});
		
		$('body').on('keyup','.carrega_margem',function(){
			var ret=$(this).attr('id').split("-"),principal=ret[0];
			valorMargem($(this).attr('id'),principal,'salva_'+principal,principal+'_valVarejo');
		});
		
		$('body').on('keyup','.carrega_valor',function(){
			var principal = $(this).attr('id');			
			valorMargem(principal+'-margem',principal,'salva_'+principal,principal+'_valVarejo');
		});
		
		function valorMargem(qualMargem,qualValCompra,qualSalva,qualVarejo){
            var valor = parseFloat($('#'+qualValCompra).val().replace(/[.]/g,"").replace(",",".")),result,total,novoVal,ultimo,valFinal,
                porcento=($('#'+qualMargem).val()=="")?0:parseInt($('#'+qualMargem).val());
			
			
			result = valor/100;
			total = valor+(porcento*result);
			$('#'+qualSalva).val(total);
			var novoValor = $('#'+qualSalva).val().replace(".",",");
			var b = 0,aumenta=0,para = false;
			for(var i=0;i<novoValor.length;i++){
				b+=1;			
				if(novoValor.substring(i,b)==','){para=true;}
				if(para==false){ultimo=b;}else{ aumenta+=1;}
			}
			if(para==false){novoVal=novoValor+',00';}else{
			if(aumenta==2){novoValor = novoValor+'0';}
			novoVal=novoValor.substring(0,parseInt(ultimo)+3);
			}
			var resto = parseInt(ultimo)%3,divisao = parseInt(ultimo/3),pontos = 3;
			if(resto!=0 && divisao!=0){
				valFinal = novoVal.substring(0,resto)+'.'+novoVal.substring(resto);
				pontos = parseInt(pontos)+parseInt(resto)+1;
			}else{valFinal = novoVal;}
			for(var a=1;a<divisao;a++){
				valFinal = valFinal.substring(0,pontos)+'.'+valFinal.substring(pontos);
				pontos+=4;
			}		
			$('#'+qualVarejo).val(valFinal);
		}
		
		//FORMATAÇÃO BOTÃO AJUDA
		var timeAjudaOut = true;
		
		$("body").on('mouseover','.ico-ajuda',function(){		
		pairaAju = setTimeout(function(){
			$('.cx_txt_ajuda').show();
			timeAjudaOut=false;
			},350);		
		});
		
		$("body").on('mouseout','.ico-ajuda',function(){
		if(timeAjudaOut){
			clearTimeout(pairaAju);
			}else{
			$('.cx_txt_ajuda').hide();
			timeAjudaOut=true;
			}
		});
		
		
		//FUNÇÃO ADICIONAR MAIS INPUTS
		$('#troca_cadastros').on('click','#bt_mais_unid',function(){
			var contMarg=$(this).attr('class').split('|'),contAumenta=parseInt(contMarg[0]),margim=parseInt(contMarg[1]),maxAumenta=parseInt(contMarg[4]),contUni = parseInt($('.contUni').length)-1,pgAdd=$(this).children('a').attr('class');
			$('.d_aviso_erro').hide().children('p').html("");						
			if(contUni<maxAumenta){
				contUni++;
				if(contAumenta==contUni){
					$(this).css({'margin-bottom':margim+'px'});
					contAumenta+=parseInt(contMarg[2]);
					margim+=parseInt(contMarg[3]);
					$(this).attr('class',contAumenta+'|'+margim+'|'+contMarg[2]+'|'+contMarg[3]+'|'+maxAumenta);
				}
				if(pgAdd=="add_mesa"){				
			$('#add_mais_unid').append('<div class="d_alinha_form contUni"><span><label for="cd_unidades_array_'+contUni+'">unidade extra '+contUni+':</label></span> <input type="text" id="cd_unidades_array_'+contUni+'" class="for_unid" /><div class="d_aviso_erro" id="erro_cd_unidades_array_'+contUni+'"><div class="d_ponta-erro"></div><p></p></div><!--d_aviso_erro--></div>');
				}else if(pgAdd=="add_entrada"){
			$('#add_mais_unid').append('<div class="d_alinha_form contUni"><span><label for="cd_descEntrada_'+contUni+'">descrição entrada extra '+contUni+':</label></span><input type="text" id="cd_descEntrada_'+contUni+'" class="for_descEntrada" autocomplete="off" /><div class="d_aviso_erro" id="erro_cd_descEntrada_'+contUni+'"><div class="d_ponta-erro"></div><p></p></div><!--d_aviso_erro--></div><div class="d_alinha_form"><span><label for="cd_valEntrada_'+contUni+'">valor entrada extra '+contUni+':</label></span><input type="text" id="cd_valEntrada_'+contUni+'" class="for_valEntrada" value="0,00" autocomplete="off" /><div class="d_aviso_erro" id="erro_cd_valEntrada_'+contUni+'"><div class="d_ponta-erro"></div><p></p></div><!--d_aviso_erro--></div><div class="d_alinha_form"><span><label for="cd_consuEntrada_'+contUni+'">é consuma ?</label></span><select id="cd_consuEntrada_'+contUni+'" class="for_consuEntrada"><option value="">selecione</option><option value="1">SIM</option><option value="0">NÃO</option></select><div class="d_aviso_erro" id="erro_cd_consuEntrada_'+contUni+'"><div class="d_ponta-erro"></div><p></p></div><!--d_aviso_erro--></div>');
				}else if(pgAdd=="add_unidade"){
				$('#add_mais_unid').append('<div class="d_alinha_form contUni"><span><label for="cd_unidades_array_'+contUni+'">unidade extra '+contUni+':</label></span> <input type="text" id="cd_unidades_array_'+contUni+'" class="for_unid" /><div class="d_aviso_erro" id="erro_cd_unidades_array_'+contUni+'"><div class="d_ponta-erro"></div><p></p></div><!--d_aviso_erro--></div>');
				}else if(pgAdd=="add_marca"){
				$('#add_mais_unid').append('<div class="d_alinha_form contUni"><span><label for="cd_marcas_array_'+contUni+'">marca extra '+contUni+':</label></span> <input type="text" id="cd_marcas_array_'+contUni+'" class="for_unid" /><div class="d_aviso_erro" id="erro_cd_marcas_array_'+contUni+'"><div class="d_ponta-erro"></div><p></p></div><!--d_aviso_erro--></div>');
				}else if(pgAdd=="add_categoria"){
				$('#add_mais_unid').append('<div class="d_alinha_form contUni"><span><label for="cd_categorias_array_'+contUni+'">categoria extra '+contUni+':</label></span> <input type="text" id="cd_categorias_array_'+contUni+'" class="for_unid" /><div class="d_aviso_erro" id="erro_cd_categorias_array_'+contUni+'"><div class="d_ponta-erro"></div><p></p></div><!--d_aviso_erro--></div>');
				}else if(pgAdd=="add_fornecedor"){
				$('#add_mais_unid').append('<div class="d_alinha_form contUni"><span><label for="cd_fornecedores_array_'+contUni+'">fornecedor extra '+contUni+':</label></span> <input type="text" id="cd_fornecedores_array_'+contUni+'" class="for_fornecedor" /><div class="d_aviso_erro" id="erro_cd_fornecedores_array_'+contUni+'"><div class="d_ponta-erro"></div><p></p></div><!--d_aviso_erro--></div>');
				}
				if(contUni==maxAumenta){ $(this).children('a').css({'cursor':'default'});}
			}
		});
		
		//CADASTRAR ENTRADA
		$('#troca_cadastros').on('click','#envia_novaEntrada',function(){
			$('.d_aviso_erro').hide().children('p').html("");
			var descEntra=[],valEntra=[],consEntra=[],qualNum=[],contar = parseInt($('.contUni').length)-1;
			for(var i=0;i<=contar;i++){
				if($('#cd_descEntrada_'+i).val()!="" && $('#cd_valEntrada_'+i).val()!="" && $('#cd_consuEntrada_'+i).val()!=""){
					descEntra.push($('#cd_descEntrada_'+i).val());
					valEntra.push($('#cd_valEntrada_'+i).val().replace(/[.]/g,"").replace(",","."));
					consEntra.push($('#cd_consuEntrada_'+i).val());
					qualNum.push(i);
				}else if($('#cd_descEntrada_'+i).val()=="" && ($('#cd_consuEntrada_'+i).val()!="" || ($('#cd_valEntrada_'+i).val()!="" && $('#cd_valEntrada_'+i).val()!="0,00"))){
					$('#erro_cd_descEntrada_'+i+' p').html("Descrição está em branco !");
					$('#erro_cd_descEntrada_'+i).show();
					$('#cd_descEntrada_'+i).focus();
					return false;
				}else if(($('#cd_descEntrada_'+i).val()!="" || $('#cd_consuEntrada_'+i).val()!="") && $('#cd_valEntrada_'+i).val()==""){
					$('#erro_cd_valEntrada_'+i+' p').html("Valo de entrada está em branco !");
					$('#erro_cd_valEntrada_'+i).show();
					$('#cd_valEntrada_'+i).focus();
					return false;
				}else if(($('#cd_descEntrada_'+i).val()!="" || ($('#cd_valEntrada_'+i).val()!="" && $('#cd_valEntrada_'+i).val()!="0,00")) && $('#cd_consuEntrada_'+i).val()==""){
					$('#erro_cd_consuEntrada_'+i+' p').html("Por favor, selecione a consuma !");
					$('#erro_cd_consuEntrada_'+i).show();
					$('#cd_consuEntrada_'+i).focus();
					return false;
				}
			}
			
			if(descEntra=="" && valEntra=="" && consEntra==""){
			$('#erro_cd_descEntrada_0 p').html("Descrição está em branco !");
			$('#erro_cd_descEntrada_0').show();
			$('#cd_descEntrada_0').focus();
			}else{
			$('#carregador').show();
			$.post('_php/cadastrar_dados.php',{descEntrada:descEntra,valEntrada:valEntra,consuEntrada:consEntra,qualNum:qualNum},function(dados){
				$('#carregador').hide();
				var ret=dados.split('|'),msg=ret[0],diverro=ret[1];
				if(diverro!="erro"){
					if(diverro!=""){
						$('#erro_'+diverro+' p').html(msg);
						$('#erro_'+diverro).show();
						$("#"+diverro).focus();
					}else{
						$('#dentroOk').html(msg).fadeIn(150);
						setTimeout(function(){$('#dentroOk').fadeOut(200,function(){$('#dentroOk').html("");});},1500);
						$('#troca_cadastros').html('');
						$('#loadingOne').show();
						$.post('_include/cadastro_entrada.php',function(pagina){
							$('#loadingOne').hide();
							$('#troca_cadastros').html(pagina);
							$('#cd_descEntrada_0').focus();
						});						
					}
				}else{
					$('#alert-cima p').html(msg);
					$('#alert').show();
					$('#spanalert a').focus();
				}			
			});			
			}
			return false;
		});
		
		//CADASTRAR UNIDADES/MARCAS/CATEGORIAS/FORNECEDORES
		$('#troca_cadastros').on('click','#envia_array',function(){
			$('.d_aviso_erro').hide().children('p').html("");
			var qualTrocar = $(this).attr('class'),qualPegar = $('#pegar_array').val(),qualArray = [],qualNum=[],contar = parseInt($('.contUni').length)-1;
			for(var i=0;i<=contar;i++){
				if($('#cd_'+qualPegar+'_array_'+i).val()!=""){
					qualArray.push($('#cd_'+qualPegar+'_array_'+i).val());
					qualNum.push(i);
				}
			}
			if(qualArray==""){
			$('#erro_cd_'+qualPegar+'_array_0 p').html("Campo está em branco !");
			$('#erro_cd_'+qualPegar+'_array_0').show();
			$('#cd_'+qualPegar+'_array_0').focus();
			}else{
			$('#carregador').show();
			$.post('_php/cadastrar_dados.php',{cadastro:'array',qualArray:qualArray,qualNum:qualNum,tabArray:qualPegar,status:qualTrocar},function(dados){
				$('#carregador').hide();
				var ret=dados.split('|'),msg=ret[0],diverro=ret[1];
				if(diverro!="erro"){					
					if(diverro!=""){
						$('#erro_'+diverro+' p').html(msg);
						$('#erro_'+diverro).show();
						$("#"+diverro).focus();
					}else{
						$('#dentroOk').html(msg).fadeIn(150);
						setTimeout(function(){$('#dentroOk').fadeOut(200,function(){$('#dentroOk').html("");});},1500);
						var qualPagina=qualPegar,status="";						
						$('#troca_cadastros').html('');
						$('#loadingOne').show();
						$.post('_include/cadastro_'+qualPagina+'.php',{status:status},function(pagina){
							$('#loadingOne').hide();
							$('#troca_cadastros').html(pagina);
						});						
					}
				}else{
					$('#alert-cima p').html(msg);
					$('#alert').show();
					$('#spanalert a').focus();
				}
			});
			}
			return false;
		});
		
		//DELETE UNIDADES/MARCAS/CATEGORIAS/FORNECEDORES
		$('#troca_cadastros').on('click','#envia_busca_del',function(){
		buscaDel($(this).attr('class'),false);
		});
		
		$('#troca_cadastros').on('keyup','#busca_del',function(e){
			var tecla=(window.event)?event.keyCode:e.which;
			if((tecla<37 || tecla>40) && (tecla<33 || tecla>36) && (tecla<16 || tecla>18) && (tecla!=0 && tecla!=9 && tecla!=20 && tecla!=255)){
				buscaDel($('#envia_busca_del').attr('class'),false);
			}
		});
		
		$('#troca_cadastros').on('click','#sel_pg_del',function(){
			if($(this).attr('class')=="s_abre_select"){
			$(this).removeClass('s_abre_select').addClass('s_fecha_select');
			$('#select_del ul').show();
			}else{
			$(this).removeClass('s_fecha_select').addClass('s_abre_select');
			$('#select_del ul').hide();
			}
		});
		
		$('#troca_cadastros').on('click','#select_del ul li a',function(){			
		if(window.history.pushState){
		window.history.pushState(null,'Gerabar - Cadastros',$(this).attr('href'));
		$('#pagina').val($(this).html());
		$('#s_num_select').html($(this).html());
		$('#sel_pg_del').removeClass('s_fecha_select').addClass('s_abre_select');
		$('#select_del ul').hide();
		$('#lista_del').html('<li class="carregaBuscaDel"></li>');		
		buscaDel($('#envia_busca_del').attr('class'),$(this).html());
		return false;
		}
		});
		
		$('body').on('click','.s_excluir_del a',function(){		
		if($('#spansim a').attr('class')!="sim"){			
			$('#confirm-cima p').html('Tem certeza que deseja deletar ?');
			$('#spansim').addClass('s_excluir_del');
			$('#spansim a').attr('id',$(this).attr('class')).addClass('sim');
			$('#confirm').show();
			$('#spansim a').focus();
		}else{
		$('#confirm-cima p').html('');
		$('#confirm').hide();

		var idDel = $(this).attr('id'),eleDel = $('#envia_busca_del').attr('class'),
		quantElemento = parseInt($('#quantElemento').val())-1,
		pgs = Math.ceil(quantElemento/8);
		if(pgs>1){
			$('#quantElemento').val(quantElemento);
			if(pgs<$('#select_del ul li').length){
			$('#select_del ul li:last').remove();
			}
		}else{
		$('#select_del').hide();
		}
		
		if(pgs<$('#pagina').val()){
			if(window.history.pushState){
				var linkAba=(eleDel=="entradas")?'entrada':eleDel;
			window.history.pushState(null,'Gerabar - Cadastros',getUrl()+'cadastros.php?cad='+linkAba+'&delete=true&pg='+pgs);
			}
			$('#pagina').val(pgs);
			$('#s_num_select').html(pgs);
		}
		
		$('#spansim a').attr('id','').removeClass('sim');
		$('#spansim').removeClass('s_excluir_del');
		
		$('#i_select_tudo').prop("checked",false);
		$('#lista_del').html('<li class="carregaBuscaDel"></li>');
		$.post("_php/carrega-busca.php",{pagina:$('#pagina').val(),qualBusca:eleDel,delet:idDel},function(retorno){
			$('#lista_del').html(retorno);
			$('#busca_del').val('');
		});
		}
		return false;
		});
		
		$('#troca_cadastros').on('click','#i_select_tudo',function(){
			if(document.getElementById("i_select_tudo").checked==true){
			$(".check-del").prop("checked",true);
			}else{
			$(".check-del").prop("checked",false);
			}
		});
		
		$('body').on('click','#delete_array',function(){
		var arra = [],quanti = 0;
		for(var i=1; i<=$('#lista_del li').length; i++){
		if(document.getElementById('loop-'+i).checked == true){
		arra.push($('#loop-'+i).val());
		quanti++;
		}}
		
		if(arra==""){
		$('#alert-cima p').html('Você não selecionou nada para excluir !');
		$('#alert').show();
		$('#spanalert a').focus();
		}else{
			
			if($('#spansim').attr('class')!="sim"){
			$('#confirm-cima p').html('Tem certeza que deseja deletar ?');
			$('#spansim').addClass('sim');
			$('#spansim a').attr('id',$(this).attr('id'));
			$('#confirm').show();
			$('#spansim a').focus();			
		}else{
		$('#confirm-cima p').html('');
		$('#confirm').hide();
				
			var eleDel = $('#envia_busca_del').attr('class'),
			quantElemento = parseInt($('#quantElemento').val())-parseInt(quanti),
			pgs = Math.ceil(quantElemento/8);
			if(pgs>1){
				$('#quantElemento').val(quantElemento);
				if(pgs<$('#select_del ul li').length){
				$('#select_del ul li:last').remove();
				}
				
			}else{
			$('#select_del').hide();
			}
			
			if(pgs<$('#pagina').val()){
				if(window.history.pushState){
				var linkAba=(eleDel=="entradas")?'entrada':eleDel;
				window.history.pushState(null,'Gerabar - Cadastros',getUrl()+'cadastros.php?cad='+linkAba+'&delete=true&pg='+pgs);
				}
				$('#pagina').val(pgs);
				$('#s_num_select').html(pgs);
			}
			
			$('#spansim').removeClass('sim');
			$('#spansim a').attr('id','');
			
			$('#i_select_tudo').prop("checked",false);
			$('#lista_del').html('<li class="carregaBuscaDel"></li>');
			$.post("_php/carrega-busca.php",{pagina:$('#pagina').val(),qualBusca:eleDel,arraDel:arra},function(retorno){
				$('#lista_del').html(retorno);
				$('#busca_del').val('');
			});			
			}
		}
		});
		
		function buscaDel(qualBusca,pg){
			clearTimeout(pararBusca);
			if(pg==false){
				var busca = $('#busca_del').val().trim();
				if(busca.length>0){
				$('#see_search').hide();
				}else{
				$('#see_search').show();
				}
				var dados = {busca:busca,qualBusca:qualBusca,pagina:$('#pagina').val()};				
			}else{
				var dados = {pagina:pg,qualBusca:qualBusca};
			}
			$('#i_select_tudo').prop("checked",false);
			$('#lista_del').html('<li class="carregaBuscaDel"></li>');
			pararBusca=setTimeout(function(){
			$.post("_php/carrega-busca.php",dados,function(retorno){
				$('#lista_del').html(retorno);
			});
			},200);
		}
	});
	
$(function(){
    
    //JAVA PAGINA ADMIM
	$("#cont_tudo_index").on('click','.d_menu_relatorio a',function(){
        var cad = $(this).children('span').attr('class');
        if(window.history.pushState){
        if($(this).attr('class')=="menu_relAberto"){
        $('#rel_'+cad).slideUp();
        $(this).removeClass("menu_relAberto");
        window.history.pushState(null,'Gerabar - Início',getUrl()+"administracao.php");
        }else{
        $('.d_menu_relatorio a').removeClass('menu_relAberto');
        $(this).addClass('menu_relAberto');
        window.history.pushState(null,'Gerabar - '+cad,$(this).attr('href'));
        $('.d_tudo_relatorio').html('').hide();
        $('#carregador').show();
        $.post('_include/relatorio_'+cad+'.php',{inclui:cad},function(pagina){
        $('#carregador').hide();
        $('#rel_'+cad).html(pagina).slideDown();
        });
        }
        return false;
        }
	});
	
	$("body").on('click','.cima_zerar',function(){
	var qualPg=$('#pegarPgRel').attr('class');
	if($('#spansim a').attr('id')!="sim"){
		$(this).blur();
        var cxOutro=(qualPg=="caixas")?"fechados":"fechadas";
		$('#confirm-cima p').html('Tem certeza de que deseja zerar o relatório de '+qualPg+' '+cxOutro+' recentementes ?');
		$('#spansim a').attr('id','sim').addClass('cima_zerar');
		$('#spansim').addClass($(this).attr('id'));
		$('#confirm').show();
		$('#spansim a').focus();
		}else{
		$('#confirm-cima p').html('');
		$('#confirm').hide();
		$('#carregador').show();
		var qualRel=$('#spansim').attr('class');
		$.get("_php/carrega-listas.php",{rementeCmd:qualRel,qualPg:qualPg},function(retorno){
		$('#carregador').hide();
		var retu=retorno.split('|'),msg=retu[0],erro=retu[1];
		if(erro==""){
			$('#dentroOk').html("Relatório zerado com sucesso !").fadeIn(150);
			setTimeout(function(){$('#dentroOk').fadeOut(150,function(){$('#dentroOk').html("");});},800);
			if(qualRel=="zeraCmdRecente"){
			$('#count_cmd').html('0');
			$('#valo_cmd').html('<span>R$</span> 0,00');
               if(qualPg=="caixas"){
                   $('.valHM').html('<span>R$</span> 0,00');
               }
			}else{			
			$('.numHM').html('0');
			$('.valHM').html('<span>R$</span> 0,00');
			}
		}else{		
		$('#alert-cima p').html(msg);
		$('#alert').show();
		$('#spanalert a').focus();
		}			
		$('#spansim a').attr('id','').attr('class','');
		$('#spansim').attr('class','');
		});
		return false;
		}
	
	});
    
    $("#cont_tudo_index").on('click','#d_adm_aberta,#d_adm_fechada',function(){
        if(window.history.pushState){
        var qualPg=$('#pegarPgRel').attr("class"),abreFecha,cxStatus;
            if(qualPg=="caixas"){
            abreFecha="fechadas";
            cxStatus=($(this).attr('id')=="d_adm_aberta")?0:1;
            }else{
            abreFecha=($(this).attr('id')=="d_adm_aberta")?"abertas":"fechadas";
            cxStatus=false;
            }
            var passarCar=(qualPg=="contas" && abreFecha=="abertas")?false:true;
            if(passarCar==true){
                $('#carregador').show();
                window.history.pushState(null,'Administração',$(this).children('a').attr('href'));        
                $.post('_include/'+qualPg+'-'+abreFecha+'.php',{inclui:true,cxStatus:cxStatus},function(pagina){
                    $('#carregador').hide();
                    $("#cont_tudo_index").html(pagina);
                });
                return false;
            }
        }
        
    });
    
    
    $("#cont_tudo_index").on('click','.d_volta_admin',function(){
        if(window.history.pushState){
        $('#carregador').show();
        window.history.pushState(null,'Administração',$(this).children('a').attr('href'));
        var qualPg=$('#qualPgEsta').attr("class");
        $.post('_include/cont_admin.php',{voltaInclui:qualPg},function(pagina){
            $('#carregador').hide();
            $("#cont_tudo_index").html(pagina);
        });
        return false;
        }
        
    });
	
	//COMANDAS ABERTO/FECHADO DO CAIXA
	$('body').on('click','.li_acao_cmd a',function(){
		
		if($(this).children('span').attr('class')=="s_conta_mostrar"){
		$('.ul_mostra_comanda').hide();
		$('.li_acao_cmd a').html('mostrar <span class="s_conta_mostrar">conta</span>');
		$(this).html('esconder <span class="s_conta_esconder">conta</span>');
		$('#cmdVer-'+$(this).attr('class')).slideDown(300);		
		}else if($(this).children('span').attr('class')=="s_conta_esconder"){			
		$(this).html('mostrar <span class="s_conta_mostrar">conta</span>');
		$('#cmdVer-'+$(this).attr('class')).slideUp(300);
		}else if($(this).children('span').attr('class')=="s_caixa_mostrar"){
		$('.ul_mostra_comanda').hide();
		$('.li_acao_cmd a').html('mostrar <span class="s_caixa_mostrar">caixa</span>');
		$(this).html('esconder <span class="s_caixa_esconder">caixa</span>');
		$('#cmdVer-'+$(this).attr('class')).slideDown(300);		
		}else if($(this).children('span').attr('class')=="s_caixa_esconder"){			
		$(this).html('mostrar <span class="s_caixa_mostrar">caixa</span>');
		$('#cmdVer-'+$(this).attr('class')).slideUp(300);		
		}else if($(this).children('span').attr('class')=="s_venda_mostrar"){
		$('.ul_mostra_comanda').hide();
		$('.li_acao_cmd a').html('mostrar <span class="s_venda_mostrar">venda</span>');
		$(this).html('esconder <span class="s_venda_esconder">venda</span>');
		$('#cmdVer-'+$(this).attr('class')).slideDown(300);		
		}else if($(this).children('span').attr('class')=="s_venda_esconder"){			
		$(this).html('mostrar <span class="s_venda_mostrar">venda</span>');
		$('#cmdVer-'+$(this).attr('class')).slideUp(300);		
		}else if($(this).children('span').attr('class')=="s_cmd_mostrar"){
		$('.ul_mostra_comanda').hide();
		$('.li_acao_cmd a').html('mostrar <span class="s_cmd_mostrar">comanda</span>');
		$(this).html('esconder <span class="s_cmd_esconder">comanda</span>');
		$('#cmdVer-'+$(this).attr('class')).slideDown(300);		
		}else{
		$(this).html('mostrar <span class="s_cmd_mostrar">comanda</span>');
		$('#cmdVer-'+$(this).attr('class')).slideUp(300);
		}
	});
	
	//DELETAR COMANDA DO SISTEMA
	$('body').on('click','.li_acao_cmdFecha a',function(){
	var idConta=$(this).attr('class'),qualPg=$('#topo_cmd_abertaFechada').attr('class'),txtCompl,comanda;
	if($('#spansim a').attr('id')!="sim"){
		$(this).blur();
		if(qualPg=="pg_contaFecha"){
		txtCompl="essa conta";
		}else if(qualPg=="pg_mesaFecha"){
		txtCompl ="essa mesa";
		}else if(qualPg=="pg_vendaFecha"){
		txtCompl ="esse venda";
		}else if(qualPg=="pg_caixaFecha"){
		txtCompl ="esse caixa";
		}else{
		txtCompl ="a comanda "+$('#del_cmd_'+idConta).children('.li_comanda_cmd').html();
		}
		
		$('#confirm-cima p').html('Tem certeza que deseja deletar '+txtCompl+' ?');
		$('#spansim').addClass('li_acao_cmdFecha');
		$('#spansim a').attr('id','sim').addClass(idConta);
		$('#confirm').show();
		$('#spansim a').focus();
		}else{
		$('#confirm-cima p').html('');
		$('#confirm').hide();
        if(qualPg=="pg_mesaFecha"){
             comanda=$('#del_cmd_'+idConta).children('.li_nome_cmdFecha').children('span').html();
         }else if(qualPg=="pg_vendaFecha" || qualPg=="pg_caixaFecha"){
             comanda=0;
         }else{
             comanda=$('#del_cmd_'+idConta).children('.li_comanda_cmd').html();
         }
		$('#carregador').show();
		$.post("_php/alterar_cadastros.php",{idComanda:comanda,idCmdFechada:idConta,qualPgFecha:qualPg},function(retorno){
		var retu=retorno.split('|'),msg=retu[0],erro=retu[1];
		$('#carregador').hide();
		if(erro==""){
			if($('#ul_cmd_abertaFechada li.liFecha1').length>1){
				$('#del_cmd_'+idConta).remove();
			}else{
				$('#tudo_cmd_aberta').html("").hide();
				$('.tudo_cmd_vazio').show();
			}
			$('#dentroOk').html(msg).fadeIn(150);
			setTimeout(function(){$('#dentroOk').fadeOut(150,function(){$('#dentroOk').html("");});},800);
		}else{
		$('#alert-cima p').html(msg);
		$('#alert').show();
		$('#spanalert a').focus();
		}
		
		$('#spansim a').attr('id','').removeClass(idConta);
		$('#spansim').removeClass('li_acao_cmdFecha');
		
		});
		return false;
		}	
	});
	
	//JAVA COMANDAS EM ABERTO
	
	//JAVA SENHA MASTER E ACESSO
	$('#troca_cadastros').on('click','.alt_senha_admim',function(){
		var qualSenha=($(this).parents('div').attr('id')=="ad_cmd_senhaAcesso")?'acesso':'master';
		$('#carregador').show();
		$.get('_include/loading-interno.php',{altSenha:true,qualSenha:qualSenha,txtTopo:$(this).html()},function(data){
		$('#carregador').hide();
		$('#fundo_branco').html(data).fadeIn(150);
		$('#alt_senha_atual').focus();
		});
	});
	
	$('body').on('click','#tdAltSenha-baixo a',function(){
	$('#fundo_branco').fadeOut(200,function(){ $('#fundo_branco').html("");});
	});
	
	$('body').on('click','#envia_alt_senha',function(){
		$('.d_aviso_erro').hide().children('p').html("");
		var senhaAtual=$('#alt_senha_atual'),novaSenha=$('#alt_nova_senha'),repSenha=$('#alt_repetNova_senha');
		if(senhaAtual.val()==""){
		$('#erro_'+senhaAtual.attr('id')+' p').html("Senha atual está em branco !");
		$('#erro_'+senhaAtual.attr('id')).show();
		senhaAtual.focus();
		}else if(novaSenha.val()==""){
		$('#erro_'+novaSenha.attr('id')+' p').html("Nova senha está em branco !");
		$('#erro_'+novaSenha.attr('id')).show();
		novaSenha.focus();
		}else if(novaSenha.val().length<6){
		$('#erro_'+novaSenha.attr('id')+' p').html("Senha colocada é muito pequena !");
		$('#erro_'+novaSenha.attr('id')).show();
		novaSenha.focus();
		}else if(erS.test(novaSenha.val())==false){
		$('#erro_'+novaSenha.attr('id')+' p').html("Senha tem que conter letras e numéros !");
		$('#erro_'+novaSenha.attr('id')).show();
		novaSenha.focus();
		}else if(repSenha.val()==""){
		$('#erro_'+repSenha.attr('id')+' p').html("Por favor, repita sua senha !");
		$('#erro_'+repSenha.attr('id')).show();
		repSenha.focus();
		}else if(novaSenha.val()!=repSenha.val()){
		$('#erro_'+repSenha.attr('id')+' p').html("As duas senhas estão diferentes !");
		$('#erro_'+repSenha.attr('id')).show();
		repSenha.focus();
		}else{		
			$('#carregador').show();
			$.post("_php/alterar_cadastros.php",{senhaAtual:senhaAtual.val(),novaSenha:novaSenha.val(),repSenha:novaSenha.val(),qualSenha:senhaAtual.attr('class')},function(dados){
				$('#carregador').hide();
				var ret=dados.split('|'),msg=ret[0],diverro=ret[1];
				if(diverro!="erro"){
					if(diverro!=""){
						$('#erro_'+diverro+' p').html(msg);
						$('#erro_'+diverro).show();
						$("#"+diverro).focus();
					}else{
						$('#dentroOk').html(msg).fadeIn(150);
						setTimeout(function(){$('#dentroOk').fadeOut(200,function(){$('#dentroOk').html("");});},1500);
						$('#fundo_branco').fadeOut(200,function(){ $('#fundo_branco').html("");});
					}
				}else{
					$('#alert-cima p').html(msg);
					$('#alert').show();
					$('#spanalert a').focus();
				}			
			});
		}
		return false;
	
	});
    
    
    //PARTE PLANO CONTRATADO
    
    $('body').on('click','#a_cancelar_contrato',function(){
        
        if($('#spansim').attr('class')!="sim"){
			
			$('#confirm-cima p').html('Tem certeza que deseja cancelar seu contrato ?</br> Sentiremos sua falta :/');
			$('#spansim').addClass('sim');
			$(this).blur();
			$('#spansim a').attr('id',$(this).attr('id'));	
			$('#confirm').show();
			$('#spansim a').focus();
			
		}else{
            $('#confirm-cima p').html('');
            $('#confirm').hide();            
            $('#dentroCarrega').html("Processando...");
            $('#carregador').show();
            
            $.post("_php/carrega-pagamento.php",{cancelarPlano:true,pagSeguro:true},function(retorno){
            var ret=retorno.split('|'),msg=ret[0],erro=ret[1];
            $('#carregador').hide();
            $('#dentroCarrega').html("Carregando...");
                
            if(erro==""){
            $('#dentroOk').html("Plano Premim Cancelado !").fadeIn(150);
            setTimeout(function(){$('#dentroOk').fadeOut(200,function(){$('#dentroOk').html("");});},1500);
                
            $("#s_alt_status_plano").html("CANCELADO");
            $("#s_cancela_contrato").hide();
            $(".s_botao_conf_plano").show();
                
            }else{
                $('#alert-cima p').html(msg);
                $('#alert').show();
                $('#spanalert a').focus();
            }
            
            });
         
            $('#spansim').removeClass('sim');
            $('#spansim a').attr('id','');
            
		}
        
    });
    
	
});

//JAVA ESTOQUE/CLIENTE
	$(function(){	
	
	$('body').on('click','.deletarEstoque',function(){
		if($('#spansim').attr('class')!="sim"){
			
			$('#confirm-cima p').html('Tem certeza que deseja deletar o produto ?');
			$('#spansim').addClass('sim');
			$(this).blur();
			$('#spansim a').attr('id',$(this).parents('li').attr('class')).addClass($(this).attr('class'));	
			$('#confirm').show();
			$('#spansim a').focus();
			
		}else{
		$('#confirm-cima p').html('');
		$('#confirm').hide();
		deletaCliEsto($(this).attr('id'));		
		}		
		});
		
		$('body').on('click','#apagaTudo',function(){
		var deletar=[],quanti = 0;
		for(var i=1;i<=$('.sel-input li').length;i++){
			if(document.getElementById("lop-"+i).checked==true){
			deletar.push($('#lop-'+i).val());
			quanti++;
			}
		}
		if(deletar==""){
		$('#alert-cima p').html('Nada foi selecionado !');
		$('#alert').show();
		$('#spanalert a').focus();
		}else{
		
		if($('#spansim').attr('class')!="sim"){			
			$('#confirm-cima p').html('Tem certeza que deseja deletar ?');
			$('#spansim').addClass('sim');
			$('#spansim a').attr('id',$(this).attr('id')).addClass('nada');
			$('#confirm').show();
			$('#spansim a').focus();
			
		}else{
		$('#confirm-cima p').html('');
		$('#confirm').hide();			
		var quantElemento = parseInt($('#quantElemento').val())-parseInt(quanti),qualpg=$('#qualPg').val(),pgs = Math.ceil(quantElemento/12);
		
		if(pgs>1){
			$('#quantElemento').val(quantElemento);
			if(pgs<$('#select_produto ul li').length){
			$('#select_produto ul li:last').remove();
			}
		}else{
		$('#pgTudo').hide();
		}
		
		if(pgs<$('#pagina').val()){
			if(window.history.pushState){
			window.history.pushState(null,'Gerabar - Estoque',getUrl()+qualpg+'.php?pg='+pgs);
			}
			$('#pagina').val(pgs);
			$('#select_pg').html(pgs);
		}
		
		var menos=parseInt($('#pagina').val())-1, mais=parseInt($('#pagina').val())+1;
		if(menos==0){$('#d_pri').hide();}else{$('#d_pri').show();}
		if(menos<=1){$('#d_ante').hide();}else{$('#d_ante').show().children('a').attr('href',getUrl()+qualpg+'.php?pg='+menos);}
		if(mais>=pgs){$('#d_pro').hide();}else{$('#d_pro').show().children('a').attr('href',getUrl()+qualpg+'.php?pg='+mais);}
		if(mais>pgs){$('#d_ult').hide();}else{$('#d_ult').show().children('a').attr('href',getUrl()+qualpg+'.php?pg='+pgs);}
		
		$('#spansim').removeClass('sim');
		$('#spansim a').attr('id','').removeClass($(this).attr('class'));	
        $('.sel-input li').hide();
        $("#carregador").show();
		$.post("_php/carrega-busca.php",{deletar:deletar,pagina:$('#pagina').val(),qualPg:qualpg},function(retorno){
        var ret=retorno.split('|'),msg=ret[0],erro=ret[1];
        $("#carregador").hide();
        if(erro=="error"){
            $('#alert-cima p').html(msg);
			$('#alert').show();
			$('#spanalert a').focus();
            $('.sel-input li').show();
        }else{
            $('.sel-input').html(ret);
			$('#todos-check').prop("checked",false);
        }
            
		});
		}}		
		});
	
	//PG ALTERAÇÃO DE PRODUTOS	
	$('body').on('click','.atualiza_estoque',function(){
		$('.d_aviso_erro').hide().children('p').html("");
		var Qid=$(this).attr('id'),id=[],marca=[],descricao=[],unidade=[],categoria=[],fornecedor=[],quant=[],codInterno=[],valCompra=[],margem=[],valVarejo=[],valorVare=[],count,Qnum,Vnum;
		if(Qid=="enviaEdita_tudo"){
		count = $('#centro_fundo_preto li.conta-li').length;
        Qnum=0;
		}else{
		Vnum=$(this).attr('id').split("_");
        Qnum=Vnum[0];
        count=parseInt(Qnum)+1;
		}
		
	for(var i=Qnum; i<count; i++){
			var salMarca=$('#cd_produto_'+i+'_1_marca'),salDescricao=$('#cd_produto_'+i+'_2_descricao'),salUnidade=$('#cd_produto_'+i+'_3_unidade'),salCategoria=$('#cd_produto_'+i+'_4_categoria'),salFornece=$('#cd_produto_'+i+'_5_fornecedor'),salQuant=$('#cd_produto_'+i+'_6_qtd'),salCodInterno=$('#cd_produto_'+i+'_7_codInterno'),salValCompra=$('#cd_produto_'+i+'_8_valCompra'),salMargem=$('#cd_produto_'+i+'_8_valCompra-margem'),salValVarejo=$('#cd_produto_'+i+'_8_valCompra_valVarejo');
			if(salMarca.val().trim()==""){
			$('#erro_'+salMarca.attr('id')+' p').html('Marca está em branco !');
			$('#erro_'+salMarca.attr('id')).show();
			salMarca.focus();
			return false;
			}else if(salDescricao.val().trim()==""){
			$('#erro_'+salDescricao.attr('id')+' p').html('Descrição está em branco !');
			$('#erro_'+salDescricao.attr('id')).show();
			salDescricao.focus();
			return false;
			}else if(salUnidade.val().trim()==""){
			$('#erro_'+salUnidade.attr('id')+' p').html('Selecione uma unidade de venda !');
			$('#erro_'+salUnidade.attr('id')).show();
			salUnidade.focus();
			return false;
			}else if(salCategoria.val().trim()==""){
			$('#erro_'+salCategoria.attr('id')+' p').html('Categoria está em branco !');
			$('#erro_'+salCategoria.attr('id')).show();
			salCategoria.focus();
			return false;
			}else if(salFornece.val().trim()==""){
			$('#erro_'+salFornece.attr('id')+' p').html('Fornecedores está em branco !');
			$('#erro_'+salFornece.attr('id')).show();
			salFornece.focus();
			return false;
			}else if(salQuant.val().trim()==""){
			$('#erro_'+salQuant.attr('id')+' p').html('Quantidade está em branco !');
			$('#erro_'+salQuant.attr('id')).show();
			salQuant.focus();
			return false;
			}else if(isNaN(salQuant.val().trim())){
			$('#erro_'+salQuant.attr('id')+' p').html('Coloque apenas números !');
			$('#erro_'+salQuant.attr('id')).show();
			salQuant.focus();
			return false;
			}else if(salCodInterno.val().trim()==""){
			$('#erro_'+salCodInterno.attr('id')+' p').html('Código interno está em branco !');
			$('#erro_'+salCodInterno.attr('id')).show();
			salCodInterno.focus();
			return false;
			}else if(salValCompra.val().trim()=="" || salValCompra.val().trim()=="0,00"){
			$('#erro_'+salValCompra.attr('id')+' p').html('Valor de compra está em branco !');
			$('#erro_'+salValCompra.attr('id')).show();
			salValCompra.focus();
			return false;
			}else if(salMargem.val().trim()==""){
			$('#erro_'+salMargem.attr('id')+' p').html('Margem está em branco !');
			$('#erro_'+salMargem.attr('id')).show();
			salMargem.focus();
			return false;
			}else if(salValVarejo.val().trim()=="" || salValVarejo.val().trim()=="0,00"){
			$('#erro_'+salValVarejo.attr('id')+' p').html('Valor de venda está em branco !');
			$('#erro_'+salValVarejo.attr('id')).show();
			salValVarejo.focus();
			return false;
			}else{
				marca.push(salMarca.val());
				descricao.push(salDescricao.val());
				unidade.push(salUnidade.val());
				categoria.push(salCategoria.val());
				fornecedor.push(salFornece.val());
				quant.push(salQuant.val());
				codInterno.push(salCodInterno.val());
				valCompra.push(salValCompra.val().replace(/[.]/g,"").replace(",","."));
				margem.push(salMargem.val());
				valVarejo.push(salValVarejo.val().replace(/[.]/g,"").replace(",","."));
				id.push(salDescricao.parents('li').attr('id'));
				valorVare.push(salValVarejo.val());
			}
	}

	if(marca!='' && descricao!='' && unidade!='' && categoria!='' && fornecedor!='' && quant!='' && valCompra!='' && margem!='' && valVarejo!='' && id!=''){
		$('#carregador').show();
		$.post('_php/alterar_cadastros.php',{id:id,marca:marca,descricao:descricao,unidade:unidade,categoria:categoria,fornecedor:fornecedor,quant:quant,codInterno:codInterno,valCompra:valCompra,margem:margem,valVarejo:valVarejo,qualPg:$('#qualPg').val(),Qnum:Qnum,contar:count},function(retorno){
            $('#carregador').hide();
			var ret=retorno.split('|'),msg=ret[0],diverro=ret[1];
				if(diverro!="erro"){
					if(diverro!=""){
						$('#erro_'+diverro+' p').html(msg);
						$('#erro_'+diverro).show();
						$("#"+diverro).focus();
					}else{
						for(i=0; i<id.length; i++){
							$('#ul_linha_estoque li.'+id[i]+' div.alinha_estoque_1 p').html(codInterno[i]);
							$('#ul_linha_estoque li.'+id[i]+' div.alinha_estoque_2 p').html(marca[i]+' '+descricao[i]+' ('+unidade[i]+')');
							$('#ul_linha_estoque li.'+id[i]+' div.alinha_estoque_3 p').html(categoria[i]);
							$('#ul_linha_estoque li.'+id[i]+' div.alinha_estoque_4 p').html(quant[i]);
							$('#ul_linha_estoque li.'+id[i]+' div.alinha_estoque_5 p').html('r$ '+valorVare[i]);
						}
						$('#dentroOk').html(msg).fadeIn(150);
						setTimeout(function(){$('#dentroOk').fadeOut(200,function(){$('#dentroOk').html("");});},1500);
						if(Qid=="enviaEdita_tudo"){$('#fundo_preto').fadeOut(150,function(){$('#centro_fundo_preto').html('');});}						
					}					
				}else{
					$('#alert-cima p').html(msg);
					$('#alert').show();
					$('#spanalert a').focus();
				}			
			});		
	}else{
	$('#alert-cima p').html('Ocorreu um erro inesperado !');
	$('#alert').show();
	$('#spanalert a').focus();
	}
	return false;
	});
	
	});