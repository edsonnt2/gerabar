<?php
	class Login extends DB{
	
		private $tabela1="usuarios";
		private $tabela2="ambientes";
		private $tabela3="operadores";
		private $prefix="Gerabar_";
		private $cookie=true;
		public $erro="";
		
		private function crip($senha){
			return sha1($senha);
		}
        
        private function plano($usuEmpresa,$tabela){
            $campo=($tabela=="usuarios")?"id":"id_empresa";
            $plano=self::getConn()->prepare("SELECT `id` FROM usuarios WHERE ".$campo."=? AND plano_ativo=? LIMIT 1");
            $plano->execute(array($usuEmpresa,1));
            $_SESSION[$this->prefix."plano"]=($plano->rowCount()>=1)?1:0;
        }
        
		private function validar($usuario,$senha){
			$senha=$this->crip($senha);
			try{
				$validar=self::getConn()->prepare("SELECT `id` FROM `".$this->tabela1."` WHERE (email=? OR nome_usuario=?) AND senha=? LIMIT 1");
				$validar->execute(array($usuario,$usuario,$senha));
				if($validar->rowCount()==1){
					$asValidar = $validar->fetch(PDO::FETCH_NUM);
					$_SESSION[$this->prefix."uid"]= $asValidar[0];
					$_SESSION[$this->prefix."table"]=$this->tabela1;                    
                    $this->plano($asValidar[0],$this->tabela1);                    
					return true;
				}else{
					$validar2=self::getConn()->prepare("SELECT `id`,id_empresa FROM `".$this->tabela2."` WHERE acesso_amb=? AND senha_amb=? LIMIT 1");
					$validar2->execute(array($usuario,$senha));
					if($validar2->rowCount()==1){
						$asValidar2 = $validar2->fetch(PDO::FETCH_NUM);
						$_SESSION[$this->prefix."uid"]= $asValidar2[0];
						$_SESSION[$this->prefix."table"]=$this->tabela2;
                        $this->plano($asValidar2[1],$this->tabela2);
						return true;
					}else{
						return false;
					}
				}
			}catch(PDOException $e){
				$this->erro=$e->getMessage();
				return false;
			}
		}
        
		function logar($usuario,$senha,$lembrar=false){
				if(!isset($_SESSION)){
				session_start();
				}		
			if($this->validar($usuario,$senha)){
				$_SESSION[$this->prefix."usuario"] = $usuario;
				$_SESSION[$this->prefix."logado"] = true;
                
				if($this->cookie){
			       $valor = join("#",array($usuario,$_SERVER["REMOTE_ADDR"],$_SERVER["HTTP_USER_AGENT"]));
				   $valor = sha1($valor);
				   setcookie($this->prefix."token",$valor,0,"/");
			  	}
				
				if($lembrar==true){
			    	$this->lembrarDados($usuario,$senha);
					return true;
			  	}else{
					return true;
				}
			}else{
				$this->erro="Usuário inválido !";
				return false;
			}		
		}
        
        function logado($cokie=true){
			if(!isset($_SESSION)){
			session_start();
			}
			
			if(!isset($_SESSION[$this->prefix."logado"])){
				if($cokie==true){
					$this->dadosLembrados();
                    $this->dadosLembradosOperador();
				}else{
					$this->erro = "Você não está logado !";
					return false;
					exit();
				}
			}
			
			if($this->cookie==true){			
				if(!isset($_COOKIE[$this->prefix."token"])){
					$this->erro="Você não está logado !";
					return false;
				}else{
					$testa_valor = join("#",array($_SESSION[$this->prefix."usuario"],$_SERVER["REMOTE_ADDR"],$_SERVER["HTTP_USER_AGENT"]));
					$testa_valor = sha1($testa_valor);
					if($_COOKIE[$this->prefix."token"]<>$testa_valor){
						$this->erro="Você não está logado !";
						return false;
					}else{
						return true;
					}
				}
			}else{
				$this->erro="Ocorreu um erro inesperado !";
				return false;
			}
		
		}
		
		function sair($cokie=true){
			if(!isset($_SESSION)){
			session_start();
			}			
			unset($_SESSION[$this->prefix."usuario"]);
			unset($_SESSION[$this->prefix."uid"]);
			unset($_SESSION[$this->prefix."table"]);
			unset($_SESSION[$this->prefix."Ocodigo"]);
            unset($_SESSION[$this->prefix."plano"]);
            
            if(isset($_SESSION['salvar_plano'])){
            unset($_SESSION['salvar_plano']);
            }
            
			$_SESSION[$this->prefix."logado"]=false;
			
			if($this->cookie==true && isset($_COOKIE[$this->prefix."token"])){
				setcookie($this->prefix."token",false,(time()-3600),"/");
				unset($_COOKIE[$this->prefix."token"]);
			}
			if($cokie==true){
		    $this->limparLembrados();
            $this->limparLembradosOperador();
			}			
			return $this->logado(false);		
		}
		
		function getDados($uid,$table){
			if($this->logado()){
				 $dados=self::getConn()->prepare("SELECT * FROM `".$table."` WHERE `id`=? LIMIT 1");
				 $dados->execute(array($uid));
				 return $dados->fetch(PDO::FETCH_ASSOC);
			}
		}
		
		private function limparLembrados(){
			if(isset($_COOKIE[$this->prefix."login_user"])){
				setcookie($this->prefix."login_user",false,(time()-3600),"/");
				unset($_COOKIE[$this->prefix."login_user"]);
			}
			 
			if(isset($_COOKIE[$this->prefix."login_pass"])){
				setcookie($this->prefix."login_pass",false,(time()-3600),"/");
				unset($_COOKIE[$this->prefix."login_pass"]);
			}
		}
		
		private function dadosLembrados(){
			if(isset($_COOKIE[$this->prefix."login_user"]) && isset($_COOKIE[$this->prefix."login_pass"])){
				$usuario=base64_decode(substr($_COOKIE[$this->prefix."login_user"],1));
				$senha=base64_decode(substr($_COOKIE[$this->prefix."login_pass"],1));
				return $this->logar($usuario,$senha,true);
			}else{
				return false;
			}
		}
		
		private function lembrarDados($usuario,$senha){
			$tempo=strtotime('+7 day',time());			  
			$usuario=rand(1,9).base64_encode($usuario);
			$senha=rand(1,9).base64_encode($senha);			  
			setcookie($this->prefix."login_user",$usuario,$tempo,"/");
			setcookie($this->prefix."login_pass",$senha,$tempo,"/");
		}
        
        //LOGIN OPERADOR
        
        private function validarOperador($codigo,$senha,$idempresa){
			$senha=$this->crip($senha);
			try{
				$valida=self::getConn()->prepare("SELECT `id` FROM `".$this->tabela3."` WHERE codigo=? AND senha=? AND id_empresa=? LIMIT 1");
				$valida->execute(array($codigo,$senha,$idempresa));
				if($valida->rowCount()==1){
					$_SESSION[$this->prefix."Ocodigo"]= $codigo;
					return true;
				}else{
					return false;				
				}
			}catch(PDOException $e){
				$this->erro=$e->getMessage();
				return false;
			}
		}
		
		function logarOperador($codigo,$senha,$idempresa){
				if(!isset($_SESSION)){
				session_start();
				}
			if($this->validarOperador($codigo,$senha,$idempresa)){
			    $this->lembrarOperador($codigo,$senha,$idempresa);
				return true;
			}else{
				$this->erro="Operador inválido !";
				return false;
			}		
		}
        
        private function lembrarOperador($operador,$senha,$idEmpresa){
			$tempo=strtotime('+7 day',time());			  
			$usuario=rand(1,9).base64_encode($operador);
			$senha=rand(1,9).base64_encode($senha);		
            $idEmpresa=rand(1,9).base64_encode($idEmpresa);
			setcookie($this->prefix."login_user_operador",$usuario,$tempo,"/");
			setcookie($this->prefix."login_pass_operador",$senha,$tempo,"/");
			setcookie($this->prefix."login_id_empresa",$idEmpresa,$tempo,"/");
		}
        
        private function limparLembradosOperador(){
			if(isset($_COOKIE[$this->prefix."login_user_operador"])){
				setcookie($this->prefix."login_user_operador",false,(time()-3600),"/");
				unset($_COOKIE[$this->prefix."login_user_operador"]);
			}			 
			if(isset($_COOKIE[$this->prefix."login_pass_operador"])){
				setcookie($this->prefix."login_pass_operador",false,(time()-3600),"/");
				unset($_COOKIE[$this->prefix."login_pass_operador"]);
			}
            if(isset($_COOKIE[$this->prefix."login_id_empresa"])){
				setcookie($this->prefix."login_id_empresa",false,(time()-3600),"/");
				unset($_COOKIE[$this->prefix."login_id_empresa"]);
			}
		}
		
		private function dadosLembradosOperador(){
			if(isset($_COOKIE[$this->prefix."login_user_operador"]) && isset($_COOKIE[$this->prefix."login_pass_operador"]) && isset($_COOKIE[$this->prefix."login_id_empresa"])){
				$codigo=base64_decode(substr($_COOKIE[$this->prefix."login_user_operador"],1));
				$senha=base64_decode(substr($_COOKIE[$this->prefix."login_pass_operador"],1));
				$idEmpresa=base64_decode(substr($_COOKIE[$this->prefix."login_id_empresa"],1));
				return $this->logarOperador($codigo,$senha,$idEmpresa);
			}else{
				return false;
			}
		}
		
	}