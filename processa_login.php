<?php

session_start();
if($_SERVER['REQUEST_METHOD']=='POST'){
	if(isset($_POST['nome'])&& isset($_POST['palavra_pass'])){
		$utilizador = $_POST['nome'];
		$password = $_POST['palavra_pass'];

		$con = new mysqli("localhost","root","","museus");

		if($con->connect_errno!=0){
			echo "Ocorreu um erro no acesso á base de dados.<br>".$con->connect_error;
			exit;

		}
		else{
			$sql = "Select * from utilizadores where nome=? and palavra_pass=?";
			$stm = $con->prepare($sql);
			if($stm!=false){
				$stm->bind_param("ss",$utilizador,$password);
				$stm->execute();
				$res = $stm->get_result();
				if($res->num_rows==1){
					echo "login com sucesso";
					$_SESSION['login']="correto";
				}
				else{
					echo "login sem sucesso";
					$_SESSION['login']="incorreto";
				}
				header("refresh:5; url=index.php");
			}
			else{
				echo "Ocorreu um erro no acesso á base de dados.<br>STM:".$con->connect_error;
				exit;
			}

		}
	}
}
