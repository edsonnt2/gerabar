<?php
	
function upload($imagem, $nome, $pasta, $larguraP, $altura1=''){
	
	if($imagem['type'] == 'image/pjpeg' || $imagem['type'] == 'image/jpeg')
	{
	$img = imagecreatefromjpeg($imagem['tmp_name']);
	}
elseif($imagem['type'] == 'image/x-png' || $imagem['type'] == 'image/png')
	{
	$img = imagecreatefrompng($imagem['tmp_name']);
	imagealphablending($img, false);
	imagesavealpha($img, true);
	}
elseif($imagem['type'] == 'image/gif')
	{
	$img = imagecreatefromgif($imagem['tmp_name']);
	}
	
	$x = imagesx($img);
	$y = imagesy($img);
	
	if($altura1==''){

	$largura = ($x>$larguraP) ? $larguraP : $x;
	$altura = ($largura*$y) / $x;
	
	if($altura>$larguraP){
		$altura = $larguraP;
		$largura = ($altura*$x) / $y;
	}
	
	}else{
		
		$altura = $altura1;
		$largura = $larguraP;
	
	}
	
	
	if(function_exists('imagecopyresampled') && $imagem['type'] !='image/gif'){
		$nova = imagecreatetruecolor($largura, $altura);
		
	}else{
		$nova = imagecreate($largura, $altura);
	}

	// additional processing for png / gif transparencies (credit to Dirk Bohl)
	if($imagem['type'] == 'image/x-png' || $imagem['type'] == 'image/png')
		{
		imagealphablending($nova, false);
		imagesavealpha($nova, true);
		}
	elseif($imagem['type'] == 'image/gif')
		{
		$originaltransparentcolor = imagecolortransparent( $img );
		if($originaltransparentcolor >= 0 && $originaltransparentcolor < imagecolorstotal( $img ))
			{
			$transparentcolor = imagecolorsforindex( $img, $originaltransparentcolor );
			$newtransparentcolor = imagecolorallocate($nova,$transparentcolor['red'],$transparentcolor['green'],$transparentcolor['blue']);
			imagefill( $nova, 0, 0, $newtransparentcolor );
			imagecolortransparent( $nova, $newtransparentcolor );
			}
		}

	imagecopyresampled($nova, $img, 0, 0, 0, 0, $largura, $altura, $x, $y);
	
	$criaPasta = explode('/',$pasta);
	$novaPasta = '';	
	foreach($criaPasta as $AsCriaPasta){
		$novaPasta.=$AsCriaPasta.'/';
		if(!file_exists($novaPasta) AND $novaPasta<>"../"){ 
		mkdir($novaPasta,0755);
		}
	}
	
	if($imagem['type'] == 'image/pjpeg' || $imagem['type'] == 'image/jpeg'){
		imagejpeg($nova, $pasta.'/'.$nome);
	}elseif($imagem['type'] == 'image/x-png' || $imagem['type'] == 'image/png'){
		imagesavealpha($nova, true);
		imagepng($nova, $pasta.'/'.$nome);
	}elseif($imagem['type'] == 'image/gif'){
		imagesavealpha($nova, true);
		imagegif($nova, $pasta.'/'.$nome);
	}

    imagedestroy($img);
	imagedestroy($nova);
	
	return $nome;
}