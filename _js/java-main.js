//JAVA MAIN
function getUrl(){ return 'http://localhost/myforadmin/';}
var er=new RegExp(/^[A-Za-z0-9_\-\.]+@[A-Za-z0-9_\-\.]{2,}\.[A-Za-z0-9]{2,}(\.[A-Za-z0-9])?/);
var pairar,pairaTwo,pairaThree,pairaUlt,pairaAju,pairaRecente,pairaGarcon,pararBusca;
//JAVA DE ALERTA E COMFIRMA
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
});

//JAVA DA BARRA PRINCIPAL
$(function(){
	var alteraBarra = true,timeout = true;
	
	function barraFechada(inicio,logoIco,abreFecha){
		if(inicio==true){
			$('#barra_principal').css({'margin-left':'-120px'});
			$('.acerta_barra').css({width:'40px'});
            //#logo_principal{ float:left; margin:5px 18px -3px 2px;}
            $('#logo_principal a').css({'width':'90px'});
            $('.img_logo_grande').hide();
            $('.img_logo_grande-2').show();
        }
		$('#ico_gerabar').show(logoIco);
		$('#logo_gerabar').hide(logoIco);
		$('.span_abre').hide(abreFecha);
		$('.span_fecha').show(abreFecha);
		
		$('#li_frente_caixa').css({ 'background-position':'129px 3px'});
		$('.li_ativo_princ a#li_frente_caixa').css({ 'background-position':'129px -29px'});
		$('#li_caixa,#li_abrir_fecha_caixa').css({ 'background-position':'129px 3px'});
		$('.li_ativo_princ a#li_caixa,.li_ativo_princ a#li_abrir_fecha_caixa').css({ 'background-position':'129px -29px'});
		$('#li_sistema_bar').css({ 'background-position':'133px 3px'});
		$('.li_ativo_princ a#li_sistema_bar').css({ 'background-position':'133px -31px'});
		$('#li_conta_cliente').css({ 'background-position':'131px 2px'});
		$('.li_ativo_princ a#li_conta_cliente').css({ 'background-position':'131px -31px'});
		$('#li_estoque').css({ 'background-position':'131px 4px'});
		$('.li_ativo_princ a#li_estoque').css({ 'background-position':'131px -26px'});
		$('#li_clientes').css({ 'background-position':'128px 2px'});
		$('.li_ativo_princ a#li_clientes').css({ 'background-position':'128px -28px'});
		$('#li_cadastros').css({ 'background-position':'131px 1px'});
		$('.li_ativo_princ a#li_cadastros').css({ 'background-position':'131px -35px'});
		$('#li_admin').css({ 'background-position':'130px 4px'});
		$('.li_ativo_princ a#li_admin').css({ 'background-position':'130px -28px'});
		$('#li_sair').css({ 'background-position':'133px 5px'});		
	}
	
	function barraAberta(inicio,logoIco,abreFecha){	
		if(inicio==true){
			$('#barra_principal').css({'margin-left':'0px'});
			$('.acerta_barra').css({width:'160px'});
            $('#logo_principal a').css({'width':'120px'});
            $('.img_logo_grande').show();
            $('.img_logo_grande-2').hide();
		}
		$('#ico_gerabar').hide(logoIco);
		$('#logo_gerabar').show(logoIco);
		$('.span_abre').show(abreFecha);
		$('.span_fecha').hide(abreFecha);

		$('#li_frente_caixa').css({ 'background-position':'4px 3px'});
		$('.li_ativo_princ a#li_frente_caixa').css({ 'background-position':'4px -29px'});
		$('#li_caixa,#li_abrir_fecha_caixa').css({ 'background-position':'4px 3px'});
		$('.li_ativo_princ a#li_caixa,.li_ativo_princ a#li_abrir_fecha_caixa').css({ 'background-position':'4px -29px'});
		$('#li_sistema_bar').css({ 'background-position':'7px 3px'});		
		$('.li_ativo_princ a#li_sistema_bar').css({ 'background-position':'7px -31px'});
		$('#li_conta_cliente').css({ 'background-position':'5px 2px'});		
		$('.li_ativo_princ a#li_conta_cliente').css({ 'background-position':'5px -31px'});
		$('#li_estoque').css({ 'background-position':'5px 4px'});
		$('.li_ativo_princ a#li_estoque').css({ 'background-position':'5px -26px'});
		$('#li_clientes').css({ 'background-position':'2px 2px'});
		$('.li_ativo_princ a#li_clientes').css({ 'background-position':'2px -28px'});
		$('#li_cadastros').css({ 'background-position':'4px 1px'});
		$('.li_ativo_princ a#li_cadastros').css({ 'background-position':'4px -35px'});		
		$('#li_admin').css({ 'background-position':'4px 4px'});
		$('.li_ativo_princ a#li_admin').css({ 'background-position':'4px -28px'});
		$('#li_sair').css({ 'background-position':'7px 5px'});
	}
    
    $('#rolarBaixo').on('click',function(){
        $("html,body").animate({ scrollTop:parseInt($("#wrap").outerHeight())},450);
        $(this).hide();
    });
	
	$(document).ready(function() {
        
        rolarBaixo();
		menuCaixa();
		if($(window).outerWidth()<=605){
		$('#logo_principal').hide();
		}else{
		$('#logo_principal').show();
		}
		
        if($(window).outerWidth()<=1130){
		barraFechada(true,0,0);	
		}else{
		barraAberta(true,0,0);
		}
    });
    
    $(window).scroll(function(){        
        rolarBaixo();
    });
    
	$(window).resize(function(){
        rolarBaixo();
		menuCaixa();
		if($(window).outerWidth()<=605){
		$('#logo_principal').hide();
		}else{
		$('#logo_principal').show();
		}
	
		if($(window).outerWidth()<=1130){
			if(alteraBarra==true){
			barraFechada(true,0,0);
			alteraBarra=false;
			}
		}else{
			if(alteraBarra==false){
			barraAberta(true,0,0);
			alteraBarra=true;
			}		
		}		
	});
	
	$('#barra_principal').hover(function(){
		if($(window).outerWidth()<=1130){
			pairar = setTimeout(function(self){
				barraAberta(false,250,250);
				$(self).animate({'margin-left':'+=120px'},300);
				timeout = false;
			}, 250, this);			
		}

	},function(){
		if(timeout){
			clearTimeout(pairar);
		}else{
			barraFechada(false,250,250);
			$(this).animate({'margin-left':'-=120px'},300);
			timeout = true;
		}
	});
});

