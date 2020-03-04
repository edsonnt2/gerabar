<?php include('_include/header_inicio.php'); ?>
<div class="cAlign">
<div id="form-H" style="float:left;">
<h1 style="margin-left:20px;">Contate-nos</h1>
</div>
</div><!--.cAlign-->
</div><!--#topo-->

<div class="cAlign">
    
<div id="tudo_contato">

	<h1>Enviar uma solicitação</h1>
    
    <h2>Se estiver com dúvidas e precisar de ajuda, tiver alguma sugestão ou se até mesmo desejar fazer parte de nossa equipe, por favor, nos envie uma solicitação.</h2>
    
    
    <form method="post" action="" enctype="multipart/form-data" id="subFormContato">
    
  	
      <div class="form-field">
      <label for="i_email_cont">Endereço de email:</label>
      <input type="text" id="i_email_cont" name="email_cont" />
      <div class="d_aviso_erro" id="erro_i_email_cont"><div class="d_ponta-erro"></div><p></p></div><!--d_aviso_erro-->
      </div>

  	  <div class="form-field">
      <label for="i_assunto_cont">Assunto:</label>
      <input type="text" id="i_assunto_cont" name="assunto_cont" />
      <div class="d_aviso_erro" id="erro_i_assunto_cont"><div class="d_ponta-erro"></div><p></p></div><!--d_aviso_erro-->
      </div>
      
  
      <div class="form-field">
      <label for="i_descricao_cont">Descrição:</label>
      <textarea id="i_descricao_cont" name="descricao_cont"></textarea>
      <div class="d_aviso_erro" id="erro_i_descricao_cont"><div class="d_ponta-erro"></div><p></p></div><!--d_aviso_erro-->
      <p id="request_description_hint">Insira os detalhes de sua solicitação. Um membro de nossa equipe de suporte responderá assim que possível.</p>
      </div>
      
      
      <div class="form-field">
      <label id="label_ane1">Anexo:</label>
      <label for="i_anexo_cont" id="label_ane2">Adicione o arquivo</label>
	  <input type="file" name="anexo_cont" id="i_anexo_cont" />
      <p id="nome_anexo"><span id="s_nome_anexo"></span> <span id="x_span_anexo">x</span></p>
      <div class="d_aviso_erro" id="erro_label_ane2" style=" margin-top:136px;"><div class="d_ponta-erro"></div><p></p></div><!--d_aviso_erro-->
      </div>
      
      
      <div class="form-field">
      <button type="submit" id="b_enviar_cont">Enviar</button>
      </div>

</form>

</div><!--tudo_contato-->
        

</div><!--.cAling-->
<?php include('_include/footer_inicio.php'); ?>