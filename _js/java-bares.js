$(function(){	
		//CRIAR NOVA CONTA
		$('#cont_cadastros').on('click','#envia_nova_conta',function(){
			$('#ul_mostra_cliente').hide();		
			var busq = $('#val_nova_conta').val().trim();				
            if(busq.length>0){
			
			$.get('_php/carrega-busca-bares.php',{buscaCliente:busq,selTabela:'busca_clientes'},function(retorno){
				$('#ul_mostra_cliente').html(retorno).show();				
			});
			}else{
			$('#ul_mostra_cliente').html('');
			}
			return false;		
		});
		
		$('#cont_cadastros').on('mouseover','#ul_mostra_cliente li',function(){
			if($(this).attr('class')!="nadaCliente"){					
			$('#ul_mostra_cliente li').attr('id','');
			$(this).attr('id','ativo_conta_nome');
			}
		});
		
		$('#cont_cadastros').on('keyup','#val_nova_conta',function(e){
			var tecla=(window.event)?event.keyCode:e.which;
			
			if((tecla<33 || tecla>36) && (tecla<16 || tecla>18) && (tecla!=37 && tecla!=39 && tecla!=0 && tecla!=9 && tecla!=20 && tecla!=255)){
				clearTimeout(pararBusca);
				var busq = $(this).val().trim();
				if(busq.length>0){
					
					if(tecla==13){	
						if(window.history.pushState){
							if($('#ativo_conta_nome a').attr('class')!=undefined){
							var ret=$('#ativo_conta_nome a').attr('class').split("|"),idcliente=ret[0],nome=ret[1],hrefA=$('#ativo_conta_nome a').attr('href');							
							window.history.pushState(null,'Gerabar - Conta de Cliente',hrefA);
							$('.aba-caixa-bar li').removeClass('cadastro_ativo');
							$('#liAbaCtCli').addClass('cadastro_ativo');
							$('#carregador').show();
							$('#troca_cadastros').html('');
							$.post('_include/contas-produtos.php',{inclui:true,cod:idcliente,cliente:nome},function(retorno){
							$('#carregador').hide();
							$('#troca_cadastros').html(retorno);
							$('#i_nome_prod_contas').focus();				
							});
							}
						}else{
						return false;
						}
					}
				if((tecla==40 || tecla==38) && $('#ul_mostra_cliente li').attr('class')!="carrega_busca"){
					var active = -1,suggest = $('#ul_mostra_cliente li'),qnts = suggest.length;
					for(var i=0;i<qnts;i++){
						if(suggest.eq(i).attr('id')=="ativo_conta_nome"){
						active = i;
						}
					}
					if(tecla==38){
						if(active>0){
							active-=1;
						}else{
							active=(qnts-1);
						}
					}else if(tecla==40){
						if(active<(qnts-1)){
							active+=1;
						}else{
							active=0;
						}
					}
					if(active != -1 && qnts>0){
					suggest.attr('id','');
					if(suggest.eq(active).attr('class')!="nadaCliente"){
						suggest.eq(active).attr('id','ativo_conta_nome');
					}
					}					
				}else{
				$('#ul_mostra_cliente').html('<li class="carrega_busca"></li>').show();
				pararBusca=setTimeout(function(){
				$.get('_php/carrega-busca-bares.php',{buscaCliente:busq,selTabela:'busca_clientes'},function(retorno){
					$('#ul_mostra_cliente').html(retorno);
				});
				},200);
				}				
				}else{
				$('#ul_mostra_cliente').html('').hide();
				}
			}		
		});
		
		$('body').on('click','.s_acrescenta_conta a',function(){			
		
			if(window.history.pushState){
				var ret=$(this).attr('class').split("|"),idcliente=ret[0],nome=ret[1],hrefA=$(this).attr('href');
				if($(this).parents('li').attr('class')=='li_cliente_busc'){				
				if($('#qualPaginaAtivo').html()!='contas-clientes'){	
				window.location.href=hrefA;
				return false;
				}
				$('#busca_do_topo').html('').hide();
				$('#i_busca_txt_tudo').val("");
				}
				window.history.pushState(null,'Gerabar - Conta de Cliente',hrefA);
				$('.aba-caixa-bar li').removeClass('cadastro_ativo');
				$('#liAbaCtCli').addClass('cadastro_ativo');
				$('#carregador').show();
				$('#troca_cadastros').html('');
				
				$.post('_include/contas-produtos.php',{inclui:true,cod:idcliente,cliente:nome},function(retorno){
				$('#carregador').hide();
				$('#troca_cadastros').html(retorno);
				$('#i_nome_prod_contas').focus();				
				});
				return false;
			}		
		});
		
		$('#cont_cadastros').on('click','#linkVoltar a',function(){
		if(window.history.pushState){
		$('.aba-caixa-bar li').removeClass('cadastro_ativo');
		$('#liAbaNoCli').addClass('cadastro_ativo');
		window.history.pushState(null,'Gerabar - Contas de clientes',$(this).attr('href'));
		$('#troca_cadastros').html('');
		$('#loadingOne').show();
		$.post('_include/novas-contas.php',{inclui:true},function(pagina){
			$('#loadingOne').hide();
			$('#troca_cadastros').html(pagina);			
				$('#val_nova_conta').focus();
		});
		return false;
		}
		});
		
		$('#cont_cadastros').on('click','#dentro2-h2 a',function(){			
			if(window.history.pushState){
				var idcliente=$('#d_cadastro_produto').attr('class'),nomeCliente=$('#s_nome_do_cliente').attr('class'),hrefA=$(this).attr('href'),novaHref='contas-clientes.php?cad=contas-abertas&cliente='+nomeCliente+'&cod='+idcliente,agrupa;
				$('#carregador').show();
				if($(this).html()=="desagrupar"){
				agrupa = "sim";
				$(this).attr('href',novaHref).html("agrupar");
				}else{
                agrupa="nao";
				$(this).attr('href',novaHref+'&desagrupa=sim').html("desagrupar");
				}
				window.history.pushState(null,'Gerabar - Conta de Cliente',hrefA);
				$('.li-inner').remove();
                $('.inner-desconta').remove();
                $('.inner-desc').remove();
				$.get('_php/carrega-busca-bares.php',{carConta:true,idCliente:idcliente,agrupa:agrupa},function(retorno){
					$('#carregador').hide();
					if(retorno!=""){
					$('li.inner').before(retorno);
					var valForm=$('.inp_val_total').attr('id').split('-');
					$('#car_val_total').html($('.inp_val_total').val()).attr('class',valForm[0]);
					}else{
					$('#car_val_total').attr('class',0).html('0,00');
					}
					$('#i_nome_prod_contas').val("").focus();
					$('#i_cod_func').val("");
					if($('#s_mostraCampo').attr('class')=='mostraDisverso'){
						$('#s_escondeCampoVal').show();
						$('#s_mostraCampo').removeClass('mostraDisverso');
						$('#i_val_diverso').val('0,00');
					}else{
					$('#s_mostraVal').html("0,00");
					}
					$('#novaQuantProd').val('0');
					$('.valAltera').html('0,00');
					$('.i_id_prod').val('0');
					$('.i_valor_prod').val("").attr("id","");
					$('.i_quant_prod').val("0");
				});
				return false;
			}
		});
		
		$('#confirm').on('keyup','#i_quant_confirm',function(e){
			var tecla=(window.event)?event.keyCode:e.which,Quant=($(this).val()=="")?0:parseInt($(this).val()),quantPaga = parseInt($('#'+$(this).attr('class')+'-li').children('.d_quant_contas').children('.quantParaPagar').html()),valorAltera=$('#'+$(this).attr('class')+'-li').children('.d_val_contas').children('.valParaPagar').html().replace(/[.]/g,"").replace(",",".");
			if((tecla<33 || tecla>36) && (tecla<16 || tecla>18) && (tecla!=37 && tecla!=39 && tecla!=0 && tecla!=9 && tecla!=20 && tecla!=255)){				
			if(tecla==38){
				Quant=(Quant<quantPaga)?Quant+1:quantPaga;
			}else if(tecla==40){
				if(Quant<=quantPaga){
					Quant=(Quant>0)?Quant-1:Quant;
				}else{
					Quant=quantPaga;
				}
			}
				$(this).val(Quant);
				$('#s_valor_confirm').html(number_format(parseFloat(valorAltera)*Quant,2,',','.'));
			}
		});
		
		$('body').on('click','.s_paga_conta a',function(){
		$('.d_aviso_erro').hide().children('p').html("");
		if($('#spansim a').attr('class')!="sim"){			
			$(this).blur();
			var rett=$(this).parents('li.li-inner').attr('id').split("-"),idConta=rett[0],
			quantParaPaga=$('#'+idConta+'-li').children('.d_quant_contas').children('.quantParaPagar').html(),
			valParaPaga=$('#'+idConta+'-li').children('.d_valtotal_contas').children('.valProdConta').html();
			
			$('#confirm-cima').html('<p class="p_confDentro">Quantas(os) <span style="text-transform:uppercase; font-weight:bold;">'+$('#'+idConta+'-li').children('.d_produto_contas').html()+'</span> deseja pagar ?</p> <p class="p_confDentro formPpaga"><input id="i_quant_confirm" class="'+idConta+'" type="text" value="'+quantParaPaga+'" onKeyPress="return SomenteNumero(event);" maxlength="11" autocomplete="off" /><div class="d_aviso_erro" id="erro_i_quant_confirm" style="margin:31px 0 0 10px;"><div class="d_ponta-erro"></div><p></p></div><!--d_aviso_erro--></p> <p class="p_confDentro formPpaga"> no valor de <strong>R$ <span id="s_valor_confirm">'+valParaPaga+'</span></strong></p>');
			$('#spansim').addClass('s_paga_conta');
			$('#confirm').show();
			$('#spansim a').addClass('sim');
			$('#i_quant_confirm').focus();
		}else{
			var quantPaga=$("#i_quant_confirm"),quantTotal = parseInt($('#'+quantPaga.attr('class')+'-li').children('.d_quant_contas').children('.quantParaPagar').html()),valPaga=$('#s_valor_confirm').html();
						
			if(quantPaga.val()=="" || quantPaga.val()=="0"){
			$('#erro_i_quant_confirm p').html("Coloque a quantidade a ser pago !");
			$('#erro_i_quant_confirm').show();
			quantPaga.focus();
			}else if(isNaN(quantPaga.val())){
			$('#erro_i_quant_confirm p').html("Coloque apenas números !");
			$('#erro_i_quant_confirm').show();
			quantPaga.focus();
			}else if(parseInt(quantPaga.val())>quantTotal){
			$('#erro_i_quant_confirm p').html("Não tem essa quantidade para ser pago !");
			$('#erro_i_quant_confirm').show();
			quantPaga.focus();
			}else{		
			$('#confirm').hide();
			$('#confirm-cima').html('<p></p>');
			$('#spansim a').removeClass('sim');
			$('#spansim').removeClass('s_paga_conta');
				$('#carregador').show();
				$.post('_include/loading-interno.php',{pagarCmd:true,totalCmd:valPaga,idCliente:$('#d_cadastro_produto').attr('class'),quant:quantPaga.val(),idPago:quantPaga.attr('class')},function(data){
				$('#carregador').hide();
				$('#fundo_branco').html(data).fadeIn(150);
				});
			}
		}
		});
		
		$('body').on('click','.s_fecha_conta a',function(){			
            var idcliente,idconta,valor;
			if($(this).parents('span').attr('id')=="pagarContaTotal"){
				idcliente=$('#d_cadastro_produto').attr('class');
                idconta=$('.idContaCliente').val();
                valor=$('#car_val_total').html();
			}else{
                idcliente=$(this).parents('li').attr('class');
                idconta=$(this).parents('li').children('.separa_conta_0').children('.numContaCli').html();
                valor=$(this).parents('li').children('.separa_conta_2').children('.valTotalContaCli').html();			
			}
            finaliza_conta(idcliente,idconta,valor);		  
            return false;
		});
		
		//PARTE DELETA CONTA		
			$('body').on('click','.s_delete_conta a',function(){
				$('#carregador').show();
				$.post('_include/loading-interno.php',{senhaMaster:true,classMaster:$(this).parents('li').attr('id')},function(data){
				$('#carregador').hide();
				$('#fundo_branco').html(data).fadeIn(150);
				$('#envia_senha_master').addClass('delContaCliMaster');
				$('#senha_master').focus();
				});
			});
		
		$('body').on('click','.delContaCliMaster',function(){
		$('.d_aviso_erro').hide().children('p').html("");	
		var senhaMaster=$('#senha_master');
		if(senhaMaster.val()==""){
		$('#erro_senha_master p').html("Senha master está em branco !");
		$('#erro_senha_master').show();
		senhaMaster.focus();
		}else{
			$('#carregador').show();
			$.post('_php/carrega-listas.php',{senhaMaster:senhaMaster.val()},function(dado){
			var ret=dado.split('|'),msg=ret[0],diverro=ret[1];
			if(diverro!="erro"){
				if(diverro!=""){
					$('#erro_'+diverro+' p').html(msg);
					$('#erro_'+diverro).show();
					$("#"+diverro).focus();
					$('#carregador').hide();
				}else{
					var rete=senhaMaster.attr('class').split("-"),idConta=rete[0],qualIdVai=$('#'+idConta+'-'+rete[1]),
					quant=qualIdVai.children('.d_quant_contas').children('.quantParaPagar').html(),idProd=(rete[1]=="liDesc")?'0':qualIdVai.children('.idProd').val();
					$.post("_php/alterar_cadastros.php",{idRemove:idConta,quant:quant,idProd:idProd,idDesconto:rete[1]},function(retorno){
					$('#carregador').hide();
					var retu=retorno.split("|"),msgs=retu[0],error=retu[1];
					if(error=="erro"){
						$('#alert-cima p').html(msgs);
						$('#alert').show();
						$('#spanalert a').focus();
					}else{
					var novoVal = parseFloat($('#car_val_total').attr('class'))-parseFloat(qualIdVai.children('.d_valtotal_contas').children('.valProdConta').html().replace(/[.]/g,"").replace(",","."));
					$('#car_val_total').attr('class',novoVal).html(number_format(novoVal,2,',','.'));
					qualIdVai.remove();
					if($('.inner-desconta').html()===undefined && $('.inner-desc').html()!=undefined){
					$('.inner-desc').eq(0).attr('class','inner-desconta');
					}
					if($('li.li-inner').length==0){
						$('#pagarContaTotal').hide();
						$('#descontarCx').hide();
					}
                    $('#fundo_branco').fadeOut(200,function(){ $('#fundo_branco').html("");});                                
                        if(rete[1]=="liDesc" && retu[2]!=0){
                        var formaPago=retu[2],valPago=retu[3],dinheiroCartao=(formaPago==1)?'em dinheiro':'no cartão';
                            $('#confirm-cima p').html('Remover desconto de R$ <span class="'+formaPago+'|'+valPago+'">'+number_format(valPago,2,',','.')+'</span> '+dinheiroCartao+' do caixa atual ?');
                            $('#spansim').addClass('s_descontoCx');
                            $('#confirm').show();
                            $('#spansim a').focus();                                
                        }else{                            
                        $('#dentroOk').html("Excluído da conta com sucesso !").fadeIn(150);
                        setTimeout(function(){$('#dentroOk').fadeOut(150,function(){$('#dentroOk').html("");});},800);
                        }
					}					
					});
				}
			}else{			
			$('#alert-cima p').html(msg);
			$('#alert').show();
			$('#spanalert a').focus();
			$('#carregador').hide();
			}
			});
		}		
		return false;
		});
		
		$('#cont_cadastros').on('click','#submenu_prod_conta li',function(){
		$('#i_nome_prod_contas').val($(this).children('span').html()).focus();
		
		var ret=$(this).children('span').attr('class').split("|"),idProd=ret[0],valForProd=ret[1],valProd=ret[2],quantProd=ret[3];
		$('.i_id_prod').val(idProd);
		$('.i_valor_prod').val(valForProd).attr('id',valProd);
		$('.i_quant_prod').val(quantProd);
		$('#s_mostraVal').html(valForProd);
		$('#submenu_prod_conta').removeClass('emcima').html('').hide();
		});
		
		$('#cont_cadastros').on('keyup','#i_val_diverso',function(e){
		$('.d_aviso_erro').hide().children('p').html("");
		var tecla=(window.event)?event.keyCode:e.which,valForm=$(this).val().replace(/[.]/g,"").replace(",","."),campoQuant=$('#novaQuantProd'),result,valorCompra;
		if(campoQuant.val()!=""){$('.valAltera').html(number_format(parseFloat(valForm)*parseInt(campoQuant.val()),2,',','.'));}
		$('.i_valor_prod').val($(this).val()).attr('id',valForm);
        result = parseFloat(valForm)/100;
			valorCompra = parseFloat(valForm)-(50*result);
            $('.i_valor_compra_prod').val(valorCompra);
		if(tecla==13){
			if($('#i_val_diverso').val()=="0,00"){
				$("#erro_i_val_diverso p").html("Coloque um valor para esse produto !");
				$("#erro_i_val_diverso").show();
				$("#i_val_diverso").focus();
				}else{
			if(campoQuant.val()=="" || campoQuant.val()=="0"){
			campoQuant.val('1').addClass("firstQuantCliente");
			$('.valAltera').html($(this).val());
			}
			campoQuant.focus();
			}
		}
		});
		
		$('#cont_cadastros').on('blur','#i_nome_prod_contas',function(){
			var busq = $('#i_nome_prod_contas').val().trim();
			if($('#submenu_prod_conta').attr('class')!="emcima" && busq.length!=0){
				$('#submenu_prod_conta').html('').hide();
				if($('.i_id_prod').val()=="0"){
					$('#s_escondeCampoVal').hide();
					$('#s_mostraCampo').addClass('mostraDisverso');
				}
			}
		});
		
		$('#cont_cadastros').on('mouseover','#submenu_prod_conta li',function(){
		if($(this).attr('class')!="carrega_busca"){
			$('#submenu_prod_conta li.conta_ativo').removeClass('conta_ativo');
			$(this).addClass('conta_ativo');			
			$('#submenu_prod_conta').addClass('emcima');
		}
		});		
				
		$('#cont_cadastros').on('mouseout','#submenu_prod_conta li',function(){
			$('#submenu_prod_conta li.conta_ativo').removeClass('conta_ativo');
			if($('.i_id_prod').val()!="0"){
				var suggest = $('#submenu_prod_conta li'),qnts = suggest.length;
				for(var i=0;i<qnts;i++){
					if(suggest.eq(i).children('span').html()==$('#i_nome_prod_contas').val()){
					suggest.eq(i).attr('class','conta_ativo');
					i=qnts;
					}
				}
			}
			$('#submenu_prod_conta').removeClass('emcima');
		});
		
		$('#cont_cadastros').on('keyup','#i_nome_prod_contas',function(e){
			$('.d_aviso_erro').hide().children('p').html("");
			var tecla=(window.event)?event.keyCode:e.which;
			if($('#s_mostraCampo').attr('class')=='mostraDisverso'){
					$('#s_escondeCampoVal').show();
					$('#s_mostraCampo').removeClass('mostraDisverso');
					$('#i_val_diverso').val('0,00');
			}
					
			if((tecla<33 || tecla>36) && (tecla<16 || tecla>18) && (tecla!=37 && tecla!=39 && tecla!=0 && tecla!=9 && tecla!=20 && tecla!=255)){
			clearTimeout(pararBusca);
            var busq = $(this).val().trim();
			if(tecla==13){
				if(busq.length==0){
					$('#erro_i_nome_prod_contas p').html('Coloque o nome ou código interno do produto !');
					$('#erro_i_nome_prod_contas').show();
				}else{
					$('#submenu_prod_conta').html('').hide();
					if($('.i_id_prod').val()=="0"){
					$('#s_escondeCampoVal').hide();
					$('#s_mostraCampo').addClass('mostraDisverso');
					}else{
					$('.valAltera').html($('#s_mostraVal').html());
					$('#novaQuantProd').val("1").addClass("firstQuantCliente");
					}
					$('#i_cod_func').focus();
				}				
				return false;
			}
			
			if($('#s_mostraVal').html()!="0,00"){
			$('#s_mostraVal').html("0,00");
			}
			if($('#novaQuantProd').val()!="0"){
			$('#novaQuantProd').val("0").remove("firstQuantCliente");
			}
            
			if($('#i_cod_func').val()!="" && $('#i_cod_func').attr("class")!="firstQuant"){
			$('#i_cod_func').val("");
			}
			
			if(busq.length>=1){
			if($('#submenu_prod_conta').attr('class')=='emcima' && tecla!=13){$('#submenu_prod_conta').removeClass('emcima');}
				if((tecla==40 || tecla==38) && $('#submenu_prod_conta li').attr('class')!="carrega_busca"){
					var active = -1,suggest = $('#submenu_prod_conta li'),qnts = suggest.length;
					for(var i=0;i<qnts;i++){
						if(suggest.eq(i).attr('class')=="conta_ativo"){
						active = i;
						}
					}
					if(tecla==38){
						if(active>0){
							active-=1;
						}else{active=(qnts-1);}
					}else if(tecla==40){
						if(active<(qnts-1)){
							active+=1;
						}else{
							active=0;
						}
					}
					if(active != -1 && qnts>0){
					suggest.removeClass('conta_ativo');
					suggest.eq(active).addClass('conta_ativo');
					$(this).val(suggest.eq(active).children('span').html());
					var ret=suggest.eq(active).children('span').attr('class').split('|'),idProd=ret[0],valForProd=ret[1],valProd=ret[2],quantProd=ret[3],valCompra=ret[4];
					$('.i_id_prod').val(idProd);
					$('.i_valor_prod').val(valForProd).attr('id',valProd);
					$('.i_valor_compra_prod').val(valCompra);
					$('.i_quant_prod').val(quantProd);
					$('#s_mostraVal').html(valForProd);
					}
					
				}else{
					$('#submenu_prod_conta').html('<li class="carrega_busca"></li>').show();
					pararBusca=setTimeout(function(){
					$.get('_php/carrega-busca.php',{qualCarrega:'conta_produtos',busca:busq},function(retorno){
					$('.i_id_prod').val("0");
					$('.i_valor_prod').val("0,00").attr('id',"0.00");
                    $('.i_valor_compra_prod').val("0.00");
					$('.i_quant_prod').val("0");
					$('.valAltera').html("0,00");
					$('#i_val_diverso').val("0,00");
					if(retorno!=""){
					$('#submenu_prod_conta').html(retorno);
					}else{
					$('#submenu_prod_conta').html('').hide();
					}
					});
					},200);
				}
			}else{
				$('#submenu_prod_conta').hide();
			}
			}
		
		});
		
		$('#cont_cadastros').on('keyup','#i_cod_func',function(e){
		$('.d_aviso_erro').hide().children('p').html("");
		var tecla=(window.event)?event.keyCode:e.which;
		if(tecla==13){
			var busq = $('#i_nome_prod_contas').val().trim();				
				if(busq.length==0){
				$("#erro_i_nome_prod_contas p").html("Coloque o nome ou código interno do produto !");
				$("#erro_i_nome_prod_contas").show();
				$("#i_nome_prod_contas").focus();
				}else if($(this).val()==""){
				$("#erro_"+$(this).attr('id')+" p").html("Coloque seu código de funcionário !");
				$("#erro_"+$(this).attr('id')).show();
				}else{
                    
					if($('#s_mostraCampo').attr('class')=="mostraDisverso"){
					$('#i_val_diverso').focus();
					}else{
					$('#novaQuantProd').focus();
					}
				}
		}
		
		});
		
		$('#cont_cadastros').on('keypress','input.firstQuantCliente',function(e){
		var tecla=(window.event)?event.keyCode:e.which;
		if(tecla>47 && tecla<58){
		if($(this).val()=="0" || $(this).val()=="1"){$(this).val('');}
		$(this).removeClass('firstQuantCliente');
		}		
		});
				
		$('#cont_cadastros').on('keyup','#novaQuantProd',function(e){
		$('.d_aviso_erro').hide().children('p').html("");
		var tecla=(window.event)?event.keyCode:e.which,qualQuant=$(this),Quant=(qualQuant.val()=="")?0:parseInt(qualQuant.val()),campoAltera=$('.valAltera'),campoAltera2=$('.i_valor_prod').attr('id'),quantTotal=parseInt($('.i_quant_prod').val());
			if((tecla<33 || tecla>36) && (tecla<16 || tecla>18) && (tecla!=37 && tecla!=39 && tecla!=0 && tecla!=9 && tecla!=20 && tecla!=255)){
			if(tecla==13){
				enviaContaCliente(qualQuant);
			}else if(tecla==38){
				Quant=(Quant<quantTotal || ($('#s_mostraCampo').attr('class')=="mostraDisverso" && $('#i_val_diverso').val()!="0,00"))?Quant+1:quantTotal;
				
			}else if(tecla==40){
				if(Quant<=quantTotal || ($('#s_mostraCampo').attr('class')=="mostraDisverso" && $('#i_val_diverso').val()!="0,00")){
					Quant=(Quant>0)?Quant-1:Quant;
				}else{
					Quant=quantTotal;					
				}
			}
				$(this).val(Quant);
				campoAltera.html(number_format(parseFloat(campoAltera2)*(Quant),2,',','.'));
			}
		});
		
		$('#cont_cadastros').on('click','#lanca_prd_conta',function(){
			enviaContaCliente($('#novaQuantProd'));
		});
		
		//CADASTRA CLIENTE CONTA
		$('#cont_cadastros').on('click','.cadClienteConta',function(){
		if(window.history.pushState){
		$('#liMais').hide();
		$('.aba-caixa-bar li').removeClass('cadastro_ativo');
		$('#liClienteConta').show().addClass('cadastro_ativo');
		menuCaixa();
		$('#div_busca_conta').hide();
		window.history.pushState(null,'Gerabar - Contas de clientes',$(this).attr('href'));
		$('#troca_cadastros').html('');
		$('#loadingOne').show();
		$.post('_include/cadastro-clientes.php',{inclui:true},function(pagina){
			$('#loadingOne').hide();
			$('#troca_cadastros').html(pagina);
			$('#cd_cliente_nome').focus();
		});
		return false;
		}
		});		
		
		function enviaContaCliente(qualQuant){
		var busq = $('#i_nome_prod_contas').val().trim();
				if(busq.length==0){
				$("#erro_i_nome_prod_contas p").html("Coloque o nome ou código interno do produto !");
				$("#erro_i_nome_prod_contas").show();
				$("#i_nome_prod_contas").focus();
				}else if($('#i_cod_func').val()==""){
				$("#erro_i_cod_func p").html("Coloque seu código de funcionário !");
				$("#erro_i_cod_func").show();
				$("#i_cod_func").focus();
				}else if(isNaN($('#i_cod_func').val())){
				$("#erro_i_cod_func p").html("Coloque apenas números !");
				$("#erro_i_cod_func").show();
				$("#i_cod_func").focus();
				}else if($('#s_mostraCampo').attr('class')=="mostraDisverso" && $('#i_val_diverso').val()=="0,00"){
				$("#erro_i_val_diverso p").html("Coloque um valor para esse produto !");
				$("#erro_i_val_diverso").show();
				$("#i_val_diverso").focus();
				}else if(qualQuant.val()=="" || qualQuant.val()==0){
				$("#erro_"+qualQuant.attr('id')+" p").html("Quantidade em branco ou igual a 0 !");
				$("#erro_"+qualQuant.attr('id')).show();
				qualQuant.focus();
				}else if(isNaN(qualQuant.val())){
				$("#erro_"+qualQuant.attr('id')+" p").html("Coloque apenas números !");
				$("#erro_"+qualQuant.attr('id')).show();
				qualQuant.focus();
				}else if((parseInt(qualQuant.val())>parseInt($('.i_quant_prod').val())) && $('#s_mostraCampo').attr('class')!="mostraDisverso"){
				$("#erro_"+qualQuant.attr('id')+" p").html("A quantidade máxima para esse produto é de "+$('.i_quant_prod').val()+" !");
				$("#erro_"+qualQuant.attr('id')).show();
				qualQuant.focus();
				}else{
				$('#carregador').show();
				$('.travaInput').attr('disabled',true);
				$.post('_php/carrega-busca-bares.php',{setContaCliente:true,idCliente:$('#d_cadastro_produto').attr('class'),idProduto:$('.i_id_prod').val(),quantidade:qualQuant.val(),valor:$('.i_valor_prod').attr('id'),valorCompra:$('.i_valor_compra_prod').val(),nomeProduto:busq,codFunc:$('#i_cod_func').val()},function(retorno){
				$('#carregador').hide();
				var ret=retorno.split('|'),msg=ret[0],diverro=ret[1];
				$('.travaInput').attr('disabled',false);
				if(diverro!=""){			
					if(diverro=="erro"){
						$('#alert-cima p').html(msg);
						$('#alert').show();
						$('#spanalert a').focus();
					}else{
					$('#erro_'+diverro+' p').html(msg);
						$('#erro_'+diverro).show();
						$("#"+diverro).focus();
					}			
				}else{
                    
					var nomeProd=($('.i_id_prod').val()==0)?$('#i_nome_prod_contas').val()+' (diversos)':$('#i_nome_prod_contas').val(),ValQuant=parseInt(qualQuant.val())*parseFloat($('.i_valor_prod').attr('id')),idContaCliente='';					
					if(nomeProd.length>40){ nomeProd=nomeProd.substring(0,40)+'...'; }
					if($('li.li-inner').length==0){
					idContaCliente='<input type="hidden" class="idContaCliente" value="'+ret[3]+'" />';
					$('#pagarContaTotal').show();
					$('#descontarCx').show();
					}					
			var beforeInner=($('.inner-desconta').html()===undefined)?$('li.inner'):$('.inner-desconta');
			beforeInner.before('<li class="li-inner" id="'+msg+'-li"><input type="hidden" class="idProd" value="'+$('.i_id_prod').val()+'" />'+idContaCliente+'<div class="d_produto_contas marginTopConta">'+nomeProd+'</div><div class="d_func_contas d_mostra_garcon"><span class="s_li_abreFecha_respansivo">nº func.:&nbsp;</span> <span class="pega_mostra_garcon">'+$('#i_cod_func').val()+'</span><div class="mostra_garcon loading-garcon"><div class="ponta-info-func"></div><div class="cont-garcon"></div></div></div><div class="d_val_contas"><span class="s_li_abreFecha_respansivo">valor unit.:&nbsp;</span> R$ <span class="valParaPagar">'+$('.i_valor_prod').val()+'</span></div><div class="d_quant_contas"><span class="s_li_abreFecha_respansivo">quant.:&nbsp;</span> <span class="quantParaPagar">'+qualQuant.val()+'</span></div><div class="d_valtotal_contas"><span class="s_li_abreFecha_respansivo">valor total:&nbsp;</span> R$ <span class="valProdConta">'+number_format(ValQuant,2,',','.')+'</span></div><div class="d_data_contas">'+ret[2]+'</div><div class="d_acao_contas"><span class="s_paga_conta"><a href="javascript:void(0);" title="Pagar esse produto" class="addImgPagar"><!--Pagar--></a></span><span class="s_delete_conta"><a href="javascript:void(0);" title="Excluir" class="addImgDel"><!--excluir--></a></span></div></li>');		
				$('#i_nome_prod_contas').val("").focus();
				$('#i_cod_func').addClass('firstQuant');
				if($('#s_mostraCampo').attr('class')=='mostraDisverso'){
					$('#s_escondeCampoVal').show();
					$('#s_mostraCampo').removeClass('mostraDisverso');
					$('#i_val_diverso').val('0,00');
				}else{
				$('#s_mostraVal').html("0,00");
				}
				qualQuant.val('0');
				$('.valAltera').html('0,00');
				$('.i_id_prod').val('0');
				$('.i_valor_prod').val("").attr("id","");
                $('.i_valor_compra_prod').val("");
				$('.i_quant_prod').val("0");
				var novoTotal = (parseFloat($('#car_val_total').attr('class'))+parseFloat(ValQuant));
				$('#car_val_total').attr('class',novoTotal).html(number_format(novoTotal,2,',','.'));		
				}
				});
				}
				return false;
		}
		
});