function menuCaixa(){
	var varPrinc=$('.aba-caixa-bar li'),num=varPrinc.length,numPegar,tamanhoLi=0,tamanhoCorpo=(parseInt($('.aba-caixa-bar').outerWidth())-8),quantMais,idLi,classLi,styleBlock,tmhLi=parseInt($('#aLiMais').attr('class'));
		for(var i=0;i<num;i++){
			styleBlock='';
			if(varPrinc.eq(i).attr('id')=="liMais"){
			i=num;
			}else{				
				if($('#liMais ul li').length==0){
				numPegar=(varPrinc.eq(i+1).attr('id')=="liMais")?0:parseInt($('#liMais').outerWidth());
				}else{
				numPegar=parseInt($('#liMais').outerWidth());
				}
				
				if(varPrinc.eq(i).attr('id')=="liClienteConta"){
					if(varPrinc.eq(i).attr('class')=="cadastro_ativo"){
					tamanhoLi+=parseInt(varPrinc.eq(i).outerWidth());
					styleBlock=' style=" display:block;"';
					}
				}else{
				tamanhoLi+=parseInt(varPrinc.eq(i).outerWidth());
				}
				
				if(tamanhoLi+numPegar>=tamanhoCorpo){
					if($('#liMais ul li').length==0){
						for(var e=i;e<num;e++){
							if(varPrinc.eq(e).attr('id')=="liMais"){
							e=num;
							}else{					
							idLi=(varPrinc.eq(e).attr('id')===undefined)?'':'id="'+varPrinc.eq(e).attr('id')+'" ';
							classLi=(varPrinc.eq(e).attr('class')===undefined)?'':'class="'+varPrinc.eq(e).attr('class')+'"';							
							if($('#liMais ul li').length==0){
							$('#liMais ul').html('<li '+idLi+classLi+styleBlock+'>'+varPrinc.eq(e).html()+'</li>');					
							}else{
							quantMais=parseInt($('#liMais ul li').length)-1;
							$('#liMais ul li').eq(quantMais).after('<li '+idLi+classLi+styleBlock+'>'+varPrinc.eq(e).html()+'</li>');
							}
							varPrinc.eq(e).remove();
							}
							styleBlock='';
						}
						i=num;
						
					}else{
						idLi=(varPrinc.eq(i).attr('id')===undefined)?'':'id="'+varPrinc.eq(i).attr('id')+'" ';
						classLi=(varPrinc.eq(i).attr('class')===undefined)?'':'class="'+varPrinc.eq(i).attr('class')+'"';
						$('#liMais ul li').eq(0).before('<li '+idLi+classLi+styleBlock+'>'+varPrinc.eq(i).html()+'</li>');
						varPrinc.eq(i).remove();
						i=num;
					}
				}
			}
		}
		
		numPegar=($('#liMais ul li').length>1)?parseInt($('#liMais').outerWidth()):0;
		if(tamanhoLi+numPegar+tmhLi<tamanhoCorpo){			
			if($('#liMais ul li').length>0){				
				styleBlock=($('#liMais ul li').eq(0).attr('id')=="liClienteConta" && $('#liMais ul li').eq(0).attr('class')=="cadastro_ativo")?' style=" display:block;"':'';				
				idLi=($('#liMais ul li').eq(0).attr('id')===undefined)?'':'id="'+$('#liMais ul li').eq(0).attr('id')+'" ';
				classLi=($('#liMais ul li').eq(0).attr('class')===undefined)?'':'class="'+$('#liMais ul li').eq(0).attr('class')+'"';
				$('#liMais').before('<li '+idLi+classLi+styleBlock+'>'+$('#liMais ul li').eq(0).html()+'</li>');
				$('#liMais ul li').eq(0).remove();
			}	
		}
		
		if($('#liMais ul li').length>0){
		$('#liMais').show();
		}else{
		$('#liMais').hide();
		}
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
//SEM maisMenos
function maisMenos(e){
	var tecla=(window.event)?event.keyCode:e.which;
	if(tecla==43 || tecla==45 || tecla==61 || tecla==95){ return false;}
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
//FIM NUMBER FORMAT


//FUNÇÃO CLICK PÁGINA ATALHOS
$(document).keydown(function(e){
    var code = e.which || e.keyCode;
    var pgCarrega=$("#qualPaginaAtivo").html(),funcional=true;
    if(pgCarrega==""){
        if(code==113){
        finaliza_venda();
        funcional=false;
        }else if(code==115){
            var hide=$('#d_val_unitario').attr('class').split(' ');
            if(hide[0]=="d_hide_frente" || hide[1]=="d_hide_frente"){
            $('#d_val_unitario').hide();
            $('#d_mostra_inp_unitario').show();
            $('#i_val_unitario').val("").focus();            
            funcional=false;
            }
        }else if(code==116){
            if($('#d_alt_unidade').attr('class')=="d_hide_frente"){
            $('#d_alt_unidade').hide();
            $('#i_quant_unitario').val("").show().focus();
            funcional=false;   
            }
        }else if(code==114){
            if($('#d_desconto_frente').attr('class')=="d_hide_frente"){
            $('#d_desconto_frente').hide();
            $('#d_mostra_val_desconto').show();
            $('#i_val_desconto').val("").focus();
            funcional=false;   
            }
        }
        
    }else if(pgCarrega=="caixa"){
        if(code==113){
        finaliza_cmd_mesa();
        funcional=false;
        }else if(code==114){
        if($('#valTotalComanda').html()!=undefined){
        finaliza_desconto();
        funcional=false;
        }
        }else if(code==112){
        if($('.bt_subbusca').children('span').attr('class')!=undefined){
        carrega_busca_cmd('cd_consulta_cmd');
        funcional=false;
        }
        }
    }else if(pgCarrega=="comanda-bar"){
        if(code==112){
        if($('.bt_subbusca').children('span').attr('class')!=undefined){
        var qualPgVai=($('.bt_subbusca').attr('id')=='bt_consultaBusca')?'cd_consulta_cmd':'cd_comanda';
        carrega_busca_cmd(qualPgVai);
        funcional=false;
        }
        }
    }else if(pgCarrega=="contas-clientes"){
        if($('#car_val_total').html()!=undefined && $('#car_val_total').html()!="0,00"){    
            if(code==113){            
            finaliza_conta($('#d_cadastro_produto').attr('class'),$('.idContaCliente').val(),$('#car_val_total').html());
            funcional=false;
            }else if(code==114){
            finaliza_desconto();
            funcional=false;
            }
        }
    }
    if(code == 27){
    $('#fundo_branco').fadeOut(150,function(){$('#fundo_branco').html('');});
    $('#fundo_preto').fadeOut(150,function(){$('#fundo_preto').html('');});
    }
    
    if(!funcional){
        e.preventDefault();
        e.stopPropagation();
    }
    
});

function carrega_busca_cmd(qualBusca){    
    $('.d_aviso_erro').hide().children('p').html("");
    $('#carregador').show();
    $.get('_include/loading-interno.php',{buscBarCmd:true,linhaProduto:qualBusca},function(data){
    $('#carregador').hide();
    $('#fundo_branco').html(data).fadeIn(150);
    $('#i_subBuscaTxt').focus();			
    });    
}

function finaliza_venda(){
    if($('.val_cx_aberto').attr('id')==undefined){
   $('.d_aviso_erro').hide().children('p').html("");            
      if($('#ulmostraprod li').length>0){
          $('#carregador').show();
          var valTotal=$('#d_valorTotal').html().split(' ');
          $.post('_include/loading-interno.php',{pagarCmd:true,totalCmd:valTotal[1],idCliente:'frente_caixa'},function(data){
              $('#carregador').hide();
              $('#fundo_branco').html(data).fadeIn(150);
        });
      }
    }
}

function finaliza_cmd_mesa(){
    if($('#countLinha').html()!=undefined){
        $('.d_aviso_erro').hide().children('p').html("");
        var countLi=parseInt($('#countLinha').html()),contCmd='',qlCmdMesa='pagarMesa';
        for(var i=1;i<=countLi;i++){		
            contCmd=contCmd+'|'+$('.sp_cmd_pegar-'+i).html();
        }
        $('#carregador').show();
        if($('#cont_consulta_cmd').attr('class')=="busca_comanda_mesa"){			
            for(i=1;i<=countLi;i++){
                qlCmdMesa=qlCmdMesa+'|0';
                //$('.sp_cmd_servico-'+i).html().replace(/[.]/g,"").replace(",",".");
            }		
        }else{
        qlCmdMesa="busca_cmd";
        }
        $.post('_include/loading-interno.php',{pagarCmd:true,totalCmd:$('#valTotalComanda').html(),idCliente:contCmd,qlCmdMesa:qlCmdMesa},function(data){
        $('#carregador').hide();
        $('#fundo_branco').html(data).fadeIn(150);
        });
    }
}

function finaliza_desconto(){
    $('.d_aviso_erro').hide().children('p').html("");
    var certoDesc=false,totalCmd;
    if($('#descontarCx a').parent('#descontarCx').attr('class')=="descontaConta"){
    totalCmd=$('#car_val_total').html();
    certoDesc=true;
    }else{
        var countLi=parseInt($('#countLinha').html());
        if(countLi>1){
        $('#alert-cima p').html("Só é possível descontar de uma comanda !");
        $('#alert').show();
        $('#spanalert a').focus();
        }else{
        certoDesc=true;
        totalCmd=$('#valTotalComanda').html();
        }
    }
    if(certoDesc==true){	
    $('#carregador').show();
    $.post('_include/loading-interno.php',{descontarCmd:true,totalCmd:totalCmd},function(data){
    $('#carregador').hide();
    $('#fundo_branco').html(data).fadeIn(150);
        $('#money-descontar').val('0,00').focus();
    });
    }
}

function finaliza_conta(idcliente,idconta,valor){
    $('#carregador').show();
    $.post('_include/loading-interno.php',{pagarCmd:true,totalCmd:valor,idCliente:idcliente,quant:"",idPago:idconta},function(data){
    $('#carregador').hide();
    $('#fundo_branco').html(data).fadeIn(150);
    }); 
}

$(function(){

//BUSCA DO TOPO
$("#i_busca_txt_tudo").on('keyup',function(e){
buscaTopoPrincipal(e);
});

$("#i_busca_envia_tudo").on('click',function(e){
buscaTopoPrincipal(e);
});
    
//FUNÇÃO BUSCA PRINCIPAL
function buscaTopoPrincipal(e){
	$('.d_aviso_erro').hide().children('p').html("");
	if(e.which==1){	var tecla=1;}else{var tecla=(window.event)?event.keyCode:e.which;}
	if((tecla<33 || tecla>36) && (tecla<16 || tecla>18) && (tecla!=37 && tecla!=38 && tecla!=39 && tecla!=40 &&  tecla!=0 && tecla!=9 && tecla!=20 && tecla!=255)){
		
	clearTimeout(pararBusca);
	$('#busca_do_topo').html('<li id="carrega_busc_topo"></li>').show();
	var busq = $('#i_busca_txt_tudo').val().trim();
	if(busq.length==0){
		$('#busca_do_topo').html('').hide();
	}else{
		$('#busca_do_topo').show();
		pararBusca=setTimeout(function(){
		$.get('_php/carrega-busca.php',{busca_geral_topo:busq,liberarPg:$('#liberarPg').val()},function(retorno){
			if(retorno==""){
			$('#busca_do_topo').html('').hide();
			}else{
			$('#busca_do_topo').html(retorno);
			}
		});
		},200);
	}
	}
return false;
}

//ABRIR CAIXA E FECHAR CAIXA
$('body').on('click','.a_abrir_caixa,.a_fechar_caixa',function(){
    $('#carregador').show();
    $.post('_include/loading-interno.php',{abrirCaixa:true,abrirFecharCx:$(this).attr('class')},function(data){
    $('#carregador').hide();
    $('#fundo_branco').html(data).fadeIn(150);
    $('#i_troco_cx').focus();
        
    });
});
    
$('#fundo_branco').on('click','#voltar-abrirCaixa a',function(){
$('.d_aviso_erro').hide().children('p').html("");
$('#fundo_branco').fadeOut(200,function(){$('#fundo_branco').html("");});
});
    
$('body').on('click','.s_fechando_cx a',function(){
    
    if($('#spansim a').attr('id')!="sim"){
		$(this).blur();
		$('#confirm-cima p').html('Tem certeza que deseja fechar esse caixa ?');
		$('#spansim').addClass('s_fechando_cx');
		$('#spansim a').attr('id','sim');
		$('#confirm').show();
		$('#spansim a').focus();
		}else{
        $('#confirm-cima p').html('');
		$('#confirm').hide();
            $('#carregador').show();
            $.get("_php/alterar_cadastros.php",{fechar_caixa:true},function(retorno){
                $('#carregador').hide();
                var retu=retorno.split('|'),msg=retu[0],erro=retu[1];
                if(erro==""){
                    $('#li_abrir_fecha_caixa').attr('class','a_abrir_caixa').attr('title','Abrir Caixa');
                    $('#li_abrir_fecha_caixa .span_abre').html('Abrir Caixa');
                    if($('#qualPaginaAtivo').html()==""){
                        $('#d_cx_livre h2').attr('class','cx-fechado').html('CAIXA FECHADO');
                        $('#enviabusca1,#busca_frente_caixa').attr('disabled',true);
                        $('#s_abrir_caixa').show();
                        $('#s_finaliza_frente,#s_transferir_frente,#s_cancelar_cx').hide();
                    }
                    $('#fundo_branco').fadeOut(200,function(){ $('#fundo_branco').html("");});
                    $('#dentroOk').html(msg).fadeIn(150);
                    setTimeout(function(){$('#dentroOk').fadeOut(150);},800);
                }else{
                $('#alert-cima p').html(msg);
                $('#alert').show();
                $('#spanalert a').focus();
                }
            });
            
        $('#spansim a').attr('id','');
		$('#spansim').removeClass('s_fechando_cx');
        }
});
    
$('#fundo_branco').on('click','#i_abrir_caixa,#i_reabrir_caixa',function(){
    $('.d_aviso_erro').hide().children('p').html("");
    var troco=$('#i_troco_cx').val().trim().replace(/[.]/g,"").replace(",","."),
        valLimit=$('#i_limiti_cx').val().trim().replace(/[.]/g,"").replace(",",".");

    if(troco=="" || troco=='0.00'){
        $('#erro_i_troco_cx p').html('Coloque o valor de troco para o caixa !');
        $('#erro_i_troco_cx').show();
        $('#i_troco_cx').focus();
    }else if(valLimit=="" || valLimit=="0.00"){
        $('#erro_i_limiti_cx p').html('Coloque o limite do caixa para a sangria !');
        $('#erro_i_limiti_cx').show();
        $('#i_limiti_cx').focus();
    }else{
        $('#carregador').show();
        $.post('_php/cadastrar_dados.php',{abrirCaixa:true,troco:troco,valLimit:valLimit,qualAbrir:$(this).attr('id')},function(retorno){
        $('#carregador').hide();
        var ret=retorno.split('|'),msg=ret[0],diverro=ret[1],qualPgAtivo=$('#qualPaginaAtivo').html();
            if(diverro==""){
            $('#li_abrir_fecha_caixa').attr('class','a_fechar_caixa').attr('title','Fechar Caixa');
            $('#li_abrir_fecha_caixa .span_abre').html('Fechar Caixa');
                
            if(qualPgAtivo==""){
                $('#d_cx_livre h2').attr('class','fa-blink').html('CAIXA LIVRE');
                $('#enviabusca1,#busca_frente_caixa').attr('disabled',false);
                $('#s_abrir_caixa').hide();
                $('#s_finaliza_frente,#s_transferir_frente,#s_cancelar_cx').show();
                $('#busca_frente_caixa').focus();
            }
                
            $('#fundo_branco').fadeOut(200,function(){ $('#fundo_branco').html("");});
            $('#dentroOk').html(msg).fadeIn(150);
            setTimeout(function(){$('#dentroOk').fadeOut(150);},800);
            }else if(diverro!="erro"){
                $('#erro_'+$('#'+diverro).attr('id')+' p').html(msg);
                $('#erro_'+$('#'+diverro).attr('id')).show();
                $('#'+diverro).focus();
            }else{
                $('#alert-cima p').html(msg);
                $('#alert').show();
                $('#spanalert a').focus();
            }
            
        });
    }
    return false;
});
    
//COMEÇO FRENTE DE CAIXA

$('#todo-frente-caixa').on('click','#enviabusca1',function(){
cadastrarFrente();
});
    
$('#todo-frente-caixa').on('click','#ul_lista_busca_caixa li',function(){
cadastrarFrente();    
});
    
    $('#todo-frente-caixa').on('keyup','#busca_frente_caixa',function(e){
	var tecla=(window.event)?event.keyCode:e.which;
	if((tecla<33 || tecla>36) && (tecla<16 || tecla>18) && (tecla!=37 && tecla!=39 && tecla!=0 && tecla!=9 && tecla!=20 && tecla!=255)){
			clearTimeout(pararBusca);
			$('.d_aviso_erro').hide().children('p').html("");            
			if((tecla==40 || tecla==38) && $('#ul_lista_busca_caixa li').attr('class')!='carrega_b'){
				var active = -1,suggest = $('#ul_lista_busca_caixa li'),qnts = suggest.length;
				
				for(var i=0;i<qnts;i++){
					if(suggest.eq(i).attr('class')=="bAtivo"){
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
				suggest.removeClass('bAtivo');
				suggest.eq(active).addClass('bAtivo');
				}
				
			}else if(tecla==13){
            cadastrarFrente();     
			}else{
			var busq = $('#busca_frente_caixa').val().trim();
			if(busq.length==0){
				$('#ul_lista_busca_caixa').html('').hide();
			}else{
            $('#ul_lista_busca_caixa').html('<li class="carrega_b"></li>').show();
			pararBusca=setTimeout(function(){
			$.get('_php/carrega-busca.php',{busca_frente_caixa:busq},function(retorno){
				if(retorno==""){
				$('#ul_lista_busca_caixa').html('').hide();
				}else{
				$('#ul_lista_busca_caixa').html(retorno);
				}
			});
			},200);
	}
	}
	}
return false;
});
    
function cadastrarFrente(){
var buscaLimpa=$("#busca_frente_caixa").val().trim(),semLista=false;
if(buscaLimpa!=""){
$("#busca_frente_caixa,#enviabusca1").attr('disabled',true);
var codigoInterno='(diversos)',nomeProd,idProduto=0,valorCompra=0,valorUnit='0,00';
    
    if($('.bAtivo').children('span').attr('class')!=undefined){
    var idVal=$('.bAtivo').children('span').attr('class').split("|");
    codigoInterno=idVal[0];
    idProduto=idVal[1];
    valorUnit=idVal[2];
    valorCompra=idVal[3];
    nomeProd=$('.bAtivo').children('span').html();
    }else{
    semLista=true;
    nomeProd=buscaLimpa;
    }
    $('#ul_lista_busca_caixa').html("").hide();
    $('#carregador').show();
    $.get("_php/cadastrar_dados.php",{frenteCaixa:'salva',codInterno:codigoInterno,nomeProduto:nomeProd,valorCompra:valorCompra,valorUnit:valorUnit.replace(/[.]/g,"").replace(",","."),idProduto:idProduto},function(retorno){
        var ret=retorno.split("|"),msg=ret[0],erro=ret[1];
        
        if(erro==""){
        if(nomeProd.length>29){ nomeProd=nomeProd.substring(0,29)+'...'; }
        $('#d_cx_livre').hide();
        $('#primdivmostra,#ulmostraprod').show();
        var countProd=parseInt($('#ulmostraprod li').length)+1;
        $('#todo-frente-caixa').attr('class',msg);
        $('#codigoprinc').html(codigoInterno);
        $('#nomeprinc').html(nomeProd);
            
        $('#ulmostraprod').append('<li class="'+msg+'"><div class="most1"><span class="s_li_cx_respansivo">código:&nbsp;</span> <span class="s_cod_cx">'+codigoInterno+'</span></div><div class="most2"><span class="s_nome_cx">'+nomeProd+'</span></div><div class="most4"><span class="s_li_cx_respansivo">valor unit.:&nbsp;</span> <span class="s_valUnit_cx">R$ '+valorUnit+'</span></div><div class="most3"><span class="s_li_cx_respansivo">quant.:&nbsp;</span> <span class="s_quant_cx">1</span></div><div class="most5"><span class="s_li_cx_respansivo">valor total:&nbsp;</span> <span class="s_valTotal_cx">R$ '+valorUnit+'</span></div><div class="most6"><a href="javascript:void(0);" id="'+idProduto+'-'+countProd+'-cxId" class="frente_delete" title="Excluir produto da comanda"><!--exclui--></a></div></li>');
            
        if(countProd==1){ $('.desCursor').removeClass('desCursor');}

        var heb = $('#ulmostraprod').get(0).scrollHeight;
        var totop = heb - $('#ulmostraprod').height();
        $('#ulmostraprod').scrollTop(totop);

        $('#busca_frente_caixa').val('');
        $('.salvaValor').html('<span>R$</span> '+valorUnit);
        $('#d_alt_unidade').html('1');

        var volumeAtual=parseInt($('#d_quant_volume').html()),valTCx=$('#d_valorTotal').html().split(" "),
            valTotalCx=parseFloat(valTCx[1].replace(/[.]/g,"").replace(",",".")),
            valForProd=parseFloat(valorUnit.replace(/[.]/g,"").replace(",","."));

        $('#d_quant_volume').html(volumeAtual+1);

        $('#d_valorTotal').html('<span>R$</span> '+number_format((valTotalCx+valForProd),2,',','.'));

        $('#d_alt_unidade,#d_desconto_frente').addClass("d_hide_frente");


        if(semLista==true){
        $('#d_val_unitario').addClass("d_hide_frente").hide();
        $('#d_mostra_inp_unitario').show();
        $('#i_val_unitario').val("").focus();
        $('#i_quant_unitario').val(1);
        }else{
            $('#d_val_unitario').removeClass("d_hide_frente");
        }
            
        }else{
            $('#alert-cima p').html(msg);
			$('#alert').show();
			$('#spanalert a').focus();
        }
        $('#carregador').hide();
        $("#busca_frente_caixa,#enviabusca1").attr('disabled',false);
    });
    
    if(semLista==false){
    $('#d_alt_unidade').hide();
    $('#i_quant_unitario').val(1).addClass("firstQuant").show().focus();
    $("#busca_frente_caixa,#enviabusca1").attr('disabled',false);
    }
}
}
    

$('#todo-frente-caixa').on('mouseover','#ul_lista_busca_caixa li',function(){
	$('#ul_lista_busca_caixa li').removeClass('bAtivo');
	$(this).addClass('bAtivo');
});
    
$('#todo-frente-caixa').on('click','.d_hide_frente',function(){
    $(this).addClass('val_cx_aberto').hide();
    if($(this).attr('id')=="d_alt_unidade"){    
    $('#i_quant_unitario').val("").show().focus();
    }else if($(this).attr('id')=="d_val_unitario"){
    $('#d_mostra_inp_unitario').show();
    $('#i_val_unitario').val("").focus();
    }else if($(this).attr('id')=="d_desconto_frente"){    
    $('#d_mostra_val_desconto').show();
    $('#i_val_desconto').val("").focus();
    }
}); 

$('#todo-frente-caixa').on('keyup','#i_val_unitario',function(e){
    var tecla = e.which || e.keyCode;
    if(tecla==13){
        $(this).blur();
    }else{
    $('#d_val_total').html('<span>R$</span> '+number_format(parseFloat($(this).val().replace(/[.]/g,"").replace(",","."))*parseInt($('#d_alt_unidade').html()),2,',','.'));    
    }
});
    
$('#todo-frente-caixa').on('blur','#i_val_unitario',function(){
    
    if($(this).val()=="" || $(this).val()=="0,00"){
    $('.d_show_frente').hide();
    $('#d_mostra_inp_unitario,.d_hide_frente').show();
    $('#d_val_unitario').hide();
    $('#erro_'+$(this).attr('id')+' p').html('Coloque o valor do produto !');
    $('#erro_'+$(this).attr('id')).show();            
    $(this).focus();
    }else{
        var valUniFormatado=$(this).val().replace(/[.]/g,"").replace(",","."),valorUni=$('#d_val_unitario').html().split(' ');
        altValorQuantidade('i_val_unitario',valUniFormatado,parseFloat(valorUni[1].replace(/[.]/g,"").replace(",",".")));
    }
}); 
    
$('#todo-frente-caixa').on('keyup','#i_quant_unitario',function(e){    
    var tecla = e.which || e.keyCode;
    var valorUni=$('#d_val_unitario').html().split(' ');
    if(tecla==13){
        $(this).blur();
    }else{
    $('#d_val_total').html('<span>R$</span> '+number_format(parseFloat(valorUni[1].replace(/[.]/g,"").replace(",","."))*parseInt($(this).val()),2,',','.'));    
    }
});

    
$('#todo-frente-caixa').on('blur','#i_quant_unitario',function(){
    var valorUni=$('#d_val_unitario').html().split(' '),valUniFormatado=valorUni[1].replace(/[.]/g,"").replace(",",".");        
    if($(this).val()=="" && valUniFormatado!="0.00"){
    $('.d_show_frente').hide();
    $('#i_quant_unitario,.d_hide_frente').show();
    $('#d_alt_unidade').hide();
    $('#erro_'+$(this).attr('id')+' p').html('Coloque a quantidade do produto !');
    $('#erro_'+$(this).attr('id')).show();            
    $(this).focus();
    }else if(isNaN($(this).val())){
    $('.d_show_frente').hide();
    $('#i_quant_unitario,.d_hide_frente').show();
    $('#d_alt_unidade').hide();
    $('#erro_'+$(this).attr('id')+' p').html('Coloque apenas números !');
    $('#erro_'+$(this).attr('id')).show();            
    $(this).focus();
    }else{        
    altValorQuantidade('i_quant_unitario',valUniFormatado,parseFloat(valUniFormatado));
    }
});
    
function altValorQuantidade(qualMuda,valUniFormatado,valUniFormatPri){
    $('.d_aviso_erro').hide().children('p').html("");
    var valUniFormatSeg=parseFloat(valUniFormatado),
        quantAtual=parseInt($('#d_alt_unidade').html()),
        ultLiLista=$('#ulmostraprod li:last-child'),
        valTCx=$('#d_valorTotal').html().split(" "),
        valTotalCx=parseFloat(valTCx[1].replace(/[.]/g,"").replace(",",".")),
        idProduto=ultLiLista.children('.most6').children('a').attr('id').split('-'),
        quantAtualiza=(qualMuda=="i_val_unitario")?quantAtual:($('#'+qualMuda).val()=="")?0:parseInt($('#'+qualMuda).val()),
        quantEnvia=quantAtualiza-quantAtual,
        codInterno=ultLiLista.children('.most1').children('.s_cod_cx').html();
    
    if(qualMuda=='i_val_unitario'){
        $('#d_mostra_inp_unitario').hide();
        $('#d_val_unitario').html('<span>R$</span> '+$('#'+qualMuda).val()).show();
        ultLiLista.children(".most4").html('<span class="s_li_cx_respansivo">valor unit.:&nbsp;</span> <span class="s_valUnit_cx">R$ '+$('#'+qualMuda).val()+'</span>');
        ultLiLista.children(".most5").html('<span class="s_li_cx_respansivo">valor total:&nbsp;</span> <span class="s_valTotal_cx">R$ '+number_format(valUniFormatSeg*quantAtualiza,2,',','.')+'</span>');
        $('#d_valorTotal').html('<span>R$</span> '+number_format((valTotalCx-(valUniFormatPri*quantAtual))+(valUniFormatSeg*quantAtualiza),2,',','.'));
        $('#d_alt_unidade').hide();
        $('#i_quant_unitario').addClass("firstQuant").show().focus();
    }else if(qualMuda=='i_quant_unitario' && (quantAtualiza!=quantAtual || idProduto[0]==0)){
        
    $('#carregador').show();
    $.get("_php/cadastrar_dados.php",{frenteCaixa:'atualiza',valorUnit:valUniFormatSeg,quantProd:quantEnvia,idProduto:idProduto[0],codInterno:codInterno},function(retorno){
        var ret=retorno.split("|"),msg=ret[0],erro=ret[1];
        if(erro==""){
            
        var volumeAtual=parseInt($('#d_quant_volume').html());
        $('#d_quant_volume').html((volumeAtual-quantAtual)+quantAtualiza);
        $('#d_alt_unidade').html(quantAtualiza).show();
        $('#'+qualMuda).hide();
            
        ultLiLista.children(".most3").html('<span class="s_li_cx_respansivo">quant.:&nbsp;</span> <span class="s_quant_cx">'+quantAtualiza+'</span>');            
        ultLiLista.children(".most5").html('<span class="s_li_cx_respansivo">valor total:&nbsp;</span> <span class="s_valTotal_cx">R$ '+number_format(valUniFormatSeg*quantAtualiza,2,',','.')+'</span>');
        $('#d_valorTotal').html('<span>R$</span> '+number_format((valTotalCx-(valUniFormatPri*quantAtual))+(valUniFormatSeg*quantAtualiza),2,',','.'));
        
        if($('#'+qualMuda).val()!="" && $('#'+qualMuda).val()!="0" && valUniFormatado=="0.00"){
            $("#d_val_unitario").hide();
            $('#d_mostra_inp_unitario').show();
            $('#i_val_unitario').focus();
        }else{
            $("#busca_frente_caixa").focus();
        }
        $('.d_hide_frente').removeClass('val_cx_aberto');
        }else if(erro!="erro"){
        $('#erro_'+erro+' p').html(msg);
        $('#erro_'+erro).show();
        $("#"+erro).focus();
        }else{
            $('#alert-cima p').html(msg);
			$('#alert').show();
			$('#spanalert a').focus();
        }
        $('#carregador').hide();
        
    });
        
    }else{
        $('#d_alt_unidade').show();
        $('#'+qualMuda).hide();
        $("#busca_frente_caixa").focus();
    }
    
}

$('#todo-frente-caixa').on('keyup','#i_val_desconto',function(e){
    var tecla = e.which || e.keyCode;
    if(tecla==13){
        $(this).blur();
    }
});
    
$('#todo-frente-caixa').on('blur','#i_val_desconto',function(){
    descontoFrente($(this).val());
});
    
function descontoFrente(valDesc){
$('.d_aviso_erro').hide().children('p').html("");
if(valDesc==""){
    valDesc=="0,00";
}
var valSplit=$('#d_valorTotal').html().split(' '),
    valorTotal=parseFloat(valSplit[1].replace(/[.]/g,"").replace(",",".")),
    valDesconto=parseFloat(valDesc.replace(/[.]/g,"").replace(",",".")),
    descSplit=$('#d_desconto_frente').html().split(' '),
    valDescontoAtual=parseFloat(descSplit[1].replace(/[.]/g,"").replace(",","."));

if(valDesconto==valDescontoAtual){
    $('#d_desconto_frente').show();
    $('#d_mostra_val_desconto').hide();
    $("#busca_frente_caixa").focus();
}else if(valDesconto>(valorTotal+valDescontoAtual)){
    $('#erro_i_val_desconto p').html('Desconto não pode ser maior que valor a pagar !');
    $('#erro_i_val_desconto').show();            
    $('#i_val_desconto').focus();
}else{
    $('#carregador').show();
    $.get("_php/cadastrar_dados.php",{frenteCaixa:true,descontarFrente:valDesconto},function(retorno){
    var ret=retorno.split("|"),msg=ret[0],diverro=ret[1];
    if(diverro==""){
    $('#carregador').hide();
    $('#d_valorTotal').html('<span>R$</span> '+number_format((valorTotal+valDescontoAtual)-valDesconto,2,',','.'));                
    $('#d_desconto_frente').html('<span>R$</span> '+valDesc).show();
    $('#d_mostra_val_desconto').hide();
    $("#busca_frente_caixa").focus();    

    }else{
        $('#alert-cima p').html(msg);
        $('#alert').show();
        $('#spanalert a').focus();
    }
    $('.d_hide_frente').removeClass('val_cx_aberto');
    });

}
    
}
    
$("#todo-frente-caixa").on('click','.frente_delete',function(){
    
    if($('.val_cx_aberto').attr('id')==undefined){    
    $('#carregador').show();
    $.post('_include/loading-interno.php',{senhaMaster:true,classMaster:$(this).attr('id')},function(data){
    $('#carregador').hide();
    $('#fundo_branco').html(data).fadeIn(150);
    $('#envia_senha_master').addClass('delFrenteMaster');
    $('#senha_master').focus();
    });
    //delCmdMaster
    }
});
    
$('body').on('click','.delFrenteMaster',function(){		
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
				var rete=senhaMaster.attr('class').split('-'),
                    idProduto=rete[0],
                    liId=$('#'+senhaMaster.attr('class')).parents('li'),
                    idFrente=liId.attr('class'),
                    quantProd=liId.children('.most3').children('.s_quant_cx').html().split(' '),
                    valorProd=liId.children('.most5').children('.s_valTotal_cx').html().split(' ');
                    
					$.post('_php/alterar_cadastros.php',{idFrente:idFrente,quantProd:quantProd,idProduto:idProduto},function(dados){
						$('#carregador').hide();
						var ret=dados.split("|"),msg=ret[0],diverro=ret[1];
                        if(diverro!="erro"){
                            
                            var quantVolume=parseInt($('#d_quant_volume').html()),
                                valPri=$('#d_valorTotal').html().split(' '),
                                valTotal=parseFloat(valPri[1].replace(/[.]/g,"").replace(",",".")),
                                valProFor=parseFloat(valorProd[1].replace(/[.]/g,"").replace(",","."));
                            
                            $('#d_quant_volume').html(quantVolume-parseInt(quantProd));
                            $('#d_valorTotal').html('<span>R$</span> '+number_format(valTotal-valProFor,2,',','.'));
                            
                            $('#ulmostraprod li.'+idFrente).remove();                            
                            
                            if($('#ulmostraprod li').length==0){
                                $('#todo-frente-caixa').attr('class','');
                                $('#codigoprinc,#nomeprinc').html('');
                                $('#d_val_unitario,#d_val_total').html('<span>R$</span> 0,00');
                                $('#d_alt_unidade').html('0');
                                $('.d_hide_frente').removeClass('d_hide_frente');
                                $('#divopcional1 span').addClass('desCursor');
                                $('#primdivmostra,#ulmostraprod').hide();
                                $('#d_cx_livre').show();
                            }else if(idFrente==$('#todo-frente-caixa').attr('class')){
                            var ultLi=$('#ulmostraprod li:last-child'),
                                ultId=ultLi.attr('class'),
                                codInterno=ultLi.children('.most1').children('.s_cod_cx').html(),
                                nomeProd=ultLi.children('.most2').children('.s_nome_cx').html(),
                                ultQuant=ultLi.children('.most3').children('.s_quant_cx').html().split(' '),
                                ultValor=ultLi.children('.most4').children('.s_valUnit_cx').html().split(' ');
                                
                                $('#todo-frente-caixa').attr('class',ultId);
                                $('#codigoprinc').html(codInterno);
                                $('#nomeprinc').html(nomeProd);
                                $('#d_val_unitario').html('<span>R$</span> '+ultValor[1]);
                                $('#d_alt_unidade').html(ultQuant[0]);
                                $('#d_val_total').html('<span>R$</span> '+number_format(parseFloat(ultValor[1].replace(/[.]/g,"").replace(",","."))*parseInt(ultQuant[0]),2,',','.') );
                                
                            }
                            $('#fundo_branco').fadeOut(200,function(){ $('#fundo_branco').html("");});
							$('#dentroOk').html(msg).fadeIn(150);
							setTimeout(function(){$('#dentroOk').fadeOut(150);},800);
                            $('#busca_frente_caixa').focus();
						}else{
							$('#alert-cima p').html(msg);
							$('#alert').show();
							$('#spanalert a').focus();
						}
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
    
    $("#todo-frente-caixa").on('click','#s_finaliza_frente a',function(){
        finaliza_venda();
    });
    
    $("#todo-frente-caixa").on('click','#s_cancelar_cx',function(){
        if($('.val_cx_aberto').attr('id')==undefined){
        if($('#ulmostraprod li').length>0){
            $('#carregador').show();
            $.post('_include/loading-interno.php',{senhaMaster:true,classMaster:"tudo_frente_caixa"},function(data){
            $('#carregador').hide();
            $('#fundo_branco').html(data).fadeIn(150);
            $('#envia_senha_master').addClass('cancelaFrenteMaster');
            $('#senha_master').focus();
            });
        }
        }
    });

    $('body').on('click','.cancelaFrenteMaster',function(){		
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
                    
					$.post('_php/alterar_cadastros.php',{idFrente:"cancelar_operacao"},function(dados){
						$('#carregador').hide();
						var ret=dados.split("|"),msg=ret[0],diverro=ret[1];
                        if(diverro!="erro"){
                            $('#ulmostraprod').html('');
                            $('#todo-frente-caixa').attr('class','');
                            $('#codigoprinc,#nomeprinc').html('');
                            $('#d_val_unitario,#d_val_total,#d_desconto_frente,#d_valorTotal').html('<span>R$</span> 0,00');
                            $('#d_alt_unidade,#d_quant_volume').html('0');
                            $('.d_hide_frente').removeClass('d_hide_frente');
                            $('#divopcional1 span').addClass('desCursor');
                            $('#primdivmostra,#ulmostraprod').hide();
                            $('#d_cx_livre').show();
                            $('#fundo_branco').fadeOut(200,function(){ $('#fundo_branco').html("");});
							$('#dentroOk').html(msg).fadeIn(150);
							setTimeout(function(){$('#dentroOk').fadeOut(150);},800);
                            $('#busca_frente_caixa').val("").focus();
						}else{
							$('#alert-cima p').html(msg);
							$('#alert').show();
							$('#spanalert a').focus();
						}
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

    

//FIM FRENTE DE CAIXA

$('body').on('click','.lanca-comanda',function(){
if(window.history.pushState){
$('.d_aviso_erro').hide().children('p').html("");
if($('.cadastro_ativo a').attr('class')=="lancar-comanda"){
var sepClick=$(this).attr('id').split('-'),numClick=sepClick[0],idiverso=$('#cd_produto_cmd-0').parents('.d_alinha_subbusca'),idClick=$('#cd_produto_cmd-0').attr('id'),href1,href2;
if(sepClick[1]=="cmdcliente"){
	if(numClick.length==1){numClick="0"+numClick;}
	$('#cd_comanda').val(numClick);
	href1='&idcomanda='+numClick;
    href2=($('#cd_produto_cmd-0').val()!="" && idiverso.children('.bt_diversos').children('span').attr('class')=="diverso-false")?'&idproduto='+$('#cd_produto_cmd-0').val():'';
}else{		
	if(idiverso.children('.bt_diversos').children('span').attr('class')=="diverso-true"){
		$('#cd_produto_cmd-0').attr('onKeyUp','return SemEspaco(this);').attr('placeholder','Código do produto...').val("").css({'padding-right':'34px'});
		idiverso.children('.bt_subbusca').show();
		idiverso.children('.bt_diversos').children('span').attr('class','diverso-false');
		$('#openVal-'+idClick).hide();
		$('#openVal-'+idClick).children('input').val('0,00');
		$('#smallQuant-'+idClick).children('input').css({'width':'220px'});
	}
	$('#cd_produto_cmd-0').val(numClick);
	href2='&idproduto='+numClick;
    href1=($('#cd_comanda').val()!="")?'&idcomanda='+$('#cd_comanda').val():'';
	$('#cd_qtd_cmd_0').val("");
}
window.history.pushState(null,'Gerabar - Controle de comanda',getUrl()+'comanda-bar.php?cad=lancar-comanda'+href1+href2);
$('#cd_garcon').focus();
$('#busca_do_topo').html('').hide();
$('#i_busca_txt_tudo').val('');
}else{
window.location.href=$(this).attr('href');
}
}
return false;
});

//FUNÇÕES BARRA TOPO
$("#a_abre_menu_topo").on('click',function(){
	$('.d_aviso_erro').hide().children('p').html("");
	if($(this).attr('class')=="menu_topo_aberto"){
		$(this).attr('class','').css({'background-position':'right 12px'});
		$('.li_princ_menu ul').hide();
	}else{
		$(this).attr('class','menu_topo_aberto').css({'background-position':'right -13px'});
		$('.li_princ_menu ul').show();
	}
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

//CADASTRA CLIENTES
$('#troca_cadastros').on('click','#envia_clientes',function(){
	
	$('.d_aviso_erro').hide().children('p').html("");
	var nome=$("#cd_cliente_nome"),nascimento = $('#cd_cliente_data'),sexo=$('#cd_cliente_sexo'),tel=$('#cd_cliente_tel').val(),email=$("#cd_cliente_email"),
        cpf_cnpj,rg_estadual,tipoPessoa;		
	if($('#0-pessoa_fisica').attr('class')=='pessoa_ativo'){
		cpf_cnpj = $('#cliente_0_11').val();
        rg_estadual = $('#cliente_0_12').val();
        tipoPessoa="pessoa_fisica";
	}else{
		cpf_cnpj = $('#cliente_0_13').val();
        rg_estadual = $('#cliente_0_14').val();
        tipoPessoa="pessoa_juridica";
	}
if(nome.val()=="" || nome.val().length<4){
	$('#erro_cd_cliente_nome p').html("Nome em branco ou pequeno de mais !");
	$('#erro_cd_cliente_nome').show();
	nome.focus();
}else if(nascimento.val()==""){
	$('#erro_cd_cliente_data p').html("Data de nascimento está em branco !");
	$('#erro_cd_cliente_data').show();
	nascimento.focus();
}else if(sexo.val()==""){
	$('#erro_cd_cliente_sexo p').html("Selecione o sexo !");
	$('#erro_cd_cliente_sexo').show();
	sexo.focus();
}else if(email.val()!="" && er.test(email.val())==false){
	$('#erro_cd_cliente_email p').html("O e-mail informado é inválido !");
	$('#erro_cd_cliente_email').show();
	email.focus();
}else{
	
	$('#carregador').show();
	$.post('_php/cadastrar_dados.php',{cadastro:'clientes',nome:nome.val(),nascimento:nascimento.val(),sexo:sexo.val(),tipoPessoa:tipoPessoa,cpf_cnpj:cpf_cnpj,rg_estadual:rg_estadual,tel:tel,email:email.val()},function(dados){
		$('#carregador').hide();
		var ret=dados.split("|"),msg=ret[0],diverro=ret[1];
		if(diverro!="erro"){
			if(diverro!=""){
				$('#erro_'+diverro+' p').html(msg);
				$('#erro_'+diverro).show();
				$("#"+diverro).focus();
			}else{
				
				if($('.cadastro_ativo').attr('id')=="liClienteConta"){
					window.history.pushState(null,'Gerabar - Conta de Cliente',getUrl()+'contas-clientes.php?cad=contas-abertas&cliente='+ret[2]+'&cod='+msg);
					$('#liClienteConta').hide().removeClass('cadastro_ativo');
					$('#liAbaCtCli').addClass('cadastro_ativo');
					$('#carregador').show();
					$('#troca_cadastros').html('');
					$.post('_include/contas-produtos.php',{inclui:true,cod:msg,cliente:ret[2]},function(retorno){
					$('#carregador').hide();
					$('#troca_cadastros').html(retorno);
					$('#i_nome_prod_contas').focus();				
					});
				}else{
				
					if($('#for_cadCliente_caixa').attr('class')=="ativo"){
					var clienteCaixa=true;
					}else{
					clienteCaixa=false;
					$('#dentroOk').html("Cliente cadastrado com sucesso !").fadeIn(150);
					setTimeout(function(){$('#dentroOk').fadeOut(200,function(){$('#dentroOk').html("");});},1500);					
					}						
					$('#troca_cadastros').html('');
					$('#loadingOne').show();
					$.post('_include/cadastro_clientes.php',function(pagina){
						$('#loadingOne').hide();							
						if(clienteCaixa==true){
						$('#carregador').show();
						$.post('_include/loading-interno.php',{novaCmd:true,nomeCliente:nome.val(),idCliente:msg},function(data){
						$('#carregador').hide();
						$('#fundo_branco').html(data).fadeIn(150);
						$('#cmd_cad_cliente').focus();
						$('#troca_cadastros').html('<div id="for_cadCliente_caixa" class="ativo">'+pagina+'</div>');
						});
						}else{
						$('#troca_cadastros').html(pagina);
						$("#cd_cliente_nome").focus();
						}
					});
				
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

$('body').on('click','.muda_pessoa',function(){			
	var ret=$(this).parents('.div_tipo_pessoa').attr('id').split("_"),nume=ret[0];
	if($(this).attr('id')=='s_aberto_muda'){
		$(this).attr('id','');
		$('#ul_qual_pessoa_'+nume).css({
			border:'0',
			padding:'4px 4px 4px 0'
		}).children('li:last').slideUp(150);
		$('#ul_qual_pessoa_'+nume+' li span').removeClass('s_form_pessoa');
	}else{
		$('.form_tipo_pessoa ul').css({
			border:'0',
			padding:'4px 4px 4px 0'
		}).children('li.ult_pessoa').slideUp(150);
		$('.muda_pessoa').attr('id','');
		$(this).attr('id','s_aberto_muda');
		$('#ul_qual_pessoa_'+nume).css({
			border:'1px solid #888',
			padding:'3px'
		}).children('li:last').slideDown(150);
		$('.form_tipo_pessoa ul li span').removeClass('s_form_pessoa');
		$('#ul_qual_pessoa_'+nume+' li span').addClass('s_form_pessoa');
	}			
});

$('body').on('click','.form_tipo_pessoa ul li span',function(){			
	var ret=$(this).parents('.div_tipo_pessoa').attr('id').split("_"),nume=ret[0];
	if($('.muda_'+nume).attr('id')=='s_aberto_muda'){			
		var txt1 = $(this).html(),txt2 = $('#ul_qual_pessoa_'+nume+' li:first').children('span').html();
		if(txt1!=txt2){
			$('#ul_qual_pessoa_'+nume+' li').removeClass('ult_pessoa');
			$('#ul_qual_pessoa_'+nume+' li:last').addClass('ult_pessoa');
			$('#'+nume+'-pessoa_juridica').removeClass('pessoa_ativo');
			$('#'+nume+'-pessoa_fisica').removeClass('pessoa_ativo');					
			$('#ul_qual_pessoa_'+nume+' li:first').children('span').html(txt1);
			$(this).html(txt2);
			if(txt1=="Física"){
				$('#'+nume+'-pessoa_juridica').hide();
				$('#'+nume+'-pessoa_fisica').addClass('pessoa_ativo').show();
				$('#cliente_'+nume+'_11').focus();
			}else{
				$('#'+nume+'-pessoa_fisica').hide();
				$('#'+nume+'-pessoa_juridica').addClass('pessoa_ativo').show();
				$('#cliente_'+nume+'_13').focus();
			}					
		}				
		$('.muda_pessoa').attr('id','');
			$('#ul_qual_pessoa_'+nume).css({
				border:'0',
				padding:'4px 4px 4px 0'
			}).children('li:last').slideUp(150);
			$('#ul_qual_pessoa_'+nume+' li span').removeClass('s_form_pessoa');
	}
});
});
function getValorComanda(){
	if($('.valorDeCada').html()!=undefined){
		var valTopo = $('.valorDeCada').html().split("|");
		$('.sp_cmd_val-1').html(valTopo[0]);
	}
}
// JAVA CAIXA
$(function(){
//ABAS JANELAS DO CAIXA
$('#cont_cadastros').on('click','.aba-caixa-bar a',function(){
		if($(this).attr('id')=="aLiMais"){ return false;}
		if(window.history.pushState){
		var cad = $(this).attr('class'),texto;	
		$('.aba-caixa-bar li').removeClass('cadastro_ativo');
		if($(this).attr('id')=="abaLink"){
		$('#linkAbaCliente').addClass('cadastro_ativo');
		}else{		
		$(this).parent('li').addClass('cadastro_ativo');
		}
		if(cad=="comanda-cliente"){
			texto="Comanda de cliente";
		}else if(cad=="cadastro-clientes"){
			texto="Cadastrar novo cliente";
		}else if(cad=="comandas-abertas"){
			texto="Comandas em aberto";
		}else if(cad=="comandas-fechadas"){
			texto="Comandas fechadas";
		}else if(cad=="contas-fechadas" || cad=="contas-abertas" || cad=="cadastro-clientes-contas" || cad=="novas-contas"){
			texto="Contas de clientes";
			$('#div_busca_conta').hide();
		}else if(cad=="opcao-mesa"){
			texto="Opções de mesa";
		}else if(cad=="mesas-fechadas"){
			texto="Mesas fechadas";
		}else{
			texto="Controle de comanda bar";
		}
		if(cad=="contas-fechadas" || cad=="contas-abertas" || cad=="novas-contas"){
			$('#liClienteConta').hide();
			menuCaixa();
		}
		window.history.pushState(null,'Gerabar - '+texto,$(this).attr('href'));
		$('#h_cadastros').html(texto);
		$('#troca_cadastros').html('');
		$('#loadingOne').show();
		var carreCad=(cad=="cadastro-clientes-contas")?"cadastro-clientes":cad;
		$.post('_include/'+carreCad+'.php',{inclui:true},function(pagina){
			$('#loadingOne').hide();
			$('#troca_cadastros').html(pagina);
			if(cad=="comanda-cliente"){
				$('#cd_cliente_busca_cliente').focus();
			}else if(cad=="cadastro-clientes" || cad=="cadastro-clientes-contas"){
				$('#cd_cliente_nome').focus();
			}else if(cad=="consulta-comanda" || cad=="consulta-mesa" || cad=="opcao-mesa"){
				$('#cd_consulta_cmd').focus();
			}else if(cad=="comanda-mesa"){
				$('#bc_cmd_mesa').focus();
			}else if(cad=="lancar-comanda"){
				$('#cd_garcon').focus();
			}else if(cad=="novas-contas"){
				$('#val_nova_conta').focus();
			}
            rolarBaixo();
		});
		return false;
		}	
});

//CONSULTA COMANDA CAIXA/BAR
	$('#troca_cadastros').on('click','#envia_cmd_consulta',function(){
		
		$('.d_aviso_erro').hide().children('p').html("");
		var consultaCmd=$('#cd_consulta_cmd'),arraCmd=[],linkAlt;
		if(consultaCmd.val()==""){
		$('#erro_consulta_cmd p').html("Campo de consulta está em branco !");
			$('#erro_consulta_cmd').show();
			consultaCmd.focus();
		}else{
			
			if($('#cd_consulta_cmd').attr('class')=="caixa_consulta_cmd"){
			$('#tudo_busc_cliente_caixa').hide();
			$('#tudo_cmd_tudo_mesa').hide();
			$('#voltarPagarCx').hide();
            linkAlt=($('#cont_consulta_cmd').attr('class')=="busca_comanda_mesa")?'opcao-mesa&idMesa='+parseInt(consultaCmd.val()):'comanda-cliente&fecharcomanda='+consultaCmd.val();
            window.history.pushState(null,'Gerabar - Opção de caixa',getUrl()+'caixa.php?cad='+linkAlt);
			}
			$('#loadingOne').show();
			$('#cont_consulta_cmd').html("");
			arraCmd.push(consultaCmd.val());			
			$.get('_php/carrega-busca.php',{busca_cmd_bar:$('#cont_consulta_cmd').attr('class'),arraCmd:arraCmd},function(retorno){			
			$('#loadingOne').hide();
			$('#cont_consulta_cmd').html(retorno);			
			if($('#mosta_total_cmd').attr('class')=="0"){
				var valTopo = $('.valorDeCada').html().split("|"),countLi=parseInt($('#countLinha').html()),qualLi;
				for(var i=0;i<countLi;i++){
				qualLi=i+1;
				$('.sp_cmd_val-'+qualLi).html(valTopo[i]);
				}
			}
			if($('#cd_consulta_cmd').attr('class')=="caixa_consulta_cmd"){
				$('#voltarPagarCx').show();	
				if($('#mosta_total_cmd').attr('class')=="0"){
				$('#juntarPagaCx,#pagarTelaCx,#descontarCx').show();
                if($('#cont_consulta_cmd').attr('class')=="busca_comanda_mesa"){
                $('.volta_mesas').css({'margin-left':'10px'});
                }else{
                $('#voltarPagaCx').css({'margin-left':'10px'});
				$('#transferirConta').show();
                }
				}else{
					if($('#cont_consulta_cmd').attr('class')=="busca_comanda_mesa"){
					$('.volta_mesas').css({'margin-left':'10px'});
					}else{
					$('#mosta_total_cmd div').css({'margin-left':'55px'});			
					$('#voltarPagaCx').css({'margin-left':'55px'});
                    $('#transferirConta').hide();
					}
                    $('#juntarPagaCx,#pagarTelaCx,#descontarCx').hide();
				}
			}
            rolarBaixo();
			});
		}
		return false;
	});
	
	$('body').on('mouseover','.d_mostra_garcon span',function(e){
		var posicaoAlt = e.clientY;
		pairaGarcon = setTimeout(function(self){
			var mostra_g=$(self).parents('.d_mostra_garcon').children('.mostra_garcon'),codFunc=$(self).parents('.d_mostra_garcon').children('.pega_mostra_garcon').html();
			if(posicaoAlt>480){
			mostra_g.css({'top':'-100px'}).children('.ponta-info-func').css({'top':'89px','background-position':'0 bottom'});
			}
			mostra_g.show();
			$.get('_include/loading-interno.php',{mostraFunc:codFunc},function(data){
				mostra_g.removeClass('loading-garcon').children('.cont-garcon').html(data);
			});
			},350,this);
		});
		
		$('body').on('mouseout','.d_mostra_garcon span',function(){
			clearTimeout(pairaGarcon);
			$('.mostra_garcon').hide().addClass('loading-garcon').css({'top':'32px'}).children('.ponta-info-func').css({'top':'-11px','background-position':'0 top'});
			$('.cont-garcon').html("");
		});
		
//TUDO FUNDO BRANCO MAIN
//OPCOES DE COMANDA ABRIR/FECHAR/PAGAR

	$('body').on('click','.a_abrir_cmd',function(){
		$('.d_aviso_erro').hide().children('p').html("");
		$('#carregador').show();
        var idCliente,nomeCliente;
		if($(this).parents('li').attr('class')=="li_cliente_busc"){
            idCliente=$(this).parents('li').children('div').children('h2').attr('class');
            nomeCliente=$(this).parents('li').children('div').children('h1').html();	
		$('#busca_do_topo').html('').hide();
		$('#i_busca_txt_tudo').val('');
		}else{
            idCliente=$(this).parents('li').attr('class');
            nomeCliente=$(this).parents('li').children('.li_nome_busc').html();
		}
		$.post('_include/loading-interno.php',{novaCmd:true,nomeCliente:nomeCliente,idCliente:idCliente},function(data){
		$('#carregador').hide();
		$('#fundo_branco').html(data).fadeIn(150);
		$('#cmd_cad_cliente').focus();
		});
	});
	
	$('body').on('click','#cancelar-cmdAdd a, #cancelar-subBusca a',function(){
	$('.d_aviso_erro').hide().children('p').html("");
	$('#fundo_branco').fadeOut(200,function(){$('#fundo_branco').html("");});
	
	if($('#i_subBuscaEnvia').attr('class')===undefined){
	$('#cd_cliente_busca_cliente').focus();
	}else{
	$('#'+$('#i_subBuscaEnvia').attr('class')).focus();
	}
	
	});
	
	//DESCONTAR DE COMANDA E MESA
	$('#troca_cadastros').on('click','#descontarCx a',function(){
		finaliza_desconto();
	});	
	
	$('body').on('keyup','#money-descontar',function(e){
	if((window.event)?event.keyCode:e.which!=13){
	$('.d_aviso_erro').hide().children('p').html("");
	var total = parseFloat($('.val-payCount').html().replace(/[.]/g,"").replace(",","."))-parseFloat($(this).val().replace(/[.]/g,"").replace(",",".")),novoVal,ultimo,valFinal;
	if(total<0){
	$('#valTroco-payCount').html('0,00');
	$('#salvaMoneyTroco').val('0.00');
	}else{
	$('#salvaMoneyResto').val(total);
	var novoValor = $('#salvaMoneyResto').val().replace(".",",");
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
	$('#valTroco-payCount').html(valFinal);
	}
	}
	});
	
	$('body').on('click','#final-descontar-payCount',function(){
		$('.d_aviso_erro').hide().children('p').html("");
		var valPagar = $('.val-payCount').html().replace(/[.]/g,"").replace(",","."),valPago=$('#money-descontar'),contCmd;
		if(parseFloat(valPago.val().replace(/[.]/g,"").replace(",","."))<=0){
		$('#erro_money-descontar p').html("Coloque o valor a ser descontado !");
		$('#erro_money-descontar').show();
		valPago.focus();
		}else if(parseFloat(valPagar)<parseFloat(valPago.val().replace(/[.]/g,"").replace(",","."))){
		$('#erro_money-descontar p').html("Valor é maior do que o valor a ser pago !");
		$('#erro_money-descontar').show();
		valPago.focus();
		}else{
			var certoDesc=false,qlCmdMesa=$('#descontarCx a').attr('class');
			if($('#descontarCx').attr('class')=="descontaConta"){
			contCmd='|'+$('#d_cadastro_produto').attr('class');
			certoDesc=true;
			qlCmdMesa=qlCmdMesa+'|'+$('.idContaCliente').val();
			}else{
				var countLi=parseInt($('#countLinha').html());
				if(countLi>1){
				$('#alert-cima p').html("Só é possível descontar de uma comanda !");
				$('#alert').show();
				$('#spanalert a').focus();
				}else{
				contCmd='|'+$('.sp_cmd_pegar-1').html();
				certoDesc=true;
				}
			}
			if(certoDesc==true){			
			$('#fundo_branco').html("").hide();
			$('#carregador').show();
			$.post('_include/loading-interno.php',{pagarCmd:true,totalCmd:valPago.val(),idCliente:contCmd,qlCmdMesa:qlCmdMesa},function(data){
			$('#carregador').hide();
			$('#fundo_branco').html(data).fadeIn(150);
			});
			}
			
		}
		return false;
	});
	//PAGAMENTO DE COMANDA
	$('#troca_cadastros').on('click','#pagarTelaCx a',function(){
		finaliza_cmd_mesa();
	});
	
	$('body').on('click','#cancelar-juntaCmd a',function(){
	$('#fundo_branco').fadeOut(200,function(){
		$('#fundo_branco').html("");
		$('#cd_consulta_cmd').focus();
	});
	});
	
	$('body').on('click','#envia_cmd_cad_cliente',function(){
		$('.d_aviso_erro').hide().children('p').html("");
		var comanda=$('#cmd_cad_cliente').val().trim(),
            pagarEntrada=$('#pagar_cad_cliente').val().trim(),
            opcEntrada=$('#opc_cmd_cliente').val().trim(),
            pedagio=$('#pedagio_cad_cliente').val().trim(),
            valPedagio=$('#val_pedagio_cad_cliente').val().trim(),
            contaEntrada=(parseInt($('#opc_cmd_cliente').children('option').length)-1);
		if(comanda==""){
		$('#erro_cmd_cad_cliente p').html("Comanda está em branco !");
		$('#erro_cmd_cad_cliente').show();
		$('#cmd_cad_cliente').focus();
		}else if(isNaN(comanda)){
		$('#erro_cmd_cad_cliente p').html("Coloque apenas números !");
		$('#erro_cmd_cad_cliente').show();
		$('#cmd_cad_cliente').focus();
		}else if(comanda.length<2){
		$('#erro_cmd_cad_cliente p').html("Coloque pelo menos dois números !");
		$('#erro_cmd_cad_cliente').show();
		$('#cmd_cad_cliente').focus();
		}else if(pagarEntrada=="" && contaEntrada>0){
		$('#erro_pagar_cad_cliente p').html("Pagar comanda na entrada sim ou não ?");
		$('#erro_pagar_cad_cliente').show();
		$('#pagar_cad_cliente').focus();
		}else if(opcEntrada=="" && contaEntrada>0){
		$('#erro_opc_cmd_cliente p').html("Escolha uma opção de entrada !");
		$('#erro_opc_cmd_cliente').show();
		$('#opc_cmd_cliente').focus();
		}else if(pedagio==""){
		$('#erro_pedagio_cad_cliente p').html("Por favor, escolha uma opção de vale !");
		$('#erro_pedagio_cad_cliente').show();
		$('#pedagio_cad_cliente').focus();
		}else{
			if(pedagio=="sim"){
			var passarPedagio=false;
			if(valPedagio=="" || valPedagio=="0,00"){
			$('#erro_val_pedagio_cad_cliente p').html("Por favor, coloque o valor do vale !");
			$('#erro_val_pedagio_cad_cliente').show();
			$('#val_pedagio_cad_cliente').focus();
			}else{
            passarPedagio=true;
			}
			}else{
			passarPedagio=true;
			}			
			if(passarPedagio==true){
			$('#carregador').show();
			$.post('_php/cadastrar_dados.php',{cadastro:'cad_comanda_cliente',comanda:comanda,contaEntrada:contaEntrada,pagarEntrada:pagarEntrada,opcEntrada:opcEntrada,pedagio:pedagio,valPedagio:valPedagio.replace(/[.]/g,"").replace(",","."),idCliente:$('#add_nome_cmd').attr('class')},function(dados){
				$('#carregador').hide();
				var ret=dados.split('|'),msg=ret[0],diverro=ret[1];
				if(diverro!="erro"){
					if(diverro!=""){
						$('#erro_'+diverro+' p').html(msg);
						$('#erro_'+diverro).show();
						$("#"+diverro).focus();
					}else{
						$('#dentroOk').html(msg).fadeIn(150);
						setTimeout(function(){$('#dentroOk').fadeOut(200,function(){ $('#dentroOk').html("");});},1500);
						$('#fundo_branco').hide().html("");
                        if($("#qualPaginaAtivo").html()=="comanda-bar"){
                            if($('#cont_form_comanda').attr('class')=="comanda"){
                            window.history.pushState(null,'Controle de comanda',getUrl()+'comanda-bar.php?cad=lancar-comanda&idcomanda='+comanda);
                            $('#cd_comanda').val(comanda);
                            $('#cd_garcon').focus();
                            }
                        }else if($('.cadastro_ativo a').attr('class')=="comanda-cliente"){
						$('#topo_resc_busc_cliente').hide();
						$('#ul_resc_busc_cliente').html('<li id="carrega_busc_cliente"></li>').hide();
						$('#tudo_cmd_cliente_caixa').show();
						$('#cd_cliente_busca_cliente').val("").focus();
						}else{$("#cd_cliente_nome").focus();}
						
						$('#voltarBuscaTelaCx').hide();
					}
				}else{
					$('#alert-cima p').html(msg);
					$('#alert').show();
					$('#spanalert a').focus();
				}
			});
			}
		}
		return false;
	});
    
    
	$('body').on('click','#transferirConta a,#s_transferir_frente a',function(){
        var qualTrans=$(this).parent('span').attr('id'),countLi=1,Cmd="frente_caixa",valorTotal,passaTrans=true;
        if(qualTrans=="transferirConta"){
        Cmd=$('.sp_cmd_pegar-1').html();    
        countLi=parseInt($('#countLinha').html());
        valorTotal=$('#valTotalComanda').html();
        }else{
        var valSplit=$('#d_valorTotal').html().split(' ');
        valorTotal=valSplit[1];
        if($('#ulmostraprod li').length==0 || $('.val_cx_aberto').attr('id')!=undefined){passaTrans=false;}
        }
         
        if(passaTrans==true){
            $('.d_aviso_erro').hide().children('p').html("");
            if(countLi>1){
                $('#alert-cima p').html("Apenas uma comanda pode ser transferida !");
                $('#alert').show();
                $('#spanalert a').focus();
            }else{
                $('#carregador').show();
                $.get('_include/loading-interno.php',{tranfCmd:Cmd,totalCmd:valorTotal},function(data){
                $('#carregador').hide();
                $('#fundo_branco').html(data).fadeIn(150,function(){ if(qualTrans=="s_transferir_frente"){ $('#i_subBuscaTxt').focus();} });
                });
            }
        }
	});
	
	$('body').on('click','#cancelar-tranferi a',function(){
	$('#fundo_branco').fadeOut(200,function(){
		$('#fundo_branco').html("");
		$('#cd_consulta_cmd').focus();
	});
	});
	
	$('body').on('click','#s_escTransf a',function(){
		$('#d_transfere').hide();
		$('#carregador').show();
		$('#tranferi-dentro').animate({'height':'+=100px','margin-bottom':'-=50px','margin-top':'-=50px'},200);
		$('#tranferi-cima').animate({'height':'+=100px'},200);
		$.get('_php/carrega-listas.php',{buscaTransfere:true},function(retorno){
		$('#voltar-tranferi').show();
		$('#d_outroTransfere').html(retorno).show();
		$('#i_subBuscaTxt').focus();
		$('#carregador').hide();
		});
	});
	
	$('body').on('click','#voltar-tranferi a',function(){
		$('#tranferi-dentro').animate({'height':'-=100px','margin-bottom':'+=50px','margin-top':'+=50px'},300);
		$('#tranferi-cima').animate({'height':'-=100px'},300);
		$('#d_outroTransfere').slideUp(250);
		$('#d_transfere').slideDown(180,function(){
			$('#d_outroTransfere').html('');		
		});
		$('#voltar-tranferi').hide();		
	});
	
	$('#troca_cadastros').on('click','#envia_busc_cliente',function(e){
	buscaClienteCmd(e);
	return false;
	});
	
	$('#troca_cadastros').on('keyup','#cd_cliente_busca_cliente',function(e){		
	buscaClienteCmd(e);
	return false;
	});
	
	function buscaClienteCmd(e){
	$('.d_aviso_erro').hide().children('p').html("");
	if(e.which==1){	var tecla=1;}else{var tecla=(window.event)?event.keyCode:e.which;}
	tecla=(window.event)?event.keyCode:e.which;
	if((tecla<33 || tecla>36) && (tecla<16 || tecla>18) && (tecla!=37 && tecla!=38 && tecla!=39 && tecla!=40 &&  tecla!=0 && tecla!=9 && tecla!=20 && tecla!=255)){
	clearTimeout(pararBusca);
	var termo = $('#cd_cliente_busca_cliente').val(),busq = termo.trim();
	if(busq.length==0){		
		if(termo.length==0){
		$('#topo_resc_busc_cliente').hide();
		$('#ul_resc_busc_cliente').html('<li id="carrega_busc_cliente"></li>').hide();
		$('#tudo_cmd_cliente_caixa').show();
		$('#voltarBuscaTelaCx').hide();
		$('#sem_cliente_bus_cx').hide();
		}else{
		$('#erro_cd_cliente_busca_cliente p').html("Campo de busca está em branco !");
		$('#erro_cd_cliente_busca_cliente').show();
		$('#cd_cliente_busca_cliente').focus();
		}
	}else{	
		$('#topo_resc_busc_cliente').hide();
		$('#sem_cliente_bus_cx').hide();
		$('#voltarBuscaTelaCx').hide();
		$('#tudo_cmd_cliente_caixa').hide();		
		if($('#carrega_busc_cliente').html()==""){
		$('#ul_resc_busc_cliente').show();
		}else{
		$('#ul_resc_busc_cliente').html('<li id="carrega_busc_cliente"></li>').show();
		}
		pararBusca=setTimeout(function(){		
		$.get('_php/carrega-busca.php',{busca_cliente_caixa:busq},function(retorno){			
			$('#voltarBuscaTelaCx').show();
			if(retorno==""){
			$('#sem_cliente_bus_cx').show();
			$('#topo_resc_busc_cliente').hide();
			$('#ul_resc_busc_cliente').html('<li id="carrega_busc_cliente"></li>').hide();
			}else{
			$('#topo_resc_busc_cliente').show();
			$('#ul_resc_busc_cliente').html(retorno);
            rolarBaixo();
			}
			$('#cd_cliente_busca_cliente').focus();
            
		});		
		
		},200);		
	}
	}
	return false;
	}
	
	$('#troca_cadastros').on('click','#voltarBuscaCx a',function(){	
	$('.d_aviso_erro').hide().children('p').html("");
	
	$('#topo_resc_busc_cliente').hide();
	$('#ul_resc_busc_cliente').html('<li id="carrega_busc_cliente"></li>').hide();
	$('#tudo_cmd_cliente_caixa').show();
	$('#cd_cliente_busca_cliente').val("").focus();
	
	$('#voltarBuscaTelaCx').hide();
	$('#sem_cliente_bus_cx').hide();
	});
	
	//COMEÇO JAVA FAZER PAGAMENTO
	$('body').on('click','#cancelar-payCount a',function(){
		$('.d_aviso_erro').hide().children('p').html("");
		$('#fundo_branco').fadeOut(200,function(){$('#fundo_branco').html("");});
	});	
	$('body').on('click','#cartao-payCount',function(){		
		if($(window).outerWidth()<=440){
		$('#payCount-dentro').animate({'height':'+=90px','margin-bottom':'-=45px','margin-top':'-=45px'},400);
		$('#payCount-cima').animate({'height':'+=90px'},400);
		}else{		
		$('#payCount-dentro').animate({'height':'+=140px','margin-bottom':'-=70px','margin-top':'-=70px'},400);
		$('#payCount-cima').animate({'height':'+=140px'},400);
		}
		$('#forma-payCount').slideUp(500);
		$('#card-payCount').slideDown(500);
		$('#card-formPaga').focus();
		$('#voltar-payCount').show();	
	});
	
	$('body').on('click','#dinheiro-payCount',function(){		
		if($(window).outerWidth()<=440){
		$('#payCount-dentro').animate({'height':'+=90px','margin-bottom':'-=45px','margin-top':'-=45px'},400);
		$('#payCount-cima').animate({'height':'+=90px'},400);
		}else{		
		$('#payCount-dentro').animate({'height':'+=140px','margin-bottom':'-=70px','margin-top':'-=70px'},400);
		$('#payCount-cima').animate({'height':'+=140px'},400);
		}
		$('#forma-payCount').slideUp(500);
		$('#money-payCount').slideDown(500);
		$('#money-pago').focus();
		$('#money-pago').val('0,00');
		$('#voltar-payCount').show();	
	});
	
	$('body').on('click','#voltar-payCount a',function(){
		$('.d_aviso_erro').hide().children('p').html("");
		
		if($(window).outerWidth()<=440){
		$('#payCount-dentro').animate({'height':'-=90px','margin-bottom':'+=45px','margin-top':'+=45px'},300);
		$('#payCount-cima').animate({'height':'-=90px'},300);
		}else{		
		$('#payCount-dentro').animate({'height':'-=140px','margin-bottom':'+=70px','margin-top':'+=70px'},300);
		$('#payCount-cima').animate({'height':'-=140px'},300);
		}
		
		$('#money-payCount').slideUp(500);
		$('#card-payCount').slideUp(500);
		$('#forma-payCount').slideDown(500,function(){
			$('#valTroco-payCount').html('0,00');
		document.getElementById("card-formPaga").selectedIndex=0;
		$('#card-autoriza').val("");
		});
		$('#voltar-payCount').hide();		
	});
	
$('body').on('keyup','#money-pago',function(e){		
	if((window.event)?event.keyCode:e.which!=13){		
	$('.d_aviso_erro').hide().children('p').html("");
	var total = parseFloat($(this).val().replace(/[.]/g,"").replace(",","."))-parseFloat($('.val-payCount').html().replace(/[.]/g,"").replace(",",".")),novoVal,ultimo,valFinal;
	if(total<0){
	$('#valTroco-payCount').html('0,00');
	$('#salvaMoneyTroco').val('0.00');
	}else{
	$('#salvaMoneyTroco').val(total);
	var novoValor = $('#salvaMoneyTroco').val().replace(".",",");
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
	$('#valTroco-payCount').html(valFinal);
	}
	}
});
	
$('body').on('click','#final-money-payCount',function(){
	$('.d_aviso_erro').hide().children('p').html("");
	var valPagar = $('.val-payCount').html().replace(/[.]/g,"").replace(",","."),valPago=$('#money-pago');			
	if(parseFloat(valPagar)>parseFloat(valPago.val().replace(/[.]/g,"").replace(",","."))){			
	$('#erro_money-pago p').html("Valor é menor do que o valor a ser pago !");
	$('#erro_money-pago').show();
	valPago.focus();
	}else{
	$('#carregador').show();
	payTodaCount($('#idCliente-payCount').val(),1,valPago.val().replace(/[.]/g,"").replace(",","."),"",$('#quantIdConta').val());
	}
	return false;
});		

$('body').on('click','#final-card-payCount',function(){
	$('.d_aviso_erro').hide().children('p').html("");
	var tipoPaga=$('#card-formPaga');
	if(tipoPaga.val()==""){
	$('#erro_card-formPaga p').html("Selecione a forma de pagamento !");
	$('#erro_card-formPaga').show();
	tipoPaga.focus();
	}else{
	$('#carregador').show();
	payTodaCount($('#idCliente-payCount').val(),2,tipoPaga.val(),$('#card-autoriza').val(),$('#quantIdConta').val());
	}
	return false;
});
    
function zeroEsquerda(varData){	
    return (varData<10)?'0'+varData:varData;
}
    
function reabrirCaixa(){
    setTimeout(function(){$('#dentroOk').fadeOut(200,function(){
        $('#dentroOk').html("");
        $('#li_abrir_fecha_caixa').attr('class','a_abrir_caixa').attr('title','Abrir Caixa');
        $('#li_abrir_fecha_caixa .span_abre').html('Abrir Caixa');
        $('#carregador').show();
        $.post('_include/loading-interno.php',{abrirCaixa:true,abrirFecharCx:'reabrir_caixa'},function(data){
        $('#carregador').hide();    
        $('#fundo_branco').html(data).fadeIn(150);
        $('#i_troco_cx').focus();
        });
    });},1500);
}

function payTodaCount(numComanda,formaPagamento,pagoCartao,autorizaCartao,dadosExtras){
	var ExExtra,passaExtra;
	if(dadosExtras==""){
	passaExtra="";
	}else{
		ExExtra=dadosExtras.split('|');
		if(ExExtra[0]=="pagarMesa"){
		passaExtra="";
		}else{
		passaExtra=ExExtra[0];
		}
	}	
	if(passaExtra=="" && numComanda!="frente_caixa"){
		var countLi=parseInt($('#countLinha').html()),valCmd=[];
		valCmd.push('0');
		for(var i=1;i<=countLi;i++){	
		valCmd.push($('.sp_cmd_val-'+i).html().replace(/[.]/g,"").replace(",","."));
		}	
	}else{
		var valCmd=$('.val-payCount').html().replace(/[.]/g,"").replace(",",".");
	}
    
	$('#final-card-payCount').attr('disabled',true);
	$('#final-money-payCount').attr('disabled',true);
	$.post("_php/alterar_cadastros.php",{idComanda:numComanda,valCmd:valCmd,formaPagamento:formaPagamento,pagoCartao:pagoCartao,autorizaCartao:autorizaCartao,dadosExtras:dadosExtras},function(retorno){
        $('#carregador').hide();
		var retu=retorno.split('|'),msg=retu[0],erro=retu[1];
		if(erro=="" || erro=="limiteCaixa"){
			$('#fundo_branco').fadeOut(300,function(){$('#fundo_branco').html("");});			
            var txtPagoOk=(numComanda=="frente_caixa")?"Pagamento feito com sucesso !":"Conta paga com sucesso !";
			$('#dentroOk').html(txtPagoOk).fadeIn(150);
            if(erro!="limiteCaixa"){
            setTimeout(function(){$('#dentroOk').fadeOut(200,function(){$('#dentroOk').html("");});},1500);
            }
			if(numComanda=="frente_caixa"){
                $('#ulmostraprod').html('');
                $('#todo-frente-caixa').attr('class','');
                $('#codigoprinc,#nomeprinc').html('');
                $('#d_alt_unidade,#d_quant_volume').html('0');
                $('#d_val_unitario,#d_val_total,#d_desconto_frente,#d_valorTotal').html('<span>R$</span> 0,00');
                $('.d_hide_frente').removeClass('d_hide_frente');
                $('#divopcional1 span').addClass('desCursor');
                $('#primdivmostra,#ulmostraprod').hide();
                $('#busca_frente_caixa').val("");
                $('#d_cx_livre').show();
                
                if(erro=="limiteCaixa"){                
                $('#d_cx_livre h2').attr('class','cx-fechado').html('CAIXA FECHADO');
                $('#enviabusca1,#busca_frente_caixa').attr('disabled',true);
                $('#s_abrir_caixa').removeClass('desCursor').show();
                $('#s_finaliza_frente,#s_transferir_frente,#s_cancelar_cx').hide();
                reabrirCaixa();
                }else{
                $('#busca_frente_caixa').focus();
                }
                
            }else if(dadosExtras==""){
				$('#tudo_busc_cliente_caixa').show();
				$('#voltarPagarCx').hide();
				$('#cont_consulta_cmd').html("");
				$('#cd_cliente_busca_cliente').val("");
				$('#cd_consulta_cmd').val("");
				window.history.pushState(null,'Gerabar - Opção de caixa',getUrl()+'caixa.php?cad=comanda-cliente');
                if(erro=="limiteCaixa"){
                reabrirCaixa();
                }else{
                $('#cd_consulta_cmd').focus();
                }
			}else if(dadosExtras!="" && passaExtra==""){
				$('#troca_cadastros').html('');
				$('#loadingOne').show();
				$.post('_include/opcao-mesa.php',{inclui:true},function(pagina){
					$('#loadingOne').hide();
					$('#troca_cadastros').html(pagina);
                    if(erro!="limiteCaixa"){
					$('#cd_consulta_cmd').focus();
                    }
				});
                if(erro=="limiteCaixa"){
                reabrirCaixa();
                }
			}else{			
				var idQuant=dadosExtras.split('|');
				if(idQuant[1]!=""){
					
				if(idQuant[1]=="descontar"){
					var fordata=new Date(),valNovoCmd,
					dataCad=zeroEsquerda(fordata.getDate())+'/'+zeroEsquerda(fordata.getMonth()+1)+'/'+fordata.getFullYear()+' '+zeroEsquerda(fordata.getHours())+':'+zeroEsquerda(fordata.getMinutes())+':'+zeroEsquerda(fordata.getSeconds());						
					if(idQuant[0]=="conta"){
						valNovoCmd=parseFloat($('#car_val_total').attr('class'))-valCmd;
						var beforeInner=($('.inner-desconta').html()===undefined)?'inner-desconta':'inner-desc';						
						$('li.inner').before('<li class="'+beforeInner+'" id="'+msg+'-liDesc"><div class="d_produto_contas marginTopConta">VALOR DESCONTADO</div><div class="d_func_contas d_mostra_garcon"><span class="s_li_abreFecha_respansivo">nº func.:&nbsp;</span> <span class="pega_mostra_garcon">'+retu[2]+'</span><div class="mostra_garcon loading-garcon"><div class="ponta-info-func"></div><div class="cont-garcon"></div></div></div><div class="d_val_contas"><span class="s_li_abreFecha_respansivo">valor unit.:&nbsp;</span> R$ <span class="valParaPagar">-'+number_format(valCmd,2,',','.')+'</span></div><div class="d_quant_contas"><span class="s_li_abreFecha_respansivo">quant.:&nbsp;</span> <span class="quantParaPagar">1</span></div><div class="d_valtotal_contas"><span class="s_li_abreFecha_respansivo">valor total:&nbsp;</span> R$ <span class="valProdConta">-'+number_format(valCmd,2,',','.')+'</span></div><div class="d_data_contas">'+dataCad+'</div><div class="d_acao_contas"><span class="s_delete_conta"><a href="javascript:void(0);" title="Excluir" class="addImgDel"><!--excluir--></a></span></div></li>');
						$('#car_val_total').attr('class',valNovoCmd).html(number_format(valNovoCmd,2,',','.'));
					}else{
						valNovoCmd=parseFloat($('#valTotalComanda').attr('class'))-valCmd;
						$('.ul_consulta_cmd').append('<li id="liCmdDesc-'+msg+'" class="0"><div class="li_tp_produto">VALOR DESCONTADO</div><div class="li_tp_garcon d_mostra_garcon"><span class="s_li_tp_respansivo">garçon:&nbsp;</span> <span class="pega_mostra_garcon">'+retu[2]+'</span><div class="mostra_garcon loading-garcon"><div class="ponta-info-func"></div><div class="cont-garcon"></div></div></div><div class="li_tp_valUnitario"><span class="s_li_tp_respansivo">valor unit.:&nbsp;</span> R$ -'+number_format(valCmd,2,',','.')+'</div><div class="li_tp_quant"><span class="s_li_tp_respansivo">quant.:&nbsp;</span> <span class="numQuantDel">1</span></div><div class="li_tp_valTotal"><span class="s_li_tp_respansivo">valor total:&nbsp;</span> R$ <span id="pegaCmdValDesc-'+msg+'" class="-'+valCmd+'">-'+number_format(valCmd,2,',','.')+'</span></div><div class="li_tp_dataHora">'+dataCad+'</div><div class="li_tp_acao"><a href="javascript:void(0);" id="'+msg+'-1-descontarId" class="cmd_delete" title="Excluir desconto da comanda"></a></div></li>');
						$('#valTotalComanda').attr('class',valNovoCmd).html(number_format(valNovoCmd,2,',','.'));
						$('.sp_cmd_val-1').html(number_format(valNovoCmd,2,',','.'));
					}
                    if(erro=="limiteCaixa"){
                    reabrirCaixa();
                    }
					return false;
				}else{
				var quantTotal = parseInt($('#'+idQuant[0]+'-li').children('.d_quant_contas').children('.quantParaPagar').html()),valorAltera=$('#'+idQuant[0]+'-li').children('.d_val_contas').children('.valParaPagar').html().replace(/[.]/g,"").replace(",",".");			
				if(quantTotal==idQuant[1]){
					$('#'+idQuant[0]+'-li').remove();
				}else{
					var novaQuant = parseInt(quantTotal)-parseInt(idQuant[1]);
					$('#'+idQuant[0]+'-li').children('.d_quant_contas').children('.quantParaPagar').html(novaQuant);
					$('#'+idQuant[0]+'-li').children('.d_valtotal_contas').children('.valProdConta').html(number_format(parseFloat(valorAltera)*(novaQuant),2,',','.'));
				}
				var altValTotal=parseFloat($('#car_val_total').attr('class'))-(parseInt(idQuant[1])*parseFloat(valorAltera));
				
				$('#car_val_total').attr('class',altValTotal).html(number_format(altValTotal,2,',','.'));
				if($('li.li-inner').length==0){$('#pagarContaTotal,#descontarCx').hide();}
                if(erro=="limiteCaixa"){
                reabrirCaixa();
                }
				}
				}else{
					if($('#pagarContaTotal').attr('class')=="s_fecha_conta"){
						window.history.pushState(null,'Gerabar - Conta de clientes',getUrl()+'contas-clientes.php?cad=contas-abertas');
						$('#troca_cadastros').html('');
						$('#loadingOne').show();
						$.post('_include/contas-abertas.php',{inclui:true},function(pagina){
							$('#loadingOne').hide();
							$('#troca_cadastros').html(pagina);
						});
                        if(erro=="limiteCaixa"){
                        reabrirCaixa();
                        }
					}else{
						if($('#ul_lista_contas li').length==1){
						$('#div_busca_conta').hide();
						$('.c_abre_nova_conta').hide();
						$('#d_mostrar_contas').html("").hide();
						$('#d_cadastro_nova_conta').show();
                        if(erro!="limiteCaixa"){
						$('#val_nova_conta').focus();
                        }
						}else{
						$('#ul_lista_contas li.'+numComanda).remove();
						}
                        if(erro=="limiteCaixa"){
                        reabrirCaixa();
                        }
					}
				}
			}
		}else{
		$('#alert-cima p').html(msg);
		$('#alert').show();
		$('#spanalert a').focus();
		$('#final-card-payCount').attr('disabled',false);
		$('#final-money-payCount').attr('disabled',false);
		}
	});
}

	//JUNTAR COMANDA CAIXA
	$('body').on('click','#envia_cmd_junta',function(){	
		$('.d_aviso_erro').hide().children('p').html("");
		var juntarCmd=$('#cmd_junta'),arraCmd=[],countLi=parseInt($('#countLinha').html()),cmdJunta='',qualCmdMesa=$('#cont_consulta_cmd').attr('class');
		if(juntarCmd.val()==""){
		$('#erro_cmd_junta p').html("Campo de consulta está em branco !");
		$('#erro_cmd_junta').show();
		juntarCmd.focus();
		}else{
			
			$('#carregador').show();
			$.get('_php/carrega-busca.php',{comanda:juntarCmd.val(),verficaCmd:qualCmdMesa},function(reto){
			$('#carregador').hide();
			var verCmd = reto.split('|');
			if(verCmd[1]=="erro"){
			$('#erro_cmd_junta p').html(verCmd[0]);
			$('#erro_cmd_junta').show();
			juntarCmd.focus();
			}else{
			if(juntarCmd.val().length==1){cmdJunta = '0';}
			for(var i=1;i<=countLi;i++){				
			if(cmdJunta+juntarCmd.val()==$('.sp_cmd_pegar-'+i).html()){
			$('#erro_cmd_junta p').html("Comanda buscada já está para pagar !");
			$('#erro_cmd_junta').show();
			juntarCmd.focus();
			return false;
			}
			arraCmd.push($('.sp_cmd_pegar-'+i).html());
			}			
			arraCmd.push(juntarCmd.val());
			$('#voltarPagarCx').hide();
			$('#loadingOne').show();
			$('#cont_consulta_cmd').html("");
						
			$('#fundo_branco').fadeOut(200,function(){
				$('#fundo_branco').html("");
				$('#cd_consulta_cmd').focus();
			});

			$.get('_php/carrega-busca.php',{busca_cmd_bar:qualCmdMesa,arraCmd:arraCmd},function(retorno){			
			$('#loadingOne').hide();
			$('#cont_consulta_cmd').html(retorno);			
			$('#voltarPagarCx').show();
			var valTopo = $('.valorDeCada').html().split("|"),coutLi=parseInt($('#countLinha').html()),qualLi;
			for(var i=0;i<coutLi;i++){
			qualLi=i+1;
			$('.sp_cmd_val-'+qualLi).html(valTopo[i]);
			}
			$('#transferirConta').hide();
			});			
			} });			
		}
		return false;	
	});
	
	$('#troca_cadastros').on('click','.ct_acao a',function(){	
	var qualLinha = $(this).attr('id').split('-');
	if($(this).children('span').attr('class')=="s_mostrar"){
	$('.ul_consulta_cmd').hide();
	$('.ct_acao a').html('mostrar <span class="s_mostrar">comanda</span>');
	$(this).html('esconder <span class="s_esconder">comanda</span>');
	$('#tudo-'+qualLinha[1]).slideDown(300);
	}else{
	$(this).html('mostrar <span class="s_mostrar">comanda</span>');
	$('#tudo-'+qualLinha[1]).slideUp(300);
	}	
	});
	
	$('#troca_cadastros').on('click','#juntarPagaCx a',function(){
		$('.d_aviso_erro').hide().children('p').html("");
		$('#carregador').show();
		$.get('_include/loading-interno.php',{juntaCmd:$('#cont_consulta_cmd').attr('class')},function(data){
		$('#carregador').hide();
		$('#fundo_branco').html(data).fadeIn(150);
		$('#cmd_junta').focus();
		});	
	});
	
	$('#troca_cadastros').on('click','#voltarPagaCx a',function(){
	$('.d_aviso_erro').hide().children('p').html("");
	window.history.pushState(null,'Gerabar - Opção de caixa',getUrl()+'caixa.php?cad=comanda-cliente');
	$('#tudo_busc_cliente_caixa').show();
	$('#tudo_cmd_tudo_mesa').show();
	$('#voltarPagarCx').hide();
	$('#voltarPagaCx').css({'margin-left':'10px'});
	$('#cont_consulta_cmd').html("");
	$('#cd_cliente_busca_cliente').val("");
	$('#cd_consulta_cmd').val("").focus();	
	$('#transferirConta').show();
	});	
	
	$('body').on('click','.a_cmd_aberto',function(){
	$('.d_aviso_erro').hide().children('p').html("");
	var ret=$(this).attr('id').split("-"),cmd=ret[0],arraCmd=[];
	if($(this).parents('li').attr('class')=='li_cliente_busc'){		
	if($('.aba-caixa-bar li.cadastro_ativo a').attr('class')!='comanda-cliente'){	
	window.location.href=getUrl()+"caixa.php?cad=comanda-cliente&fecharcomanda="+cmd;
	return false;
	}
	$('#busca_do_topo').html('').hide();
	$('#i_busca_txt_tudo').val("");	
	}else{
	$('#topo_resc_busc_cliente').hide();
	$('#ul_resc_busc_cliente').html('<li id="carrega_busc_cliente"></li>').hide();
	$('#cd_cliente_busca_cliente').val("");
	$('#tudo_cmd_cliente_caixa').show();
	$('#voltarBuscaCx').hide();
	}	
	$('#cd_consulta_cmd').val(cmd).focus();	
	$('#tudo_busc_cliente_caixa').hide();
	$('#voltarPagarCx').hide();
	window.history.pushState(null,'Gerabar - Opção de caixa',getUrl()+'caixa.php?cad=comanda-cliente&fecharcomanda='+cmd);
	$('#loadingOne').show();
	$('#cont_consulta_cmd').html("");
	arraCmd.push(cmd);
	$.get('_php/carrega-busca.php',{busca_cmd_bar:'busca_comanda_bar',arraCmd:arraCmd},function(retorno){
	$('#loadingOne').hide();
			$('#cont_consulta_cmd').html(retorno);
			if($('#mosta_total_cmd').attr('class')=="0"){
				var valTopo = $('.valorDeCada').html().split("|"),countLi=parseInt($('#countLinha').html()),qualLi;
				for(var i=0;i<countLi;i++){
				qualLi=i+1;
				$('.sp_cmd_val-'+qualLi).html(valTopo[i]);
				}
			}
			if($('#cd_consulta_cmd').attr('class')=="caixa_consulta_cmd"){				
				$('#voltarPagarCx').show();	
				if($('#mosta_total_cmd').attr('class')=="0"){				
				$('#voltarPagaCx').css({'margin-left':'10px'});
				$('#juntarPagaCx').show();
				$('#descontarCx').show();				
				$('#pagarTelaCx').show();
				$('#transferirConta').show();
				}else{
				$('#mosta_total_cmd div').css({'margin-left':'55px'});			
				$('#voltarPagaCx').css({'margin-left':'55px'});
				$('#juntarPagaCx').hide();
				$('#pagarTelaCx').hide();
				$('#descontarCx').hide();
				$('#transferirConta').hide();
				}
			}
	});
	});
	
	$('body').on('click','.cmd_delete',function(){		
		$('#carregador').show();
		$.post('_include/loading-interno.php',{senhaMaster:true,classMaster:$(this).attr('id')},function(data){
		$('#carregador').hide();
		$('#fundo_branco').html(data).fadeIn(150);
		$('#envia_senha_master').addClass('delCmdMaster');
		$('#senha_master').focus();
		});
	});
	
	$('#cont_cadastros').on('click','.deletarClientes',function(){
		$('#carregador').show();
		$.post('_include/loading-interno.php',{senhaMaster:true,classMaster:$(this).parents('li').attr('class')},function(data){
		$('#carregador').hide();
		$('#fundo_branco').html(data).fadeIn(150);
		$('#envia_senha_master').addClass('delClienteMaster');
		$('#senha_master').focus();
		});
	});
	
	$('body').on('click','#senhaMaster-baixo a',function(){
	$('#fundo_branco').fadeOut(200,function(){ $('#fundo_branco').html("");});
	});
	
	$('body').on('click','.delCmdMaster',function(){		
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
				var rete=senhaMaster.attr('class').split('-'),id=rete[0],linhaLi=rete[1],qualCmdMesa=$('#cont_consulta_cmd').attr('class'),valCmd,qualIdVai,funcionario=false;
					if(rete[2]=="descontarId"){
						valCmd=$('#pegaCmdValDesc-'+id).attr('class');
                        qualIdVai=$('#liCmdDesc-'+id);						
					}else{
						valCmd=$('#pegaCmdVal-'+id).attr('class');
                        qualIdVai=$('#liCmd-'+id);
					}
                    
                    if(qualCmdMesa==undefined){                       
                       qualCmdMesa=$('#tp_valor_cmd').attr('class');
                    }
                    if(qualCmdMesa=="vendas-abertas"){
                        funcionario=qualIdVai.children('div').children('.pega_mostra_garcon').html();
                    }
                    
					$.post('_php/alterar_cadastros.php',{delProdCmd:id,idProduto:qualIdVai.attr('class'),quantCmd:qualIdVai.children('div').children('.numQuantDel').html(),qualCmdMesa:qualCmdMesa,idDesconto:rete[2],idfuncionario:funcionario},function(dados){
						$('#carregador').hide();
						var ret=dados.split("|"),msg=ret[0],diverro=ret[1];
							if(diverro!="erro"){
						if($('#cont_consulta_cmd ul').html()!=undefined && $('#cont_consulta_cmd ul').length==1){
					var valConsuma=parseFloat($('#mosta_total_cmd div').attr('class')),valTotalCmd=parseFloat($('#valTotalComanda').attr('class'))-parseFloat(valCmd);
					if($('.consumo-'+linhaLi).html()=="1" && valConsuma>valTotalCmd){
						var newValTotal = valConsuma-valTotalCmd;
						if($('#valTotalComanda').html()=="0,00" || valConsuma==0){ var txtEx1='consumir ',txtEx2=' style="display:none;"',valCerto=0,txtEx3='';}else{ var txtEx1='',txtEx2='',valCerto=valConsuma,txtEx3=' de R$ ';}
						$('#mosta_total_cmd div').html('resta '+txtEx1+'R$ <span id="resto_val" class="'+newValTotal+'">'+number_format(newValTotal,2,',','.')+'</span> DA CONSUMAÇÃO'+txtEx3+'<span id="valTotalComanda" class="'+valTotalCmd+'"'+txtEx2+'>'+number_format(valCerto,2,',','.')+'</span>');
						$('.sp_cmd_val-'+linhaLi).html(number_format(valCerto,2,',','.'));
					}else{
						valTotalCmd=(valTotalCmd>0)?valTotalCmd:0;
						$('#mosta_total_cmd div').html('valor total da comanda R$ <span id="valTotalComanda" class="'+valTotalCmd+'">'+number_format(valTotalCmd,2,',','.')+'</span>');
						$('.sp_cmd_val-'+linhaLi).html(number_format(valTotalCmd,2,',','.'));
					}
				}else{
					var valConsuma=parseFloat($('#totalCada-'+linhaLi+' div').attr('class')),valTotalCmd=parseFloat($('#valTotalComanda-'+linhaLi).attr('class'))-parseFloat(valCmd);					
					if($('.consumo-'+linhaLi).html()=="1" && valConsuma>valTotalCmd){
						var newValTotal = valConsuma-valTotalCmd;
						var restoTotal = (parseFloat($('#valTotalComanda-'+linhaLi).attr('class'))<0)?0:parseFloat($('#valTotalComanda-'+linhaLi).attr('class'))-valConsuma;
						if($('#valTotalComanda-'+linhaLi).html()=="0,00" || valConsuma==0){ var txtEx1='consumir ',txtEx2=' style="display:none;"',valCerto=0,txtEx3='';}else{ var txtEx1='',txtEx2='',valCerto=valConsuma,txtEx3=' de R$ '; }
						$('#totalCada-'+linhaLi+' div').html('resta '+txtEx1+'R$ <span id="resto_val" class="'+newValTotal+'">'+number_format(newValTotal,2,',','.')+'</span> DA CONSUMAÇÃO'+txtEx3+'<span id="valTotalComanda-'+linhaLi+'" class="'+valTotalCmd+'"'+txtEx2+'>'+number_format(valCerto,2,',','.')+'</span>');
						$('.sp_cmd_val-'+linhaLi).html(number_format(valCerto,2,',','.'));
					}else{
						valTotalCmd=(valTotalCmd>0)?valTotalCmd:0;
						var restoTotal = parseFloat($('#valTotalComanda-'+linhaLi).attr('class'))-valTotalCmd;						
						$('#totalCada-'+linhaLi+' div').html('valor total da comanda R$ <span id="valTotalComanda-'+linhaLi+'" class="'+valTotalCmd+'">'+number_format(valTotalCmd,2,',','.')+'</span>');
						$('.sp_cmd_val-'+linhaLi).html(number_format(valTotalCmd,2,',','.'));
					}
					if($('#cont_consulta_cmd ul').html()!=undefined){
					var novoTTcmd = parseFloat($('#valTotalComanda').attr('class'))-restoTotal;
					$('#valTotalComanda').attr('class',novoTTcmd).html(number_format(novoTTcmd,2,',','.'));
					}					
				}
				qualIdVai.remove();
                        $('#fundo_branco').fadeOut(200,function(){ $('#fundo_branco').html("");});                                
                                console.log(ret[2]);
                            if(rete[2]=="descontarId" && ret[2]!=0){
                            var formaPago=ret[2],valPago=ret[3],dinheiroCartao=(formaPago==1)?'em dinheiro':'no cartão';
                                $('#confirm-cima p').html('Remover desconto de R$ <span class="'+formaPago+'|'+valPago+'">'+number_format(valPago,2,',','.')+'</span> '+dinheiroCartao+' do caixa atual ?');
                                $('#spansim').addClass('s_descontoCx');
                                $('#confirm').show();
                                $('#spansim a').focus();                                
                            }else{                            
							$('#dentroOk').html("Produto excluir com sucesso !").fadeIn(150);
							setTimeout(function(){$('#dentroOk').fadeOut(150);},800);
                            }
						}else{
							$('#alert-cima p').html(msg);
							$('#alert').show();
							$('#spanalert a').focus();
						}
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
    
    $('body').on('click','.s_descontoCx a',function(){
        $('#carregador').show();
        var formaValor=$('.p_confDentro').children('span').attr('class').split('|'),formaPago=formaValor[0],valPago=formaValor[1];
        $.post('_php/alterar_cadastros.php',{descontarCx:true,formaPago:formaPago,valPago:valPago},function(retorno){
            var ret=retorno.split('|'),msg=ret[0],erro=ret[1];
            $('#carregador').hide();
            if(erro==""){
                $('#confirm-cima p').html('');
                $('#confirm').hide();    
                $('#spansim').removeClass('s_descontoCx');
                $('#dentroOk').html(msg).fadeIn(150);
                setTimeout(function(){$('#dentroOk').fadeOut(150);},800);
            }else{
                $('#alert-cima p').html(msg);
                $('#alert').show();
                $('#spanalert a').focus();
            }            
        });
        return false;
    });
    
	
	//PARTE DE IDENTIFICAÇÃO DO OPERADOR
	
	$("#cont_identifica").on('click','#acesso_operario',function(){
		$('.d_aviso_erro').hide().children('p').html("");
		var codigoOpe=$('#cd_codigoOpe'),senhaOpe=$('#cd_senhaOpe');
		if(codigoOpe.val()==""){
		$('#erro_'+codigoOpe.attr('id')+' p').html("Código do operador em branco !");
		$('#erro_'+codigoOpe.attr('id')).show();
		$('#'+codigoOpe.attr('id')).focus();
		}else if(senhaOpe.val()==""){
		$('#erro_'+senhaOpe.attr('id')+' p').html("Senha do operador em branco !");
		$('#erro_'+senhaOpe.attr('id')).show();
		$('#'+senhaOpe.attr('id')).focus();
		}else{
			$('#carregador').show();
			$.post("_php/loginCadastro.php",{codigoOpe:codigoOpe.val(),senhaOpe:senhaOpe.val()},function(data){			
				var ret=data.split('|'),msg=ret[0],diverro=ret[1];
				if(diverro!="erro"){
					if(diverro!=""){
						$('#carregador').hide();
						$('#erro_'+diverro+' p').html(msg);
						$('#erro_'+diverro).show();
						$("#"+diverro).focus();
					}else{						
						window.location.href=getUrl();
					}
				}else{
					$('#carregador').hide();
					$('#alert-cima p').html(msg);
					$('#alert').show();
					$('#spanalert a').focus();
				}
			
			});
		
		}
		return false;	
	});
	
	//PARTE DO CAIXA E BAR	
	$('body').on('keyup','.comandaDoBar input',function(e){
		var tecla=(window.event)?event.keyCode:e.which;		
		maisMenosProdutos(tecla);
	});	
	
	$('body').on('click','.MaisMenosProduto',function(){		
		if($(this).attr('id')=="maisProdutos"){ 
		maisMenosProdutos(107);
		}else{
		maisMenosProdutos(109);
		}
	});
	
	function maisMenosProdutos(tecla){	
		var contProQuant=$('#contProQuant').val();
		if(tecla==107 || tecla==187){
			$('#carregador').show();
			$('#contProQuant').val(parseInt($('#contProQuant').val())+1);
			$('.d_aviso_erro').hide().children('p').html("");			
			$.get('_include/loading-interno.php',{prodBarCmd:true,contProQuant:contProQuant},function(data){
			$("#cmdBarBaixo").append(data);
			if(contProQuant==1){$('#menosProdutos').show();}
			$('#carregador').hide();
			});
			}else if((tecla==109 || tecla==189) && contProQuant>1){
				$('#contProQuant').val(parseInt($('#contProQuant').val())-1);
				$('.d_aviso_erro').hide().children('p').html("");
				$('.cmdExtraBar:last').remove();
				if(contProQuant==2){$('#menosProdutos').hide();}
				//$('#cd_garcon').focus();
			}
        rolarBaixo();
	}
	
	$('body').on('keypress','input.firstQuant',function(e){
		var tecla=(window.event)?event.keyCode:e.which;
		if(tecla>47 && tecla<58){
		$(this).val('').removeClass('firstQuant');
		}		
	});
	
	//TRANSFERIR CONTA	
	$('body').on('click','#s_transferir a',function(){
	$('#carregador').show();
    var CmdFrente=$('#transComanda').html();
	$.post("_php/alterar_cadastros.php",{transferirConta:CmdFrente,idCliente:$('#d_transfere p').attr('class')},function(retorno){	
	$('#carregador').hide();
		
		var retu=retorno.split('|'),msg=retu[0],erro=retu[1];		
		if(erro==""){
			$('#fundo_branco').fadeOut(300,function(){$('#fundo_branco').html("");});
			$('#dentroOk').html(msg).fadeIn(150);
			setTimeout(function(){$('#dentroOk').fadeOut(200);},1500);
            
            if(CmdFrente=="compra"){                
                $('#ulmostraprod').html('');
                $('#todo-frente-caixa').attr('class','');
                $('#codigoprinc,#nomeprinc').html('');
                $('#d_val_unitario,#d_val_total,#d_desconto_frente,#d_valorTotal').html('<span>R$</span> 0,00');
                $('#d_alt_unidade,#d_quant_volume').html('0');
                $('.d_hide_frente').removeClass('d_hide_frente');
                $('#divopcional1 span').addClass('desCursor');
                $('#primdivmostra,#ulmostraprod').hide();
                $('#d_cx_livre').show();
                $('#busca_frente_caixa').val("").focus();                
            }else{
			$('#tudo_busc_cliente_caixa').show();
			$('#voltarPagarCx').hide();
			$('#cont_consulta_cmd').html("");
			$('#cd_cliente_busca_cliente').val("");
			$('#cd_consulta_cmd').val("").focus();
			window.history.pushState(null,'Gerabar - Opção de caixa',getUrl()+'caixa.php?cad=comanda-cliente');
            }
            
		}else{
		$('#alert-cima p').html(msg);
		$('#alert').show();
		$('#spanalert a').focus();
		}
	});
	return false;
	});
	
	//CADASTRO COMANDA BAR
		$('body').on('click','.bt_submenu',function(){
		$('.d_aviso_erro').hide().children('p').html("");
		var qualCampo = $(this).children('span').attr('class');
		if($('#submenu_'+qualCampo).attr('class')=="sub_aberto"){
		$('#submenu_'+qualCampo).hide().removeClass('sub_aberto');
		$(this).css({'background-position':'0 11px'});
		}else{
		$('div.d_alinha_submenu ul').hide().removeClass('sub_aberto');		
		$('.bt_submenu').css({'background-position':'0 11px'});
		$(this).css({'background-position':'-26px 11px'});
		$('#submenu_'+qualCampo).show().addClass('sub_aberto');
		}
		});	
    
		$('body').on('click','.bt_subbusca',function(){
			carrega_busca_cmd($(this).children('span').attr('class'));
		});
		
		$('body').on('click','#subBusca-cima ul li',function(){
			$('#'+$('#i_subBuscaEnvia').attr('class')).val($(this).children('span').attr('class')).focus();
			$('.d_aviso_erro').hide().children('p').html("");
			$('#fundo_branco').fadeOut(200,function(){$('#fundo_branco').html("");});
			
		});
		
		$('body').on('click','#tranferi-cima ul li',function(){
				$('#d_transfere p').attr('class',$(this).children('span').attr('class'));
				$('#transNome').html($(this).children('span').html());
				$('#tranferi-dentro').animate({'height':'-=100px','margin-bottom':'+=50px','margin-top':'+=50px'},300);
				$('#tranferi-cima').animate({'height':'-=100px'},300);
				$('#d_outroTransfere').slideUp(250);
				$('#d_transfere').slideDown(180,function(){
				$('#d_outroTransfere').html('');
				});
				$('#voltar-tranferi').hide();
			
		});
		
		$('body').on('mouseover','#subBusca-cima ul li',function(){
			if($(this).attr('class')!="emfalta"){
			$('#subBusca-cima ul li').removeClass('bAtivo');
			$(this).addClass('bAtivo');
			}
		});
		
		$('body').on('mouseover','#tranferi-cima ul li',function(){
			if($(this).attr('class')!="emfalta"){
			$('#tranferi-cima ul li').removeClass('bAtivo');
			$(this).addClass('bAtivo');
			}
		});
		
		$('body').on('keyup','#i_subBuscaTxt',function(e){
			var tecla=(window.event)?event.keyCode:e.which;				
			if((tecla<33 || tecla>36) && (tecla<16 || tecla>18) && (tecla!=37 && tecla!=39 && tecla!=0 && tecla!=9 && tecla!=20 && tecla!=255)){
			clearTimeout(pararBusca);
			$('.d_aviso_erro').hide().children('p').html("");
			var menuB=$('#i_subBuscaEnvia').attr('class');
			if((tecla==40 || tecla==38) && $('#subbusca_'+menuB+' li').attr('class')!='carrega_b'){
				var active = -1,suggest = $('#subbusca_'+menuB+' li'),qnts = suggest.length;
				
				for(var i=0;i<qnts;i++){
					if(suggest.eq(i).attr('class')=="bAtivo"){
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
				suggest.removeClass('bAtivo');
				suggest.eq(active).addClass('bAtivo');
				}
				
			}else if(tecla==13 && $('.bAtivo').children('span').attr('class')!=undefined){
			
			if(menuB=="buscaTransferi"){
				$('#d_transfere p').attr('class',$('.bAtivo').children('span').attr('class'));
				$('#transNome').html($('.bAtivo').children('span').html());
				$('#tranferi-dentro').animate({'height':'-=100px','margin-bottom':'+=50px','margin-top':'+=50px'},300);
				$('#tranferi-cima').animate({'height':'-=100px'},300);
				$('#d_outroTransfere').slideUp(250);
				$('#d_transfere').slideDown(180,function(){
					$('#d_outroTransfere').html('');		
				});
				$('#voltar-tranferi').hide();
			}else{
				$('#'+menuB).val($('.bAtivo').children('span').attr('class')).focus();
				$('#fundo_branco').fadeOut(200,function(){$('#fundo_branco').html("");});
			}
			
			
			}else{			
				var busq = $(this).val().trim();
				$('#subbusca_'+menuB).html('<li class="carrega_b"></li>').show();
				pararBusca=setTimeout(function(){				
				$.get('_php/carrega-busca.php',{qualCarrega:'cd_produto_cmd',buscCmdBar:menuB,busca:busq},function(retorno){
				if(retorno!=""){
					$('#subbusca_'+menuB).html(retorno);
				}else{
					$('#subbusca_'+menuB).html('').hide();
				}
				});
				},200);
			
			}
			}		
		});
		
		$('body').on('click','div.d_alinha_submenu ul li span',function(){
		$('.d_aviso_erro').hide().children('p').html("");		
		$('#cd_produto_'+$(this).attr('class')).val($(this).html()).focus();		
		$('.bt_submenu').css({'background-position':'0 11px'});
		
		$('div.d_alinha_submenu ul').hide().removeClass('sub_aberto');		
		});
		
		$('body').on('blur','div.d_alinha_submenu input',function(){
			$('.d_aviso_erro').hide().children('p').html("");		
			if($('#busca_'+$(this).attr('id')).attr('class')!="emcima"){
			$('#busca_'+$(this).attr('id')).html('').hide();
			}
		});
		
		$('body').on('mouseover','div.d_alinha_submenu ul li span',function(){
		$('.d_aviso_erro').hide().children('p').html("");
		$('.d_alinha_submenu ul li.active').removeClass('active');
		$(this).parents('ul').addClass('emcima');
		});
		
		$('body').on('mouseout','div.d_alinha_submenu ul li span',function(){
		$('.d_aviso_erro').hide().children('p').html("");
		$(this).parents('ul').removeClass('emcima');
		});
		
		$('body').on('keyup','div.d_alinha_submenu input',function(e){
			var tecla=(window.event)?event.keyCode:e.which;				
			if((tecla<33 || tecla>36) && (tecla<16 || tecla>18) && (tecla!=37 && tecla!=39 && tecla!=0 && tecla!=9 && tecla!=20 && tecla!=255)){				
			clearTimeout(pararBusca);
			var busq = $(this).val().trim(),qualCarrega = $(this).attr('id');
			if(busq.length>=1){
				$('.d_aviso_erro').hide().children('p').html("");
				$('#busca_'+qualCarrega).removeClass('emcima');
				if((tecla==40 || tecla==38) && $('#busca_'+qualCarrega+' li span').attr('class')!="carrega_busca"){
					var active = -1,suggest = $('#busca_'+qualCarrega+' li'),qnts = suggest.length;
					for(var i=0;i<qnts;i++){
						if(suggest.eq(i).attr('class')=="active"){
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
					suggest.removeClass('active');
					suggest.eq(active).addClass('active');					
					var txtVal=suggest.eq(active).children('span').html();
					$(this).val(txtVal);
					}					
				}else{					
					$('.bt_submenu').css({'background-position':'0 11px'});
					$('div.d_alinha_submenu ul').hide().removeClass('sub_aberto');					
					$('#busca_'+qualCarrega).html('<li><span class="carrega_busca"></span></li>').show();					
					pararBusca=setTimeout(function(){
					$.get('_php/carrega-busca.php',{qualCarrega:qualCarrega,busca:busq},function(retorno){
					if(retorno!=""){
					$('#busca_'+qualCarrega).html(retorno);
					}else{
					$('#busca_'+qualCarrega).html('').hide();
					}
					});
					},200);
				}
			}else{
				$('#busca_'+qualCarrega).html('').hide();
			}
			}		
		});
		
    
		$('#troca_cadastros').on('click','.bt_diversos span',function(){
		$('.d_aviso_erro').hide().children('p').html("");
		var idiverso=$(this).parents('.d_alinha_subbusca'),idClick=idiverso.children('input').attr('id');		
		if($(this).attr('class')=="diverso-false"){
		idiverso.children('input').attr('onKeyUp','').attr('placeholder','Nome diverso...').css({'padding-right':'5px'}).focus();
		idiverso.children('.bt_subbusca').hide();
		$(this).attr('class','diverso-true');
		$('#openVal-'+idClick).show();
		$('#smallQuant-'+idClick).children('input').css({'width':'140px'});
		}else{
		idiverso.children('input').attr('onKeyUp','return SemEspaco(this);').attr('placeholder','Código do produto...').css({'padding-right':'34px'}).focus();
		idiverso.children('.bt_subbusca').show();
		$(this).attr('class','diverso-false');
		$('#openVal-'+idClick).hide();
		$('#openVal-'+idClick).children('input').val('0,00');
		$('#smallQuant-'+idClick).children('input').css({'width':'220px'});
		}
		});
	
		$('#troca_cadastros').on('click','#envia_cmd_bar',function(){			
			$('.d_aviso_erro').hide().children('p').html("");
			$('.campoQuant input').removeClass('firstQuant');
			var garcon = $('#cd_garcon'),comanda = $('#cd_comanda'),salProd=[],salQuant=[],txtDiverso=[],salValDiverso=[],contar=$('#contProQuant').val(),passaCerto=false,cmdMesa=$('#cont_form_comanda').attr('class');
			if(garcon.val()==""){
			$('#erro_cd_garcon p').html("Coloque aqui o garçon / funcionário !");
			$('#erro_cd_garcon').show();
			garcon.focus();
			}else if(isNaN(garcon.val())){
			$('#erro_cd_garcon p').html("Coloque apenas números !");
			$('#erro_cd_garcon').show();
			garcon.focus();
			}else if(comanda.val()==""){
			$('#erro_cd_comanda p').html("Coloque aqui a "+cmdMesa+" !");
			$('#erro_cd_comanda').show();
			comanda.focus();
			}else{
					for(var i=0;i<contar;i++){
						var diverso=$('#cd_btDiverso_cmd_'+i).children('span').attr('class');
						if($('#cd_produto_cmd-'+i).val()==""){
							var txtPro = (diverso=="diverso-false")?'Coloque o código do produto !':'Coloque o nome do produto diverso !'
							$('#erro_cd_produto_cmd-'+i+' p').html(txtPro);
							$('#erro_cd_produto_cmd-'+i).show();
							$('#cd_produto_cmd-'+i).focus();
							return false;
						}
						if(diverso=='diverso-true' && $('#cd_valDiv_cmd_'+i).val()=="0,00"){
							$('#erro_cd_valDiv_cmd_'+i+' p').html("Coloque o valor do produto diverso !");
							$('#erro_cd_valDiv_cmd_'+i).show();
							$('#cd_valDiv_cmd_'+i).focus();
							return false;
						}
						if($('#cd_qtd_cmd_'+i).val()==""){
							$('#erro_cd_qtd_cmd_'+i+' p').html("Coloque aqui a quantidade de produto !");
							$('#erro_cd_qtd_cmd_'+i).show();
							$('#cd_qtd_cmd_'+i).val('1').addClass('firstQuant').focus();
							return false;
						}
                        if(isNaN($('#cd_qtd_cmd_'+i).val())){
							$('#erro_cd_qtd_cmd_'+i+' p').html("Coloque apenas números !");
							$('#erro_cd_qtd_cmd_'+i).show();
							$('#cd_qtd_cmd_'+i).focus();
							return false;
						}
						
							salProd.push($('#cd_produto_cmd-'+i).val());							
							txtDiverso.push(diverso);							
							salValDiverso.push($('#cd_valDiv_cmd_'+i).val().replace(/[.]/g,"").replace(",","."));
							salQuant.push($('#cd_qtd_cmd_'+i).val());
							if((contar-1)==i){passaCerto=true}
							
					}
			if(passaCerto==true){
			$('#carregador').show();
			$('#envia_cmd_bar').attr('disabled',true);
			$.post('_php/cadastrar_dados.php',{cadastro:'comanda_bar',garcon:garcon.val(),comanda:comanda.val(),produto:salProd,quantidade:salQuant,txtDiverso:txtDiverso,salValDiverso:salValDiverso,cmdMesa:cmdMesa},function(dados){
				$('#carregador').hide();
				var ret=dados.split("|");
				$('#envia_cmd_bar').attr('disabled',false);
				if(ret[1]!="erro"){
					if(ret[1]!=""){
						$('#erro_'+ret[1]+' p').html(ret[0]);
						$('#erro_'+ret[1]).show();
						$("#"+ret[1]).focus();
					}else{
						$('#dentroOk').attr('class','dentroCmd').html("<p>"+ret[0]+"</p>").fadeIn(150);
						setTimeout(function(){$('#dentroOk').fadeOut(200,function(){$('#dentroOk').attr('class','dentroRespansivo').html("");});},1800);
						if(cmdMesa=="mesa"){							
							var pgMesa=$('#pgAbaMesa').val(),txtMesa=(pgMesa=="opcao-mesa")?'Opções de caixa':'Controle de comanda';							
							window.history.pushState(null,'Gerabar - '+txtMesa,$('.volta_mesas').attr('href'));
							$('#troca_cadastros').html('');
							$('#loadingOne').show();
							$.post('_include/'+pgMesa+'.php',{inclui:true},function(pagina){
								$('#loadingOne').hide();
								$('#troca_cadastros').html(pagina);
							});
						}else{
						window.history.pushState(null,'Gerabar - '+txtMesa,getUrl()+'comanda-bar.php?cad=lancar-comanda');
						garcon.val("").focus();
						comanda.val("");
						$('#cd_qtd_cmd_0').val("");
						$('.cmdExtraBar').remove();
						$('#contProQuant').val("1");						
						var idiverso=$('#cd_btDiverso_cmd_0').parents('.d_alinha_subbusca');
						idiverso.children('input').attr('onKeyUp','return SemEspaco(this);').attr('placeholder','Código do produto...').val("").css({'padding-right':'34px'});
						idiverso.children('.bt_subbusca').show();
						$('#cd_btDiverso_cmd_0 span').attr('class','diverso-false');
						$('#openVal-cd_produto_cmd-0').hide();
						$('#openVal-cd_produto_cmd-0').children('input').val('0,00');
						$('#smallQuant-cd_produto_cmd-0').children('input').css({'width':'220px'});
						$('#menosProdutos').hide();
						}
					}
				}else{
					$('#alert-cima p').html(ret[0]);
					$('#alert').show();
					$('#spanalert a').focus();
				}			
			});			
			}}
			return false;
		});
		
		//DELETA ESTOQUE
		
	$('body').on('click','.delClienteMaster',function(){			
	$('.d_aviso_erro').hide().children('p').html("");
	var senhaMaster=$('#senha_master');
	if(senhaMaster.val()==""){
	$('#erro_senha_master p').html("Senha master está em branco !");
	$('#erro_senha_master').show();
	senhaMaster.focus();
	}else{
		$.post('_php/carrega-listas.php',{senhaMaster:senhaMaster.val()},function(dado){
			$('#carregador').hide();
			var ret=dado.split('|'),msg=ret[0],diverro=ret[1];
			if(diverro!="erro"){
				if(diverro!=""){
					$('#erro_'+diverro+' p').html(msg);
					$('#erro_'+diverro).show();
					$("#"+diverro).focus();
				}else{
				deletaCliEsto($('#senha_master').attr('class'));
				$('#fundo_branco').fadeOut(200,function(){ $('#fundo_branco').html("");});
					$('#dentroOk').html("Cliente excluído com sucesso !").fadeIn(150);
					setTimeout(function(){$('#dentroOk').fadeOut(150,function(){$('#dentroOk').html("");});},800);
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
	
	//FILTRO ABERTO/FECHADO
	$('body').on('click','.muda_filtro',function(){
	var divCima=$(this).attr('id');
	if($('#d_'+divCima+' ul').attr('class')=="s_aberto_filtro"){
	$('#d_'+divCima+' ul li span').removeClass('s_form_filtro');
	$('#d_'+divCima+' li.li_hide').slideUp(150,function(){
	$('#d_'+divCima+' ul').attr('class','');
	});
	}else{
	$('#d_'+divCima+' ul li span').addClass('s_form_filtro');
	$('#d_'+divCima+' li.li_hide').slideDown(150,function(){
	$('#d_'+divCima+' ul').attr('class','s_aberto_filtro');
	});	
	}	
	});
	
    
	$('body').on('click','.s_form_filtro',function(){
		$('.d_aviso_erro').hide().children('p').html("");
		var divCima=$(this).parents('div').attr('id'),qualCad=$("#qualCad"),compLink,gSexo=$("#h_sexo"),bus1="",bus2="",pBusca=true,
		gEntrada=$("#h_entrada");
		
		if($('#'+divCima+' li.li_ativo_filtro span').attr('id')==$(this).attr('id')){
			$('#'+divCima+' ul li span').removeClass('s_form_filtro');
			$('#'+divCima+' li.li_hide').slideUp(150,function(){
			$('#'+divCima+' ul').attr('class','');
			});
		}else{
			$('#'+divCima+' .muda_filtro').before('<li class="li_hide">'+$('#'+divCima+' li.li_ativo_filtro').html()+'</li>');
			$('#'+divCima+' li.li_ativo_filtro span').attr('id',$(this).attr('id')).html($(this).html());
			$(this).parents('li').remove();
			$('#'+divCima+' ul li span').removeClass('s_form_filtro');
			$('#'+divCima+' li.li_hide').slideUp(150,function(){
			$('#'+divCima+' ul').attr('class','');
			});
			if(divCima=="d_f_data"){
				$('.fecha_tudo_filtro').hide();
				$('#tudoCarregaCmd').html("");
				if($(this).attr('id')!="f_tudo"){
					$('#d_filtro_i'+$(this).attr('id')).show();
					$('#d_daBusca').show();
					if($(this).attr('id')=="_data_inicio"){
					compLink="";
					$("#i_data_inicio").val($("#DBdataInicio").val());
					$("#i_data_final").val($("#DBdataFinal").val());
					$('#p_countCmd').css({'margin-top':'29px'}).show();
					}else{
					compLink="&busca=";
					$('#p_countCmd').hide();
					}
					$('#i'+$(this).attr('id')).focus();
				}else{
				compLink="&tudo=true";
				$('#p_countCmd').css({'margin-top':'7px'}).show();
				}
				if(qualCad.val()!="contas-fechadas" && qualCad.val()!="contas-abertas" && qualCad.val()!="mesas-fechadas" && qualCad.val()!="mesas-abertas" && qualCad.val()!="vendas-fechadas" && qualCad.val()!="vendas-abertas" && qualCad.val()!="caixas-fechados" && qualCad.val()!="caixas-abertos"){
					if(gEntrada.attr('class')!="todas"){
					compLink='&entrada='+gEntrada.attr('class')+compLink;
					}
				}
				
				if(gSexo.attr('class')!="todas" && qualCad.val()!="mesas-fechadas" && qualCad.val()!="mesas-abertas" && qualCad.val()!="vendas-fechadas" && qualCad.val()!="vendas-abertas" && qualCad.val()!="caixas-fechados" && qualCad.val()!="caixas-abertos"){
				compLink='&sexo='+gSexo.attr('class')+compLink;
				}
				
				var qualva=$(this).attr('id').split('_'),qualvai=qualva[1],pSexo,pEntrada;
				if(qualCad.val()!="mesas-fechadas" && qualCad.val()!="mesas-abertas" && qualCad.val()!="vendas-fechadas" && qualCad.val()!="vendas-abertas" && qualCad.val()!="caixas-fechados" && qualCad.val()!="caixas-abertos"){
                    pSexo=gSexo.attr('class');
                    pEntrada=(qualCad.val()=="contas-fechadas" || qualCad.val()=="contas-abertas")?'todas':gEntrada.attr('class');				
				}else{
                    pSexo='';
                    pEntrada='';
				}
				
				qualCad.attr('class',qualvai);
				if(qualvai=="busca"){pBusca=false;}
				
			}else{
				var qualvai=qualCad.attr('class');
				if(qualvai=="data"){
					var var1=$('#i_data_inicio'),var2=$('#i_data_final');
					if(var1.val()=="__/__/____" || var1.val()==""){
					$('#erro_'+var1.attr('id')+' p').html("Data inical está incorreta !");
					$('#erro_'+var1.attr('id')).show();
					var1.focus();
					return false;
					}else if(var2.val()=="__/__/____" || var2.val()==""){
					$('#erro_'+var2.attr('id')+' p').html("Data final está incorreta !");
					$('#erro_'+var2.attr('id')).show();
					var2.focus();
					return false;
					}else{
						bus1=var1.val();
						bus2=var2.val();
						compLink='&dataInicial='+bus1+'&dataFinal='+bus2;
					}
				}else if(qualvai=="busca"){
					bus1=$('#i_busca_filtro').val();
					compLink="&busca="+bus1;
					if(bus1==""){pBusca=false;}
				}else{compLink="&tudo=true";}
										
				var entSex=$(this).attr('id').split('_'),compli,compli2;
				
				if(divCima=="d_f_entrada"){
                    compli=(gSexo.attr('class')!="todas")?"&sexo="+gSexo.attr('class'):"";
                    compli2=(entSex[1]!="todas")?"&entrada="+entSex[1]:"";
					compLink=compli+compli2+compLink;
					gEntrada.attr('class',entSex[1]);
					pEntrada=entSex[1];
					pSexo=gSexo.attr('class');
					
				}else{
					
					if(qualCad.val()=="contas-fechadas" || qualCad.val()=="contas-abertas"){
						compli="";
						pEntrada="todas";
					}else{
                        compli=(gEntrada.attr('class')!="todas")?"&entrada="+gEntrada.attr('class'):"";
						pEntrada=gEntrada.attr('class');
					}
					compli2=(entSex[1]!="todas")?"&sexo="+entSex[1]:"";
					compLink=compli2+compli+compLink;
					gSexo.attr('class',entSex[1]);
					pSexo=entSex[1];
					
				}
			}
			window.history.pushState(null,'Gerabar - Opções de caixa','?cad='+qualCad.val()+compLink);
			if(pBusca==true){
				$('#carregador').show();
				$.get("_php/carrega-busca.php",{qualCad:qualCad.val(),qualvai:qualvai,var1:bus1,var2:bus2,entrada:pEntrada,sexo:pSexo},function(data){
				$("#carregador").hide();
				$('#tudoCarregaCmd').html(data);				
				var countCmd=$('#trasContBusca').html(),sengu,plura;
				if(qualCad.val()=="mesas-fechadas" || qualCad.val()=="mesas-abertas"){
					sengu='mesa';
					plura='mesas';
				}else if(qualCad.val()=="vendas-fechadas" || qualCad.val()=="vendas-abertas"){
					sengu='venda';
					plura='vendas';
				}else if(qualCad.val()=="caixas-fechados" || qualCad.val()=="caixas-abertos"){
					sengu='caixa';
					plura='caixas';
				}else if(qualCad.val()=="contas-fechadas" || qualCad.val()=="contas-abertas"){
					sengu='conta';
					plura='contas';
				}else{
					sengu='comanda';
					plura='comandas';
				}
				if(countCmd>0){
				if(countCmd>1){$('#p_countCmd').html(countCmd+' '+plura+' encontradas');}else{$('#p_countCmd').html(countCmd+' '+sengu+' encontrada');}
				}else{
				$('#p_countCmd').html("");
				}
				});
			}else{
				$('#i'+$(this).attr('id')).val("");
			}
		}
	});
	
	$("body").on('click','#envia_filtro_openExit',function(){
		$('.d_aviso_erro').hide().children('p').html("");
		var qualFiltra=$('.li_ativo_filtro').children('span').attr('id'),tudoCerto=false,compLink="",gEntrada="",gSexo="",var1;
		if($("#qualCad").val()!="mesas-fechadas" && $("#qualCad").val()!="mesas-abertas" && $("#qualCad").val()!="vendas-fechadas" && $("#qualCad").val()!="vendas-abertas" && $("#qualCad").val()!="caixas-fechados" && $("#qualCad").val()!="caixas-abertos"){
		gSexo=$("#h_sexo").attr('class');
        gEntrada=($("#qualCad").val()=="contas-fechadas" || $("#qualCad").val()=="contas-abertas")?'todas':$("#h_entrada").attr('class');            
		if(gEntrada!="todas"){ compLink='&'+gEntrada+'=true';}            
		if(gSexo!="todas"){compLink='&'+gSexo+'=true'+compLink;}
		}
		
		if(qualFiltra=="_data_inicio"){
			var1=$('#i_data_inicio');
            var var2=$('#i_data_final');
			if(var1.val()=="__/__/____" || var1.val()==""){
			$('#erro_'+var1.attr('id')+' p').html("Data inical está incorreta !");
			$('#erro_'+var1.attr('id')).show();
			var1.focus();
			}else if(var2.val()=="__/__/____" || var2.val()==""){
			$('#erro_'+var2.attr('id')+' p').html("Data final está incorreta !");
			$('#erro_'+var2.attr('id')).show();
			var2.focus();
			}else{
			tudoCerto="data";
			window.history.pushState(null,'Gerabar - Opções de caixa','?cad='+$("#qualCad").val()+compLink+'&dataInicial='+var1.val()+'&dataFinal='+var2.val());
			busca1=var1.val();
			busca2=var2.val();
			}
		}else{		
			var1=$('#i_busca_filtro');
            var busca1=var1.val().trim(),busca2="";
			$('#tudoCarregaCmd').html("");
			if(busca1.length==0 && var1.val()!=""){
			$('#erro_'+var1.attr('id')+' p').html("Digite algo para ser buscado !");
			$('#erro_'+var1.attr('id')).show();
			}else{
			tudoCerto="busca";			
			}				
			window.history.pushState(null,'Gerabar - Opções de caixa','?cad='+$("#qualCad").val()+compLink+'&busca='+busca1);
			var1.focus();
		}
		if(tudoCerto!=false && var1.val()!=""){
		$("#carregador").show();
		$.get("_php/carrega-busca.php",{qualCad:$("#qualCad").val(),qualvai:tudoCerto,var1:busca1,var2:busca2,entrada:gEntrada,sexo:gSexo},function(data){
		$("#carregador").hide();
		$('#tudoCarregaCmd').html(data);
		var countCmd=$('#trasContBusca').html(),sengu,plura;
		if($("#qualCad").val()=="mesas-fechadas" || $("#qualCad").val()=="mesas-abertas"){
			sengu='mesa';
			plura='mesas';
		}else if($("#qualCad").val()=="vendas-fechadas" || $("#qualCad").val()=="vendas-abertas"){
			sengu='venda';
			plura='vendas';
		}else if($("#qualCad").val()=="caixas-fechados" || $("#qualCad").val()=="caixas-abertos"){
			sengu='caixa';
			plura='caixas';
		}else if($("#qualCad").val()=="contas-fechadas" || $("#qualCad").val()=="contas-abertas"){
			sengu='conta';
			plura='contas';
		}else{
			sengu='comanda';
			plura='comandas';
		}
		if(countCmd>0){
		if(countCmd>1){$('#p_countCmd').html(countCmd+' '+plura+' encontradas');}else{$('#p_countCmd').html(countCmd+' '+sengu+' encontrada');}
		}else{
		$('#p_countCmd').html("");
		}
		});
		}
		return false;
	});
		
});
//FECHA JAVA CAIXA/BAR

//JAVA ESTOQUE/CLIENTE
	$(function(){
		//BUSCA ESTOQUE		
		$('input.for-val').priceFormat({prefix:'',centsSeparator:',',thousandsSeparator:'.'});
		$("#filtra_clientes_contato").mask("(99) 99999-999?9");
		$('.key_input input').on('keyup',function(e){
		var tecla=(window.event)?event.keyCode:e.which;
			if((tecla<37 || tecla>40) && (tecla<33 || tecla>36) && (tecla<16 || tecla>18) && (tecla!=0 && tecla!=9 && tecla!=20 && tecla!=255)){
			buscaAtualizaEstoque($('#qualPg').val());
			return false;
		}
		});
		
		$('#filtra_estoque_bus').on('click',function(){
		buscaAtualizaEstoque($('#qualPg').val());
		return false;
		});
		
		$('#filtra_clientes_bus').on('click',function(){
		buscaAtualizaEstoque($('#qualPg').val());
		return false;
		});
		
		//EDITA/DELETA ESTOQUE FUNDO PRETO
		$('#todos-check').on('click',function(){		
			if(document.getElementById("todos-check").checked==true){
			$(".sel-input input[type='checkbox']").prop("checked",true);
			}else{
			$(".sel-input input[type='checkbox']").prop("checked",false);
			}
		});
        
		$('#editarTudo').on('click',function(){
		var arra=[],tabelaCP,qtdC;
		for(var i=1; i<=$('.sel-input li').length; i++){
		if(document.getElementById('lop-'+i).checked == true){
		arra.push($('#lop-'+i).val());
		}}
		
		if(arra==""){
		$('#alert-cima p').html('Nada foi selecionado !');
		$('#alert').show();
		$('#spanalert a').focus();
		}else{
			$('#carregador').show();
			$.get("_php/carrega-listas.php",{idproduto:arra,clienteProduto:$('#qualPg').val()},function(retorno){
            $('#carregador').hide();
            if(retorno==""){
                
            if($('#qualPg').val()=="clientes"){
                tabelaCP="clientes";
                qtdC=20;
            }else{
                tabelaCP="produtos";
                qtdC=30;
            }                
            $('#alert-cima p').html('Plano Premium expirado !</br> Renove seu plano ou delete os '+tabelaCP+' acima do limite do Plano Grátis (max. '+qtdC+' cadastros).');
            $('#alert').show();
            $('#spanalert a').focus();
            }else{                
                $('#fundo_preto').html(retorno).fadeIn(150);
                $('#cliente_0_1').focus();
                $(".sel-input input[type='checkbox']").prop("checked",false);
                $('#todos-check').prop("checked",false);
            }
                
			
			});
		}
		});
		
		$('body').on('click','.editaEstCli',function(){			
        var tabelaCP,qtdC,divLocal,ambCaixa;            
		if($(this).parents('div').attr('class')=="li_edit_busc"){
            divLocal='clientes';
            ambCaixa=1;
        }else{
            divLocal=$('#qualPg').val();
            ambCaixa=0;
        }
            
		$("#carregador").show();
		$.get("_php/carrega-listas.php",{idproduto:[$(this).parents('li').attr('class')],clienteProduto:divLocal,ambCaixa:ambCaixa},function(retorno){
		$("#carregador").hide();        
            if(retorno==""){            
            if($('#qualPg').val()=="clientes"){
                tabelaCP="clientes";
                qtdC=20;
            }else{
                tabelaCP="produtos";
                qtdC=30;
            }   
            $('#alert-cima p').html('Plano Premium expirado !</br> Renove seu plano ou delete os '+tabelaCP+' acima do limite do Plano Grátis (max. '+qtdC+' cadastros).');
            $('#alert').show();
            $('#spanalert a').focus();
            }else{
                $('#fundo_preto').html(retorno).fadeIn(150);
                $('#cliente_0_1').focus();
            }
		});
		});
		
		$('body').on('click','#fecha_editaEstCli',function(){
		$('#fundo_preto').fadeOut(150,function(){$('#fundo_preto').html('');});
		});
		
		//PAGINAÇÃO ESTOQUE
		$('body').on('click','#select_bt',function(){
			if($(this).attr('class')=="select_abre_bt"){
			$(this).removeClass('select_abre_bt').addClass('select_fecha_bt');
			$('#select_produto ul').show();
			}else{
			$(this).removeClass('select_fecha_bt').addClass('select_abre_bt');
			$('#select_produto ul').hide();
			}
		});
		
		$('body').on('click','#select_produto ul li a',function(){
		if($('#select_produto').attr('class')!="naofaz"){
		if(window.history.pushState){
		window.history.pushState(null,'Gerabar - Estoques',$(this).attr('href'));
		var pg = $(this).html();
		paginaEstoque(pg,$('#qualPg').val());
		return false;
		}
		}
		});
		
		$('body').on('click','.bt_pg a',function(){
			if(window.history.pushState){
			window.history.pushState(null,'Gerabar - Estoques',$(this).attr('href'));
			var pg = $(this).attr('class');
			paginaEstoque(pg,$('#qualPg').val());
			return false;
			}
		});
	
	//PG ALTERAÇÃO DE CLIENTES	
	$('body').on('click','.atualiza_clientes',function(){		
		$('.d_aviso_erro').hide().children('p').html("");
		var Qid=$(this).attr('id'),id=[],nome=[],nascimento=[],sexo=[],cpf_cnpj=[],rg_estadual=[],tipo_pessoa=[],tel=[],email=[],number=[],Qnum,count;
		if(Qid=="enviaEdita_tudo"){
            count=$('#centro_fundo_preto li.conta-li').length;
            Qnum=0;
		}else{			
		var Vnum=$(this).attr('id').split('_');
            Qnum=Vnum[0];
            count = parseInt(Qnum)+1;
		}
		
	for(var i=Qnum; i<count; i++){
			var salNome=$('#cliente_'+i+'_1'),salNascimento=$('#cliente_'+i+'_3'),salSexo=$('#cliente_'+i+'_4'),salTel=$('#cliente_'+i+'_15'),salEmail=$('#cliente_'+i+'_18'),salCpf_cnpj,salRg_estadual,salTipo_pessoa;			
			if($('#'+i+'-pessoa_fisica').attr('class')=='pessoa_ativo'){
				salCpf_cnpj = $('#cliente_'+i+'_11');
                salRg_estadual = $('#cliente_'+i+'_12');
                salTipo_pessoa="pessoa_fisica";
			}else{
				salCpf_cnpj = $('#cliente_'+i+'_13');
                salRg_estadual = $('#cliente_'+i+'_14');
                salTipo_pessoa="pessoa_juridica";
			}

			if(salNome.val().trim()=="" || salNome.val().trim().length<5){
			$('#erro_'+salNome.attr('id')+' p').html('Nome em branco ou pequeno demais !');
			$('#erro_'+salNome.attr('id')).show();
			salNome.focus();
			return false;
			}else if(salSexo.val().trim()==""){
			$('#erro_'+salSexo.attr('id')+' p').html('Por favor, selecione o sexo !');
			$('#erro_'+salSexo.attr('id')).show();
			salNome.focus();
			return false;
			}else if(salEmail.val().trim()!="" && er.test(salEmail.val().trim())==false){
			$('#erro_'+salEmail.attr('id')+' p').html("O e-mail informado é inválido !");
			$('#erro_'+salEmail.attr('id')).show();
			salEmail.focus();
			return false;
			}else{				
				nome.push(salNome.val());
				nascimento.push(salNascimento.val());
				sexo.push(salSexo.val());
				cpf_cnpj.push(salCpf_cnpj.val());
				rg_estadual.push(salRg_estadual.val());
				tipo_pessoa.push(salTipo_pessoa);
				tel.push(salTel.val());
				email.push(salEmail.val());
				id.push(salNome.parents('li').attr('id'));
				number.push(i);				
			}
	}
	
	if(id!='' && nome!=''){
        $('#carregador').show();
		$.post('_php/alterar_cadastros.php',{id:id,nome:nome,nascimento:nascimento,sexo:sexo,cpf_cnpj:cpf_cnpj,rg_estadual:rg_estadual,tipo_pessoa:tipo_pessoa,tel:tel,email:email,qualPg:$('#qualPg').val(),number:number},function(retorno){
            $('#carregador').hide();
			var ret=retorno.split('|'),msg=ret[0],diverro=ret[1];
				if(diverro!="erro"){
					if(diverro!=""){
						$('#erro_'+diverro+' p').html(msg);
						$('#erro_'+diverro).show();						
						$("#"+diverro).focus();
					}else{
						if($('#qual_amb').html()=="1"){
							$("#ul_resc_busc_cliente li."+id[0]+" div.li_nome_busc").html(nome[0]);
							$("#ul_resc_busc_cliente li."+id[0]+" div.li_cpf_busc").html(cpf_cnpj[0]);
							$("#ul_resc_busc_cliente li."+id[0]+" div.li_rg_busc").html(rg_estadual[0]);
							$("#ul_resc_busc_cliente li."+id[0]+" div.li_telefone_busc").html(tel[0]);
						}else{						
							for(i=0; i<id.length; i++){
								$('#ul_linha_clientes li.'+id[i]+' div.alinha_clientes_2 p').html(nome[i]);
								$('#ul_linha_clientes li.'+id[i]+' div.alinha_clientes_3 p').html(tel[i]);
							}
						}					
					$('#dentroOk').html(msg).fadeIn(150);
					setTimeout(function(){$('#dentroOk').fadeOut(200,function(){$('#dentroOk').html("");});},1500);
					if(Qid=="enviaEdita_tudo"){$('#fundo_preto').fadeOut(150,function(){$('#fundo_preto').html('');});}					
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
        
    
    //SELECIONADOR DINAMICO
    $("body").on("click",".s_selecionar",function(){
        $(".s_selecionar").hide();
        $(".s_selecionar_tudo").show();
        $(".s_cancelar_selecao").show();
        $(".d_select_list").show();
        $("#ul_cmd_abertaFechada li, #ul_resc_busc_cliente li").addClass("select_list_ativo");
    });
        
    $("body").on("click",".s_cancelar_selecao",function(){        
        $(".d_select_lista li").hide();
        $(".s_selecionar").show();
        $(".s_selecionar_tudo a").html("Selecionar Tudo");
        $(".s_li_selecionado").removeClass("s_li_selecionado");
        $(".d_select_list").removeClass("d_secionado_list");
        $(".d_select_list").hide();
        $("#ul_cmd_abertaFechada li, #ul_resc_busc_cliente li").removeClass("select_list_ativo");
    });
        
    $("body").on("click",".s_selecionar_tudo",function(){        
        if($(this).children('a').html()=="Selecionar Tudo"){
            $(".d_select_list").addClass("d_secionado_list");
            $(".d_secionado_list span").addClass("s_li_selecionado");            
           $(this).children('a').html("Desmarcar Tudo");
           $(".s_acao_sel").show();
        }else{
            $(".s_li_selecionado").removeClass("s_li_selecionado");
            $(".d_select_list").removeClass("d_secionado_list");
            $(this).children('a').html("Selecionar Tudo");
            $(".s_acao_sel").hide();
        }        
    });
        
    $("body").on("click",".d_select_list",function(){
        
        if($(this).children("span").attr("class")=="s_li_selecionado"){
        $(this).removeClass("d_secionado_list");    
        $(this).children("span").removeClass("s_li_selecionado");
        }else{
        $(this).addClass("d_secionado_list");
        $(this).children("span").addClass("s_li_selecionado");
        }
        
        if($(".s_li_selecionado").length>=1){
           $(".s_acao_sel").show(); 
        }else{
            $(".s_acao_sel").hide();
        }
        
        if($(".liFecha1").length == $(".s_li_selecionado").length){
           $(".s_selecionar_tudo a").html("Desmarcar Tudo");
        }else{
           $(".s_selecionar_tudo a").html("Selecionar Tudo");
        }
        
    });
        
    $("body").on("click",".s_acao_sel a",function(){
        
        if($('#spansim a').attr('id')!="sim"){
		$(this).blur();
		$('#confirm-cima p').html('Tem certeza que deseja deletar ?');
		$('#spansim').addClass('s_acao_sel');
		$('#spansim a').attr('id','sim');
		$('#confirm').show();
		$('#spansim a').focus();
		}else{
        $('#confirm-cima p').html('');
		$('#confirm').hide();
        var qualPg=$('#topo_cmd_abertaFechada').attr('class'),idDel=[],idCmdDel=[],sepId,cmdDel=0;
        for(var i=1;i<=$(".d_select_list").length;i++){
            
            if($("#sDel_"+i).attr('class')=="s_li_selecionado"){
            sepId=$("#sDel_"+i).parent("div").attr("id").split('_');
            idDel.push(sepId[1]);
            if(qualPg!="pg_caixaFecha"){
            cmdDel = (qualPg=="pg_mesaFecha")?$('#del_cmd_'+sepId[1]).children('.li_nome_cmdFecha').children('span').html():$('#del_cmd_'+sepId[1]).children('.li_comanda_cmd').html();
            }
            idCmdDel.push(cmdDel);
            }
        }   
        
        if(idDel!=""){
            $('#carregador').show();
            $.post("_php/alterar_cadastros.php",{qualCadDeletar:qualPg,idDelSelect:idDel,idCmdDel:idCmdDel},function(retorno){                
                var retu=retorno.split('|'),msg=retu[0],erro=retu[1];
                if(erro==""){
                //CARREGA DEPOIS DE DELETAR        
                var qualCad=$("#qualCad"),qualvai=qualCad.attr('class'),gSexo=$("#h_sexo"),gEntrada=$("#h_entrada"),pSexo,pEntrada,bus1="",bus2="";

                if(qualCad.val()!="mesas-fechadas" && qualCad.val()!="vendas-fechadas"){
                    pSexo=gSexo.attr('class');
                    pEntrada=(qualCad.val()=="contas-fechadas" || qualCad.val()=="contas-abertas")?'todas':gEntrada.attr('class');				
                }else{
                    pSexo='';
                    pEntrada='';
                }

                if(qualvai=="data"){
                    var var1=$('#i_data_inicio'),var2=$('#i_data_final');
                    if(var1.val()=="__/__/____" && var2.val()=="__/__/____"){                        
                    bus1=var1.val();
                    bus2=var2.val();
                    }
                }else if(qualvai=="busca"){
                    bus1=$('#i_busca_filtro').val();
                }

                    $.get("_php/carrega-busca.php",{qualCad:qualCad.val(),qualvai:qualvai,var1:bus1,var2:bus2,entrada:pEntrada,sexo:pSexo},function(data){
                    $("#carregador").hide();
                    $('#tudoCarregaCmd').html(data);

                     $('#dentroOk').html(msg).fadeIn(150);
                        setTimeout(function(){$('#dentroOk').fadeOut(150,function(){$('#dentroOk').html("");});},800);

                    var countCmd=$('#trasContBusca').html(),sengu,plura;
                    if(qualCad.val()=="mesas-fechadas"){
                        sengu='mesa';
                        plura='mesas';
                    }else if(qualCad.val()=="vendas-fechadas"){
                        sengu='caixa';
                        plura='caixas';
                    }else if(qualCad.val()=="contas-fechadas" || qualCad.val()=="contas-abertas"){
                        sengu='conta';
                        plura='contas';
                    }else{
                        sengu='comanda';
                        plura='comandas';
                    }
                    if(countCmd>0){
                    if(countCmd>1){$('#p_countCmd').html(countCmd+' '+plura+' encontradas');}else{$('#p_countCmd').html(countCmd+' '+sengu+' encontrada');}
                    }else{
                    $('#p_countCmd').html("");
                    }
                    });
                    //recarrega depois de deleta
                    
                }else{
                $('#carregador').hide();
                $('#alert-cima p').html(msg);
                $('#alert').show();
                $('#spanalert a').focus();
                }
                
            });
            
        $('#spansim a').attr('id','');
		$('#spansim').removeClass('s_acao_sel');
        
        }
            
        }
        
    });
	
});

function rolarBaixo(){
    var hackFim=parseInt($('#rackFimTela').offset().top),
        pagina=parseInt($("#wrap").outerHeight()),
        tela=parseInt($("body,html").outerHeight());

    if(pagina>tela){
        if(hackFim<(pagina-100)){
            $('#rolarBaixo').show();
        }else{            
            $('#rolarBaixo').hide();
        }
    }else{
        $('#rolarBaixo').hide();
    }
}

function deletaCliEsto(idDelete){

	var deleta=[idDelete],qualpg=$('#qualPg').val(),
    NoQuantEle=(parseInt($('#quantElemento').val())<=1)?2:parseInt($('#quantElemento').val()),
	quantElemento = NoQuantEle -1,
	pgs = Math.ceil(quantElemento/12); 
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
	
	
	$('.sel-input li').hide();
    $("#carregador").show();
	$.post("_php/carrega-busca.php",{deletar:deleta,pagina:$('#pagina').val(),qualPg:qualpg},function(retorno){
        var ret=retorno.split('|'),msg=ret[0],erro=ret[1];
        $("#carregador").hide();
        if(erro=="error"){
            $('#alert-cima p').html(msg);
			$('#alert').show();
			$('#spanalert a').focus();
            $('.sel-input li').show();
        }else{
            $('.sel-input').html(retorno);
            $('#todos-check').prop("checked",false);		
            if($('#spansim a').attr('class')=="deletarEstoque"){
            $('#spansim').removeClass('sim');
            $('#spansim a').attr('id','').removeClass('deletarEstoque');
            }
        }
        
	});	
	
}

function paginaEstoque(pg,qualPg){		
			$('#pagina').val(pg);
			if($('#select_bt').attr('class')=="select_fecha_bt"){				
			$('#select_bt').removeClass('select_fecha_bt').addClass('select_abre_bt');
			$('#select_produto ul').hide();
			}			
			if(pg!=$('#select_pg').html()){
				$('#select_pg').html(pg);
				var menos=parseInt(pg)-1, mais=parseInt(pg)+1,pgs = Math.ceil(parseInt($('#quantElemento').val())/12);
				if(menos==0){$('#d_pri').hide();}else{$('#d_pri').show();}
				if(menos<=1){$('#d_ante').hide();}else{$('#d_ante').show().children('a').attr('href',getUrl()+qualPg+'.php?pg='+menos).attr('class',menos);
				}
				if(mais>=pgs){$('#d_pro').hide();}else{$('#d_pro').show().children('a').attr('href',getUrl()+qualPg+'.php?pg='+mais).attr('class',mais);
				}
				if(mais>pgs){$('#d_ult').hide();}else{$('#d_ult').show().children('a').attr('href',getUrl()+qualPg+'.php?pg='+pgs).attr('class',pgs);
				}
				
				$('#ul_linha_'+qualPg).html('<li id="carreBuscaEstoque"></li>');				
				$.post("_php/carrega-busca.php",{pagEstoque:true,pagina:pg,qualPg:qualPg},function(ret){
					$('#ul_linha_'+qualPg).html(ret);
					$('#todos-check').prop("checked",false);
				});			
			}		
		}
		
		function buscaAtualizaEstoque(qualPg){
		clearTimeout(pararBusca);	
        var elemento1,elemento2,elemento3,elemento4,elemento5;
		if(qualPg=='estoque'){
		elemento1 = $('#filtra_estoque_cod').val();
        elemento2 = $('#filtra_estoque_nome').val();
		elemento3 = $('#filtra_estoque_cat').val();
        elemento4 = $('#filtra_estoque_quant').val();
		elemento5 = $('#filtra_estoque_val').val().replace(/[.]/g,"").replace(",",".");		
		}else{		
		elemento1 = $('#filtra_clientes_cod').val();
        elemento2 = $('#filtra_clientes_nome').val();
		elemento3 = $('#filtra_clientes_contato').val();
        elemento4 = $('#filtra_clientes_comanda').val();
		elemento5="";
		}
		var termo=elemento2,termo2=elemento3,branco=0,branco2=0,h=0,hh,jj,par=false;		
		for(var j=0;j<termo.length;j++){
			h+=1;
			if(par==false){
				if(termo2.length<h){hh = termo2.length;	jj = (termo2.length-1);	}else{hh = h; jj = j;}
				if(termo.substring(j,h)==" "){
				branco+=1;
				if(termo2.substring(jj,hh)==" " && termo2.length>=h){
				branco2+=1;
				}
				
				}else{
				par = true;
				}
			}
		}
		
		var nome = termo.substring(branco),cat = termo2.substring(branco2);		
		if(nome.length>0 || elemento1.length>0 || elemento4.length>0 || (cat.length>0 && cat!="(__) _____-____" && cat!="(__) ____-____") || (elemento5.length>0 && elemento5!="0.00")){$('#pgTudo').hide();
		}else{$('#pgTudo').show();}
				
		$('#ul_linha_'+qualPg).html('<li id="carreBuscaEstoque"></li>');
		pararBusca=setTimeout(function(){
		$.post("_php/carrega-busca.php",{codigo:elemento1,nome:nome,categoria:cat,quant:elemento4,valor:elemento5,pagina:$('#pagina').val(),qualPg:qualPg},function(ret){
			$('#ul_linha_'+qualPg).html(ret);
		});
		},200);
	}