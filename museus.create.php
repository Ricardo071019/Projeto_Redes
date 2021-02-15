<?php
session_start();
if(!isset($_SESSION['login'])){
	$_SESSION['login']="incorreto";
}
if($_SESSION['login']=="correto" && isset($_SESSION['login'])){
	if($_SERVER['REQUEST_METHOD']=="POST"){
	$nome_museu="";
	$Visitantes="";


	if(isset($_POST['nome'])){
		$nome_museu = $_POST['nome'];
	}
	else{
		echo '<scipt>alert("É obrigatorio o preenchimento do nome.");</script>';
	}
	if(isset($_POST['Visitantes'])){
		$Visitantes = $_POST['Visitantes'];
	}
		
	$con = new mysqli("localhost","root","","musues");
	if($con->connect_errno!=0){
		echo "Ocorreu um erro no acesso á base de dados.<br>".$con->connect_error;
		exit;
	}
	else {
		$sql = 'insert into museus(nome_museu,Visitantes) values (?,?)';
		$stm = $con->prepare ( $sql);
		if($stm!=false){
			$stm->bind_param('ss',$nome_museu,$Visitantes);
			$stm->execute();
			$stm->close();

			echo '<script>alert("Museu adicionado com sucesso");</script>';
			echo "Aguarde um momento.A reencaminhar página";
			header("refresh:5;url=index.museus.php");

		}
		else{
			echo ($con->error);
			echo  "Aguarde um momento.A reencaminhar página";
			header("refresh:5;url=index.museus.php");
		}

	}//end if -if($con->connect_errno!=0)

}//if($_SERVER['REQUEST_METHOD']=="POST")
else{//else if($SERVER['REQUEST_METHOD']=="POST")
	?>
	<!DOCTYPE html>
	<html>
	<head>
		<meta charset="ISO-8859-1">
		<title>Adicionar Museu</title>
	</head>
	<body>
		<h1>Adicionar Museu</h1>
		<form action="museus.create.php" method="post">
			<label>Nome</label><input type="text" name="nome_museu" required><br>
			<label>Visitantes</label><input type="text" name="Visitantes"><br>
			<input type="submit" name="enviar"><br>

		</form>
	
	</body>
	</html>
	<?php
}//end if -if($SERVER['REQUEST_METHOD']=="POST")
?>



<?php
}
else{
	echo 'Para entrar nesta pagina necessita de efetuar<a href="login.php">login</a>';
	header('refresh:2;url=login.php');
	
}
?>