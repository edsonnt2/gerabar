<?php
	
	class Validar{		
	static function validar_cpf($cpf,$dv){
	if(strlen($cpf)<9){
		return false;
		}
	if($cpf=='000000000' OR $cpf=='111111111' OR $cpf=='222222222' OR $cpf=='333333333' OR $cpf=='444444444' OR $cpf=='555555555' OR $cpf=='666666666' OR $cpf=='777777777' OR $cpf=='888888888' OR $cpf=='999999999'){
		return false;
		}
	$num1 = 10;
	for($j=0;$j<strlen($cpf);$j++){
		if(substr($cpf,$j,1)>=0 AND substr($cpf,$j,1)<=9){
			$num_cpf = substr($cpf,$j,1);
			}else{
			return false;
			}
			
			$mult[] = $num_cpf * $num1;
			$num1-=1;
		}		
	 $total = $mult[0]+$mult[1]+$mult[2]+$mult[3]+$mult[4]+$mult[5]+$mult[6]+$mult[7]+$mult[8];
	 $total1 = $total/11;
	 $totals = (int)$total1;
	 $mult2 = $totals*11;
	 $sub1 = $total - $mult2;
	 if($sub1==0 OR $sub1==1){
		$pdigito = 0;
		}else{
		$pdigito = 11-$sub1;		
		}
		$num2 = 11;
		for($d=0;$d<strlen($cpf);$d++){
			$numu_cpf = substr($cpf,$d,1);
			$multi[] = $numu_cpf * $num2;
			$num2-=1;
			}
		
		$ultda = $pdigito*2;
		$result = $multi[0]+$multi[1]+$multi[2]+$multi[3]+$multi[4]+$multi[5]+$multi[6]+$multi[7]+$multi[8]+$ultda;
		$result1 = $result/11;
		$results = (int)$result1;
		$result2 = $results*11;
		$sub2 = $result-$result2;
		if($sub2==0 OR $sub2==1){
		$sdigito = 0;
		}else{
		$sdigito = 11-$sub2;
		}
		$resultFinal = $pdigito.$sdigito;
		if($dv==$resultFinal){
			return true;
			}else{
			return false;
			}		 
	}
	
	
			static function validar_cnpj($cnpj) { 
			if(strlen($cnpj) <> 18){
			 return false; 
			}
			if($cnpj=='00.000.000/0000-00' OR $cnpj=='11.111.111/1111-11' OR $cnpj=='22.222.222/2222-22' OR $cnpj=='33.333.333/3333-33' OR $cnpj=='44.444.444/4444-44' OR $cnpj=='55.555.555/5555-55' OR $cnpj=='66.666.666/6666-66' OR $cnpj=='77.777.777/7777-77' OR $cnpj=='88.888.888/8888-88' OR $cnpj=='99.999.999/9999-99'){
			return false;
			}
			
			$soma1 = ($cnpj[0] * 5) + 
			($cnpj[1] * 4) + 
			($cnpj[3] * 3) + 
			($cnpj[4] * 2) + 
			($cnpj[5] * 9) + 
			($cnpj[7] * 8) + 
			($cnpj[8] * 7) + 
			($cnpj[9] * 6) + 
			($cnpj[11] * 5) + 
			($cnpj[12] * 4) + 
			($cnpj[13] * 3) + 
			($cnpj[14] * 2);
			
			$resto = $soma1 % 11;
			
			$digito1 = $resto < 2 ? 0 : 11 - $resto;
			
			$soma2 = ($cnpj[0] * 6) +
			($cnpj[1] * 5) +
			($cnpj[3] * 4) + 
			($cnpj[4] * 3) + 
			($cnpj[5] * 2) + 
			($cnpj[7] * 9) + 
			($cnpj[8] * 8) + 
			($cnpj[9] * 7) + 
			($cnpj[11] * 6) + 
			($cnpj[12] * 5) + 
			($cnpj[13] * 4) + 
			($cnpj[14] * 3) + 
			($cnpj[16] * 2);
			
			$resto = $soma2 % 11;
			
			$digito2 = $resto < 2 ? 0 : 11 - $resto;
			
			if($cnpj[16] == $digito1 AND $cnpj[17] == $digito2){
			return true;
			}else{
			return false;
			}
		}
	
	}
	