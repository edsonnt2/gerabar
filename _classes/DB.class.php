<?php
class DB{	
	private static $conn;
 
	static function getConn(){
		if(is_null(self::$conn) || empty(self::$conn)){
			try{
			$conexao = "mysql:host=localhost;dbname=geraba01_gerabar";
			self::$conn = new PDO($conexao,"root","");
			self::$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
			self::$conn->exec("set names utf8");
			return self::$conn;
			}catch(PDOException $erro){
				echo 'ERROR: ' . $erro->getMessage();
				exit();
			}
		}else{
			return self::$conn;			
		}
	}	
}