$(function(){
//PARTE COMANDA MESA CAIXA
$('#troca_cadastros').on('click','#s_openNext_mesa a',function(){
if(window.history.pushState){	
window.history.pushState(null,'Gerabar - Controle de comanda',$(this).attr('href'));
$('#carregador').show();
$.get('_php/carrega-busca-bares.php',{newMesa:true,mesaCaixa:true},function(data){
$('.list-mesas-ul').html(data);
$('#carregador').hide();
$('#s_openNext_mesa').hide();
$('#tudo_cmd_mesa_caixa').hide();
$('#cont-sel-mesas').show();
$('#bc_cmd_mesa').val('').focus();
});
return false;
}
});

//PARTE COMANDA MESA BAR
$('#troca_cadastros').on('click','#s_abrir_new_mesa a',function(){
if(window.history.pushState){	
window.history.pushState(null,'Gerabar - Controle de comanda',$(this).attr('href'));
$('#s_abrir_new_mesa').hide();
$('.info_topo_cad h1').html('selecione a comanda de mesa').show();
$('.info_topo_cad').show();
$('.d_alinha_form').show();
$('.list-mesas-ul').html('');
$('#carregador').show();
$('#pgAbaMesa').attr('class','abaMesa2');
$.get('_php/carrega-busca-bares.php',{newMesa:true},function(data){
$('#bc_cmd_mesa').val("").focus();
$('.list-mesas-ul').html(data);
$('#carregador').hide();
});
return false;
}
});

//BUSCA POR MESAS
$('#troca_cadastros').on('click','#envia_bc_cmd_mesa',function(){
	$('.d_aviso_erro').hide().children('p').html("");
	var busca=$('#bc_cmd_mesa');	
	if(busca.val()==""){
	$('#erro_'+busca.attr('id')+' p').html("Coloque o número da mesa !");
	$('#erro_'+busca.attr('id')).show();
	busca.focus();
	}else{
	$("#carregador").show();
	$('.list-mesas-ul').html("");
	$('.d_alinha_form').show();
	$.get("_php/carrega-busca-bares.php",{newMesa:true,serchMesa:busca.val(),abaMesaQ:$('#pgAbaMesa').attr('class')},function(data){
	$("#carregador").hide();
	$('.list-mesas-ul').html(data);
	});
	}
	return false;
});
	
	
$('#troca_cadastros').on('click','.list-mesas-ul a',function(){
if(window.history.pushState){	
var pgMesa=$('#cont-sel-mesas').attr('class'),txtMesa=(pgMesa=="selMesaCaixa")?'Opções de caixa':'Controle de comanda',idMesa=$(this).html().replace(/[^0-9]/g,'');
window.history.pushState(null,'Gerabar - '+txtMesa,$(this).attr('href'));
	if(pgMesa=="selMesaCaixa" && $(this).parents('li').attr('class')=="openMesa"){
			var arraCmd=[];
			$('#tudo_cmd_tudo_mesa').hide();
			$('#tudo_cmd_mesa_caixa').show();
			$('#voltarPagarCx').hide();
			$('#cd_consulta_cmd').val(idMesa).focus();
			$('#loadingOne').show();
			$('#cont_consulta_cmd').html("");
			arraCmd.push(idMesa);
			$.get('_php/carrega-busca.php',{busca_cmd_bar:'busca_comanda_mesa',arraCmd:arraCmd},function(retorno){			
			$('#loadingOne').hide();
			$('#cont_consulta_cmd').html(retorno);			
			if($('#mosta_total_cmd').attr('class')=="0"){
				var valTopo = $('.valorDeCada').html().split("|"),countLi=parseInt($('#countLinha').html()),qualLi;
				for(var i=0;i<countLi;i++){
				qualLi=i+1;
				$('.sp_cmd_val-'+qualLi).html(valTopo[i]);
				}
			}
				$('#voltarPagarCx').show();	
				$('.volta_mesas').css({'margin-left':'10px'});
				if($('#mosta_total_cmd').attr('class')=="0"){
				$('#juntarPagaCx,#descontarCx,#pagarTelaCx').show();
				}else{
				$('#juntarPagaCx,#pagarTelaCx').hide();
				}
			});
	}else{
	$('#troca_cadastros').html('');
	$('#loadingOne').show();	
	var pgAbaMesa=(pgMesa=="selMesaCaixa")?"opcao-mesa":"comanda-mesa";	
	$.post('_include/lancar-comanda.php',{inclui:pgAbaMesa,idMesa:idMesa},function(pagina){
		$('#loadingOne').hide();
		$('#troca_cadastros').html(pagina);
		$('#cd_comanda').val(idMesa).attr('disabled',true);
		$('#cd_garcon').focus();			
	});
	}
	return false;
}
});

$('#troca_cadastros').on('click','.volta_mesas',function(){
if(window.history.pushState){
var pgMesa=$('#pgAbaMesa').val(),txtMesa=(pgMesa=="opcao-mesa")?'Opções de caixa':'Controle de comanda';
window.history.pushState(null,'Gerabar - '+txtMesa,$(this).attr('href'));
	$('#troca_cadastros').html('');
	$('#loadingOne').show();
	$.post('_include/'+pgMesa+'.php',{inclui:true},function(pagina){
		$('#loadingOne').hide();
		$('#troca_cadastros').html(pagina);
	});
	return false;
}
});

//CADASTRA MESAS
$('#troca_cadastros').on('click','#d-cx-quant span',function(){		
			var inpQuant=$('#i-quant-mesa'),novoQuant,bClick=$(this);			
			bClick.css({'border':'0','border-left':'2px solid #666','border-top':'1px solid #666'});
			if(bClick.attr('id')=='s-menos-mesa'){bClick.css({'border-top':'2px solid #666'});}			
			window.setTimeout(function(){
			if(bClick.attr('id')=='s-mais-mesa'){
			if(parseInt(inpQuant.val())>=999){novoQuant=999;}else{novoQuant=parseInt(inpQuant.val())+1;}
			}else{
			if(parseInt(inpQuant.val())>999){
			novoQuant=999;
			}else if(inpQuant.val()==0){
			novoQuant=inpQuant.val();
			}else{
			novoQuant=parseInt(inpQuant.val())-1;
			}
			}
			novoQuant=(novoQuant<10)?'0'+parseInt(novoQuant):novoQuant;
			inpQuant.val(novoQuant);
			bClick.css({
				'border':'1px solid #666',
				'border-top':'0'
			});
			if(bClick.attr('id')=='s-menos-mesa'){bClick.css({'border-top':'1px solid #666'});}			
			},60);
		});
		
	$('#troca_cadastros').on('click','#envia-mesa a',function(){
	var qMesa=$('#i-quant-mesa').val();
	if(qMesa==""){
		$('#alert-cima p').html('Quantidade de mesa não pode ser igual a ""');
		$('#alert').show();
		$('#spanalert a').focus();
	}else if(isNaN(qMesa)){
		$('#alert-cima p').html('Coloque apenas números !');
		$('#alert').show();
		$('#spanalert a').focus();
	}else{
	$('#carregador').show();
	$.post('_php/cadastrar_dados.php',{qMesa:qMesa},function(data){
	$('#carregador').hide();
	var ret=data.split('|'),msg=ret[0],diverro=ret[1];		
		if(diverro!=""){
			$('#alert-cima p').html(msg);
			$('#alert').show();
			$('#spanalert a').focus();
		}else{
			$('#dentroOk').html(msg).fadeIn(150);
			setTimeout(function(){$('#dentroOk').fadeOut(200,function(){$('#dentroOk').html("");});},1500);
		}
	});
	}
	});

});